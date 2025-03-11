@extends('layouts.dashboard-peserta')

@section('content')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-xl text-gray-700 font-semibold mb-6 border-b-2 border-gray-300 pb-2">Detail Kursus</h2>
    <div class="flex flex-col sm:flex-row mb-4 space-y-4 sm:space-y-0 sm:space-x-4">
        <div class="w-full sm:w-1/3">
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
    
    <div class="mt-10">
        <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">Materi Kursus</h3>
        <div class="space-y-6">
            @if($course->materi->isEmpty())
                <p class="text-gray-600 text-center">Belum ada materi</p>
            @else
            @foreach($course->materi as $materi)
            <div class="bg-neutral-50 p-4 rounded-lg shadow-md">
                <div x-data="{ open: false }">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-semibold mr-2">{{ sprintf('%02d', $loop->iteration) }}.</span>
                        <h4 class="text-lg font-semibold text-gray-700 flex-1 capitalize">{{ $materi->judul }}</h4>
                        <button @click="open = ! open" class="text-gray-600 hover:text-gray-800">
                            <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
    
                    <p class="text-gray-600 mb-2 mt-2" x-show="open" x-transition>{{ $materi->deskripsi }}</p>
                    
                    <div x-show="open" x-transition>
                        @if($materi->videos->count())
                        <div class="mt-4">
                            <h5 class="text-md font-semibold text-gray-700 flex items-center space-x-2 mb-2">
                                <!-- Icon -->
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
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
                                <!-- Icon -->
                                <img width="30" height="30" src="https://img.icons8.com/pastel-glyph/128/file.png" alt="file" class="w-5 h-5"/>
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
                        <p class="text-gray-600 mt-4">Belum ada video untuk materi ini.</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="mt-6 flex justify-end">
        <a href="{{ route('categories-detail', ['id' => $category->id]) }}" class="bg-sky-400 text-white font-semibold py-1.5 px-5 rounded-lg hover:bg-sky-300">
            Kembali
        </a>           
    </div>
@endsection
