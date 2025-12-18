@extends('admin.dashboard')

@section('content')
<h2 class="text-xl font-bold mb-4">Daftar Chat Pelanggan</h2>

<div class="bg-white rounded shadow p-4">
    @foreach($users as $u)
        <a href="{{ route('admin.chat.view', $u->sender_id) }}" 
           class="block p-3 border-b hover:bg-gray-100">
            {{ $u->pelanggan->nama ?? 'Pelanggan #'.$u->sender_id }}
        </a>
    @endforeach
</div>
@endsection
