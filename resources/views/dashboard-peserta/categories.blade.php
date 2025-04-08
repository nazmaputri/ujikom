@extends('layouts.dashboard-peserta')

@section('content')
    <div class="bg-white border border-gray-300 rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-6 text-center border-b-2 border-gray-300 text-gray-700 pb-2">Daftar Kategori</h2>

        <!-- Grid Kategori dengan scroll horizontal pada mode mobile dan iPad -->
        <div class="overflow-x-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($categories as $category)
                <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                    <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->title }}">
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="text-lg font-semibold text-gray-800 capitalize flex-grow">{{ $category->name }}</h3>
                        <h3 class="text-sm text-gray-600 flex-grow">{{ $category->description }}</h3>
                        <div class="flex justify-end mt-4">
                            <a href="{{ route('categories-detail', ['id' => $category->id]) }}" class="flex mt-auto text-sm bg-sky-400 text-white p-2 rounded-lg hover:bg-sky-300 space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                                    </svg>
                                <span>Lihat</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
        <!-- Pagination -->
        <div class="mt-6">
            {{ $categories->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
