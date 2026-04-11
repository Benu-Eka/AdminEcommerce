@extends('admin.layout.app')

@section('title', 'Dashboard Admin')

@section('content')
@php
    $totalProduk = $totalProduk ?? 0;
    $newThisMonth = $newThisMonth ?? 0;
    $totalPesanan = $totalPesanan ?? 0;
    $pesananHariIni = $pesananHariIni ?? 0;
    $totalPendapatan = $totalPendapatan ?? 0;
    $pendapatanBulanIni = $pendapatanBulanIni ?? 0;
    $pendapatanBulanLalu = $pendapatanBulanLalu ?? 0;
    $monthlyRevenue = $monthlyRevenue ?? array_fill(0, 12, 0);
    $selectedYear = $selectedYear ?? now()->year;
    $topProducts = $topProducts ?? collect();

    // Hitung persentase perubahan pendapatan
    $persenPendapatan = $pendapatanBulanLalu > 0
        ? round((($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100, 1)
        : ($pendapatanBulanIni > 0 ? 100 : 0);
@endphp
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
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalProduk) }}</h3>
                <span class="text-green-500 text-xs font-semibold">+{{ $newThisMonth }} Baru bulan ini</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center transition hover:shadow-md">
            <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Total Pesanan</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalPesanan) }}</h3>
                <span class="text-green-500 text-xs font-semibold">+{{ $pesananHariIni }} Hari ini</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center transition hover:shadow-md">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <span class="{{ $persenPendapatan >= 0 ? 'text-green-500' : 'text-red-500' }} text-xs font-semibold">
                    {{ $persenPendapatan >= 0 ? '+' : '' }}{{ $persenPendapatan }}% dari bulan lalu
                </span>
            </div>
        </div>
    </div>

    {{-- Grafik & Recent Activities --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Grafik Penjualan --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-800">Grafik Pendapatan Bulanan</h2>
                <select id="yearSelector" class="text-sm border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                        onchange="window.location.href='{{ route('admin.dashboard') }}?year=' + this.value">
                    @for ($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endfor
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
                @forelse($topProducts as $p)
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg mr-4 overflow-hidden flex-shrink-0">
                            @php
                                $imgSrc = 'https://via.placeholder.com/50';
                                if ($p->foto_produk) {
                                    $imgSrc = Str::startsWith($p->foto_produk, ['http', 'https', 'data:', '/storage', 'build'])
                                        ? $p->foto_produk
                                        : asset('build/assets/' . $p->foto_produk);
                                }
                            @endphp
                            <img src="{{ $imgSrc }}" alt="produk" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='https://placehold.co/50x50?text=No+Img';">
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-800">{{ $p->nama_barang }}</h4>
                            <p class="text-xs text-gray-500">{{ $p->total_sold }} Terjual</p>
                        </div>
                        <div class="text-sm font-bold text-green-600">Rp {{ number_format($p->harga_jual ?? 0, 0, ',', '.') }}</div>
                    </div>
                @empty
                    <div class="text-sm text-gray-400">Belum ada penjualan.</div>
                @endforelse
            </div>
            <a href="{{ route('admin.manajemenProduk.index') }}" class="w-full inline-block text-center mt-8 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition">
                Lihat Semua Produk
            </a>
        </div>
    </div>
</div>

{{-- Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const monthlyData = @json($monthlyRevenue);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: monthlyData,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5] },
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                            if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                            return 'Rp ' + value;
                        }
                    }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection