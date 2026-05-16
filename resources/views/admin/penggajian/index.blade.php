@extends('layouts.dashboard')

@section('title', 'Kelola Penggajian')
@section('page-title', 'Kelola Penggajian')
@section('page-subtitle', 'Manajemen penggajian seluruh pegawai Anita Konveksi')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')

<div class="section-header">
    <div>
        <h2><i class="fas fa-money-bill-wave" style="color:var(--accent); margin-right:8px;"></i>Kelola Penggajian</h2>
        <p>24 Pegawai aktif — manajemen penggajian mingguan & bulanan</p>
    </div>
    <a href="#" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Penggajian
    </a>
</div>

{{-- Summary cards --}}
<div class="stats-grid" style="grid-template-columns: repeat(3,1fr); margin-bottom:1.25rem;">
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-value">24</div>
        <div class="stat-label">Total Pegawai</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-calendar-week"></i></div>
        <div class="stat-value">Rp 12,4M</div>
        <div class="stat-label">Penggajian Bulan Ini</div>
    </div>
    <div class="stat-card dark">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-value">8</div>
        <div class="stat-label">Belum Diproses</div>
    </div>
</div>

<div class="content-card">
    <div class="filter-bar">
        <select class="form-select" id="filter-minggu">
            <option value="">Minggu ke-</option>
            <option value="1">Minggu ke-1</option>
            <option value="2">Minggu ke-2</option>
            <option value="3">Minggu ke-3</option>
            <option value="4">Minggu ke-4</option>
        </select>
        <select class="form-select" id="filter-tipe">
            <option value="">Semua Tipe</option>
            <option value="harian">Harian</option>
            <option value="mingguan">Mingguan</option>
            <option value="bulanan">Bulanan</option>
        </select>
        <button class="btn btn-dark"><i class="fas fa-filter"></i> Filter</button>
        <button class="btn btn-primary" style="margin-left:auto;">
            <i class="fas fa-money-bill-wave"></i> Proses Penggajian
        </button>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>Posisi</th>
                    <th>Tipe Gaji</th>
                    <th>Minggu</th>
                    <th>Hari Kerja</th>
                    <th>Rate</th>
                    <th>Total Gaji</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="color:var(--text-muted); font-size:0.8rem;">1</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:32px; height:32px; background:var(--accent-light); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.8rem; font-weight:700; color:var(--accent-dark); flex-shrink:0;">SR</div>
                            <span style="font-weight:600;">Siti Rahayu</span>
                        </div>
                    </td>
                    <td>Penjahit Senior</td>
                    <td><span class="badge badge-info">Mingguan</span></td>
                    <td>Minggu ke-1</td>
                    <td>6 hari</td>
                    <td>Rp 150.000/hari</td>
                    <td style="font-weight:700; color:var(--primary);">Rp 900.000</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td>
                        <div class="action-group">
                            <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Proses</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted); font-size:0.8rem;">2</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:32px; height:32px; background:var(--accent-light); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.8rem; font-weight:700; color:var(--accent-dark); flex-shrink:0;">BW</div>
                            <span style="font-weight:600;">Budi Waluyo</span>
                        </div>
                    </td>
                    <td>Bagian Sablon</td>
                    <td><span class="badge badge-info">Mingguan</span></td>
                    <td>Minggu ke-1</td>
                    <td>6 hari</td>
                    <td>Rp 130.000/hari</td>
                    <td style="font-weight:700; color:var(--primary);">Rp 780.000</td>
                    <td><span class="badge badge-success">Dibayar</span></td>
                    <td>
                        <div class="action-group">
                            <a href="#" class="btn btn-outline btn-sm"><i class="fas fa-print"></i> Cetak</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted); font-size:0.8rem;">3</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:32px; height:32px; background:var(--accent-light); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.8rem; font-weight:700; color:var(--accent-dark); flex-shrink:0;">AT</div>
                            <span style="font-weight:600;">Anik Triani</span>
                        </div>
                    </td>
                    <td>Penjahit</td>
                    <td><span class="badge badge-info">Mingguan</span></td>
                    <td>Minggu ke-1</td>
                    <td>5 hari</td>
                    <td>Rp 120.000/hari</td>
                    <td style="font-weight:700; color:var(--primary);">Rp 600.000</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td>
                        <div class="action-group">
                            <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Proses</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted); font-size:0.8rem;">4</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:32px; height:32px; background:var(--accent-light); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.8rem; font-weight:700; color:var(--accent-dark); flex-shrink:0;">DS</div>
                            <span style="font-weight:600;">Dika Santoso</span>
                        </div>
                    </td>
                    <td>Finishing</td>
                    <td><span class="badge badge-dark">Harian</span></td>
                    <td>Minggu ke-1</td>
                    <td>6 hari</td>
                    <td>Rp 100.000/hari</td>
                    <td style="font-weight:700; color:var(--primary);">Rp 600.000</td>
                    <td><span class="badge badge-success">Dibayar</span></td>
                    <td>
                        <div class="action-group">
                            <a href="#" class="btn btn-outline btn-sm"><i class="fas fa-print"></i> Cetak</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted); font-size:0.8rem;">5</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:32px; height:32px; background:var(--accent-light); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.8rem; font-weight:700; color:var(--accent-dark); flex-shrink:0;">RL</div>
                            <span style="font-weight:600;">Rini Lestari</span>
                        </div>
                    </td>
                    <td>Bordir</td>
                    <td><span class="badge badge-info">Mingguan</span></td>
                    <td>Minggu ke-1</td>
                    <td>6 hari</td>
                    <td>Rp 125.000/hari</td>
                    <td style="font-weight:700; color:var(--primary);">Rp 750.000</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td>
                        <div class="action-group">
                            <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Proses</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
