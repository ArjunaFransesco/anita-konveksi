@extends('layouts.dashboard')

@section('title', 'Input Pesanan')
@section('page-title', 'Input Pesanan')
@section('page-subtitle', 'Form input pesanan')

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@push('styles')
<style>
    .field-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
    @media (max-width: 768px) { .field-grid-2 { grid-template-columns: 1fr; gap: 0; } }
    
    .pesanan-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        align-items: start;
    }
    .pesanan-grid > div { min-width: 0; }
    @media (max-width: 900px) { .pesanan-grid { grid-template-columns: 1fr; } }

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

    .item-subtotal {
        text-align: right;
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-top: 3px;
    }
    .item-subtotal strong { color: var(--primary); }

    .item-divider {
        border: none;
        border-top: 1px dashed var(--border);
        margin: 0.75rem 0;
    }

    .btn-add-item, .btn-clone-item {
        background: transparent;
        border: 1.5px dashed var(--border);
        border-radius: var(--radius-sm);
        padding: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        font-family: 'Inter', sans-serif;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-add-item {
        width: 100%;
        margin-bottom: 1rem;
        color: var(--text-muted);
    }
    .btn-add-item:hover, .btn-clone-item:hover {
        border-color: var(--accent);
        color: var(--accent-dark);
        background: var(--accent-light);
    }
    .btn-clone-item {
        width: auto;
        padding: 4px 12px;
        margin-left: 8px;
        font-size: 0.7rem;
    }

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
    }
    .btn-batal:hover { background: #bb2d3b; color:#fff; }

    .btn-remove {
        background: rgba(220,53,69,0.1);
        border: none;
        color: #dc3545;
        border-radius: 4px;
        padding: 3px 8px;
        font-size: 0.75rem;
        cursor: pointer;
        margin-right: 6px;
    }
    .btn-remove:hover { background: rgba(220,53,69,0.2); }

    .size-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .size-group select, .size-group input {
        flex: 1;
    }
    .diskon-badge {
        background: #d1ecf1;
        color: #0c5460;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: bold;
        margin-left: 10px;
    }
    .payment-option {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
    }
    .payment-option label {
        font-weight: normal;
        text-transform: none;
        font-size: 0.85rem;
    }
    .item-actions {
        display: flex;
        justify-content: flex-end;
        gap: 5px;
        margin-bottom: 8px;
    }

    .logo-section {
        background: #F8F9FA;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 0.85rem;
        margin-bottom: 0.85rem;
    }
    .logo-section-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 0.65rem;
    }
    .logo-section-title label { margin-bottom: 0; }
    .logo-entry {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 0.75rem;
        margin-bottom: 0.65rem;
    }
    .logo-entry:last-child { margin-bottom: 0; }
    .logo-entry-grid {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 0.75rem;
        align-items: end;
    }
    .btn-add-logo {
        background: transparent;
        border: 1.5px dashed var(--border);
        border-radius: var(--radius-sm);
        color: var(--text-muted);
        font-size: 0.76rem;
        font-weight: 700;
        padding: 6px 10px;
        cursor: pointer;
        transition: var(--transition);
    }
    .btn-add-logo:hover {
        border-color: var(--accent);
        background: var(--accent-light);
        color: var(--accent-dark);
    }
    .btn-remove-logo {
        background: rgba(220,53,69,0.1);
        border: none;
        color: #dc3545;
        border-radius: 4px;
        padding: 8px 10px;
        font-size: 0.75rem;
        cursor: pointer;
    }
    .btn-remove-logo:hover { background: rgba(220,53,69,0.2); }
    @media (max-width: 900px) {
        .logo-entry-grid { grid-template-columns: 1fr; }
        .btn-remove-logo { width: 100%; }
    }

</style>
@endpush

@section('dashboard-content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<form action="{{ route('owner.pesanan.store') }}" method="POST" id="formPesanan" enctype="multipart/form-data">
@csrf

<div class="pesanan-grid">

    {{-- KIRI: Pelanggan --}}
    <div class="panel-card">
        <div class="panel-header"><h3>Pelanggan</h3></div>
        <div class="panel-body">
            <div class="field-row">
                <label>Nama Pelanggan <span style="color:#dc3545">*</span></label>
                <input type="text" name="nama" class="form-input" value="{{ old('nama') }}" placeholder="Contoh: Ahmad Fauzi" required>
            </div>
            <div class="field-row">
                <label>No. Telepon / WhatsApp</label>
                <input type="text" name="no_hp" class="form-input" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
            </div>
            <div class="field-row">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-input" value="{{ old('alamat') }}" placeholder="Jl. Raya No. 123, RT/RW ...">
            </div>
            <div class="field-row">
                <label>Deadline / Tanggal Ambil</label>
                <input type="date" name="deadline" class="form-input" value="{{ old('deadline') }}">
            </div>

            {{-- Opsi Pembayaran: Lunas atau DP --}}
            <div class="field-row">
                <label>Metode Pembayaran</label>
                <div class="payment-option">
                    <label><input type="radio" name="tipe_pembayaran" value="lunas" id="radioLunas" class="payment-radio"> Lunas Langsung</label>
                    <label><input type="radio" name="tipe_pembayaran" value="dp" id="radioDP" class="payment-radio" checked> DP (Down Payment)</label>
                </div>
            </div>

            <div id="dpContainer">
                <div class="field-row">
                    <label>DP Awal (Rp)</label>
                    <input type="number" name="dp" id="dpInput" class="form-input" value="{{ old('dp', 0) }}" min="0" placeholder="Contoh: 500000">
                </div>
                <div class="field-row">
                    <label>Metode DP / Lunas</label>
                    <select name="metode_dp" class="form-select">
                        <option value="tunai">Tunai</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>
                <div class="field-row">
                    <label>Bukti Pembayaran (Opsional)</label>
                    <div id="buktiPembayaranContainer"></div>
                    <button type="button" onclick="addBuktiInput()" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.8rem; margin-bottom: 8px; background: #e2e8f0; color: #1e293b; border: none; border-radius: 4px; cursor: pointer;"><i class="fas fa-plus"></i> Tambah Foto</button>
                    <small style="color:var(--text-muted); font-size:0.72rem; display:block;">Pilih Kamera untuk foto langsung, atau Galeri untuk memilih file. Format: JPG, PNG.</small>
                </div>
                <script>
                function addBuktiInput() {
                    const container = document.getElementById('buktiPembayaranContainer');
                    const wrapper = document.createElement('div');
                    wrapper.style.display = 'flex';
                    wrapper.style.gap = '8px';
                    wrapper.style.alignItems = 'center';
                    wrapper.style.marginBottom = '8px';
                    
                    const input = document.createElement('input');
                    input.type = 'file';
                    input.name = 'bukti_pembayaran[]';
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
                    addBuktiInput();
                });
                </script>
            </div>
        </div>
    </div>

    {{-- KANAN: Detail Pesanan --}}
    <div class="panel-card">
        <div class="panel-header"><h3>Detail Pesanan</h3></div>
        <div class="panel-body">
            <div id="itemContainer">
                <div class="item-row" data-idx="0">
                    <div class="item-actions">
                        <button type="button" class="btn-remove" onclick="removeItem(this)" style="display:none;">Hapus</button>
                        <button type="button" class="btn-clone-item" onclick="cloneItem(this)"><i class="fas fa-copy"></i> Clone</button>
                    </div>
                    <div class="field-row">
                        <label>Jenis Produk <span style="color:#dc3545">*</span></label>
                        <input type="text" name="jenis_produk[]" class="form-input" placeholder="Contoh: Kaos, Kemeja, Jaket" required>
                    </div>
                    <div class="field-grid-2">
                        <div class="field-row">
                            <label>Jumlah (Qty) <span style="color:#dc3545">*</span></label>
                            <input type="number" name="jumlah[]" class="form-input qty-input" min="1" placeholder="Minimal 1" required>
                        </div>
                        <div class="field-row">
                            <label>Harga Satuan (Rp) <span style="color:#dc3545">*</span></label>
                            <input type="number" name="harga_satuan[]" class="form-input price-input" min="0" placeholder="Harga per pcs" required>
                        </div>
                    </div>
                    <div class="field-row">
                        <label>Ukuran</label>
                        <div class="size-group">
                            <select name="size_id[]" class="form-select size-select">
                                <option value="">-- Pilih Ukuran Standar --</option>
                                @foreach(\App\Models\Size::all() as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                @endforeach
                                <option value="custom">Custom...</option>
                            </select>
                            <input type="text" name="size_custom[]" class="form-input size-custom" placeholder="Ukuran custom (contoh: XXL Panjang)" style="display:none;">
                        </div>
                    </div>
                    <div class="field-grid-2">
                        <div class="field-row">
                            <label>Bahan</label>
                            <input type="text" name="bahan[]" class="form-input" placeholder="Contoh: Cotton 30s, Carded">
                        </div>
                        <div class="field-row">
                            <label>Warna</label>
                            <input type="text" name="warna[]" class="form-input" placeholder="Hitam, Putih, Merah">
                        </div>
                    </div>
                    <div class="logo-section">
                        <div class="logo-section-title">
                            <label>Logo & Keterangan Desain/Sablon</label>
                            <button type="button" class="btn-add-logo" onclick="addLogo(this)"><i class="fas fa-plus"></i> Tambah Logo</button>
                        </div>
                        <div class="logo-list">
                            <div class="logo-entry">
                                <div class="logo-entry-grid">
                                    <div class="field-row" style="margin-bottom:0;">
                                        <label>Keterangan Desain / Sablon</label>
                                        <input type="text" name="desain_detail[0][]" class="form-input" placeholder="Contoh: Logo dada kiri, sablon belakang">
                                    </div>
                                    <div class="field-row" style="margin-bottom:0;">
                                        <label>Upload Logo (jpg/png)</label>
                                        <input type="file" name="logo[0][]" class="form-input" accept="image/jpeg,image/png">
                                    </div>
                                    <button type="button" class="btn-remove-logo" onclick="removeLogo(this)" style="display:none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item-subtotal">Subtotal: <strong class="subtotal-display">Rp 0</strong></div>
                </div>
            </div>

            <div style="display: flex; gap: 10px; margin-bottom: 1rem;">
                <button type="button" class="btn-add-item" onclick="addNewItem()" style="flex:1;">
                    <i class="fas fa-plus"></i> Tambah Produk Baru (Kosong)
                </button>
                <button type="button" class="btn-add-item" onclick="cloneFromExisting()" style="flex:1;">
                    <i class="fas fa-copy"></i> Tambah dari Produk Sebelumnya
                </button>
            </div>

            <div class="field-row" style="margin-bottom: 1rem; background: #f0fdf4; padding: 10px; border-radius: 6px; border: 1px dashed #22c55e;">
                <label style="color: #15803d;">Diskon Manual (Opsional)</label>
                <div class="size-group">
                    <select name="diskon_jenis" id="diskonJenis" class="form-select" style="max-width: 150px;">
                        <option value="persen">Persen (%)</option>
                        <option value="nominal">Nominal (Rp)</option>
                    </select>
                    <input type="number" name="diskon_value" id="diskonValue" class="form-input" min="0" step="any" placeholder="Nilai diskon">
                </div>
            </div>

            <div class="total-strip">
                <span class="ts-label">Total Harga <span id="diskonInfo" class="diskon-badge" style="display:none;">Diskon 5%</span></span>
                <span class="ts-value" id="displayTotal">Rp 0</span>
            </div>
            <div class="total-strip">
                <span class="ts-label">Sisa Tagihan</span>
                <span class="ts-value ts-sisa" id="displaySisa">Rp 0</span>
            </div>

            <div class="action-row">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a href="{{ route('owner.dashboard') }}" class="btn-batal">Batal</a>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script>
let itemCount = document.querySelectorAll('.item-row').length;
window.manualDiskonMode = false;

function formatRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function buildLogoEntry(productIndex) {
    const div = document.createElement('div');
    div.className = 'logo-entry';
    div.innerHTML = `
        <div class="logo-entry-grid">
            <div class="field-row" style="margin-bottom:0;">
                <label>Keterangan Desain / Sablon</label>
                <input type="text" name="desain_detail[${productIndex}][]" class="form-input" placeholder="Contoh: Logo dada kiri, sablon belakang">
            </div>
            <div class="field-row" style="margin-bottom:0;">
                <label>Upload Logo (jpg/png)</label>
                <input type="file" name="logo[${productIndex}][]" class="form-input" accept="image/jpeg,image/png">
            </div>
            <button type="button" class="btn-remove-logo" onclick="removeLogo(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>`;
    return div;
}

function updateLogoRemoveButtons(row) {
    const entries = row.querySelectorAll('.logo-entry');
    entries.forEach((entry, idx) => {
        const btn = entry.querySelector('.btn-remove-logo');
        if (btn) btn.style.display = entries.length > 1 ? 'inline-block' : 'none';
    });
}

function addLogo(btn) {
    const row = btn.closest('.item-row');
    const list = row.querySelector('.logo-list');
    const idx = row.getAttribute('data-idx') || 0;
    list.appendChild(buildLogoEntry(idx));
    reindexItemRows();
}

function removeLogo(btn) {
    const row = btn.closest('.item-row');
    const entries = row.querySelectorAll('.logo-entry');
    if (entries.length <= 1) {
        alert('Minimal harus ada satu form logo/desain untuk produk ini.');
        return;
    }
    btn.closest('.logo-entry').remove();
    updateLogoRemoveButtons(row);
    reindexItemRows();
}

function resetLogoList(row) {
    const list = row.querySelector('.logo-list');
    if (!list) return;
    const idx = row.getAttribute('data-idx') || 0;
    list.innerHTML = '';
    list.appendChild(buildLogoEntry(idx));
    updateLogoRemoveButtons(row);
}

function reindexItemRows() {
    document.querySelectorAll('.item-row').forEach((row, idx) => {
        row.setAttribute('data-idx', idx);
        row.querySelectorAll('.logo-entry').forEach(entry => {
            const ket = entry.querySelector('input[type="text"]');
            const file = entry.querySelector('input[type="file"]');
            if (ket) ket.name = `desain_detail[${idx}][]`;
            if (file) file.name = `logo[${idx}][]`;
        });
        updateLogoRemoveButtons(row);
    });
}

function recalc() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        let qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        let harga = parseFloat(row.querySelector('.price-input').value) || 0;
        let sub = qty * harga;
        total += sub;
        row.querySelector('.subtotal-display').textContent = formatRp(sub);
    });

    let diskonJenis = document.getElementById('diskonJenis').value;
    let diskonValueInput = document.getElementById('diskonValue');
    let diskonValue = parseFloat(diskonValueInput.value) || 0;

    let diskonPersen = 0;
    let diskonNominal = 0;

    // Diskon 5% jika total qty seluruh item > 10 (hanya trigger jika input kosong)
    let totalQty = 0;
    document.querySelectorAll('.qty-input').forEach(inp => {
        totalQty += parseFloat(inp.value) || 0;
    });

    if (!window.manualDiskonMode) {
        if (totalQty > 10) {
            diskonValueInput.value = 5;
            document.getElementById('diskonJenis').value = 'persen';
            diskonJenis = 'persen';
            diskonValue = 5;
        } else {
            diskonValueInput.value = '';
            diskonValue = 0;
        }
    }

    if (diskonValue > 0) {
        if (diskonJenis === 'nominal') {
            diskonNominal = diskonValue;
            if (total > 0) diskonPersen = (diskonNominal / total) * 100;
        } else {
            diskonPersen = diskonValue;
            diskonNominal = total * (diskonPersen / 100);
        }
    }

    if (diskonNominal > total) {
        diskonNominal = total;
    }

    let totalSetelahDiskon = total - diskonNominal;

    let diskonInfo = document.getElementById('diskonInfo');
    if (diskonNominal > 0) {
        diskonInfo.style.display = 'inline-block';
        if (diskonJenis === 'nominal') {
            diskonInfo.innerText = 'Diskon ' + formatRp(diskonNominal);
        } else {
            diskonInfo.innerText = 'Diskon ' + parseFloat(diskonPersen.toFixed(2)) + '%';
        }
    } else {
        diskonInfo.style.display = 'none';
    }

    document.getElementById('displayTotal').textContent = formatRp(totalSetelahDiskon);

    // Hitung sisa tagihan berdasarkan DP
    let pembayaranType = document.querySelector('input[name="tipe_pembayaran"]:checked').value;
    let dp = 0;
    if (pembayaranType === 'dp') {
        dp = parseFloat(document.getElementById('dpInput').value) || 0;
    } else {
        dp = totalSetelahDiskon;
    }
    let sisa = Math.max(0, totalSetelahDiskon - dp);
    document.getElementById('displaySisa').textContent = formatRp(sisa);
}

// Track manual discount mode
document.getElementById('diskonValue').addEventListener('input', function() {
    window.manualDiskonMode = true;
});
document.getElementById('diskonJenis').addEventListener('change', function() {
    window.manualDiskonMode = true;
});

// Fungsi untuk membuat clone dari row tertentu (untuk clone item)
function cloneRow(sourceRow) {
    const clone = sourceRow.cloneNode(true);
    const newIdx = itemCount++;
    clone.setAttribute('data-idx', newIdx);
    
    // Kosongkan nilai input yang perlu diisi ulang oleh user (kecuali clone ingin semua nilai sama? kita pertahankan semua nilai termasuk qty, tapi user bisa ubah)
    // Biarkan semua nilai tetap (karena clone dari existing product biasanya ingin menduplikasi sifat product, qty bisa diubah)
    // Tapi reset file input (logo)
    clone.querySelectorAll('input[type="file"]').forEach(fileInput => fileInput.value = '');
    
    // Reset subtotal
    clone.querySelector('.subtotal-display').textContent = 'Rp 0';
    
    // Sembunyikan size custom jika tidak custom
    const sizeSelect = clone.querySelector('.size-select');
    const customInput = clone.querySelector('.size-custom');
    if (sizeSelect && customInput && sizeSelect.value !== 'custom') {
        customInput.style.display = 'none';
        customInput.value = '';
    }
    
    // Tambahkan tombol remove (tampilkan jika belum ada)
    let removeBtn = clone.querySelector('.btn-remove');
    if (!removeBtn) {
        const actionsDiv = clone.querySelector('.item-actions');
        if (actionsDiv) {
            removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn-remove';
            removeBtn.innerHTML = '<i class="fas fa-times"></i> Hapus';
            removeBtn.onclick = function() { removeItem(this); };
            actionsDiv.insertBefore(removeBtn, actionsDiv.firstChild);
        }
    } else {
        removeBtn.style.display = 'inline-block';
    }
    
    const container = document.getElementById('itemContainer');
    const divider = document.createElement('hr');
    divider.className = 'item-divider';
    container.appendChild(divider);
    container.appendChild(clone);
    
    // Re-attach event listeners untuk size select pada clone
    attachSizeEvent(clone);
    reindexItemRows();
    
    // Recalc total
    recalc();
}

// Fungsi untuk menambah item kosong
function addNewItem() {
    const firstRow = document.querySelector('.item-row');
    const clone = firstRow.cloneNode(true);
    const newIdx = itemCount++;
    clone.setAttribute('data-idx', newIdx);
    
    // Reset semua nilai input (kosong)
    clone.querySelectorAll('input, select').forEach(el => {
        if (el.type !== 'file') {
            if (el.tagName === 'SELECT') el.selectedIndex = 0;
            else el.value = '';
        } else {
            el.value = '';
        }
    });
    clone.querySelector('.subtotal-display').textContent = 'Rp 0';
    
    // Reset size custom
    const customInput = clone.querySelector('.size-custom');
    if (customInput) customInput.style.display = 'none';
    
    // Pastikan remove button ada dan terlihat
    let removeBtn = clone.querySelector('.btn-remove');
    if (!removeBtn) {
        const actionsDiv = clone.querySelector('.item-actions');
        if (actionsDiv) {
            removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn-remove';
            removeBtn.innerHTML = '<i class="fas fa-times"></i> Hapus';
            removeBtn.onclick = function() { removeItem(this); };
            actionsDiv.insertBefore(removeBtn, actionsDiv.firstChild);
        }
    } else {
        removeBtn.style.display = 'inline-block';
    }
    
    const container = document.getElementById('itemContainer');
    const divider = document.createElement('hr');
    divider.className = 'item-divider';
    container.appendChild(divider);
    container.appendChild(clone);
    
    resetLogoList(clone);
    attachSizeEvent(clone);
    reindexItemRows();
    recalc();
}

// Fungsi untuk clone dari produk yang sudah ada (pilihan dropdown)
function cloneFromExisting() {
    const allRows = document.querySelectorAll('.item-row');
    if (allRows.length === 0) {
        alert('Belum ada produk untuk di-clone.');
        return;
    }
    // Buat dialog pilihan produk
    let options = [];
    allRows.forEach((row, idx) => {
        let productName = row.querySelector('input[name="jenis_produk[]"]').value;
        let sizeText = '';
        const sizeSelect = row.querySelector('.size-select');
        const customInput = row.querySelector('.size-custom');
        if (sizeSelect && sizeSelect.value === 'custom' && customInput.value) {
            sizeText = ' (Ukuran: ' + customInput.value + ')';
        } else if (sizeSelect && sizeSelect.selectedOptions[0] && sizeSelect.selectedOptions[0].text !== '-- Pilih Ukuran Standar --') {
            sizeText = ' (Ukuran: ' + sizeSelect.selectedOptions[0].text + ')';
        }
        options.push(`${idx+1}. ${productName}${sizeText}`);
    });
    let choice = prompt("Pilih produk yang akan diduplikasi:\n" + options.join("\n") + "\n\nMasukkan nomor produk:");
    if (choice && !isNaN(choice)) {
        let idx = parseInt(choice) - 1;
        if (idx >= 0 && idx < allRows.length) {
            cloneRow(allRows[idx]);
        } else {
            alert('Nomor tidak valid.');
        }
    }
}

function cloneItem(btn) {
    const row = btn.closest('.item-row');
    if (row) cloneRow(row);
}

function removeItem(btn) {
    const row = btn.closest('.item-row');
    if (row && document.querySelectorAll('.item-row').length > 1) {
        row.remove();
        // Hapus divider sebelumnya? sederhana: biarkan saja, tidak masalah.
        reindexItemRows();
        recalc();
    } else {
        alert('Minimal harus ada satu item produk.');
    }
}

function attachSizeEvent(row) {
    const sizeSelect = row.querySelector('.size-select');
    const customInput = row.querySelector('.size-custom');
    if (sizeSelect && customInput) {
        sizeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customInput.style.display = 'block';
                customInput.required = true;
            } else {
                customInput.style.display = 'none';
                customInput.value = '';
                customInput.required = false;
            }
        });
    }
}

// Event listener untuk radio pembayaran
document.querySelectorAll('.payment-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        let dpContainer = document.getElementById('dpContainer');
        if (this.value === 'lunas') {
            document.getElementById('dpInput').disabled = true;
        } else {
            document.getElementById('dpInput').disabled = false;
        }
        recalc();
    });
});

// Event listener untuk perubahan input
document.getElementById('formPesanan').addEventListener('input', recalc);
document.getElementById('formPesanan').addEventListener('change', recalc);

// Inisialisasi untuk row pertama
document.querySelectorAll('.item-row').forEach(row => { attachSizeEvent(row); updateLogoRemoveButtons(row); });
reindexItemRows();
document.getElementById('dpInput').disabled = false;
document.querySelector('select[name="metode_dp"]').disabled = false;

// Tampilkan tombol remove untuk row pertama (jika lebih dari satu nanti)
// Sembunyikan remove untuk row pertama jika hanya satu
if (document.querySelectorAll('.item-row').length === 1) {
    let firstRemove = document.querySelector('.item-row .btn-remove');
    if (firstRemove) firstRemove.style.display = 'none';
}
</script>
@endpush