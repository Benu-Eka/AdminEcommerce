<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Log;

class AdminChatController extends Controller
{
    /**
     * ===============================
     * 1. DAFTAR CHAT PELANGGAN
     * ===============================
     */
    public function index()
    {
        // Ambil pelanggan yang pernah chat
        $users = Message::where('sender_type', 'pelanggan')
            ->select('sender_id')
            ->distinct()
            ->get();

        // Ambil data pelanggan
        foreach ($users as $u) {
            $u->pelanggan = Pelanggan::where('pelanggan_id', $u->sender_id)->first();
        }

        return view('admin.chat.index', compact('users'));
    }

    public function chat($pelangganId)
{
    $pelanggan = Pelanggan::where('pelanggan_id', $pelangganId)->first();

    if (!$pelanggan) {
        $pelanggan = (object)[
            'pelanggan_id' => $pelangganId,
            'nama' => 'Pelanggan #' . $pelangganId,
        ];
    }

    // ✅ AMBIL PESAN
    $messages = Message::where(function ($q) use ($pelangganId) {
            $q->where('sender_id', $pelangganId)
              ->where('sender_type', 'pelanggan');
        })
        ->orWhere(function ($q) use ($pelangganId) {
            $q->where('receiver_id', $pelangganId)
              ->where('receiver_type', 'pelanggan');
        })
        ->orderBy('created_at')
        ->get();

    return view('admin.chat.chatroom', compact('pelanggan', 'messages'))
        ->with('user', $pelanggan); // agar konsisten dengan view lama
}


    /**
     * ===============================
     * 2. AMBIL CHAT (REALTIME)
     * ===============================
     */
    public function fetch($pelangganId)
    {
        $messages = Message::where(function ($q) use ($pelangganId) {
                // pesan dari pelanggan ke admin
                $q->where('sender_id', $pelangganId)
                  ->where('sender_type', 'pelanggan');
            })
            ->orWhere(function ($q) use ($pelangganId) {
                // pesan dari admin ke pelanggan
                $q->where('receiver_id', $pelangganId)
                  ->where('receiver_type', 'pelanggan');
            })
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    /**
     * ===============================
     * 3. KIRIM PESAN DARI ADMIN
     * ===============================
     */
    public function send(Request $req)
{
    // 1. Log data yang diterima dari browser (untuk cek apakah pelanggan_id ada)
    Log::info('Payload Chat:', $req->all());

    // 2. Log data user yang sedang login
    Log::info('Admin ID yang mengirim:', ['id' => auth()->id()]);

    try {
        $message = \App\Models\Message::create([
            'sender_id'     => auth()->id(),
            'sender_type'   => 'admin',
            'receiver_id'   => $req->pelanggan_id,
            'receiver_type' => 'pelanggan',
            'message'       => $req->message,
        ]);

        Log::info('Pesan berhasil disimpan:', ['id' => $message->id]);
        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        // 3. Log jika terjadi error SQL atau error lainnya
        Log::error('Gagal mengirim pesan chat: ' . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString() // Opsional: untuk melihat alur error lengkap
        ]);

        return response()->json(['error' => 'Server Error'], 500);
    }
}


}
