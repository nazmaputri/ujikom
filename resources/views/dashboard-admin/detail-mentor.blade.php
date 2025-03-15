@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto">
    <!-- Card Detail Mentor -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <!-- Judul Card -->
        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold mb-5 text-gray-700 border-b-2 pb-2">Detail Mentor</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Foto Profil & Role -->
            <div class="flex flex-col items-center space-y-1">
                <!-- Foto Profil -->
                <div class="w-36 h-36 rounded-full overflow-hidden flex justify-center items-center bg-gray-100">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('storage/default-profile.jpg') }}" alt="" class="object-cover w-full h-full">
                </div>                
                
                <!-- Nama -->
                <div class="p-1">
                    <p class="font-semibold text-gray-700 text-sm">{{ $user->name }}</p>
                </div>

                <!-- Role -->
                <div class="w-full text-center">
                    <p class="text-gray-700">{{ ucfirst($user->role) }}</p>
                </div>
            </div>

            <!-- Kolom Tengah: Informasi Mentor -->
            <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Email:</h4>
                    <p class="text-sm text-gray-700">{{ $user->email }}</p>
                </div>

                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">No Telepon:</h4>
                    <p class="text-sm text-gray-700">{{ $user->phone_number ?? '-' }}</p>
                </div>

                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Pengalaman:</h4>
                    <p class="text-sm text-gray-700">{{ $user->experience ?? '-' }}</p>
                </div>

                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Status:</h4>
                    <p class="text-sm text-gray-700">{{ ucfirst($user->status) ?? '-' }}</p>
                </div>

                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Tanggal Registrasi:</h4>
                    <p class="text-sm text-gray-700">{{\Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}</p>
                </div>
                
                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Email Terverifikasi:</h4>
                    <p class="text-sm text-gray-700">
                        {{ $user->email_verified_at ? \Carbon\Carbon::parse($user->email_verified_at)->translatedFormat('d F Y H:i:s') : 'Belum Terverifikasi' }}
                    </p>
                </div>                
            </div>
        </div>
    </div>

    <!-- Card Kursus -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">
        <div class="text-left mb-4 border-b-2 border-gray-300 pb-2">
            <h2 class="text-lg font-semibold text-gray-700">Kursus</h2>
        </div>
        <table class="min-w-full">
            <thead>
                <tr class="bg-sky-100 text-gray-700">
                    <th class="px-2 py-2 text-center">No</th>
                    <th class="px-4 py-2 text-center">Judul</th>
                    <th class="px-4 py-2 text-center">Harga</th>
                    <th class="px-4 py-2 text-center">Tanggal dibuat</th>
                    <th class="px-4 py-2 text-center">Rating</th>
                </tr>
            </thead>
        
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($courses as $index => $course) 
                    <tr class="bg-white hover:bg-sky-50 border-b">
                        <td class="px-2 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $course->title }}</td>
                        <td class="px-4 py-2 text-center">Rp {{ number_format($course->price, 0, ',', '.') }}</td> 
                        <td class="px-4 py-2">{{ $course->created_at->format('d-m-Y') }}</td>
                        <td class="px-4 py-2 text-center">
                            {{ $course->rating ?? 'Belum ada rating' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">Belum ada kursus yang diajarkan oleh mentor ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="text-right pt-10">
        <a href="{{ route('datamentor-admin') }}" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-none">
            Kembali
        </a>
        </div>
    </div>

@endsection
