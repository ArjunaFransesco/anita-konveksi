@extends('layouts.dashboard')

@section('title', 'Pengeluaran')
@section('page-title', 'Modul Pengeluaran')
@section('page-subtitle', 'Pencatatan transaksi pengeluaran operasional')

@section('sidebar-menu')
    @include('kasir.sidebar')
@endsection

@push('styles')
<style>
    /* ── Layout ───────────────────────────────────────── */
    .peng-layout {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 1.25rem;
        align-items: start;
    }
    @media (max-width: 960px) { .peng-layout { grid-template-columns: 1fr; } }

    /* ── Form Card ────────────────────────────────────── */
    .peng-form-card {
        background: #fff;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        overflow: hidden;
        position: sticky;
        top: 1rem;
    }
    .peng-card-header {
        background: var(--primary);
        color: #fff;
        padding: 0.85rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 0.88rem;
        letter-spacing: 0.04em;
    }
    .peng-card-header i { color: var(--accent); }
    .peng-card-body { padding: 1.25rem; }

    .field-group { display: flex; flex-direction: column; gap: 4px; margin-bottom: 1rem; }
    .field-group label {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .field-group .form-input,
    .field-group .form-select,
    .field-group textarea {
        width: 100%;
        padding: 9px 12px;
        font-size: 0.85rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: 'Inter', sans-serif;
        background: #fff;
        color: var(--text-main);
        transition: border-color 0.2s;
    }
    .field-group .form-input:focus,
    .field-group .form-select:focus,
    .field-group textarea:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(255,159,28,0.1);
    }
    .field-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

    /* ── Tipe Badge ───────────────────────────────────── */
    .tipe-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .tipe-bahan_baku  { background: rgba(0,123,255,0.1);   color: #0056b3; }
    .tipe-gaji        { background: rgba(40,167,69,0.12);  color: #1a7a38; }
    .tipe-operasional { background: rgba(255,159,28,0.15); color: #cc7a00; }
    .tipe-listrik_air { background: rgba(111,66,193,0.12); color: #5a2f9e; }
    .tipe-lain_lain   { background: rgba(108,117,125,0.12);color: #495057; }

    .metode-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .metode-tunai    { background: #e9ecef; color: #495057; }
    .metode-transfer { background: rgba(13,202,240,0.12); color: #087990; }

    /* ── Filter bar ───────────────────────────────────── */
    .filter-bar {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: flex-end;
        margin-bottom: 1.1rem;
    }
    .filter-bar .field-group { margin-bottom: 0; }
    .filter-bar select,
    .filter-bar input[type=month] {
        padding: 8px 12px;
        font-size: 0.83rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        background: #fff;
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
    }

    /* ── Summary Card ─────────────────────────────────── */
    .total-card {
        background: var(--primary);
        color: #fff;
        border-radius: var(--radius-md);
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.1rem;
        box-shadow: var(--shadow-md);
    }
    .total-card .tc-label { font-size: 0.82rem; opacity: 0.8; }
    .total-card .tc-value {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        font-size: 1.35rem;
        color: var(--accent);
    }
    .total-card .tc-icon { font-size: 2rem; opacity: 0.2; }

    /* ── Action btn row ───────────────────────────────── */
    .action-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.9rem;
        flex-wrap: wrap;
        gap: 8px;
    }
    .export-group { display: flex; gap: 8px; }

    /* ── Hapus confirm ────────────────────────────────── */
    .btn-delete {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: var(--radius-sm);
        transition: background 0.2s;
        font-size: 0.85rem;
    }
    .btn-delete:hover { background: rgba(220,53,69,0.1); }
</style>
@endpush

@section('dashboard-content')

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
@endif

<div class="peng-layout">

    {{-- ── KIRI: Form Input ─────────────────────────────────────────── --}}
    <div class="peng-form-card">
        <div class="peng-card-header">
            <i class="fas fa-plus-circle"></i> Catat Pengeluaran Baru
        </div>
        <div class="peng-card-body">
            <form action="{{ route('kasir.pengeluaran.store') }}" method="POST" id="formPengeluaran">
            @csrf

            <div class="field-grid-2">
                <div class="field-group">
                    <label>Tanggal <span style="color:#dc3545">*</span></label>
                    <input type="date" name="tanggal" class="form-input"
                           value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
                <div class="field-group">
                    <label>Metode <span style="color:#dc3545">*</span></label>
                    <select name="metode" class="form-select" required>
                        <option value="tunai"    {{ old('metode') === 'tunai'    ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ old('metode') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>
            </div>

            <div class="field-group">
                <label>Tipe Pengeluaran <span style="color:#dc3545">*</span></label>
                <select name="tipe" class="form-select" required>
                    <option value="">-- Pilih Tipe --</option>
                    @foreach($tipeLabels as $key => $label)
                        <option value="{{ $key }}" {{ old('tipe') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field-group">
                <label>Keterangan <span style="color:#dc3545">*</span></label>
                <input type="text" name="keterangan" class="form-input"
                       placeholder="Cth: Beli kain 5 meter, Gaji penjahit..." 
                       value="{{ old('keterangan') }}" required>
            </div>

            <div class="field-group">
                <label>Jumlah (Rp) <span style="color:#dc3545">*</span></label>
                <input type="number" name="jumlah" class="form-input"
                       placeholder="0" min="1" value="{{ old('jumlah') }}" required>
            </div>

            <div class="field-group">
                <label>Catatan (Opsional)</label>
                <textarea name="catatan" class="form-input" rows="2"
                          placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
            </div>

            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <button type="reset" class="btn btn-outline">
                    <i class="fas fa-undo"></i> Reset
                </button>
            </div>

            </form>
        </div>
    </div>

    {{-- ── KANAN: Tabel & Filter ────────────────────────────────────── --}}
    <div>

        {{-- Total Summary --}}
        <div class="total-card">
            <div>
                <div class="tc-label">Total Pengeluaran — {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->isoFormat('MMMM YYYY') }}</div>
                <div class="tc-value">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</div>
            </div>
            <i class="fas fa-chart-pie tc-icon"></i>
        </div>

        {{-- Filter + Ekspor --}}
        <div class="action-row">
            <form method="GET" action="{{ route('kasir.pengeluaran.index') }}" class="filter-bar">
                <div class="field-group">
                    <label style="font-size:0.7rem; font-weight:700; color:var(--text-muted); text-transform:uppercase;">Bulan</label>
                    <input type="month" name="bulan" value="{{ $bulan }}">
                </div>
                <div class="field-group">
                    <label style="font-size:0.7rem; font-weight:700; color:var(--text-muted); text-transform:uppercase;">Tipe</label>
                    <select name="tipe">
                        <option value="">Semua Tipe</option>
                        @foreach($tipeLabels as $key => $label)
                            <option value="{{ $key }}" {{ $tipe === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>

            <div class="export-group">
                <a href="{{ route('kasir.pengeluaran.export.excel', ['bulan' => $bulan, 'tipe' => $tipe]) }}"
                   class="btn btn-outline btn-sm">
                    <i class="fas fa-file-excel" style="color:#1D6F42;"></i> Ekspor Excel
                </a>
                <a href="{{ route('kasir.pengeluaran.export.pdf', ['bulan' => $bulan, 'tipe' => $tipe]) }}"
                   class="btn btn-outline btn-sm">
                    <i class="fas fa-file-pdf" style="color:#dc3545;"></i> Ekspor PDF
                </a>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="content-card">
            <div style="overflow-x:auto;">
                @if($pengeluarans->isEmpty())
                    <div style="padding:3rem; text-align:center; color:var(--text-muted);">
                        <i class="fas fa-inbox" style="font-size:2.5rem; opacity:0.3; display:block; margin-bottom:0.75rem;"></i>
                        Belum ada data pengeluaran untuk periode ini.
                    </div>
                @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Catatan</th>
                            <th style="width:60px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengeluarans as $i => $p)
                        <tr>
                            <td style="color:var(--text-muted); font-size:0.78rem;">{{ $i + 1 }}</td>
                            <td>{{ $p->tanggal->format('d M Y') }}</td>
                            <td>
                                <span class="tipe-badge tipe-{{ $p->tipe }}">{{ $p->tipe_label }}</span>
                            </td>
                            <td style="max-width:220px;">{{ $p->keterangan }}</td>
                            <td style="font-weight:700; color:var(--primary);">
                                Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="metode-badge metode-{{ $p->metode }}">{{ ucfirst($p->metode) }}</span>
                            </td>
                            <td style="font-size:0.78rem; color:var(--text-muted);">
                                {{ $p->catatan ?? '-' }}
                            </td>
                            <td>
                                <form action="{{ route('kasir.pengeluaran.destroy', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus data pengeluaran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background:#f8f9fa;">
                            <td colspan="4" style="font-weight:700; text-align:right; padding:10px 12px; font-size:0.85rem;">
                                Total
                            </td>
                            <td style="font-weight:800; color:var(--primary); font-family:'Montserrat',sans-serif; padding:10px 12px;">
                                Rp {{ number_format($totalBulanIni, 0, ',', '.') }}
                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection
