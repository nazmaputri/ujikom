@extends('layouts.dashboard-admin')

@section('content')
<div>
    <div class="bg-white p-6 rounded-md shadow-lg overflow-auto">
        <div class="justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Tambah Mentor</h3>
        </div>
        <form action="{{ route('store-mentor') }}" method="POST" class="grid grid-col-1 md:grid-cols-2 gap-6">
            @csrf
            <input type="hidden" name="added_by_admin" value="true">
            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 pb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required placeholder="Masukkan nama lengkap">
            </div>
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 pb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required placeholder="Masukkan Email">
            </div>
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 pb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required placeholder="Masukkan password">
            </div>
            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 pb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required placeholder="Masukkan konfirmasi password">
            </div>
            <!-- Nomor Telepon -->
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 pb-2">Nomor Telepon</label>
                <input type="text" name="phone_number" id="phone_number" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required placeholder="Masukkan nomor telepon">
            </div>
            <!-- Profesi -->
            <div>
                <label for="profesi" class="block text-sm font-medium text-gray-700 pb-2">Profesi</label>
                <input type="text" name="profesi" id="profesi" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required placeholder="Masukkan profesi">
            </div>
            <!-- LinkedIn -->
            <div>
                <label for="linkedin" class="block text-sm font-medium text-gray-700 pb-2">LinkedIn</label>
                <input type="text" name="linkedin" id="linkedin" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required placeholder="Masukkan link URL linkedin">
            </div>
            <!-- Company -->
            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 pb-2">Perusahaan</label>
                <input type="text" name="company" id="company" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required placeholder="Masukkan nama perusahaan tempat bekerja">
            </div>
            <!-- Years of Experience -->
            <div>
                <label for="years_of_experience" class="block text-sm font-medium text-gray-700 pb-2">Tahun Pengalaman</label>
                <input type="number" name="years_of_experience" id="years_of_experience" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required placeholder="Masukkan tahun pengalaman bekerja">
            </div>
            <!-- Deskripsi Pengalaman -->
            <div class="">
                <label for="experience" class="block text-sm font-medium text-gray-700 pb-2">Deskripsi Pengalaman</label>
                <textarea name="experience" id="experience" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" placeholder="Deskripsikan pengalaman"></textarea>
            </div>
            <!-- Hidden Role -->
            <input type="hidden" name="role" value="mentor">
            <!-- Submit Button -->
            <div class="col-span-1 md:col-span-2 flex justify-end space-x-4">
                <a href="{{ route('datamentor-admin') }}" class="bg-red-400 text-white font-semibold py-2 px-6 rounded-lg hover:bg-red-300">Batal</a>
                <button type="submit" class="bg-sky-400 text-white font-semibold py-2 px-6 rounded-lg hover:bg-sky-300">
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>
@endsection