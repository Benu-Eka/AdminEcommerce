<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';
    protected $primaryKey = 'kode_barang'; // Sesuai file SQL
    public $incrementing = false; // Karena primary key adalah varchar
    protected $keyType = 'string';

    protected $fillable = [
        'kode_barang', 'nama_barang', 'satuan_jual', 'kategori_barang_id',
        'id_supplier', 'jml_barang_per_karton', 'foto_produk', 'is_visible',
        'tipe_harga_barang', 'harga_jual', 'harga_beli', 'berlaku_mulai'
    ];
}