@extends('layouts.dashboard-admin')

@section('content')
<!-- Tambahkan Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Detail Kursus</h2>
    <!-- Card Informasi Kursus -->
    <div class="flex flex-col lg:flex-row mb-4">
        <div class="w-full lg:w-1/3 mb-4 lg:mb-0">
            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-80 h-35">
        </div>
        <!-- Informasi Kursus -->
        <div class="ml-4 w-2/3 md:ml-4 mt-1 space-y-1">
            <h2 class="text-md font-semibold text-gray-700 mb-2 capitalize">{{ $course->title }}</h2>
            <p class="text-gray-700 mb-2 text-sm">{{ $course->description }}</p>
            <p class="text-gray-600 text-sm">Mentor : <span class="capitalize">{{ $course->mentor->name }}<span></p>
            <p class="text-gray-600 text-sm">Harga : <span class="text-red-500">Rp {{ number_format($course->price, 0, ',', '.') }}</span></p>
            <p class="text-gray-600 text-sm">Kapasitas : {{ $course->capacity }} peserta</p> 
            <p class="text-gray-600 text-sm">Tanggal Mulai : {{ $course->start_date }}</p>
            <p class="text-gray-600 text-sm">Masa Aktif : {{ $course->duration }}</p>
        </div>
    </div>

    <!-- Silabus -->
    <div class="mt-10">
        <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">Materi Kursus</h3>
        <div class="space-y-6">
            @if($course->materi->isEmpty())
                <p class="text-gray-600 text-center mt-1 text-sm">Kursus ini belum ada materi apapun.</p>
            @else
            @foreach($course->materi as $materi)
            <div class="bg-neutral-50 p-4 rounded-lg shadow-md">
                <div x-data="{ open: false }">
                    <!-- Judul Materi dengan Toggle Dropdown -->
                    <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                        <!-- Menambahkan nomor urut di sebelah kiri judul -->
                        <span class="text-gray-700 font-semibold mr-2">
                            {{ sprintf('%02d', $loop->iteration) }}.
                        </span>
                        
                        <h4 class="text-md font-semibold text-gray-700 flex-1 capitalize">{{ $materi->judul }}</h4>
                                                
                        <!-- Tombol Toggle -->
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>

                    <!-- Deskripsi Materi -->
                    <p class="text-gray-600 mb-2 mt-2" x-show="open" x-transition>{{ $materi->deskripsi }}</p>

                    <!-- Video (Tampilkan hanya jika open adalah true) -->
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
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 list-none p-0">
                                @foreach($materi->videos as $video)
                                    <li class="text-gray-700">
                                        <p>{{ $video->judul }}</p>
                                        <!-- Menampilkan video dalam ukuran lebih kecil -->
                                        <video controls class="w-full h-full object-cover mt-2">
                                            <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                        </video>
                                    </li>
                                @endforeach
                                </ul>
                            </div>                                
                        @else
                            <p class="text-gray-600 mt-4">Belum ada video untuk materi ini.</p>
                        @endif
                    </div>

                    <!-- Materi PDF -->
                    <div x-show="open" x-transition>
                        @if($materi->pdfs->count())
                            <div class="mt-10">
                                <h5 class="text-md font-semibold text-gray-700 flex items-center space-x-2 mb-2">
                                    <!-- Icon -->
                                    <img width="30" height="30" src="https://img.icons8.com/pastel-glyph/128/file.png" alt="file" class="w-5 h-5"/>
                                    <span>PDF</span>
                                </h5>
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 list-none p-0">
                                @foreach($materi->pdfs as $file)
                                    <li class="text-gray-700">
                                        <p>{{ $file->judul }}</p>
                                        <iframe 
                                            src="{{ asset('storage/' . $file->pdf_file) }}" 
                                            class="w-full h-96 rounded-md mt-2" 
                                            frameborder="0">
                                        </iframe>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-gray-600 mt-4">Belum ada materi PDF untuk materi ini.</p>
                        @endif
                    </div>

                    <!-- Kuis -->
                    <div x-show="open" x-transition>
                        {{-- @if($materi->quizzes->count())
                        <div class="mt-4">
                            <h5 class="text-md font-semibold text-gray-800">📝 Kuis</h5>
                                <ul class="list-disc list-inside">
                                    @foreach($materi->quizzes as $quiz)
                                    <li>
                                    <a href="{{ route('quizzes.show', $quiz->id) }}" class="text-sky-400 hover:underline">
                                        {{ $quiz->title }}
                                    </a>
                                    </li>
                                    @endforeach
                                </ul>
                        </div>
                        @else
                            <p class="text-gray-600 mt-4">Belum ada kuis untuk materi ini.</p>
                                @endif --}}
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Tabel Peserta Terdaftar -->
    <div class="bg-white mt-6 p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4 inline-block pb-1 text-gray-700">Peserta Terdaftar</h3>
            <div class="overflow-x-auto">
                <div class="min-w-full w-64">
                <table class="min-w-full border-collapse" id="courseTable">
                    <thead>
                        <tr class="bg-sky-100 text-gray-700 text-sm">
                            <th class="py-2 px-2 border-b border-l border-t border-gray-200">No</th>
                            <th class="py-2 px-4 border-b border-t border-gray-200">Nama</th>
                            <th class="py-2 px-4 border-b border-t border-gray-200">Email</th>
                            <th class="py-2 border-b border-r border-t border-gray-200">Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($participants as $index => $participant)
                        <tr class="bg-white hover:bg-sky-50 user-row text-sm">
                            <td class="py-2 px-4 text-center text-gray-600 text-sm border-b border-l border-gray-200">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 text-gray-600 text-sm border-b border-gray-200">{{ $participant->user->name }}</td>
                            <td class="py-2 px-4 text-gray-600 text-sm border-b border-gray-200">{{ $participant->user->email }}</td>
                            <td class="py-2 text-center text-green-500 text-sm border-b border-r border-gray-200">{{ $participant->transaction_status }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-2 text-center text-sm text-gray-600 border-l border-b border-r border-gray-200">Belum ada peserta terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
                <div class="mt-4">
                    {{ $participants->links() }}
                </div>
            </div>
        <div class="mt-6 flex justify-end">
            {{-- <a href="{{ route('categories.show', $category->name) }}" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded">
                Kembali
            </a> --}}
        </div> 
    </div>
@endsection
