@extends('layouts.dashboard-admin')  

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded-lg shadow-md p-5">
            <h1 class="text-xl font-semibold mb-6 border-b-2 pb-2 text-gray-700 text-center">Daftar Penilaian EduFlix</h1>
            
        @if (session('success'))
            <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div id="flash-message" class="bg-yellow-100 border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-3">
                {{ session('info') }}
            </div>
        @endif

            <!-- Wrapper for responsiveness -->
            <div class="overflow-x-auto">
               <div class="min-w-full w-64">
               <table class="min-w-full mt-1 border-collapse">
                    <thead>
                        <tr class="bg-sky-100 text-gray-700 text-sm">
                            <th class="px-4 py-2 text-center text-gray-700 border-b border-l border-gray-200">No</th>
                            <th class="px-4 py-2 text-center text-gray-700 border-b border-gray-200">Nama</th>
                            <th class="px-4 py-2 text-center text-gray-700 border-b border-gray-200">Rating</th>
                            <th class="px-4 py-2 text-center text-gray-700 border-b border-gray-200">Komentar</th>
                            <th class="px-4 py-2 text-center text-gray-700 border-b border-gray-200">Status</th>
                            <th class="px-4 py-2 text-center text-gray-700 border-b border-r border-gray-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $startNumber = ($ratings->currentPage() - 1) * $ratings->perPage() + 1;
                    @endphp
                        @forelse ($ratings as $index => $rating)
                        <tr class="bg-white border-b hover:bg-sky-50 user-row text-sm text-gray-600">
                            <td class="text-center px-4 py-2 text-sm  border-b border-l  border-gray-200">{{ $startNumber + $index }}</td>
                            <td class="px-4 py-2 text-sm capitalize">{{ $rating->nama }}</td>
                            <td class="px-4 py-2 text-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                @endfor
                            </td>
                            <td class="px-4 py-2">
                                <span>{{ $rating->comment }}</span>
                            </td>
                            <!-- Kolom Status -->
                            <td class="px-4 py-2 text-center align-middle">
                                @php
                                    $displayStatus = $rating->display
                                        ? ['label' => 'ditampilkan', 'bg' => 'bg-green-200/50', 'border' => 'border-green-300', 'text' => 'text-green-500']
                                        : ['label' => 'disembunyikan', 'bg' => 'bg-red-200/50', 'border' => 'border-red-300', 'text' => 'text-red-500'];
                                @endphp
                                <span class="inline-block min-w-[120px] px-2 py-0.5 rounded-xl border-2 text-center 
                                    {{ $displayStatus['bg'] }} {{ $displayStatus['border'] }} {{ $displayStatus['text'] }}">
                                    {{ $displayStatus['label'] }}
                                </span>
                            </td>

                            <!-- Kolom Toggle & Hapus -->
                            <td class="px-4 py-2 text-center align-middle">
                                <div class="flex items-center justify-center space-x-4">
                                    <!-- Form Toggle -->
                                    <form action="{{ route('toggle.displayadmin', $rating->id) }}" method="POST">
                                        @csrf
                                        <label for="rating-toggle-{{ $rating->id }}" class="flex items-center cursor-pointer" title="{{ $rating->display ? 'Sembunyikan' : 'Tampilkan' }}">
                                            <div class="relative">
                                                <input type="checkbox" name="display" id="rating-toggle-{{ $rating->id }}" class="hidden peer" 
                                                    {{ $rating->display ? 'checked' : '' }} value="1" onchange="this.form.submit()" />
                                                <div class="block bg-gray-300 w-9 h-5 rounded-full peer-checked:bg-green-500 peer-checked:justify-end"></div>
                                                <div class="dot absolute top-0.5 start-[2px] bg-white h-4 w-4 rounded-full transition-transform peer-checked:translate-x-full"></div>
                                            </div>
                                        </label>
                                    </form>

                                    <!-- Tombol Hapus -->
                                    <button class="delete-btn text-white bg-red-400 p-1 rounded-md hover:bg-red-300" data-action="{{ route('ratings.destroy', $rating->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>                                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4 text-sm">Belum ada rating</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
               </div>
                <div class="mt-4">
                    {{ $ratings->links() }}
                </div>
            </div> 
        </div>
    </div>

<!-- Popup Konfirmasi Hapus -->
<div id="popup-confirm" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-[1000]">
    <div class="bg-white p-6 mx-4 rounded-lg shadow-lg max-w-sm w-full">
        <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center">Konfirmasi Hapus</h2>
        <p class="text-gray-600 mb-4">Apakah Anda yakin ingin menghapus rating ini?</p>
        <div class="flex justify-center space-x-3">
            <button id="cancel-btn" class="px-4 py-2 bg-sky-400 rounded-md text-white hover:bg-sky-300">Batal</button>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-400 text-white rounded-md hover:bg-red-300">Hapus</button>
            </form>
        </div>
    </div>
</div>

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

    //untuk mengatur flash message dari backend
    document.addEventListener('DOMContentLoaded', function () {
        const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.remove();
            }, 3000); // Hapus pesan setelah 3 detik
        }
    });

    //untuk mengatur popup konfirmasi penghapusan rating
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            let formAction = this.getAttribute('data-action');
            document.getElementById('delete-form').setAttribute('action', formAction);
            document.getElementById('popup-confirm').classList.remove('hidden');
        });
    });
    
    document.getElementById('cancel-btn').addEventListener('click', function() {
        document.getElementById('popup-confirm').classList.add('hidden');
    });
</script>
@endsection
