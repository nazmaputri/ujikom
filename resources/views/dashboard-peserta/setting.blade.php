@extends('layouts.dashboard-peserta')

@section('content')

<div class="w-full mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-semibold text-gray-700 border-b-2 pb-2 mb-4">Pengaturan Akun</h2>
    <form action="{{ url('/update-peserta') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kolom Foto Profil -->
            <div class="flex flex-col items-center">
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-16 h-16 rounded-full">
                @else
                    <!-- SVG sebagai ikon default -->
                    <svg class="w-16 h-16 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                        <path d="M399 384.2C376.9 345.8 335.4 320 288 320l-64 0c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"/>
                    </svg>
                @endif
                <input type="file" name="photo" id="photo" class="p-2 mt-3 block w-full border border-gray-200 rounded-md shadow-sm">
                @error('photo')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kolom Input Kanan -->
            <div class="md:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="p-2 mt-1 block w-full border border-gray-200 rounded-md shadow-sm focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required>
                        @error('name')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="p-2 mt-1 block w-full border border-gray-200 rounded-md shadow-sm focus:ring-1 focus:ring-sky-500 focus:border-sky-500" required>
                        @error('email')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Masukkan Password Baru</label>
                        <input type="password" name="password" id="password" class="p-2 mt-1 block w-full border-gray-200 border rounded-md shadow-sm focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
                        @error('password')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="p-2 mt-1 block w-full border border-gray-200 rounded-md shadow-sm focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <button type="submit" class="bg-sky-400 text-white font-semibold py-1.5 px-5 rounded-lg hover:bg-sky-300">Simpan</button>
            <a href="{{ route('welcome-peserta') }}" class="bg-red-400 text-white font-semibold py-1.5 px-5 rounded-lg hover:bg-red-500">Batal</a>
        </div>
    </form>
    
<script>
    // Toggle password visibility for password field
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
        
    togglePassword.addEventListener('click', function() {
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
    });
        
    // Toggle password visibility for confirm password field
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordField = document.getElementById('password_confirmation');
        
    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPasswordField.type === 'password' ? 'text' : 'password';
        confirmPasswordField.type = type;
    });
</script>
</div>

@endsection