@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto bg-white rounded-lg p-5">
    <!-- Wrapper div dengan background putih, padding, dan shadow -->
    <div class="">
        <h2 class="text-xl font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Tambah Diskon</h2>

        <!-- Menampilkan pesan sukses -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulir Diskon -->
        <form action="{{ route('discount.store') }}" method="POST" class="mt-4 grid grid-col-1 md:grid-cols-2 space-x-3">
            @csrf

            <!-- Kode Kupon -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Kode Kupon</label>
                <input type="text" name="coupon_code" required class="border p-3 w-full rounded-lg focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
            </div>

            <!-- Persen Diskon -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Persen Diskon (%)</label>
                <input type="number" name="discount_percentage" required min="1" max="100" class="border p-3 w-full rounded-lg focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
            </div>

            <!-- Tanggal Mulai -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Tanggal Mulai</label>
                <input type="date" name="start_date" required class="border p-3 w-full rounded-lg focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
            </div>

            <!-- Tanggal Berakhir -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Tanggal Berakhir</label>
                <input type="date" name="end_date" required class="border p-3 w-full rounded-lg focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
            </div>

            <!-- Jam Mulai -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Jam Mulai</label>
                <input type="time" name="start_time" required class="border p-3 w-full rounded-lg focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
            </div>

            <!-- Jam Berakhir -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Jam Berakhir</label>
                <input type="time" name="end_time" required class="border p-3 w-full rounded-lg focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
            </div>

            <!-- Terapkan ke Semua Kursus -->
            <div class="mt-4">
                <input type="hidden" name="apply_to_all" value="0">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="apply_to_all" id="applyToAll" value="1"
                        class="rounded border-gray-300 text-blue-600 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
                    <span class="text-gray-700 pb-2">Terapkan ke semua kursus</span>
                </label>
            </div>

            <!-- Dropdown Pilih Kursus -->
            <div id="courseSelection" class="mt-4" x-data="{ open: false, selectedCourses: [], searchTerm: '' }" x-show="!applyToAll">
                <label class="block text-gray-700 pb-2 font-medium">Pilih Kursus</label>

                <div class="relative">
                    <!-- Button untuk membuka dropdown -->
                    <button @click="open = !open" type="button"
                        class="border p-3 w-full rounded-lg bg-white flex justify-between items-center focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
                        <span x-text="selectedCourses.length > 0 ? selectedCourses.join(', ') : 'Pilih Kursus'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white border rounded-lg shadow-lg">
                        <div class="p-2">
                            <input type="text" placeholder="Cari kursus..." x-model="searchTerm"
                                class="w-full p-3 border rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                        <ul class="max-h-40 overflow-y-auto">
                            @foreach($courses as $course)
                                <li class="p-3 hover:bg-blue-100 cursor-pointer"
                                    @click="selectedCourses.includes('{{ $course->title }}') 
                                        ? selectedCourses.splice(selectedCourses.indexOf('{{ $course->title }}'), 1) 
                                        : selectedCourses.push('{{ $course->title }}')">
                                    <input type="checkbox" name="courses[]" value="{{ $course->id }}" class="mr-2">
                                    {{ $course->title }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <p class="text-sm text-gray-500 mt-1">* Klik untuk memilih, gunakan CTRL untuk multi-select.</p>
            </div>

            <!-- Tombol -->
            <div class="col-span-1 md:col-span-2 mt-6 flex justify-end space-x-2">
                <a href="{{ route('discount') }}" class="bg-red-400 hover:bg-red-300 text-white font-semibold py-2 px-4 rounded">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('discountForm', () => ({
            applyToAll: false,
        }));
    });

    document.getElementById('applyToAll').addEventListener('change', function () {
        document.getElementById('courseSelection').style.display = this.checked ? 'none' : 'block';
    });
</script>
@endsection
