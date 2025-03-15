<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

     <!-- Custom Style -->
     <style>
        body {
            font-family: "Quicksand", sans-serif !important;
        }
    </style>
</head>
<body class="bg-sky-50">
    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-4xl p-5 space-y-6 bg-white rounded-lg shadow-lg m-10">
            <!-- Logo and Website Name -->
            <div class="flex flex-col items-center justify-center space-y-2">
                <div class="flex flex-col md:flex-row items-center space-x-3">
                    <img src="{{ asset('storage/eduflix-1.png') }}" alt="Logo" class="w-18 h-16">
                    <h1 class="text-xl font-semibold text-sky-600">Daftar</h1>
                </div>
                <h4 class="text-center text-sky-600">
                    Ayo daftar dan menjadi bagian mentor di EduFlix!
                </h4>
            </div>  

           
            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Form -->
            <form action="{{ route('register') }}" method="POST" class="">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-sky-600 pb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" class="w-full px-4 py-2 border text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-sky-600 pb-2">Email</label>
                        <input type="email" name="email" id="email" placeholder="Masukkan email" class="w-full px-4 py-2 border text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Password Field -->
                    <div class="relative">
                        <label for="password" class="block text-sm font-medium text-sky-600 pb-2">Kata Sandi</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan kata sandi" class="w-full px-4 py-2 border text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('password') border-red-500 @enderror">
                        <span class="absolute right-3 mt-2 transform cursor-pointer text-gray-500" id="togglePassword">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Confirm Password Field -->
                    <div class="relative">
                        <label for="password_confirmation" class="block text-sm font-medium text-sky-600 pb-2">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Masukkan ulang kata sandi" class="w-full px-4 py-2 border text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('password_confirmation') border-red-500 @enderror">
                        <span class="absolute mt-2 right-1 transform -translate-x-1/2 cursor-pointer text-gray-500" id="toggleConfirmPassword">
                            <svg id="eyeConfirmIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Phone Number Field -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-sky-600 pb-2">Nomor Telepon</label>
                        <input type="text" name="phone_number" id="phone_number" placeholder="Masukkan nomor telepon" class="w-full px-4 py-2 border text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('phone_number') border-red-500 @enderror" value="{{ old('phone_number') }}">
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Profesi -->
                    <div>
                        <label for="profesi" class="block text-sm font-medium text-sky-600 pb-2">Profesi</label>
                        <input type="text" name="profesi" id="profesi" placeholder="Masukkan profesi anda saat ini" class="w-full px-4 py-2 border text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('profesi') border-red-500 @enderror" value="{{ old('profesi') }}">
                        @error('profesi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- LinkedIn -->
                    <div>
                        <label for="linkedin" class="block text-sm font-medium text-sky-600 pb-2">LinkedIn</label>
                        <input type="text" name="linkedin" id="linkedin" placeholder="Masukkan Link URL LinkedIn" class="w-full px-4 py-2 border text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('linkedin') border-red-500 @enderror" value="{{ old('linkedin') }}">
                        @error('linkedin')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Perusahaan -->
                    <div>
                        <label for="company" class="block text-sm font-medium text-sky-600 pb-2">Perusahaan</label>
                        <input type="text" name="company" id="company" placeholder="Masukkan nama perusahaan tempat bekerja" class="w-full px-4 py-2 border text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('company') border-red-500 @enderror" value="{{ old('company') }}">
                        @error('company')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Tahun Pengalaman -->
                    <div>
                        <label for="years_of_experience" class="block text-sm font-medium text-sky-600 pb-2">Tahun Pengalaman</label>
                        <input type="number" name="years_of_experience" id="years_of_experience" placeholder="Masukkan tahun pengalaman bekerja" class="w-full px-4 py-2 border text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('years_of_experience') border-red-500 @enderror" value="{{ old('years_of_experience') }}">
                        @error('years_of_experience')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Deskripsi Pengalaman -->
                    <div>
                        <label for="experience" class="block text-sm font-medium text-sky-600 pb-2">Deskripsi Pengalaman</label>
                        <textarea name="experience" id="experience" rows="5" placeholder="Deskripsikan pengalaman saat bekerja atau mengajar" class="text-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('experience') border-red-500 @enderror">{{ old('experience') }}</textarea>
                        @error('experience')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            
                <!-- Hidden Role Field -->
                <input type="hidden" name="role" value="mentor">
             
                <div class="justify-center items-center space-y-4 mt-5">
                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button type="submit"
                            class="md:w-1/2 w-full px-4 py-2 bg-sky-600 text-white font-semibold rounded-md hover:bg-sky-700 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:ring-offset-2">
                            Daftar
                        </button>
                    </div>
                
                    <!-- Login Link -->
                    <h4 class="text-center text-sky-600">
                        Sudah punya akun?
                        <a href="/login" class="text-blue-900 underline">Login</a>
                    </h4>
                </div>
            </form>
            
        </div>
    </div>

<script>
    // Pengaturan Icon PAssword
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    const eyeOpen = `<path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />`;
    const eyeClosed = `<path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
                    <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />`;

    togglePassword.addEventListener('click', function() {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.innerHTML = eyeClosed;
        } else {
            passwordField.type = 'password';
            eyeIcon.innerHTML = eyeOpen;
        }
    });

    // Pengaturan Icon Konfirmasi Password
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordField = document.getElementById('password_confirmation');
    const eyeConfirmIcon = document.getElementById('eyeConfirmIcon');

    const eyeOpenConfirm = `<path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />`;

    const eyeClosedConfirm = `<path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
                    <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />`;

    toggleConfirmPassword.addEventListener('click', function() {
        if (confirmPasswordField.type === 'password') {
            confirmPasswordField.type = 'text';
            eyeConfirmIcon.innerHTML = eyeClosedConfirm;
        } else {
            confirmPasswordField.type = 'password';
            eyeConfirmIcon.innerHTML = eyeOpenConfirm;
        }
    });
</script>
</body>
</html>
