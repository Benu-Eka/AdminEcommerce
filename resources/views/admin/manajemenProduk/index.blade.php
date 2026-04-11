@extends('admin.layout.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="p-4 md:p-8 bg-gray-50 min-h-screen">
    {{-- Header Section --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 flex items-center">
                    <span class="p-2 bg-red-100 rounded-lg mr-3 shadow-sm">
                        <i class="fa-solid fa-boxes-stacked text-red-600"></i>
                    </span>
                    Manajemen Produk
                </h1>
                <p class="text-gray-500 mt-1 ml-0 md:ml-14">Atur ketersediaan dan visibilitas produk di katalog e-commerce.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3">
                {{-- Search Bar --}}
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
                    </span>
                    <input type="text" id="searchInput" placeholder="Cari produk..." 
                        class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all text-sm">
                </div>
                
                <div class="flex items-center space-x-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-lg border border-blue-100 w-full sm:w-auto justify-center">
                    <i class="fa-solid fa-circle-info"></i>
                    <span class="text-sm font-bold">Total: {{ $products->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Section --}}
    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6 rounded-r-lg shadow-sm">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fa-solid fa-lightbulb text-amber-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-amber-800 font-semibold uppercase tracking-wider">Tips Manajemen</p>
                <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                    Produk dengan status <span class="px-1.5 py-0.5 bg-amber-200 rounded font-bold text-amber-900">Tidak Aktif</span> secara otomatis akan disembunyikan dari aplikasi pelanggan namun tetap tersimpan secara aman di database.
                </p>
            </div>
        </div>
    </div>

    {{-- Main Table Section --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
            <table class="w-full text-left border-collapse" id="productTable">
                <thead class="sticky top-0 z-10 bg-gray-100 shadow-sm">
                    <tr class="border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Info Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">Tipe & Satuan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Harga Jual</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">Status Visibility</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider text-right">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $p)
                    <tr class="hover:bg-gray-50 transition-colors {{ !$p->is_visible ? 'bg-gray-50/50' : '' }} product-row">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-200 rounded mr-3 overflow-hidden flex-shrink-0 border border-gray-200">
                                    @php
                                        $imgSrc = 'https://via.placeholder.com/50';
                                        if ($p->foto_produk) {
                                            $imgSrc = Str::startsWith($p->foto_produk, ['http', 'https', 'data:', '/storage', 'build'])
                                                ? $p->foto_produk
                                                : asset('build/assets/' . $p->foto_produk);
                                        }
                                    @endphp
                                    <img src="{{ $imgSrc }}" alt="produk" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='https://placehold.co/40x40?text=Img';">
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 product-name">{{ $p->nama_barang }}</div>
                                    <div class="text-[11px] text-gray-500 font-mono tracking-tighter opacity-75 product-code">{{ $p->kode_barang }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2.5 py-1 text-[10px] font-bold bg-white border border-gray-300 text-gray-700 rounded-md shadow-sm uppercase italic">
                                {{ $p->satuan_jual }}
                            </span>
                            <div class="text-[10px] text-gray-400 mt-1.5 font-medium tracking-wide">{{ $p->tipe_harga_barang }}</div>
                        </td>
                        <td class="px-6 py-4 text-right sm:text-left">
                            <span class="text-sm font-bold text-emerald-600 font-mono">
                                Rp {{ number_format($p->harga_jual, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($p->is_visible)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                    <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>
                                    AKTIF DI TOKO
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-red-100 text-red-800 border border-red-200 opacity-75">
                                    <span class="w-2 h-2 mr-2 bg-red-400 rounded-full"></span>
                                    TERSEMBUNYI
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.manajemenProduk.toggleVisibility', $p->kode_barang) }}" method="POST" class="inline delete-form">
                                @csrf
                                <button type="submit" 
                                        class="toggle-btn inline-flex items-center px-4 py-2 text-[12px] font-bold rounded-lg transition-all transform hover:scale-105 active:scale-95
                                        {{ $p->is_visible ? 'bg-orange-50 text-orange-600 hover:bg-orange-600 hover:text-white border border-orange-200' : 'bg-green-50 text-green-600 hover:bg-green-600 hover:text-white border border-green-200' }}">
                                    <i class="fa-solid {{ $p->is_visible ? 'fa-eye-slash' : 'fa-eye' }} mr-2"></i>
                                    {{ $p->is_visible ? 'NONAKTIFKAN' : 'AKTIFKAN' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-20">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-box-open text-gray-200 text-5xl"></i>
                                </div>
                                <p class="text-gray-400 font-medium italic">Belum ada produk yang terdaftar di database.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Script Tambahan --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fitur Live Search Sederhana
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.product-row');
        
        rows.forEach(row => {
            let name = row.querySelector('.product-name').textContent.toLowerCase();
            let code = row.querySelector('.product-code').textContent.toLowerCase();
            if (name.includes(filter) || code.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    // Konfirmasi SweetAlert2 saat toggle status
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let btn = this.querySelector('.toggle-btn');
            let status = btn.textContent.trim().toLowerCase();
            
            Swal.fire({
                title: 'Konfirmasi Perubahan',
                text: `Apakah Anda yakin ingin ${status} produk ini?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection