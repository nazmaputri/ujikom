@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex items-center justify-start space-x-4 mb-8">
            <h2 class="text-2xl uppercase font-bold border-b-2 border-gray-300 pb-2">Data Mentor</h2>
            <button id="addMentorBtn" class="bg-sky-300 text-white px-4 py-2 rounded-md hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                </svg>
            </button>
        </div>

        <!-- Pop-up Modal -->
        <div id="addMentorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white w-11/12 max-w-5xl p-6 rounded-md shadow-lg overflow-auto max-h-[90vh]">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-sky-600">Tambah Mentor</h3>
                    <button id="closeMentorModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                </div>
                <form action="{{ route('register') }}" method="POST" class="grid grid-cols-2 gap-6">
                    @csrf
                    <input type="hidden" name="added_by_admin" value="true">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-sky-600 pb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" required placeholder="Masukkan nama lengkap">
                    </div>
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-sky-600 pb-2">Email</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" required placeholder="Masukkan Email">
                    </div>
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-sky-600 pb-2">Password</label>
                        <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" required placeholder="Masukkan password">
                    </div>
                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-sky-600 pb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" required placeholder="Masukkan konfirmasi password">
                    </div>
                    <!-- Nomor Telepon -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-sky-600 pb-2">Nomor Telepon</label>
                        <input type="text" name="phone_number" id="phone_number" class="w-full px-4 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" required placeholder="Masukkan nomor telepon">
                    </div>
                    <!-- Profesi -->
                    <div>
                        <label for="profesi" class="block text-sm font-medium text-sky-600 pb-2">Profesi</label>
                        <input type="text" name="profesi" id="profesi" class="w-full px-4 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" required placeholder="Masukkan profesi">
                    </div>
                    <!-- LinkedIn -->
                    <div>
                        <label for="linkedin" class="block text-sm font-medium text-sky-600 pb-2">LinkedIn</label>
                        <input type="text" name="linkedin" id="linkedin" class="w-full px-4 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" required placeholder="Masukkan link URL linkedin">
                    </div>
                    <!-- Company -->
                    <div>
                        <label for="company" class="block text-sm font-medium text-sky-600 pb-2">Perusahaan</label>
                        <input type="text" name="company" id="company" class="w-full px-4 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" required placeholder="Masukkan nama perusahaan tempat bekerja">
                    </div>
                    <!-- Years of Experience -->
                    <div>
                        <label for="years_of_experience" class="block text-sm font-medium text-sky-600 pb-2">Tahun Pengalaman</label>
                        <input type="number" name="years_of_experience" id="years_of_experience" class="w-full px-4 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" required placeholder="Masukkan tahun pengalaman bekerja">
                    </div>
                    <!-- Deskripsi Pengalaman -->
                    <div class="col-span-2">
                        <label for="experience" class="block text-sm font-medium text-sky-600 pb-2">Deskripsi Pengalaman</label>
                        <textarea name="experience" id="experience" rows="4" class="w-full px-4 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Deskripsikan pengalaman"></textarea>
                    </div>
                    <!-- Hidden Role -->
                    <input type="hidden" name="role" value="mentor">
                    <!-- Submit Button -->
                    <div class="col-span-2">
                        <button type="submit" class="w-full px-4 py-2 bg-sky-600 text-white font-bold rounded-md hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                            Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('addMentorBtn').addEventListener('click', function () {
                document.getElementById('addMentorModal').classList.remove('hidden');
            });

            document.getElementById('closeMentorModal').addEventListener('click', function () {
                document.getElementById('addMentorModal').classList.add('hidden');
            });
        </script>
        
         <!-- Search Bar -->
         <form action="{{ route('datamentor-admin') }}" method="GET" class="max-w-sm mx-auto mb-4">
            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Cari</label>
            <div class="relative flex items-center">
                <!-- Input Search -->
                <input type="search" name="search" id="search" 
                    class="block w-full pl-4 pr-14 py-3 text-sm text-gray-900 border-2 border-sky-300 rounded-full bg-gray-50 focus:ring-blue-400 focus:border-blue-500" 
                    placeholder="Cari Mentor (Nama, Status)" value="{{ request('search') }}" />
                <!-- Button Search -->
                <button type="submit" 
                    class="absolute right-2.5 bottom-2 bg-sky-300 text-white hover:bg-sky-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-full text-sm px-4 py-2 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
        </form>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-yellow-100 border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4">
                {{ session('info') }}
            </div>
        @endif
        <!-- Tabel data user -->
        <div class="overflow-x-auto">
            <table class="min-w-full border-separate border-spacing-1" id="userTable">
                <thead>
                    <tr class="bg-sky-200 text-gray-600 text-sm leading-normal">
                        <th class="border border-gray-300 px-4 py-2 rounded-md">No</th>
                        <th class="border border-gray-300 px-4 py-2 rounded-md">Nama</th>
                        <th class="border border-gray-300 px-4 py-2 rounded-md">Status</th>
                        <th class="border border-gray-300 px-4 py-2 rounded-md">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $startNumber = ($users->currentPage() - 1) * $users->perPage() + 1;
                @endphp
                    @foreach ($users as $index => $user)
                        <tr class="bg-white hover:bg-sky-50 user-row" data-role="{{ $user->role }}">
                            <td class="border border-gray-300 px-4 py-2 rounded-md text-center">{{ $startNumber + $index }}</td>
                            <td class="border border-gray-300 px-4 py-2 rounded-md">{{ $user->name }}</td>
                            <td class="py-3 px-4 text-center border border-gray-300 rounded-md">
                                <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    @if($user->status === 'pending')
                                        <button type="submit" class="text-green-500 hover:text-green-700">Set Active</button>
                                    @else
                                        <span class="text-gray-500">Active</span>
                                    @endif
                                </form>
                            </td>                                             
                            <td class="py-3 px-6 text-center border border-gray-300 rounded-md">
                                <div class="flex items-center justify-center space-x-8">
                                    <!-- Tombol Lihat Detail -->
                                    <a href="{{ route('detaildata-mentor', ['id' => $user->id]) }}" class="text-white bg-gray-500 p-1 rounded-md hover:bg-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    <!-- Form hapus user -->
                                    <form id="deleteForm" action="{{ route('admin.delete', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-white bg-red-500 p-1 rounded-md hover:bg-red-800" onclick="openDeleteModal()">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>

                                    <!-- Modal Konfirmasi -->
                                    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
                                        <div class="bg-white p-6 rounded-lg shadow-lg">
                                            <h2 class="text-lg font-semibold">Konfirmasi Penghapusan</h2>
                                            <p>Apakah Anda yakin ingin menghapus pengguna ini?</p>
                                            <div class="mt-4 flex justify-center space-x-4">
                                                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md">Batal</button>
                                                <button onclick="confirmDelete()" class="ml-2 px-4 py-2 bg-red-500 text-white rounded-md">Hapus</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Script untuk membuka dan menutup modal -->
                                    <script>
                                        function openDeleteModal() {
                                            document.getElementById('deleteModal').classList.remove('hidden');
                                        }

                                        function closeDeleteModal() {
                                            document.getElementById('deleteModal').classList.add('hidden');
                                        }

                                        function confirmDelete() {
                                            document.getElementById('deleteForm').submit(); // Kirim form untuk menghapus user
                                        }
                                    </script>
                                </div>
                            </td>                                                                        
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination mt-4">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.tab-button');
        const userRows = document.querySelectorAll('.user-row');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const role = button.id;

                // Update button styles
                buttons.forEach(btn => {
                    btn.classList.remove('bg-sky-200', 'text-gray-800');
                    btn.classList.add('bg-gray-100', 'text-gray-600');
                });
                button.classList.add('bg-sky-200', 'text-gray-800');

                // Show/Hide rows based on role
                userRows.forEach(row => {
                    if (role === 'allUsers' || row.dataset.role.toLowerCase() === role) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

@endsection
