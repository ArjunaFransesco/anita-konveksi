@extends('layouts.dashboard')

@section('title', 'Monitoring Produksi')
@section('page-title', 'Monitoring Produksi')
@section('page-subtitle')
Pantau alur produksi semua pesanan aktif
@endsection

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@section('dashboard-content')

<div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 1.5rem;">
    <button class="btn" style="background-color: #FFFFFF; border: 1px solid var(--border); color: var(--text-main); font-weight: 700;">Ekspor Excel</button>
    <button class="btn" style="background-color: #FFFFFF; border: 1px solid var(--border); color: var(--text-main); font-weight: 700;">Ekspor PDF</button>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(5, 1fr); margin-bottom: 2rem;">
    {{-- 5 boxes matching the wireframe --}}
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 80px;">
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); text-align: center;">Potong</div>
        <div style="font-size: 1.2rem; font-weight: 800; color: var(--primary); text-align: center;">12</div>
    </div>
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 80px;">
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); text-align: center;">Sablon</div>
        <div style="font-size: 1.2rem; font-weight: 800; color: var(--primary); text-align: center;">8</div>
    </div>
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 80px;">
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); text-align: center;">Bordir</div>
        <div style="font-size: 1.2rem; font-weight: 800; color: var(--primary); text-align: center;">5</div>
    </div>
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 80px;">
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); text-align: center;">Jahit</div>
        <div style="font-size: 1.2rem; font-weight: 800; color: var(--primary); text-align: center;">15</div>
    </div>
    <div class="stat-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; border-radius: var(--radius-md); min-height: 80px;">
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); text-align: center;">Packing</div>
        <div style="font-size: 1.2rem; font-weight: 800; color: var(--primary); text-align: center;">20</div>
    </div>
</div>

<div class="content-card" style="background-color: #E9ECEF; border: none; padding: 1.5rem; min-height: 400px;">
    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text-main); margin-bottom: 1.5rem; text-transform: uppercase;">DETAIL PER PESANAN</h3>
    
    <div style="background-color: #FFFFFF; border-radius: var(--radius-sm); overflow: hidden;">
        <table class="data-table" style="background: transparent; width: 100%;">
            <thead>
                <tr style="background: transparent;">
                    <th style="color: var(--text-main); font-size: 0.75rem;">NO. INVOICE</th>
                    <th style="color: var(--text-main); font-size: 0.75rem;">PELANGGAN</th>
                    <th style="color: var(--text-main); font-size: 0.75rem;">PRODUK</th>
                    <th style="color: var(--text-main); font-size: 0.75rem;">MASUK STATUS</th>
                    <th style="color: var(--text-main); font-size: 0.75rem;">DURASI</th>
                    <th style="color: var(--text-main); font-size: 0.75rem;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                {{-- Example Row --}}
                <tr style="background-color: transparent;">
                    <td style="font-weight: 700; font-size: 0.8rem;">INV-2026-005</td>
                    <td style="font-size: 0.8rem;">Sekolah Bina Insani</td>
                    <td style="font-size: 0.8rem;">Kaos Olahraga</td>
                    <td style="font-size: 0.8rem;">10 Mar 2026</td>
                    <td style="font-size: 0.8rem;">2 Hari</td>
                    <td><span class="badge badge-warning">Sablon</span></td>
                </tr>
                <tr style="background-color: transparent;">
                    <td style="font-weight: 700; font-size: 0.8rem;">INV-2026-006</td>
                    <td style="font-size: 0.8rem;">Universitas A</td>
                    <td style="font-size: 0.8rem;">Kemeja PDH</td>
                    <td style="font-size: 0.8rem;">08 Mar 2026</td>
                    <td style="font-size: 0.8rem;">4 Hari</td>
                    <td><span class="badge" style="background-color: #Cce5ff; color: #004085; padding: 4px 12px; border-radius: 20px;">Jahit</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
