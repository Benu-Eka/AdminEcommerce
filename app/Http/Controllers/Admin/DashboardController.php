<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ========== PRODUK ==========
        $totalProduk = Barang::count();

        $newThisMonth = Barang::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // ========== PESANAN ==========
        $totalPesanan = DB::table('orders')->count();

        $pesananHariIni = DB::table('orders')
            ->whereDate('created_at', today())
            ->count();

        // ========== PENDAPATAN ==========
        $totalPendapatan = DB::table('orders')
            ->where('status', 'dibayar')
            ->sum('total');

        // Pendapatan bulan ini vs bulan lalu (untuk persentase)
        $pendapatanBulanIni = DB::table('orders')
            ->where('status', 'dibayar')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        $pendapatanBulanLalu = DB::table('orders')
            ->where('status', 'dibayar')
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total');

        // ========== GRAFIK PENDAPATAN BULANAN ==========
        $selectedYear = $request->get('year', now()->year);

        $monthlyRevenueRaw = DB::table('orders')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(total) as pendapatan')
            )
            ->where('status', 'dibayar')
            ->whereYear('created_at', $selectedYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('pendapatan', 'bulan');

        // Isi 12 bulan (bulan tanpa data = 0)
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRevenue[] = (int) ($monthlyRevenueRaw[$i] ?? 0);
        }

        // ========== TOP SELLING ==========
        $topProducts = DB::table('order_items')
            ->select(
                'order_items.kode_barang',
                'barangs.nama_barang',
                'barangs.harga_jual',
                'barangs.foto_produk',
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->join('barangs', 'barangs.kode_barang', '=', 'order_items.kode_barang')
            ->join('orders', 'orders.order_id', '=', 'order_items.order_id')
            ->where('orders.status', 'dibayar')
            ->groupBy('order_items.kode_barang', 'barangs.nama_barang', 'barangs.harga_jual', 'barangs.foto_produk')
            ->orderByDesc('total_sold')
            ->limit(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'newThisMonth',
            'totalPesanan',
            'pesananHariIni',
            'totalPendapatan',
            'pendapatanBulanIni',
            'pendapatanBulanLalu',
            'monthlyRevenue',
            'selectedYear',
            'topProducts'
        ));
    }
}