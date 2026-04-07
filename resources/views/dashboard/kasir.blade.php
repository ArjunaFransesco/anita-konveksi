@extends('layouts.dashboard')

@section('title', 'Dashboard Kasir')
@section('page-title', 'Dashboard Kasir')
@section('sidebar-menu')
    <li class="{{ request()->routeIs('dashboard.kasir') ? 'active' : '' }}"><a href="{{ route('dashboard.kasir') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
    <li><a href="#"><i class="fas fa-clipboard-list"></i> <span>Input Pesanan</span></a></li>
    <li><a href="#"><i class="fas fa-sync-alt"></i> <span>Update Status</span></a></li>
    <li><a href="#"><i class="fas fa-credit-card"></i> <span>Catat Pembayaran</span></a></li>
@endsection
@section('dashboard-content')
    <h3>Selamat datang, Kasir {{ Auth::user()->name }}</h3>
    <p>Input pesanan baru, update status pesanan, dan catat pembayaran.</p>
    <div style="background:#e9ecef; padding:1rem; border-radius:8px; margin-top:1rem;">💰 Transaksi hari ini: Rp 3.250.000</div>
@endsection