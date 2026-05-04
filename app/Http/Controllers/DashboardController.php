<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function ownerDashboard()
    {
        return view('dashboard.owner');
    }

    public function adminDashboard()
    {
        return view('dashboard.admin');
    }

    public function kasirDashboard()
    {
        // Stat cards — data real dari tabel orders
        $totalPesanan   = Order::count();
        $menungguDP     = Order::where('status_pembayaran', 'belum')->count();
        $siapDiambil    = Order::where('status_produksi', 'siap_diambil')->count();
        $selesai        = Order::where('status_produksi', 'selesai')->count();

        // 10 pesanan terbaru
        $recentOrders = Order::with('customer')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('dashboard.kasir', compact(
            'totalPesanan',
            'menungguDP',
            'siapDiambil',
            'selesai',
            'recentOrders'
        ));
    }
}