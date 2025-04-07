@extends('layouts.dashboard-mentor')

@section('content')
<div class="h-screen flex flex-col lg:flex-row">
    <!-- Sidebar -->
    <aside class="lg:w-1/3 bg-white rounded rounded-md border-r border-gray-300 lg:h-screen overflow-y-auto">
        <div class="p-4 space-y-4">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Chats</h2>
            
            <!-- List Chat -->
            @foreach ($chats as $chat)
            <a href="{{ route('chat.mentor', ['courseId' => $chat->course_id, 'chatId' => $chat->id]) }}" 
                class="flex items-center p-3 bg-sky-50 rounded-lg cursor-pointer hover:bg-sky-50 hover:opacity-40
                {{ $activeChat && $activeChat->id == $chat->id ? 'bg-sky-100' : '' }}">
                <img src="{{ asset('storage/default-profile.jpg') }}" class="w-10 h-10 rounded-full" alt="profile peserta"/>
                <div class="ml-4">
                    <h3 class="text-gray-700 font-medium">
                        {{ $chat->student->name }}
                    </h3>
                    <p class="text-gray-500 text-sm truncate">Pesan terbaru...</p>
                </div>
            </a>
            @endforeach

            <!-- Start New Chat Section (Only visible if no chat exists) -->
            <div class="lg:block hidden">
                <h2 class="text-md font-semibold mt-6 text-gray-700">Mulai chat baru</h2>
                @if ($students->isNotEmpty())
                    @foreach ($students as $student)
                        <!-- Only show "Start New Chat" if no existing chat with the student -->
                        @if (!in_array($student->id, $chats->pluck('student_id')->toArray()))
                        <a href="{{ route('chat.start', ['studentId' => $student->id]) }}" 
                           class="flex items-center p-3 bg-gray-100 rounded-lg cursor-pointer hover:bg-gray-200">
                           <img width="40" height="40" src="https://img.icons8.com/pastel-glyph/64/user-male-circle.png" alt="user-male-circle"/>
                            <div class="ml-4">
                                <h3 class="text-gray-700 font-medium">{{ $student->name }}</h3>
                                <p class="text-gray-500 text-sm">Mulai chat baru...</p>
                            </div>
                        </a>
                        @endif
                    @endforeach
                @else
                    <p class="text-gray-500 mt-4">Belum ada peserta yang membeli kursus ini.</p>
                @endif
            </div>
        </div>
    </aside>

    <!-- Main Chat Area -->
    <main class="flex-1 flex flex-col bg-neutral-50">
        @if ($activeChat && $activeChat->student)
        <!-- Profil Student -->
        <div class="bg-white border-b border-gray-300 p-4 flex items-center relative">
            <img src="{{ asset('storage/default-profile.jpg') }}" class="w-10 h-10 rounded-full" alt="user-male-circle"/>
            <div class="ml-4">
                <h3 class="text-gray-700 font-medium">{{ $activeChat->student->name }}</h3>
                {{-- <p class="text-gray-500 text-sm">Online</p> --}}
            </div>
            <a href="{{ route('courses.index') }}" class="absolute right-4 top-1/2 transform -translate-y-1/2">
                <button type="button" id="prev-btn" class="border hover:bg-neutral-100/50 font-semibold text-white px-2 py-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" fill="currentColor" class="w-4 h-4 text-gray-700">
                        <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/>
                    </svg>
                </button>
            </a>        
        </div>        
    
        <!-- Chat Messages -->
        <div class="bg-[url('{{ asset('storage/wp-chat.jpg') }}')] bg-repeat flex-1 overflow-y-auto p-4">
            @if (count($messages))
                @foreach ($messages as $message)
                    <div class="flex items-start mb-4 {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="{{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-white border-gray-200 border text-gray-800' }} p-3 rounded-lg shadow-md">
                            <p class="{{ $message->sender_id == auth()->id() ? 'text-white' : 'text-gray-700' }}">{{ $message->message }}</p>
                            <p class="{{ $message->sender_id == auth()->id() ? 'text-white' : 'text-gray-700' }} text-xs">{{ $message->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex items-center justify-center p-4">
                    <p class="text-gray-500">Belum ada pesan. Mari mulai chat!</p>
                </div>
            @endif
        </div>        
    
        <!-- Chat Input -->
        <div class="p-4 bg-white border-t border-gray-300">
            <form action="{{ route('chat.send', $activeChat->id) }}" method="POST" class="flex items-center">
                @csrf
                <!-- Menambahkan hidden input untuk course_id -->
                <input type="hidden" name="course_id" value="{{ $activeChat->course_id }}"> <!-- Menambahkan course_id -->
                <input type="text" name="message" placeholder="Type a message..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-400">
                    Kirim
                </button>
            </form>
        </div>
        @else
        <div class="flex-1 flex items-center justify-center p-4">
            <p class="text-gray-500">Pilih peserta untuk memulai chat.</p>
        </div>
        @endif
    </main>
    
</div>
@endsection