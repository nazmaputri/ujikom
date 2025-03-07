<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\Keranjang;
use App\Models\Purchase;
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
        $keranjangItems = Keranjang::where('user_id', $user->id)->get();
    
        if ($keranjangItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }
    
        // Hitung total harga semua kursus dalam keranjang
        $totalAmount = 0;
        $itemDetails = [];
    
        foreach ($keranjangItems as $item) {
            $totalAmount += $item->course->price; // Pastikan kolom price ada di tabel courses
    
            $itemDetails[] = [
                'id' => 'COURSE-' . $item->course_id,
                'price' => $item->course->price,
                'quantity' => 1,
                'name' => $item->course->title,
            ];
        }
    
        // Buat Order ID unik yang akan digunakan sebagai transaction_id
        $orderId = 'ORDER-' . time();
    
        // Konfigurasi Midtrans
        Config::$serverKey   = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey   = env('MIDTRANS_CLIENT_KEY'); // Pastikan clientKey diambil dari .env
        Config::$isProduction = false;
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    
        // Data transaksi Midtrans
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
            // Ambil Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($transactionData);
    
            // Simpan transaksi ke tabel `payments` tanpa course_id
            $payment = Payment::create([
                'user_id'            => $user->id,
                'transaction_id'     => $orderId,
                'payment_type'       => 'midtrans',
                'transaction_status' => 'pending',
                'amount'             => $totalAmount,
                'payment_url'        => null,
            ]);
    
            // Simpan setiap item keranjang ke tabel `purchases` dengan transaction_id yang sama
            foreach ($keranjangItems as $item) {
                Purchase::create([
                    'user_id'        => $user->id,
                    'course_id'      => $item->course_id,
                    'transaction_id' => $orderId, // Menghubungkan pembelian ke Payment via transaction_id
                    'status'         => 'pending'
                ]);
            }
    
            // Opsional: Hapus data keranjang setelah checkout berhasil
            Keranjang::where('user_id', $user->id)->delete();
    
            return response()->json([
                'snapToken' => $snapToken,
                'payment'   => $payment
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

        // Perbarui status pembayaran
        $payment->transaction_status = $transactionStatus;
        $payment->save();

        return response()->json([
            'message' => 'Status pembayaran berhasil diperbarui.',
            'payment' => $payment,
        ]);
    }
}

