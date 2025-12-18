@extends('admin.layout.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Ringkasan Performa</h1>
        <p class="text-gray-500 text-sm">Selamat datang kembali, Admin. Berikut adalah statistik toko Anda hari ini.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center transition hover:shadow-md">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Total Produk</p>
                <h3 class="text-2xl font-bold text-gray-800">1,248</h3>
                <span class="text-green-500 text-xs font-semibold">+12 Baru bulan ini</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center transition hover:shadow-md">
            <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Total Pesanan</p>
                <h3 class="text-2xl font-bold text-gray-800">450</h3>
                <span class="text-green-500 text-xs font-semibold">+5% dari kemarin</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center transition hover:shadow-md">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-gray-800">Rp 125.400.000</h3>
                <span class="text-blue-500 text-xs font-semibold">Target 85% tercapai</span>
            </div>
        </div>
    </div>

    {{-- Grafik & Recent Activities --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Grafik Penjualan --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-800">Grafik Penjualan Bulanan</h2>
                <select class="text-sm border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    <option>Tahun 2024</option>
                    <option>Tahun 2023</option>
                </select>
            </div>
            <div class="relative h-80">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Produk Terlaris / Aktivitas --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Top Selling</h2>
            <div class="space-y-4">
                {{-- Item 1 --}}
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-200 rounded-lg mr-4 overflow-hidden">
                        <img src="https://via.placeholder.com/50" alt="produk">
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-gray-800">Minyak Goreng 2L</h4>
                        <p class="text-xs text-gray-500">142 Terjual</p>
                    </div>
                    <div class="text-sm font-bold text-green-600">Rp 35k</div>
                </div>
                {{-- Item 2 --}}
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-200 rounded-lg mr-4 overflow-hidden">
                        <img src="https://via.placeholder.com/50" alt="produk">
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-gray-800">Beras Premium 5kg</h4>
                        <p class="text-xs text-gray-500">98 Terjual</p>
                    </div>
                    <div class="text-sm font-bold text-green-600">Rp 75k</div>
                </div>
            </div>
            <button class="w-full mt-8 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition">
                Lihat Semua Produk
            </button>
        </div>
    </div>
</div>

{{-- Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Pendapatan (Juta)',
                data: [12, 19, 15, 25, 22, 30],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection