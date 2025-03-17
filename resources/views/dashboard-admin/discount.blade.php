@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto bg-white rounded-lg p-5">
    <!-- Wrapper div dengan background putih dan padding -->
    <div class="">
        <h2 class="text-xl font-semibold mb-6 border-b-2 pb-2 text-gray-700 text-center">Diskon</h2>
        <div class="inline-flex shadow-md shadow-sky-100 hover:shadow-none items-center space-x-2 text-white bg-sky-300 hover:bg-sky-200 font-semibold py-2 px-4 rounded-md">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
            </svg>
            <a href="{{ route('discount-tambah') }}" class=" text-white rounded transition duration-300">Tambah Diskon</a>
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
                    <th class="py-2 px-2 text-center text-gray-700 border-b border=l border-gray-200">No</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-gray-200">Kode Kupon</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-gray-200">Diskon (%)</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-gray-200">Tanggal</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border=r border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($discounts as $discount)
                        <tr class="hover:bg-sky-50 border-b border-l border-r">
                        <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border=l border-gray-200">1</td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">{{ $discount->coupon_code }}</td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">{{ $discount->discount_percentage }}%</td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">{{ \Carbon\Carbon::parse($discount->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($discount->endd_date)->translatedFormat('d F Y') }}</td>
                            <td class="py-3 px-2 text-center border-b border=r border-gray-200">
                                <div class="flex justify-center space-x-6">
                                    <!-- Tombol Lihat Detail -->
                                <a href="#"
                                class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat"
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

                                <!-- Modal Detail Discount -->
                                <div id="discountModal" class="fixed inset-0 flex items-center text-left justify-center bg-black bg-opacity-50 hidden z-50">
                                <div class="bg-white p-6 rounded-md w-96">
                                    <h2 class="text-xl font-bold mb-4">Detail Discount</h2>
                                    <p><strong>Coupon Code:</strong> <span id="modalCouponCode"></span></p>
                                    <p><strong>Discount Percentage:</strong> <span id="modalDiscountPercentage"></span>%</p>
                                    <p><strong>Start Date:</strong> <span id="modalStartDate"></span></p>
                                    <p><strong>End Date:</strong> <span id="modalEndDate"></span></p>
                                    <p><strong>Start Time:</strong> <span id="modalStartTime"></span></p>
                                    <p><strong>End Time:</strong> <span id="modalEndTime"></span></p>
                                    <p><strong>Apply To All:</strong> <span id="modalApplyToAll"></span></p>
                                    <div class="mt-4 text-right">
                                        <button class="bg-red-400 hover:bg-red-300 text-white px-4 py-2 rounded-md" onclick="closeDiscountModal()">Tutup</button>
                                    </div>
                                </div>
                                </div>

                                <script>
                                function openDiscountModal(id, couponCode, discountPercentage, startDate, endDate, startTime, endTime, applyToAll) {
                                    // Isi data ke modal
                                    document.getElementById('modalCouponCode').textContent = couponCode;
                                    document.getElementById('modalDiscountPercentage').textContent = discountPercentage;
                                    document.getElementById('modalStartDate').textContent = startDate;
                                    document.getElementById('modalEndDate').textContent = endDate;
                                    document.getElementById('modalStartTime').textContent = startTime;
                                    document.getElementById('modalEndTime').textContent = endTime;
                                    document.getElementById('modalApplyToAll').textContent = applyToAll ? 'Yes' : 'No';
                                    // Tampilkan modal
                                    document.getElementById('discountModal').classList.remove('hidden');
                                }

                                function closeDiscountModal() {
                                    document.getElementById('discountModal').classList.add('hidden');
                                }
                                </script>

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

                                <!-- Modal Konfirmasi -->
                                <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
                                    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                        <h3 class="text-md font-medium text-center">Apakah Anda yakin ingin menghapus diskon ini?</h3>
                                        <div class="mt-4 flex justify-center space-x-3">
                                            <button onclick="closeDeleteModal()" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded">
                                                Batal
                                            </button>
                                            <form id="deleteForm" method="POST" action="" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-400 hover:bg-red-300 text-white font-semibold py-2 px-4 rounded">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- JavaScript untuk Modal -->
                                <script>
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
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
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
</script>
@endsection
