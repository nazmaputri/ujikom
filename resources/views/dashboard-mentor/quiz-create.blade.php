@extends('layouts.dashboard-mentor')

@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Judul Halaman -->
        <h2 class="text-xl font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Tambah Kuis</h2>

        {{-- @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <!-- Form Tambah Kuis -->
        <form action="{{ isset($materiId) ? route('quiz.store', ['courseId' => $courseId, 'materiId' => $materiId]): route('final-task.store', ['courseId' => $courseId]) }}" method="POST" class="space-y-6">    
    @csrf
    <!-- Input untuk Judul Kuis -->
     <div>
        <label for="title" class="block text-gray-700 font-bold mb-2">Judul Kuis</label>
        <input type="text" name="title" id="title" class="w-full p-2 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 text-gray-600 @error('title') border-red-500 @enderror" placeholder="Masukkan judul kuis" value="{{ old('title') }}">
        @error('title')
            <div class="text-red-600 text-sm mt-1 error-message" id="error-title">{{ $message }}</div>
        @enderror
    </div>

    <!-- Input untuk Deskripsi Kuis -->
    <div>
        <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
        <textarea name="description" id="description" rows="5" class="w-full p-2 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 text-gray-600 @error('description') border-red-500 @enderror" placeholder="Masukkan deskripsi kuis">{{ old('description') }}</textarea>
        @error('description')
            <div class="text-red-600 text-sm mt-1 error-message" id="error-description">{{ $message }}</div>
        @enderror
    </div>

    <!-- Input untuk Waktu Pengerjaan Kuis -->
    <div>
        <label for="duration" class="block text-gray-700 font-bold mb-2">Durasi (menit)</label>
        <input type="number" name="duration" id="duration" class="w-full p-2 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 text-gray-600 @error('duration') border-red-500 @enderror" placeholder="Masukkan durasi kuis (menit)" value="{{ old('duration') }}" min="1">
        @error('duration')
            <div class="text-red-600 text-sm mt-1 error-message" id="error-duration">{{ $message }}</div>
        @enderror
    </div>
    <!-- Daftar Soal Dinamis -->
    <div id="questions-container">
        <h3 class="text-md font-semibold mb-1 text-gray-700">Soal dan Jawaban</h3>

        <!-- Soal Template (untuk cloning) -->
        <template id="question-template">
            <div class="question-item border p-4 mb-4 rounded bg-gray-50">
                <!-- Menampilkan Nomor Soal -->
                <div class="mb-3">
                    <span class="text-md text-gray-700 font-semibold">Soal <span class="question-number"></span></span>
                </div>

                <!-- Input Pertanyaan -->
                <div class="mb-3">
                    <label class="block text-gray-700 font-semibold mb-2">Soal</label>
                    <input type="text" name="questions[0][question]" class="w-full p-2 border rounded question-input focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 text-gray-600" placeholder="Masukkan teks soal" value="{{ old('questions.0.question') }}" >
                    @error('questions.*.question')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Jawaban Pilihan Ganda -->
                <div class="answers-container">
                    <label class="block text-gray-700 font-semibold mb-2">Jawaban Pilihan Ganda</label>
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center mb-2">
                            <input type="radio" name="questions[0][correct_answer]" value="{{ $i }}" class="mr-2 answer-radio" >
                            <input type="text" name="questions[0][answers][]" class="w-full text-gray-600 p-2 border focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 rounded answer-input" placeholder="Masukkan jawaban" value="{{ old('questions.0.answers.' . $i) }}" >
                            @error('questions.*.answers.*')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @endfor
                </div>

                <!-- Tombol Hapus Soal -->
                <button type="button" onclick="removeQuestion(this)" class="text-red-600 hover:text-red-800 font-semibold mt-2">Hapus Soal</button>
            </div>
        </template>

        <!-- Container untuk Soal-soal -->
        <div id="question-list"></div>

        <!-- Tombol Tambah Soal -->
        <button type="button" onclick="addQuestion()" class="mt-1 bg-green-400 hover:bg-green-300 text-white font-bold py-2 px-4 rounded">
            Tambah Soal
        </button>
    </div>

    <!-- Tombol Submit -->
    <div class="mt-6 flex justify-end space-x-2">
        @if(isset($materiId))
            {{-- Jika sedang membuat kuis biasa --}}
            <a href="{{ route('materi.show', ['courseId' => $course->id, 'materiId' => $materi->id]) }}"
            class="bg-red-400 hover:bg-red-300 text-white font-semibold py-2 px-4 rounded-lg">
                Batal
            </a>
        @else
            {{-- Jika sedang membuat tugas akhir --}}
            <a href="{{ route('courses.show', ['course' => $course->id]) }}"
            class="bg-red-400 hover:bg-red-300 text-white font-semibold py-2 px-4 rounded-lg">
                Batal
            </a>
        @endif    
        <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded-lg">
            Simpan
        </button>
    </div>
</form>

        
    </div>
</div>

<script>
// Fungsi untuk menghapus pesan error dan border merah saat pengguna mulai mengetik
    document.addEventListener('DOMContentLoaded', function () {
        // Mengambil semua input dan textarea yang memiliki error
        const inputs = document.querySelectorAll('input, textarea');
        
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                // Hapus border merah dan pesan error ketika pengguna mulai mengetik
                if (this.classList.contains('border-red-500')) {
                    this.classList.remove('border-red-500');
                }
                const errorMessage = document.querySelector(`#error-${this.id}`);
                if (errorMessage) {
                    errorMessage.remove();
                }
            });
        });
    });

    let questionCounter = 0;

    function addQuestion() {
        const template = document.getElementById('question-template').content.cloneNode(true);
        const questionList = document.getElementById('question-list');
        const newIndex = questionCounter++;

        template.querySelector('.question-number').textContent = newIndex + 1;

        template.querySelectorAll('.question-input, .answer-input, .answer-radio').forEach(el => {
            if (el.classList.contains('question-input')) {
                el.name = `questions[${newIndex}][question]`;
            } else if (el.classList.contains('answer-radio')) {
                el.name = `questions[${newIndex}][correct_answer]`;
            } else {
                el.name = `questions[${newIndex}][answers][]`;
            }
        });

        questionList.appendChild(template);
    }

    function removeQuestion(element) {
        element.closest('.question-item').remove();
    }
</script>
@endsection
