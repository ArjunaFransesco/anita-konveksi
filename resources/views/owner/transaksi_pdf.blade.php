<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $judul }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 10px; color: #1e1e2a; }
        .header { text-align: center; margin-bottom: 16px; border-bottom: 2px solid #1e1e2a; padding-bottom: 10px; }
        .header h1 { font-size: 15px; font-weight: 700; letter-spacing: 1px; }
        .header p { font-size: 9px; color: #555; margin-top: 3px; }
        .meta { display: flex; justify-content: space-between; font-size: 9px; margin-bottom: 12px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #1e1e2a; color: #fff; }
        thead th { padding: 6px 8px; text-align: left; font-size: 9px; font-weight: 600; }
        tbody tr:nth-child(even) { background: #f8f9fa; }
        tbody td { padding: 5px 8px; border-bottom: 1px solid #e9ecef; font-size: 9px; }
        tfoot tr { background: #1e1e2a; color: #fff; }
        tfoot td { padding: 7px 8px; font-size: 10px; font-weight: 700; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 10px; font-size: 8px; font-weight: 600; }
        .badge-lunas  { background: #dcfce7; color: #166534; }
        .badge-belum  { background: #fee2e2; color: #991b1b; }
        .footer { font-size: 8px; color: #888; text-align: center; margin-top: 12px; border-top: 1px solid #e9ecef; padding-top: 6px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ANITA KONVEKSI</h1>
        <p>{{ $judul }}</p>
    </div>
    <div class="meta">
        <span>Dicetak: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY, HH:mm') }}</span>
        <span>Total: {{ $orders->count() }} transaksi</span>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width:20px;">#</th>
                <th style="width:85px;">Invoice</th>
                <th>Pelanggan</th>
                <th style="width:65px;">Tanggal</th>
                <th style="width:65px;">Deadline</th>
                <th style="width:80px; text-align:right;">Total (Rp)</th>
                <th style="width:75px; text-align:right;">DP (Rp)</th>
                <th style="width:75px; text-align:right;">Sisa (Rp)</th>
                <th style="width:75px;">Status</th>
                <th style="width:55px;">Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $i => $o)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-weight:700;">{{ $o->invoice_number }}</td>
                <td>{{ $o->customer->nama }}</td>
                <td>{{ $o->tanggal_pesan->format('d/m/Y') }}</td>
                <td>{{ $o->deadline ? $o->deadline->format('d/m/Y') : '-' }}</td>
                <td style="text-align:right; font-weight:600;">{{ number_format($o->total_setelah_diskon, 0, ',', '.') }}</td>
                <td style="text-align:right;">{{ number_format($o->dp, 0, ',', '.') }}</td>
                <td style="text-align:right; color:{{ $o->sisa_tagihan > 0 ? '#991b1b' : '#166534' }}; font-weight:600;">
                    {{ $o->sisa_tagihan > 0 ? number_format($o->sisa_tagihan, 0, ',', '.') : 'Lunas' }}
                </td>
                <td>{{ $o->status_label }}</td>
                <td>
                    <span class="badge {{ $o->status_pembayaran === 'lunas' ? 'badge-lunas' : 'badge-belum' }}">
                        {{ $o->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right;">TOTAL</td>
                <td style="text-align:right;">{{ number_format($orders->sum('total_setelah_diskon'), 0, ',', '.') }}</td>
                <td style="text-align:right;">{{ number_format($orders->sum('dp'), 0, ',', '.') }}</td>
                <td style="text-align:right;">{{ number_format($orders->sum('sisa_tagihan'), 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
    <div class="footer">Dokumen ini digenerate otomatis oleh sistem Anita Konveksi</div>
</body>
</html>
