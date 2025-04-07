<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Course;
use App\Models\Keranjang;
use Carbon\Carbon;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $discounts = Discount::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('coupon_code', 'like', '%' . $search . '%')
                ->orWhere('discount_percentage', 'like', '%' . $search . '%')
                ->orWhere('start_date', 'like', '%' . $search . '%')
                ->orWhere('end_date', 'like', '%' . $search . '%');
            });
        })->paginate(5);

        return view('dashboard-admin.discount', compact('discounts', 'search'));
    }

    public function create()
    {
        $courses = Course::all(); // Ambil semua data kursus
    
        return view('dashboard-admin.discount-tambah', compact('courses'));
    }    
    
    // Menampilkan form edit diskon
    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        $courses = Course::all();
        return view('dashboard-admin.discount-edit', compact('discount', 'courses'));
    }

    // Memperbarui data diskon
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'coupon_code' => 'required|string',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
        ], [
            'coupon_code.required' => 'Kode kupon wajib diisi.',
            'coupon_code.string' => 'Kode kupon harus berupa teks.',
            'discount_percentage.required' => 'Persentase diskon wajib diisi.',
            'discount_percentage.numeric' => 'Persentase diskon harus berupa angka.',
            'discount_percentage.min' => 'Persentase diskon minimal 1%.',
            'discount_percentage.max' => 'Persentase diskon maksimal 100%.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'end_date.required' => 'Tanggal berakhir wajib diisi.',
            'end_date.date' => 'Format tanggal berakhir tidak valid.',
            'end_date.after_or_equal' => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'end_time.required' => 'Waktu berakhir wajib diisi.',
        ]);

        $discount = Discount::findOrFail($id);
        $discount->coupon_code = $request->coupon_code;
        $discount->discount_percentage = $request->discount_percentage;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->start_time = $request->start_time;
        $discount->end_time = $request->end_time;
        $discount->apply_to_all = $request->has('apply_to_all') && $request->apply_to_all == 1 ? 1 : 0;
        $discount->save();

        // Jika diskon tidak berlaku untuk semua kursus, perbarui relasi kursus
        // if (!$discount->apply_to_all) {
        //     $discount->courses()->sync($request->input('courses', []));
        // } else {
        //     $discount->courses()->detach();
        // }

        return redirect()->route('discount')->with('success', 'Data diskon berhasil diperbarui.');
    }

    // Metode untuk menghapus discount
    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('discount')->with('success', 'Diskon berhasil dihapus.');
    }

    public function applyDiscount(Request $request)
    {
        $couponCode = $request->coupon_code;
        $courseId = $request->course_id;

        // Cari diskon berdasarkan kode kupon
        $discount = Discount::where('coupon_code', $couponCode)->first();

        // Jika kupon tidak ditemukan
        if (!$discount) {
            return response()->json(['message' => 'Kupon tidak valid'], 400);
        }

        // Cek apakah kupon masih dalam periode yang berlaku
        $now = Carbon::now();
        $startDateTime = Carbon::parse($discount->start_date . ' ' . $discount->start_time);
        $endDateTime = Carbon::parse($discount->end_date . ' ' . $discount->end_time);

        if ($now->lt($startDateTime) || $now->gt($endDateTime)) {
            return response()->json(['warning' => 'Kupon sudah kadaluarsa atau belum aktif'], 400);
        }

        // Ambil kursus berdasarkan ID
        $course = Course::find($courseId);
        
        if (!$course) {
            return response()->json(['warning' => 'Kursus tidak ditemukan'], 400);
        }

        // Cek apakah kupon berlaku untuk semua kursus atau hanya kursus tertentu
        if (!$discount->apply_to_all && !$discount->courses->contains($courseId)) {
            return response()->json(['warning' => 'Kupon tidak berlaku untuk kursus ini'], 400);
        }

        // Hitung harga setelah diskon
        $discountAmount = ($course->price * $discount->discount_percentage) / 100;
        $discountedPrice = max($course->price - $discountAmount, 0); // Pastikan harga tidak negatif

        return response()->json([
            'original_price' => $course->price,
            'discount_percentage' => $discount->discount_percentage,
            'discounted_price' => $discountedPrice,
            'success' => 'Diskon berhasil diterapkan'
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'coupon_code' => 'required|unique:discounts,coupon_code',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'apply_to_all' => 'nullable|boolean', 
            'courses' => 'nullable|array',
        ], [
            'coupon_code.required' => 'Kode kupon wajib diisi.',
            'coupon_code.unique' => 'Kode kupon sudah digunakan, silakan gunakan kode lain.',
            'discount_percentage.required' => 'Persentase diskon wajib diisi.',
            'discount_percentage.integer' => 'Persentase diskon harus berupa angka.',
            'discount_percentage.min' => 'Persentase diskon minimal 1%.',
            'discount_percentage.max' => 'Persentase diskon maksimal 100%.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'end_date.required' => 'Tanggal berakhir wajib diisi.',
            'end_date.date' => 'Format tanggal berakhir tidak valid.',
            'end_date.after_or_equal' => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'end_time.required' => 'Waktu berakhir wajib diisi.',
            'apply_to_all.boolean' => 'Nilai apply to all harus berupa benar atau salah.',
            'courses.array' => 'Kursus harus berupa array.',
        ]);
    
        $applyToAll = $request->has('apply_to_all');
    
        $discount = Discount::create([
            'coupon_code' => $request->coupon_code,
            'discount_percentage' => $request->discount_percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'apply_to_all' => $applyToAll
        ]);
    
        if (!$applyToAll && $request->has('courses')) {
            $discount->courses()->attach($request->courses);
        }
    
        return redirect()->route('discount')->with('success', 'Diskon berhasil dibuat!');
    }
    
}
