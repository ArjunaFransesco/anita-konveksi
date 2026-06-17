@extends('layouts.dashboard')

@section('title', 'Daftar Transaksi')
@section('page-title', 'Daftar Transaksi')
@section('page-subtitle', 'Pantau semua transaksi pesanan Anita Konveksi')

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@push('styles')
<style>
    .status-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .sp-nunggu  { background: rgba(108,117,125,0.12); color: #6c757d; }
    .sp-proses  { background: rgba(255,159,28,0.15);  color: #cc7a00; }
    .sp-siap    { background: rgba(0,123,255,0.12);   color: #0056b3; }
    .sp-selesai { background: rgba(40,167,69,0.12);   color: #1a7a38; }
    .sp-qc      { background: rgba(111,66,193,0.12);  color: #5a2f9e; }
    .pay-belum  { background: rgba(220,53,69,0.1);    color: #b02a37; }
    .pay-lunas  { background: rgba(40,167,69,0.12);   color: #1a7a38; }
    .text-danger-fw { color: #dc3545; font-weight: 700; }
    .text-success-fw { color: #198754; font-weight: 700; }

    /* Filter bar */
    .filter-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 1rem 1.25rem;
        box-shadow: var(--shadow-sm);
        margin-bottom: 1.25rem;
    }
    .filter-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    .filter-row .fg { display: flex; flex-direction: column; gap: 4px; }
    .filter-row .fg label {
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .filter-row input,
    .filter-row select {
        padding: 8px 12px;
        font-size: 0.83rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        background: #fff;
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
        min-width: 150px;
    }
    .filter-row input[type=text] { min-width: 200px; }
    .filter-row input[type=month] { min-width: 140px; }

    /* Action top bar */
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 8px;
    }
    .export-group { display: flex; gap: 8px; }

    /* Summary pills */
    .summary-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 1.1rem;
    }
    .sum-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid var(--border);
        background: #fff;
        box-shadow: var(--shadow-sm);
    }
    .sum-pill i { font-size: 0.85rem; }
    .pill-total  { border-color: #dee2e6; color: var(--primary); }
    .pill-lunas  { border-color: rgba(40,167,69,0.3); color: #1a7a38; background: rgba(40,167,69,0.05); }
    .pill-belum  { border-color: rgba(220,53,69,0.3); color: #b02a37; background: rgba(220,53,69,0.05); }
    .pill-omset  { border-color: rgba(255,159,28,0.4); color: #cc7a00; background: rgba(255,159,28,0.07); }

    /* Modal Detail Transaksi */
    .detail-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 2000;
        justify-content: center;
        align-items: center;
        padding: 1rem;
    }
    .detail-overlay.open { display: flex; }
    .detail-modal {
        background: #fff;
        border-radius: var(--radius-md);
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        width: 850px;
        max-width: 96vw;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .detail-modal-header {
        background: var(--primary);
        color: #fff;
        padding: 0.85rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 700;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .detail-modal-body { padding: 1.25rem; overflow-y: auto; flex: 1; }
    .detail-section { margin-bottom: 1.2rem; }
    .detail-section-title {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 8px;
        padding-bottom: 4px;
        border-bottom: 1px solid var(--border);
    }
    .detail-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
    }
    .detail-info-row {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .detail-info-label { font-size: 0.7rem; color: var(--text-muted); }
    .detail-info-value { font-size: 0.85rem; font-weight: 600; color: var(--text-main); }
    .pay-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        margin-bottom: 8px;
        background: #fafafa;
    }
    .pay-item-info { flex: 1; }
    .pay-item-date { font-size: 0.72rem; color: var(--text-muted); }
    .pay-item-label { font-size: 0.82rem; font-weight: 600; }
    .pay-item-amount { font-size: 1rem; font-weight: 700; color: var(--primary); }
    .pay-bukti-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--border);
        cursor: pointer;
        flex-shrink: 0;
    }
    .tipe-dp      { background: #fff3cd; color: #856404; padding: 2px 8px; border-radius: 10px; font-size: 0.68rem; font-weight: 700; }
    .tipe-lunas   { background: #d4edda; color: #155724; padding: 2px 8px; border-radius: 10px; font-size: 0.68rem; font-weight: 700; }
</style>
@endpush

@section('dashboard-content')

{{-- Filter Card --}}
<div class="filter-card">
    <form method="GET" action="{{ route('owner.transaksi') }}" id="filterForm">
        <div class="filter-row">
            <div class="fg">
                <label>Cari</label>
                <input type="text" name="q" value="{{ $search }}" placeholder="Invoice / Nama Pelanggan...">
            </div>
            <div class="fg">
                <label>Status Produksi</label>
                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $key => $label)
                        <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fg">
                <label>Pembayaran</label>
                <select name="bayar">
                    <option value="">Semua</option>
                    <option value="lunas"  {{ $bayar === 'lunas'  ? 'selected' : '' }}>Lunas</option>
                    <option value="belum"  {{ $bayar === 'belum'  ? 'selected' : '' }}>Belum Lunas</option>
                </select>
            </div>
            <div class="fg">
                <label>Bulan</label>
                <input type="month" name="bulan" value="{{ $bulan }}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('owner.transaksi') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>
</div>

{{-- Summary Pills --}}
<div class="summary-pills">
    <div class="sum-pill pill-total">
        <i class="fas fa-list"></i>
        <span>{{ $orders->total() }} Transaksi</span>
    </div>
    <div class="sum-pill pill-lunas">
        <i class="fas fa-check-circle"></i>
        <span>{{ $orders->getCollection()->where('status_pembayaran', 'lunas')->count() }} Lunas (halaman ini)</span>
    </div>
    <div class="sum-pill pill-belum">
        <i class="fas fa-clock"></i>
        <span>{{ $orders->getCollection()->where('status_pembayaran', 'belum')->count() }} Belum Lunas (halaman ini)</span>
    </div>
    <div class="sum-pill pill-omset">
        <i class="fas fa-coins"></i>
        <span>Rp {{ number_format($orders->getCollection()->sum('total_setelah_diskon'), 0, ',', '.') }} (halaman ini)</span>
    </div>
</div>

{{-- Top Action Bar --}}
<div class="top-bar">
    <span style="font-size:0.82rem; color:var(--text-muted);">
        Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} transaksi
    </span>
    <div class="export-group">
        <a href="{{ route('owner.transaksi.export.excel', request()->query()) }}"
           class="btn btn-outline btn-sm">
            <i class="fas fa-file-excel" style="color:#1D6F42;"></i> Ekspor Excel
        </a>
        <a href="{{ route('owner.transaksi.export.pdf', request()->query()) }}"
           class="btn btn-outline btn-sm">
            <i class="fas fa-file-pdf" style="color:#dc3545;"></i> Ekspor PDF
        </a>
    </div>
</div>

{{-- Tabel --}}
<div class="content-card">
    <div style="overflow-x:auto;">
        @if($orders->isEmpty())
            <div style="padding:3rem; text-align:center; color:var(--text-muted);">
                <i class="fas fa-inbox" style="font-size:2.5rem; opacity:0.3; display:block; margin-bottom:.75rem;"></i>
                Tidak ada transaksi ditemukan.
            </div>
        @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Deadline</th>
                    <th>Total</th>
                    <th>DP</th>
                    <th>Sisa</th>
                    <th>Status Produksi</th>
                    <th>Pembayaran</th>
                    <th style="width:60px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $o)
                @php
                    $sp = $o->status_produksi;
                    $pillClass = match(true) {
                        in_array($sp, ['nunggu_konfirmasi','menunggu_bahan'])                   => 'sp-nunggu',
                        in_array($sp, ['proses_potong','proses_jahit','proses_sablon_bordir'])  => 'sp-proses',
                        $sp === 'quality_control'                                               => 'sp-qc',
                        $sp === 'siap_diambil'                                                  => 'sp-siap',
                        $sp === 'selesai'                                                       => 'sp-selesai',
                        default                                                                 => 'sp-nunggu',
                    };
                @endphp
                <tr>
                    <td style="font-weight:700; color:var(--accent);">{{ $o->invoice_number }}</td>
                    <td>{{ $o->customer->nama }}</td>
                    <td>{{ $o->tanggal_pesan->format('d M Y') }}</td>
                    <td style="color:var(--text-muted);">
                        {{ $o->deadline ? $o->deadline->format('d M Y') : '-' }}
                    </td>
                    <td style="font-weight:600;">Rp {{ number_format($o->total_setelah_diskon, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($o->dp, 0, ',', '.') }}</td>
                    <td class="{{ $o->sisa_tagihan > 0 ? 'text-danger-fw' : 'text-success-fw' }}">
                        {{ $o->sisa_tagihan > 0 ? 'Rp '.number_format($o->sisa_tagihan, 0, ',', '.') : 'Lunas' }}
                    </td>
                    <td><span class="status-pill {{ $pillClass }}">{{ $o->status_label }}</span></td>
                    <td>
                        <span class="status-pill {{ $o->status_pembayaran === 'lunas' ? 'pay-lunas' : 'pay-belum' }}">
                            {{ $o->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-outline btn-sm" style="padding:4px 10px; font-size:0.72rem;"
                                onclick="bukaTrDetail({{ $o->id }})">
                            <i class="fas fa-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
    <div style="padding: 1rem 1.25rem; border-top: 1px solid var(--border); display:flex; justify-content:flex-end;">
        {{ $orders->links('pagination::simple-bootstrap-4') }}
    </div>
    @endif
</div>

@endsection

@push('styles')
{{-- Styles sudah di atas --}}
@endpush

{{-- Modal Detail Transaksi --}}
<div class="detail-overlay" id="detailOverlay">
    <div class="detail-modal">
        <div class="detail-modal-header">
            <span><i class="fas fa-receipt" style="color:var(--accent)"></i> Detail Transaksi &mdash; <span id="dInvoice"></span></span>
            <button onclick="tutupDetail()" style="background:none;border:none;color:#fff;font-size:1.3rem;cursor:pointer;">&#x2715;</button>
        </div>
        <div class="detail-modal-body" id="detailModalBody">
            <div style="text-align:center; padding:2rem; color:var(--text-muted);"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function bukaTrDetail(orderId) {
    document.getElementById('detailOverlay').classList.add('open');
    document.getElementById('dInvoice').textContent = '...';
    document.getElementById('detailModalBody').innerHTML = '<div style="text-align:center; padding:2rem; color:var(--text-muted);"><i class="fas fa-spinner fa-spin fa-2x"></i></div>';

    fetch(`/owner/pesanan/${orderId}/detail`)
        .then(r => r.json())
        .then(d => renderDetail(d))
        .catch(() => {
            document.getElementById('detailModalBody').innerHTML = '<p style="color:#dc3545;">Gagal memuat data.</p>';
        });
}

function tutupDetail() {
    document.getElementById('detailOverlay').classList.remove('open');
}

function fmt(n) { return 'Rp ' + parseFloat(n).toLocaleString('id-ID'); }

function renderLogoItemsTransaksi(item) {
    const items = Array.isArray(item.logo_items) && item.logo_items.length
        ? item.logo_items
        : (item.logo ? [{ logo: item.logo, keterangan_desain: item.desain || '-' }] : []);

    if (!items.length) return '-';

    return items.map((logo, idx) => {
        const ket = (logo.keterangan_desain || '-');
        const image = logo.logo
            ? `<a href="${logo.logo}" target="_blank" style="margin-right:5px;" title="Klik untuk memperbesar"><img src="${logo.logo}" style="width:30px;height:30px;object-fit:cover;border-radius:4px;vertical-align:middle;" alt="Logo"></a>`
            : '';
        return `<div style="margin-bottom:4px; font-size:0.75rem; display:flex; align-items:center;">${image} <span>${ket}</span></div>`;
    }).join('');
}

function renderDetail(d) {
    document.getElementById('dInvoice').textContent = d.invoice;

    const produkRows = (d.details || []).map(item => `
        <tr style="border-bottom: 1px solid #e2e8f0;">
            <td style="font-weight:600; padding: 8px;">${item.jenis_produk}</td>
            <td style="padding: 8px;">${item.jumlah} pcs</td>
            <td style="padding: 8px;">${item.ukuran}</td>
            <td style="padding: 8px;">${item.bahan}</td>
            <td style="padding: 8px;">${item.warna}</td>
            <td style="padding: 8px;">${renderLogoItemsTransaksi(item)}</td>
            <td style="text-align:right; padding: 8px;">${fmt(item.subtotal)}</td>
        </tr>
    `).join('');

    const payRows = (d.payments || []).map(p => {
        const buktiHtml = p.bukti
            ? `<a href="${p.bukti}" target="_blank"><img src="${p.bukti}" class="pay-bukti-thumb" alt="Bukti" title="Klik untuk perbesar"></a>`
            : '<span style="font-size:0.75rem;color:var(--text-muted);">Tidak ada bukti</span>';

        const tipeClass = p.tipe === 'DP' ? 'tipe-dp' : 'tipe-lunas';
        return `
            <div class="pay-item">
                <div class="pay-item-info">
                    <div class="pay-item-date">${p.tanggal}</div>
                    <div class="pay-item-label">
                        <span class="${tipeClass}">${p.tipe}</span>
                        &nbsp; ${p.metode}
                    </div>
                    <div class="pay-item-amount">${fmt(p.jumlah)}</div>
                </div>
                ${buktiHtml}
            </div>
        `;
    }).join('');

    let diskonHtml = '';
    if (d.diskon_nominal > 0) {
        if (d.diskon_jenis === 'nominal') {
            diskonHtml = `<div class="detail-info-row"><span class="detail-info-label">Diskon</span><span class="detail-info-value" style="color:#17a2b8;">- ${fmt(d.diskon_nominal)}</span></div>`;
        } else {
            diskonHtml = `<div class="detail-info-row"><span class="detail-info-label">Diskon (${parseFloat(d.diskon_persen).toFixed(2).replace(/\.00$/, '')}%)</span><span class="detail-info-value" style="color:#17a2b8;">- ${fmt(d.diskon_nominal)}</span></div>`;
        }
    }

    document.getElementById('detailModalBody').innerHTML = `
        <div class="detail-section">
            <div class="detail-section-title">Informasi Pelanggan</div>
            <div class="detail-info-grid">
                <div class="detail-info-row"><span class="detail-info-label">Nama</span><span class="detail-info-value">${d.customer}</span></div>
                <div class="detail-info-row"><span class="detail-info-label">No. HP</span><span class="detail-info-value">${d.no_hp || '-'}</span></div>
                <div class="detail-info-row"><span class="detail-info-label">Tgl. Pesan</span><span class="detail-info-value">${d.tanggal_pesan}</span></div>
                <div class="detail-info-row"><span class="detail-info-label">Deadline</span><span class="detail-info-value">${d.deadline}</span></div>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-section-title">Detail Produk</div>
            <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:0.8rem;">
                <thead><tr style="background:#f0f0f0;">
                    <th style="padding:5px 8px; text-align:left;">Produk</th>
                    <th style="padding:5px 8px;">Qty</th>
                    <th style="padding:5px 8px;">Ukuran</th>
                    <th style="padding:5px 8px;">Bahan</th>
                    <th style="padding:5px 8px;">Warna</th>
                    <th style="padding:5px 8px;">Logo & Keterangan</th>
                    <th style="padding:5px 8px; text-align:right;">Subtotal</th>
                </tr></thead>
                <tbody>${produkRows}</tbody>
            </table>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-section-title">Ringkasan Pembayaran</div>
            <div class="detail-info-grid">
                <div class="detail-info-row"><span class="detail-info-label">Total Harga</span><span class="detail-info-value">${fmt(d.total_harga_raw || d.total_harga)}</span></div>
                ${diskonHtml}
                <div class="detail-info-row" style="border-top:1px dashed var(--border); padding-top:4px;"><span class="detail-info-label" style="font-weight:700;">Total Akhir</span><span class="detail-info-value" style="font-weight:700;">${fmt(d.total_setelah_diskon)}</span></div>
                <div class="detail-info-row"><span class="detail-info-label">DP Terbayar</span><span class="detail-info-value">${fmt(d.dp)}</span></div>
                <div class="detail-info-row"><span class="detail-info-label">Sisa</span><span class="detail-info-value" style="color:${parseFloat(d.sisa_tagihan)>0?'#dc3545':'#28a745'}">${parseFloat(d.sisa_tagihan)>0 ? fmt(d.sisa_tagihan) : 'LUNAS'}</span></div>
                <div class="detail-info-row"><span class="detail-info-label">Status</span><span class="detail-info-value">${d.status_pembayaran}</span></div>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-section-title">Riwayat Pembayaran & Bukti</div>
            ${payRows || '<p style="color:var(--text-muted); font-size:0.82rem;">Belum ada pembayaran tercatat.</p>'}
        </div>
    `;
}

document.getElementById('detailOverlay')?.addEventListener('click', function(e) {
    if (e.target === this) tutupDetail();
});
</script>
@endpush

@section('after-content')
@endsection
