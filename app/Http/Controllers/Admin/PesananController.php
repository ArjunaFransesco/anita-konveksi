<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q', '');
        $status = $request->query('status', '');

        $query = Order::with(['customer', 'details'])->orderByDesc('created_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%$search%")
                  ->orWhereHas('customer', fn($c) => $c->where('nama', 'like', "%$search%"));
            });
        }

        if ($status) {
            $query->where('status_produksi', $status);
        }

        $orders = $query->paginate(15)->withQueryString();
        $statusList = Order::$statusProduksiLabels;

        return view('admin.pesanan.index', compact('orders', 'search', 'status', 'statusList'));
    }

    public function updateStatus(Request $request, $id)
    {
        $keys = implode(',', array_keys(Order::$statusProduksiLabels));
        $request->validate([
            'status_produksi' => "required|in:{$keys}",
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status_produksi' => $request->status_produksi,
        ]);

        return back()->with('success', 'Status produksi berhasil diupdate');
    }
}

