<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Purchase;
use App\Models\Course;
use App\Models\MateriUSer;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function certificate($courseId)
{
    $userId = auth()->id();

    // Cek apakah user telah menyelesaikan semua materi (kuis)
    $unfinishedQuizzes = MateriUser::where('user_id', $userId)
        ->whereIn('materi_id', function ($query) use ($courseId) {
            $query->select('id')->from('materi');
        })
        ->whereNull('completed_at') // Jika ada yang belum selesai
        ->exists(); // Menggunakan `exists()` agar lebih efisien

    if ($unfinishedQuizzes) {
        return redirect()->back()->with('error', 'Anda harus menyelesaikan semua kuis sebelum mengakses sertifikat.');
    }

    // Ambil data kursus untuk ditampilkan di sertifikat
    $course = Course::findOrFail($courseId);

    // Data untuk sertifikat
    $data = [
        'participant_name'       => auth()->user()->name, 
        'course_title'           => $course->title,
        'course_category'        => $course->category,
        'course_start_date'      => $course->start_date,
        'course_end_date'        => $course->end_date,
        'mentor_name'            => $course->mentor->name ?? 'Tidak Diketahui',
        'signature_title_left'   => 'Direktur Kursus',
        'signature_title_right'  => 'Mentor Kursus',
        'course'                 => $course // Pastikan course dikirimkan ke view
    ];

    return view('dashboard-peserta.certificate-detail', $data);
}

    
    // Menampilkan Sertifikat
    public function showCertificate($courseId)
    {
        $userId = auth()->id(); // Mendapatkan ID user yang login

        // Ambil data course berdasarkan courseId
        $course = Course::findOrFail($courseId);

        // Data untuk sertifikat
        $data = [
            'participant_name'       => $userId ? auth()->user()->name : 'Nama Peserta Tidak Diketahui',  // Nama peserta
            'course_title'           => $course->title,
            'course_category'        => $course->category,
            'course_start_date'      => $course->start_date,
            'course_end_date'        => $course->end_date,
            'mentor_name'            => $course->mentor->name ?? 'Tidak Diketahui',
            'signature_title_left'   => 'Direktur Kursus',
            'signature_title_right'  => 'Mentor Kursus',
        ];

        // Mengembalikan view untuk sertifikat
        return view('dashboard-mentor.sertifikat', $data);
    }
    
    // Mengunduh Sertifikat
    public function downloadCertificate($courseId)
    {
        $userId = auth()->id();
    
        // Ambil data pembelian dari tabel purchases
        $purchase = Purchase::where('user_id', $userId)
                            ->where('course_id', $courseId)
                            ->where('status', 'success') // pastikan status pembelian sukses
                            ->firstOrFail();
    
        $course = $purchase->course;
    
        // Data untuk sertifikat
        $data = [
            'participant_name'       => $purchase->user->name,
            'course_title'           => $course->title,
            'course_category'        => $course->category,
            'course_start_date'      => $course->start_date,
            'course_end_date'        => $course->end_date,
            'mentor_name'            => $course->mentor->name ?? 'Tidak Diketahui',
            'signature_title_left'   => 'Direktur Kursus',
            'signature_title_right'  => 'Mentor Kursus',
            'is_pdf'                 => true // ← agar image tampil saat diunduh
        ];
    
        // Buat PDF menggunakan DOMPDF
        $pdf = Pdf::loadView('dashboard-mentor.sertifikat', $data)
                  ->setPaper('a4', 'landscape');
    
        return $pdf->download('certificate.pdf');
    }
    
}
