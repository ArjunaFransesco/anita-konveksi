<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pesanan Pegawai — {{ $order->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #fff;
            padding: 24px 28px;
        }

        /* ── Header ─────────────────────────── */
        .header {
            border-bottom: 3px solid #333;
            padding-bottom: 12px;
            margin-bottom: 16px;
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
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            background: #333;
            padding: 5px 12px;
            border-radius: 4px;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: inline-block;
        }
        .invoice-num { font-size: 10px; color: #555; margin-top: 5px; text-align: right; }

        /* ── Info Section ────────────────────── */
        .info-box {
            background: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 14px;
            display: table;
            width: 100%;
        }
        .info-left { display: table-cell; width: 50%; vertical-align: top; }
        .info-right { display: table-cell; width: 50%; vertical-align: top; padding-left: 16px; }
        .info-row { margin-bottom: 4px; font-size: 10.5px; }
        .info-label { color: #555; display: inline-block; width: 90px; }
        .info-value { font-weight: 600; }

        /* ── Deadline Alert ─────────────────── */
        .deadline-box {
            background: #eee;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 8px 14px;
            margin-bottom: 14px;
            font-size: 11px;
            font-weight: 600;
            color: #333;
        }
        .deadline-box span { font-size: 13px; }

        /* ── Tabel Produk ───────────────────── */
        .prod-section-title {
            font-size: 11px;
            font-weight: 700;
            color: #000;
            margin-bottom: 6px;
            padding-bottom: 3px;
            border-bottom: 1px solid #ccc;
        }
        .prod-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .prod-table thead tr { background: #333; color: #fff; }
        .prod-table th { padding: 7px 9px; font-size: 10px; text-align: left; font-weight: 600; }
        .prod-table td { padding: 7px 9px; font-size: 10.5px; border-bottom: 1px solid #ccc; vertical-align: top; }
        .prod-table tbody tr:nth-child(even) { background: #f5f5f5; }
        .qty-badge {
            display: inline-block;
            background: #333;
            color: #fff;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 10px;
        }

        /* ── Desain / Logo section ──────────── */
        .desain-list { margin-top: 4px; padding-left: 12px; }
        .desain-item { font-size: 9.5px; color: #333; margin-bottom: 2px; list-style: disc; }

        /* ── Catatan ───────────────────────── */
        .notes-box {
            border: 1px dashed #999;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 16px;
            font-size: 10px;
            color: #333;
        }
        .notes-box strong { color: #000; }

        /* ── TTD ────────────────────────────── */
        .ttd-wrap { display: table; width: 100%; margin-top: 20px; }
        .ttd-cell { display: table-cell; text-align: center; width: 33.33%; }
        .ttd-box {
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 8px;
            margin: 0 6px;
        }
        .ttd-label { font-size: 9.5px; color: #555; margin-bottom: 44px; }
        .ttd-name { font-size: 10px; font-weight: 700; border-top: 1px solid #aaa; display: inline-block; padding-top: 4px; min-width: 90px; }

        /* ── Footer ─────────────────────────── */
        .doc-footer {
            border-top: 1px dashed #ccc;
            padding-top: 8px;
            margin-top: 14px;
            font-size: 9px;
            color: #555;
            text-align: center;
        }
        .no-price-notice {
            background: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 9px;
            color: #333;
            text-align: center;
            margin-bottom: 10px;
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
        <div class="doc-title">Surat Pesanan Produksi</div>
        <div class="invoice-num">{{ $order->invoice_number }}</div>
    </div>
</div>

{{-- Pemberitahuan --}}
<div class="no-price-notice">
    ⚠ Dokumen ini TIDAK mencantumkan informasi harga — khusus untuk keperluan produksi internal
</div>

{{-- Info Pesanan --}}
<div class="info-box">
    <div class="info-left">
        <div class="info-row">
            <span class="info-label">Pelanggan</span>: <span class="info-value">{{ $order->customer->nama }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">No. HP</span>: <span class="info-value">{{ $order->customer->no_hp ?? '-' }}</span>
        </div>
        @if($order->customer->alamat)
        <div class="info-row">
            <span class="info-label">Alamat</span>: <span class="info-value">{{ $order->customer->alamat }}</span>
        </div>
        @endif
    </div>
    <div class="info-right">
        <div class="info-row">
            <span class="info-label">Tgl. Pesan</span>: <span class="info-value">{{ $order->tanggal_pesan->isoFormat('D MMMM YYYY') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">No. Invoice</span>: <span class="info-value">{{ $order->invoice_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status</span>: <span class="info-value">{{ $order->status_label }}</span>
        </div>
    </div>
</div>

{{-- Deadline Alert --}}
@if($order->deadline)
<div class="deadline-box">
    ⏰ DEADLINE: <span>{{ $order->deadline->isoFormat('D MMMM YYYY') }}</span>
    @php $sisa = now()->diffInDays($order->deadline, false); @endphp
    @if($sisa > 0)
        &nbsp;({{ $sisa }} hari lagi)
    @elseif($sisa === 0)
        &nbsp;(Hari ini!)
    @else
        &nbsp;<span style="color:#333; font-weight: bold;">(SUDAH LEWAT {{ abs($sisa) }} hari)</span>
    @endif
</div>
@endif

{{-- Detail Produk --}}
<div class="prod-section-title">📦 Detail Produk yang Dipesan</div>
<table class="prod-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Jenis Produk</th>
            <th>Qty</th>
            <th>Ukuran</th>
            <th>Bahan</th>
            <th>Warna</th>
            <th>Keterangan Desain / Sablon</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->details as $i => $d)
        @php
            $ukuran = $d->size_custom ?? ($d->size ? $d->size->name : $d->ukuran) ?? '-';

            // Kumpulkan semua keterangan desain
            $desainList = [];
            if ($d->logoItems->isNotEmpty()) {
                foreach ($d->logoItems as $li) {
                    if ($li->keterangan_desain) {
                        $desainList[] = $li->keterangan_desain;
                    }
                }
            }
            if (empty($desainList) && $d->desain) {
                $desainList[] = $d->desain;
            }
        @endphp
        <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $d->jenis_produk }}</strong></td>
            <td><span class="qty-badge">{{ number_format($d->jumlah, 0, ',', '.') }} pcs</span></td>
            <td>{{ $ukuran }}</td>
            <td>{{ $d->bahan ?? '-' }}</td>
            <td>{{ $d->warna ?? '-' }}</td>
            <td>
                @if(count($desainList) > 0)
                    <ul class="desain-list">
                        @foreach($desainList as $dk)
                            <li class="desain-item">{{ $dk }}</li>
                        @endforeach
                    </ul>
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Catatan --}}
<div class="notes-box">
    <strong>Catatan untuk Pegawai:</strong><br>
    Pastikan setiap item sesuai dengan spesifikasi di atas. Jika ada pertanyaan atau ketidaksesuaian bahan, segera hubungi pemilik sebelum melanjutkan produksi.
    @if($order->deadline)
    Pesanan ini harus selesai sebelum tanggal <strong>{{ $order->deadline->isoFormat('D MMMM YYYY') }}</strong>.
    @endif
</div>

{{-- Tanda Tangan --}}
<div class="ttd-wrap">
    <div class="ttd-cell">
        <div class="ttd-box">
            <div class="ttd-label">Dikeluarkan oleh</div>
            <div class="ttd-name">Pemilik</div>
        </div>
    </div>
    <div class="ttd-cell">
        <div class="ttd-box">
            <div class="ttd-label">Diterima oleh</div>
            <div class="ttd-name">Pegawai Produksi</div>
        </div>
    </div>
    <div class="ttd-cell">
        <div class="ttd-box">
            <div class="ttd-label">Quality Control</div>
            <div class="ttd-name">( _________________ )</div>
        </div>
    </div>
</div>

{{-- Footer --}}
<div class="doc-footer">
    Dicetak pada {{ now()->isoFormat('D MMMM YYYY, HH:mm') }} &mdash; Anita Konveksi &mdash; Dokumen ini HANYA untuk keperluan produksi internal. Tidak mencantumkan harga.
</div>

</body>
</html>
