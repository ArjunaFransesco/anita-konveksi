@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')
    <h3>Halo, Admin {{ Auth::user()->name }}</h3>
    <p>Kelola pesanan, pegawai, penggajian, dan user.</p>
    <div style="background:#e9ecef; padding:1rem; border-radius:8px; margin-top:1rem;">📋 Ada 12 pesanan baru hari ini.</div>
@endsection