@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto">
    <!-- Card Wrapper -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Tambah Kategori</h2>

        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Gambar Kategori -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-semibold mb-2">Gambar Kategori</label>
                <input type="file" name="image" id="image" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('image') border-red-500 @enderror">
                @error('image')
                    <span class="text-red-500 text-sm"  id="image-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nama Kategori -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
                <input type="text" name="name" id="name" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('name') border-red-500 @enderror" placeholder="Masukkan nama kategori" value="{{ old('name') }}">
                @error('name')
                    <span class="text-red-500 text-sm"  id="name-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Deskripsi Kategori -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea name="description" id="description" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 @error('description') border-red-500 @enderror" placeholder="Masukkan deskripsi kategori">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm"  id="description-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('categories.index') }}" class="bg-red-400 hover:bg-red-300 text-white py-2 px-4 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white py-2 px-4 rounded-lg">
                    Tambah 
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('input, textarea'); // Memilih input dan textarea
        inputs.forEach(input => {
            input.addEventListener('input', function () { // Memperbaiki event listener
                removeErrorStyles(input.id);
            });
        });
    });

    function removeErrorStyles(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.classList.remove('border-red-500'); // Menghapus border merah
            const errorMessage = document.getElementById(inputId + '-error');
            if (errorMessage) {
                errorMessage.style.display = 'none'; // Menyembunyikan pesan error
            }
        }
    }
</script>

@endsection
