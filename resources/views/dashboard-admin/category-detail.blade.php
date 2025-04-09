@extends('layouts.dashboard-admin')

@section('content')

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Detail Kategori</h2>

    <!-- Detail Kategori -->
    <div class="flex flex-col lg:flex-row mb-4">
        <div class="w-full lg:w-1/3 mb-4 lg:mb-0">       
            @if ($category->image_path)
                <img src="{{ Storage::url($category->image_path) }}" alt="{{ $category->name }}" class="rounded-lg  w-80 h-35">
            @else
                <div class="bg-gray-200 text-gray-500 flex items-center justify-center rounded-lg w-full h-48">
                    <span>Gambar tidak tersedia</span>
                </div>
            @endif
        </div>
        <div class="w-full md:w-2/3 space-y-2 mt-4 md:mt-0 md:ml-4">
            <h2 class="text-md text-gray-700 font-semibold mb-2 capitalize">{{ $category->name }}</h2>
            <p class="text-sm text-gray-700 mb-2">{{ $category->description }}</p>
            <p class="text-sm text-gray-600">Total Kursus : {{ $category->courses->count() }}</p>
        </div>
    </div>  
</div>

<div class="mt-6 bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold mb-4 border-b-2 pb-2 text-gray-700">Daftar Kursus</h3>

    @if (session('success'))
        <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div id="flash-message" class="bg-yellow-100 border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-3">
            {{ session('info') }}
        </div>
    @endif

    <!-- Membungkus tabel dengan div untuk pengguliran -->
    <div class="overflow-x-auto">
        <div class="min-w-full w-64">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-sky-100 text-gray-700">
                    <th class="px-2 py-2 border-b border-l border-gray-200">No</th>
                    <th class="px-4 py-2 border-b border-gray-200">Judul</th>
                    <th class="px-4 py-2 border-b border-gray-200">Mentor</th>
                    <th class="px-4 py-2 border-b border-gray-200">Harga</th>
                    <th class="px-4 py-2 border-b border-r border-gray-200">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-gray-600 text-sm">
                @forelse ($category->courses as $index => $course)
                    <tr class="bg-white hover:bg-sky-50 border-b border-gray-200">
                        <td class="px-2 py-2 text-center border-b border-l border-t border-gray-200">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 capitalize border-b border-t border-gray-200">{{ $course->title }}</td>
                        <td class="px-4 py-2 capitalize border-b border-t border-gray-200">{{ $course->mentor->name ?? 'Tidak Ada Mentor' }}</td>
                        <td class="px-4 py-2 border-b border-t border-gray-200">Rp {{ number_format($course->price, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-center border-b border-t border-r border-gray-200">
                            <div class="flex justify-center items-center space-x-4">
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('detail-kursusadmin', [$course->id, $category->name]) }}" 
                                    class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200 flex items-center" title="Lihat">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>

                                <!-- Tombol Setujui Kursus -->
                                <form action="{{ route('courses.approve', ['id' => $course->id, 'name' => $category->name]) }}" 
                                    method="POST" 
                                    class="flex items-center" 
                                    title="Setujui Kursus">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="font-semibold p-1 rounded-md
                                            {{ $course->status == 'pending' ? 'bg-green-300 hover:bg-green-200 text-white' : 'bg-gray-300 text-white cursor-not-allowed' }}"
                                        {{ $course->status != 'pending' ? 'disabled' : '' }}>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" 
                                            class="w-5 h-5 text-white" fill="currentColor">
                                            <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                                        </svg>
                                    </button>
                                </form>


                                @php
                                    $canToggle = in_array($course->status, ['approved', 'published', 'nopublished']);
                                @endphp

                                <form 
                                    action="{{ 
                                        $course->status == 'published' 
                                            ? route('hiddencourse', ['id' => $course->id, 'name' => $category->name]) 
                                            : ($course->status == 'approved' || $course->status == 'nopublished'
                                                ? route('courses.publish', ['id' => $course->id, 'name' => $category->name]) 
                                                : '#') 
                                    }}" 
                                    method="POST" class="toggle-form">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="relative w-9 h-5 rounded-full transition-colors duration-300 ease-in-out mt-1
                                            {{ $course->status == 'published' ? 'bg-green-400' : 'bg-gray-300' }}
                                            {{ !$canToggle ? 'cursor-not-allowed opacity-60' : '' }}"
                                        title="{{ $course->status == 'published' ? 'Sembunyikan Kursus' : 'Publikasikan Kursus' }}"
                                        {{ !$canToggle ? 'disabled' : '' }}>

                                        <div class="absolute top-0.5 start-[2px] bg-white border-gray-300 border rounded-full h-4 w-4
                                            transition-transform duration-300 ease-in-out
                                            {{ $course->status == 'published' ? 'translate-x-full border-white' : '' }}">
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4 border-l border-r border-b border-gray-200">Belum ada kursus dalam kategori ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $courses->links() }} 
    </div>

    <div class="mt-6 flex justify-end space-x-2">
        <a href="{{ route('categories.index') }}" class="bg-sky-400 hover:bg-sky-300 text-white font-bold py-2 px-4 rounded">
            Kembali
        </a>
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
</script>
@endsection
