@php
    // --- LOGIKA PENENTUAN ACTIVE STATE UNTUK DROPDOWN ---

    // Data Master paths
    $dataMasterActive = request()->is('barangs*') || 
                        request()->is('pelanggans*') || 
                        request()->is('kategori_pelanggan*') || 
                        request()->is('suppliers*') || 
                        request()->is('kategori_barang*');

    // Inventori Gudang paths
    $inventoriGudangActive = request()->is('katalog_barang*') || 
                             request()->is('stok-barang*') || 
                             request()->is('stock_opname*');
    
    // Manajemen Produk paths (BARU)
    $manajemenProdukActive = request()->is('katalog-produk*') ||
                             request()->is('kategori-produk*') ||
                             request()->is('pricing-rules*');
    
    // Fungsi untuk kelas link aktif utama
    $activeLinkClasses = 'bg-red-800 text-white shadow-xl shadow-red-950/70';
    $defaultLinkClasses = 'text-neutral-100';

    // Fungsi untuk kelas sub-link aktif
    $activeSubLinkClasses = 'bg-red-700/80 text-white font-semibold shadow-inner';
    $defaultSubLinkClasses = 'text-neutral-200';
@endphp

<div
    class="bg-gradient-to-b from-red-900 to-red-950 text-white w-68 space-y-6 py-7 px-4 fixed inset-y-0 left-0 z-40 h-screen 
           transform transition duration-300 ease-in-out md:relative md:translate-x-0 overflow-y-scroll"
    :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
    @click.away="sidebarOpen = false"
    {{-- Initial state ditentukan oleh apakah ada sub-menu yang aktif --}}
    x-data="{ 
        dataMasterOpen: {{ $dataMasterActive ? 'true' : 'false' }}, 
        inventoriGudangOpen: {{ $inventoriGudangActive ? 'true' : 'false' }},
        manajemenProdukOpen: {{ $manajemenProdukActive ? 'true' : 'false' }} {{-- State BARU --}}
    }"
>

    {{-- Logo / Branding --}}
    <img src="{{ asset('assets/images/Logo_fanjaya_1.png') }}" alt="Logo Fanjaya" class="w-36 mx-auto mb-6 object-contain">

    {{-- Dashboard - Link Utama --}}
    <a href="{{ route('admin.dashboard') }}"
        class="text-sm font-semibold flex items-center gap-3 w-full p-2.5 rounded-xl transition-all duration-200 
               hover:bg-red-800/70 hover:shadow-lg hover:shadow-red-950/80
               {{ request()->routeIs('admin.dashboard') ? $activeLinkClasses : $defaultLinkClasses }}">
        <i class="fa-regular fa-chart-bar text-xl w-6"></i>
        <span>Dashboard</span>
    </a>

    <nav class="space-y-1">
        
        <a href="/admin/manajemenProduk"
            class="flex items-center gap-3 text-sm font-medium w-full p-2.5 rounded-xl hover:bg-red-800/70 transition-all duration-200
            {{ $manajemenProdukActive ? $activeLinkClasses : $defaultLinkClasses }}">
            <i class="fa-solid fa-clipboard-check text-xl w-6"></i>
            <span>Manajemen Produk</span>
        </a>
        
        <a href="/admin/chat" 
            class="flex items-center gap-3 text-sm font-medium w-full p-2.5 rounded-xl hover:bg-red-800/70 transition-all duration-200
            {{ request()->is('admin/chat*') ? $activeLinkClasses : $defaultLinkClasses }}">
            <i class="fa-solid fa-users-gear text-xl w-6"></i>
            <span>Chat Pelanggan</span>
        </a>

        <a href="{{ route('admin.orders.index') }}" 
            class="flex items-center gap-3 text-sm font-medium w-full p-2.5 rounded-xl hover:bg-red-800/70 transition-all duration-200
            {{ request()->is('admin/orders*') ? $activeLinkClasses : $defaultLinkClasses }}">
            <i class="fa-solid fa-truck-fast text-xl w-6"></i>
            <span>Kelola Pesanan</span>
        </a>
            </nav>
</div>