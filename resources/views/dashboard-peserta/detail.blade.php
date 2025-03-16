@extends('layouts.dashboard-peserta')

@section('content')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-xl text-gray-700 font-semibold mb-6 border-b-2 border-gray-300 pb-2 text-center">Detail Kursus</h2>
    
    <!-- container detail kursus -->
    <div class="flex flex-col sm:flex-row mb-4 space-y-4 sm:space-y-0 sm:space-x-4">
        <div class="w-full sm:w-1/4 md:w-1/5">
            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-full h-auto">
        </div>
        <div class="w-full sm:w-2/3 space-y-1">
            @if(!empty($course->title))
                <h2 class="text-xl font-semibold text-gray-700 mb-2 capitalize">{{ $course->title }}</h2>
            @endif
        
            @if(!empty($course->description))
                <p class="text-gray-600 mb-2 text-md">{{ $course->description }}</p>
            @endif
        
            @if(!empty($course->mentor->name))
                <p class="text-gray-600 text-sm"><span>Mentor :</span> {{ $course->mentor->name }}</p>
            @endif
        
            @if(!empty($course->start_date))
                <p class="text-gray-600 text-sm"><span>Tanggal Mulai :</span> {{ $course->start_date }}</p>
            @endif
        
            @if(!empty($course->duration))
                <p class="text-gray-600 text-sm"><span>Masa aktif :</span> {{ $course->duration }}</p>
            @endif
        
            @if(!empty($course->price))
                <p class="text-red-500 inline-flex items-center text-sm rounded-xl font-semibold">
                    Rp. {{ number_format($course->price, 0, ',', '.') }}
                </p>
                {{-- @if(!$hasPurchased) <!-- Cek apakah kursus sudah dibeli -->
                <button class="bg-sky-300 text-white font-semibold px-4 py-2 rounded-lg hover:bg-sky-600" id="pay-now-{{ $course->id }}" data-course-id="{{ $course->id }}" data-course-price="{{ $course->price }}">
                    Beli Sekarang
                </button>
                @else
                <p class="text-red-500 mt-4">Anda sudah membeli kursus ini.</p>
                @endif --}}
            @endif
        </div>        
    </div>
    
    <!-- container materi kursus -->
    <div class="mt-10">
        <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">Materi Kursus</h3>
        <div class="space-y-6">
            @if($course->materi->isEmpty())
                <p class="text-gray-600 text-center">Belum ada materi</p>
            @else
            @foreach($course->materi as $materi)
            <div class="bg-neutral-50 p-4 rounded-lg shadow-md">
                <div x-data="{ open: false }">
                    <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                        <span class="text-gray-700 font-semibold mr-2">{{ sprintf('%02d', $loop->iteration) }}.</span>
                        <h4 class="text-lg font-semibold text-gray-700 flex-1 capitalize">{{ $materi->judul }}</h4>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 transition-transform duration-300 ease-in-out text-gray-600 hover:text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>

                    <div 
                        x-show="open"
                        x-transition:enter="transition ease-in-out duration-300 transform"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in-out duration-300 transform"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                        class="mt-2"
                    >
                        <p class="text-gray-600 mb-2">{{ $materi->deskripsi }}</p>

                        @if($materi->videos->count())
                        <div class="mt-4">
                            <h5 class="text-md font-semibold text-gray-700 flex items-center space-x-2 mb-2">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                                    <path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM188.3 147.1c7.6-4.2 16.8-4.1 24.3 .5l144 88c7.1 4.4 11.5 12.1 11.5 20.5s-4.4 16.1-11.5 20.5l-144 88c-7.4 4.5-16.7 4.7-24.3 .5s-12.3-12.2-12.3-20.9l0-176c0-8.7 4.7-16.7 12.3-20.9z" />
                                </svg>
                                <span>Video</span>
                            </h5>                            
                            <ul class="grid grid-cols-1 gap-4">
                                @foreach($materi->videos as $video)
                                    <li class="text-gray-700">
                                        <p>- {{ $video->judul }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @else
                        <p class="text-gray-600 mt-4">Belum ada video untuk materi ini.</p>
                        @endif

                        @if($materi->pdfs->count())
                        <div class="mt-4">
                            <h5 class="text-md font-semibold text-gray-700 flex items-center space-x-2 mb-2">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <path d="M64 464c-8.8 0-16-7.2-16-16L48 64c0-8.8 7.2-16 16-16l160 0 0 80c0 17.7 14.3 32 32 32l80 0 0 288c0 8.8-7.2 16-16 16L64 464zM64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-293.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0L64 0zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0z"/>
                                </svg>
                                <span>PDF</span>
                            </h5>                            
                            <ul class="grid grid-cols-1 gap-4">
                                @foreach($materi->pdfs as $pdf)
                                    <li class="text-gray-700">
                                        <p>- {{ $pdf->judul }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @else
                        <p class="text-gray-600 mt-4">Belum ada PDF untuk materi ini.</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

   <!-- Section Ulasan Pengguna -->
<div class="bg-white p-8 rounded-lg shadow-md mt-10">
    <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">Ulasan Pengguna</h3>
    <div class="space-y-6">
        <!-- Contoh Ulasan 1 -->
        <div class="bg-neutral-50 p-4 rounded-lg shadow-md flex space-x-4">
            <img src="https://via.placeholder.com/50" alt="User Profile" class="w-12 h-12 rounded-full object-cover">
            <div>
                <h4 class="text-md font-semibold text-gray-700">John Doe</h4>
                <div class="flex items-center text-yellow-400 text-sm mb-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.26 3.902a1 1 0 00.95.69h4.1c.969 0 1.371 1.24.588 1.81l-3.32 2.41a1 1 0 00-.364 1.118l1.26 3.902c.3.921-.755 1.688-1.54 1.118L10 14.347l-3.774 2.732c-.785.57-1.84-.197-1.54-1.118l1.26-3.902a1 1 0 00-.364-1.118L2.263 8.33c-.783-.57-.38-1.81.588-1.81h4.1a1 1 0 00.95-.69l1.148-3.902z" />
                    </svg>
                    <span class="ml-1">4.5</span>
                </div>
                <p class="text-gray-600">Kursus ini sangat membantu saya memahami dasar-dasar pemrograman.</p>
            </div>
        </div>
    </div>
</div>

    <div class="mt-6 flex justify-end">
        <a href="{{ route('categories-detail', ['id' => $category->id]) }}" class="bg-sky-400 text-white font-semibold py-1.5 px-5 rounded-lg hover:bg-sky-300">
            Kembali
        </a>           
    </div>
@endsection
