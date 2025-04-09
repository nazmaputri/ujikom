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
            <details class="mb-2">
                <summary class="cursor-pointer text-sky-400 mb-1 text-sm">Lihat Video Materi</summary>
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
        <p class="mt-4 text-gray-500 text-sm">Tidak ada video materi yang tersedia.</p>
        @endif

        <!-- File Materi -->
        @if($materi->pdfs->isNotEmpty())
        <div class="mt-2">
            <details class="mb-2">
                <summary class="cursor-pointer text-sky-400 mb-1 text-sm">Lihat File Materi</summary>
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
        <p class="mt-4 text-gray-500 text-sm">Tidak ada video YouTube yang tersedia.</p>
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
            {{ $quizCount >= 1 ? 'bg-gray-300 cursor-not-allowed shadow-none' : 'bg-sky-400 shadow-md shadow-sky-100 hover:shadow-none hover:bg-sky-300' }} 
            font-bold py-2 px-4 rounded-md"
            @if($quizCount >= 1) onclick="return false;" @endif>
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                </svg>
                <span>Tambah Kuis</span>
            </a>          
        </div>

        @if (session('success'))
            <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-3 mt-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- tabel -->
        <div class="overflow-hidden overflow-x-auto w-full">
            <div class="min-w-full w-64">
                <table class="min-w-full mt-4 border-collapse">
                    <thead>
                        <tr class="bg-sky-200 text-gray-600 text-sm">
                            <th class="px-2 py-2 border-b border-l border-gray-200">No</th>
                            <th class="px-4 py-2 border-b border-gray-200">Judul</th>
                            <th class="px-4 py-2 border-b border-gray-200">Durasi</th>
                            <th class="px-4 py-2 border-b border-r border-gray-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startNumber = ($quizzes->currentPage() - 1) * $quizzes->perPage() + 1;
                        @endphp
                        @foreach($quizzes as $index => $quiz)
                            <tr class="bg-white hover:bg-sky-50 user-row text-sm text-gray-600">
                                <td class="px-2 py-2 text-center border-b border-l  border-gray-200">{{ $startNumber + $index }}</td>
                                <td class="px-4 py-2 text-center border-b border-gray-200">{{ $quiz->title }}</td>
                                <td class="px-4 py-2 text-center border-b border-gray-200">{{ $quiz->duration }} menit</td>
                                <td class="px-4 py-2 border-b  border-r border-gray-200">
                                    <div class="flex items-center justify-center space-x-6">
                                        <a href="{{ route('quiz.detail',  ['course' => $course, 'materi' => $materi, $quiz->id]) }}" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('quiz-edit',  ['courseId' => $courseId, 'materiId' => $materiId, $quiz->id]) }}" class="text-white bg-yellow-300 p-1 rounded-md hover:bg-yellow-200" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <button type="button" class="text-white bg-red-400 p-1 rounded-md hover:bg-red-300" 
                                                onclick="openDeleteModal('{{ route('quiz.destroy', ['courseId' => $courseId, 'materiId' => $materiId, $quiz->id]) }}')" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($quizzes->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center py-4 text-sm text-gray-600 border-b border-l border-r border-gray-200">Belum ada kuis untuk materi ini.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
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

<!-- Modal Popup -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-[1000]">
    <div class="bg-white p-5 rounded-lg shadow-lg w-96 mx-4">
        <h2 class="text-lg text-gray-700 text-center font-semibold mb-2">Konfirmasi Hapus</h2>
        <p class="text-gray-600 text-center mb-4">Apakah Anda yakin ingin menghapus kuis ini?</p>
        <div class="flex justify-center space-x-2">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-sky-400 text-white hover:bg-sky-300 rounded-md">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-400 hover:bg-red-300  text-white rounded-md">Hapus</button>
            </form>
        </div>
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

    //untuk membuka/menutup popup konfirmasi penghapusa data
    function openDeleteModal(url) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>

@endsection
