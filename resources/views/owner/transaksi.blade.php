@extends('layouts.dashboard')

@section('title', 'Daftar Transaksi')
@section('page-title', 'Daftar Transaksi')
@section('page-subtitle', 'Pantau semua transaksi pesanan Anita Konveksi')

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@push('styles')
<style>
    .status-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .sp-nunggu  { background: rgba(108,117,125,0.12); color: #6c757d; }
    .sp-proses  { background: rgba(255,159,28,0.15);  color: #cc7a00; }
    .sp-siap    { background: rgba(0,123,255,0.12);   color: #0056b3; }
    .sp-selesai { background: rgba(40,167,69,0.12);   color: #1a7a38; }
    .sp-qc      { background: rgba(111,66,193,0.12);  color: #5a2f9e; }
    .pay-belum  { background: rgba(220,53,69,0.1);    color: #b02a37; }
    .pay-lunas  { background: rgba(40,167,69,0.12);   color: #1a7a38; }
    .text-danger-fw { color: #dc3545; font-weight: 700; }
    .text-success-fw { color: #198754; font-weight: 700; }

    /* Filter bar */
    .filter-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 1rem 1.25rem;
        box-shadow: var(--shadow-sm);
        margin-bottom: 1.25rem;
    }
    .filter-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    .filter-row .fg { display: flex; flex-direction: column; gap: 4px; }
    .filter-row .fg label {
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .filter-row input,
    .filter-row select {
        padding: 8px 12px;
        font-size: 0.83rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        background: #fff;
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
        min-width: 150px;
    }
    .filter-row input[type=text] { min-width: 200px; }
    .filter-row input[type=month] { min-width: 140px; }

    /* Action top bar */
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 8px;
    }
    .export-group { display: flex; gap: 8px; }

    /* Summary pills */
    .summary-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 1.1rem;
    }
    .sum-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid var(--border);
        background: #fff;
        box-shadow: var(--shadow-sm);
    }
    .sum-pill i { font-size: 0.85rem; }
    .pill-total  { border-color: #dee2e6; color: var(--primary); }
    .pill-lunas  { border-color: rgba(40,167,69,0.3); color: #1a7a38; background: rgba(40,167,69,0.05); }
    .pill-belum  { border-color: rgba(220,53,69,0.3); color: #b02a37; background: rgba(220,53,69,0.05); }
    .pill-omset  { border-color: rgba(255,159,28,0.4); color: #cc7a00; background: rgba(255,159,28,0.07); }
</style>
@endpush

@section('dashboard-content')

{{-- Filter Card --}}
<div class="filter-card">
    <form method="GET" action="{{ route('owner.transaksi') }}" id="filterForm">
        <div class="filter-row">
            <div class="fg">
                <label>Cari</label>
                <input type="text" name="q" value="{{ $search }}" placeholder="Invoice / Nama Pelanggan...">
            </div>
            <div class="fg">
                <label>Status Produksi</label>
                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $key => $label)
                        <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fg">
                <label>Pembayaran</label>
                <select name="bayar">
                    <option value="">Semua</option>
                    <option value="lunas"  {{ $bayar === 'lunas'  ? 'selected' : '' }}>Lunas</option>
                    <option value="belum"  {{ $bayar === 'belum'  ? 'selected' : '' }}>Belum Lunas</option>
                </select>
            </div>
            <div class="fg">
                <label>Bulan</label>
                <input type="month" name="bulan" value="{{ $bulan }}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('owner.transaksi') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>
</div>

{{-- Summary Pills --}}
<div class="summary-pills">
    <div class="sum-pill pill-total">
        <i class="fas fa-list"></i>
        <span>{{ $orders->total() }} Transaksi</span>
    </div>
    <div class="sum-pill pill-lunas">
        <i class="fas fa-check-circle"></i>
        <span>{{ $orders->getCollection()->where('status_pembayaran', 'lunas')->count() }} Lunas (halaman ini)</span>
    </div>
    <div class="sum-pill pill-belum">
        <i class="fas fa-clock"></i>
        <span>{{ $orders->getCollection()->where('status_pembayaran', 'belum')->count() }} Belum Lunas (halaman ini)</span>
    </div>
    <div class="sum-pill pill-omset">
        <i class="fas fa-coins"></i>
        <span>Rp {{ number_format($orders->getCollection()->sum('total_setelah_diskon'), 0, ',', '.') }} (halaman ini)</span>
    </div>
</div>

{{-- Top Action Bar --}}
<div class="top-bar">
    <span style="font-size:0.82rem; color:var(--text-muted);">
        Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} transaksi
    </span>
    <div class="export-group">
        <a href="{{ route('owner.transaksi.export.excel', request()->query()) }}"
           class="btn btn-outline btn-sm">
            <i class="fas fa-file-excel" style="color:#1D6F42;"></i> Ekspor Excel
        </a>
        <a href="{{ route('owner.transaksi.export.pdf', request()->query()) }}"
           class="btn btn-outline btn-sm">
            <i class="fas fa-file-pdf" style="color:#dc3545;"></i> Ekspor PDF
        </a>
    </div>
</div>

{{-- Tabel --}}
<div class="content-card">
    <div style="overflow-x:auto;">
        @if($orders->isEmpty())
            <div style="padding:3rem; text-align:center; color:var(--text-muted);">
                <i class="fas fa-inbox" style="font-size:2.5rem; opacity:0.3; display:block; margin-bottom:.75rem;"></i>
                Tidak ada transaksi ditemukan.
            </div>
        @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Deadline</th>
                    <th>Total</th>
                    <th>DP</th>
                    <th>Sisa</th>
                    <th>Status Produksi</th>
                    <th>Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $o)
                @php
                    $sp = $o->status_produksi;
                    $pillClass = match(true) {
                        in_array($sp, ['nunggu_konfirmasi','menunggu_bahan'])                   => 'sp-nunggu',
                        in_array($sp, ['proses_potong','proses_jahit','proses_sablon_bordir'])  => 'sp-proses',
                        $sp === 'quality_control'                                               => 'sp-qc',
                        $sp === 'siap_diambil'                                                  => 'sp-siap',
                        $sp === 'selesai'                                                       => 'sp-selesai',
                        default                                                                 => 'sp-nunggu',
                    };
                @endphp
                <tr>
                    <td style="font-weight:700; color:var(--accent);">{{ $o->invoice_number }}</td>
                    <td>{{ $o->customer->nama }}</td>
                    <td>{{ $o->tanggal_pesan->format('d M Y') }}</td>
                    <td style="color:var(--text-muted);">
                        {{ $o->deadline ? $o->deadline->format('d M Y') : '-' }}
                    </td>
                    <td style="font-weight:600;">Rp {{ number_format($o->total_setelah_diskon, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($o->dp, 0, ',', '.') }}</td>
                    <td class="{{ $o->sisa_tagihan > 0 ? 'text-danger-fw' : 'text-success-fw' }}">
                        {{ $o->sisa_tagihan > 0 ? 'Rp '.number_format($o->sisa_tagihan, 0, ',', '.') : 'Lunas' }}
                    </td>
                    <td><span class="status-pill {{ $pillClass }}">{{ $o->status_label }}</span></td>
                    <td>
                        <span class="status-pill {{ $o->status_pembayaran === 'lunas' ? 'pay-lunas' : 'pay-belum' }}">
                            {{ $o->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
    <div style="padding: 1rem 1.25rem; border-top: 1px solid var(--border); display:flex; justify-content:flex-end;">
        {{ $orders->links('pagination::simple-bootstrap-4') }}
    </div>
    @endif
</div>

@endsection
