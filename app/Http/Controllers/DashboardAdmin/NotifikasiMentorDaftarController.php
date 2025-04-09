<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotifikasiMentorDaftar;

class NotifikasiMentorDaftarController extends Controller
{
    public function fetchNotifikasi()
    {
        // Ambil notifikasi yang belum dibaca
        $notifikasi = NotifikasiMentorDaftar::where('is_read', false)->get();

        return response()->json($notifikasi);
    }

    // Tandai notifikasi sebagai dibaca
    public function markAsRead($id)
    {
        $notifikasi = NotifikasiMentorDaftar::find($id);

        if ($notifikasi) {
            $notifikasi->is_read = true;
            $notifikasi->save();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Notifikasi tidak ditemukan'], 404);
    }

    // function untuk menghitung jumlah notifikasi yang belum dibaca 
    public function checkUnreadNotifikasi()
    {
        // Cek apakah ada notifikasi yang belum dibaca
        $unreadNotifikasiCount = NotifikasiMentorDaftar::where('is_read', false)->count();

        return response()->json(['unread_count' => $unreadNotifikasiCount]);
    }
}
