@extends('layouts.dashboard')

@section('title', 'Dashboard Kasir')
@section('page-title', 'Dashboard Kasir')
@section('page-subtitle')
Tugas Hari ini — {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
@endsection

@section('sidebar-menu')
    @include('kasir.sidebar')
@endsection

@push('styles')
<style>
    /* Status badge label dalam tabel */
    .status-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .sp-nunggu    { background: rgba(108,117,125,0.12); color: #6c757d; }
    .sp-proses    { background: rgba(255,159,28,0.15);  color: #cc7a00; }
    .sp-siap      { background: rgba(0,123,255,0.12);   color: #0056b3; }
    .sp-selesai   { background: rgba(40,167,69,0.12);   color: #1a7a38; }
    .sp-qc        { background: rgba(111,66,193,0.12);  color: #5a2f9e; }

    .pay-belum  { background: rgba(220,53,69,0.1);  color: #b02a37; }
    .pay-lunas  { background: rgba(40,167,69,0.12); color: #1a7a38; }

    /* Quick-action chips di atas tabel */
    .quick-links {
        display: flex;
        gap: 10px;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
    }
    .quick-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        text-decoration: none;
        color: var(--text-main);
        font-size: 0.83rem;
        font-weight: 600;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        flex: 1;
        min-width: 160px;
    }
    .quick-link:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
        border-color: var(--accent);
        color: var(--accent-dark);
    }
    .quick-link .ql-icon {
        width: 34px; height: 34px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .ql-blue   { background: rgba(0,123,255,0.1);  color: #0056b3; }
    .ql-orange { background: var(--accent-light);  color: var(--accent-dark); }
    .ql-green  { background: rgba(40,167,69,0.1);  color: #1a7a38; }
    .ql-label  { line-height: 1.2; }
    .ql-label small { font-size: 0.7rem; color: var(--text-muted); font-weight: 400; display: block; }
</style>
@endpush

@section('dashboard-content')

{{-- ── STAT CARDS ── --}}
<div class="stats-grid">
    <div class="stat-card dark">
        <div class="stat-icon"><i class="fas fa-file-invoice"></i></div>
        <div class="stat-value">{{ $totalPesanan }}</div>
        <div class="stat-label">Total Pesanan</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-value">{{ $menungguDP }}</div>
        <div class="stat-label">Menunggu Pelunasan</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-box-open"></i></div>
        <div class="stat-value">{{ $siapDiambil }}</div>
        <div class="stat-label">Siap Diambil</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-value">{{ $selesai }}</div>
        <div class="stat-label">Selesai</div>
    </div>
</div>

{{-- ── QUICK ACTIONS ── --}}
<div class="quick-links">
    <a href="{{ route('kasir.pesanan.input') }}" class="quick-link">
        <div class="ql-icon ql-blue"><i class="fas fa-cart-plus"></i></div>
        <div class="ql-label">Input Pesanan <small>Buat pesanan baru</small></div>
    </a>
    <a href="{{ route('kasir.pesanan.index') }}" class="quick-link">
        <div class="ql-icon ql-orange"><i class="fas fa-tasks"></i></div>
        <div class="ql-label">Update Status <small>Kelola status produksi</small></div>
    </a>
    <a href="{{ route('kasir.pembayaran.catat') }}" class="quick-link">
        <div class="ql-icon ql-green"><i class="fas fa-file-invoice-dollar"></i></div>
        <div class="ql-label">Catat Pembayaran <small>DP atau pelunasan</small></div>
    </a>
</div>

{{-- ── TABEL PESANAN TERBARU ── --}}
<div class="content-card">
    <div class="card-header" style="background:#F8F9FA;">
        <h3>Pesanan Terbaru</h3>
        <a href="{{ route('kasir.pesanan.index') }}" class="btn btn-outline btn-sm">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    @if($recentOrders->isEmpty())
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Belum ada pesanan. <a href="{{ route('kasir.pesanan.input') }}">Input pesanan pertama</a></p>
        </div>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Deadline</th>
                    <th>Total</th>
                    <th>Sisa</th>
                    <th>Status Produksi</th>
                    <th>Pembayaran</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                @php
                    $sp = $order->status_produksi;
                    $pillClass = match(true) {
                        in_array($sp, ['nunggu_konfirmasi','menunggu_bahan'])    => 'sp-nunggu',
                        in_array($sp, ['proses_potong','proses_jahit','proses_sablon_bordir']) => 'sp-proses',
                        $sp === 'quality_control'                                => 'sp-qc',
                        $sp === 'siap_diambil'                                   => 'sp-siap',
                        $sp === 'selesai'                                        => 'sp-selesai',
                        default                                                  => 'sp-nunggu',
                    };
                @endphp
                <tr>
                    <td><span style="font-weight:700; font-size:0.82rem;">{{ $order->invoice_number }}</span></td>
                    <td>{{ $order->customer->nama }}</td>
                    <td style="white-space:nowrap; font-size:0.8rem; color:var(--text-muted);">
                        {{ $order->tanggal_pesan->format('d M Y') }}
                    </td>
                    <td style="white-space:nowrap; font-size:0.8rem; color:var(--text-muted);">
                        {{ $order->deadline ? $order->deadline->format('d M Y') : '-' }}
                    </td>
                    <td style="font-weight:600; white-space:nowrap;">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </td>
                    <td style="white-space:nowrap; {{ $order->sisa_tagihan > 0 ? 'color:#dc3545; font-weight:700;' : 'color:#28a745; font-weight:700;' }}">
                        {{ $order->sisa_tagihan > 0 ? 'Rp '.number_format($order->sisa_tagihan, 0, ',', '.') : 'Lunas' }}
                    </td>
                    <td>
                        <span class="status-pill {{ $pillClass }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td>
                        <span class="status-pill {{ $order->status_pembayaran === 'lunas' ? 'pay-lunas' : 'pay-belum' }}">
                            {{ $order->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('kasir.pembayaran.catat', ['order_id' => $order->id]) }}"
                               class="btn btn-sm btn-outline" title="Catat Bayar">
                                <i class="fas fa-money-bill-wave"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection