@extends('layouts.dashboard')

@section('title', 'Laporan Pemasukan')
@section('page-title', 'Laporan Pemasukan')
@section('page-subtitle')
Rekap pemasukan dari DP dan Pelunasan
@endsection

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@section('dashboard-content')

{{-- Filter & Action Bar --}}
<div class="content-card" style="margin-bottom: 1.5rem; background-color: #E9ECEF; border: none; padding: 1.25rem;">
    <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
        <input type="text" class="form-input" style="padding: 10px 15px; border-radius: 8px; width: 140px; border: 1px solid #CED4DA; text-align: center;" placeholder="Bulan - Thn">
        <select class="form-select" style="padding: 10px 15px; border-radius: 8px; width: 180px; border: 1px solid #CED4DA; text-align: center;">
            <option>Bulanan / Tahunan</option>
        </select>
        <button class="btn" style="background-color: #ADB5BD; color: var(--text-main); font-weight: 700; padding: 10px 2rem;">Filter</button>
        <div style="margin-left: auto; display: flex; gap: 10px;">
            <button class="btn" style="background-color: #FFFFFF; border: 1px solid var(--border); color: var(--text-main); font-weight: 700; padding: 10px 2rem;">Ekspor Excel</button>
            <button class="btn" style="background-color: #FFFFFF; border: 1px solid var(--border); color: var(--text-main); font-weight: 700; padding: 10px 2rem;">Ekspor PDF</button>
        </div>
    </div>
</div>

{{-- Summary Cards --}}
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 1.5rem;">
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 120px;">
        <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); margin-bottom: 1rem;">Total Pemasukan</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">Rp 85.000.000</div>
    </div>
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 120px;">
        <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); margin-bottom: 1rem;">Dari DP</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">Rp 35.000.000</div>
    </div>
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 120px;">
        <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); margin-bottom: 1rem;">Dari Pelunasan</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">Rp 50.000.000</div>
    </div>
</div>

{{-- Table --}}
<div class="content-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md);">
    <div style="background-color: #FFFFFF; padding: 20px; border-radius: var(--radius-sm);">
        <table class="data-table" style="background: transparent;">
            <thead>
                <tr style="background: transparent;">
                    <th style="color: var(--text-main); font-size: 0.75rem;">TANGGAL</th>
                    <th style="color: var(--text-main); font-size: 0.75rem;">NO. INVOICE</th>
                    <th style="color: var(--text-main); font-size: 0.75rem;">PELANGGAN</th>
                    <th style="color: var(--text-main); font-size: 0.75rem;">TIPE</th>
                    <th style="color: var(--text-main); font-size: 0.75rem;">METODE</th>
                    <th style="color: var(--text-main); font-size: 0.75rem;">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-size: 0.8rem; font-weight: 500;">10 Mar 2026</td>
                    <td style="font-size: 0.8rem; font-weight: 500;">INV-2026-041</td>
                    <td style="font-size: 0.8rem; font-weight: 500;">PT. Sinar Abadi</td>
                    <td><span class="badge" style="background-color: #Cce5ff; color: #004085; padding: 4px 12px;">DP</span></td>
                    <td style="font-size: 0.8rem; font-weight: 500;">Transfer</td>
                    <td style="font-size: 0.8rem; font-weight: 600; text-align: right;">Rp 2.000.000</td>
                </tr>
                <tr>
                    <td style="font-size: 0.8rem; font-weight: 500;">09 Mar 2026</td>
                    <td style="font-size: 0.8rem; font-weight: 500;">INV-2026-040</td>
                    <td style="font-size: 0.8rem; font-weight: 500;">Koperasi Maju</td>
                    <td><span class="badge" style="background-color: #d4edda; color: #155724; padding: 4px 12px; border-radius: 20px;">Pelunasan</span></td>
                    <td style="font-size: 0.8rem; font-weight: 500;">Tunai</td>
                    <td style="font-size: 0.8rem; font-weight: 600; text-align: right;">Rp 4.100.000</td>
                </tr>
                <tr>
                    <td style="font-size: 0.8rem; font-weight: 500;">08 Mar 2026</td>
                    <td style="font-size: 0.8rem; font-weight: 500;">INV-2026-039</td>
                    <td style="font-size: 0.8rem; font-weight: 500;">CV. Berkah Jaya</td>
                    <td><span class="badge" style="background-color: #Cce5ff; color: #004085; padding: 4px 12px;">DP</span></td>
                    <td style="font-size: 0.8rem; font-weight: 500;">Transfer</td>
                    <td style="font-size: 0.8rem; font-weight: 600; text-align: right;">Rp 1.500.000</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
