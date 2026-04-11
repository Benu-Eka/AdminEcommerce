@props([
    'kodeBarang' => null,
    'name',
    'price',
    'oldPrice' => null,
    'discount' => null,
    'image',
    'productLink' => '#',  {{-- ✅ tambahkan default agar tidak undefined --}}
    'variasi' => null,
])

<a href="{{ $productLink }}" 
   class="block bg-white rounded-xl border border-gray-100 hover:border-green-500 hover:shadow-lg 
          overflow-hidden transition duration-300 relative group">

    {{-- 🔖 Label Diskon --}}
    @if($discount)
        <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-0.5 
                     rounded-full shadow z-10">
            {{ $discount }}
        </span>
    @endif

    {{-- 🖼️ Gambar Produk --}}
    <div class="p-4 flex flex-col items-center">
        <div class="h-36 w-full flex justify-center items-center mb-4 overflow-hidden">
            @if(Str::startsWith($image, ['http', 'https', 'data:', '/storage', 'build']))
                <img src="{{ $image }}" 
                     alt="{{ $name }}" 
                     class="h-full w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            @else
                <img src="{{ asset('build/assets/' . $image) }}" 
                     alt="{{ $name }}" 
                     onerror="this.onerror=null;this.src='https://placehold.co/150x150?text=No+Image';"
                     class="h-full w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            @endif
        </div>

        {{-- 📦 Informasi Produk --}}
        <div class="text-center w-full">
            <p class="text-sm text-gray-800 font-semibold h-10 overflow-hidden" title="{{ $name }}">
                {{ $name }}
            </p>

            {{-- 🧂 Variasi produk --}}
            @if($variasi)
                <p class="text-xs text-gray-500 mb-1">{{ $variasi }}</p>
            @endif

            {{-- ⭐ Rating --}}
            <div class="flex justify-center items-center mt-1 mb-2">
                <span class="text-yellow-400 text-xs">★★★★☆</span>
                <span class="text-gray-500 text-xs ml-1">(0)</span>
            </div>

            {{-- 💰 Harga --}}
            <div class="flex justify-center items-end space-x-2 mb-2">
                <span class="text-lg font-bold text-green-600">Rp {{ $price }}</span>
                @if($oldPrice)
                    <span class="text-xs text-gray-400 line-through">Rp {{ $oldPrice }}</span>
                @endif
            </div>

            {{-- 🛒 Tombol Tambah ke Keranjang --}}
            <form action="{{ route('cart.add') }}" method="POST" class="mt-2" onClick="event.stopPropagation();">
                @csrf
                <input type="hidden" name="kode_barang" value="{{ $kodeBarang }}">
                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-full 
                           text-sm font-semibold transition duration-300 opacity-0 group-hover:opacity-100">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Tambah ke Keranjang
                </button>
            </form>
        </div>
    </div>
</a>
