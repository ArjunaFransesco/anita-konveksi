@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle')
Tugas Hari ini — {{ \Carbon\Carbon::now()->isoFormat("D MMMM YYYY") }}
@endsection

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')

{{-- Page Header --}}
<div class="section-header">
    <div>
        <h2>Selamat datang, {{ Auth::user()->name }}</h2>
        <p>Ringkasan operasional bisnis Anita Konveksi — {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
    </div>
</div>

{{-- Stats Cards --}}
<div class="stats-grid">
    <div class="stat-card orange">
        <span class="stat-delta delta-up">+12%</span>
        <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
        <div class="stat-value">48</div>
        <div class="stat-label">Total Pesanan Aktif</div>
    </div>
    <div class="stat-card dark">
        <span class="stat-delta delta-up">+3</span>
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-value">24</div>
        <div class="stat-label">Pegawai Aktif</div>
    </div>
    <div class="stat-card green">
        <span class="stat-delta delta-up">+8%</span>
        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-value">Rp 14,5M</div>
        <div class="stat-label">Pendapatan Bulan Ini</div>
    </div>
    <div class="stat-card blue">
        <span class="stat-delta delta-down">-2</span>
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-value">6</div>
        <div class="stat-label">Pesanan Menunggu</div>
    </div>
</div>

{{-- Bottom Two Cards --}}
<div class="cards-grid">

    {{-- Pesanan Terbaru --}}
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-clipboard-list" style="color:var(--accent); margin-right:6px;"></i> Pesanan Terbaru</h3>
            <span class="card-badge">5 terbaru</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight:600; color:var(--accent);">#ORD-001</td>
                        <td>SDN Prambon 1</td>
                        <td>Seragam Sekolah</td>
                        <td><span class="badge badge-warning">Proses</span></td>
                        <td style="font-weight:600;">Rp 2.500.000</td>
                    </tr>
                    <tr>
                        <td style="font-weight:600; color:var(--accent);">#ORD-002</td>
                        <td>PT. Maju Bersama</td>
                        <td>Seragam Kantor</td>
                        <td><span class="badge badge-info">Baru</span></td>
                        <td style="font-weight:600;">Rp 5.200.000</td>
                    </tr>
                    <tr>
                        <td style="font-weight:600; color:var(--accent);">#ORD-003</td>
                        <td>SMP Negeri 2</td>
                        <td>Jaket Angkatan</td>
                        <td><span class="badge badge-success">Selesai</span></td>
                        <td style="font-weight:600;">Rp 3.800.000</td>
                    </tr>
                    <tr>
                        <td style="font-weight:600; color:var(--accent);">#ORD-004</td>
                        <td>Komunitas Karang Taruna</td>
                        <td>Kaos Sablon</td>
                        <td><span class="badge badge-warning">Proses</span></td>
                        <td style="font-weight:600;">Rp 1.750.000</td>
                    </tr>
                    <tr>
                        <td style="font-weight:600; color:var(--accent);">#ORD-005</td>
                        <td>Dinas Pendidikan</td>
                        <td>Seragam Drumband</td>
                        <td><span class="badge badge-danger">Terlambat</span></td>
                        <td style="font-weight:600;">Rp 9.600.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Jadwal Penggajian --}}
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-money-check-alt" style="color:var(--accent); margin-right:6px;"></i> Jadwal Penggajian</h3>
            <span class="card-badge">Minggu ini</span>
        </div>
        <div class="card-body">
            <div class="payroll-item">
                <div class="pi-left">
                    <div class="pi-avatar">SR</div>
                    <div>
                        <div class="pi-name">Siti Rahayu</div>
                        <div class="pi-position">Penjahit Senior</div>
                    </div>
                </div>
                <div>
                    <div class="pi-amount">Rp 850.000</div>
                    <div style="font-size:0.72rem; color:var(--text-muted); text-align:right;">Mingguan</div>
                </div>
            </div>
            <div class="payroll-item">
                <div class="pi-left">
                    <div class="pi-avatar">BW</div>
                    <div>
                        <div class="pi-name">Budi Waluyo</div>
                        <div class="pi-position">Bagian Sablon</div>
                    </div>
                </div>
                <div>
                    <div class="pi-amount">Rp 720.000</div>
                    <div style="font-size:0.72rem; color:var(--text-muted); text-align:right;">Mingguan</div>
                </div>
            </div>
            <div class="payroll-item">
                <div class="pi-left">
                    <div class="pi-avatar">AT</div>
                    <div>
                        <div class="pi-name">Anik Triani</div>
                        <div class="pi-position">Penjahit</div>
                    </div>
                </div>
                <div>
                    <div class="pi-amount">Rp 680.000</div>
                    <div style="font-size:0.72rem; color:var(--text-muted); text-align:right;">Mingguan</div>
                </div>
            </div>
            <div class="payroll-item">
                <div class="pi-left">
                    <div class="pi-avatar">DS</div>
                    <div>
                        <div class="pi-name">Dika Santoso</div>
                        <div class="pi-position">Finishing</div>
                    </div>
                </div>
                <div>
                    <div class="pi-amount">Rp 600.000</div>
                    <div style="font-size:0.72rem; color:var(--text-muted); text-align:right;">Mingguan</div>
                </div>
            </div>
        </div>
        <div style="padding: 0.9rem 1.25rem; border-top: 1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:0.8rem; color:var(--text-muted);">Total minggu ini</span>
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="font-family:'Montserrat',sans-serif; font-weight:800; font-size:1rem; color:var(--primary);">Rp 2.850.000</span>
                <a href="#" class="btn btn-primary btn-sm">
                    <i class="fas fa-money-bill-wave"></i> Proses Penggajian
                </a>
            </div>
        </div>
    </div>

</div>

@endsection