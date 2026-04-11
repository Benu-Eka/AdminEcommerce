@extends('admin.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Pesan Pelanggan</h2>
        <span class="bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">
            {{ $users->count() }} Percakapan
        </span>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @forelse($users as $u)
            @php
                $pel = $u->pelanggan;
                $displayName = $pel->username ?? $pel->nama_pelanggan ?? $pel->nama ?? $pel->email ?? ('Pelanggan #' . $u->sender_id);
                $initial = strtoupper(substr($displayName, 0, 1));
            @endphp
            <a href="{{ route('admin.chat.view', $u->sender_id) }}" 
               class="flex items-center p-4 border-b border-gray-50 hover:bg-red-50 transition-colors duration-200 group">
                
                <div class="relative">
                    <div class="w-12 h-12 bg-gradient-to-tr from-red-200 to-red-400 rounded-full flex items-center justify-center text-white font-bold">
                        {{ $initial }}
                    </div>
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-red-500 border-2 border-white rounded-full"></div>
                </div>

                <div class="ml-4 flex-1">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900 group-hover:text-red-700">
                            {{ $displayName }}
                        </h3>
                        <span class="text-xs text-gray-400">
                            {{-- $u->created_at->diffForHumans() --}} 2 min ago
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 truncate max-w-xs">
                        Klik untuk melihat detail percakapan...
                    </p>
                </div>

                <div class="ml-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
        @empty
            <div class="p-8 text-center text-gray-500">
                Belum ada pesan masuk.
            </div>
        @endforelse
    </div>
</div>
@endsection
