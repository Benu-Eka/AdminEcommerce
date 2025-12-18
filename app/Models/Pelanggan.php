<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $primaryKey = 'pelanggan_id';
    public $timestamps = false;

    public function pelanggan()
{
    return $this->belongsTo(Pelanggan::class, 'sender_id');
}
}
