<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengeluaran — {{ $judulBulan }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #1e1e2a; }

        .header { text-align: center; margin-bottom: 18px; border-bottom: 2px solid #1e1e2a; padding-bottom: 12px; }
        .header h1 { font-size: 16px; font-weight: 700; letter-spacing: 1px; }
        .header p { font-size: 10px; color: #555; margin-top: 4px; }

        .meta { display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 14px; color: #555; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        thead tr { background: #1e1e2a; color: #fff; }
        thead th { padding: 7px 10px; text-align: left; font-size: 10px; font-weight: 600; letter-spacing: 0.5px; }
        tbody tr:nth-child(even) { background: #f8f9fa; }
        tbody td { padding: 6px 10px; border-bottom: 1px solid #e9ecef; font-size: 10px; }

        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
        }
        .tipe-bahan_baku  { background: #dbeafe; color: #1e40af; }
        .tipe-gaji        { background: #dcfce7; color: #166534; }
        .tipe-operasional { background: #fef9c3; color: #854d0e; }
        .tipe-listrik_air { background: #f3e8ff; color: #6b21a8; }
        .tipe-lain_lain   { background: #f1f5f9; color: #475569; }

        tfoot tr { background: #1e1e2a; color: #fff; }
        tfoot td { padding: 8px 10px; font-size: 11px; font-weight: 700; }

        .footer { font-size: 9px; color: #888; text-align: center; margin-top: 10px; border-top: 1px solid #e9ecef; padding-top: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ANITA KONVEKSI</h1>
        <p>Laporan Pengeluaran — {{ $judulBulan }}</p>
    </div>

    <div class="meta">
        <span>Dicetak: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY, HH:mm') }}</span>
        <span>Total: {{ $pengeluarans->count() }} transaksi</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:28px;">#</th>
                <th style="width:80px;">Tanggal</th>
                <th style="width:95px;">Tipe</th>
                <th>Keterangan</th>
                <th style="width:95px; text-align:right;">Jumlah (Rp)</th>
                <th style="width:60px;">Metode</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengeluarans as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                <td><span class="badge tipe-{{ $p->tipe }}">{{ $p->tipe_label }}</span></td>
                <td>{{ $p->keterangan }}</td>
                <td style="text-align:right; font-weight:600;">{{ number_format($p->jumlah, 0, ',', '.') }}</td>
                <td>{{ ucfirst($p->metode) }}</td>
                <td style="color:#666;">{{ $p->catatan ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; padding:16px; color:#999;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right;">TOTAL PENGELUARAN</td>
                <td style="text-align:right;">{{ number_format($totalBulanIni, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">Dokumen ini digenerate otomatis oleh sistem Anita Konveksi</div>
</body>
</html>
