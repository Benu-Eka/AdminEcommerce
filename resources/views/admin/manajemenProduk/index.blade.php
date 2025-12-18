@extends('admin.layout.app')

@section('title', 'Manajemen Produk')
@section('content')
<div class="p-4 md:p-8 bg-gray-50 min-h-screen">
    {{-- Header Section --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 flex items-center">
                    <span class="p-2 bg-red-100 rounded-lg mr-3">
                        <i class="fa-solid fa-boxes-stacked text-red-600"></i>
                    </span>
                    Manajemen Produk
                </h1>
                <p class="text-gray-500 mt-1 ml-12">Atur ketersediaan dan visibilitas produk di katalog e-commerce.</p>
            </div>
            
            <div class="flex items-center space-x-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-lg border border-blue-100">
                <i class="fa-solid fa-circle-info"></i>
                <span class="text-sm font-medium">Total Produk: {{ $products->count() }}</span>
            </div>
        </div>
    </div>

    {{-- Alert Section --}}
    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6 rounded-r-lg shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fa-solid fa-lightbulb text-amber-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-amber-800 font-semibold">Tips Manajemen</p>
                <p class="text-xs text-amber-700 mt-1">
                    Produk dengan status <span class="font-bold">"Tidak Aktif"</span> secara otomatis akan disembunyikan dari aplikasi pelanggan namun tetap tersimpan di database.
                </p>
            </div>
        </div>
    </div>

    {{-- Main Table Section --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Info Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">Tipe & Satuan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Harga Jual</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Status Visibility</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider text-right">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($products as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">{{ $p->nama_barang }}</div>
                            <div class="text-xs text-gray-500 font-mono tracking-tighter">{{ $p->kode_barang }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 text-xs font-semibold bg-gray-200 text-gray-700 rounded-md">{{ strtoupper($p->satuan_jual) }}</span>
                            <div class="text-[10px] text-gray-400 mt-1">{{ $p->tipe_harga_barang }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-emerald-600 font-mono">
                                Rp {{ number_format($p->harga_jual, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($p->is_visible)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                    <span class="w-2 h-2 mr-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                    Aktif di Toko
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                    <span class="w-2 h-2 mr-1.5 bg-red-400 rounded-full"></span>
                                    Tersembunyi
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.manajemenProduk.toggleVisibility', $p->kode_barang) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-lg transition-all 
                                        {{ $p->is_visible ? 'bg-orange-50 text-orange-600 hover:bg-orange-600 hover:text-white border border-orange-200' : 'bg-green-50 text-green-600 hover:bg-green-600 hover:text-white border border-green-200' }}">
                                    <i class="fa-solid {{ $p->is_visible ? 'fa-eye-slash' : 'fa-eye' }} mr-2 text-xs"></i>
                                    {{ $p->is_visible ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Empty State jika tidak ada data --}}
        @if($products->isEmpty())
        <div class="text-center py-12">
            <i class="fa-solid fa-box-open text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500 italic">Belum ada produk yang terdaftar.</p>
        </div>
        @endif
    </div>
</div>
@endsection