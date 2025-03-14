@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto">
    @php
        // Gunakan tahun yang diterima dari controller
        $currentYear = $year;
    @endphp
    <!-- Laporan Pendapatan Mentor (2% Komisi) -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex flex-col items-center mb-4">
            <div class="flex items-center space-x-4">
                <h2 class="text-xl font-semibold inline-block pb-1 text-gray-700">
                    Laporan Pendapatan Mentor (2% Komisi) - Tahun {{ $currentYear }}
                </h2>
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
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('revenueChart').getContext('2d');

    // Data yang diterima dari controller
    const coursesRevenue = @json($coursesRevenue);
    const monthLabels = @json($monthNames);

    // Siapkan dataset untuk setiap kursus
    const datasets = [];
    const colors = [
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)',
        'rgba(153, 102, 255, 0.6)',
        'rgba(255, 159, 64, 0.6)'
    ];
    let colorIndex = 0;
    // coursesRevenue diharapkan berbentuk objek dengan key course_id
    for (const courseId in coursesRevenue) {
        if (coursesRevenue.hasOwnProperty(courseId)) {
            const course = coursesRevenue[courseId];
            // Pastikan data monthly tersedia untuk 12 bulan
            const data = [];
            for (let i = 1; i <= 12; i++) {
                data.push(course.monthly[i] || 0);
            }
            datasets.push({
                label: course.title,
                data: data,
                borderColor: colors[colorIndex % colors.length],
                backgroundColor: colors[colorIndex % colors.length],
                fill: false,
                tension: 0.1
            });
            colorIndex++;
        }
    }

    // Buat grafik menggunakan Chart.js
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: datasets
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
            }
        }
    });

    // Update grafik saat tahun dipilih
    document.getElementById('yearFilter').addEventListener('change', function () {
        const selectedYear = this.value;
        window.location.href = `?year=${selectedYear}`;
    });
});
</script>
@endsection
