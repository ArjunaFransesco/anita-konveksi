<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function laporan(Request $request)
    {
        $filter = $this->resolveLaporanFilter($request);
        $data   = $this->buildLaporanData($filter['start'], $filter['end']);

        return view('owner.laporan', array_merge($data, [
            'filter' => $filter,
        ]));
    }

    public function exportLaporanExcel(Request $request)
    {
        $jenis  = $request->query('jenis', 'laporan');
        $filter = $this->resolveLaporanFilter($request);
        $data   = $this->buildLaporanData($filter['start'], $filter['end']);

        $namaJenis = str_replace('_', '-', $jenis);
        $filename  = 'laporan_' . $namaJenis . '_' . $filter['start']->format('Ymd') . '_' . $filter['end']->format('Ymd') . '.csv';
        $headers   = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($jenis, $filter, $data) {
            $fp = fopen('php://output', 'w');
            fputs($fp, "\xEF\xBB\xBF");

            fputcsv($fp, ['Anita Konveksi']);
            fputcsv($fp, ['Periode', $filter['label']]);
            fputcsv($fp, []);

            if ($jenis === 'pemasukan') {
                fputcsv($fp, ['No', 'Tanggal', 'Invoice', 'Pelanggan', 'Tipe', 'Metode', 'Jumlah']);
                foreach ($data['pemasukanRows'] as $i => $row) {
                    fputcsv($fp, [
                        $i + 1,
                        $row->tanggal_bayar->format('d/m/Y'),
                        $row->order->invoice_number ?? '-',
                        $row->order->customer->nama ?? '-',
                        strtoupper($row->tipe),
                        ucfirst($row->metode),
                        (float) $row->jumlah,
                    ]);
                }
                fputcsv($fp, []);
                fputcsv($fp, ['Total Pemasukan', '', '', '', '', '', (float) $data['totalPemasukan']]);
            } elseif ($jenis === 'pengeluaran') {
                fputcsv($fp, ['No', 'Tanggal', 'Keterangan', 'Kategori', 'Metode', 'Sumber', 'Jumlah']);
                foreach ($data['pengeluaranRows'] as $i => $row) {
                    fputcsv($fp, [
                        $i + 1,
                        Carbon::parse($row['tanggal'])->format('d/m/Y'),
                        $row['keterangan'],
                        $row['kategori'],
                        $row['metode'],
                        $row['sumber'],
                        (float) $row['jumlah'],
                    ]);
                }
                fputcsv($fp, []);
                fputcsv($fp, ['Total Pengeluaran', '', '', '', '', '', (float) $data['totalPengeluaran']]);
            } else {
                fputcsv($fp, ['LAPORAN LABA RUGI']);
                fputcsv($fp, []);
                fputcsv($fp, ['Komponen', 'Debit/Pendapatan', 'Kredit/Beban']);
                fputcsv($fp, ['Pendapatan Usaha', (float) $data['totalPemasukan'], '']);
                fputcsv($fp, ['Beban Operasional', '', (float) $data['totalPengeluaranOperasional']]);
                fputcsv($fp, ['Beban Gaji/Upah', '', (float) $data['totalPenggajian']]);
                fputcsv($fp, ['Total Beban', '', (float) $data['totalPengeluaran']]);
                fputcsv($fp, ['Laba/Rugi Bersih', (float) $data['labaRugi'], '']);
                fputcsv($fp, ['Piutang Belum Lunas', (float) $data['totalPiutang'], '']);

                fputcsv($fp, []);
                fputcsv($fp, ['BUKU BESAR KAS / REKONSILIASI']);
                fputcsv($fp, ['No', 'Tanggal', 'Uraian', 'Debit', 'Kredit', 'Saldo']);
                foreach ($data['bukuBesarRows'] as $i => $row) {
                    fputcsv($fp, [
                        $i + 1,
                        Carbon::parse($row['tanggal'])->format('d/m/Y'),
                        $row['uraian'],
                        (float) $row['debit'],
                        (float) $row['kredit'],
                        (float) $row['saldo'],
                    ]);
                }

                fputcsv($fp, []);
                fputcsv($fp, ['DAFTAR PESANAN PERIODE']);
                fputcsv($fp, ['ID Pesanan', 'Tanggal', 'Pelanggan', 'Produk Singkat']);
                foreach ($data['orderRows'] as $row) {
                    fputcsv($fp, [
                        $row['id'],
                        Carbon::parse($row['tanggal'])->format('d/m/Y'),
                        $row['pelanggan'],
                        $row['produk_singkat'],
                    ]);
                }
            }

            fclose($fp);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportLaporanPdf(Request $request)
    {
        $jenis  = $request->query('jenis', 'laporan');
        $filter = $this->resolveLaporanFilter($request);
        $data   = $this->buildLaporanData($filter['start'], $filter['end']);

        $judul = match ($jenis) {
            'pemasukan'   => 'Laporan Pemasukan',
            'pengeluaran' => 'Laporan Pengeluaran',
            default       => 'Laporan Laba Rugi',
        };

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('owner.laporan_pdf', array_merge($data, [
            'jenis'  => $jenis,
            'judul'  => $judul,
            'filter' => $filter,
        ]))->setPaper('a4', $jenis === 'laporan' ? 'portrait' : 'landscape');

        return $pdf->download(strtolower(str_replace(' ', '_', $judul)) . '_' . now()->format('Ymd_His') . '.pdf');
    }

    public function piutang(Request $request)
    {
        $search = $request->query('q', '');
        $statusTempo = $request->query('tempo', '');
        $bulan = $request->query('bulan', '');
        $today = Carbon::today();

        $basePiutang = Order::with(['customer', 'details.size', 'payments'])
            ->where(function ($query) {
                $query->where('status_pembayaran', 'belum')
                      ->orWhere('sisa_tagihan', '>', 0);
            });

        $summaryBase = clone $basePiutang;
        $totalPiutangAll = (float) $summaryBase->sum('sisa_tagihan');
        $totalInvoicePiutang = (clone $basePiutang)->count();
        $piutangLewatTempo = (float) (clone $basePiutang)
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', $today->toDateString())
            ->sum('sisa_tagihan');
        $piutangJatuhTempoDekat = (float) (clone $basePiutang)
            ->whereNotNull('deadline')
            ->whereBetween('deadline', [$today->toDateString(), $today->copy()->addDays(7)->toDateString()])
            ->sum('sisa_tagihan');

        $query = clone $basePiutang;

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', fn ($c) => $c->where('nama', 'like', "%{$search}%"));
            });
        }

        if ($bulan) {
            [$year, $month] = explode('-', $bulan);
            $query->whereYear('tanggal_pesan', $year)->whereMonth('tanggal_pesan', $month);
        }

        if ($statusTempo === 'lewat_tempo') {
            $query->whereNotNull('deadline')->whereDate('deadline', '<', $today->toDateString());
        } elseif ($statusTempo === 'jatuh_tempo_dekat') {
            $query->whereNotNull('deadline')->whereBetween('deadline', [$today->toDateString(), $today->copy()->addDays(7)->toDateString()]);
        } elseif ($statusTempo === 'belum_jatuh_tempo') {
            $query->where(function ($q) use ($today) {
                $q->whereNull('deadline')->orWhereDate('deadline', '>', $today->copy()->addDays(7)->toDateString());
            });
        }

        $filteredTotal = (float) (clone $query)->sum('sisa_tagihan');

        $piutangRows = $query
            ->orderByRaw('deadline IS NULL')
            ->orderBy('deadline')
            ->orderByDesc('tanggal_pesan')
            ->paginate(12)
            ->withQueryString();

        return view('owner.piutang', compact(
            'piutangRows',
            'search',
            'statusTempo',
            'bulan',
            'today',
            'totalPiutangAll',
            'totalInvoicePiutang',
            'piutangLewatTempo',
            'piutangJatuhTempoDekat',
            'filteredTotal'
        ));
    }

    public function monitoringProduksi(Request $request)
    {
        $search = $request->query('q', '');
        $status = $request->query('status', '');
        $deadline = $request->query('deadline', '');
        $bulan = $request->query('bulan', '');
        $today = Carbon::today();

        $statusList = Order::$statusProduksiLabels;

        $summaryBase = Order::query();
        $totalPesanan = (clone $summaryBase)->count();
        $totalAktif = (clone $summaryBase)->where('status_produksi', '!=', 'selesai')->count();
        $totalSelesai = (clone $summaryBase)->where('status_produksi', 'selesai')->count();
        $totalLewatDeadline = (clone $summaryBase)
            ->where('status_produksi', '!=', 'selesai')
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', $today->toDateString())
            ->count();
        $totalSiapDiambil = (clone $summaryBase)->where('status_produksi', 'siap_diambil')->count();

        $statusCounts = Order::select('status_produksi', DB::raw('COUNT(*) as total'))
            ->groupBy('status_produksi')
            ->pluck('total', 'status_produksi');

        $query = Order::with(['customer', 'details.size'])
            ->orderByRaw('deadline IS NULL')
            ->orderBy('deadline')
            ->orderByDesc('created_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', fn ($c) => $c->where('nama', 'like', "%{$search}%"))
                  ->orWhereHas('details', fn ($d) => $d->where('jenis_produk', 'like', "%{$search}%"));
            });
        }

        if ($status) {
            $query->where('status_produksi', $status);
        }

        if ($bulan) {
            [$year, $month] = explode('-', $bulan);
            $query->whereYear('tanggal_pesan', $year)->whereMonth('tanggal_pesan', $month);
        }

        if ($deadline === 'lewat') {
            $query->where('status_produksi', '!=', 'selesai')
                  ->whereNotNull('deadline')
                  ->whereDate('deadline', '<', $today->toDateString());
        } elseif ($deadline === 'minggu_ini') {
            $query->whereNotNull('deadline')
                  ->whereBetween('deadline', [$today->toDateString(), $today->copy()->addDays(7)->toDateString()]);
        } elseif ($deadline === 'tanpa_deadline') {
            $query->whereNull('deadline');
        }

        $orders = $query->paginate(12)->withQueryString();

        return view('owner.monitoring', compact(
            'orders',
            'search',
            'status',
            'deadline',
            'bulan',
            'today',
            'statusList',
            'statusCounts',
            'totalPesanan',
            'totalAktif',
            'totalSelesai',
            'totalLewatDeadline',
            'totalSiapDiambil'
        ));
    }

    private function resolveLaporanFilter(Request $request): array
    {
        $periode = $request->query('periode', 'bulanan');
        $today   = Carbon::today();

        if ($periode === 'tahunan') {
            $tahun = (int) $request->query('tahun', $today->year);
            $start = Carbon::create($tahun, 1, 1)->startOfDay();
            $end   = Carbon::create($tahun, 12, 31)->endOfDay();
            $label = 'Tahun ' . $tahun;
        } elseif ($periode === 'rentang') {
            $start = $request->filled('tanggal_mulai')
                ? Carbon::parse($request->query('tanggal_mulai'))->startOfDay()
                : $today->copy()->startOfMonth();
            $end = $request->filled('tanggal_selesai')
                ? Carbon::parse($request->query('tanggal_selesai'))->endOfDay()
                : $today->copy()->endOfMonth();

            if ($end->lt($start)) {
                [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
            }

            $label = $start->isoFormat('D MMMM YYYY') . ' - ' . $end->isoFormat('D MMMM YYYY');
        } else {
            $periode = 'bulanan';
            $bulan = $request->query('bulan', $today->format('Y-m'));
            $start = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();
            $end   = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth();
            $label = $start->isoFormat('MMMM YYYY');
        }

        return [
            'periode'         => $periode,
            'bulan'           => $start->format('Y-m'),
            'tahun'           => $start->format('Y'),
            'tanggal_mulai'   => $start->format('Y-m-d'),
            'tanggal_selesai' => $end->format('Y-m-d'),
            'start'           => $start,
            'end'             => $end,
            'label'           => $label,
        ];
    }

    private function buildLaporanData(Carbon $start, Carbon $end): array
    {
        $pemasukanRows = Payment::with(['order.customer'])
            ->whereBetween('tanggal_bayar', [$start->toDateString(), $end->toDateString()])
            ->orderByDesc('tanggal_bayar')
            ->orderByDesc('id')
            ->get();

        $totalPemasukan = (float) $pemasukanRows->sum('jumlah');
        $totalDp        = (float) $pemasukanRows->where('tipe', 'dp')->sum('jumlah');
        $totalPelunasan = (float) $pemasukanRows->where('tipe', 'pelunasan')->sum('jumlah');

        $pengeluaranOperasional = Pengeluaran::whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        $pengeluaranRows = collect();

        foreach ($pengeluaranOperasional as $item) {
            $pengeluaranRows->push([
                'tanggal'    => $item->tanggal,
                'keterangan' => $item->keterangan,
                'kategori'   => $item->tipe_label,
                'metode'     => ucfirst($item->metode),
                'sumber'     => 'Pengeluaran',
                'jumlah'     => (float) $item->jumlah,
            ]);
        }

        $pengeluaranRows = $pengeluaranRows->sortByDesc('tanggal')->values();

        $totalPengeluaran = (float) $pengeluaranOperasional->sum('jumlah');
        $labaRugi         = $totalPemasukan - $totalPengeluaran;

        $kategoriPengeluaran = $pengeluaranRows
            ->groupBy('kategori')
            ->map(fn($items) => (float) collect($items)->sum('jumlah'))
            ->sortDesc();

        $totalPiutang = (float) Order::where('status_pembayaran', 'belum')->sum('sisa_tagihan');

        // Alias untuk kompatibilitas view lama
        $totalPengeluaranOperasional = $totalPengeluaran;
        $totalPenggajian             = 0;

        $orderRows = Order::with(['customer', 'details.size'])
            ->whereBetween('tanggal_pesan', [$start->toDateString(), $end->toDateString()])
            ->orderBy('tanggal_pesan')
            ->orderBy('id')
            ->get()
            ->map(function ($order) {
                $produkSingkat = $order->details->map(function ($detail) {
                    $ukuran = $detail->size_custom ?: ($detail->ukuran ?: optional($detail->size)->name);
                    $ukuranText = $ukuran ? ' (' . $ukuran . ')' : '';
                    return $detail->jenis_produk . ' ' . number_format((float) $detail->jumlah, 0, ',', '.') . ' pcs' . $ukuranText;
                })->filter()->implode(', ');

                return [
                    'id'             => $order->invoice_number ?: ('ORD-' . $order->id),
                    'tanggal'        => $order->tanggal_pesan,
                    'pelanggan'      => $order->customer->nama ?? '-',
                    'produk_singkat' => $produkSingkat ?: '-',
                ];
            });

        $bukuBesarRows = collect();

        foreach ($pemasukanRows as $row) {
            $bukuBesarRows->push([
                'tanggal'    => $row->tanggal_bayar,
                'uraian'     => 'Pembayaran ' . (($row->tipe === 'dp') ? 'DP' : 'Pelunasan') . ' - ' . ($row->order->invoice_number ?? '-'),
                'debit'      => (float) $row->jumlah,
                'kredit'     => 0,
                'kategori'   => 'Pemasukan',
            ]);
        }

        foreach ($pengeluaranRows as $row) {
            $bukuBesarRows->push([
                'tanggal'    => $row['tanggal'],
                'uraian'     => $row['keterangan'],
                'debit'      => 0,
                'kredit'     => (float) $row['jumlah'],
                'kategori'   => $row['kategori'],
            ]);
        }

        $saldoBerjalan = 0;
        $bukuBesarRows = $bukuBesarRows
            ->sortBy(function ($row) {
                return Carbon::parse($row['tanggal'])->format('Y-m-d') . '|' . $row['uraian'];
            })
            ->values()
            ->map(function ($row) use (&$saldoBerjalan) {
                $saldoBerjalan += ((float) $row['debit']) - ((float) $row['kredit']);
                $row['saldo'] = $saldoBerjalan;
                return $row;
            });

        $laporanRingkas = collect([
            ['komponen' => 'Total Pemasukan',    'jumlah' => $totalPemasukan,    'tipe' => 'plus'],
            ['komponen' => 'Total Pengeluaran',  'jumlah' => $totalPengeluaran,  'tipe' => 'minus'],
            ['komponen' => 'Laba / Rugi Bersih', 'jumlah' => $labaRugi, 'tipe' => $labaRugi >= 0 ? 'plus' : 'minus'],
            ['komponen' => 'Piutang Belum Lunas','jumlah' => $totalPiutang,      'tipe' => 'neutral'],
        ]);

        return compact(
            'pemasukanRows',
            'totalPemasukan',
            'totalDp',
            'totalPelunasan',
            'pengeluaranRows',
            'totalPengeluaranOperasional',
            'totalPenggajian',
            'totalPengeluaran',
            'kategoriPengeluaran',
            'labaRugi',
            'totalPiutang',
            'orderRows',
            'bukuBesarRows',
            'laporanRingkas'
        );
    }
}
