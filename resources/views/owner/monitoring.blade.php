@extends('layouts.dashboard')

@section('title', 'Monitoring Produksi')
@section('page-title', 'Monitoring Produksi')
@section('page-subtitle')
Pantau progres produksi berdasarkan status pesanan yang tersimpan di database
@endsection

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@push('styles')
<style>
    .filter-card {
        background:#fff; border:1px solid var(--border); border-radius:var(--radius-md);
        padding:1rem 1.25rem; box-shadow:var(--shadow-sm); margin-bottom:1.25rem;
    }
    .filter-row { display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end; }
    .filter-row .fg { display:flex; flex-direction:column; gap:4px; }
    .filter-row label { font-size:.7rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.06em; }
    .filter-row input, .filter-row select {
        padding:8px 12px; font-size:.83rem; border:1px solid var(--border); border-radius:var(--radius-sm);
        background:#fff; font-family:'Inter', sans-serif; color:var(--text-main); min-width:160px;
    }
    .filter-row input[type=text] { min-width:220px; }
    .status-pill { display:inline-block; padding:3px 10px; border-radius:20px; font-size:.72rem; font-weight:700; white-space:nowrap; }
    .sp-nunggu { background:rgba(108,117,125,.12); color:#6c757d; }
    .sp-proses { background:rgba(255,159,28,.15); color:#cc7a00; }
    .sp-siap { background:rgba(0,123,255,.12); color:#0056b3; }
    .sp-selesai { background:rgba(40,167,69,.12); color:#1a7a38; }
    .sp-qc { background:rgba(111,66,193,.12); color:#5a2f9e; }
    .deadline-danger { color:#dc3545; font-weight:800; }
    .deadline-warning { color:#cc7a00; font-weight:800; }
    .muted-text { color:var(--text-muted); font-size:.82rem; }
    .product-mini { max-width:300px; color:var(--text-muted); font-size:.78rem; line-height:1.45; }
    .progress-wrap { min-width:150px; }
    .progress-bar-bg { height:8px; border-radius:999px; background:var(--border); overflow:hidden; margin-bottom:5px; }
    .progress-bar-fill { height:100%; border-radius:999px; background:var(--accent); }
    .status-board { display:grid; grid-template-columns:repeat(4, 1fr); gap:1rem; margin-bottom:1.5rem; }
    .status-card { background:#fff; border:1px solid var(--border); border-radius:var(--radius-md); box-shadow:var(--shadow-sm); padding:1rem; }
    .status-card .label { font-size:.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.05em; margin-bottom:6px; }
    .status-card .value { font-family:'Montserrat', sans-serif; font-size:1.4rem; font-weight:800; color:var(--primary); }
    .status-card .bar { height:5px; border-radius:999px; background:var(--border); overflow:hidden; margin-top:10px; }
    .status-card .bar span { display:block; height:100%; background:var(--accent); border-radius:999px; }
    @media (max-width:1100px) { .status-board { grid-template-columns:repeat(2, 1fr); } }
    @media (max-width:700px) { .status-board { grid-template-columns:1fr; } }
</style>
@endpush

@section('dashboard-content')

<div class="stats-grid">
    <div class="stat-card dark">
        <div class="stat-icon"><i class="fas fa-list-check"></i></div>
        <div class="stat-value">{{ number_format($totalPesanan, 0, ',', '.') }}</div>
        <div class="stat-label">Total Pesanan</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-gears"></i></div>
        <div class="stat-value">{{ number_format($totalAktif, 0, ',', '.') }}</div>
        <div class="stat-label">Produksi Aktif</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-box-open"></i></div>
        <div class="stat-value">{{ number_format($totalSiapDiambil, 0, ',', '.') }}</div>
        <div class="stat-label">Siap Diambil</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-triangle-exclamation"></i></div>
        <div class="stat-value">{{ number_format($totalLewatDeadline, 0, ',', '.') }}</div>
        <div class="stat-label">Lewat Deadline</div>
    </div>
</div>

<div class="filter-card">
    <form method="GET" action="{{ route('owner.monitoring') }}">
        <div class="filter-row">
            <div class="fg">
                <label>Cari</label>
                <input type="text" name="q" value="{{ $search }}" placeholder="Invoice / pelanggan / produk...">
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
                <label>Deadline</label>
                <select name="deadline">
                    <option value="">Semua Deadline</option>
                    <option value="lewat" {{ $deadline === 'lewat' ? 'selected' : '' }}>Lewat Deadline</option>
                    <option value="minggu_ini" {{ $deadline === 'minggu_ini' ? 'selected' : '' }}>Jatuh Tempo ≤ 7 Hari</option>
                    <option value="tanpa_deadline" {{ $deadline === 'tanpa_deadline' ? 'selected' : '' }}>Tanpa Deadline</option>
                </select>
            </div>
            <div class="fg">
                <label>Bulan Pesanan</label>
                <input type="month" name="bulan" value="{{ $bulan }}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
            <a href="{{ route('owner.monitoring') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i> Reset</a>
        </div>
    </form>
</div>

<div class="status-board">
    @foreach($statusList as $key => $label)
        @php
            $count = (int) ($statusCounts[$key] ?? 0);
            $percent = $totalPesanan > 0 ? min(100, round(($count / $totalPesanan) * 100)) : 0;
        @endphp
        <div class="status-card">
            <div class="label">{{ $label }}</div>
            <div class="value">{{ $count }}</div>
            <div class="bar"><span style="width: {{ $percent }}%;"></span></div>
            <div class="muted-text" style="margin-top:6px;">{{ $percent }}% dari total pesanan</div>
        </div>
    @endforeach
</div>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fas fa-industry" style="color:var(--accent); margin-right:6px;"></i> Daftar Monitoring Produksi</h3>
        <span class="card-badge">{{ $orders->total() }} data</span>
    </div>
    <div style="overflow-x:auto;">
        @if($orders->isEmpty())
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Tidak ada data produksi sesuai filter.</p>
            </div>
        @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Pelanggan</th>
                    <th>Produk Singkat</th>
                    <th>Tanggal Pesan</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Nilai Pesanan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    @php
                        $sp = $order->status_produksi;
                        $pillClass = match(true) {
                            in_array($sp, ['nunggu_konfirmasi','menunggu_bahan']) => 'sp-nunggu',
                            in_array($sp, ['proses_potong','proses_jahit','proses_sablon_bordir']) => 'sp-proses',
                            $sp === 'quality_control' => 'sp-qc',
                            $sp === 'siap_diambil' => 'sp-siap',
                            $sp === 'selesai' => 'sp-selesai',
                            default => 'sp-nunggu',
                        };
                        $deadlineDate = $order->deadline;
                        $deadlineClass = '';
                        $deadlineNote = '';
                        if ($deadlineDate && $order->status_produksi !== 'selesai') {
                            if ($deadlineDate->lt($today)) {
                                $deadlineClass = 'deadline-danger';
                                $deadlineNote = 'Lewat ' . $deadlineDate->diffInDays($today) . ' hari';
                            } elseif ($deadlineDate->lte($today->copy()->addDays(7))) {
                                $deadlineClass = 'deadline-warning';
                                $deadlineNote = $today->diffInDays($deadlineDate) . ' hari lagi';
                            }
                        }
                        $produk = $order->details->map(function($detail) {
                            $ukuran = $detail->size_custom ?: ($detail->ukuran ?: optional($detail->size)->name);
                            $ukuranText = $ukuran ? ' (' . $ukuran . ')' : '';
                            return $detail->jenis_produk . ' ' . number_format((float) $detail->jumlah, 0, ',', '.') . ' pcs' . $ukuranText;
                        })->filter()->implode(', ');
                    @endphp
                    <tr>
                        <td style="font-weight:800; color:var(--accent-dark);">{{ $order->invoice_number }}</td>
                        <td>
                            <div style="font-weight:700;">{{ $order->customer->nama ?? '-' }}</div>
                            <div class="muted-text">{{ $order->customer->no_hp ?? '-' }}</div>
                        </td>
                        <td><div class="product-mini">{{ $produk ?: '-' }}</div></td>
                        <td>{{ $order->tanggal_pesan?->format('d M Y') ?? '-' }}</td>
                        <td>
                            <div class="{{ $deadlineClass }}">{{ $deadlineDate ? $deadlineDate->format('d M Y') : '-' }}</div>
                            @if($deadlineNote)
                                <div class="muted-text">{{ $deadlineNote }}</div>
                            @endif
                        </td>
                        <td><span class="status-pill {{ $pillClass }}">{{ $order->status_label }}</span></td>
                        <td>
                            <div class="progress-wrap">
                                <div class="progress-bar-bg"><div class="progress-bar-fill" style="width: {{ $order->progress }}%;"></div></div>
                                <div class="muted-text">{{ $order->progress }}%</div>
                            </div>
                        </td>
                        <td style="font-weight:700;">Rp {{ number_format((float) $order->total_setelah_diskon, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<div style="margin-top:1rem;">
    {{ $orders->links() }}
</div>

@endsection
