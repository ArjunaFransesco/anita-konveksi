@extends('layouts.dashboard')

@section('title', 'Daftar & Update Pesanan')
@section('page-title', 'Daftar Pesanan')
@section('page-subtitle', 'Pantau dan perbarui status produksi setiap pesanan')

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@push('styles')
<style>
    .search-bar {
        background: #fff;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1.25rem;
    }
    .search-bar input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
        background: transparent;
    }
    .search-bar i { color: var(--text-muted); }

    .order-card {
        background: #fff;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        overflow: hidden;
        transition: var(--transition);
    }
    .order-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }
    .order-card-header {
        padding: 0.9rem 1.1rem 0.7rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }
    .inv-number {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--primary);
    }
    .order-card-body { padding: 0.9rem 1.1rem; }

    .order-meta {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 0.6rem;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }
    .order-meta span { display: flex; align-items: center; gap: 6px; }
    .order-meta i { width: 14px; text-align: center; color: var(--accent); }

    /* Progress bar */
    .progress-wrap { margin-bottom: 0.85rem; }
    .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.72rem;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .progress-bar-bg {
        height: 6px;
        background: #E9ECEF;
        border-radius: 3px;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        border-radius: 3px;
        background: var(--accent);
        transition: width 0.5s ease;
    }
    .progress-bar-fill.done { background: #28a745; }

    /* Update form inline */
    .update-form {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .update-form select {
        flex: 1;
        padding: 7px 10px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 0.78rem;
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
        background: #F8F9FA;
        cursor: pointer;
    }
    .update-form select:focus { outline: none; border-color: var(--accent); }

    .cards-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    @media (max-width: 1100px) { .cards-3 { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 700px)  { .cards-3 { grid-template-columns: 1fr; } }

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        color: var(--text-muted);
    }
    .empty-state i { font-size: 3rem; opacity: 0.25; display: block; margin-bottom: 1rem; }

    /* Tombol aksi card */
    .card-actions {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        padding: 8px 1.1rem 10px;
        border-top: 1px solid var(--border);
        background: #fafafa;
    }
    .btn-act {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: var(--radius-sm);
        font-size: 0.72rem;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .btn-act:hover { opacity: 0.8; }
    .btn-kwitansi  { background: #fff3cd; border-color: #ffc107; color: #856404; }
    .btn-surat     { background: #d4edda; border-color: #28a745; color: #155724; }
    .btn-foto      { background: #cce5ff; border-color: #004085; color: #004085; }

    /* Modal Foto Hasil */
    .foto-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.55);
        z-index: 2000;
        justify-content: center;
        align-items: center;
    }
    .foto-modal-overlay.open { display: flex; }
    .foto-modal-box {
        background: #fff;
        border-radius: var(--radius-md);
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        width: 560px;
        max-width: 95vw;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .foto-modal-header {
        background: var(--primary);
        color: #fff;
        padding: 0.85rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 700;
        font-size: 0.9rem;
    }
    .foto-modal-body { padding: 1.25rem; overflow-y: auto; flex: 1; }
    .foto-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-bottom: 1rem;
    }
    .foto-item {
        position: relative;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid var(--border);
    }
    .foto-item img {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        display: block;
    }
    .foto-item .foto-del {
        position: absolute;
        top: 4px;
        right: 4px;
        background: rgba(220,53,69,0.85);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        font-size: 0.65rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .foto-ket { font-size: 0.68rem; color: var(--text-muted); text-align: center; padding: 3px 4px; }
</style>
@endpush

@section('dashboard-content')

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif

{{-- Search --}}
<form method="GET" action="{{ route('owner.pesanan.index') }}" class="search-bar">
    <i class="fas fa-search"></i>
    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari No. Invoice atau Nama Pelanggan...">
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    @if($search)
        <a href="{{ route('owner.pesanan.index') }}" class="btn btn-outline btn-sm">Reset</a>
    @endif
</form>

{{-- Header aksi --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
    <div style="font-size:0.82rem; color:var(--text-muted);">
        <b style="color:var(--primary);">{{ $orders->count() }}</b> pesanan ditemukan
    </div>
    <a href="{{ route('owner.pesanan.input') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Pesanan Baru
    </a>
</div>

{{-- Order Cards --}}
@if($orders->isEmpty())
    <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <p>Belum ada pesanan{{ $search ? ' yang cocok' : '' }}.</p>
        <a href="{{ route('owner.pesanan.input') }}" class="btn btn-primary" style="margin-top:1rem;">
            <i class="fas fa-plus"></i> Input Pesanan Pertama
        </a>
    </div>
@else
    <div class="cards-3">
        @foreach($orders as $order)
        @php
            $progress  = $order->progress;
            $isDone    = $order->status_produksi === 'selesai';
            $statusMap = \App\Models\Order::$statusProduksiLabels;
        @endphp
        <div class="order-card">
            <div class="order-card-header">
                <div>
                    <div class="inv-number">{{ $order->invoice_number }}</div>
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-top:2px;">{{ $order->customer->nama }}</div>
                </div>
                <span class="badge {{ $order->status_pembayaran === 'lunas' ? 'badge-success' : 'badge-warning' }}">
                    {{ $order->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                </span>
            </div>
            <div class="order-card-body">
                <div class="order-meta">
                    <span><i class="fas fa-calendar-alt"></i> Deadline: {{ $order->deadline ? $order->deadline->format('d M Y') : '-' }}</span>
                    <span><i class="fas fa-coins"></i> Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    <span><i class="fas fa-hand-holding-usd"></i> Sisa: Rp {{ number_format($order->sisa_tagihan, 0, ',', '.') }}</span>
                </div>

                {{-- Progress --}}
                <div class="progress-wrap">
                    <div class="progress-label">
                        <span style="color:var(--text-main);">{{ $order->status_label }}</span>
                        <span style="color:var(--accent);">{{ $progress }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill {{ $isDone ? 'done' : '' }}" style="width:{{ $progress }}%"></div>
                    </div>
                </div>

                {{-- Update form --}}
                <form method="POST" action="{{ route('owner.pesanan.status', $order->id) }}" class="update-form">
                    @csrf
                    <select name="status_produksi">
                        @foreach($statusMap as $val => $label)
                            <option value="{{ $val }}" {{ $order->status_produksi === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm" style="background:var(--accent); color:var(--primary); flex-shrink:0;">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </form>
            </div>

            {{-- Tombol Aksi --}}
            <div class="card-actions">
                <a href="{{ route('owner.pesanan.kwitansi', $order->id) }}" target="_blank" class="btn-act btn-kwitansi">
                    <i class="fas fa-receipt"></i> Kwitansi
                </a>
                <a href="{{ route('owner.pesanan.surat_pegawai', $order->id) }}" target="_blank" class="btn-act btn-surat">
                    <i class="fas fa-file-alt"></i> Surat Pegawai
                </a>
                <button type="button" class="btn-act btn-foto"
                        onclick="openFotoModal({{ $order->id }}, '{{ $order->invoice_number }}')"
                        id="btn-foto-{{ $order->id }}">
                    <i class="fas fa-camera"></i> Foto Hasil
                </button>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- Modal: Foto Hasil Produksi --}}
<div class="foto-modal-overlay" id="fotoModal">
    <div class="foto-modal-box">
        <div class="foto-modal-header">
            <span><i class="fas fa-camera" style="color:var(--accent)"></i> Foto Hasil — <span id="fotoModalInvoice"></span></span>
            <button onclick="closeFotoModal()" style="background:none;border:none;color:#fff;font-size:1.3rem;cursor:pointer;">✕</button>
        </div>
        <div class="foto-modal-body">
            {{-- Foto yang sudah ada --}}
            <div id="fotoGrid" class="foto-grid"></div>
            <p id="fotoKosong" style="color:var(--text-muted); font-size:0.82rem; text-align:center; display:none; margin-bottom:1rem;">
                <i class="fas fa-image" style="font-size:2rem; opacity:0.3; display:block; margin-bottom:6px;"></i>
                Belum ada foto hasil. Upload foto di bawah.
            </p>

            {{-- Form Upload --}}
            <form id="formUploadFoto" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="border:2px dashed var(--border); border-radius:8px; padding:1rem; text-align:center; margin-bottom:10px;">
                    <input type="file" name="foto_hasil[]" id="inputFotoHasil" multiple
                           accept="image/jpeg,image/png,image/jpg" style="display:none;">
                    <label for="inputFotoHasil" style="cursor:pointer; color:var(--accent); font-weight:600; font-size:0.82rem;">
                        <i class="fas fa-cloud-upload-alt" style="font-size:1.8rem; display:block; margin-bottom:6px;"></i>
                        Klik untuk pilih foto (bisa lebih dari 1)
                    </label>
                    <div id="uploadPreviewList" style="margin-top:8px; font-size:0.75rem; color:var(--text-muted);"></div>
                </div>
                <input type="text" name="keterangan" placeholder="Keterangan foto (opsional)"
                       style="width:100%; padding:8px 10px; border:1px solid var(--border); border-radius:var(--radius-sm); font-size:0.82rem; margin-bottom:10px;">
                <button type="submit" class="btn btn-primary" style="width:100%;">
                    <i class="fas fa-upload"></i> Upload Foto Hasil
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentOrderId = null;

function openFotoModal(orderId, invoice) {
    currentOrderId = orderId;
    document.getElementById('fotoModalInvoice').textContent = invoice;
    document.getElementById('fotoGrid').innerHTML = '<p style="color:var(--text-muted);font-size:0.8rem;">Memuat...</p>';
    document.getElementById('fotoModal').classList.add('open');

    // Set form action
    document.getElementById('formUploadFoto').action = `/owner/pesanan/${orderId}/hasil-foto`;

    // Load foto via AJAX
    fetch(`/owner/pesanan/${orderId}/detail`)
        .then(r => r.json())
        .then(data => renderFotoGrid(data.hasil_fotos || []))
        .catch(() => { document.getElementById('fotoGrid').innerHTML = ''; });
}

function renderFotoGrid(fotos) {
    const grid = document.getElementById('fotoGrid');
    const kosong = document.getElementById('fotoKosong');

    if (!fotos.length) {
        grid.innerHTML = '';
        kosong.style.display = 'block';
        return;
    }
    kosong.style.display = 'none';
    grid.innerHTML = fotos.map(f => `
        <div class="foto-item" id="foto-item-${f.id}">
            <a href="${f.url}" target="_blank">
                <img src="${f.url}" alt="Foto Hasil" loading="lazy">
            </a>
            <form method="POST" action="/owner/hasil-foto/${f.id}" style="display:inline;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="foto-del" onclick="return confirm('Hapus foto ini?')" title="Hapus">
                    <i class="fas fa-times"></i>
                </button>
            </form>
            ${f.keterangan ? `<div class="foto-ket">${f.keterangan}</div>` : ''}
        </div>
    `).join('');
}

function closeFotoModal() {
    document.getElementById('fotoModal').classList.remove('open');
    currentOrderId = null;
}

// Preview nama file yang dipilih
document.getElementById('inputFotoHasil')?.addEventListener('change', function () {
    const names = Array.from(this.files).map(f => f.name).join(', ');
    document.getElementById('uploadPreviewList').textContent = names ? `✓ ${this.files.length} file: ${names}` : '';
});

// Tutup modal jika klik luar
document.getElementById('fotoModal')?.addEventListener('click', function (e) {
    if (e.target === this) closeFotoModal();
});
</script>
@endpush

@endsection
