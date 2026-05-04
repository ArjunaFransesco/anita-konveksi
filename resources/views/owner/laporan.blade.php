@extends('layouts.dashboard')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')
@section('page-subtitle', 'Rekap pemasukan, pengeluaran, dan laporan keuangan Anita Konveksi')

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@section('dashboard-content')

{{-- Laporan Card with Tabs --}}
<div class="content-card" style="margin-top: 0;">

    {{-- Tab Header --}}
    <div style="padding: 0; border-bottom: 2px solid var(--border);">
        <div style="display: flex; align-items: center; padding: 0 1.25rem;">
            <button class="laporan-tab active" id="tab-pemasukan" onclick="switchTab('pemasukan')">
                <i class="fas fa-arrow-circle-down" style="color: #28a745;"></i> Pemasukan
            </button>
            <button class="laporan-tab" id="tab-pengeluaran" onclick="switchTab('pengeluaran')">
                <i class="fas fa-arrow-circle-up" style="color: #dc3545;"></i> Pengeluaran
            </button>
            <button class="laporan-tab" id="tab-laporan" onclick="switchTab('laporan')">
                <i class="fas fa-file-alt" style="color: var(--accent);"></i> Laporan
            </button>
        </div>
    </div>

    {{-- ===== TAB: PEMASUKAN ===== --}}
    <div class="laporan-panel" id="panel-pemasukan">
        {{-- Summary Chips --}}
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; padding: 1.25rem 1.25rem 0;">
            <div class="lap-chip green">
                <div class="lap-chip-label">Total Pemasukan</div>
                <div class="lap-chip-value">Rp 85.000.000</div>
            </div>
            <div class="lap-chip blue">
                <div class="lap-chip-label">Dari DP</div>
                <div class="lap-chip-value">Rp 35.000.000</div>
            </div>
            <div class="lap-chip yellow">
                <div class="lap-chip-label">Dari Pelunasan</div>
                <div class="lap-chip-value">Rp 50.000.000</div>
            </div>
        </div>
        {{-- Filter Bar --}}
        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap; padding: 1rem 1.25rem;">
            <input type="text" class="form-input" placeholder="Bulan - Thn" style="width:130px; padding:8px 12px; border-radius:8px;">
            <select class="form-select" style="width:170px; padding:8px 12px; border-radius:8px;">
                <option>Bulanan / Tahunan</option>
            </select>
            <button class="btn btn-dark" style="padding:8px 20px; border-radius:8px;">
                <i class="fas fa-filter"></i> Filter
            </button>
            <div style="margin-left:auto; display:flex; gap:8px;">
                <button class="btn btn-outline btn-sm">Ekspor Excel</button>
                <button class="btn btn-outline btn-sm">Ekspor PDF</button>
            </div>
        </div>
        {{-- Table --}}
        <div style="overflow-x:auto; padding: 0 1.25rem 1.25rem;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Invoice</th>
                        <th>Pelanggan</th>
                        <th>Tipe</th>
                        <th>Metode</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>10 Mar 2026</td>
                        <td style="font-weight:700; color:var(--accent);">INV-2026-041</td>
                        <td>PT. Sinar Abadi</td>
                        <td><span class="badge badge-info">DP</span></td>
                        <td>Transfer</td>
                        <td style="font-weight:700; color:#15803d; text-align:right;">Rp 2.000.000</td>
                    </tr>
                    <tr>
                        <td>09 Mar 2026</td>
                        <td style="font-weight:700; color:var(--accent);">INV-2026-040</td>
                        <td>Koperasi Maju</td>
                        <td><span class="badge badge-success">Pelunasan</span></td>
                        <td>Tunai</td>
                        <td style="font-weight:700; color:#15803d; text-align:right;">Rp 4.100.000</td>
                    </tr>
                    <tr>
                        <td>08 Mar 2026</td>
                        <td style="font-weight:700; color:var(--accent);">INV-2026-039</td>
                        <td>CV. Berkah Jaya</td>
                        <td><span class="badge badge-info">DP</span></td>
                        <td>Transfer</td>
                        <td style="font-weight:700; color:#15803d; text-align:right;">Rp 1.500.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== TAB: PENGELUARAN ===== --}}
    <div class="laporan-panel" id="panel-pengeluaran" style="display:none;">
        {{-- Summary Chips --}}
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; padding: 1.25rem 1.25rem 0;">
            <div class="lap-chip red">
                <div class="lap-chip-label">Total Pengeluaran</div>
                <div class="lap-chip-value">Rp 35.000.000</div>
            </div>
            <div class="lap-chip yellow">
                <div class="lap-chip-label">Bahan Baku</div>
                <div class="lap-chip-value">Rp 20.000.000</div>
            </div>
            <div class="lap-chip purple">
                <div class="lap-chip-label">Operasional & Gaji</div>
                <div class="lap-chip-value">Rp 15.000.000</div>
            </div>
        </div>
        {{-- Filter Bar --}}
        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap; padding: 1rem 1.25rem;">
            <input type="text" class="form-input" placeholder="Bulan - Thn" style="width:130px; padding:8px 12px; border-radius:8px;">
            <select class="form-select" style="width:170px; padding:8px 12px; border-radius:8px;">
                <option>Bulanan / Tahunan</option>
            </select>
            <button class="btn btn-dark" style="padding:8px 20px; border-radius:8px;">
                <i class="fas fa-filter"></i> Filter
            </button>
            <div style="margin-left:auto; display:flex; gap:8px;">
                <button class="btn btn-outline btn-sm">Ekspor Excel</button>
                <button class="btn btn-outline btn-sm">Ekspor PDF</button>
            </div>
        </div>
        {{-- Table --}}
        <div style="overflow-x:auto; padding: 0 1.25rem 1.25rem;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Kategori</th>
                        <th>Metode</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>05 Mar 2026</td>
                        <td>Pembelian kain seragam</td>
                        <td><span class="badge badge-warning">Bahan Baku</span></td>
                        <td>Transfer</td>
                        <td style="font-weight:700; color:#be123c; text-align:right;">Rp 8.000.000</td>
                    </tr>
                    <tr>
                        <td>08 Mar 2026</td>
                        <td>Pembayaran gaji penjahit</td>
                        <td><span class="badge" style="background:#ede9fe; color:#6b21a8; border-radius:20px; padding:3px 10px;">Gaji</span></td>
                        <td>Tunai</td>
                        <td style="font-weight:700; color:#be123c; text-align:right;">Rp 3.500.000</td>
                    </tr>
                    <tr>
                        <td>10 Mar 2026</td>
                        <td>Biaya listrik & operasional</td>
                        <td><span class="badge" style="background:#fef9c3; color:#854d0e; border-radius:20px; padding:3px 10px;">Operasional</span></td>
                        <td>Tunai</td>
                        <td style="font-weight:700; color:#be123c; text-align:right;">Rp 750.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== TAB: LAPORAN ===== --}}
    <div class="laporan-panel" id="panel-laporan" style="display:none;">
        {{-- Summary Chips --}}
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; padding: 1.25rem 1.25rem 0;">
            <div class="lap-chip green">
                <div class="lap-chip-label">Total Pemasukan</div>
                <div class="lap-chip-value">Rp 85.000.000</div>
            </div>
            <div class="lap-chip red">
                <div class="lap-chip-label">Total Pengeluaran</div>
                <div class="lap-chip-value">Rp 35.000.000</div>
            </div>
            <div class="lap-chip blue">
                <div class="lap-chip-label">Laba Bersih</div>
                <div class="lap-chip-value">Rp 50.000.000</div>
            </div>
            <div class="lap-chip yellow">
                <div class="lap-chip-label">Piutang Belum Lunas</div>
                <div class="lap-chip-value">Rp 15.000.000</div>
            </div>
        </div>
        {{-- Filter & Export --}}
        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap; padding: 1rem 1.25rem;">
            <input type="text" class="form-input" placeholder="Bulan - Thn" style="width:130px; padding:8px 12px; border-radius:8px;">
            <select class="form-select" style="width:170px; padding:8px 12px; border-radius:8px;">
                <option>Bulanan / Tahunan</option>
            </select>
            <button class="btn btn-dark" style="padding:8px 20px; border-radius:8px;">
                <i class="fas fa-filter"></i> Filter
            </button>
            <div style="margin-left:auto; display:flex; gap:8px;">
                <button class="btn btn-outline btn-sm">Ekspor Excel</button>
                <button class="btn btn-outline btn-sm">Ekspor PDF</button>
            </div>
        </div>
        {{-- Table --}}
        <div style="overflow-x:auto; padding: 0 1.25rem 1.25rem;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Pemasukan</th>
                        <th>Pengeluaran</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>10 Mar 2026</td>
                        <td>DP – INV-2026-041 PT. Sinar Abadi</td>
                        <td><span class="badge badge-success">Pemasukan</span></td>
                        <td style="font-weight:700; color:#15803d; text-align:right;">Rp 2.000.000</td>
                        <td style="text-align:right; color:var(--text-muted);">—</td>
                        <td style="font-weight:700; text-align:right;">Rp 52.000.000</td>
                    </tr>
                    <tr>
                        <td>09 Mar 2026</td>
                        <td>Pembelian bahan baku kain</td>
                        <td><span class="badge badge-danger">Pengeluaran</span></td>
                        <td style="text-align:right; color:var(--text-muted);">—</td>
                        <td style="font-weight:700; color:#be123c; text-align:right;">Rp 3.500.000</td>
                        <td style="font-weight:700; text-align:right;">Rp 50.000.000</td>
                    </tr>
                    <tr>
                        <td>08 Mar 2026</td>
                        <td>Pelunasan – INV-2026-040 Koperasi Maju</td>
                        <td><span class="badge badge-success">Pemasukan</span></td>
                        <td style="font-weight:700; color:#15803d; text-align:right;">Rp 4.100.000</td>
                        <td style="text-align:right; color:var(--text-muted);">—</td>
                        <td style="font-weight:700; text-align:right;">Rp 53.500.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('styles')
<style>
/* ── Tab Buttons ── */
.laporan-tab {
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    padding: 14px 24px;
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--text-muted);
    cursor: pointer;
    transition: color 0.2s, border-color 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    white-space: nowrap;
    margin-bottom: -2px;
}
.laporan-tab:hover { color: var(--primary); }
.laporan-tab.active {
    color: var(--primary);
    border-bottom: 3px solid var(--primary);
}

/* ── Panel animation ── */
.laporan-panel { animation: fadeInPanel 0.2s ease; }
@keyframes fadeInPanel {
    from { opacity: 0; transform: translateY(5px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Summary Chips ── */
.lap-chip {
    flex: 1;
    min-width: 150px;
    border-radius: 10px;
    padding: 1rem 1.1rem;
    border: 1px solid transparent;
}
.lap-chip-label { font-size: 0.72rem; font-weight: 700; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.04em; }
.lap-chip-value { font-size: 1.3rem; font-weight: 800; }
.lap-chip.green  { background:#f0fdf4; border-color:#bbf7d0; }
.lap-chip.green  .lap-chip-label { color:#15803d; }
.lap-chip.green  .lap-chip-value { color:#15803d; }
.lap-chip.red    { background:#fff1f2; border-color:#fecdd3; }
.lap-chip.red    .lap-chip-label { color:#be123c; }
.lap-chip.red    .lap-chip-value { color:#be123c; }
.lap-chip.blue   { background:#eff6ff; border-color:#bfdbfe; }
.lap-chip.blue   .lap-chip-label { color:#1d4ed8; }
.lap-chip.blue   .lap-chip-value { color:#1d4ed8; }
.lap-chip.yellow { background:#fefce8; border-color:#fde68a; }
.lap-chip.yellow .lap-chip-label { color:#92400e; }
.lap-chip.yellow .lap-chip-value { color:#92400e; }
.lap-chip.purple { background:#faf5ff; border-color:#e9d5ff; }
.lap-chip.purple .lap-chip-label { color:#6b21a8; }
.lap-chip.purple .lap-chip-value { color:#6b21a8; }

/* ── Period chips ── */
.period-chip {
    background: #f3f4f6;
    padding: 7px 18px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    border: 2px solid transparent;
    transition: border-color 0.15s;
}
.period-chip.active-chip {
    border-color: var(--primary);
    color: var(--primary);
    background: #fff;
}
</style>
@endpush

@push('scripts')
<script>
function switchTab(tab) {
    document.querySelectorAll('.laporan-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.laporan-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('panel-' + tab).style.display = 'block';
    document.getElementById('tab-' + tab).classList.add('active');
}
</script>
@endpush
