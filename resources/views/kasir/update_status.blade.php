@extends('layouts.dashboard')

@section('title', 'Daftar & Update Pesanan')
@section('page-title', 'Daftar Pesanan')
@section('page-subtitle', 'Pantau dan perbarui status produksi setiap pesanan')

@section('sidebar-menu')
    @include('kasir.sidebar')
@endsection

@push('styles')
<style>
    .search-bar {
        background: #fff;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1.25rem;
    }
    .search-bar input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
        background: transparent;
    }
    .search-bar i { color: var(--text-muted); }

    .order-card {
        background: #fff;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        overflow: hidden;
        transition: var(--transition);
    }
    .order-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }
    .order-card-header {
        padding: 0.9rem 1.1rem 0.7rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }
    .inv-number {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--primary);
    }
    .order-card-body { padding: 0.9rem 1.1rem; }

    .order-meta {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 0.6rem;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }
    .order-meta span { display: flex; align-items: center; gap: 6px; }
    .order-meta i { width: 14px; text-align: center; color: var(--accent); }

    /* Progress bar */
    .progress-wrap { margin-bottom: 0.85rem; }
    .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.72rem;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .progress-bar-bg {
        height: 6px;
        background: #E9ECEF;
        border-radius: 3px;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        border-radius: 3px;
        background: var(--accent);
        transition: width 0.5s ease;
    }
    .progress-bar-fill.done { background: #28a745; }

    /* Update form inline */
    .update-form {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .update-form select {
        flex: 1;
        padding: 7px 10px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 0.78rem;
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
        background: #F8F9FA;
        cursor: pointer;
    }
    .update-form select:focus { outline: none; border-color: var(--accent); }

    .cards-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    @media (max-width: 1100px) { .cards-3 { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 700px)  { .cards-3 { grid-template-columns: 1fr; } }

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        color: var(--text-muted);
    }
    .empty-state i { font-size: 3rem; opacity: 0.25; display: block; margin-bottom: 1rem; }
</style>
@endpush

@section('dashboard-content')

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif

{{-- Search --}}
<form method="GET" action="{{ route('kasir.pesanan.index') }}" class="search-bar">
    <i class="fas fa-search"></i>
    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari No. Invoice atau Nama Pelanggan...">
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    @if($search)
        <a href="{{ route('kasir.pesanan.index') }}" class="btn btn-outline btn-sm">Reset</a>
    @endif
</form>

{{-- Header aksi --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
    <div style="font-size:0.82rem; color:var(--text-muted);">
        <b style="color:var(--primary);">{{ $orders->count() }}</b> pesanan ditemukan
    </div>
    <a href="{{ route('kasir.pesanan.input') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Pesanan Baru
    </a>
</div>

{{-- Order Cards --}}
@if($orders->isEmpty())
    <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <p>Belum ada pesanan{{ $search ? ' yang cocok' : '' }}.</p>
        <a href="{{ route('kasir.pesanan.input') }}" class="btn btn-primary" style="margin-top:1rem;">
            <i class="fas fa-plus"></i> Input Pesanan Pertama
        </a>
    </div>
@else
    <div class="cards-3">
        @foreach($orders as $order)
        @php
            $progress  = $order->progress;
            $isDone    = $order->status_produksi === 'selesai';
            $statusMap = \App\Models\Order::$statusProduksiLabels;
        @endphp
        <div class="order-card">
            <div class="order-card-header">
                <div>
                    <div class="inv-number">{{ $order->invoice_number }}</div>
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-top:2px;">{{ $order->customer->nama }}</div>
                </div>
                <span class="badge {{ $order->status_pembayaran === 'lunas' ? 'badge-success' : 'badge-warning' }}">
                    {{ $order->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                </span>
            </div>
            <div class="order-card-body">
                <div class="order-meta">
                    <span><i class="fas fa-calendar-alt"></i> Deadline: {{ $order->deadline ? $order->deadline->format('d M Y') : '-' }}</span>
                    <span><i class="fas fa-coins"></i> Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    <span><i class="fas fa-hand-holding-usd"></i> Sisa: Rp {{ number_format($order->sisa_tagihan, 0, ',', '.') }}</span>
                </div>

                {{-- Progress --}}
                <div class="progress-wrap">
                    <div class="progress-label">
                        <span style="color:var(--text-main);">{{ $order->status_label }}</span>
                        <span style="color:var(--accent);">{{ $progress }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill {{ $isDone ? 'done' : '' }}" style="width:{{ $progress }}%"></div>
                    </div>
                </div>

                {{-- Update form --}}
                <form method="POST" action="{{ route('kasir.pesanan.status', $order->id) }}" class="update-form">
                    @csrf
                    <select name="status_produksi">
                        @foreach($statusMap as $val => $label)
                            <option value="{{ $val }}" {{ $order->status_produksi === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm" style="background:var(--accent); color:var(--primary); flex-shrink:0;">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
