@extends('layouts.dashboard-peserta')

@section('content')

<div class="container mx-auto">
    <div class="bg-white border border-gray-300 rounded-lg shadow-md p-6 mb-6">
        <!-- Detail Kategori -->
        <h2 class="text-xl text-gray-700 font-semibold mb-6 text-center border-b-2 border-gray-300 pb-2 capitalize">
            Daftar Kursus : {{ $category->name }}
        </h2>
        
        @if($courses->isEmpty())
            <!-- Pesan jika tidak ada kursus -->
            <div class="text-center text-gray-600">
                <p class="text-md">Kategori ini belum memiliki kursus.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses as $course)
                @php
                    // Cek apakah user sudah membeli kursus ini melalui tabel purchases
                    $isPurchased = $course->purchases()
                        ->where('user_id', auth()->id())
                        ->where('status', 'success') // pastikan status pembelian sesuai
                        ->exists();
                @endphp            

        <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden flex flex-col">
            <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}">
            <div class="flex flex-col flex-grow">
                <h3 class="text-md font-semibold text-gray-800 capitalize mx-3 mt-1">{{ $course->title }}</h3>
                <p class="text-sm text-gray-600 mx-3 capitalize">Mentor : {{ $course->mentor->name }}</p>
                <p class="text-red-500 inline-flex items-center text-sm rounded-xl font-semibold mx-3" id="course-price-{{ $course->id }}">
                    Rp. {{ number_format($course->price, 0, ',', '.') }}
                </p>
                <div class="items-center mt-1 flex-grow">
                    <div class="flex my-2 mx-3">
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < floor($course->average_rating)) 
                                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                </svg>
                            @endif
                        @endfor
                        <span class="text-yellow-500 font-bold text-sm sm:ml-2 sm:mt-0">{{ number_format($course->average_rating, 1) }} / 5</span>
                    </div>
                </div>

                <!-- LABEL -->
                <div class="mt-auto">
                    <div class="flex w-full h-[30px]">
                        <div class="w-1/2 {{ $isPurchased ? 'bg-green-500 hover:bg-green-400' : 'bg-red-500 hover:bg-red-400' }} flex justify-center items-center p-4">
                            @if (!$isPurchased)
                                <form action="{{ route('cart.add', ['id' => $course->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center space-x-3 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-5 h-5">
                                            <path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" fill="white"/>
                                        </svg>
                                        <span class="text-sm">Keranjang</span>
                                    </button>
                                </form>
                            @else
                                <span class="text-sm text-white px-3 py-1 rounded cursor-not-allowed">
                                    Sudah dibeli
                                </span>
                            @endif
                        </div>

                        <div class="w-1/2 bg-sky-400 hover:bg-sky-300 flex justify-center items-center p-4">
                            <a href="{{ route('kursus-peserta', ['id' => $course->id, 'categoryId' => $category->id]) }}" 
                            class="text-white py-1.5 px-5 rounded-lg flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm">Detail</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                @endforeach
            </div>
        @endif
        <div class="mt-6 flex justify-end">
            <a href="{{ route('kategori-peserta') }}" class="bg-sky-400 text-white font-semibold py-1.5 px-5 rounded-lg hover:bg-sky-300">
                Kembali
            </a>
        </div>
    </div>
</div>

@endsection
