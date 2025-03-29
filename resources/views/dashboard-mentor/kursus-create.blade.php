@extends('layouts.dashboard-mentor')

@section('content')
<div class="container mx-auto"> 
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Tambah Kursus</h2>

        <!-- Form Tambah Kursus -->
        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div>
                    <!-- Input untuk Judul -->
                    <div class="mb-4">
                        <label for="title" class="block font-semibold text-gray-700 pb-2">Judul Kursus</label>
                        <input type="text" name="title" id="title" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('title') border-red-500 @enderror" placeholder="Masukkan judul kursus" value="{{ old('title') }}">
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Start_date -->
                    <div class="mb-4">
                        <label for="start_date" class="block font-semibold text-gray-700 pb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('start_date') border-red-500 @enderror" placeholder="Masukkan Waktu Mulai" min="{{ \Carbon\Carbon::today()->toDateString() }}">
                        <small class="text-gray-600">Jika tidak di isi maka "Akses seumur hidup"</small>
                        @error('start_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk End_date -->
                    <div class="mb-4">
                        <label for="end_date" class="block font-semibold text-gray-700 pb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('end_date') border-red-500 @enderror" placeholder="Masukkan Waktu Selesai" min="{{ \Carbon\Carbon::today()->toDateString() }}">
                        <small class="text-gray-600">Jika tidak di isi maka "Akses seumur hidup"</small>
                        @error('end_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="block font-semibold text-gray-700 pb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('description') border-red-500 @enderror" placeholder="Masukkan deskripsi kursus">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <!-- Kolom Kanan -->
                <div>
                    <!-- Input untuk Kategori -->
                    <div class="mb-4">
                        <label for="category_id" class="block font-semibold text-gray-700 pb-2">Kategori Kursus</label>
                        <select name="category" id="category" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Harga -->
                    <div class="mb-4">
                        <label for="price" class="block font-semibold text-gray-700 pb-2">Harga</label>
                        <input type="text" name="price" id="price" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('price') border-red-500 @enderror" placeholder="Masukkan harga kursus.contoh:3000 " value="{{ old('price') }}">
                        @error('price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Kapasitas -->
                    <div class="mb-4">
                        <label for="capacity" class="block font-semibold text-gray-700 pb-2">Kapasitas Peserta</label>
                        <input type="number" name="capacity" id="capacity" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('capacity') border-red-500 @enderror" placeholder="Masukkan kapasitas kursus" value="{{ old('capacity') }}">
                        <small class="text-gray-600">Jika tidak di isi maka kapasitasnya tidak terbatas</small>
                        @error('capacity')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Foto -->
                    <div class="mb-4">
                        <label for="image" class="block font-semibold text-gray-700 pb-2">Foto Kursus</label>
                        <input type="file" name="image" id="image" class="w-full p-2 text-sm text-gray-700 border rounded">
                        <small class="text-gray-600">Format gambar yang diperbolehkan: jpg, png, jpeg</small>
                    </div>
                    
                    <div class="mt-4">
                        <label for="chat-toggle" class="flex items-center cursor-pointer">
                            <span class="mr-3 text-gray-700 font-semibold">Aktifkan Fitur Chat</span>
                            <!-- Toggle Switch -->
                            <div class="relative ">
                                <input type="checkbox" name="chat" id="chat-toggle" class="hidden peer" {{ old('chat', $course->chat ?? false) ? 'checked' : '' }} value="1"/>
                                <div class="block bg-gray-300 w-9 h-5 rounded-full peer-checked:bg-green-500 peer-checked:justify-end"></div>
                                <div class="dot absolute top-0.5 start-[2px] bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-full"></div>
                            </div>
                        </label>
                    
                        <!-- Pesan saat fitur chat diaktifkan -->
                        <div id="chat-status" class="mt-1 hidden">
                            <p class="text-green-500 font-semibold">Fitur Chat Aktif!</p>
                        </div>
                    
                        <!-- Pesan saat fitur chat dinonaktifkan -->
                        <div id="chat-status-inactive" class="mt-1 hidden">
                            <p class="text-red-500 font-semibold">Fitur Chat Dinonaktifkan!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('courses.index') }}" class="bg-red-400 hover:bg-red-300 text-white font-bold py-2 px-4 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-bold py-2 px-4 rounded-lg">
                    Tambah 
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Menambahkan event listener untuk toggle
    document.getElementById('chat-toggle').addEventListener('change', function() {
        var chatStatus = document.getElementById('chat-status');
        var chatStatusInactive = document.getElementById('chat-status-inactive');
                    
        // Menampilkan atau menyembunyikan pesan berdasarkan status toggle
        if (this.checked) {
            chatStatus.classList.remove('hidden');
            chatStatusInactive.classList.add('hidden');
        } else {
            chatStatus.classList.add('hidden');
            chatStatusInactive.classList.remove('hidden');
        }
    });
    // Menambahkan event listener untuk setiap input yang ada
    const inputs = document.querySelectorAll('input, textarea, select');

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            // Menghapus kelas border merah saat input mulai diubah
            if (this.classList.contains('border-red-500')) {
                this.classList.remove('border-red-500');
            }

            // Menghapus pesan error jika ada
            const errorMessage = this.nextElementSibling;
            if (errorMessage && errorMessage.classList.contains('text-red-500')) {
                errorMessage.style.display = 'none';
            }
        });
    });
</script>

@endsection
