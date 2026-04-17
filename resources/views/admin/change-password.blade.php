@extends('admin.layout.app')

@section('title', 'Ganti Password')

@section('content')
<div class="max-w-lg mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900">Ganti Password</h1>
        <p class="text-gray-500 text-sm mt-1">Perbarui password akun admin Anda.</p>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Form --}}
    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <form method="POST" action="{{ route('admin.change-password.update') }}" class="space-y-5">
            @csrf

            {{-- Password Lama --}}
            <div>
                <label for="current_password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">
                    Password Lama
                </label>
                <input type="password"
                       id="current_password"
                       name="current_password"
                       required
                       class="w-full text-sm border-gray-200 focus:border-red-600 focus:ring-red-600/5 py-2.5 px-4 shadow-sm rounded-xl transition-all duration-200"
                       placeholder="Masukkan password lama">
                @error('current_password')
                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div>
                <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">
                    Password Baru
                </label>
                <input type="password"
                       id="password"
                       name="password"
                       required
                       class="w-full text-sm border-gray-200 focus:border-red-600 focus:ring-red-600/5 py-2.5 px-4 shadow-sm rounded-xl transition-all duration-200"
                       placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">
                    Konfirmasi Password Baru
                </label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       required
                       class="w-full text-sm border-gray-200 focus:border-red-600 focus:ring-red-600/5 py-2.5 px-4 shadow-sm rounded-xl transition-all duration-200"
                       placeholder="Ketik ulang password baru">
            </div>

            {{-- Info Admin --}}
            <div class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-100 rounded-xl">
                <div class="flex-shrink-0 bg-red-600 text-white p-2 rounded-lg shadow-sm">
                    <i class="fa-solid fa-user-shield text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Login sebagai</p>
                    <p class="text-sm text-gray-800 font-bold">{{ Auth::user()->nama_lengkap ?? Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-3 rounded-xl transition-all duration-300 shadow-lg shadow-red-500/20">
                <i class="fa-solid fa-key mr-2"></i> Simpan Password Baru
            </button>
        </form>
    </div>
</div>
@endsection
