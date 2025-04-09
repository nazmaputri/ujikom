@extends('layouts.dashboard-peserta')
@section('content')
@if(session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
<div class="bg-white rounded-lg shadow-md p-5 w-full flex flex-col md:flex-row h-auto items-center">
    <div class="w-full text-center md:text-left mb-4 md:mb-0">
        <h1 class="text-xl font-semibold mb-4 text-gray-700">Selamat datang, {{ Auth::user()->name }}!</h1>
        <p class="mb-6 text-gray-600">
            Kami sangat senang Anda di sini. Di tempat ini, Anda dapat belajar, berbagi, dan terhubung dengan orang-orang yang memiliki minat yang sama.
            <br> Mari kita mulai perjalanan ini bersama-sama!
        </p>
    </div>
    <div class="md:w-1/4 flex justify-center md:justify-end">
        <img src="{{ asset('storage/buku.png') }}" alt="Welcome Image" class="w-full h-auto md:w-54"/>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md p-6 mt-7">
    <h2 class="text-xl font-semibold mb-5 text-gray-700 border-b-2 pb-2">Kursus Saya</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col">
                <!-- Image -->
                <img src="{{ asset('storage/' . $course->image_path) }}" alt="Kursus {{ $course->title }}" class="w-full h-40 object-cover rounded-t-lg">
    
                <!-- Course Content -->
                <div class="px-4 pt-4 pb-1 flex flex-col flex-grow">
                    <div class="flex justify-between items-center mb-2">
                        <!-- Course Title and Rating -->
                        <div>
                            <h3 class="text-md text-gray-700 font-semibold capitalize">{{ $course->title }}</h3>
                            <div class="flex">
                                <!-- Jumlah Rating -->
                                <span class="text-yellow-500 text-sm font-semibold mr-3">{{ number_format($course->average_rating, 1) }}</span>
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < floor($course->average_rating)) <!-- Rating Penuh -->
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                        </svg>
                                    @elseif ($i < ceil($course->average_rating)) <!-- Rating Setengah -->
                                        <svg class="w-4 h-4" viewBox="0 0 20 20">
                                            <defs>
                                                <linearGradient id="half-star-{{ $i }}">
                                                    <stop offset="50%" stop-color="rgb(234,179,8)" /> <!-- Kuning -->
                                                    <stop offset="50%" stop-color="rgb(209,213,219)" /> <!-- Abu-abu -->
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#half-star-{{ $i }})" d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                        </svg>
                                    @else <!-- Rating Kosong -->
                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                        </svg>
                                    @endif
                                @endfor
                            </div>                                                      
                        </div>
                    </div>
                    <!-- Progress Bar -->
                    <div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <!-- Progress dengan warna gradasi biru -->
                            <div class="h-4 rounded-full" style="width: {{ $course->progress }}%; background: linear-gradient(to right, #87CEEB, #4682B4);"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2 text-right">{{ $course->progress }}% completed</p>
                    </div>
                </div>
                <!-- Button -->
                <div class="p-2 mt-auto flex-col sm:flex-row justify-between gap-3">
                    <!-- Button Lanjut Belajar -->
                    <a href="{{ route('study-peserta', ['id' => $course->id]) }}" class="flex-1">
                        <button class="bg-yellow-200/50 mb-4 text-yellow-500 border border-yellow-300 w-full py-2 rounded-lg font-semibold flex items-center justify-center gap-2 hover:text-white hover:bg-yellow-300 transition-colors">
                            Belajar
                        </button>
                    </a>
                
                    <a href="{{ $course->isCompletedForCertificate ? route('certificate-detail', ['courseId' => $course->id]) : '#' }}" 
                        class="flex-1 {{ !$course->isCompletedForCertificate ? 'pointer-events-none' : '' }}">
                         <button class="w-full py-2 rounded-lg font-semibold flex items-center justify-center gap-2 
                             {{ !$course->isCompletedForCertificate ? 'bg-gray-400 text-gray-600 border-gray-600 cursor-not-allowed opacity-50' : 'bg-green-200/50 text-green-500 border border-green-300 hover:bg-green-300 hover:text-white transition-colors group' }}">
                             
                             <!-- SVG Icon with transition effects -->
                             <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" class="w-5 h-5 transition-all 
                                {{ !$course->isCompletedForCertificate ? 'grayscale opacity-50 cursor-not-allowed' : 'group-hover:fill-white fill-green-500' }}">
                                <path d="M 9.5 7 C 6.47 7 4 9.47 4 12.5 L 4 31.5 C 4 34.53 6.47 37 9.5 37 L 30 37 L 30 35.650391 C 28.75 34.110391 28 32.14 28 30 C 28 25.03 32.03 21 37 21 C 39.83 21 42.36 22.309375 44 24.359375 L 44 12.5 C 44 9.47 41.53 7 38.5 7 L 9.5 7 z M 13.5 15 L 34.5 15 C 35.33 15 36 15.67 36 16.5 C 36 17.33 35.33 18 34.5 18 L 13.5 18 C 12.67 18 12 17.33 12 16.5 C 12 15.67 12.67 15 13.5 15 z M 37 23 A 7 7 0 1 0 37 37 A 7 7 0 1 0 37 23 z M 13.5 26 L 22.5 26 C 23.33 26 24 26.67 24 27.5 C 24 28.33 23.33 29 22.5 29 L 13.5 29 C 12.67 29 12 28.33 12 27.5 C 12 26.67 12.67 26 13.5 26 z M 32 37.480469 L 32 43.980469 C 32 44.790469 32.910312 45.260781 33.570312 44.800781 L 36.429688 42.800781 C 36.769688 42.560781 37.230312 42.560781 37.570312 42.800781 L 40.429688 44.800781 C 41.089687 45.260781 42 44.790469 42 43.980469 L 42 37.480469 C 40.57 38.440469 38.85 39 37 39 C 35.15 39 33.43 38.440469 32 37.480469 z"></path>
                            </svg>
                             Sertifikat
                         </button>
                     </a>                            
                </div>                
            </div>
        @empty
            <div class="col-span-full">
                <p class="text-gray-600 text-center">Belum ada kursus yang diikuti.</p>
            </div>
        @endforelse
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
</script>
@endsection
