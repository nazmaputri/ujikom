@extends('layouts.dashboard-admin')

@section('content')
<!-- Tambahkan Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Detail Kursus</h2>
    <!-- Card Informasi Kursus -->
    <div class="flex mb-4">
        <!-- Thumbnail Kursus -->
        <div class="w-1/3">
            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-full h-auto">
        </div>
        <!-- Informasi Kursus -->
        <div class="ml-4 w-2/3 space-y-1">
            <h2 class="text-md font-semibold text-gray-700 mb-2 capitalize">{{ $course->title }}</h2>
            <p class="text-gray-700 mb-2 text-md">{{ $course->description }}</p>
            <p class="text-gray-600 text-sm">Mentor : {{ $course->mentor->name }}</p>
            <p class="text-gray-600 text-sm">Biaya : Rp {{ number_format($course->price, 0, ',', '.') }}</p>
            <p class="text-gray-600 text-sm">Kapasitas : {{ $course->capacity }} peserta</p> 
            <p class="text-gray-600 text-sm">Tanggal Mulai : {{ $course->start_date }}</p>
            <p class="text-gray-600 text-sm">Masa Aktif : {{ $course->duration }}</p>
        </div>
    </div>

    <!-- Silabus -->
    <div class="mt-10">
        <h3 class="text-xl font-semibold mb-4 inline-block pb-1 text-gray-700">Materi Kursus</h3>
        <div class="space-y-6">
            @foreach($course->materi as $materi)
            <div class="bg-neutral-50 p-4 rounded-lg shadow-md">
                <div x-data="{ open: false }">
                    <!-- Judul Materi dengan Toggle Dropdown -->
                    <div class="flex justify-between items-center">
                    <!-- Menambahkan nomor urut di sebelah kiri judul -->
                        <span class="text-gray-700 font-semibold mr-2">
                            {{ sprintf('%02d', $loop->iteration) }}.
                        </span>
                        <h4 class="text-lg font-semibold text-gray-700 flex-1 capitalize">{{ $materi->judul }}</h4>
                                
                        <!-- Tombol Toggle -->
                        <button @click="open = ! open" class="text-gray-600 hover:text-gray-800">
                            <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
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
        </div>
    </div>

    <!-- Tabel Peserta Terdaftar -->
    <div class="mt-6">
        <h3 class="text-xl font-semibold mb-4 inline-block pb-1 text-gray-700">Peserta Terdaftar</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full" id="courseTable">
                    <thead>
                        <tr class="bg-sky-100 text-gray-700">
                            <th class="py-2 px-2">No</th>
                            <th class="py-2 px-4">Nama Peserta</th>
                            <th class="py-2 px-4">Email</th>
                            <th class="py-2">Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($participants as $index => $participant)
                        <tr class="bg-white hover:bg-sky-50 user-row">
                            <td class="py-2 px-4 text-center text-gray-600 text-sm">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 text-gray-600 text-sm">{{ $participant->user->name }}</td>
                            <td class="py-2 px-4 text-gray-600 text-sm">{{ $participant->user->email }}</td>
                            <td class="py-2 text-center text-green-500 text-sm">{{ $participant->transaction_status }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">Belum ada peserta terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $participants->links() }}
                </div>
            </div>
        <div class="mt-6 flex justify-end">
            <a href="{{ route('categories.show', $category->name) }}" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded">
                Kembali
            </a>
        </div> 
    </div>
</div>
    
@endsection
