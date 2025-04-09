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
    <!-- AlphineJs -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
     <!-- Custom Style -->
     <style>
        body {
            font-family: "Quicksand", sans-serif !important;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body>
    @include('components.navbar') 
    
    <section id="promo" class="bg-red-600 text-white px-4 py-2 text-center pt-[90px] fixed w-full z-40">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 pb-3 mx-14">
            <!-- Promo text -->
            <div class="text-sm sm:text-base font-semibold">
            APRIL SMART DEALS DISKON 30%! <br class="md:hidden" />
            <span class="font-normal">Cuma Sampai 11 April 2025!</span>
            </div>

            <!-- Countdown -->
            <div class="flex items-center gap-2 text-sm sm:text-base font-bold">
            <span>03<span class="text-xs font-normal ml-1">Hari</span></span>
            <span>09<span class="text-xs font-normal ml-1">Jam</span></span>
            <span>45<span class="text-xs font-normal ml-1">Menit</span></span>
            <span>02<span class="text-xs font-normal ml-1">Detik</span></span>
            </div>

            <!-- Kode Promo -->
            <div class="flex items-center gap-2">
            <button class="bg-white text-red-600 font-bold px-3 py-1 rounded hover:bg-gray-100 text-sm">
                APRILDEALS
            </button>
            <button class="bg-sky-500 text-white font-semibold px-3 py-1 rounded hover:bg-sky-400 text-sm">
                SALIN
            </button>
            </div>
        </div>
    </section>

    <!-- NANTI TAMBAHKAN LOGIKA UNTUK MT SECTION COURSE (engechekan kondisi dimana jika section promo ada/tidak agar mt nya pass)-->
    <!-- Bagian Materi Kursus -->
    <section id="course" class="py-12 bg-sky-50">
        <div class="container mx-auto px-6 lg:px-8 md:mt-32 mt-64">
            <!-- Kontainer Kursus -->
            <div class="flex flex-col lg:flex-row bg-white shadow-lg overflow-hidden border rounded-xl">
                <!-- Detail Kursus -->
                <div class="lg:w-2/3 w-full flex flex-col rounded-xl p-8 text-left">
                    <div>
                        <h2 class="md:text-xl text-md font-semibold text-gray-700 capitalize mb-1 capitalize">{{ $course->title }}</h2>
                        <p class="text-gray-700">{{ $course->description }}</p>
                        <p class="text-gray-600 capitalize">Mentor : {{ $course->mentor->name }}</p>
                        <h3 class="text-xl font-semibold text-gray-700 my-2 text-left">Materi</h3>
                        <ul class="divide-y divide-gray-200">
                            @foreach ($course->materi as $index => $materi)
                                <li class="flex items-center space-x-4 py-2">
                                    <!-- Icon -->
                                    <svg class="h-5 w-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                                        <path d="..." />
                                    </svg>
                                    <!-- Judul Materi -->
                                    <span class="text-sm font-semibold text-gray-700 capitalize">
                                        {{ $index + 1 }}. {{ $materi->judul }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="/">
                            <button class="bg-sky-300 hover:bg-sky-200 text-gray-700 py-2 px-4 rounded-full font-semibold mt-6">
                                Kembali
                            </button>
                        </a>
                    </div>
                </div>

               <!-- Trailer dan keranjang -->
                <div class="lg:w-1/3 w-full p-6 bg-white border border-gray-300 rounded-lg shadow-md" data-aos="zoom-in">
                    <!-- Cuplikan Video Pembelajaran -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Cuplikan Video Pembelajaran</h3>
                        @foreach ($course->materi as $materi)
                            @php
                                $firstVideo = $materi->videos->first();
                            @endphp

                            @if ($materi->is_preview && $firstVideo)
                                <div class="mb-6">
                                    <video controls class="w-full rounded-lg shadow">
                                        <source src="{{ asset('storage/' . $firstVideo->video_url) }}" type="video/mp4">
                                        Browser tidak mendukung pemutar video.
                                    </video>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Header 3 Teks Sejajar -->
                    <div class="flex space-x-1 items-center mb-4">
                        <span class="font-semibold text-2xl text-gray-700">Rp.99.000</span>
                        <span class="text-sm font-medium text-gray-600 line-through">Rp. 250.000</span>
                        <span class="text-sm font-medium text-gray-600">Potongan 85%!</span>
                    </div>

                    <!-- Deskripsi atau Teks di bawah 3 baris -->
                    <div class="flex items-center space-x-1 text-red-500 text-sm mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>
                            Diskon berlaku <span class="font-semibold">4 Hari lagi!</span>
                        </span>
                    </div>

                    <!-- Dua Tombol Vertikal -->
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('beli.kursus', ['id' => $course->id]) }}">
                            <button class="w-full bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded-lg">
                                Tambah Ke Keranjang
                            </button>
                        </a>
                        <a href="#">
                            <button class="w-full bg-transparent border border-sky-300 hover:border-sky-200 text-sky-400 hover:bg-sky-100 hover:text-sky-500 font-semibold py-2 px-4 rounded-lg">
                                Beli Sekarang
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>        
    </section>

    <!-- Informasi Kursus -->
    <section class="bg-white p-10">        
        <div class="flex items-center justify-center px-4">
            <div class="w-full text-center">
                <h2 class="text-2xl font-semibold text-gray-700 mb-2" data-aos="zoom-in">
                    Yuk Beli Kursusnya Sekarang Untuk Akses Materinya!
                </h2>
                <!-- Deskripsi -->
                <p class="text-gray-700 mb-6 px-6 lg:px-20" data-aos="zoom-in">
                    Mari belajar di Eduflix dan mulai tingkatkan skillmu! Pilih kursus yang kamu butuhkan, 
                    pelajari kapan saja, di mana saja. Nikmati video pembelajaran terstruktur dan modul praktik interaktif yang dirancang oleh para ahli di bidangnya.
                </p>
                <!-- Button Beli Sekarang -->
                <a href="{{ route('beli.kursus', ['id' => $course->id]) }}">
                    <button class="bg-yellow-300 hover:bg-yellow-200 text-gray-700 font-semibold py-3 px-6 rounded-full text-md shadow-lg shadow-yellow-100 hover:shadow-none" data-aos="zoom-in">
                        Beli Sekarang
                    </button>
                </a>

                <!-- Pop-up Error jika sudah dibeli -->
                @if(session('error'))
                    <div id="popupError" class="fixed top-5 right-5 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce">
                        {{ session('error') }}
                    </div>

                    <script>
                        // Hilangkan popup setelah 3 detik
                        setTimeout(function() {
                            const popup = document.getElementById('popupError');
                            if (popup) popup.remove();
                        }, 3000);
                    </script>
                @endif
            </div>
        </div>       
        
        <div class="mt-8 pt-6 px-6 lg:px-8 md:space-y-6 space-y-3">
            <div class="">
                <!-- Judul -->
                <h3 class="text-xl font-semibold text-gray-700 my-4">Yang Akan Didapatkan</h3>
                                
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
                    <button class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-3 rounded-lg text-sm shadow-lg shadow-blue-100 hover:shadow-none flex items-center space-x-2" data-aos="zoom-in-right">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                        </svg>
                        <span>Latihan Soal</span>
                    </button>
                </div>                     
            </div> 

            <h3 class="text-xl font-semibold text-gray-700">Rating Kursus</h3>

            @php
                $filteredRatings = $ratings->filter(fn($rating) => $rating->display == 1);
            @endphp

            @if ($filteredRatings->isEmpty())
                <p class="text-gray-500 mt-2">Belum ada rating</p>
            @else
                <div 
                    x-data="{
                        scrollEl: null,
                        scrollAmount: 320,
                        autoScrollInterval: null,
                        init() {
                            this.scrollEl = this.$refs.slider;
                            this.startAutoScroll();
                        },
                        scrollLeft() {
                            this.scrollEl.scrollBy({ left: -this.scrollAmount, behavior: 'smooth' });
                        },
                        scrollRight() {
                            this.scrollEl.scrollBy({ left: this.scrollAmount, behavior: 'smooth' });
                        },
                        startAutoScroll() {
                            this.autoScrollInterval = setInterval(() => this.scrollRight(), 3000);
                        },
                        stopAutoScroll() {
                            clearInterval(this.autoScrollInterval);
                        }
                    }"
                    x-init="init()"
                    class="relative mt-4"
                >
                    <!-- Tombol Kiri -->
                    <button @click="scrollLeft" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-gray-50 text-gray-700 p-2 rounded-full shadow hover:bg-gray-100">
                        &#8592;
                    </button>

                    <!-- Slider -->
                    <div 
                        x-ref="slider"
                        @mouseover="stopAutoScroll()"
                        @mouseout="startAutoScroll()"
                        class="flex overflow-x-auto no-scrollbar scroll-smooth space-x-4 px-8"
                    >
                        @foreach ($filteredRatings as $rating)
                        <div class="min-w-[300px] max-w-[300px] h-[150px] flex-shrink-0 border border-gray-200 rounded-xl p-4 hover:shadow-lg transition-shadow duration-300 ease-in-out" data-aos="zoom-in-up">
                            <!-- Nama, Foto & Tanggal -->
                            <div class="flex items-center space-x-2">
                                <img src="{{ asset('storage/default-profile.jpg') }}" alt="Foto Profil" class="w-6 h-6 rounded-full object-cover">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800">{{ $rating->user->name }}</h4>
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($rating->created_at)->format('d F Y') }}</span>
                                </div>
                            </div>

                            <!-- Rating Bintang -->
                            <div class="flex items-center space-x-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <span class="{{ $i < $rating->stars ? 'text-yellow-500' : 'text-gray-300' }}">&starf;</span>
                                @endfor
                            </div>

                            <!-- Komentar -->
                            <p class="text-gray-700 text-sm overflow-hidden text-ellipsis line-clamp-3">
                                {{ $rating->comment }}
                            </p>
                            </div>

                                @endforeach
                            </div>

                            <!-- Tombol Kanan -->
                            <button @click="scrollRight" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-gray-50 text-gray-700 p-2 rounded-full shadow hover:bg-gray-100">
                                &#8594;
                            </button>
                        </div>
                    @endif
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
