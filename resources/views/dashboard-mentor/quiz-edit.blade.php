@extends('layouts.dashboard-mentor')

@section('content')
<div class="container mx-auto">
    <!-- Card Wrapper -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-xl font-semibold text-gray-700 mb-6 text-center border-b-2 pb-2">Edit Kuis</h1>

        <!-- Form Edit Quiz -->
        <form action="{{ isset($materiId)
        ? route('quiz.update', ['courseId' => $courseId, 'materiId' => $materiId, $quiz->id])
        : route('final-update', ['courseId' => $courseId, 'id' => $quiz->id]) }}" method="POST">    
    @csrf
    @method('PUT')

    <!-- Judul Quiz -->
    <div class="mb-4">
        <label for="title" class="block text-gray-700 font-semibold">Judul Kuis</label>
        <input type="text" name="title" id="title" value="{{ old('title', $quiz->title) }}" 
               class="w-full text-gray-700 text-sm  border-gray-300 rounded-lg border focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 p-2
               @error('title') border-red-500 @enderror">
        @error('title') 
            <span class="text-red-500 text-sm">{{ $message }}</span> 
        @enderror
    </div>

    <!-- Deskripsi Quiz -->
    <div class="mb-4">
        <label for="description" class="block text-gray-700 font-semibold">Deskripsi</label>
        <textarea name="description" id="description" rows="3" 
                  class="w-full text-gray-700 text-sm border-gray-300 rounded-lg border focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 p-2
                  @error('description') border-red-500 @enderror">{{ old('description', $quiz->description) }}</textarea>
        @error('description') 
            <span class="text-red-500 text-sm">{{ $message }}</span> 
        @enderror
    </div>

    <!-- Durasi Quiz -->
    <div class="mb-4">
        <label for="duration" class="block text-gray-700 font-semibold">Durasi (Menit)</label>
        <input type="number" name="duration" id="duration" value="{{ old('duration', $quiz->duration) }}" 
               class="w-full text-gray-700 text-sm border-gray-300 border rounded-lg focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 p-2
               @error('duration') border-red-500 @enderror">
        @error('duration') 
            <span class="text-red-500 text-sm">{{ $message }}</span> 
        @enderror
    </div>

    <!-- Soal Quiz -->
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Soal dan Jawaban</h3>
        @foreach($quiz->questions as $index => $question)
            <div class="bg-gray-50 p-4 rounded-md shadow-md mb-4">
                <!-- Soal -->
                <div class="mb-4">
                    <label for="questions[{{ $index }}][question]" class="block text-gray-700 font-semibold">Soal {{ $index + 1 }}</label>
                    <input type="text" name="questions[{{ $index }}][question]" id="questions[{{ $index }}][question]" 
                           value="{{ old("questions.$index.question", $question->question) }}" 
                           class="w-full text-gray-700 text-sm border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 p-2
                           @error("questions.$index.question") border-red-500 @enderror">
                    @error("questions.$index.question") 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Jawaban -->
                <div class="space-y-3">
                    @foreach($question->answers as $answerIndex => $answer)
                        <div class="flex items-center space-x-4">
                            <label for="questions[{{ $index }}][answers][{{ $answerIndex }}]" class="block text-gray-700 font-semibold">Jawaban {{ $answerIndex + 1 }}</label>
                            <input type="text" name="questions[{{ $index }}][answers][{{ $answerIndex }}]" 
                                   id="questions[{{ $index }}][answers][{{ $answerIndex }}]" 
                                   value="{{ old("questions.$index.answers.$answerIndex", $answer->answer) }}" 
                                   class="flex-1 text-gray-700 text-sm border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-300 focus:border-sky-500 p-2
                                   @error("questions.$index.answers.$answerIndex") border-red-500 @enderror">

                            <!-- Checkbox untuk Jawaban Benar -->
                            <input type="radio" name="questions[{{ $index }}][correct_answer]" value="{{ $answerIndex }}" 
                                   {{ old("questions.$index.correct_answer") == $answerIndex ? 'checked' : '' }} class="focus:ring focus:ring-blue-300">
                            <span class="text-sm text-gray-700 text-sm hidden sm:inline ml-2">Benar</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Daftar Soal Dinamis -->
    <div id="questions-container">
        <!-- Soal Template (untuk cloning) -->
        <template id="question-template">
            <div class="question-item border p-4 mb-4 rounded bg-gray-50">
                <!-- Menampilkan Nomor Soal -->
                <div class="mb-3">
                    <span class="text-lg font-semibold">Soal <span class="question-number"></span></span>
                </div>

                <!-- Input Pertanyaan -->
                <div class="mb-3">
                    <label class="block text-gray-700 font-bold mb-2">Soal</label>
                    <input type="text" name="questions[0][question]" class="w-full p-2 border rounded question-input" placeholder="Masukkan teks soal" required>
                </div>

                <!-- Input Jawaban Pilihan Ganda -->
                <div class="answers-container">
                    <label class="block text-gray-700 font-bold mb-2">Jawaban Pilihan Ganda</label>
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center mb-2">
                            <input type="radio" name="questions[0][correct_answer]" value="{{ $i }}" class="mr-2 answer-radio" required>
                            <input type="text" name="questions[0][answers][]" class="w-full p-2 border rounded answer-input" placeholder="Masukkan jawaban" required>
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
        <button type="button" onclick="addQuestion()" class="mt-4 bg-green-400 hover:bg-green-300 text-white font-semibold py-2 px-4 rounded">
            Tambah Soal
        </button>
    </div>

    <!-- Tombol aksi -->
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
        <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white text-sm font-semibold py-2 px-4 rounded-lg">
            Simpan
        </button>
    </div>
</form>
</div>
</div>

<script>
 document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('input, textarea');

        inputs.forEach(input => {
            input.addEventListener('focus', function () {
                // Hapus border merah dan pesan error ketika input di fokus
                if (this.classList.contains('border-red-500')) {
                    this.classList.remove('border-red-500');
                }

                // Hapus pesan error ketika input di fokus
                const errorMessage = this.nextElementSibling;
                if (errorMessage && errorMessage.classList.contains('text-red-500')) {
                    errorMessage.style.display = 'none';  // Sembunyikan pesan error
                }
            });
        });
    });
   let questionCounter = {{ count($quiz->questions) }}; // Mulai dari jumlah soal yang sudah ada

function addQuestion() {
    const template = document.getElementById('question-template').content.cloneNode(true);
    const questionList = document.getElementById('question-list');
    const newIndex = questionCounter++;

    const questionNumber = template.querySelector('.question-number');
    if (questionNumber) {
        questionNumber.textContent = newIndex + 1;
    }

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
    const questionItem = element.closest('.question-item');
    if (questionItem) {
        questionItem.remove();
    }
}

</script>
@endsection
