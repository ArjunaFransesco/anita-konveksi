@extends('layouts.dashboard')

@section('title', 'Piutang Pelanggan')
@section('page-title', 'Piutang Pelanggan')
@section('page-subtitle')
Pantau sisa tagihan pelanggan berdasarkan data pesanan dan pembayaran
@endsection

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@push('styles')
<style>
    .filter-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 1rem 1.25rem;
        box-shadow: var(--shadow-sm);
        margin-bottom: 1.25rem;
    }
    .filter-row { display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end; }
    .filter-row .fg { display:flex; flex-direction:column; gap:4px; }
    .filter-row label { font-size:.7rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.06em; }
    .filter-row input, .filter-row select {
        padding:8px 12px; font-size:.83rem; border:1px solid var(--border); border-radius:var(--radius-sm);
        background:#fff; font-family:'Inter', sans-serif; color:var(--text-main); min-width:160px;
    }
    .filter-row input[type=text] { min-width:220px; }
    .summary-line { display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom:1rem; }
    .muted-text { color:var(--text-muted); font-size:.82rem; }
    .amount-danger { color:#dc3545; font-weight:800; }
    .amount-success { color:#198754; font-weight:800; }
    .status-pill { display:inline-block; padding:3px 10px; border-radius:20px; font-size:.72rem; font-weight:700; white-space:nowrap; }
    .pill-danger { background:rgba(220,53,69,.10); color:#b02a37; }
    .pill-warning { background:rgba(255,159,28,.15); color:#cc7a00; }
    .pill-info { background:rgba(0,123,255,.10); color:#0056b3; }
    .pill-dark { background:rgba(26,26,26,.10); color:var(--primary); }
    .product-mini { max-width:280px; color:var(--text-muted); font-size:.78rem; line-height:1.45; }
    .invoice-text { font-weight:800; color:var(--accent-dark); }
</style>
@endpush

@section('dashboard-content')

<div class="stats-grid">
    <div class="stat-card dark">
        <div class="stat-icon"><i class="fas fa-file-invoice-dollar"></i></div>
        <div class="stat-value">Rp {{ number_format($totalPiutangAll, 0, ',', '.') }}</div>
        <div class="stat-label">Total Piutang Aktif</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-value">Rp {{ number_format($piutangJatuhTempoDekat, 0, ',', '.') }}</div>
        <div class="stat-label">Jatuh Tempo ≤ 7 Hari</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-receipt"></i></div>
        <div class="stat-value">{{ number_format($totalInvoicePiutang, 0, ',', '.') }}</div>
        <div class="stat-label">Invoice Belum Lunas</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-triangle-exclamation"></i></div>
        <div class="stat-value">Rp {{ number_format($piutangLewatTempo, 0, ',', '.') }}</div>
        <div class="stat-label">Piutang Lewat Tempo</div>
    </div>
</div>

<div class="filter-card">
    <form method="GET" action="{{ route('owner.piutang') }}">
        <div class="filter-row">
            <div class="fg">
                <label>Cari</label>
                <input type="text" name="q" value="{{ $search }}" placeholder="Invoice / pelanggan...">
            </div>
            <div class="fg">
                <label>Status Tempo</label>
                <select name="tempo">
                    <option value="">Semua Piutang</option>
                    <option value="lewat_tempo" {{ $statusTempo === 'lewat_tempo' ? 'selected' : '' }}>Lewat Tempo</option>
                    <option value="jatuh_tempo_dekat" {{ $statusTempo === 'jatuh_tempo_dekat' ? 'selected' : '' }}>Jatuh Tempo ≤ 7 Hari</option>
                    <option value="belum_jatuh_tempo" {{ $statusTempo === 'belum_jatuh_tempo' ? 'selected' : '' }}>Belum Jatuh Tempo</option>
                </select>
            </div>
            <div class="fg">
                <label>Bulan Pesanan</label>
                <input type="month" name="bulan" value="{{ $bulan }}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
            <a href="{{ route('owner.piutang') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i> Reset</a>
        </div>
    </form>
</div>

<div class="summary-line">
    <span class="muted-text">
        Menampilkan {{ $piutangRows->firstItem() ?? 0 }}–{{ $piutangRows->lastItem() ?? 0 }} dari {{ $piutangRows->total() }} piutang
    </span>
    <span class="status-pill pill-dark">
        Total hasil filter: Rp {{ number_format($filteredTotal, 0, ',', '.') }}
    </span>
</div>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fas fa-hand-holding-usd" style="color:var(--accent); margin-right:6px;"></i> Detail Piutang Pelanggan</h3>
        <span class="card-badge">Data dari tabel orders</span>
    </div>
    <div style="overflow-x:auto;">
        @if($piutangRows->isEmpty())
            <div class="empty-state">
                <i class="fas fa-circle-check"></i>
                <p>Tidak ada piutang aktif sesuai filter.</p>
            </div>
        @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Deadline</th>
                    <th>Produk Singkat</th>
                    <th>Total</th>
                    <th>Terbayar</th>
                    <th>Sisa Piutang</th>
                    <th>Status Tempo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($piutangRows as $order)
                    @php
                        $terbayar = (float) $order->payments->sum('jumlah');
                        $sisa = (float) $order->sisa_tagihan;
                        $deadlineDate = $order->deadline;
                        $isOverdue = $deadlineDate && $deadlineDate->lt($today);
                        $isDueSoon = $deadlineDate && !$isOverdue && $deadlineDate->lte($today->copy()->addDays(7));
                        $tempoLabel = $isOverdue ? 'Lewat Tempo' : ($isDueSoon ? 'Jatuh Tempo Dekat' : 'Belum Jatuh Tempo');
                        $tempoClass = $isOverdue ? 'pill-danger' : ($isDueSoon ? 'pill-warning' : 'pill-info');
                        $produk = $order->details->map(function($detail) {
                            $ukuran = $detail->size_custom ?: ($detail->ukuran ?: optional($detail->size)->name);
                            $ukuranText = $ukuran ? ' (' . $ukuran . ')' : '';
                            return $detail->jenis_produk . ' ' . number_format((float) $detail->jumlah, 0, ',', '.') . ' pcs' . $ukuranText;
                        })->filter()->implode(', ');
                    @endphp
                    <tr>
                        <td class="invoice-text">{{ $order->invoice_number }}</td>
                        <td>
                            <div style="font-weight:700;">{{ $order->customer->nama ?? '-' }}</div>
                            <div class="muted-text">{{ $order->customer->no_hp ?? '-' }}</div>
                        </td>
                        <td>{{ $order->tanggal_pesan?->format('d M Y') ?? '-' }}</td>
                        <td>{{ $deadlineDate ? $deadlineDate->format('d M Y') : '-' }}</td>
                        <td><div class="product-mini">{{ $produk ?: '-' }}</div></td>
                        <td style="font-weight:700;">Rp {{ number_format((float) $order->total_setelah_diskon, 0, ',', '.') }}</td>
                        <td class="amount-success">Rp {{ number_format($terbayar, 0, ',', '.') }}</td>
                        <td class="amount-danger">Rp {{ number_format($sisa, 0, ',', '.') }}</td>
                        <td><span class="status-pill {{ $tempoClass }}">{{ $tempoLabel }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<div style="margin-top:1rem;">
    {{ $piutangRows->links() }}
</div>

@endsection
