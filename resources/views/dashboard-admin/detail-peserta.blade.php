@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto">
    <!-- Card Detail User -->
    <div class="bg-white shadow-lg rounded-lg border border-gray-200 p-6 mb-6">
        <!-- Judul Card -->
        <div class="text-left mb-6">
            <h2 class="text-xl font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Detail Peserta</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom Kiri: Foto Profil, Nama, Role -->
            <div class="flex flex-col items-center space-y-3">
                <!-- Foto Profil -->
                <div class="w-32 h-32 rounded-full overflow-hidden flex justify-center items-center bg-gray-100">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) :  asset('storage/default-profile.jpg') }}" alt="Foto Profil" class="object-cover w-full h-full">
                </div>

                <!-- Nama -->
                <p class="text-lg text-gray-700 font-semibold text-center md:text-left">{{ $user->name }}</p>

                <!-- Role -->
                <p class="text-gray-700 text-sm text-center md:text-left">{{ ucfirst($user->role) }}</p>
            </div>

            <!-- Kolom Kanan: Informasi Lainnya -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                <!-- Email -->
                <div>
                    <h4 class="font-semibold text-gray-700 text-sm">Email:</h4>
                    <p class="text-sm text-gray-700">{{ $user->email }}</p>
                </div>

                <!-- No Telepon -->
                <div>
                    <h4 class="font-semibold text-gray-700 text-sm">No Telepon:</h4>
                    <p class="text-sm text-gray-700">{{ $user->phone_number ?? '-' }}</p>
                </div>

                <!-- Status -->
                <div>
                    <h4 class="font-semibold text-gray-700 text-sm">Status:</h4>
                    <p class="text-sm text-gray-700">{{ ucfirst($user->status) ?? '-' }}</p>
                </div>

                <!-- Tanggal Registrasi -->
                <div>
                    <h4 class="font-semibold text-gray-700 text-sm">Tanggal Registrasi:</h4>
                    <p class="text-sm text-gray-700">{{ $user->created_at->translatedFormat('d F Y') }}</p>
                </div>

                <!-- Email Verified At -->
                <div class="md:col-span-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Email Terverifikasi:</h4>
                    <p class="text-sm text-gray-700">{{ $user->email_verified_at ? $user->email_verified_at->translatedFormat('d F Y H:i:s') : 'Belum Terverifikasi' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg border border-gray-200 p-6 mb-6">
        <div class="text-left mb-4 border-b-2 border-gray-300 pb-2">
            <h2 class="text-lg font-semibold text-gray-700">Kursus Yang Diikuti</h2>
        </div>
        <div class="overflow-x-auto">
            <div class="min-w-full w-64">
                <table class="min-w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-sky-100 text-gray-700 text-sm">
                            <th class="px-2 py-2 text-center border-b border-l border-gray-200">No</th>
                            <th class="px-4 py-2 text-center border-b border-gray-200">Judul</th>
                            {{-- <th class="px-4 py-2 text-center border-b border-gray-200">Kategori</th> --}}
                            <th class="px-4 py-2 text-center border-b border-r border-gray-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse($purchasedCourses as $index => $purchase)
                            <tr class="bg-white hover:bg-sky-50 border-b text-sm">
                                <td class="px-2 py-2 text-center border-b border-l border-gray-200">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $purchase->course->title }}</td>
                                {{-- <td class="px-4 py-2 border-b border-gray-200">{{ $purchase->course->category->name ?? '-' }}</td> --}}
                                <td class="py-3 px-6 text-center border-b border-r border-gray-200">
                                    <div class="flex items-center justify-center space-x-8">
                                        <!-- Tombol Lihat Detail -->
                                        <a href="" 
                                           class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">Peserta belum membeli kursus</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
            </div>
        </div>
        <!-- Tombol Kembali -->
        <div class="text-right mt-6">
            <a href="{{ route('datapeserta-admin') }}" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-3 px-4 rounded-lg shadow-md shadow-blue-100 hover:shadow-none">
                Kembali
            </a>
        </div>
    </div>

</div>
@endsection
