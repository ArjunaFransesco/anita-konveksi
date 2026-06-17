<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $judul }}</title>
    <style>
        @page { margin: 28px 32px; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5px;
            color: #000;
            line-height: 1.35;
        }
        .report-header {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .company-title {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: .2px;
            margin: 0;
            color: #000;
        }
        .report-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-top: 4px;
        }
        .meta { color: #555; font-size: 9.5px; }
        .right { text-align: right; }
        .center { text-align: center; }
        .muted { color: #666; }
        .section-title {
            margin: 16px 0 7px;
            font-size: 12px;
            font-weight: 800;
            color: #000;
            border-left: 4px solid #000;
            padding-left: 7px;
        }
        table { width: 100%; border-collapse: collapse; }
        .summary td {
            border: 1px solid #ccc;
            padding: 7px 8px;
        }
        .summary .label { background: #f5f5f5; font-weight: 700; }
        .summary .value { font-weight: 800; }
        .statement th,
        .statement td,
        .data th,
        .data td {
            border: 1px solid #ccc;
            padding: 6px 7px;
            vertical-align: top;
        }
        .statement th,
        .data th {
            background: #333;
            color: #ffffff;
            font-weight: 700;
            text-align: left;
        }
        .statement .group {
            background: #eee;
            font-weight: 800;
            color: #000;
        }
        .statement .indent { padding-left: 18px; }
        .statement .total-row td {
            background: #f5f5f5;
            font-weight: 800;
        }
        .statement .final-row td {
            background: #eee;
            font-weight: 900;
            border-top: 2px solid #000;
        }
        .statement .final-row.loss td { background: #eee; }
        .green { color: #333; font-weight: 800; }
        .red { color: #333; font-weight: 800; }
        .small { font-size: 9px; }
        .footer {
            margin-top: 18px;
            padding-top: 8px;
            border-top: 1px solid #ccc;
            font-size: 9px;
            color: #555;
        }
        .page-break { page-break-before: always; }
    </style>
</head>
<body>
    <table class="report-header">
        <tr>
            <td>
                <h1 class="company-title">Anita Konveksi &amp; Sablon</h1>
                <div class="report-title">{{ $judul }}</div>
            </td>
            <td class="right meta">
                <div><strong>Periode:</strong> {{ $filter['label'] }}</div>
                <div><strong>Dicetak:</strong> {{ now()->isoFormat('D MMMM YYYY HH:mm') }}</div>
                <div><strong>Sistem:</strong> Anita Konveksi</div>
            </td>
        </tr>
    </table>

    @if($jenis === 'pemasukan')
        <div class="section-title">Ringkasan Pemasukan</div>
        <table class="summary">
            <tr>
                <td class="label">Total Pemasukan</td>
                <td class="value green right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td class="label">DP</td>
                <td class="value right">Rp {{ number_format($totalDp, 0, ',', '.') }}</td>
                <td class="label">Pelunasan</td>
                <td class="value right">Rp {{ number_format($totalPelunasan, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="section-title">Rincian Penerimaan Kas</div>
        <table class="data">
            <thead>
                <tr>
                    <th style="width:4%;">No</th>
                    <th style="width:10%;">Tanggal</th>
                    <th style="width:14%;">ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th style="width:10%;">Jenis</th>
                    <th style="width:10%;">Metode</th>
                    <th style="width:16%;" class="right">Debit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemasukanRows as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->tanggal_bayar->format('d/m/Y') }}</td>
                    <td>{{ $row->order->invoice_number ?? '-' }}</td>
                    <td>{{ $row->order->customer->nama ?? '-' }}</td>
                    <td>{{ $row->tipe === 'dp' ? 'DP' : 'Pelunasan' }}</td>
                    <td>{{ ucfirst($row->metode) }}</td>
                    <td class="right">Rp {{ number_format($row->jumlah, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="center muted">Belum ada pemasukan pada periode ini.</td></tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="6" class="right"><strong>Total Pemasukan</strong></td>
                    <td class="right"><strong>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

    @elseif($jenis === 'pengeluaran')
        <div class="section-title">Ringkasan Pengeluaran</div>
        <table class="summary">
            <tr>
                <td class="label">Total Pengeluaran</td>
                <td class="value red right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                <td class="label">Operasional</td>
                <td class="value right">Rp {{ number_format($totalPengeluaranOperasional, 0, ',', '.') }}</td>
                <td class="label">Penggajian</td>
                <td class="value right">Rp {{ number_format($totalPenggajian, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="section-title">Rincian Pengeluaran Kas</div>
        <table class="data">
            <thead>
                <tr>
                    <th style="width:4%;">No</th>
                    <th style="width:10%;">Tanggal</th>
                    <th>Keterangan</th>
                    <th style="width:15%;">Kategori</th>
                    <th style="width:10%;">Metode</th>
                    <th style="width:12%;">Sumber</th>
                    <th style="width:16%;" class="right">Kredit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengeluaranRows as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($row['tanggal'])->format('d/m/Y') }}</td>
                    <td>{{ $row['keterangan'] }}</td>
                    <td>{{ $row['kategori'] }}</td>
                    <td>{{ $row['metode'] }}</td>
                    <td>{{ $row['sumber'] }}</td>
                    <td class="right">Rp {{ number_format($row['jumlah'], 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="center muted">Belum ada pengeluaran pada periode ini.</td></tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="6" class="right"><strong>Total Pengeluaran</strong></td>
                    <td class="right"><strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

    @else
        <div class="section-title">Ringkasan Posisi Keuangan</div>
        <table class="summary">
            <tr>
                <td class="label">Pendapatan Diterima</td>
                <td class="value green right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td class="label">Total Beban</td>
                <td class="value red right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                <td class="label">{{ $labaRugi >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}</td>
                <td class="value {{ $labaRugi >= 0 ? 'green' : 'red' }} right">Rp {{ number_format(abs($labaRugi), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Beban Operasional</td>
                <td class="value right">Rp {{ number_format($totalPengeluaranOperasional, 0, ',', '.') }}</td>
                <td class="label">Beban Gaji/Upah</td>
                <td class="value right">Rp {{ number_format($totalPenggajian, 0, ',', '.') }}</td>
                <td class="label">Piutang Belum Lunas</td>
                <td class="value right">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="section-title">Laporan Laba Rugi</div>
        <table class="statement">
            <thead>
                <tr>
                    <th>Komponen</th>
                    <th style="width:22%;" class="right">Debit / Pendapatan</th>
                    <th style="width:22%;" class="right">Kredit / Beban</th>
                </tr>
            </thead>
            <tbody>
                <tr class="group"><td colspan="3">Pendapatan Usaha</td></tr>
                <tr>
                    <td class="indent">Pembayaran pesanan diterima</td>
                    <td class="right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                    <td class="right">-</td>
                </tr>
                <tr class="total-row">
                    <td>Total Pendapatan</td>
                    <td class="right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                    <td class="right">-</td>
                </tr>

                <tr class="group"><td colspan="3">Beban Usaha</td></tr>
                <tr>
                    <td class="indent">Beban operasional</td>
                    <td class="right">-</td>
                    <td class="right">Rp {{ number_format($totalPengeluaranOperasional, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="indent">Beban gaji / upah dibayar</td>
                    <td class="right">-</td>
                    <td class="right">Rp {{ number_format($totalPenggajian, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total Beban</td>
                    <td class="right">-</td>
                    <td class="right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                </tr>
                <tr class="final-row {{ $labaRugi < 0 ? 'loss' : '' }}">
                    <td>{{ $labaRugi >= 0 ? 'Laba Bersih Periode Berjalan' : 'Rugi Bersih Periode Berjalan' }}</td>
                    <td colspan="2" class="right">Rp {{ number_format(abs($labaRugi), 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Buku Besar Kas / Rekonsiliasi Saldo</div>
        <table class="data">
            <thead>
                <tr>
                    <th style="width:4%;">No</th>
                    <th style="width:10%;">Tanggal</th>
                    <th>Uraian</th>
                    <th style="width:15%;" class="right">Debit</th>
                    <th style="width:15%;" class="right">Kredit</th>
                    <th style="width:15%;" class="right">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bukuBesarRows as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($row['tanggal'])->format('d/m/Y') }}</td>
                    <td>{{ $row['uraian'] }}</td>
                    <td class="right">{{ $row['debit'] > 0 ? 'Rp ' . number_format($row['debit'], 0, ',', '.') : '-' }}</td>
                    <td class="right">{{ $row['kredit'] > 0 ? 'Rp ' . number_format($row['kredit'], 0, ',', '.') : '-' }}</td>
                    <td class="right {{ $row['saldo'] < 0 ? 'red' : '' }}">Rp {{ number_format($row['saldo'], 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="center muted">Belum ada transaksi kas pada periode ini.</td></tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="3" class="right"><strong>Total</strong></td>
                    <td class="right"><strong>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</strong></td>
                    <td class="right"><strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
                    <td class="right"><strong>Rp {{ number_format($labaRugi, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Daftar Pesanan Periode</div>
        <table class="data">
            <thead>
                <tr>
                    <th style="width:17%;">ID Pesanan</th>
                    <th style="width:13%;">Tanggal</th>
                    <th style="width:24%;">Pelanggan</th>
                    <th>Produk Singkat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orderRows as $row)
                <tr>
                    <td>{{ $row['id'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($row['tanggal'])->format('d/m/Y') }}</td>
                    <td>{{ $row['pelanggan'] }}</td>
                    <td>{{ $row['produk_singkat'] }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="center muted">Belum ada pesanan pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="small muted" style="margin-top:8px;">
            Catatan: Laporan laba/rugi dihitung berdasarkan kas yang benar-benar diterima dari pembayaran dan kas yang keluar dari pengeluaran operasional serta penggajian dibayar pada periode laporan.
        </div>
    @endif

    <div class="footer">
        Dokumen ini dibuat otomatis oleh Sistem Informasi Anita Konveksi. Mohon cocokkan dengan bukti transaksi fisik/transfer bila diperlukan.
    </div>
</body>
</html>
