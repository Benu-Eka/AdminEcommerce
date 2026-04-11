<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tambahkan baris ini untuk menyesuaikan primary key (PK)
    protected $primaryKey = 'user_id';

    // Tambahkan baris ini karena PK bukan integer (AUTO_INCREMENT)
    public $incrementing = false;

    // Tambahkan baris ini untuk menentukan tipe PK (varchar)
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'user_id',
    'nama_lengkap',
    'username', // Pastikan kolom ini ada
    'email',
    'password',
    'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Helper function untuk mengecek apakah user adalah Admin.
     */
public function isAdmin()
{
    // Mengubah string role menjadi huruf besar (UPPERCASE) sebelum membandingkan
    return strtoupper($this->role) === 'ADMIN'; 
}
}
