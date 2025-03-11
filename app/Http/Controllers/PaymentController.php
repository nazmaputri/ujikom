<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\Keranjang;
use App\Models\Purchase;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Log;
 
class PaymentController extends Controller
{
    
    public function createPayment(Request $request)
    {
        $user = Auth::user(); // Ambil user yang sedang login
        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 401);
        }
    
        // Ambil semua item di keranjang berdasarkan user_id beserta relasi course
        $keranjangItems = Keranjang::where('user_id', $user->id)->with('course')->get();
    
        if ($keranjangItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }
    
        // Hitung total harga sebelum diskon dan susun item detail
        $totalAmount = 0;
        $itemDetails = [];
        foreach ($keranjangItems as $item) {
            $totalAmount += $item->course->price;
            $itemDetails[] = [
                'id'       => 'COURSE-' . $item->course_id,
                'price'    => $item->course->price,
                'quantity' => 1,
                'name'     => $item->course->title,
            ];
        }
    
        // Cek apakah ada kode kupon yang dikirim
        $couponCode = $request->input('coupon_code');
        if ($couponCode) {
            // Cari diskon aktif berdasarkan kode kupon
            $discount = Discount::where('coupon_code', $couponCode)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();
    
            if ($discount) {
                // Hitung diskon sesuai dengan properti apply_to_all
                if ($discount->apply_to_all) {
                    $discountAmount = $totalAmount * ($discount->discount_percentage / 100);
                } else {
                    // Diskon hanya berlaku untuk kursus tertentu
                    $discountAmount = 0;
                    foreach ($keranjangItems as $item) {
                        if ($discount->courses->contains($item->course->id)) {
                            $discountAmount += $item->course->price * ($discount->discount_percentage / 100);
                        }
                    }
                }
                $totalAmount = $totalAmount - $discountAmount;
    
                // Tambahkan item detail untuk diskon (dengan nilai negatif)
                $itemDetails[] = [
                    'id'       => 'DISCOUNT-' . $couponCode,
                    'price'    => -$discountAmount,
                    'quantity' => 1,
                    'name'     => 'Diskon Kupon ' . $couponCode,
                ];
            }
        }
    
        // Buat Order ID unik yang akan digunakan sebagai transaction_id
        $orderId = 'ORDER-' . time();
    
        // Konfigurasi Midtrans
        Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey    = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false;
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    
        // Data transaksi Midtrans dengan harga total (setelah diskon jika ada)
        $transactionData = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalAmount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $user->phone ?? '08123456789',
            ],
        ];
    
        try {
            DB::beginTransaction();
    
            // Ambil Snap Token dari Midtrans dengan data transaksi di atas
            $snapToken = Snap::getSnapToken($transactionData);
    
            // Simpan transaksi ke tabel payments
            $payment = Payment::create([
                'user_id'            => $user->id,
                'transaction_id'     => $orderId,
                'payment_type'       => 'midtrans',
                'transaction_status' => 'pending',
                'amount'             => $totalAmount,
                'payment_url'        => null,
            ]);
    
            // Simpan setiap item keranjang ke tabel purchases (menggunakan transaction_id yang sama)
            foreach ($keranjangItems as $item) {
                Purchase::create([
                    'user_id'        => $user->id,
                    'course_id'      => $item->course_id,
                    'transaction_id' => $orderId,
                    'status'         => 'pending'
                ]);
            }
    
            // Opsional: Hapus data keranjang setelah checkout berhasil
            Keranjang::where('user_id', $user->id)->delete();
    
            DB::commit();
    
            return response()->json([
                'snapToken' => $snapToken,
                'payment'   => $payment,
                'order_id'  => $orderId,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error'   => 'Gagal mendapatkan token pembayaran',
                'message' => $e->getMessage()
            ], 500);
        }
    }    
    
    public function updatePaymentStatus(Request $request)
    {
        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');
    
        // Cari transaksi berdasarkan order_id
        $payment = Payment::where('transaction_id', $orderId)->first();
    
        if (!$payment) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }
    
        // Perbarui status pembayaran di tabel payments
        $payment->transaction_status = $transactionStatus;
        $payment->save();
    
        // Jika status transaksi sukses, perbarui status pembelian di tabel purchases
        if ($transactionStatus === 'success') {
            Purchase::where('transaction_id', $orderId)
                ->update(['status' => 'success']);
        }
    
        return response()->json([
            'message' => 'Status pembayaran berhasil diperbarui.',
            'payment' => $payment,
        ]);
    }
    
}

