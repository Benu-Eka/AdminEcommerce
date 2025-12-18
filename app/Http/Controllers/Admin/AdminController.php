<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Barang;
use App\Models\Product; // Menggunakan Product Model untuk manajemen produk
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. Dashboard Utama
    public function dashboard()
    {
        // Logika untuk data dashboard (misalnya, menghitung statistik)
        // $totalOrders = Order::count();
        // $totalProducts = Product::count();

        return view('admin.dashboard');
    }

    // 2. Tampilan Manajemen Produk (Sesuai dengan route /manajemenProduk)
    public function manajemenProdukIndex()
    {
        // Ambil semua produk, biasanya dengan paginasi
        // $products = Product::orderBy('id', 'desc')->paginate(15);
        
        // Asumsi: Kita mengirim data produk ke view
        // return view('manajemenProduk.index', compact('products'));

        return view('admin.manajemen-produk.index');
    }

    // 3. Mengubah Status Tampil/Sembunyi Produk (Sesuai dengan route toggle-visibility)
    public function toggleVisibility(Request $request, Product $product)
    {
        // Menggunakan Route Model Binding untuk Product $product (lebih bersih)

        // Ubah status is_visible (asumsi field ini ada di tabel produk)
        $product->is_visible = !$product->is_visible;
        $product->save();

        // Cek jika ini adalah permintaan AJAX
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'is_visible' => $product->is_visible]);
        }
        
        return back()->with('success', 'Status tampilan produk berhasil diperbarui!');
    }
}