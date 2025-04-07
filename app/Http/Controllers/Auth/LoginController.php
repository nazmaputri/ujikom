<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Keranjang;
use App\Models\Purchase;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Redirect user ke Google untuk login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback yang menerima data dari Google dan login pengguna
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = $googleUser->getEmail();
    
            // Cari user berdasarkan email
            $user = User::where('email', $email)->first();
    
            // Kalau user tidak ditemukan
            if (!$user) {
                return redirect()->route('register')->withErrors([
                    'email' => 'Email Anda belum terdaftar. Silakan daftar terlebih dahulu.',
                ]);
            }
    
            // Cek verifikasi email
            if (is_null($user->email_verified_at)) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Email Anda belum diverifikasi.',
                ]);
            }
    
            // Cek status akun
            if ($user->status !== 'active') {
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda tidak aktif.',
                ]);
            }
    
            // Login pengguna
            switch ($user->role) {
                case 'admin':
                    Auth::guard('admin')->login($user); 
                    return redirect()->route('welcome-admin');
                
                case 'mentor':
                    Auth::guard('mentor')->login($user); 
                    return redirect()->route('welcome-mentor');
                
                case 'student':
                    Auth::guard('student')->login($user);  
                    return redirect()->route('welcome-peserta');
                
                default:
                    Auth::logout();
                    return redirect('login')->withErrors(['email' => 'Role tidak dikenal.']);
            }
    
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'google' => 'Gagal login dengan Google. Coba lagi nanti.',
            ]);
        }
    }
    

    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.'
        ]);
    
        // Cek pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();
    
        // Jika pengguna tidak ditemukan
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.',
            ])->withInput($request->except('password'));
        }
    
        // Cek apakah password cocok dengan hash yang ada di database
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ])->withInput($request->except('password'));
        }
    
        // Cek apakah email sudah terverifikasi
        if (is_null($user->email_verified_at)) {
            return back()->withErrors(['email' => 'Email Anda belum terverifikasi.']);
        }
    
        // Cek apakah status pengguna aktif
        if ($user->status !== 'active') {
            return back()->withErrors(['email' => 'Akun Anda tidak aktif.']);
        }

        // Cek apakah akun dalam status inactive
        if ($user->status === 'inactive') {
            return back()->withErrors(['email' => 'Akun Anda tidak aktif.']);
        }

        // Login pengguna dan amankan sesi baru
        $request->session()->regenerate();
    
        // Redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
                Auth::guard('admin')->login($user); 
                return redirect()->route('welcome-admin');
            
            case 'mentor':
                Auth::guard('mentor')->login($user); 
                return redirect()->route('welcome-mentor');
            
            case 'student':
                Auth::guard('student')->login($user); 
                
                // Cek apakah sebelumnya ada permintaan beli kursus
                if (Session::has('kursus_id_pending')) {
                    $courseId = Session::pull('kursus_id_pending'); // ambil dan hapus dari session

                    // Cek apakah kursus sudah dibeli
                    $hasPurchased = Purchase::where('user_id', $user->id)
                        ->where('course_id', $courseId)
                        ->where('status', 'success')
                        ->exists();

                    if ($hasPurchased) {
                        return redirect()->route('welcome-peserta')->with('error', 'Kursus ini sudah Anda beli.');
                    }

                    // Tambahkan ke keranjang hanya jika belum dibeli
                    Keranjang::firstOrCreate([
                        'user_id' => $user->id,
                        'course_id' => $courseId,
                    ]);

                    return redirect()->route('cart.index')->with('success', 'Kursus berhasil ditambahkan ke keranjang.');
                }

                return redirect()->route('welcome-peserta');

            default:
                // Jika role tidak dikenal, logout dan tolak akses
                Auth::logout();
                return redirect('login')->withErrors(['email' => 'Role tidak dikenal.']);
        }
    }    

    // Proses logout
    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Anda telah berhasil logout.');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Anda telah berhasil logout.');
    }

    public function logoutMentor(Request $request)
    {
        Auth::guard('mentor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Anda telah berhasil logout.');
    }

}
