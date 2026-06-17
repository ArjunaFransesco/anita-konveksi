@extends('layouts.dashboard')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')
@section('page-subtitle', 'Rekap pemasukan, pengeluaran, dan laba/rugi Anita Konveksi')

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@section('dashboard-content')

@php
    $query = request()->query();
    $exportQuery = http_build_query($query);
@endphp

<div class="content-card" style="margin-top: 0;">
    <div style="padding: 0; border-bottom: 2px solid var(--border);">
        <div style="display: flex; align-items: center; padding: 0 1.25rem; overflow-x:auto;">
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

    {{-- Filter umum --}}
    <form method="GET" action="{{ route('owner.laporan') }}" class="lap-filter">
        <select name="periode" id="periode" class="form-select" onchange="toggleFilterInputs()">
            <option value="bulanan" {{ $filter['periode'] === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
            <option value="tahunan" {{ $filter['periode'] === 'tahunan' ? 'selected' : '' }}>Tahunan</option>
            <option value="rentang" {{ $filter['periode'] === 'rentang' ? 'selected' : '' }}>Pilih Rentang</option>
        </select>
        <input type="month" name="bulan" id="input-bulan" class="form-input" value="{{ $filter['bulan'] }}">
        <input type="number" name="tahun" id="input-tahun" class="form-input" value="{{ $filter['tahun'] }}" min="2000" max="2100" style="width:120px;">
        <input type="date" name="tanggal_mulai" id="input-mulai" class="form-input" value="{{ $filter['tanggal_mulai'] }}">
        <input type="date" name="tanggal_selesai" id="input-selesai" class="form-input" value="{{ $filter['tanggal_selesai'] }}">
        <button class="btn btn-dark" type="submit"><i class="fas fa-filter"></i> Filter</button>
        <span class="filter-label">Periode: {{ $filter['label'] }}</span>
    </form>

    {{-- ===== TAB: PEMASUKAN ===== --}}
    <div class="laporan-panel" id="panel-pemasukan">
        <div class="lap-chip-wrap">
            <div class="lap-chip green">
                <div class="lap-chip-label">Total Pemasukan</div>
                <div class="lap-chip-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            </div>
            <div class="lap-chip blue">
                <div class="lap-chip-label">Dari DP</div>
                <div class="lap-chip-value">Rp {{ number_format($totalDp, 0, ',', '.') }}</div>
            </div>
            <div class="lap-chip yellow">
                <div class="lap-chip-label">Dari Pelunasan</div>
                <div class="lap-chip-value">Rp {{ number_format($totalPelunasan, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="lap-action-row">
            <a class="btn btn-outline btn-sm" href="{{ route('owner.laporan.export.excel', array_merge(request()->query(), ['jenis' => 'pemasukan'])) }}"><i class="fas fa-file-excel" style="color:#1D6F42;"></i> Ekspor Excel</a>
            <a class="btn btn-outline btn-sm" href="{{ route('owner.laporan.export.pdf', array_merge(request()->query(), ['jenis' => 'pemasukan'])) }}"><i class="fas fa-file-pdf" style="color:#dc3545;"></i> Ekspor PDF</a>
        </div>

        <div style="overflow-x:auto; padding: 0 1.25rem 1.25rem;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Invoice</th>
                        <th>Pelanggan</th>
                        <th>Tipe</th>
                        <th>Metode</th>
                        <th style="text-align:right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemasukanRows as $row)
                    <tr>
                        <td>{{ $row->tanggal_bayar->format('d M Y') }}</td>
                        <td style="font-weight:700; color:var(--accent);">{{ $row->order->invoice_number ?? '-' }}</td>
                        <td>{{ $row->order->customer->nama ?? '-' }}</td>
                        <td><span class="badge-soft {{ $row->tipe === 'dp' ? 'info' : 'success' }}">{{ $row->tipe === 'dp' ? 'DP' : 'Pelunasan' }}</span></td>
                        <td>{{ ucfirst($row->metode) }}</td>
                        <td style="font-weight:700; color:#15803d; text-align:right;">Rp {{ number_format($row->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="empty-row">Belum ada pemasukan pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== TAB: PENGELUARAN ===== --}}
    <div class="laporan-panel" id="panel-pengeluaran" style="display:none;">
        <div class="lap-chip-wrap">
            <div class="lap-chip red">
                <div class="lap-chip-label">Total Pengeluaran</div>
                <div class="lap-chip-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            </div>
            <div class="lap-chip yellow">
                <div class="lap-chip-label">Pengeluaran Operasional</div>
                <div class="lap-chip-value">Rp {{ number_format($totalPengeluaranOperasional, 0, ',', '.') }}</div>
            </div>
            <div class="lap-chip purple">
                <div class="lap-chip-label">Penggajian Dibayar</div>
                <div class="lap-chip-value">Rp {{ number_format($totalPenggajian, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="lap-action-row">
            <a class="btn btn-outline btn-sm" href="{{ route('owner.laporan.export.excel', array_merge(request()->query(), ['jenis' => 'pengeluaran'])) }}"><i class="fas fa-file-excel" style="color:#1D6F42;"></i> Ekspor Excel</a>
            <a class="btn btn-outline btn-sm" href="{{ route('owner.laporan.export.pdf', array_merge(request()->query(), ['jenis' => 'pengeluaran'])) }}"><i class="fas fa-file-pdf" style="color:#dc3545;"></i> Ekspor PDF</a>
        </div>

        <div style="overflow-x:auto; padding: 0 1.25rem 1.25rem;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Kategori</th>
                        <th>Metode</th>
                        <th>Sumber</th>
                        <th style="text-align:right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengeluaranRows as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row['tanggal'])->format('d M Y') }}</td>
                        <td>{{ $row['keterangan'] }}</td>
                        <td><span class="badge-soft danger">{{ $row['kategori'] }}</span></td>
                        <td>{{ $row['metode'] }}</td>
                        <td>{{ $row['sumber'] }}</td>
                        <td style="font-weight:700; color:#be123c; text-align:right;">Rp {{ number_format($row['jumlah'], 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="empty-row">Belum ada pengeluaran pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== TAB: LAPORAN LABA RUGI ===== --}}
    <div class="laporan-panel" id="panel-laporan" style="display:none;">
        <div class="lap-chip-wrap">
            <div class="lap-chip green">
                <div class="lap-chip-label">Total Pemasukan</div>
                <div class="lap-chip-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            </div>
            <div class="lap-chip red">
                <div class="lap-chip-label">Total Pengeluaran</div>
                <div class="lap-chip-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            </div>
            <div class="lap-chip {{ $labaRugi >= 0 ? 'blue' : 'red' }}">
                <div class="lap-chip-label">{{ $labaRugi >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}</div>
                <div class="lap-chip-value">Rp {{ number_format(abs($labaRugi), 0, ',', '.') }}</div>
            </div>
            <div class="lap-chip yellow">
                <div class="lap-chip-label">Piutang Belum Lunas</div>
                <div class="lap-chip-value">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="lap-action-row">
            <a class="btn btn-outline btn-sm" href="{{ route('owner.laporan.export.excel', array_merge(request()->query(), ['jenis' => 'laporan'])) }}"><i class="fas fa-file-excel" style="color:#1D6F42;"></i> Ekspor Excel</a>
            <a class="btn btn-outline btn-sm" href="{{ route('owner.laporan.export.pdf', array_merge(request()->query(), ['jenis' => 'laporan'])) }}"><i class="fas fa-file-pdf" style="color:#dc3545;"></i> Ekspor PDF</a>
        </div>

        <div class="lap-summary-grid">
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Komponen</th>
                            <th style="text-align:right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanRingkas as $row)
                        <tr>
                            <td style="font-weight:600;">{{ $row['komponen'] }}</td>
                            <td style="text-align:right; font-weight:800; color:{{ $row['tipe'] === 'minus' ? '#be123c' : ($row['tipe'] === 'plus' ? '#15803d' : 'var(--text-main)') }};">
                                Rp {{ number_format(abs($row['jumlah']), 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="kategori-card">
                <h4><i class="fas fa-chart-pie"></i> Pengeluaran per Kategori</h4>
                @forelse($kategoriPengeluaran as $kategori => $jumlah)
                    <div class="kategori-row">
                        <span>{{ $kategori }}</span>
                        <strong>Rp {{ number_format($jumlah, 0, ',', '.') }}</strong>
                    </div>
                @empty
                    <p style="color:var(--text-muted); margin-top:.75rem;">Belum ada data kategori pengeluaran.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.laporan-tab {
    background: none;
    border: none;
    padding: 1rem 1.25rem;
    cursor: pointer;
    font-weight: 700;
    color: var(--text-muted);
    border-bottom: 3px solid transparent;
    transition: var(--transition);
    white-space: nowrap;
}
.laporan-tab:hover { color: var(--primary); }
.laporan-tab.active {
    color: var(--primary);
    border-bottom-color: var(--accent);
}
.lap-filter {
    display:flex;
    gap:10px;
    align-items:center;
    flex-wrap:wrap;
    padding: 1rem 1.25rem;
    border-bottom:1px solid var(--border);
}
.lap-filter .form-input, .lap-filter .form-select {
    padding:8px 12px;
    border-radius:8px;
    border:1px solid var(--border);
    background:#fff;
}
.filter-label { color:var(--text-muted); font-size:.85rem; font-weight:600; }
.lap-chip-wrap {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1.25rem 1.25rem 0;
}
.lap-chip {
    flex: 1;
    min-width: 190px;
    border: 1px solid;
    border-radius: var(--radius-md);
    padding: 1rem;
}
.lap-chip-label { font-size: 0.72rem; font-weight: 700; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.04em; }
.lap-chip-value { font-size: 1.3rem; font-weight: 800; }
.lap-chip.green  { background:#f0fdf4; border-color:#bbf7d0; }
.lap-chip.green  .lap-chip-label, .lap-chip.green .lap-chip-value { color:#15803d; }
.lap-chip.red    { background:#fff1f2; border-color:#fecdd3; }
.lap-chip.red    .lap-chip-label, .lap-chip.red .lap-chip-value { color:#be123c; }
.lap-chip.blue   { background:#eff6ff; border-color:#bfdbfe; }
.lap-chip.blue   .lap-chip-label, .lap-chip.blue .lap-chip-value { color:#1d4ed8; }
.lap-chip.yellow { background:#fefce8; border-color:#fde68a; }
.lap-chip.yellow .lap-chip-label, .lap-chip.yellow .lap-chip-value { color:#92400e; }
.lap-chip.purple { background:#faf5ff; border-color:#e9d5ff; }
.lap-chip.purple .lap-chip-label, .lap-chip.purple .lap-chip-value { color:#6b21a8; }
.lap-action-row {
    display:flex;
    justify-content:flex-end;
    gap:8px;
    padding: 1rem 1.25rem;
}
.badge-soft {
    display:inline-block;
    border-radius:20px;
    padding:3px 10px;
    font-size:.75rem;
    font-weight:700;
}
.badge-soft.info { background:#dbeafe; color:#1d4ed8; }
.badge-soft.success { background:#dcfce7; color:#15803d; }
.badge-soft.danger { background:#fee2e2; color:#be123c; }
.empty-row { text-align:center; color:var(--text-muted); padding:2rem !important; }
.lap-summary-grid {
    display:grid;
    grid-template-columns: 1.2fr .8fr;
    gap:1rem;
    padding: 0 1.25rem 1.25rem;
}
.kategori-card {
    border:1px solid var(--border);
    border-radius:var(--radius-md);
    padding:1rem;
    background:#fff;
}
.kategori-card h4 { margin-bottom:.75rem; font-size:1rem; }
.kategori-card h4 i { color:var(--accent); margin-right:6px; }
.kategori-row {
    display:flex;
    justify-content:space-between;
    gap:10px;
    padding:.65rem 0;
    border-bottom:1px solid var(--border);
    font-size:.9rem;
}
.kategori-row:last-child { border-bottom:none; }
@media (max-width: 900px) {
    .lap-summary-grid { grid-template-columns:1fr; }
}
</style>
@endpush

@push('scripts')
<script>
function switchTab(tab) {
    document.querySelectorAll('.laporan-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.laporan-panel').forEach(p => p.style.display = 'none');
    document.getElementById('tab-' + tab).classList.add('active');
    document.getElementById('panel-' + tab).style.display = 'block';
    localStorage.setItem('owner_laporan_tab', tab);
}

function toggleFilterInputs() {
    const periode = document.getElementById('periode').value;
    document.getElementById('input-bulan').style.display = periode === 'bulanan' ? 'block' : 'none';
    document.getElementById('input-tahun').style.display = periode === 'tahunan' ? 'block' : 'none';
    document.getElementById('input-mulai').style.display = periode === 'rentang' ? 'block' : 'none';
    document.getElementById('input-selesai').style.display = periode === 'rentang' ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    toggleFilterInputs();
    const savedTab = localStorage.getItem('owner_laporan_tab') || 'pemasukan';
    if (document.getElementById('tab-' + savedTab)) switchTab(savedTab);
});
</script>
@endpush
