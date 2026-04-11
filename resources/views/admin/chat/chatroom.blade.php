@extends('admin.layout.app')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col h-[85vh] bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    
    <div class="px-6 py-4 bg-white border-b border-gray-100 flex items-center justify-between">
        @php
            $displayName = $user->username ?? $user->nama_pelanggan ?? $user->nama ?? $user->email ?? ('Pelanggan #' . ($user->pelanggan_id ?? $user->sender_id ?? '')); 
            $initial = strtoupper(substr($displayName, 0, 1));
        @endphp
        <div class="flex items-center">
            <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white font-bold mr-3 shadow-sm">
                {{ $initial }}
            </div>
            <div>
                <h2 class="font-bold text-gray-800 leading-tight text-red-700">
                    {{ $displayName }}
                </h2>
                <p class="text-xs text-red-500 flex items-center">
                    <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse mr-1"></span> Online
                </p>
            </div>
        </div>
        <a href="{{ route('admin.chat.index') }}" class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </a>
    </div>

    <div id="chatBox" class="flex-1 overflow-y-auto p-6 bg-[#f0f2f5] space-y-4">
        @foreach ($messages as $msg)
            @if($msg->sender_type == 'admin')
                <div class="flex justify-end">
                    <div class="max-w-[70%] bg-red-600 text-white px-4 py-2 rounded-2xl rounded-tr-none shadow-sm">
                        <p class="text-sm">{{ $msg->message }}</p>
                        <div class="text-[10px] text-red-100 mt-1 text-right">
                            {{ $msg->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="flex justify-start">
                    <div class="max-w-[70%] bg-white text-gray-800 px-4 py-2 rounded-2xl rounded-tl-none shadow-sm border border-gray-100">
                        <p class="text-sm">{{ $msg->message }}</p>
                        <div class="text-[10px] text-gray-400 mt-1">
                            {{ $msg->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="p-4 bg-white border-t border-gray-100">
        <div class="flex items-center bg-gray-100 rounded-full px-4 py-2 focus-within:ring-2 focus-within:ring-red-500 transition-all">
            <input type="text" id="messageInput"
                class="flex-1 bg-transparent border-none focus:ring-0 text-sm py-1"
                placeholder="Ketik pesan di sini..."
                autocomplete="off">
            
            <button id="sendBtn" class="ml-2 bg-red-600 hover:bg-red-700 text-white p-2 rounded-full transition-colors shadow-md flex items-center justify-center">
                <svg class="w-5 h-5 transform rotate-90" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chatBox');
    const sendBtn = document.getElementById('sendBtn');
    const input = document.getElementById('messageInput');

    // Fungsi Scroll ke Bawah
    function scrollBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    
    // Jalankan scroll saat pertama kali load
    scrollBottom();

    // FUNGSI KIRIM PESAN
    function sendMessage() {
        let message = input.value.trim();
        if (!message) return;

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let formData = new FormData();
        formData.append("message", message);
        formData.append("pelanggan_id", "{{ $user->pelanggan_id }}");

        fetch("{{ route('admin.chat.send') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
                "Accept": "application/json"
            },
            body: formData
        })
        .then(async res => {
            if (res.status === 419) {
                alert("Sesi telah berakhir, silakan refresh halaman.");
                location.reload();
            }
            return res.json();
        })
        .then(data => {
            input.value = "";
            loadMessages(); // Refresh chat segera setelah kirim
        })
        .catch(err => console.error("Error:", err));
    }

    // Event Listener Klik Tombol
    sendBtn.addEventListener('click', sendMessage);

    // Event Listener Enter di Keyboard
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // FUNGSI LOAD PESAN (REALTIME)
    function loadMessages() {
        fetch("{{ route('admin.chat.fetch', $user->pelanggan_id) }}")
            .then(res => res.json())
            .then(data => {
                let html = "";
                data.forEach(msg => {
                    const time = new Date(msg.created_at).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
                    
                    if (msg.sender_type === "admin") {
                        html += `
                            <div class="flex justify-end">
                                <div class="max-w-[70%] bg-red-600 text-white px-4 py-2 rounded-2xl rounded-tr-none shadow-sm">
                                    <p class="text-sm">${msg.message}</p>
                                    <div class="text-[10px] text-red-100 mt-1 text-right">${time}</div>
                                </div>
                            </div>`;
                    } else {
                        html += `
                            <div class="flex justify-start">
                                <div class="max-w-[70%] bg-white text-gray-800 px-4 py-2 rounded-2xl rounded-tl-none shadow-sm border border-gray-100">
                                    <p class="text-sm">${msg.message}</p>
                                    <div class="text-[10px] text-gray-400 mt-1">${time}</div>
                                </div>
                            </div>`;
                    }
                });
                
                // Simpan posisi scroll sebelum update
                const isAtBottom = chatBox.scrollHeight - chatBox.clientHeight <= chatBox.scrollTop + 100;
                
                chatBox.innerHTML = html;

                // Hanya scroll ke bawah jika user memang sudah di posisi bawah
                if (isAtBottom) {
                    scrollBottom();
                }
            });
    }

    // Interval fetch 1 detik
    setInterval(loadMessages, 1000);
</script>
@endsection