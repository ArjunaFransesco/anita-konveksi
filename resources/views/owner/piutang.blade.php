@extends('layouts.dashboard')

@section('title', 'Laporan Piutang')
@section('page-title', 'Laporan Piutang')
@section('page-subtitle')
Rekap tagihan / sisa pembayaran pelanggan
@endsection

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@section('dashboard-content')

<div class="cards-grid" style="grid-template-columns: 1fr 1fr; margin-bottom: 1.5rem;">
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 120px;">
        <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); margin-bottom: 1rem;">Total Piutang</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">Rp 15.000.000</div>
    </div>
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 120px;">
        <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); margin-bottom: 1rem;">Jatuh Tempo (Segera)</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">Rp 4.500.000</div>
    </div>
</div>

<div class="content-card" style="background-color: #E9ECEF; border: none; min-height: 400px; border-radius: var(--radius-md); padding: 1.5rem;">
    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--primary); margin-bottom: 1rem;">Detail Piutang Pelanggan</h3>
    <div style="display: flex; align-items: center; justify-content: center; height: 300px;">
        <p style="color: var(--text-muted);">[ Tabel / List Piutang Pelanggan ]</p>
    </div>
</div>

@endsection
