@extends('layouts.dashboard')

@section('title', 'Pengeluaran')
@section('page-title', 'Modul Pengeluaran')
@section('page-subtitle', 'Pencatatan transaksi pengeluaran operasional')

@section('sidebar-menu')
    @include('owner.sidebar')
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
    .peng-layout > div { min-width: 0; }
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
    @media (max-width: 768px) {
        .field-grid-2 { grid-template-columns: 1fr; gap: 0; }
    }

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
            <form action="{{ route('owner.pengeluaran.store') }}" method="POST" id="formPengeluaran" enctype="multipart/form-data">
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

            <div class="field-group">
                <label>Foto Nota / Struk (Opsional)</label>
                <div id="fotoNotaContainer"></div>
                <button type="button" onclick="addNotaInput()" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.8rem; margin-bottom: 8px; background: #e2e8f0; color: #1e293b; border: none; border-radius: 4px; cursor: pointer;"><i class="fas fa-plus"></i> Tambah Foto</button>
                <small style="color:var(--text-muted); font-size:0.72rem; display:block;">Pilih Kamera untuk foto langsung, atau Galeri untuk memilih file. Format: JPG, PNG.</small>
                <script>
                function addNotaInput() {
                    const container = document.getElementById('fotoNotaContainer');
                    const wrapper = document.createElement('div');
                    wrapper.style.display = 'flex';
                    wrapper.style.gap = '8px';
                    wrapper.style.alignItems = 'center';
                    wrapper.style.marginBottom = '8px';
                    
                    const input = document.createElement('input');
                    input.type = 'file';
                    input.name = 'foto_nota[]';
                    input.accept = 'image/*';
                    input.style.display = 'none';
                    
                    const fileName = document.createElement('span');
                    fileName.style.fontSize = '0.75rem';
                    fileName.style.color = 'var(--text-muted)';
                    fileName.style.flex = '1';
                    fileName.style.whiteSpace = 'nowrap';
                    fileName.style.overflow = 'hidden';
                    fileName.style.textOverflow = 'ellipsis';
                    fileName.innerText = 'Belum ada file';
                    
                    input.onchange = function() {
                        if(this.files && this.files[0]) {
                            fileName.innerText = this.files[0].name;
                            fileName.style.color = 'var(--text-dark)';
                            fileName.style.fontWeight = '600';
                        } else {
                            fileName.innerText = 'Belum ada file';
                            fileName.style.color = 'var(--text-muted)';
                            fileName.style.fontWeight = 'normal';
                        }
                    };
                    
                    const camBtn = document.createElement('button');
                    camBtn.type = 'button';
                    camBtn.className = 'btn btn-outline';
                    camBtn.style.padding = '4px 8px';
                    camBtn.style.fontSize = '0.75rem';
                    camBtn.innerHTML = '<i class="fas fa-camera"></i> Kamera';
                    camBtn.onclick = function() {
                        if (typeof openWebcam === 'function') {
                            openWebcam(input);
                        } else {
                            input.setAttribute('capture', 'environment');
                            input.click();
                        }
                    };
                    
                    const galBtn = document.createElement('button');
                    galBtn.type = 'button';
                    galBtn.className = 'btn btn-outline';
                    galBtn.style.padding = '4px 8px';
                    galBtn.style.fontSize = '0.75rem';
                    galBtn.innerHTML = '<i class="fas fa-image"></i> Galeri';
                    galBtn.onclick = function() {
                        input.removeAttribute('capture');
                        input.click();
                    };
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.style.background = 'rgba(220,53,69,0.1)';
                    removeBtn.style.border = 'none';
                    removeBtn.style.color = '#dc3545';
                    removeBtn.style.borderRadius = '4px';
                    removeBtn.style.padding = '6px 10px';
                    removeBtn.style.cursor = 'pointer';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.onclick = function() { wrapper.remove(); };
                    
                    wrapper.appendChild(camBtn);
                    wrapper.appendChild(galBtn);
                    wrapper.appendChild(fileName);
                    wrapper.appendChild(input);
                    wrapper.appendChild(removeBtn);
                    container.appendChild(wrapper);
                }
                document.addEventListener('DOMContentLoaded', function() {
                    addNotaInput();
                });
                </script>
                <div id="previewFotoNota" style="margin-top:6px; display:none;">
                    <img id="previewImg" src="" alt="Preview Nota"
                         style="max-width:100%; max-height:160px; border-radius:6px; border:1px solid var(--border);">
                </div>
                <small style="color:var(--text-muted); font-size:0.7rem;">Maks. 4MB (JPG/PNG/PDF)</small>
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
            <form method="GET" action="{{ route('owner.pengeluaran.index') }}" class="filter-bar">
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
                <a href="{{ route('owner.pengeluaran.export.excel', ['bulan' => $bulan, 'tipe' => $tipe]) }}"
                   class="btn btn-outline btn-sm">
                    <i class="fas fa-file-excel" style="color:#1D6F42;"></i> Ekspor Excel
                </a>
                <a href="{{ route('owner.pengeluaran.export.pdf', ['bulan' => $bulan, 'tipe' => $tipe]) }}"
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
                            <th style="width:60px;">Nota</th>
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
                            <td style="text-align:center;">
                                @if(!empty($p->foto_nota_array))
                                    @if(count($p->foto_nota_array) > 1)
                                        <button type="button" onclick='bukaNotaModal(@json(array_map(function($n) { return asset("storage/".$n); }, $p->foto_nota_array)))' 
                                                title="Lihat {{ count($p->foto_nota_array) }} Nota" 
                                                style="background:none; border:none; color:var(--accent); font-size:1.1rem; cursor:pointer;">
                                            <i class="fas fa-images"></i>
                                            <span style="font-size:0.7rem; font-weight:bold;">{{ count($p->foto_nota_array) }}</span>
                                        </button>
                                    @else
                                        <a href="{{ asset('storage/' . $p->foto_nota_array[0]) }}" target="_blank"
                                           title="Lihat Nota" style="color:var(--accent); font-size:1.1rem;">
                                            <i class="fas fa-file-image"></i>
                                        </a>
                                    @endif
                                @else
                                    <span style="color:var(--border);">-</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('owner.pengeluaran.destroy', $p->id) }}" method="POST"
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
                            <td colspan="4"></td>
                        </tr>
                    </tfoot>
                </table>
                @endif
            </div>
        </div>

        {{-- Modal Nota Gallery --}}
        <div id="notaGalleryOverlay" class="nota-modal-overlay" style="display:none;">
            <div class="nota-modal">
                <div class="nota-modal-header">
                    <span>Daftar Foto Nota</span>
                    <button type="button" onclick="tutupNotaModal()" class="btn-close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="nota-modal-body" id="notaGalleryBody">
                    <!-- Images will be injected here -->
                </div>
            </div>
        </div>

        <style>
            .nota-modal-overlay {
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.6);
                z-index: 9999;
                display: flex;
                justify-content: center;
                align-items: center;
                backdrop-filter: blur(4px);
            }
            .nota-modal {
                background: #fff;
                border-radius: var(--radius-md);
                width: 600px;
                max-width: 90vw;
                max-height: 90vh;
                display: flex;
                flex-direction: column;
                overflow: hidden;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            }
            .nota-modal-header {
                background: var(--primary);
                color: #fff;
                padding: 12px 16px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-weight: 700;
            }
            .btn-close-modal {
                background: none; border: none; color: #fff; cursor: pointer; font-size: 1.1rem;
            }
            .nota-modal-body {
                padding: 16px;
                overflow-y: auto;
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 12px;
            }
            .nota-gallery-item {
                width: 100%;
                aspect-ratio: 1;
                object-fit: cover;
                border-radius: 8px;
                border: 1px solid var(--border);
                cursor: pointer;
                transition: transform 0.2s;
            }
            .nota-gallery-item:hover {
                transform: scale(1.05);
            }
        </style>

    </div>
</div>

@push('scripts')
<script>
function bukaNotaModal(fotos) {
    const body = document.getElementById('notaGalleryBody');
    body.innerHTML = '';
    fotos.forEach(url => {
        const a = document.createElement('a');
        a.href = url;
        a.target = '_blank';
        a.title = 'Klik untuk memperbesar';
        const img = document.createElement('img');
        img.src = url;
        img.className = 'nota-gallery-item';
        a.appendChild(img);
        body.appendChild(a);
    });
    document.getElementById('notaGalleryOverlay').style.display = 'flex';
}

function tutupNotaModal() {
    document.getElementById('notaGalleryOverlay').style.display = 'none';
}

document.getElementById('inputFotoNota')?.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewFotoNota').style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('previewFotoNota').style.display = 'none';
    }
});
</script>
@endpush

@endsection
