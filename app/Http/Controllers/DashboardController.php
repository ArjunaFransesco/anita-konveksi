<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Employee;
use App\Models\Pengeluaran;
use App\Models\Penggajian;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function ownerDashboard()
    {
        $now        = Carbon::now();
        $startMonth = $now->copy()->startOfMonth();
        $endMonth   = $now->copy()->endOfMonth();

        // KPI bulan ini memakai data real: payments = pemasukan, pengeluarans + penggajians dibayar = pengeluaran.
        $totalOmset = Order::whereBetween('tanggal_pesan', [$startMonth, $endMonth])
            ->sum('total_setelah_diskon');

        $totalPemasukan = Payment::whereBetween('tanggal_bayar', [$startMonth, $endMonth])
            ->sum('jumlah');

        $pengeluaranOperasional = Pengeluaran::whereBetween('tanggal', [$startMonth, $endMonth])
            ->sum('jumlah');

        $pengeluaranGaji = Penggajian::where('status', 'dibayar')
            ->whereNotNull('tanggal_bayar')
            ->whereBetween('tanggal_bayar', [$startMonth, $endMonth])
            ->sum('total_gaji');

        $totalPengeluaran = $pengeluaranOperasional + $pengeluaranGaji;
        $labaBersih       = $totalPemasukan - $totalPengeluaran;
        $totalPiutang     = Order::where('status_pembayaran', 'belum')->sum('sisa_tagihan');
        $totalPesananBulanIni = Order::whereBetween('tanggal_pesan', [$startMonth, $endMonth])->count();

        // Statistik Operasional (Kasir)
        $opTotalPesanan   = Order::count();
        $opMenungguDP     = Order::where('status_pembayaran', 'belum')->count();
        $opSiapDiambil    = Order::where('status_produksi', 'siap_diambil')->count();
        $opSelesai        = Order::where('status_produksi', 'selesai')->count();

        // Grafik 6 bulan terakhir: pemasukan, pengeluaran, laba/rugi.
        $chartLabels      = [];
        $chartPemasukan   = [];
        $chartPengeluaran = [];
        $chartLabaRugi    = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = $now->copy()->subMonths($i);
            $chartLabels[] = $bulan->isoFormat('MMM YYYY');

            $pemasukan = (float) Payment::whereYear('tanggal_bayar', $bulan->year)
                ->whereMonth('tanggal_bayar', $bulan->month)
                ->sum('jumlah');

            $pengeluaran = (float) Pengeluaran::whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month)
                ->sum('jumlah');

            $gaji = (float) Penggajian::where('status', 'dibayar')
                ->whereNotNull('tanggal_bayar')
                ->whereYear('tanggal_bayar', $bulan->year)
                ->whereMonth('tanggal_bayar', $bulan->month)
                ->sum('total_gaji');

            $totalKeluar = $pengeluaran + $gaji;

            $chartPemasukan[]   = $pemasukan;
            $chartPengeluaran[] = $totalKeluar;
            $chartLabaRugi[]    = $pemasukan - $totalKeluar;
        }

        // Ringkasan transaksi terbaru.
        $recentTransaksi = Order::with('customer')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        return view('dashboard.owner', compact(
            'totalOmset',
            'totalPemasukan',
            'totalPengeluaran',
            'totalPiutang',
            'totalPesananBulanIni',
            'labaBersih',
            'chartLabels',
            'chartPemasukan',
            'chartPengeluaran',
            'chartLabaRugi',
            'recentTransaksi',
            'opTotalPesanan',
            'opMenungguDP',
            'opSiapDiambil',
            'opSelesai'
        ));
    }

    public function adminDashboard()
    {
        $now        = Carbon::now();
        $startMonth = $now->copy()->startOfMonth();
        $endMonth   = $now->copy()->endOfMonth();

        // Stat cards
        $totalPesananAktif  = Order::where('status_produksi', '!=', 'selesai')->count();
        $totalPegawai       = Employee::where('is_active', true)->count();
        $pendapatanBulanIni = Order::whereBetween('tanggal_pesan', [$startMonth, $endMonth])
                                   ->sum('total_setelah_diskon');
        $pesananMenunggu    = Order::where('status_pembayaran', 'belum')->count();

        // 5 pesanan terbaru
        $recentOrders = Order::with('customer')
                             ->orderByDesc('created_at')
                             ->limit(5)
                             ->get();

        // Jadwal penggajian: pegawai aktif (semua, tampilkan max 5)
        $jadwalGaji = Employee::where('is_active', true)
                              ->orderBy('name')
                              ->limit(5)
                              ->get();

        $totalGajiMingguIni = Employee::where('is_active', true)->sum('salary_rate');

        return view('dashboard.admin', compact(
            'totalPesananAktif',
            'totalPegawai',
            'pendapatanBulanIni',
            'pesananMenunggu',
            'recentOrders',
            'jadwalGaji',
            'totalGajiMingguIni'
        ));
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

    public function detailPesanan(int $id)
    {
        $order = Order::with(['customer', 'details', 'details.size', 'payments'])->findOrFail($id);

        return response()->json([
            'id'               => $order->id,
            'invoice'          => $order->invoice_number,
            'customer'         => $order->customer->nama,
            'no_hp'            => $order->customer->no_hp,
            'alamat'           => $order->customer->alamat,
            'tanggal_pesan'    => $order->tanggal_pesan->format('d M Y'),
            'deadline'         => $order->deadline ? $order->deadline->format('d M Y') : '-',
            'total_harga_raw'  => $order->total_harga,
            'diskon_persen'    => $order->diskon_persen,
            'total_setelah_diskon' => $order->total_setelah_diskon,
            'dp'               => $order->dp,
            'sisa_tagihan'     => $order->sisa_tagihan,
            'status_produksi'  => $order->status_label,
            'status_pembayaran' => $order->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum',
            'details'          => $order->details->map(function ($d) {
                $ukuran = $d->size_custom ?? ($d->size ? $d->size->name : $d->ukuran);
                return [
                    'jenis_produk' => $d->jenis_produk,
                    'jumlah'       => $d->jumlah,
                    'ukuran'       => $ukuran ?? '-',
                    'bahan'        => $d->bahan ?? '-',
                    'warna'        => $d->warna ?? '-',
                    'desain'       => $d->desain ?? '-',
                    'harga_satuan' => $d->harga_satuan,
                    'subtotal'     => $d->subtotal,
                    'logo'         => $d->logo_path ? asset('storage/' . $d->logo_path) : null,
                ];
            }),
            'payments'         => $order->payments->map(function ($p) {
                return [
                    'tanggal' => $p->tanggal_bayar->format('d M Y'),
                    'jumlah'  => $p->jumlah,
                    'metode'  => ucfirst($p->metode),
                    'tipe'    => $p->tipe == 'dp' ? 'DP' : 'Pelunasan',
                ];
            }),
        ]);
    }
}
