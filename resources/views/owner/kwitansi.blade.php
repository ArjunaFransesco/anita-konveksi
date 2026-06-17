<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi {{ $order->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #fff;
            padding: 20px;
        }

        /* ── Header ─────────────────────────── */
        .header {
            border-bottom: 3px solid #333;
            padding-bottom: 12px;
            margin-bottom: 14px;
            display: table;
            width: 100%;
        }
        .header-left { display: table-cell; vertical-align: middle; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; }
        .company-name {
            font-size: 20px;
            font-weight: 700;
            color: #000;
            letter-spacing: 1px;
        }
        .company-sub { font-size: 9px; color: #555; margin-top: 2px; }
        .doc-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .invoice-num { font-size: 10px; color: #555; margin-top: 3px; }

        /* ── Info rows ──────────────────────── */
        .info-table { width: 100%; margin-bottom: 14px; border-collapse: collapse; }
        .info-table td { padding: 3px 6px; font-size: 10.5px; }
        .info-table td:first-child { color: #555; width: 34%; }
        .info-table td:nth-child(2) { width: 4%; color: #555; }
        .info-table td:last-child { font-weight: 600; color: #000; }

        /* ── Produk Table ───────────────────── */
        .prod-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .prod-table thead tr { background: #333; color: #fff; }
        .prod-table th { padding: 7px 8px; font-size: 10px; text-align: left; font-weight: 600; }
        .prod-table td { padding: 6px 8px; font-size: 10.5px; border-bottom: 1px solid #ccc; }
        .prod-table tbody tr:nth-child(even) { background: #f5f5f5; }
        .prod-table .num { text-align: right; }

        /* ── Ringkasan ──────────────────────── */
        .summary-wrap { display: table; width: 100%; margin-bottom: 16px; }
        .summary-right { display: table-cell; width: 55%; vertical-align: top; padding-left: 20px; }
        .summary-table { width: 100%; border-collapse: collapse; }
        .summary-table td { padding: 4px 8px; font-size: 10.5px; }
        .summary-table td:last-child { text-align: right; font-weight: 600; }
        .summary-table .divider td { border-top: 1px solid #ccc; }
        .summary-table .total-row td { font-size: 12px; font-weight: 700; color: #000; }
        .summary-table .lunas-row td { color: #333; font-weight: 700; }
        .summary-table .sisa-row td { color: #333; font-weight: 700; }

        /* ── Pembayaran ─────────────────────── */
        .pay-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .pay-table th { background: #e0e0e0; font-size: 10px; padding: 5px 8px; text-align: left; font-weight: 600; color: #000; }
        .pay-table td { padding: 5px 8px; font-size: 10px; border-bottom: 1px solid #ccc; }

        /* ── Status Badge ───────────────────── */
        .badge-lunas { background: #eee; color: #333; padding: 3px 10px; border-radius: 12px; font-weight: 700; font-size: 10px; }
        .badge-belum { background: #ddd; color: #333; padding: 3px 10px; border-radius: 12px; font-weight: 700; font-size: 10px; }

        /* ── TTD ────────────────────────────── */
        .ttd-wrap { display: table; width: 100%; margin-top: 20px; }
        .ttd-cell { display: table-cell; text-align: center; width: 50%; }
        .ttd-box {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px;
            margin: 0 10px;
        }
        .ttd-label { font-size: 9.5px; color: #666; margin-bottom: 50px; }
        .ttd-name { font-size: 10px; font-weight: 700; border-top: 1px solid #aaa; display: inline-block; padding-top: 4px; min-width: 100px; }

        /* ── Footer ─────────────────────────── */
        .doc-footer {
            border-top: 1px dashed #ccc;
            padding-top: 8px;
            margin-top: 14px;
            font-size: 9px;
            color: #aaa;
            text-align: center;
        }
    </style>
</head>
<body>

{{-- Header --}}
<div class="header">
    <div class="header-left">
        <div class="company-name">ANITA KONVEKSI</div>
        <div class="company-sub">Jasa Konveksi Pakaian Berkualitas</div>
    </div>
    <div class="header-right">
        <div class="doc-title">KWITANSI</div>
        <div class="invoice-num">{{ $order->invoice_number }}</div>
    </div>
</div>

{{-- Info Pelanggan & Pesanan --}}
<table class="info-table">
    <tr>
        <td>Kepada</td><td>:</td>
        <td><strong>{{ $order->customer->nama }}</strong></td>
    </tr>
    @if($order->customer->no_hp)
    <tr>
        <td>No. HP</td><td>:</td>
        <td>{{ $order->customer->no_hp }}</td>
    </tr>
    @endif
    @if($order->customer->alamat)
    <tr>
        <td>Alamat</td><td>:</td>
        <td>{{ $order->customer->alamat }}</td>
    </tr>
    @endif
    <tr>
        <td>Tanggal Pesan</td><td>:</td>
        <td>{{ $order->tanggal_pesan->isoFormat('D MMMM YYYY') }}</td>
    </tr>
    @if($order->deadline)
    <tr>
        <td>Deadline</td><td>:</td>
        <td>{{ $order->deadline->isoFormat('D MMMM YYYY') }}</td>
    </tr>
    @endif
    <tr>
        <td>Status Pembayaran</td><td>:</td>
        <td>
            @if($order->status_pembayaran === 'lunas')
                <span class="badge-lunas">LUNAS</span>
            @else
                <span class="badge-belum">BELUM LUNAS</span>
            @endif
        </td>
    </tr>
</table>

{{-- Detail Produk --}}
<table class="prod-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Produk</th>
            <th>Ukuran</th>
            <th>Bahan / Warna</th>
            <th class="num">Qty</th>
            <th class="num">Harga/pcs</th>
            <th class="num">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->details as $i => $d)
        @php
            $ukuran = $d->size_custom ?? ($d->size ? $d->size->name : $d->ukuran) ?? '-';
            $bahanWarna = array_filter([$d->bahan, $d->warna]);
        @endphp
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $d->jenis_produk }}</td>
            <td>{{ $ukuran }}</td>
            <td>{{ implode(' / ', $bahanWarna) ?: '-' }}</td>
            <td class="num">{{ number_format($d->jumlah, 0, ',', '.') }}</td>
            <td class="num">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
            <td class="num">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Ringkasan Harga --}}
<div class="summary-wrap">
    <div class="summary-right">
        <table class="summary-table">
            <tr>
                <td>Subtotal</td>
                <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            @if($order->diskon_nominal > 0)
            <tr>
                @if($order->diskon_jenis === 'nominal')
                    <td>Diskon (Nominal)</td>
                @else
                    <td>Diskon ({{ $order->diskon_persen }}%)</td>
                @endif
                <td style="color:#333;">- Rp {{ number_format($order->diskon_nominal, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="divider total-row">
                <td>Total</td>
                <td>Rp {{ number_format($order->total_setelah_diskon, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>DP / Terbayar</td>
                <td>Rp {{ number_format($order->dp, 0, ',', '.') }}</td>
            </tr>
            <tr class="{{ $order->sisa_tagihan > 0 ? 'sisa-row' : 'lunas-row' }}">
                <td>{{ $order->sisa_tagihan > 0 ? 'Sisa Tagihan' : 'Status' }}</td>
                <td>{{ $order->sisa_tagihan > 0 ? 'Rp ' . number_format($order->sisa_tagihan, 0, ',', '.') : 'LUNAS' }}</td>
            </tr>
        </table>
    </div>
</div>

{{-- Riwayat Pembayaran --}}
@if($order->payments->count() > 0)
<p style="font-size:10px; font-weight:700; margin-bottom:5px; color:#000;">Riwayat Pembayaran:</p>
<table class="pay-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Metode</th>
            <th style="text-align:right;">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->payments as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $p->tanggal_bayar->isoFormat('D MMM YYYY') }}</td>
            <td>{{ $p->tipe === 'dp' ? 'DP' : 'Pelunasan' }}</td>
            <td>{{ ucfirst($p->metode) }}</td>
            <td style="text-align:right; font-weight:600;">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- Tanda Tangan --}}
<div class="ttd-wrap">
    <div class="ttd-cell">
        <div class="ttd-box">
            <div class="ttd-label">Penerima / Pelanggan</div>
            <div class="ttd-name">{{ $order->customer->nama }}</div>
        </div>
    </div>
    <div class="ttd-cell">
        <div class="ttd-box">
            <div class="ttd-label">Hormat Kami, Anita Konveksi</div>
            <div class="ttd-name">( _____________________ )</div>
        </div>
    </div>
</div>

{{-- Footer --}}
<div class="doc-footer">
    Dicetak pada {{ now()->isoFormat('D MMMM YYYY, HH:mm') }} &mdash; Anita Konveksi &mdash; Dokumen ini sah tanpa tanda tangan basah jika di atas Rp 250.000 memerlukan materai.
</div>

</body>
</html>
