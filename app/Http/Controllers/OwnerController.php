<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Pengeluaran;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function transaksi(Request $request)
    {
        $search   = $request->query('q', '');
        $status   = $request->query('status', '');
        $bayar    = $request->query('bayar', '');
        $bulan    = $request->query('bulan', '');

        $query = Order::with('customer')
                      ->orderByDesc('created_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%$search%")
                  ->orWhereHas('customer', fn($c) => $c->where('nama', 'like', "%$search%"));
            });
        }

        if ($status) {
            $query->where('status_produksi', $status);
        }

        if ($bayar) {
            $query->where('status_pembayaran', $bayar);
        }

        if ($bulan) {
            [$y, $m] = explode('-', $bulan);
            $query->whereYear('tanggal_pesan', $y)->whereMonth('tanggal_pesan', $m);
        }

        $orders      = $query->paginate(15)->withQueryString();
        $statusList  = \App\Models\Order::$statusProduksiLabels;

        return view('owner.transaksi', compact('orders', 'statusList', 'search', 'status', 'bayar', 'bulan'));
    }

    public function exportTransaksiExcel(Request $request)
    {
        $search = $request->query('q', '');
        $status = $request->query('status', '');
        $bayar  = $request->query('bayar', '');
        $bulan  = $request->query('bulan', '');

        $query = Order::with('customer')->orderByDesc('created_at');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%$search%")
                  ->orWhereHas('customer', fn($c) => $c->where('nama', 'like', "%$search%"));
            });
        }
        if ($status) $query->where('status_produksi', $status);
        if ($bayar)  $query->where('status_pembayaran', $bayar);
        if ($bulan)  { [$y,$m] = explode('-',$bulan); $query->whereYear('tanggal_pesan',$y)->whereMonth('tanggal_pesan',$m); }

        $orders   = $query->get();
        $filename = 'transaksi_' . now()->format('Ymd') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($orders) {
            $fp = fopen('php://output', 'w');
            fputs($fp, "\xEF\xBB\xBF");
            fputcsv($fp, ['No', 'Invoice', 'Pelanggan', 'Tanggal', 'Deadline', 'Total', 'DP', 'Sisa', 'Status Produksi', 'Pembayaran']);
            foreach ($orders as $i => $o) {
                fputcsv($fp, [
                    $i + 1,
                    $o->invoice_number,
                    $o->customer->nama,
                    $o->tanggal_pesan->format('d/m/Y'),
                    $o->deadline ? $o->deadline->format('d/m/Y') : '-',
                    number_format($o->total_setelah_diskon, 0, ',', '.'),
                    number_format($o->dp, 0, ',', '.'),
                    number_format($o->sisa_tagihan, 0, ',', '.'),
                    $o->status_label,
                    $o->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum Lunas',
                ]);
            }
            fclose($fp);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportTransaksiPdf(Request $request)
    {
        $search = $request->query('q', '');
        $status = $request->query('status', '');
        $bayar  = $request->query('bayar', '');
        $bulan  = $request->query('bulan', '');

        $query = Order::with('customer')->orderByDesc('created_at');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%$search%")
                  ->orWhereHas('customer', fn($c) => $c->where('nama', 'like', "%$search%"));
            });
        }
        if ($status) $query->where('status_produksi', $status);
        if ($bayar)  $query->where('status_pembayaran', $bayar);
        if ($bulan)  { [$y,$m] = explode('-',$bulan); $query->whereYear('tanggal_pesan',$y)->whereMonth('tanggal_pesan',$m); }

        $orders   = $query->get();
        $judul    = 'Laporan Transaksi — ' . now()->isoFormat('D MMMM YYYY');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('owner.transaksi_pdf', compact('orders', 'judul'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('transaksi_' . now()->format('Ymd') . '.pdf');
    }

    public function laporan()
    {
        return view('owner.laporan');
    }

    public function piutang()
    {
        return view('owner.piutang');
    }

    public function monitoringProduksi()
    {
        return view('owner.monitoring');
    }
}
