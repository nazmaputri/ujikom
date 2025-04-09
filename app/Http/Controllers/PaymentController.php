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
    
        // Ambil semua item di keranjang berdasarkan user_id
        $keranjangItems = Keranjang::where('user_id', $user->id)->with('course')->get();
    
        if ($keranjangItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }
    
        // Cek apakah ada kode kupon yang dikirim dan valid
        $couponCode = $request->input('coupon_code');
        $discount = null;
        if ($couponCode) {
            $discount = Discount::where('coupon_code', $couponCode)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();
        }
    
        $totalAmount = 0;
        $itemDetails = [];
    
        // Iterasi tiap item di keranjang untuk menghitung harga diskon (jika ada)
        foreach ($keranjangItems as $item) {
            $originalPrice = $item->course->price;
            $price = $originalPrice;
    
            // Jika ada diskon dan berlaku untuk item ini
            if ($discount) {
                if ($discount->apply_to_all || $discount->courses->contains($item->course->id)) {
                    $price = $originalPrice - ($originalPrice * $discount->discount_percentage / 100);
                }
            }
    
            $totalAmount += $price;
    
            $itemDetails[] = [
                'id'       => 'COURSE-' . $item->course_id,
                'price'    => $price,
                'quantity' => 1,
                'name'     => $item->course->title,
            ];
        }
    
        // Buat Order ID unik yang akan digunakan sebagai transaction_id
        $orderId = 'ORDER-' . time();
    
        // Konfigurasi Midtrans
        Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey    = env('MIDTRANS_CLIENT_KEY'); // Pastikan clientKey diambil dari .env
        Config::$isProduction = false;
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    
        // Data transaksi Midtrans dengan harga total yang sudah didiskon (jika ada)
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
            // Ambil Snap Token dari Midtrans dengan data transaksi yang sudah diperbarui
            $snapToken = Snap::getSnapToken($transactionData);
    
            // Simpan transaksi ke tabel `payments`
            $payment = Payment::create([
                'user_id'            => $user->id,
                'transaction_id'     => $orderId,
                'payment_type'       => 'midtrans',
                'transaction_status' => 'pending', // status awal pending
                'amount'             => $totalAmount,
                'payment_url'        => null,
            ]);
    
            // Simpan setiap item keranjang ke tabel `purchases` dengan transaction_id yang sama
            foreach ($keranjangItems as $item) {
                Purchase::create([
                    'user_id'        => $user->id,
                    'course_id'      => $item->course_id,
                    'transaction_id' => $orderId,
                    'status'         => 'pending'
                ]);
            }
    
            // Data keranjang tidak dihapus di sini karena status awalnya pending.
            // Penghapusan data keranjang akan dilakukan pada notifikasi Midtrans ketika status transaksi sudah success.
    
            return response()->json([
                'snapToken' => $snapToken,
                'payment'   => $payment,
                'order_id'  => $orderId,
            ]);
        } catch (\Exception $e) {
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
    
        // Jika status transaksi sukses, perbarui status pembelian dan hapus keranjang
        if ($transactionStatus === 'success') {
            Purchase::where('transaction_id', $orderId)
                ->update(['status' => 'success']);
    
            Keranjang::where('user_id', $payment->user_id)->delete();
        }
    
        // Tidak perlu redirect di sini, karena ini dipanggil dari backend (webhook/callback)
        return response()->json([
            'message' => 'Status pembayaran berhasil diperbarui.',
        ]);
    }
    
    
}

