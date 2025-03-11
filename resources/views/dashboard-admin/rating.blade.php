@extends('layouts.dashboard-admin')  

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded-lg shadow-md p-5">
            <h1 class="text-xl font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Daftar Penilaian EduFlix</h1>
            
            <!-- Wrapper for responsiveness -->
            <div class="overflow-x-auto">
                <table class="min-w-full mt-3">
                    <thead>
                        <tr class="bg-sky-100 text-gray-700">
                            <th class="px-4 py-2 text-center text-gray-700">No</th>
                            <th class="px-4 py-2 text-center text-gray-700">Nama</th>
                            <th class="px-4 py-2 text-center text-gray-700">Rating</th>
                            <th class="px-4 py-2 text-center text-gray-700">Komentar</th>
                            <th class="px-4 py-2 text-center text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $startNumber = ($ratings->currentPage() - 1) * $ratings->perPage() + 1;
                    @endphp
                        @forelse ($ratings as $index => $rating)
                        <tr class="bg-white hover:bg-sky-50 user-row text-sm">
                            <td class="text-center px-4 py-2 text-sm">{{ $startNumber + $index }}</td>
                            <td class="px-4 py-2 text-sm capitalize">{{ $rating->nama }}</td>
                            <td class="px-4 py-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                @endfor
                            </td>
                            <td class="px-4 py-2">
                                <span>{{ $rating->comment }}</span>
                            </td>
                            <td class="px-4 py-2">                              
                                <form action="{{ route('toggle.displaymentor', $rating->id) }}" method="POST">
                                    @csrf
                                    @method('POST') <!-- Menggunakan metode POST untuk keamanan -->
                                    <label for="rating-toggle-{{ $rating->id }}" class="flex items-center cursor-pointer">
                                        <!-- Toggle Switch -->
                                        <div class="relative">
                                            <input type="checkbox" name="display" id="rating-toggle-{{ $rating->id }}" class="hidden peer" 
                                                {{ $rating->display ? 'checked' : '' }} value="1"/>
                                            <div class="block bg-gray-300 w-14 h-7 rounded-full peer-checked:bg-green-500 peer-checked:justify-end"></div>
                                            <div class="dot absolute left-1 top-1 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-6"></div>
                                        </div>
                                        <!-- Menambahkan kelas kondisi untuk warna teks -->
                                        <span class="ml-3 {{ $rating->display ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $rating->display ? 'Rating ditampilkan' : 'Rating disembunyikan' }}
                                        </span>
                                    </label>
                                </form>
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
                            <td colspan="5" class="text-center text-gray-500 py-4 text-sm">Belum ada rating</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $ratings->links() }}
                </div>
            </div> 
        </div>
    </div>
@endsection
