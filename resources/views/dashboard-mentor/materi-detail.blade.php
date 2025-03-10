@extends('layouts.dashboard-mentor')

@section('content')
<div class="container mx-auto">

  <!-- Card Wrapper -->
    <div class="bg-white p-6 rounded-lg shadow-md">

        <!-- Judul Halaman -->
        <h1 class="text-xl text-center text-gray-700 font-semibold mb-4 border-b-2 pb-2 capitalize">Detail Materi : {{ $materi->judul }}</h1>

        <!-- Detail Materi -->
        <p class="text-gray-700">{{ $materi->deskripsi ?? 'Tidak ada deskripsi' }}</p>

        <!-- Nama Kursus -->
        <p class="mt-2 text-gray-700"><span class="font-semibold">Kursus :</span> {{ $materi->course->title ?? 'Kursus tidak tersedia' }}</p>

        <!-- Video Materi -->
        @if($materi->videos->isNotEmpty())
        <div class="mt-6">
            <details class="mb-4">
                <summary class="cursor-pointer text-sky-400 mb-1 text-md">Lihat Video Materi</summary>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6"> <!-- Layout untuk dua video per baris -->
                    @foreach($materi->videos as $video)
                        <div class="border p-4 rounded-md shadow-md">
                            <h4 class="font-semibold text-gray-600 mb-2 capitalize">{{ $video->judul }}</h4>
                            <video controls class="w-full rounded-md shadow-md">
                                <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                        </div>
                    @endforeach
                </div>
            </details>
        </div>
        @else
        <p class="mt-4 text-gray-500">Tidak ada video materi yang tersedia.</p>
        @endif

        <!-- File Materi -->
        @if($materi->pdfs->isNotEmpty())
        <div class="mt-6">
            <details class="mb-4">
                <summary class="cursor-pointer text-sky-400 mb-1 text-md">Lihat File Materi</summary>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6"> <!-- Layout untuk dua file PDF per baris -->
                    @foreach($materi->pdfs as $file)
                        <div class="border p-4 rounded-md shadow-md">
                            <h4 class="font-semibold text-gray-700 mb-2 capitalize">{{ $file->judul }}</h4>
                            <iframe 
                                src="{{ asset('storage/' . $file->pdf_file) }}" 
                                class="w-full h-96 rounded-md" 
                                frameborder="0">
                            </iframe>
                        </div>
                    @endforeach
                </div>
            </details>
        </div>
        @else
        <p class="mt-4 text-gray-500">Tidak ada file materi yang tersedia.</p>
        @endif

        <!-- Video YouTube Materi -->
        @if($materi->youtubes->isNotEmpty())
        <div class="mt-6">
            <details class="mb-4">
                <summary class="cursor-pointer text-sky-400 mb-4">Lihat Video YouTube</summary>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6"> <!-- Layout untuk dua video per baris -->
                    @foreach($materi->youtubes as $youtube)
                        <div class="border p-4 rounded-md shadow-md">
                            <h4 class="font-semibold mb-2 capitalize">{{ $youtube->judul }}</h4>
                            <div class="relative" style="padding-top: 56.25%;"> <!-- Aspect ratio 16:9 -->
                                <iframe src="https://www.youtube.com/embed/{{ basename($youtube->link_youtube) }}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen 
                                        class="absolute top-0 left-0 w-full h-full rounded-md shadow-md">
                                </iframe>
                            </div>
                        </div>
                    @endforeach
                </div>
            </details>
        </div>
        @else
        <p class="mt-4 text-gray-500">Tidak ada video YouTube yang tersedia.</p>
        @endif
    </div>


    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <h2 class="text-xl text-gray-700 font-semibold mb-2 border-b-2 pb-2">Kuis</h2>

        <div class="text-right p-1 ">
            @php
                // Ambil jumlah kuis yang sudah ditambahkan untuk materi ini
                $quizCount = App\Models\Quiz::where('materi_id', $materiId)->count();
            @endphp
            
            <a href="{{ $quizCount < 1 ? route('quiz.create', ['courseId' => $courseId, 'materiId' => $materiId]) : '#' }}" 
            class="inline-flex items-center space-x-2 text-white 
            {{ $quizCount >= 1 ? 'bg-sky-300 cursor-not-allowed shadow-none' : 'bg-sky-300 shadow-md shadow-sky-100 hover:shadow-none hover:bg-sky-600' }} 
            font-bold py-2 px-4 rounded-md"
            @if($quizCount >= 1) onclick="return false;" @endif>
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                </svg>
                <span>Tambah Kuis</span>
            </a>          
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden overflow-x-auto w-full">
            <table class="min-w-full mt-4">
                <thead>
                    <tr class="bg-sky-200 text-gray-600 text-sm">
                        <th class="px-2 py-2">No</th>
                        <th class="px-4 py-2">Judul</th>
                        <th class="px-4 py-2">Durasi</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startNumber = ($quizzes->currentPage() - 1) * $quizzes->perPage() + 1;
                    @endphp
                    @foreach($quizzes as $index => $quiz)
                        <tr class="bg-white hover:bg-sky-50 user-row text-sm text-gray-600">
                            <td class="px-2 py-2 text-center">{{ $startNumber + $index }}</td>
                            <td class="px-4 py-2">{{ $quiz->title }}</td>
                            <td class="px-4 py-2">{{ $quiz->duration }} menit</td>
                            <td class="px-4 py-2">
                                <div class="flex items-center justify-center space-x-6">
                                    <a href="{{ route('quiz.detail',  ['courseId' => $courseId, 'materiId' => $materiId, $quiz->id]) }}" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('quiz.edit',  ['courseId' => $courseId, 'materiId' => $materiId, $quiz->id]) }}" class="text-white bg-yellow-300 p-1 rounded-md hover:bg-yellow-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <button type="button" class="text-white bg-red-400 p-1 rounded-md hover:bg-red-300" 
                                            onclick="openDeleteModal('{{ route('quiz.destroy', ['courseId' => $courseId, 'materiId' => $materiId, $quiz->id]) }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                    <!-- Modal Konfirmasi Hapus -->
                                    <div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 z-10 flex justify-center items-center hidden">
                                        <div class="bg-white p-5 rounded-md w-full max-w-md text-center">
                                            <p class="text-lg font-semibold mb-6">Apakah Anda yakin ingin menghapus kuis ini?</p>
                                            <button onclick="closeDeleteModal()" class="bg-sky-400 font-semibold px-6 py-2 text-white rounded-md hover:bg-sky-300 mr-3">Batal</button>
                                            <form id="confirmDeleteForm" action="" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-400 font-semibold text-white px-6 py-2 rounded-md hover:bg-red-300">Ya</button>
                                            </form>
                                        </div>
                                    </div>
                                    <script>
                                        // Fungsi untuk membuka modal dan menetapkan action pada form
                                        function openDeleteModal(actionUrl) {
                                            const modal = document.getElementById('deleteModal');
                                            const confirmForm = document.getElementById('confirmDeleteForm');
                                            confirmForm.action = actionUrl; // Set action form dengan URL yang diberikan
                                            modal.classList.remove('hidden'); // Tampilkan modal
                                        }

                                        // Fungsi untuk menutup modal
                                        function closeDeleteModal() {
                                            const modal = document.getElementById('deleteModal');
                                            modal.classList.add('hidden'); // Sembunyikan modal
                                        }
                                    </script>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if ($quizzes->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-4">Belum ada Kuis untuk Materi ini.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $quizzes->links() }}
        </div>
        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('courses.show', $course->id) }}" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded">
                Kembali
            </a>
        </div>      
    </div>
</div>
@endsection
