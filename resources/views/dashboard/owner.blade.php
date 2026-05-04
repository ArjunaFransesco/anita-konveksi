@extends('layouts.dashboard')

@section('title', 'Dashboard Owner')
@section('page-title', 'Selamat Datang, Owner!')
@section('page-subtitle')
Dashboard Utama Anita Konveksi — {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
@endsection

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@section('dashboard-content')

<div class="stats-grid">
    <div class="stat-card dark">
        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        <div class="stat-value">Rp 120 Jt</div>
        <div class="stat-label">Total Omset Bulan Ini</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-hand-holding-usd"></i></div>
        <div class="stat-value">Rp 85 Jt</div>
        <div class="stat-label">Total Pemasukan</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-value">Rp 35 Jt</div>
        <div class="stat-label">Total Pengeluaran</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-file-invoice-dollar"></i></div>
        <div class="stat-value">Rp 15 Jt</div>
        <div class="stat-label">Total Piutang Belum Lunas</div>
    </div>
</div>

<div class="cards-grid">
    <div class="content-card" style="min-height: 400px;">
        <div class="card-header" style="background-color: #E9ECEF;">
            <h3>Grafik Pemasukan & Pengeluaran</h3>
        </div>
        <div class="card-body" style="display:flex; align-items:center; justify-content:center;">
            <p style="color: var(--text-muted);">[ Area Grafik / Chart ]</p>
        </div>
    </div>

    <div class="content-card" style="min-height: 400px;">
        <div class="card-header" style="background-color: #E9ECEF;">
            <h3>Ringkasan Transaksi Terbaru</h3>
        </div>
        <div class="card-body" style="display:flex; align-items:center; justify-content:center;">
            <p style="color: var(--text-muted);">[ List Transaksi Terbaru ]</p>
        </div>
    </div>
</div>

@endsection