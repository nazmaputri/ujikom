<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Discount;
use App\Models\Course;
use App\Models\Purchase;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // Menampilkan halaman keranjang
    public function index(Request $request)
    {
        // Ambil data keranjang user
        $carts = Keranjang::where('user_id', Auth::id())->with('course')->get();
    
        // Hitung total harga sebelum diskon
        $totalPrice = $carts->sum(fn($cart) => $cart->course->price);
    
        // Ambil diskon yang berlaku untuk semua kursus atau kursus tertentu
        $activeDiscount = Discount::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    
        $totalPriceAfterDiscount = $totalPrice;
        $couponCode = $request->query('coupon'); // Ambil kode kupon dari query string
    
        if ($couponCode) {
            $discount = Discount::where('coupon_code', $couponCode)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();
    
            if ($discount) {
                if ($discount->apply_to_all) {
                    $discountAmount = $totalPrice * ($discount->discount_percentage / 100);
                } else {
                    $discountAmount = 0;
                    foreach ($carts as $cart) {
                        if ($discount->courses->contains($cart->course->id)) {
                            $discountAmount += $cart->course->price * ($discount->discount_percentage / 100);
                        }
                    }
                }
                $totalPriceAfterDiscount = $totalPrice - $discountAmount;
            }
        }
    
        return view('dashboard-peserta.keranjang', compact(
            'carts', 'activeDiscount', 'totalPrice', 'totalPriceAfterDiscount', 'couponCode'
        ));
    }
    
    // Menambahkan kursus ke keranjang (hanya bisa ditambahkan sekali)
    public function addToCart(Request $request, $courseId)
    {
        // Cek apakah kursus sudah ada di keranjang user
        $existingCart = Keranjang::where('user_id', Auth::id())->where('course_id', $courseId)->first();

        if ($existingCart) {
            return redirect()->route('cart.index')->with('warning', 'Kursus ini sudah ada di keranjang Anda.');
        }

        // Jika belum ada, tambahkan ke keranjang
        Keranjang::create([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
        ]);

        return redirect()->route('cart.index')->with('success', 'Kursus berhasil ditambahkan ke keranjang!');
    }

    public function handlePurchase($courseId)
    {
        if (!Auth::check()) {
            // Simpan ID kursus ke session agar bisa diproses setelah login
            Session::put('kursus_id_pending', $courseId);
            return redirect()->route('login')->with('message', 'Silakan login terlebih dahulu untuk membeli kursus.');
        }
    
        // Cek jika user yang login adalah role student
        if (Auth::user()->role !== 'student') {
            return redirect()->back()->with('warning', 'Hanya peserta yang dapat membeli kursus.');
        }
    
        // Cek apakah kursus sudah dibeli sebelumnya
        $hasPurchased = Purchase::where('user_id', Auth::id())
                                ->where('course_id', $courseId)
                                ->where('status', 'success')
                                ->exists();
    
        if ($hasPurchased) {
            return redirect()->back()->with('error', 'Kursus ini sudah Anda beli.');
        }
    
        // Tambahkan ke keranjang jika belum dibeli
        return $this->addToCart(new Request(), $courseId);
    }    

    // Menghapus kursus dari keranjang
    public function removeFromCart($cartId)
    {
        $cart = Keranjang::findOrFail($cartId);
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Kursus berhasil dihapus dari keranjang.');
    }
}


