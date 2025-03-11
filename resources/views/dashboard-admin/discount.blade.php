@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto bg-white rounded-lg p-5">
    <!-- Wrapper div dengan background putih dan padding -->
    <div class="">
        <h2 class="text-xl font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Diskon</h2>
        <div>
            <a href="{{ route('discount-tambah') }}" class="bg-sky-400 text-white px-4 py-2 rounded hover:bg-sky-300 transition duration-300">Tambah Diskon</a>
        </div>

        <!-- Tabel dengan responsivitas -->
        <div class="overflow-x-auto mt-6">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-sky-100 text-gray-700 text-sm">
                        <th class="py-2 px-2 text-center text-gray-700">Kode Kupon</th>
                        <th class="py-2 px-2 text-center text-gray-700">Diskon (%)</th>
                        <th class="py-2 px-2 text-center text-gray-700">Tanggal</th>
                        <th class="py-2 px-2 text-center text-gray-700">Jam</th>
                        <th class="py-2 px-2 text-center text-gray-700">Kursus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($discounts as $discount)
                        <tr class="hover:bg-sky-50">
                            <td class="py-3 px-2 text-gray-600 text-sm">{{ $discount->coupon_code }}</td>
                            <td class="py-3 px-2 text-gray-600 text-sm">{{ $discount->discount_percentage }}%</td>
                            <td class="py-3 px-2 text-gray-600 text-sm">{{ $discount->start_date }} - {{ $discount->end_date }}</td>
                            <td class="py-3 px-2 text-gray-600 text-sm">{{ $discount->start_time }} - {{ $discount->end_time }}</td>
                            <td class="py-3 px-2 text-gray-600 text-sm">
                                @if($discount->apply_to_all)
                                    <span class="inline-block px-3 py-1 text-white bg-sky-300 rounded-full">Semua Kursus</span>
                                @else
                                    @foreach($discount->courses as $course)
                                        <span class="inline-block px-3 py-1 text-white bg-blue-500 rounded-full mr-2">{{ $course->name }}</span>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
