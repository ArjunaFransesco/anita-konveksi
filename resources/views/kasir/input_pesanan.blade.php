@extends('layouts.dashboard')

@section('title', 'Input Pesanan')
@section('page-title', 'Input Pesanan')
@section('page-subtitle', 'Form input pesanan')

@section('sidebar-menu')
    @include('kasir.sidebar')
@endsection

@push('styles')
<style>
    /* ── Two-panel layout sesuai wireframe ── */
    .pesanan-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        align-items: start;
    }
    @media (max-width: 900px) { .pesanan-grid { grid-template-columns: 1fr; } }

    /* Panel card */
    .panel-card {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .panel-header {
        padding: 0.9rem 1.25rem;
        border-bottom: 1px solid var(--border);
        background: #F8F9FA;
    }
    .panel-header h3 {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.92rem;
        font-weight: 800;
        color: var(--primary);
    }
    .panel-body { padding: 1.25rem; }

    /* Field rows — mirip wireframe: label + input penuh */
    .field-row { margin-bottom: 0.85rem; }
    .field-row label {
        display: block;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }
    .field-row .form-input,
    .field-row .form-select {
        width: 100%;
        padding: 9px 12px;
        font-size: 0.85rem;
    }
    .field-row textarea.form-input {
        resize: vertical;
        min-height: 72px;
    }

    /* Tampilan subtotal per item */
    .item-subtotal {
        text-align: right;
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-top: 3px;
    }
    .item-subtotal strong { color: var(--primary); }

    /* Divider antar row produk */
    .item-divider {
        border: none;
        border-top: 1px dashed var(--border);
        margin: 0.75rem 0;
    }

    /* Tombol tambah item */
    .btn-add-item {
        width: 100%;
        background: transparent;
        border: 1.5px dashed var(--border);
        border-radius: var(--radius-sm);
        padding: 8px;
        color: var(--text-muted);
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        font-family: 'Inter', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-bottom: 1rem;
    }
    .btn-add-item:hover {
        border-color: var(--accent);
        color: var(--accent-dark);
        background: var(--accent-light);
    }

    /* Total bar di atas tombol aksi */
    .total-strip {
        background: #F8F9FA;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border);
        padding: 0.75rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.85rem;
    }
    .total-strip .ts-label { color: var(--text-muted); font-weight: 600; }
    .total-strip .ts-value {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        color: var(--primary);
        font-size: 1.05rem;
    }
    .total-strip .ts-sisa { color: #dc3545; }

    /* Action row di bawah panel kanan — Simpan | Batal */
    .action-row {
        display: flex;
        gap: 10px;
        justify-content: flex-start;
        padding-top: 0.25rem;
    }
    .btn-simpan {
        background: #0d6efd;
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        padding: 9px 28px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        font-family: 'Inter', sans-serif;
    }
    .btn-simpan:hover { background: #0b5ed7; }
    .btn-batal {
        background: #dc3545;
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        padding: 9px 22px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: var(--transition);
        font-family: 'Inter', sans-serif;
    }
    .btn-batal:hover { background: #bb2d3b; color:#fff; }

    /* Remove-row button */
    .btn-remove {
        background: rgba(220,53,69,0.1);
        border: none;
        color: #dc3545;
        border-radius: 4px;
        padding: 3px 8px;
        font-size: 0.75rem;
        cursor: pointer;
        float: right;
        margin-top: -2px;
    }
    .btn-remove:hover { background: rgba(220,53,69,0.2); }
</style>
@endpush

@section('dashboard-content')

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
@endif

<form action="{{ route('kasir.pesanan.store') }}" method="POST" id="formPesanan">
@csrf

<div class="pesanan-grid">

    {{-- ── KIRI: Pelanggan ── --}}
    <div class="panel-card">
        <div class="panel-header"><h3>Pelanggan</h3></div>
        <div class="panel-body">

            <div class="field-row">
                <label>Nama Pelanggan <span style="color:#dc3545">*</span></label>
                <input type="text" name="nama" class="form-input"
                       value="{{ old('nama') }}" placeholder="Nama lengkap pelanggan" required>
            </div>

            <div class="field-row">
                <label>No. Telepon / WhatsApp</label>
                <input type="text" name="no_hp" class="form-input"
                       value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
            </div>

            <div class="field-row">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-input"
                       value="{{ old('alamat') }}" placeholder="Alamat pelanggan">
            </div>

            <div class="field-row" style="margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                <label>Deadline / Tanggal Ambil</label>
                <input type="date" name="deadline" class="form-input" value="{{ old('deadline') }}">
            </div>

            <div class="field-row">
                <label>DP Awal (Rp)</label>
                <input type="number" name="dp" id="dpInput" class="form-input"
                       value="{{ old('dp', 0) }}" min="0" placeholder="0">
            </div>

            <div class="field-row">
                <label>Metode DP</label>
                <select name="metode_dp" class="form-select">
                    <option value="tunai">Tunai</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>

        </div>
    </div>

    {{-- ── KANAN: Detail Pesanan ── --}}
    <div class="panel-card">
        <div class="panel-header">
            <h3>Detail Pesanan</h3>
        </div>
        <div class="panel-body">

            {{-- Kontainer item produk --}}
            <div id="itemContainer">

                {{-- Item 1 (default) --}}
                <div class="item-row" data-idx="0">
                    <div class="field-row">
                        <label>Jenis Produk <span style="color:#dc3545">*</span></label>
                        <input type="text" name="jenis_produk[]" class="form-input"
                               placeholder="Kaos, Kemeja, Jaket..." required>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                        <div class="field-row">
                            <label>Jumlah (Qty) <span style="color:#dc3545">*</span></label>
                            <input type="number" name="jumlah[]" class="form-input qty-input"
                                   placeholder="0" min="1" required>
                        </div>
                        <div class="field-row">
                            <label>Harga Satuan (Rp) <span style="color:#dc3545">*</span></label>
                            <input type="number" name="harga_satuan[]" class="form-input price-input"
                                   placeholder="0" min="0" required>
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                        <div class="field-row">
                            <label>Ukuran / Size</label>
                            <input type="text" name="ukuran[]" class="form-input" placeholder="S, M, L, XL">
                        </div>
                        <div class="field-row">
                            <label>Bahan</label>
                            <input type="text" name="bahan[]" class="form-input" placeholder="Cotton Combed 30s">
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                        <div class="field-row">
                            <label>Warna</label>
                            <input type="text" name="warna[]" class="form-input" placeholder="Hitam, Putih...">
                        </div>
                        <div class="field-row">
                            <label>Desain / Sablon</label>
                            <input type="text" name="desain[]" class="form-input" placeholder="Logo dada kiri...">
                        </div>
                    </div>
                    <div class="item-subtotal">Subtotal: <strong class="subtotal-display">Rp 0</strong></div>
                </div>

            </div>

            {{-- Tombol tambah item --}}
            <button type="button" class="btn-add-item" onclick="addItem()">
                <i class="fas fa-plus"></i> Tambah Jenis Produk
            </button>

            {{-- Total strip --}}
            <div class="total-strip">
                <span class="ts-label">Total Harga</span>
                <span class="ts-value" id="displayTotal">Rp 0</span>
            </div>
            <div class="total-strip" style="margin-bottom:1.25rem;">
                <span class="ts-label">Sisa Tagihan</span>
                <span class="ts-value ts-sisa" id="displaySisa">Rp 0</span>
            </div>

            {{-- Simpan & Batal --}}
            <div class="action-row">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a href="{{ route('kasir.dashboard') }}" class="btn-batal">Batal</a>
            </div>

        </div>
    </div>

</div>
</form>

@endsection

@push('scripts')
<script>
let itemCount = 1;

function formatRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function recalc() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const qty   = parseFloat(row.querySelector('.qty-input').value)   || 0;
        const harga = parseFloat(row.querySelector('.price-input').value)  || 0;
        const sub   = qty * harga;
        total += sub;
        row.querySelector('.subtotal-display').textContent = formatRp(sub);
    });
    const dp   = parseFloat(document.getElementById('dpInput').value) || 0;
    document.getElementById('displayTotal').textContent = formatRp(total);
    document.getElementById('displaySisa').textContent  = formatRp(Math.max(0, total - dp));
}

function addItem() {
    const orig = document.querySelector('.item-row[data-idx="0"]');
    const clone = orig.cloneNode(true);
    clone.setAttribute('data-idx', itemCount);

    // Kosongkan nilai
    clone.querySelectorAll('input').forEach(el => el.value = '');
    clone.querySelector('.subtotal-display').textContent = 'Rp 0';

    // Tambah tombol remove
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn-remove';
    removeBtn.innerHTML = '<i class="fas fa-times"></i> Hapus';
    removeBtn.onclick = function () {
        this.closest('.item-row').remove();
        recalc();
    };

    // Sisipkan divider + remove button
    const divider = document.createElement('hr');
    divider.className = 'item-divider';
    const container = document.getElementById('itemContainer');
    container.appendChild(divider);

    clone.querySelector('.field-row').insertBefore(removeBtn, clone.querySelector('.field-row label'));
    container.appendChild(clone);
    itemCount++;
}

document.getElementById('formPesanan').addEventListener('input', recalc);
</script>
@endpush
