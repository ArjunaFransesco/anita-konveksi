@extends('layouts.dashboard')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', 'Pantau semua pesanan pelanggan Anita Konveksi')

@section('sidebar-menu')
    @include('admin.sidebar')
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
    .filter-row input[type=text] { min-width: 250px; }

    /* Action top bar */
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 8px;
    }
</style>
@endpush

@section('dashboard-content')

<div class="section-header">
    <div>
        <h2><i class="fas fa-shopping-cart" style="color:var(--accent); margin-right:8px;"></i>Detail Pesanan</h2>
        <p>Seluruh data pesanan pelanggan</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- Filter Card --}}
<div class="filter-card">
    <form method="GET" action="{{ route('admin.pesanan.index') }}">
        <div class="filter-row">
            <div class="fg">
                <label>Pencarian</label>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari No. Invoice / Pelanggan...">
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
            <button type="submit" class="btn btn-dark btn-sm" style="margin-bottom: 2px;">
                <i class="fas fa-search"></i> Cari
            </button>
            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline btn-sm" style="margin-bottom: 2px;">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>
</div>

{{-- Top Action Bar --}}
<div class="top-bar">
    <span style="font-size:0.85rem; color:var(--text-muted);">
        Menampilkan {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} dari total {{ $orders->total() }} pesanan
    </span>
</div>

<div class="content-card">
    <div style="overflow-x:auto;">
        @if($orders->isEmpty())
            <div style="padding:3rem; text-align:center; color:var(--text-muted);">
                <i class="fas fa-box-open" style="font-size:2.5rem; opacity:0.3; display:block; margin-bottom:.75rem;"></i>
                Tidak ada pesanan ditemukan.
            </div>
        @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Produk & Qty</th>
                    <th>Tgl Pesan</th>
                    <th>Tenggat (Deadline)</th>
                    <th>Total Biaya</th>
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

                    // Aggregate products string
                    $productsStr = '';
                    $totalQty = 0;
                    foreach($o->details as $idx => $d) {
                        $productsStr .= $d->jenis_produk;
                        if($idx < count($o->details) - 1) $productsStr .= ', ';
                        $totalQty += $d->jumlah;
                    }
                @endphp
                <tr>
                    <td style="font-weight:700; color:var(--accent);">{{ $o->invoice_number }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $o->customer->nama }}</div>
                        <div style="font-size:0.75rem; color:var(--text-muted);">{{ $o->customer->no_hp ?? '-' }}</div>
                    </td>
                    <td>
                        <div style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $productsStr }}">
                            {{ $productsStr }}
                        </div>
                        <div style="font-size:0.75rem; font-weight:700; color:var(--primary); margin-top:3px;">
                            Total: {{ $totalQty }} pcs
                        </div>
                    </td>
                    <td>{{ $o->tanggal_pesan->format('d M Y') }}</td>
                    <td style="color:var(--text-muted);">
                        @if($o->deadline)
                            @if(now()->startOfDay()->gt(\Carbon\Carbon::parse($o->deadline)) && !in_array($o->status_produksi, ['siap_diambil', 'selesai']))
                                <span style="color:#dc3545; font-weight:700;"><i class="fas fa-exclamation-circle"></i> {{ $o->deadline->format('d M Y') }}</span>
                            @else
                                {{ $o->deadline->format('d M Y') }}
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td style="font-weight:600;">Rp {{ number_format($o->total_setelah_diskon, 0, ',', '.') }}</td>
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
    
    @if($orders->hasPages())
    <div style="padding: 1rem 1.25rem; border-top: 1px solid var(--border); display:flex; justify-content:flex-end;">
        {{ $orders->links('pagination::simple-bootstrap-4') }}
    </div>
    @endif
</div>

@endsection
