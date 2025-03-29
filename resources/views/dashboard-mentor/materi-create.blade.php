@extends('layouts.dashboard-mentor')

@section('content')
<div class="container mx-auto">
    <!-- Judul Utama -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Tambah Materi</h2>

        <!-- Form Tambah Materi -->
        <form action="{{ route('materi.store', ['courseId' => $course->id]) }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Kiri: Input Judul dan Deskripsi -->
                <div>
                    <!-- Input untuk Judul Materi -->
                    <div class="mb-4">
                        <label for="judul" class="block text-gray-700 font-semibold mb-2">Judul Materi</label>
                        <input type="text" name="judul" id="judul" class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" placeholder="Masukkan judul materi" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div> 

                    <!-- Input untuk Video -->
                    <div class="mb-4" id="video-upload">
                        <label class="block text-gray-700 font-semibold mb-2">Unggah Video Materi</label>
                        <input type="text" name="video_titles[]" class="w-full p-2 border text-sm text-gray-700 rounded mb-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" placeholder="Masukkan judul video">
                        <input type="file" name="videos[]" class="w-full text-sm text-gray-700 p-2 border rounded">
                        <button type="button" onclick="addVideoInput()" class="font-semibold text-sm mt-2 bg-green-400 hover:bg-green-300 text-white p-2 rounded">Tambah Video</button>
                        <small class="text-gray-600">Format video yang diperbolehkan: mp4, avi, mkv</small>
                        @error('videos')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                        @error('video_titles')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Input Untuk Link Youtube-->
                    <div class="mb-4" id="youtube-upload">
                        <label class="block text-gray-700 font-semibold">Tambahkan Link YouTube</label>
                        
                        <!-- Kontainer untuk link YouTube yang ditambahkan -->
                        <div id="youtube-container" class="hidden">
                            <!-- Template untuk input judul dan link YouTube -->
                            <div class="youtube-item mb-4">
                                <input 
                                    type="text" 
                                    name="youtube_titles[]" 
                                    class="w-full p-2 border rounded mb-2" 
                                    placeholder="Masukkan judul video YouTube">
                                <input 
                                    type="url" 
                                    name="youtube_links[]" 
                                    class="w-full p-2 border rounded mb-2" 
                                    placeholder="Masukkan link YouTube">
                                <button 
                                    type="button" 
                                    class="font-semibold mt-2 bg-red-400 hover:bg-red-300 text-white p-2 rounded" 
                                    onclick="removeYoutubeItem(this)">Hapus
                                </button>
                            </div>
                        </div>
                        
                        <!-- Tombol untuk menambahkan link YouTube -->
                        <button 
                            type="button" 
                            onclick="addYoutubeItem()" 
                            class="font-semibold mt-2 text-sm bg-green-400 hover:bg-green-300 text-white p-2 rounded">Tambah Link YouTube
                        </button>
                        
                        <small class="text-gray-600">Jika ukuran video lebih dari 1GB, gunakan link YouTube.</small>
                        
                        @error('youtube_links')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                        @error('youtube_titles')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>                    
                </div>
                
                <!-- Kanan: Input File Video dan Materi -->
                <div>
                   <!-- Pilihan Kursus (Hidden Input) -->
                    <div class="mb-4 hidden">
                        <label for="courses_id" class="block text-gray-700 font-semibold mb-2">Kursus Terkait</label>
                        <input type="hidden" name="courses_id" id="courses_id" value="{{ $course->id }}">
                        @error('courses_id')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                     <!-- Input untuk Deskripsi Materi -->
                     <div class="mb-4">
                        <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" placeholder="Masukkan deskripsi materi">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input untuk Materi PDF -->
                    <div class="mb-4" id="pdf-upload">
                        <label class="block text-gray-700 font-semibold mb-2">Unggah File Materi</label>
                        <input type="text" name="material_titles[]" class="w-full p-2 text-sm text-gray-700 border rounded mb-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" placeholder="Masukkan judul PDF">
                        <input type="file" name="material_files[]" class="w-full p-2 text-sm text-gray-700 border rounded">
                        <button type="button" onclick="addPdfInput()" class="font-semibold mt-2 text-sm bg-green-400 hover:bg-green-300 text-white p-2 rounded">Tambah PDF</button>
                        <small class="text-gray-600">Format file yang diperbolehkan: PDF, DOC, PPT</small>
                        @error('material_files')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                        @error('material_titles')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('courses.show', $course->id)}}" class="bg-red-400 hover:bg-red-300 text-white font-semibold py-2 px-4 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded-lg">
                    Tambah 
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Menambahkan input video baru
    function addVideoInput() {
        const videoInput = document.createElement('div');
        videoInput.classList.add('mt-2');
        videoInput.innerHTML = ` 
            <label class="block text-gray-700 font-semibold mb-2">Unggah Video</label>
            <input type="text" name="video_titles[]" class="w-full p-2 border rounded mb-2 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" placeholder="Masukkan judul video">
            <input type="file" name="videos[]" class="w-full text-sm text-gray-700 p-2 border rounded">
            <button type="button" onclick="removeInput(this)" class="mt-2 text-sm font-semibold bg-red-500 hover:bg-red-300 text-white p-2 rounded">Hapus</button>
        `;
        document.getElementById('video-upload').appendChild(videoInput);
    }

    // Menambahkan input PDF baru
    function addPdfInput() {
        const pdfInput = document.createElement('div');
        pdfInput.classList.add('mt-2');
        pdfInput.innerHTML = ` 
            <label class="block text-gray-700 font-semibold mb-2">Unggah PDF</label>
            <input type="text" name="material_titles[]" class="w-full p-2 text-sm text-gray-700 border rounded mb-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" placeholder="Masukkan judul PDF">
            <input type="file" name="material_files[]" class="w-full p-2 text-sm text-gray-700 border rounded">
            <button type="button" onclick="removeInput(this)" class="mt-2 text-sm bg-red-500 hover:bg-red-300 text-white p-2 rounded">Hapus</button>
        `;
        document.getElementById('pdf-upload').appendChild(pdfInput);
    }

    // Menghapus input
    function removeInput(button) {
        button.parentElement.remove();
    }

    // Fungsi untuk menampilkan kontainer dan menambahkan input YouTube baru
    function addYoutubeItem() {
        const container = document.getElementById('youtube-container');
        
        // Menampilkan kontainer jika tersembunyi
        container.classList.remove('hidden');
        
        const newItem = document.createElement('div');
        newItem.classList.add('youtube-item', 'mb-4');
        newItem.innerHTML = `
            <input 
                type="text" 
                name="youtube_titles[]" 
                class="w-full p-2 text-sm text-gray-700 border rounded mb-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" 
                placeholder="Masukkan judul video YouTube"
            >
            <input 
                type="url" 
                name="youtube_links[]" 
                class="w-full p-2 text-sm text-gray-700 border rounded mb-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" 
                placeholder="Masukkan link YouTube"
            >
            <button 
                type="button" 
                class="font-semibold text-sm hover:bg-red-300 mt-2 bg-red-400 text-white p-2 rounded" 
                onclick="removeYoutubeItem(this)"
            >
                Hapus
            </button>
        `;
        container.appendChild(newItem);
    }

    // Fungsi untuk menghapus input tertentu
    function removeYoutubeItem(button) {
        const item = button.closest('.youtube-item');
        item.remove();
    }
</script>
@endsection
