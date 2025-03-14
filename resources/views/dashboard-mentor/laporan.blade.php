@extends('layouts.dashboard-mentor')

@section('content')
<div class="container mx-auto">
    @php
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 2); // Tahun saat ini hingga 5 tahun terakhir
    @endphp

    <!-- container info potongan royalti -->
    <div class="flex items-center p-3 mb-4 text-sm text-sky-700 rounded-lg bg-sky-200" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Info!</span> Setiap kursus yang dibeli oleh peserta sudah terpotong <strong>2%</strong> untuk admin
        </div>
    </div>

    <!-- Grafik Pendapatan -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex flex-col items-center mb-4">
            <div class="flex items-center space-x-4">
                <h2 class="text-xl font-semibold text-gray-700">
                    Laporan Pendapatan Bulanan
                </h2>
                <select id="yearFilter" class="p-1.5 border rounded-md focus:outline-none focus:ring focus:ring-sky-200" onchange="filterByYear()">
                    @foreach ($years as $availableYear)
                        <option value="{{ $availableYear }}" {{ $availableYear == request('year', $currentYear) ? 'selected' : '' }}>
                            {{ $availableYear }}
                        </option>
                    @endforeach
                </select>  
          
                <script>
                    function filterByYear() {
                        const year = document.getElementById('yearFilter').value;
                        const url = new URL(window.location.href);
                        url.searchParams.set('year', year); // Tambahkan parameter 'year' ke URL
                        window.location.href = url.toString(); // Redirect ke URL dengan parameter tahun
                    }
                </script>
            </div>   
            <div class="border-b-2 w-full mt-2"></div>
        </div>  
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const revenueData = @json($revenueData); // Data dari controller
    const months = @json($months); // Label bulan

    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: revenueData,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
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
            }
        }
    });
});

</script>
@endsection
