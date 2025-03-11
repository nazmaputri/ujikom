@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto">
    <!-- Card Detail User -->
    <div class="bg-white shadow-lg rounded-lg border border-gray-200 p-6 mb-6">
        <!-- Judul Card -->
        <div class="text-left mb-6">
            <h2 class="text-xl font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Detail Peserta</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <!-- Kolom Kiri: Foto Profil, Role -->
            <div class="flex flex-col items-center mb-6 space-y-4">
                <!-- Foto Profil -->
                <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-gray-300 flex justify-center items-center bg-gray-100">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('path/to/default-photo.jpg') }}" alt="Foto Profil" class="object-cover w-full h-full">
                </div>           
        
                <!-- Role -->
                <div class="py-1 px-2 w-full text-center">
                    <p class="text-gray-700">{{ ucfirst($user->role) }}</p>
                </div>
            </div>
        
            <!-- Kolom Kanan: Informasi Lainnya -->
            <div class="flex flex-col space-y-4">
                <!-- Email -->
                <div class="py-1 px-2 w-full">
                    <h4 class="font-semibold text-gray-700 text-sm">Email:</h4>
                    <p class="text-sm text-gray-700">{{ $user->email }}</p>
                </div>

                <!-- No Telepon -->
                <div class="py-1 px-2 w-full">
                    <h4 class="font-semibold text-gray-700 text-sm">No Telepon:</h4>
                    <p class="text-sm text-gray-700">{{ $user->phone_number ?? '-' }}</p>
                </div>

                <!-- Status -->
                <div class="py-1 px-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Status:</h4>
                    <p class="text-sm text-gray-700">{{ ucfirst($user->status) ?? '-' }}</p>
                </div>
        
                <!-- Tanggal Registrasi -->
                <div class="py-1 px-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Tanggal Registrasi:</h4>
                    <p class="text-sm text-gray-700">{{ $user->created_at->translatedFormat('d F Y') }}</p>
                </div>
        
                <!-- Email Verified At -->
                <div class="py-1 px-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Email Terverifikasi:</h4>
                    <p class="text-sm text-gray-700">{{ $user->email_verified_at ? $user->email_verified_at->translatedFormat('d F Y H:i:s') : 'Belum Terverifikasi' }}</p>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-right mt-4">
            <a href="{{ route('datapeserta-admin') }}" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-6 rounded-lg shadow-md shadow-blue-100 hover:shadow-none">
                Kembali
            </a>
        </div>
    </div>
</div>

@endsection
