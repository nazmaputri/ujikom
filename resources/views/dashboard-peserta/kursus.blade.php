@extends('layouts.dashboard-peserta')
@section('content')
<div class="container mx-auto">
    <div class="bg-white border border-gray-300 rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-xl font-semibold mb-6 border-b-2 pb-2 text-gray-700 text-center">Kursus Saya</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($courses as $course)
                <div class="border rounded-lg p-4 shadow-md bg-white flex flex-col">
                    <div class="w-full mb-2">
                        <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-full h-40 object-cover">
                    </div>
                    <h2 class="text-lg text-gray-700 font-semibold capitalize">{{ $course->title }}</h2>
                    <p class="text-gray-600 text-sm mt-2 capitalize"><span class="">Mentor :</span> {{ $course->mentor->name }}</p>
                    <p class="text-gray-600 text-sm mb-5"><span class="">Masa Aktif :</span> {{ $course->duration }}</p>

                    <div class="flex justify-between items-center mt-auto gap-x-3 flex-nowrap overflow-x-auto">
                        <!-- Button Detail -->
                        <a href="{{ route('detail-kursus', $course->id) }}" 
                            class="bg-sky-200/50 border border-sky-300 text-sky-500 px-2 py-2 rounded-lg hover:bg-sky-300 hover:text-white flex items-center space-x-1 group w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm sm:block hidden">Detail</span>
                        </a>
                    
                        <!-- Button Belajar -->
                        <a href="{{ route('study-peserta', ['id' => $course->id]) }}" 
                            class="bg-yellow-200/50 border border-yellow-300 text-yellow-500 px-2 py-2 rounded-lg hover:bg-yellow-300 hover:text-white flex items-center space-x-1 group w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-3 h-3 fill-current text-yellow-500 group-hover:text-white">
                                <path d="M160 96a96 96 0 1 1 192 0A96 96 0 1 1 160 96zm80 152l0 264-48.4-24.2c-20.9-10.4-43.5-17-66.8-19.3l-96-9.6C12.5 457.2 0 443.5 0 427L0 224c0-17.7 14.3-32 32-32l30.3 0c63.6 0 125.6 19.6 177.7 56zm32 264l0-264c52.1-36.4 114.1-56 177.7-56l30.3 0c17.7 0 32 14.3 32 32l0 203c0 16.4-12.5 30.2-28.8 31.8l-96 9.6c-23.2 2.3-45.9 8.9-66.8 19.3L272 512z"/>
                            </svg>
                            <span class="text-sm sm:block hidden">Belajar</span>
                        </a>
                    
                        <!-- Button Chat -->
                        <a href="{{ $course->isChatActive ? route('chat.student', $course->id) : '#' }}" 
                            class="px-2 py-2 rounded-lg  flex items-center space-x-1 group w-auto
                            {{ $course->isChatActive ? 'bg-green-200/50 border border-green-300 hover:bg-green-300 text-green-500 hover:text-white cursor-pointer' : 'bg-gray-200 border border-gray-300 text-gray-500 cursor-not-allowed' }}" 
                            {{ $course->isChatActive ? '' : 'aria-disabled="true"' }} 
                            title="{{ $course->isChatActive ? '' : 'Chat tidak tersedia untuk kursus ini' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" 
                                class="w-3 h-3 fill-current 
                                {{ $course->isChatActive ? 'text-green-500 group-hover:text-white' : 'text-gray-500' }}">
                                <path d="M208 352c114.9 0 208-78.8 208-176S322.9 0 208 0S0 78.8 0 176c0 38.6 14.7 74.3 39.6 103.4c-3.5 9.4-8.7 17.7-14.2 24.7c-4.8 6.2-9.7 11-13.3 14.3c-1.8 1.6-3.3 2.9-4.3 3.7c-.5 .4-.9 .7-1.1 .8l-.2 .2s0 0 0 0s0 0 0 0C1 327.2-1.4 334.4 .8 340.9S9.1 352 16 352c21.8 0 43.8-5.6 62.1-12.5c9.2-3.5 17.8-7.4 25.2-11.4C134.1 343.3 169.8 352 208 352zM448 176c0 112.3-99.1 196.9-216.5 207C255.8 457.4 336.4 512 432 512c38.2 0 73.9-8.7 104.7-23.9c7.5 4 16 7.9 25.2 11.4c18.3 6.9 40.3 12.5 62.1 12.5c6.9 0 13.1-4.5 15.2-11.1c2.1-6.6-.2-13.8-5.8-17.9c0 0 0 0 0 0s0 0 0 0l-.2-.2c-.2-.2-.6-.4-1.1-.8c-1-.8-2.5-2-4.3-3.7c-3.6-3.3-8.5-8.1-13.3-14.3c-5.5-7-10.7-15.4-14.2-24.7c24.9-29 39.6-64.7 39.6-103.4c0-92.8-84.9-168.9-192.6-175.5c.4 5.1 .6 10.3 .6 15.5z"/>
                            </svg>
                            <span class="text-sm sm:block hidden {{ $course->isChatActive ? 'text-green-500 group-hover:text-white' : 'text-gray-500' }}">Chat</span>
                        </a>                        
                    </div>                    
                </div>
            @empty
            <div class="col-span-full">
                <p class="text-gray-600 text-center">Anda belum membeli kursus apapun.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
