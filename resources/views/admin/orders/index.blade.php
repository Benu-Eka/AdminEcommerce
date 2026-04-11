@extends('admin.layout.app')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900">Kelola Pesanan</h1>
        <p class="text-gray-500 text-sm mt-1">Konfirmasi dan update status pesanan pelanggan.</p>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- Tabs --}}
    <div class="bg-white rounded-2xl shadow-sm border p-2 mb-6">
        <div class="flex gap-1 overflow-x-auto">
            <a href="{{ route('admin.orders.index', ['tab' => 'dibayar']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ ($activeTab ?? 'dibayar') == 'dibayar' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-500 hover:bg-gray-50' }}">
                Dibayar <span class="ml-1 text-xs opacity-70">({{ $orders['dibayar']->count() }})</span>
            </a>
            <a href="{{ route('admin.orders.index', ['tab' => 'dikemas']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ ($activeTab ?? '') == 'dikemas' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-500 hover:bg-gray-50' }}">
                Dikemas <span class="ml-1 text-xs opacity-70">({{ $orders['dikemas']->count() }})</span>
            </a>
            <a href="{{ route('admin.orders.index', ['tab' => 'dikirim']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ ($activeTab ?? '') == 'dikirim' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-500 hover:bg-gray-50' }}">
                Dikirim <span class="ml-1 text-xs opacity-70">({{ $orders['dikirim']->count() }})</span>
            </a>
            <a href="{{ route('admin.orders.index', ['tab' => 'selesai']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ ($activeTab ?? '') == 'selesai' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-500 hover:bg-gray-50' }}">
                Selesai <span class="ml-1 text-xs opacity-70">({{ $orders['selesai']->count() }})</span>
            </a>
            <a href="{{ route('admin.orders.index', ['tab' => 'permintaan_batal']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ ($activeTab ?? '') == 'permintaan_batal' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-500 hover:bg-gray-50' }}">
                Permintaan Batal <span class="ml-1 text-xs opacity-70">({{ $orders['permintaan_batal']->count() }})</span>
            </a>
            <a href="{{ route('admin.orders.index', ['tab' => 'dibatalkan']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ ($activeTab ?? '') == 'dibatalkan' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-500 hover:bg-gray-50' }}">
                Dibatalkan <span class="ml-1 text-xs opacity-70">({{ $orders['dibatalkan']->count() }})</span>
            </a>
        </div>
    </div>

    {{-- Tabel Pesanan --}}
    @php $currentOrders = $orders[$activeTab ?? 'dibayar'] ?? collect(); @endphp

    @if($currentOrders->isEmpty())
        <div class="bg-white rounded-2xl border border-dashed border-gray-200 py-16 text-center">
            <i class="fa-regular fa-folder-open text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-400 font-medium">Tidak ada pesanan dengan status ini.</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 text-xs uppercase font-bold border-b">
                        <th class="py-4 px-5">Order ID</th>
                        <th class="py-4 px-5">Pelanggan</th>
                        <th class="py-4 px-5">Produk</th>
                        <th class="py-4 px-5 text-right">Total</th>
                        <th class="py-4 px-5">Tanggal</th>
                        <th class="py-4 px-5">Status</th>
                        <th class="py-4 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($currentOrders as $order)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-4 px-5">
                            <span class="font-bold text-sm text-gray-800">{{ $order->order_id }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <div>
                                <p class="font-semibold text-sm text-gray-800">{{ $order->nama_penerima ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $order->pelanggan->nama_pelanggan ?? '-' }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-5">
                            <div class="space-y-1">
                                @foreach($order->items->take(2) as $item)
                                    <p class="text-xs text-gray-600">
                                        {{ $item->nama_barang ?? ($item->barang->nama_barang ?? '-') }}
                                        <span class="text-gray-400">× {{ $item->quantity }}</span>
                                    </p>
                                @endforeach
                                @if($order->items->count() > 2)
                                    <p class="text-xs text-gray-400">+{{ $order->items->count() - 2 }} item lainnya</p>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <span class="font-bold text-sm">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="text-xs text-gray-500">{{ $order->created_at?->format('d M Y H:i') }}</span>
                        </td>
                        <td class="py-4 px-5">
                            @php
                                $statusColors = [
                                    'dibayar' => 'bg-green-100 text-green-700',
                                    'dikemas' => 'bg-orange-100 text-orange-700',
                                    'dikirim' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-emerald-100 text-emerald-700',
                                ];
                            @endphp
                            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-5 text-center">
                            @if($order->cancel_requested == 1)
                                <form action="{{ route('admin.orders.approveCancel', $order->order_id) }}" method="POST"
                                      onsubmit="return confirm('Setujui pembatalan ini? Dana akan otomatis direfund ke saldo pelanggan.')">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">
                                        <i class="fa-solid fa-check mr-1"></i> Setujui Batal
                                    </button>
                                </form>
                            @elseif($order->status === 'dibayar')
                                <form action="{{ route('admin.orders.updateStatus', $order->order_id) }}" method="POST" 
                                      onsubmit="return confirm('Konfirmasi pesanan ini sebagai DIKEMAS?')">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">
                                        <i class="fa-solid fa-box mr-1"></i> Kemas
                                    </button>
                                </form>
                            @elseif($order->status === 'dikemas')
                                <form action="{{ route('admin.orders.updateStatus', $order->order_id) }}" method="POST"
                                      onsubmit="return confirm('Konfirmasi pesanan ini sebagai DIKIRIM?')">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">
                                        <i class="fa-solid fa-truck mr-1"></i> Kirim
                                    </button>
                                </form>
                            @elseif($order->status === 'dikirim')
                                <span class="text-xs text-gray-400 italic">Menunggu konfirmasi pelanggan</span>
                            @elseif($order->status === 'selesai')
                                <span class="text-xs text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i> Selesai</span>
                            @elseif($order->status === 'batal')
                                <span class="text-xs text-red-600 font-semibold"><i class="fa-solid fa-times-circle mr-1"></i> Dibatalkan</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
