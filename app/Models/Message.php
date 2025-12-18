<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Pastikan User dan Pelanggan di-import jika Anda menggunakan relasi ini
use App\Models\User; 
use App\Models\Pelanggan; 

class Message extends Model
{
    // WAJIB: Tambahkan properti $fillable untuk Mass Assignment
    protected $fillable = [
        'sender_id', 
        'sender_type', 
        'receiver_id', 
        'receiver_type', 
        'message', 
        // Tambahkan kolom lain jika ada (misal: 'chat_session_id')
    ];

    public function senderUser()
    {
        // Asumsi sender_id merujuk ke PK 'user_id' di tabel users
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }

    public function receiverPelanggan()
    {
        // Asumsi receiver_id merujuk ke PK 'pelanggan_id' di tabel pelanggans
        return $this->belongsTo(Pelanggan::class, 'receiver_id', 'pelanggan_id');
    }
}