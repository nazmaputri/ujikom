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
                <p class="text-gray-600 mb-2 text-sm">{{ $course->description }}</p>
            @endif
        
            @if(!empty($course->mentor->name))
                <p class="text-gray-600 text-sm capitalize"><span>Mentor :</span> {{ $course->mentor->name }}</p>
            @endif
        
            @if(!empty($course->start_date))
                <p class="text-gray-600 text-sm"><span>Tanggal Mulai :</span>{{ \Carbon\Carbon::parse($course->start_date)->translatedFormat('d F Y') }}</p>
            @endif
        
            @if(!empty($course->duration))
                <p class="text-gray-600 text-sm"><span>Masa aktif :</span> {{ $course->duration }}</p>
            @endif

            @if(!empty($course->price))
                <div class="flex space-x-4">   
                    <p class="text-red-500 inline-flex items-center text-sm rounded-xl font-semibold">
                        Rp. {{ number_format($course->price, 0, ',', '.') }}
                    </p>
                    <div class="flex space-x-2 items-center text-center">
                    @if (!$hasPurchased)
                        <!-- Tombol Keranjang -->
                        <form action="{{ route('cart.add', ['id' => $course->id]) }}" method="POST" class="">
                            @csrf
                            <button type="submit" class="flex items-center p-1.5 space-x-2 text-white bg-red-400 rounded-md border hover:bg-red-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 576 512" class="w-4 h-4">
                                    <path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/>
                                </svg>
                                <span class="text-sm">Keranjang</span>
                            </button>
                        </form>
                    @else
                        <!-- Label Kursus Sudah Dibeli -->
                        <span class="text-sm text-green-700 bg-green-200 rounded-md px-4 cursor-not-allowed">
                            Sudah dibeli
                        </span>
                    @endif
                    </div>
                </div>
            @endif
        </div>        
    </div>
    
    <!-- container materi kursus -->
    <div class="mt-10">
        <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">Materi Kursus</h3>
        <div class="space-y-6">
            @if($course->materi->isEmpty())
                <p class="text-gray-600 text-center text-sm">Belum ada materi</p>
            @else
            @foreach($course->materi as $materi)
                <div class="bg-neutral-50 p-4 rounded-lg shadow-md">
                    <div x-data="{ open: false }">
                        <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                            <span class="text-gray-700 font-semibold mr-2 text-sm">{{ sprintf('%02d', $loop->iteration) }}.</span>
                            <h4 class="text-sm font-semibold text-gray-700 flex-1 capitalize">{{ $materi->judul }}</h4>
                            <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 transition-transform duration-300 ease-in-out text-gray-600 hover:text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <div 
                            x-show="open"
                            x-transition
                            class="mt-2"
                        >
                            <p class="text-gray-600 mb-2 text-sm">{{ $materi->deskripsi }}</p>

                            <ul class="space-y-1">
                                @foreach($materi->videos as $index => $video)
                                    <li class="text-sm text-gray-700">
                                        @if($course->is_purchased || ($loop->first && $materi->is_preview))
                                            <button onclick="openModal('modal-{{ $materi->id }}-{{ $index }}')" class="text-blue-600 font-semibold hover:underline">
                                                ▶ {{ $video->judul }}
                                            </button>

                                            <div id="modal-{{ $materi->id }}-{{ $index }}" class="fixed inset-0 hidden z-50 bg-black bg-opacity-75 flex items-center justify-center">
                                                <div class="relative w-full max-w-5xl p-4">
                                                    <video class="w-full h-auto" controls>
                                                        <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                                                    </video>
                                                    <button onclick="closeModal('modal-{{ $materi->id }}-{{ $index }}')" class="absolute top-2 right-2 text-white text-xl font-bold">&times;</button>
                                                </div>
                                            </div>
                                        @else
                                            🔒 <span class="text-gray-500">{{ $video->judul }} (Terkunci)</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                            <script>
                                function openModal(id) {
                                    document.getElementById(id).classList.remove('hidden');
                                    document.getElementById(id).classList.add('flex');
                                }

                                function closeModal(id) {
                                    const modal = document.getElementById(id);
                                    const video = modal.querySelector('video');
                                    video.pause();
                                    video.currentTime = 0;
                                    modal.classList.add('hidden');
                                    modal.classList.remove('flex');
                                }
                            </script>

                            {{-- PDF Section --}}
                            @if($materi->pdfs->count())
                                <div class="mt-4">
                                    <h5 class="text-sm font-semibold text-gray-700 flex items-center space-x-2 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                                            <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                        </svg>
                                        <span>PDF</span>
                                    </h5>

                                    <ul class="space-y-2">
                                        @foreach($materi->pdfs as $pdf)
                                            <li class="text-gray-700 text-sm">
                                                @if($course->is_purchased)
                                                    <p class="mb-1">{{ $pdf->judul }}</p>
                                                    <iframe src="{{ asset('storage/' . $pdf->pdf_file) }}#toolbar=0" width="100%" height="500px" class="border rounded" allow="fullscreen"></iframe>
                                                @else
                                                    🔒 <span class="text-gray-500">{{ $pdf->judul }} (Terkunci)</span>
                                                @endif
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

<!-- Modal Script -->
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const video = modal.querySelector('video');
        video.pause();
        video.currentTime = 0;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

</div>

<!-- Section Ulasan Pengguna -->
<div class="bg-white p-8 rounded-lg shadow-md mt-10">
    <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">Ulasan Pengguna</h3>
    <!-- card rating -->
    <div class="space-y-6">
    <!-- Jika tidak ada ulasan -->
    @if($rating->isEmpty())
        <p class="text-gray-500 text-center text-sm">Belum ada ulasan</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($rating as $rating)
                <div class="bg-neutral-50 p-4 rounded-lg shadow-md">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $rating->user->profile_photo ? asset('storage/' . $rating->user->profile_photo) : asset('storage/default-profile.jpg') }}" 
                            alt="User Profile" class="w-6 h-6 rounded-full object-cover">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700">{{ $rating->user->name }}</h4>
                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($rating->created_at)->format('d F Y') }}</span>
                        </div>
                    </div>
                    <!-- Rating Bintang -->
                    <div class="flex items-center space-x-1">
                        @for ($i = 0; $i < 5; $i++)
                            <span class="{{ $i < $rating->stars ? 'text-yellow-500' : 'text-gray-300' }}">&starf;</span>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm">{{ $rating->comment }}</p>
                </div>
            @endforeach
        </div>
    @endif
    </div>
</div>

    <div class="mt-6 flex justify-end">
        <a href="{{ route('categories-detail', ['id' => $category->id]) }}" class="bg-sky-400 text-white font-semibold py-1.5 px-5 rounded-lg hover:bg-sky-300">
            Kembali
        </a>           
    </div>
@endsection
