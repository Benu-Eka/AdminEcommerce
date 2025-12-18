<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Contoh mengambil data untuk ditampilkan di dashboard
        $totalProduk = Barang::count();
        
        // Memanggil file: views/admin/products/dashboard.blade.php
        return view('admin.dashboard', compact('totalProduk'));
    }
}