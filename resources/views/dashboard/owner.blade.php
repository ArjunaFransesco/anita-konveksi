@extends('layouts.dashboard')

@section('title', 'Dashboard Owner')
@section('page-title', 'Dashboard Owner')
@section('sidebar-menu')
    <li class="{{ request()->routeIs('dashboard.owner') ? 'active' : '' }}"><a href="{{ route('dashboard.owner') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
    <li><a href="#"><i class="fas fa-exchange-alt"></i> <span>Transaksi</span></a></li>
    <li><a href="#"><i class="fas fa-chart-line"></i> <span>Laporan Pemasukan</span></a></li>
    <li><a href="#"><i class="fas fa-chart-line"></i> <span>Laporan Pengeluaran</span></a></li>
    <li><a href="#"><i class="fas fa-file-invoice-dollar"></i> <span>Piutang</span></a></li>
    <li><a href="#"><i class="fas fa-industry"></i> <span>Monitoring Produksi</span></a></li>
@endsection
@section('dashboard-content')
    <h3>Selamat datang, Owner {{ Auth::user()->name }}</h3>
    <p>Halaman ini menampilkan ringkasan data toko.</p>
    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1rem; margin-top:1rem;">
        <div style="background:#f8f9fa; padding:1rem; border-radius:8px;">📊 Total Transaksi: Rp 124.500.000</div>
        <div style="background:#f8f9fa; padding:1rem; border-radius:8px;">👥 Piutang: Rp 12.000.000</div>
        <div style="background:#f8f9fa; padding:1rem; border-radius:8px;">🏭 Produksi: 5 pesanan aktif</div>
    </div>
@endsection