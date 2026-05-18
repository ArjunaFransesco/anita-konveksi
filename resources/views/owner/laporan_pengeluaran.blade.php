@extends('layouts.dashboard')

@section('title', 'Laporan Pengeluaran')
@section('page-title', 'Laporan Pengeluaran')
@section('page-subtitle')
Rekap seluruh transaksi pengeluaran
@endsection

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@section('dashboard-content')

<div class="content-card" style="margin-bottom: 1.5rem; background-color: #E9ECEF; border: none; padding: 1.25rem;">
    <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
        <span style="background-color: #FFFFFF; padding: 6px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Bulan Ini</span>
        <span style="background-color: #FFFFFF; padding: 6px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Tahunan</span>
        <span style="background-color: #FFFFFF; padding: 6px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Pilih Rentang</span>
        
        <div style="margin-left: auto; display: flex; gap: 10px;">
            <span style="background-color: #FFFFFF; padding: 6px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Ekspor Excel</span>
            <span style="background-color: #FFFFFF; padding: 6px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Ekspor PDF</span>
        </div>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 1.5rem;">
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 120px;">
        <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); margin-bottom: 1rem;">Total Pengeluaran</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">Rp 35.000.000</div>
    </div>
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 120px;">
        <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); margin-bottom: 1rem;">Bahan Baku</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">Rp 20.000.000</div>
    </div>
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 120px;">
        <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); margin-bottom: 1rem;">Operasional & Gaji</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">Rp 15.000.000</div>
    </div>
</div>

<div class="content-card" style="background-color: #E9ECEF; border: none; min-height: 350px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
    <p style="color: var(--text-muted);">[ Detail Daftar Pengeluaran & Grafik ]</p>
</div>

@endsection
