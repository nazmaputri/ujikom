<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS CDN -->
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
    <div class="flex justify-center items-center min-h-screen px-4">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-lg">
            <!-- Logo and Website Name -->
            <div class="flex flex-col items-center justify-center space-y-2">   
                <div class="flex items-center space-x-3">
                    <a href="{{ route('landingpage') }}" class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-sky-600 transition-all duration-300 hover:translate-y-[-2px]">
                            <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                        <img src="{{ asset('storage/eduflix-1.png') }}" alt="Logo" class="w-[72px] h-16">
                    </a>
                    <h1 class="text-xl font-semibold text-sky-600">Masuk</h1>
                </div>
            </div>         
            
            @if (session('success'))
                <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-3">
                    {{ session('success') }}
                </div>
            @endif
        
            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-4" id="form">
                @csrf

               <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-sky-600 pb-2">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 border text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('email') border-red-500 @enderror" placeholder="Masukkan email">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1"  id="email-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="pb-4 relative">
                    <label for="password" class="block text-sm font-medium text-sky-600 pb-2">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border text-sm rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('password') border-red-500 @enderror" placeholder="Masukkan kata sandi">
                    <button type="button" onclick="toggleVisibility()" class="absolute right-3 mt-2 text-gray-500">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1" id="password-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" id="btn-submit" class="inline-flex justify-center items-center w-full px-4 py-2 bg-sky-600 text-white font-semibold rounded-md hover:bg-sky-500 focus:outline-none">
                        Masuk
                    </button>
                </div>
            </form>

            <h4 class="text-center text-sky-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-900 underline">Daftar</a>
                <div class="flex justify-center mt-6">
                    <a href="{{ route('login.google') }}" 
                       class="flex items-center justify-center border border-gray-300 rounded-md px-4 py-2 hover:bg-gray-100 transition duration-200">
                        <img width="24" height="24" 
                             src="https://img.icons8.com/color/48/google-logo.png" 
                             alt="google-logo" 
                             class="mr-2" />
                        <span class="text-sm text-gray-700 font-medium">Login dengan Google</span>
                    </a>
                </div>                
            </h4>

        </div>
    </div>

<script>
    //untuk mengatur flash message dari backend
    document.addEventListener('DOMContentLoaded', function () {
        const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.remove();
            }, 3000); // Hapus pesan setelah 3 detik
        }
    });
    
    // Pengaturan untuk membuka/menutup input password
    function toggleVisibility() {
    const input = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (input.type === 'password') { //untuk melihat password
        input.type = 'text';
        eyeIcon.innerHTML = `
            <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
            <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />
        `;
    } else {
        input.type = 'password'; // untuk menyembunyikan password
        eyeIcon.innerHTML = `
            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
        `;
    }
    }

    // untuk mengatur button "masuk" saat sedang loading
    const form = document.getElementById('form');
    form.addEventListener('submit', function (e) {
        const buttonSubmit = document.getElementById('btn-submit');
        
        // Ubah teks tombol ke loading state
        buttonSubmit.innerHTML =
            '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';
        
        // Tambahkan atribut disabled
        buttonSubmit.setAttribute('disabled', true);
        
        // Tambahkan kelas untuk menonaktifkan hover dan pointer
        buttonSubmit.classList.add('cursor-not-allowed', 'bg-sky-500');
        buttonSubmit.classList.remove('hover:bg-sky-500');
    });
</script>
</body>
</html>
