@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <!-- Total Pendapatan -->
        <div class="font-semibold">
            <p class="text-gray-700 font-semibold">Total Pendapatan Admin: <span class="text-red-500 font-semibold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span></p>
        </div>

        <div class="flex flex-col items-center mb-4">
            <div class="flex items-center space-x-4">
                <h2 class="text-xl font-semibold inline-block pb-1 text-gray-700">
                    Laporan Pendapatan Mentor (2% Komisi)
                </h2>
                @php
                    $years = range(2023, 2025);
                    $currentYear = isset($year) ? $year : date('Y');
                @endphp
                <select id="yearFilter" class="p-1 border rounded-md focus:outline-none focus:ring focus:ring-sky-200">
                    @foreach ($years as $availableYear)
                        <option value="{{ $availableYear }}" {{ $availableYear == $currentYear ? 'selected' : '' }}>
                            {{ $availableYear }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        <!-- Grafik -->
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Pendapatan Per Kursus -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Detail Pendapatan per Kursus</h3>
        <div class="overflow-x-auto">
           <div class="min-w-full w-64">
           @if (count($coursesRevenue) > 0)
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-sky-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border-l border-t text-center">No</th>
                            <th class="px-4 py-2 text-left border-t">Judul Kursus</th>
                            <th class="px-4 py-2 text-right border-t">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach ($paginatedCourses as $course)
                        <tr class="hover:bg-sky-50">
                            <td class="px-4 py-2 text-gray-700 text-sm border-l border-b text-center">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-2 text-gray-700 border-b">{{ $course['title'] }}</td>
                            <td class="px-4 py-2 text-right text-red-500 border-r border-b">
                                Rp. {{ number_format(array_sum($course['monthly']), 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 text-sm">Belum ada pendapatan</p>
            @endif
           </div>
        </div>
        <div class="mt-4">
            {{ $paginatedCourses->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('revenueChart').getContext('2d');

    const coursesRevenue = @json($coursesRevenue);
    const monthLabels = @json($monthNames);

    // Buat array 12 bulan dan jumlahkan semua pendapatan kursus untuk tiap bulan
    const totalPerMonth = Array(12).fill(0);
    for (const courseId in coursesRevenue) {
        if (coursesRevenue.hasOwnProperty(courseId)) {
            const monthly = coursesRevenue[courseId].monthly;
            for (let i = 1; i <= 12; i++) {
                totalPerMonth[i - 1] += monthly[i] || 0;
            }
        }
    }

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Total Pendapatan Bulanan',
                data: totalPerMonth,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Pendapatan (Rp)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    document.getElementById('yearFilter').addEventListener('change', function () {
        const selectedYear = this.value;
        window.location.href = `?year=${selectedYear}`;
    });
});
</script>
@endsection
