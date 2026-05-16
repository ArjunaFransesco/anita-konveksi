@extends('layouts.dashboard')

@section('title', 'Daftar Transaksi')
@section('page-title', 'Daftar Transaksi')
@section('page-subtitle')
Pantau semua transaksi pesanan
@endsection

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@section('dashboard-content')

<div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 20px;">
    <button class="btn" style="background-color: #FFFFFF; border: 1px solid var(--border); color: var(--text-main); font-weight: 700;">Ekspor Excel</button>
    <button class="btn" style="background-color: #FFFFFF; border: 1px solid var(--border); color: var(--text-main); font-weight: 700;">Ekspor PDF</button>
</div>

<div class="content-card" style="margin-bottom: 2rem; background-color: #E9ECEF; border: none; padding: 1rem;">
    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
        <input type="text" class="form-input" style="flex: 1; min-width: 200px; padding: 10px; border-radius: 20px;" placeholder="Cari Pelanggan">
        <select class="form-select" style="min-width: 150px; padding: 10px; border-radius: 20px;">
            <option>Semua Status</option>
            <option>Baru</option>
            <option>Proses</option>
            <option>Selesai</option>
        </select>
        <select class="form-select" style="min-width: 180px; padding: 10px; border-radius: 20px;">
            <option>Semua Pembayaran</option>
            <option>Lunas</option>
            <option>Belum Lunas</option>
        </select>
    </div>
</div>

<div class="content-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; min-height: 400px; display: flex; flex-direction: column;">
    <div style="background-color: #FFFFFF; padding: 15px; border-bottom: 2px solid #E9ECEF; border-radius: var(--radius-sm) var(--radius-sm) 0 0;">
        <table class="data-table" style="background: transparent;">
            <thead>
                <tr style="background: transparent;">
                    <th style="color: var(--text-main); font-size: 0.75rem; letter-spacing: 0;">NO. INVOICE</th>
                    <th style="color: var(--text-main); font-size: 0.75rem; letter-spacing: 0;">PELANGGAN</th>
                    <th style="color: var(--text-main); font-size: 0.75rem; letter-spacing: 0;">TOTAL</th>
                    <th style="color: var(--text-main); font-size: 0.75rem; letter-spacing: 0;">DP</th>
                    <th style="color: var(--text-main); font-size: 0.75rem; letter-spacing: 0;">SISA</th>
                    <th style="color: var(--text-main); font-size: 0.75rem; letter-spacing: 0;">STATUS PRODUKSI</th>
                    <th style="color: var(--text-main); font-size: 0.75rem; letter-spacing: 0;">PEMBAYARAN</th>
                    <th style="color: var(--text-main); font-size: 0.75rem; letter-spacing: 0;">DEADLINE</th>
                </tr>
            </thead>
            <tbody>
                {{-- Example row --}}
                <tr style="background-color: transparent;">
                    <td style="font-weight: 700; font-size: 0.8rem;">INV-2026-001</td>
                    <td style="font-size: 0.8rem;">PT Indomaju</td>
                    <td style="font-size: 0.8rem;">Rp 5.000.000</td>
                    <td style="font-size: 0.8rem;">Rp 2.000.000</td>
                    <td style="font-size: 0.8rem;">Rp 3.000.000</td>
                    <td><span class="badge badge-warning">Proses</span></td>
                    <td><span class="badge badge-warning">DP</span></td>
                    <td style="font-size: 0.8rem;">15 Apr 2026</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="flex: 1; background-color: #E9ECEF; border-radius: 0 0 var(--radius-sm) var(--radius-sm);"></div>
</div>

@endsection
