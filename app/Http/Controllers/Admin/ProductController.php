<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Barang::all();
        // Memanggil folder admin -> folder manajemenProduk -> index.blade.php
        return view('admin.manajemenProduk.index', compact('products'));
    }

    public function toggleVisibility($kodeBarang)
    {
        // Mencari produk berdasarkan primary key 'kode_barang'
        $barang = Barang::findOrFail($kodeBarang);
        
        // Membalikkan nilai is_visible (0 jadi 1, 1 jadi 0)
        $barang->is_visible = !$barang->is_visible;
        $barang->save();

        return back()->with('success', 'Status visibilitas produk berhasil diperbarui!');
    }
}