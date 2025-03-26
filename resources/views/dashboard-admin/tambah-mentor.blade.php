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
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('name') border-red-500 @enderror" placeholder="Masukkan nama lengkap">
                @error('name')
                    <p class="text-red-500 text-sm mt-1" id="name-error">{{ $message }}</p>
                @enderror
            </div>
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 pb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('email') border-red-500 @enderror" placeholder="Masukkan Email">
                @error('email')
                    <p class="text-red-500 text-sm mt-1" id="email-error">{{ $message }}</p>
                @enderror
            </div>
           
            <!-- Nomor Telepon -->
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 pb-2">Nomor Telepon</label>
                <input type="text" name="phone_number" id="phone_number" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('phone_number') border-red-500 @enderror" placeholder="Masukkan nomor telepon">
                @error('phone_number')
                    <p class="text-red-500 text-sm mt-1" id="phone_number-error">{{ $message }}</p>
                @enderror
            </div>
            <!-- Profesi -->
            <div>
                <label for="profesi" class="block text-sm font-medium text-gray-700 pb-2">Profesi</label>
                <input type="text" name="profesi" id="profesi" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('profesi') border-red-500 @enderror" placeholder="Masukkan profesi">
            </div>
            <!-- LinkedIn -->
            <div>
                <label for="linkedin" class="block text-sm font-medium text-gray-700 pb-2">LinkedIn</label>
                <input type="text" name="linkedin" id="linkedin" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('linkedin') border-red-500 @enderror" placeholder="Masukkan link URL linkedin">
                @error('linkedin')
                    <p class="text-red-500 text-sm mt-1" id="linkedin-error">{{ $message }}</p>
                @enderror
            </div>
            <!-- Company -->
            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 pb-2">Perusahaan</label>
                <input type="text" name="company" id="company" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('company') border-red-500 @enderror" placeholder="Masukkan nama perusahaan tempat bekerja">
                @error('company')
                    <p class="text-red-500 text-sm mt-1" id="company-error">{{ $message }}</p>
                @enderror
            </div>
            <!-- Years of Experience -->
            <div>
                <label for="years_of_experience" class="block text-sm font-medium text-gray-700 pb-2">Tahun Pengalaman</label>
                <input type="number" name="years_of_experience" id="years_of_experience" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('years_of_experience') border-red-500 @enderror" placeholder="Masukkan tahun pengalaman bekerja">
                @error('years_of_experience')
                    <p class="text-red-500 text-sm mt-1" id="years_of_experienc-error">{{ $message }}</p>
                @enderror
            </div>
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 pb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('password') border-red-500 @enderror" placeholder="Masukkan password">
                @error('password')
                    <p class="text-red-500 text-sm mt-1" id="password-error">{{ $message }}</p>
                @enderror
            </div>
            <!-- Deskripsi Pengalaman -->
            <div class="">
                <label for="experience" class="block text-sm font-medium text-gray-700 pb-2">Deskripsi Pengalaman</label>
                <textarea name="experience" id="experience" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('experience') border-red-500 @enderror" placeholder="Deskripsikan pengalaman"></textarea>
                @error('experience')
                    <p class="text-red-500 text-sm mt-1" id="experience-error">{{ $message }}</p>
                @enderror
            </div>
            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 pb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('password_confirmation') border-red-500 @enderror" placeholder="Masukkan konfirmasi password">
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1" id="password_confirmation-error">{{ $message }}</p>
                @enderror
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

<script>
    // Fungsi untuk menghapus class error dan menyembunyikan pesan error validasi (form line 149 to 168)
    document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                removeErrorStyles(input.id);
            });
        });
    });

    function removeErrorStyles(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.classList.remove('border-red-500', 'focus:ring-red-500', 'text-red-500');
            const errorMessage = document.getElementById(inputId + '-error');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }
    }
</script>
@endsection
