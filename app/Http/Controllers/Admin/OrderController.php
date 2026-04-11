<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'dibayar');

        $orders = [
            'dibayar' => Order::where('status', 'dibayar')
                ->where('cancel_requested', 0)
                ->with(['pelanggan', 'items.barang'])
                ->latest()
                ->get(),

            'dikemas' => Order::where('status', 'dikemas')
                ->with(['pelanggan', 'items.barang'])
                ->latest()
                ->get(),

            'dikirim' => Order::where('status', 'dikirim')
                ->with(['pelanggan', 'items.barang'])
                ->latest()
                ->get(),

            'selesai' => Order::where('status', 'selesai')
                ->with(['pelanggan', 'items.barang'])
                ->latest()
                ->get(),

            'permintaan_batal' => Order::where('cancel_requested', 1)
                ->whereIn('status', ['pending', 'dibayar'])
                ->with(['pelanggan', 'items.barang'])
                ->latest()
                ->get(),

            'dibatalkan' => Order::where('status', 'batal')
                ->with(['pelanggan', 'items.barang'])
                ->latest()
                ->get(),
        ];

        return view('admin.orders.index', compact('orders', 'activeTab'));
    }

    public function updateStatus(Request $request, $orderId)
    {
        $order = Order::where('order_id', $orderId)->firstOrFail();

        $allowedTransitions = [
            'dibayar' => 'dikemas',
            'dikemas' => 'dikirim',
        ];

        $currentStatus = $order->status;

        if (!isset($allowedTransitions[$currentStatus])) {
            return back()->with('error', 'Status pesanan tidak dapat diubah.');
        }

        if ($order->cancel_requested) {
            return back()->with('error', 'Pesanan ini sedang dalam pengajuan pembatalan.');
        }

        $newStatus = $allowedTransitions[$currentStatus];
        $order->status = $newStatus;
        $order->save();

        $labels = [
            'dikemas' => 'dikemas',
            'dikirim' => 'dikirim',
        ];

        return back()->with('success', "Pesanan {$orderId} berhasil diubah ke status: {$labels[$newStatus]}");
    }

    public function approveCancel($orderId)
    {
        $order = Order::where('order_id', $orderId)
            ->where('cancel_requested', 1)
            ->with('pelanggan')
            ->firstOrFail();

        $oldStatus = $order->status;
        $pelanggan = $order->pelanggan;

        \Illuminate\Support\Facades\DB::transaction(function () use ($order, $pelanggan, $oldStatus) {
            if ($oldStatus === 'dibayar') {
                $saldoSebelum = (float) $pelanggan->saldo;
                $refundAmount = (float) $order->total;
                $saldoSesudah = $saldoSebelum + $refundAmount;

                $pelanggan->saldo = $saldoSesudah;
                $pelanggan->save();

                // Because we are in Admin App, we must import SaldoTransaction or use DB builder
                // Since SaldoTransaction is in App\Models\SaldoTransaction, we can use it if it exists in Admin's App namespace.
                // Admin app shares the database but its models are in `AdminEcommerce\app\Models`.
                // Does AdminEcommerce have SaldoTransaction? No, it's not created there. 
                // Let's create it via DB insert to avoid model issues.
                \Illuminate\Support\Facades\DB::table('saldo_transactions')->insert([
                    'pelanggan_id' => $pelanggan->pelanggan_id,
                    'order_id' => $order->order_id,
                    'tipe' => 'refund',
                    'jumlah' => $refundAmount,
                    'saldo_sebelum' => $saldoSebelum,
                    'saldo_sesudah' => $saldoSesudah,
                    'keterangan' => 'Refund pembatalan pesanan (Disetujui Admin) ' . $order->order_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $order->status = 'batal';
            $order->cancel_requested = 0;
            $order->save();
        });

        return back()->with('success', "Pembatalan pesanan {$order->order_id} disetujui. Dana telah direfund ke saldo pelanggan.");
    }
}
