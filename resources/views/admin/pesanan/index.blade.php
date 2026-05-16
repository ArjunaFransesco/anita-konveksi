@extends('layouts.dashboard')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', 'Lihat semua detail pesanan pelanggan Anita Konveksi')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')

<div class="section-header">
    <div>
        <h2><i class="fas fa-shopping-cart" style="color:var(--accent); margin-right:8px;"></i>Detail Pesanan</h2>
        <p>Detail semua pesanan pelanggan Anita Konveksi</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="content-card">
    <div class="filter-bar">
        <select class="form-select" id="filter-status">
            <option value="">Semua Status</option>
            <option value="baru">Baru</option>
            <option value="proses">Dalam Proses</option>
            <option value="selesai">Selesai</option>
            <option value="terlambat">Terlambat</option>
        </select>
        <input type="text" class="form-input" placeholder="Cari pesanan / pelanggan..." style="min-width:220px;" id="search-pesanan">
        <button class="btn btn-dark" onclick="filterTable()"><i class="fas fa-search"></i> Cari</button>
        <span style="margin-left:auto; font-size:0.8rem; color:var(--text-muted);">Menampilkan semua pesanan</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table" id="pesanan-table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Tanggal Pesan</th>
                    <th>Tenggat</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight:700; color:var(--accent);">#ORD-001</td>
                    <td>SDN Prambon 1</td>
                    <td>Seragam Sekolah</td>
                    <td>120 pcs</td>
                    <td>01 Apr 2026</td>
                    <td>15 Apr 2026</td>
                    <td style="font-weight:600;">Rp 2.500.000</td>
                    <td><span class="badge badge-warning">Proses</span></td>
                </tr>
                <tr>
                    <td style="font-weight:700; color:var(--accent);">#ORD-002</td>
                    <td>PT. Maju Bersama</td>
                    <td>Seragam Kantor</td>
                    <td>85 pcs</td>
                    <td>02 Apr 2026</td>
                    <td>20 Apr 2026</td>
                    <td style="font-weight:600;">Rp 5.200.000</td>
                    <td><span class="badge badge-info">Baru</span></td>
                </tr>
                <tr>
                    <td style="font-weight:700; color:var(--accent);">#ORD-003</td>
                    <td>SMP Negeri 2 Nganjuk</td>
                    <td>Jaket Angkatan</td>
                    <td>200 pcs</td>
                    <td>25 Mar 2026</td>
                    <td>10 Apr 2026</td>
                    <td style="font-weight:600;">Rp 3.800.000</td>
                    <td><span class="badge badge-success">Selesai</span></td>
                </tr>
                <tr>
                    <td style="font-weight:700; color:var(--accent);">#ORD-004</td>
                    <td>Karang Taruna Prambon</td>
                    <td>Kaos Sablon</td>
                    <td>50 pcs</td>
                    <td>03 Apr 2026</td>
                    <td>18 Apr 2026</td>
                    <td style="font-weight:600;">Rp 1.750.000</td>
                    <td><span class="badge badge-warning">Proses</span></td>
                </tr>
                <tr>
                    <td style="font-weight:700; color:var(--accent);">#ORD-005</td>
                    <td>Dinas Pendidikan Nganjuk</td>
                    <td>Seragam Drumband</td>
                    <td>60 set</td>
                    <td>20 Mar 2026</td>
                    <td>05 Apr 2026</td>
                    <td style="font-weight:600;">Rp 9.600.000</td>
                    <td><span class="badge badge-danger">Terlambat</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
function filterTable() {
    const search = document.getElementById('search-pesanan').value.toLowerCase();
    const status = document.getElementById('filter-status').value.toLowerCase();
    const rows = document.querySelectorAll('#pesanan-table tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const matchSearch = !search || text.includes(search);
        const matchStatus = !status || text.includes(status);
        row.style.display = (matchSearch && matchStatus) ? '' : 'none';
    });
}
document.getElementById('search-pesanan').addEventListener('keyup', filterTable);
document.getElementById('filter-status').addEventListener('change', filterTable);
</script>
@endpush
