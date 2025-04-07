<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->judul ?? 'Kursus' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
     <!-- Custom Style -->
     <style>
        body {
            font-family: "Quicksand", sans-serif !important;
        }
    </style>
</head>
<body>
    @include('components.navbar') 

    <!-- Bagian Materi Kursus -->
    <section id="course" class="py-12 bg-sky-50">
        <div class="container mx-auto px-6 lg:px-8 mt-16">
            <!-- Kontainer Kursus -->
            <div class="flex flex-col lg:flex-row bg-white shadow-lg overflow-hidden border rounded-xl">
                <!-- Bagian Langganan -->
                <div class="lg:w-2/3 w-full flex flex-col justify-center bg-white shadow-lg rounded-xl p-8 text-center">
                    <h2 class="md:text-2xl text-xl font-semibold text-gray-700 mb-2" data-aos="zoom-in">
                        Yuk Beli Kursusnya Sekarang Untuk Akses Materinya!
                    </h2>
                    <!-- Deskripsi -->
                    <p class="text-sm text-gray-700 mb-6 px-6 lg:px-20" data-aos="zoom-in">
                        Mari belajar di Eduflix dan mulai tingkatkan skillmu! Pilih kursus yang kamu butuhkan, 
                        pelajari kapan saja, di mana saja. Nikmati video pembelajaran terstruktur dan modul praktik interaktif yang dirancang oleh para ahli di bidangnya.
                    </p>
                    <!-- Button Langganan -->
                    <a href="/login">
                        <button class="bg-yellow-300 hover:bg-yellow-200 text-gray-700 font-semibold py-3 px-6 rounded-full text-md shadow-lg shadow-yellow-100 hover:shadow-none" data-aos="zoom-in">
                            Beli Sekarang
                        </button>
                    </a>                    
                </div>
                <!-- Informasi Kursus -->
                <div class="lg:w-1/3 w-full p-8" data-aos="zoom-in">
                    <div class="flex flex-col">
                        <!-- Materi Kursus -->
                        <div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-4">Materi</h3>
                            <ul class="divide-y divide-gray-200">
                                @foreach ($course->materi as $index => $materi)
                                    @php
                                        $firstVideo = $materi->videos->first(); // ambil video pertama
                                    @endphp
                                    <li class="flex items-center space-x-4 py-3">
                                        <!-- Icon -->
                                        <svg class="h-5 w-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                                            <path d="..."/>
                                        </svg>
                        
                                        <!-- Judul Materi -->
                                        @if ($materi->is_preview && $firstVideo)
                                            <button class="text-sm font-semibold text-blue-600 hover:underline capitalize open-video-btn"data-video-url="{{ asset('storage/' . $firstVideo->video_url) }}">
                                                {{ $index + 1 }}. {{ $materi->judul }}
                                            </button>
                                        @else
                                            <span class="text-sm font-semibold text-gray-700 capitalize">
                                                {{ $index + 1 }}. {{ $materi->judul }}
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fullscreen Modal -->
            <div id="videoModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center">
                <div class="relative w-full h-full">
                    <button 
                        onclick="closeModal()" 
                        class="absolute top-4 right-4 text-white text-2xl z-50 hover:text-red-500">
                        ✖
                    </button>
                    <video id="modalVideo" controls autoplay class="w-full h-full object-contain bg-black"></video>
                </div>
            </div>
            
            <script>
                // Buka modal
                document.querySelectorAll('.open-video-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const videoUrl = this.getAttribute('data-video-url');
                        const modal = document.getElementById('videoModal');
                        const video = document.getElementById('modalVideo');
            
                        video.src = videoUrl;
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    });
                });
            
                // Tutup modal
                function closeModal() {
                    const modal = document.getElementById('videoModal');
                    const video = document.getElementById('modalVideo');
            
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                    video.pause();
                    video.currentTime = 0;
                    video.src = '';
                }
            </script>
        </div>        
    </section>

    <!-- Informasi Kursus -->
    <section class="bg-white p-10">
        <a href="/">
            <button class="bg-sky-200 text-gray-600 py-2 px-4 rounded-full font-bold mb-6">
                Kembali
            </button>
        </a>        

        <div class="flex flex-col lg:flex-row mb-4">
            <div class="w-full lg:w-1/3 mb-4 lg:mb-0">
                <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-full h-auto">
            </div>
            <div class="ml-6 w-2/3 space-y-2">
                <h2 class="md:text-xl text-md font-semibold text-gray-700 capitalize mb-1 capitalize">{{ $course->title }}</h2>
                <p class="text-gray-700">{{ $course->description }}</p>
                <p class="text-gray-600 capitalize">Mentor : {{ $course->mentor->name }}</p>
                <p class="text-red-400 inline-flex items-center text-md rounded-xl font-semibold">Rp. {{ number_format($course->price, 0, ',', '.') }}</p>
            </div>
        </div>
        
        <div class="border-t mt-8 pt-6">
            <!-- Judul -->
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Yang Akan Didapatkan</h3>
            
            <!-- Daftar Button -->
            <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
                <button class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-3 rounded-lg text-sm shadow-lg shadow-blue-100 hover:shadow-none flex items-center space-x-2" data-aos="zoom-in-right">
                    <img class="w-6 h-6" style="filter: invert(1);" src="https://img.icons8.com/fluency-systems-regular/50/certificate--v1.png" alt="certificate--v1"/>
                    <span>Sertifikat</span>
                </button>
                <button class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-3 rounded-lg text-sm shadow-lg shadow-blue-100 hover:shadow-none flex items-center space-x-2" data-aos="zoom-in-right">
                    <img class="w-6 h-6" style="filter: invert(1);" src="https://img.icons8.com/ios-glyphs/30/last-24-hours.png" alt="last-24-hours"/>
                    <span>Akses Materi 24 Jam</span>
                </button>
                <button class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-3 rounded-lg text-sm shadow-lg shadow-blue-100 hover:shadow-none flex items-center space-x-2" data-aos="zoom-in-right">
                    <img class="w-6 h-6" style="filter: invert(1);" src="https://img.icons8.com/material-outlined/24/book.png" alt="book"/>
                    <span>Bahan Bacaan</span>
                </button>
                <button class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-3 rounded-lg text-sm shadow-lg shadow-blue-100 hover:shadow-none flex items-center space-x-2" data-aos="zoom-in-right">
                    <img class="w-6 h-6" style="filter: invert(1);" src="https://img.icons8.com/sf-black/64/cinema-.png" alt="cinema-"/>
                    <span>Video Pembelajaran</span>
                </button>
            </div>                     
        </div>        
        
        <div class="border-t mt-8 pt-6">
            <!-- Judul -->
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Rating Kursus</h3>
            
            <!-- Daftar Button -->
            <div class="flex items-center space-x-2 mt-4">
                @php
                    $filteredRatings = $ratings->filter(fn($rating) => $rating->display == 1);
                @endphp

                @if ($filteredRatings->isEmpty())
                    <p class="text-gray-500 w-full">Belum ada rating</p>
                @else
                    @foreach ($filteredRatings as $rating)
                        <div class="border border-gray-200 rounded-xl w-full md:w-1/2 lg:w-1/3 p-6 mt-6 mx-2 hover:shadow-lg transition-shadow duration-300 ease-in-out" data-aos="zoom-in-up">
                            <!-- Nama User -->
                            <h4 class="text-md font-semibold text-gray-800">{{ $rating->user->name }}</h4>
                        
                            <!-- Rating Bintang -->
                            <div class="flex items-center space-x-1 mb-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <span class="{{ $i < $rating->stars ? 'text-yellow-500' : 'text-gray-300' }}">&starf;</span>
                                @endfor
                            </div>
                        
                            <!-- Tanggal -->
                            <div class="flex items-center text-sm text-gray-500 space-x-2 mb-1">
                                <svg class="w-3 h-3 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor">
                                    <path d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 48L0 160l0-48C0 85.5 21.5 64 48 64l48 0 0-32c0-17.7 14.3-32 32-32zM0 192l448 0 0 272c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 192zm64 80l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zM64 400l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z" />
                                </svg>
                                <span class="text-xs">{{ \Carbon\Carbon::parse($rating->created_at)->format('d F Y') }}</span>
                            </div>
                        
                            <!-- Ulasan -->
                            <p class="text-gray-700 text-sm">"{{ $rating->comment }}"</p>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>       
    </section>

    @include('components.footer') <!-- Menambahkan Footer -->

     <!-- AOS JS -->
     <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
     <script>
         // Initialize AOS animation
         AOS.init({
             duration: 1000, 
             once: true,    
         });
     </script>

</body>
</html>
