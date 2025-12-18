@extends('admin.layout.app')

@section('content')

<h2 class="text-lg font-bold mb-3">
    Chat dengan: {{ $user->pelanggan->nama ?? 'Pelanggan #' . $user->sender_id }}
</h2>

<div id="chatBox" class="h-[65vh] overflow-y-auto bg-gray-100 p-4 rounded shadow">

    @foreach ($messages as $msg)
        @if($msg->sender_type == 'admin')
            <div class="flex justify-end mb-2">
                <div class="bg-blue-600 text-white px-3 py-2 rounded-lg">
                    {{ $msg->message }}
                    <div class="text-xs text-blue-200">
                        {{ $msg->created_at->format('H:i') }}
                    </div>
                </div>
            </div>
        @else
            <div class="flex mb-2">
                <div class="bg-gray-300 text-gray-900 px-3 py-2 rounded-lg">
                    {{ $msg->message }}
                    <div class="text-xs text-gray-700">
                        {{ $msg->created_at->format('H:i') }}
                    </div>
                </div>
            </div>
        @endif
    @endforeach

</div>

<div class="mt-3 flex">
    <input type="text" id="messageInput"
        class="w-full border rounded-l px-3 py-2"
        placeholder="Ketik pesan...">

    <button id="sendBtn"
        class="bg-blue-600 text-white px-4 rounded-r">
        Kirim
    </button>
</div>


<script>
const chatBox = document.getElementById('chatBox');
const sendBtn = document.getElementById('sendBtn');
const input = document.getElementById('messageInput');

function scrollBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}
scrollBottom();

// SEND MESSAGE
sendBtn.addEventListener('click', () => {
    let message = input.value.trim();
    if (!message) return;

    // Ambil token dari meta tag (cara paling aman)
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let formData = new FormData();
    formData.append("message", message);
    formData.append("pelanggan_id", "{{ $user->pelanggan_id }}");

    fetch("{{ route('admin.chat.send') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token, // Gunakan variabel token
            "Accept": "application/json" // Beritahu Laravel ini request JSON
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
        loadMessages();
    })
    .catch(err => console.error("Error:", err));
});

// FETCH REALTIME 1 DETIK
function loadMessages() {
    fetch("{{ route('admin.chat.fetch', $user->pelanggan_id) }}")
        .then(res => res.json())
        .then(data => {
            chatBox.innerHTML = "";
            data.forEach(msg => {
                if (msg.sender_type === "admin") {
                    chatBox.innerHTML += `
                        <div class="flex justify-end mb-2">
                            <div class="bg-blue-600 text-white px-3 py-2 rounded-lg">
                                ${msg.message}
                                <div class="text-xs text-blue-200">
                                    ${new Date(msg.created_at).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}
                                </div>
                            </div>
                        </div>`;
                } else {
                    chatBox.innerHTML += `
                        <div class="flex mb-2">
                            <div class="bg-gray-300 text-gray-900 px-3 py-2 rounded-lg">
                                ${msg.message}
                                <div class="text-xs text-gray-700">
                                    ${new Date(msg.created_at).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}
                                </div>
                            </div>
                        </div>`;
                }
            });

            scrollBottom();
        });
}

setInterval(loadMessages, 1000);
</script>

@endsection
