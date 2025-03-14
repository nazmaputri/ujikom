<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardMentor\CourseController;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\HelloMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class DashboardAdminController extends Controller
{
    public function approve($id, $name)
    {
        $course = Course::findOrFail($id);
        $course->status = 'approved';
        $course->save();
    
        return redirect()->route('categories.show', $name)->with('success', 'Kursus disetujui!');
    }    

    public function publish($id, $name)
    {
        $course = Course::findOrFail($id);
        $course->status = 'published';
        $course->save();

        return redirect()->route('categories.show', $name)->with('success', 'Kursus dipublikasikan!');
    }

    public function rating()
    {
        $ratings = Rating::paginate(5); 

        return view('dashboard-admin.rating', compact('ratings'));
    }

    public function displayRating($id)
    {
        $ratings = Rating::findOrFail($id);  
        if (!$ratings) {
            // Jika rating tidak ditemukan, redirect ke halaman sebelumnya dengan pesan error
            return redirect()->route('rating-admin')->with('error', 'Rating tidak ditemukan');
        }
        return view('components.rating', compact('ratings'));  
    }

    public function index() {
        $users = User::all(); 
        return view('layouts.dashboard-admin');
    }

    public function detailmentor($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard-admin.detail-mentor', compact('user'));
    }

    public function mentor(Request $request)
    {
        // Ambil query pencarian dari input
        $query = $request->input('search');

        // Filter data mentor berdasarkan role dan query pencarian
        $users = User::where('role', 'mentor') // Pastikan hanya role mentor
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('status', 'LIKE', "%{$query}%");
                });
            })
            ->paginate(5); // Pagination 5 per halaman

        // Mengirim data mentor dan query ke view
        return view('dashboard-admin.data-mentor', compact('users', 'query'));
    }

    public function detailpeserta($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard-admin.detail-peserta', compact('user'));
    }

    public function peserta(Request $request)
    {
        // Ambil query pencarian dari input
        $query = $request->input('search');
    
        // Filter data peserta berdasarkan role dan query pencarian
        $users = User::where('role', 'student') // Hanya role 'student'
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%");
                });
            })
            ->paginate(5); // Pagination 5 per halaman
    
        // Kirim data ke view
        return view('dashboard-admin.data-peserta', compact('users', 'query'));
    }    

    public function show(Request $request)
    {
        $jumlahMentor = User::where('role', 'mentor')->count();
        $jumlahPeserta = User::where('role', 'student')->count(); 
        $jumlahKursus = Course::count();
    
        // Ambil tahun dari request atau default ke tahun saat ini
        $year = $request->input('year', date('Y'));
        
        // Ambil data jumlah pengguna yang mendaftar setiap bulan di tahun tertentu
        $userGrowth = User::select(
                            DB::raw('MONTH(created_at) as month'),
                            DB::raw('COUNT(*) as user_count')
                        )
                        ->whereYear('created_at', $year) // Filter berdasarkan tahun
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
                        ->get();
        
        // Nama bulan
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        // Inisialisasi data untuk grafik
        $userGrowthData = array_fill(0, 12, 0);
        
        // Isi data pengguna yang terdaftar di bulan yang sesuai
        foreach ($userGrowth as $data) {
            $userGrowthData[$data->month - 1] = $data->user_count; // Month-1 untuk indexing dari 0
        }
        
        // Ambil daftar tahun dari data pengguna
        $years = User::select(DB::raw('YEAR(created_at) as year'))
                    ->distinct()
                    ->orderBy('year', 'asc')
                    ->pluck('year');
        
        return view('dashboard-admin.welcome', [
            'jumlahMentor'    => $jumlahMentor,
            'jumlahPeserta'   => $jumlahPeserta,
            'jumlahKursus'    => $jumlahKursus,
            'userGrowthData'  => $userGrowthData,
            'monthNames'      => $monthNames,
            'years'           => $years,
            'year'            => $year
        ]);
    }    

    public function detailkursus($id, $name) {
        $category = Category::with('courses')->where('name', $name)->firstOrFail();
        $course = Course::findOrFail($id);
    
        // Ambil user yang sedang login
        $user = auth()->user();
    
        // Ambil peserta yang telah membayar dengan status sukses
        $participants = Purchase::where('user_id', $user->id)
                                ->where('status', 'success')
                                ->where('course_id', $id)
                                ->paginate(5);
    
        return view('dashboard-admin.detail-kursus', compact('course', 'category', 'participants'));
    }    

    public function updateStatus($id)
    {
        $user = User::findOrFail($id);

        // Periksa apakah status saat ini 'pending'
        if ($user->status === 'pending') {
            // Ubah status menjadi 'active'
            $user->status = 'active';
            $user->save();

            // Kirim email ke user
            Mail::to($user->email)->send(new HelloMail($user->name));

            return redirect()->back()->with('success', 'Status mentor berhasil di perbaharui dan email telah terkirim!');
        }

        return redirect()->back()->with('info', 'User is already active.');
    }
    
    public function laporan(Request $request)
    {
        $year = $request->input('year', date('Y'));
    
        // Ambil data pendapatan admin (2% dari harga kursus) per kursus per bulan
        $revenues = DB::table('purchases')
            ->join('courses', 'purchases.course_id', '=', 'courses.id')
            ->selectRaw('
                courses.id as course_id, 
                courses.title, 
                MONTH(purchases.created_at) as month, 
                SUM(courses.price * 0.02) as admin_revenue
            ')
            ->where('purchases.status', 'success')
            ->whereYear('purchases.created_at', $year)
            ->groupBy('course_id', 'month', 'courses.title')
            ->orderBy('month', 'asc')
            ->get();
    
        // Siapkan nama bulan (1 s.d 12)
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
        // Untuk keperluan grafik, kita bisa mengelompokkan data revenue per kursus.
        $coursesRevenue = [];
        foreach ($revenues as $rev) {
            // Inisialisasi jika belum ada
            if (!isset($coursesRevenue[$rev->course_id])) {
                $coursesRevenue[$rev->course_id] = [
                    'title' => $rev->title,
                    'monthly' => array_fill(1, 12, 0)
                ];
            }
            // Set nilai revenue untuk bulan tertentu
            $coursesRevenue[$rev->course_id]['monthly'][(int)$rev->month] = (float)$rev->admin_revenue;
        }
    
        // Ambil daftar tahun yang tersedia dari data purchases (opsional)
        $years = DB::table('purchases')
            ->select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'asc')
            ->pluck('year');
    
        return view('dashboard-admin.laporan', compact('coursesRevenue', 'monthNames', 'years', 'year'));
    }    
    
    // menampilkan halaman form tambah mentor
    public function tambahmentor()
    {
        return view('dashboard-admin.tambah-mentor');
    }

    public function registerMentorByAdmin(Request $request)
    {
        // Validasi input pendaftaran mentor
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:15',
            'profesi' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|integer',
        ], [
            'name.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'phone_number.required' => 'Nomor telepon harus diisi.',
            'profesi.required' => 'Profesi harus diisi.',
            'experience.required' => 'Pengalaman harus diisi.',
        ]);

        // Buat user baru dengan role mentor
        $mentor = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => 'mentor', // Role dipastikan selalu mentor
            'status' => 'pending', // Status default mentor pending
            'email_verified_at' => now(),
            'profesi' => $request->profesi,
            'experience' => $request->experience,
            'linkedin' => $request->linkedin,
            'company' => $request->company,
            'years_of_experience' => $request->years_of_experience,
        ]);

        return redirect()->route('datamentor-admin')->with('success', 'Mentor berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('datamentor-admin')->with('success', 'User berhasil dihapus.');
    }    

    public function deletePeserta($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('datapeserta-admin')->with('success', 'User berhasil dihapus.');
    }

}
