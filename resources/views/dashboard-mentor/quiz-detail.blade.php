@extends('layouts.dashboard-mentor')

@section('content')
<div class="container mx-auto">

    <!-- Card Wrapper untuk Kuis -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <!-- Judul Kuis -->
        <h1 class="text-xl text-gray-700 text-center font-semibold mb-3 border-b-2 pb-2 capitalize">{{ $quiz->title }}</h1>

        <!-- Deskripsi Kuis -->
        <p class="text-gray-700 mb-2 text-md">
            {{ $quiz->description ?? 'Tidak ada deskripsi untuk kuis ini.' }}
        </p>

        <!-- Durasi Kuis -->
        <p class="text-gray-600 mb-6 text-sm">
            <strong>Durasi :</strong> {{ $quiz->duration }} Menit
        </p>

        <!-- Daftar Soal -->
        @if($quiz->questions->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
            @foreach($quiz->questions as $index => $question)
            <!-- Card untuk Setiap Soal -->
            <div class="bg-gray-50 border rounded-lg p-4 shadow-md text-sm">
                <div class="flex items-start">
                    <!-- Nomor Soal -->
                    <span class="text-sm text-gray-700 font-semibold mr-2">{{ $index + 1 }}.</span>
                    
                    <!-- Pertanyaan -->
                    <p class="text-sm font-medium text-gray-700 flex-1 capitalize">{{ $question->question }}</p>
                </div>

                <!-- Jawaban Tersembunyi dengan Dropdown -->
                <details class="mt-4">
                    <summary class="cursor-pointer text-sky-400">Lihat Jawaban</summary>
                    <ul class="list-none mt-2 space-y-2">
                        @foreach($question->answers as $answer)
                        <li class="p-2 border rounded-md {{ $answer->is_correct ? 'bg-green-100 text-green-700 font-semibold' : 'bg-gray-100 text-gray-600' }}">
                            {{ $answer->answer }}
                        </li>
                        @endforeach
                    </ul>
                </details>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500">Belum ada soal yang ditambahkan untuk kuis ini.</p>
        @endif

        <!-- Tombol Kembali -->
        <div class="mt-6 justify-end flex">
            @if(isset($materiId))
                {{-- Jika sedang membuat kuis biasa --}}
                <a href="{{ route('materi.show', ['courseId' => $course->id, 'materiId' => $materi->id]) }}"
                class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded-lg">
                    Kembali
                </a>
            @else
                {{-- Jika sedang membuat tugas akhir --}}
                <a href="{{ route('courses.show', ['course' => $course->id]) }}"
                class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded-lg">
                    Kembali
                </a>
            @endif
        </div>
    </div>

</div>
@endsection
