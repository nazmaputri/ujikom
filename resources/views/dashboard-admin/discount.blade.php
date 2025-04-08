@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto bg-white rounded-lg p-5">
    <!-- Wrapper div dengan background putih dan padding -->
    <div class="">
        <h2 class="text-xl font-semibold mb-6 border-b-2 pb-2 text-gray-700 text-center">Diskon</h2>
        <div class="flex flex-col md:flex-row items-center justify-between space-y-4 mb-4">
            <!-- searchbar -->
            <form action="{{ route('discount') }}" method="GET" class="w-full md:max-w-xs">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Cari</label>
                <div class="relative flex items-center">
                    <input type="search" name="search" id="search" 
                        class="block w-full pl-4 pr-14 py-2.5 text-sm text-gray-700 border-2 border-sky-300 rounded-full focus:outline-none bg-gray-50" 
                        placeholder="Cari Kode Kupon..." value="{{ request('search') }}" />
                    <button type="submit" 
                        class="absolute right-1 py-2.5 bg-sky-300 text-white hover:bg-sky-200 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-full text-sm px-3 font-semibold flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>
            </form>
            
            <!-- button tambah -->
            <div class="inline-flex shadow-md shadow-sky-100 hover:shadow-none items-center space-x-2 text-white bg-sky-300 hover:bg-sky-200 font-semibold py-2 px-4 rounded-md">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                </svg>
                <a href="{{ route('discount-tambah') }}" class=" text-white rounded transition duration-300">Tambah Diskon</a>
            </div>
        </div>

        @if (session('success'))
            <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 p-2 mt-3 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel dengan responsivitas -->
        <div class="overflow-x-auto mt-6">
            <div class="min-w-full w-64">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-sky-100 text-gray-700 text-sm border-b border-l border-r">
                    <th class="py-2 px-2 text-center text-gray-700 border-b border-l border-t border-gray-200">No</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-t border-gray-200">Kode Kupon</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-t border-gray-200">Diskon (%)</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-t border-gray-200">Tanggal</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-t border-r border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @if($discounts->isEmpty())
                    <tr>
                        <td colspan="5" class="py-2 px-2 text-center text-gray-700 text-sm border-l border-b border-r">
                            Tidak ada data diskon yang tersedia
                        </td>
                    </tr>
                @else
                    @foreach($discounts as $discount)
                        <tr class="hover:bg-sky-50 border-b border-l border-r">
                        <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border=l border-gray-200">{{ $loop->iteration }}</td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">{{ $discount->coupon_code }}</td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">{{ $discount->discount_percentage }}%</td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">{{ \Carbon\Carbon::parse($discount->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($discount->end_date)->translatedFormat('d F Y') }}</td>
                            <td class="py-3 px-2 text-center border-b border=r border-gray-200">
                                <div class="flex justify-center space-x-6">
                                <!-- Tombol Lihat Detail -->
                                <a href="#" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat"
                                    onclick="openDiscountModal(
                                    '{{ $discount->id }}',
                                    '{{ $discount->coupon_code }}',
                                    '{{ $discount->discount_percentage }}',
                                    '{{ $discount->start_date }}',
                                    '{{ $discount->end_date }}',
                                    '{{ $discount->start_time }}',
                                    '{{ $discount->end_time }}',
                                    {{ $discount->apply_to_all ? 'true' : 'false' }}
                                )">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                </a>

                                <!-- Tombol Edit -->
                                <a href="{{ route('discount.edit', $discount->id) }}" class="text-white bg-yellow-300 p-1 rounded-md  hover:bg-yellow-200" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <!-- Tombol Hapus -->
                                <button type="button" class="text-white bg-red-400 p-1 rounded-md hover:bg-red-300" onclick="openDeleteModal('{{ route('discount.destroy', $discount->id) }}')" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            </div>
        </div>
        <div class="pagination mt-4">
            {{ $discounts->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-[1000]">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-md font-medium text-center">Apakah Anda yakin ingin menghapus diskon ini?</h3>
        <div class="mt-4 flex justify-center space-x-3">
            <button onclick="closeDeleteModal()" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded-lg">
                Batal
            </button>
            <form id="deleteForm" method="POST" action="" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-400 hover:bg-red-300 text-white font-semibold py-2 px-4 rounded-lg">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Discount -->
<div id="discountModal" class="fixed inset-0 flex items-center text-left justify-center bg-black bg-opacity-50 hidden z-[1000]">
    <div class="bg-white p-4 rounded-md mx-4 w-full md:w-[700px]">
    <div class="flex items-center justify-between w-full mb-4">
        <h2 class="text-gray-700 font-semibold w-full text-center text-lg">Detail Discount</h2>
        <button class="bg-red-400 hover:bg-red-300 text-white px-2 py-0.5 rounded-md" onclick="closeDiscountModal()">x</button>
    </div>
        <p class="text-gray-700 font-semibold">Kode Kupon:<span id="modalCouponCode"></span></p>
        <p class="text-gray-700 font-semibold">Apply To All: <span id="modalApplyToAll"></span></p>
        <!-- Tabel dengan border bottom dashed -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse mt-4">
                <thead class="bg-gray-100">
                    <tr class="border-b border-dashed border-gray-400">
                        <th class="px-4 py-2 text-center text-sm text-gray-700">Potongan</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700">Tanggal Mulai</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700">Tanggal Selesai</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700">Jam Mulai</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700">Jam Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-dashed border-gray-300">
                        <td class="px-4 py-2 text-sm text-gray-700 text-center"><span id="modalDiscountPercentage"></span>%</td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-center"><span id="modalStartDate"></span></td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-center"><span id="modalEndDate"></span></td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-center"><span id="modalStartTime"></span></td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-center"><span id="modalEndTime"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
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
    
    // untuk menampilkan detail diskon 
    function openDiscountModal(id, couponCode, discountPercentage, startDate, endDate, startTime, endTime, applyToAll) {
        // Isi data ke modal
        document.getElementById('modalCouponCode').textContent = couponCode;
        document.getElementById('modalDiscountPercentage').textContent = discountPercentage;
        document.getElementById('modalStartDate').textContent = new Date(startDate).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById('modalEndDate').textContent = new Date(endDate).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById('modalStartTime').textContent = startTime;
        document.getElementById('modalEndTime').textContent = endTime;
        document.getElementById('modalApplyToAll').textContent = applyToAll ? 'Yes' : 'No';
            // Tampilkan modal
            document.getElementById('discountModal').classList.remove('hidden');
        }

    function closeDiscountModal() {
        document.getElementById('discountModal').classList.add('hidden');
    }

    function openDeleteModal(url) {
        // Set action URL form delete sesuai dengan discount yang dipilih
        document.getElementById('deleteForm').action = url;
        // Tampilkan modal
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        // Sembunyikan modal
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
