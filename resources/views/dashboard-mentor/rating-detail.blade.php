@extends('layouts.dashboard-mentor')

@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-xl font-semibold text-gray-700 text-center mb-6 border-b-2 pb-2 capitalize">Rating Kursus : {{ $course->title }}</h1>
        
        <!-- Wrapper for responsiveness -->
        <div class="overflow-x-auto">
            <div class="min-w-full w-64">
            <table class="min-w-full text-sm mt-2">
                <thead>
                    <tr class="bg-sky-200 text-gray-700">
                        <th class="px-2 py-2">No</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Rating</th>
                        <th class="px-4 py-2">Komentar</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ratings as $index => $rating)
                    <tr class="bg-white hover:bg-sky-50 user-row text-sm text-gray-600">
                        <td class="text-center px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $rating->user->name }}</td>
                        <td class="px-4 py-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $rating->stars ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                            @endfor
                        </td>
                        <td class="px-4 py-2 rounded-md">
                            <span>{{ $rating->comment }}</span>
                        </td>
                        <td class="px-4 py-2">
                                <!-- Teks status display admin -->
                                <span class="ml-3 {{ $rating->display ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $rating->display ? 'Rating ditampilkan' : 'Rating disembunyikan' }}
                                </span>
                            </td>
                        <td class="px-4 py-2  text-center rounded-md">                              
                            <div class="flex items-center justify-center space-x-4 ">
                            <form action="{{ route('toggle.displaymentor', $rating->id) }}" method="POST">
                                @csrf
                                @method('POST') <!-- Menggunakan metode POST untuk keamanan -->
                                <label for="rating-toggle-{{ $rating->id }}" class="flex items-center cursor-pointer">
                                    <!-- Toggle Switch -->
                                    <div class="relative">
                                        <input type="checkbox" name="display" id="rating-toggle-{{ $rating->id }}" class="hidden peer" 
                                            {{ $rating->display ? 'checked' : '' }} value="1"/>
                                        <div class="block bg-gray-300  w-9 h-5 rounded-full peer-checked:bg-green-500 peer-checked:justify-end"></div>
                                        <div class="dot absolute top-0.5 start-[2px] bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-full"></div>
                                    </div>
                                </label>
                            </form>

                            <!-- Form hapus rating -->
                            <form action="{{ route('ratingmentor.destroy', $rating->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white bg-red-400 p-1 rounded-md hover:bg-red-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                            </div>
                        </td>                        
                        <script>
                            // Menambahkan event listener untuk toggle
                            document.querySelectorAll('[id^="rating-toggle-"]').forEach(function(toggle) {
                                toggle.addEventListener('change', function() {
                                    var ratingId = this.id.split('-').pop();  // Mendapatkan id rating dari ID toggle
                                    var form = this.closest('form');
                                    
                                    // Mengirim formulir untuk mengubah status display
                                    form.submit();
                                });
                            });
                        </script>                                      
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">Belum ada rating</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('rating-kursus') }}" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded">
                Kembali
            </a>
        </div>   
    </div>
</div>
@endsection
