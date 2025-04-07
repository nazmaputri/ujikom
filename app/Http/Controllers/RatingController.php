<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{

    public function toggleDisplayAdmin(Request $request, $id)
    {
        // Ambil data rating dari tabel rating
        $rating = Rating::findOrFail($id);

        // Jika checkbox ada pada request, set display ke 1; jika tidak, set ke 0
        $rating->display = $request->has('display') ? 1 : 0;
        $rating->save();

        return redirect()->back()->with('success', 'Status display admin berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:130',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
        
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        
            'rating.required' => 'Rating wajib dipilih.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.min' => 'Rating minimal adalah 1.',
            'rating.max' => 'Rating maksimal adalah 5.',
        
            'comment.string' => 'Komentar harus berupa teks.',
            'comment.max' => 'Komentar tidak boleh lebih dari 130 karakter.',
        ]);        

        // Simpan data ke database
        Rating::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Terima kasih atas penilaian Anda!');
    }

    // hapus rating by id
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id); // Cari rating berdasarkan ID
        $rating->delete(); // Hapus rating

        return redirect()->route('rating-admin')->with('success', 'Rating berhasil dihapus');
    }

}
