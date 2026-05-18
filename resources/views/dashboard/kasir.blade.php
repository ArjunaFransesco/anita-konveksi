@extends('layouts.dashboard')

@section('title', 'Dashboard Kasir')
@section('page-title', 'Dashboard Kasir')
@section('page-subtitle')
Tugas Hari ini — {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
@endsection

@section('sidebar-menu')
    @include('kasir.sidebar')
@endsection

@push('styles')
<style>
    /* ========== STYLE DARI KODE SEBELUMNYA (TIDAK BERUBAH) ========== */
    .status-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .sp-nunggu    { background: rgba(108,117,125,0.12); color: #6c757d; }
    .sp-proses    { background: rgba(255,159,28,0.15);  color: #cc7a00; }
    .sp-siap      { background: rgba(0,123,255,0.12);   color: #0056b3; }
    .sp-selesai   { background: rgba(40,167,69,0.12);   color: #1a7a38; }
    .sp-qc        { background: rgba(111,66,193,0.12);  color: #5a2f9e; }
    .pay-belum    { background: rgba(220,53,69,0.1);    color: #b02a37; }
    .pay-lunas    { background: rgba(40,167,69,0.12);   color: #1a7a38; }
    .quick-links {
        display: flex;
        gap: 10px;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
    }
    .quick-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        text-decoration: none;
        color: var(--text-main);
        font-size: 0.83rem;
        font-weight: 600;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        flex: 1;
        min-width: 160px;
    }
    .quick-link:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
        border-color: var(--accent);
        color: var(--accent-dark);
    }
    .quick-link .ql-icon {
        width: 34px; height: 34px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .ql-blue   { background: rgba(0,123,255,0.1);  color: #0056b3; }
    .ql-orange { background: var(--accent-light);  color: var(--accent-dark); }
    .ql-green  { background: rgba(40,167,69,0.1);  color: #1a7a38; }
    .ql-red    { background: rgba(220,53,69,0.1);  color: #b02a37; }
    .ql-label  { line-height: 1.2; }
    .ql-label small { font-size: 0.7rem; color: var(--text-muted); font-weight: 400; display: block; }
    
    /* ========== PERBAIKAN MODAL DENGAN TAMPILAN RAPI ========== */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.6);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        font-family: 'Inter', sans-serif;
    }
    .custom-modal-content {
        background: white;
        width: 95%;
        max-width: 1100px;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        animation: fadeIn 0.2s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.98); }
        to { opacity: 1; transform: scale(1); }
    }
    .custom-modal-header {
        padding: 18px 24px;
        background: #0d6efd;
        color: white;
        border-radius: 16px 16px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .custom-modal-header h5 {
        margin: 0;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1.2rem;
    }
    .custom-modal-close {
        background: none;
        border: none;
        color: white;
        font-size: 1.8rem;
        cursor: pointer;
        line-height: 1;
        opacity: 0.8;
        transition: opacity 0.2s;
    }
    .custom-modal-close:hover { opacity: 1; }
    .custom-modal-body {
        padding: 24px;
    }
    .custom-modal-footer {
        padding: 14px 24px;
        border-top: 1px solid #dee2e6;
        text-align: right;
        background: #f8f9fa;
        border-radius: 0 0 16px 16px;
    }
    .btn-secondary {
        background: #6c757d;
        color: white;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: background 0.2s;
    }
    .btn-secondary:hover { background: #5a6268; }
    
    /* Tabel di dalam modal */
    .modal-detail-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }
    .modal-detail-table th,
    .modal-detail-table td {
        padding: 8px 12px;
        text-align: left;
        vertical-align: top;
        border-bottom: 1px solid #e9ecef;
    }
    .modal-detail-table th {
        width: 35%;
        background: #f8f9fa;
        font-weight: 600;
        color: #1e1e2a;
    }
    .badge-custom {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-produksi { background: #e9ecef; color: #495057; }
    .badge-lunas { background: #d1e7dd; color: #0f5132; }
    .badge-belum { background: #f8d7da; color: #842029; }
    .bg-info { background: #0dcaf0; color: #000; }
    .items-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.8rem;
    }
    .items-table th, .items-table td {
        padding: 8px 10px;
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }
    .items-table th {
        background: #f1f3f5;
        font-weight: 600;
    }
    .logo-thumb {
        max-width: 50px;
        max-height: 50px;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .riwayat-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.8rem;
        margin-top: 10px;
    }
    .riwayat-table th, .riwayat-table td {
        padding: 6px 12px;
        border: 1px solid #dee2e6;
    }
    .spinner-border {
        display: inline-block;
        width: 2rem;
        height: 2rem;
        border: 0.25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border 0.75s linear infinite;
    }
    @keyframes spinner-border {
        to { transform: rotate(360deg); }
    }
    .text-center { text-align: center; }
    .py-4 { padding-top: 2rem; padding-bottom: 2rem; }
    .mt-3 { margin-top: 1rem; }
    .fw-bold { font-weight: 700; }
    .text-danger { color: #dc3545; }
    .text-success { color: #198754; }
    .ms-2 { margin-left: 0.5rem; }
    .table-responsive { overflow-x: auto; }
</style>
@endpush

@section('dashboard-content')

<div class="stats-grid">
    <div class="stat-card dark">
        <div class="stat-icon"><i class="fas fa-file-invoice"></i></div>
        <div class="stat-value">{{ $totalPesanan }}</div>
        <div class="stat-label">Total Pesanan</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-value">{{ $menungguDP }}</div>
        <div class="stat-label">Menunggu Pelunasan</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-box-open"></i></div>
        <div class="stat-value">{{ $siapDiambil }}</div>
        <div class="stat-label">Siap Diambil</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-value">{{ $selesai }}</div>
        <div class="stat-label">Selesai</div>
    </div>
</div>

<div class="quick-links">
    <a href="{{ route('kasir.pesanan.input') }}" class="quick-link">
        <div class="ql-icon ql-blue"><i class="fas fa-cart-plus"></i></div>
        <div class="ql-label">Input Pesanan <small>Buat pesanan baru</small></div>
    </a>
    <a href="{{ route('kasir.pesanan.index') }}" class="quick-link">
        <div class="ql-icon ql-orange"><i class="fas fa-tasks"></i></div>
        <div class="ql-label">Update Status <small>Kelola status produksi</small></div>
    </a>
    <a href="{{ route('kasir.pembayaran.catat') }}" class="quick-link">
        <div class="ql-icon ql-green"><i class="fas fa-file-invoice-dollar"></i></div>
        <div class="ql-label">Catat Pembayaran <small>DP atau pelunasan</small></div>
    </a>
    <a href="{{ route('kasir.pengeluaran.index') }}" class="quick-link">
        <div class="ql-icon ql-red"><i class="fas fa-money-bill-wave"></i></div>
        <div class="ql-label">Pengeluaran <small>Catat transaksi keluar</small></div>
    </a>
</div>


<div class="content-card">
    <div class="card-header" style="background:#F8F9FA;">
        <h3>Pesanan Terbaru</h3>
        <a href="{{ route('kasir.pesanan.index') }}" class="btn btn-outline btn-sm">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>

    @if($recentOrders->isEmpty())
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Belum ada pesanan. <a href="{{ route('kasir.pesanan.input') }}">Input pesanan pertama</a></p>
        </div>
    @else
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr><th>Invoice</th><th>Pelanggan</th><th>Tanggal</th><th>Deadline</th><th>Total (Setelah Diskon)</th><th>Sisa</th><th>Status Produksi</th><th>Pembayaran</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    @php
                        $sp = $order->status_produksi;
                        $pillClass = match(true) {
                            in_array($sp, ['nunggu_konfirmasi','menunggu_bahan']) => 'sp-nunggu',
                            in_array($sp, ['proses_potong','proses_jahit','proses_sablon_bordir']) => 'sp-proses',
                            $sp === 'quality_control' => 'sp-qc',
                            $sp === 'siap_diambil' => 'sp-siap',
                            $sp === 'selesai' => 'sp-selesai',
                            default => 'sp-nunggu'
                        };
                    @endphp
                    <tr>
                        <td><span style="font-weight:700;">{{ $order->invoice_number }}</span></td>
                        <td>{{ $order->customer->nama }}</td>
                        <td>{{ $order->tanggal_pesan->format('d M Y') }}</td>
                        <td>{{ $order->deadline ? $order->deadline->format('d M Y') : '-' }}</td>
                        <td>Rp {{ number_format($order->total_setelah_diskon, 0, ',', '.') }}</td>
                        <td class="{{ $order->sisa_tagihan > 0 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                            {{ $order->sisa_tagihan > 0 ? 'Rp '.number_format($order->sisa_tagihan, 0, ',', '.') : 'Lunas' }}
                        </td>
                        <td><span class="status-pill {{ $pillClass }}">{{ $order->status_label }}</span></td>
                        <td><span class="status-pill {{ $order->status_pembayaran === 'lunas' ? 'pay-lunas' : 'pay-belum' }}">{{ $order->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum' }}</span></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline" onclick="showDetailModal({{ $order->id }})" title="Detail"><i class="fas fa-eye"></i></button>
                            <a href="{{ route('kasir.pembayaran.catat', ['order_id' => $order->id]) }}" class="btn btn-sm btn-outline" title="Catat Bayar"><i class="fas fa-money-bill-wave"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- MODAL CUSTOM DENGAN STYLING RAPI -->
<div id="customModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5><i class="fas fa-file-invoice"></i> Detail Pesanan</h5>
            <button class="custom-modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="custom-modal-body" id="modalDetailBody">
            <div class="text-center py-4">
                <div class="spinner-border text-primary"></div>
                <p class="mt-3">Memuat data pesanan...</p>
            </div>
        </div>
        <div class="custom-modal-footer">
            <button class="btn-secondary" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function formatRupiah(angka) {
    return 'Rp ' + Math.round(angka).toLocaleString('id-ID');
}

function showDetailModal(orderId) {
    const modal = document.getElementById('customModal');
    const body = document.getElementById('modalDetailBody');
    body.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary"></div><p>Memuat data pesanan...</p></div>';
    modal.style.display = 'flex';

    const url = '/kasir/pesanan/' + orderId + '/detail';
    
    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('Server merespon ' + response.status);
            return response.json();
        })
        .then(data => {
            let diskonBadge = data.diskon_persen > 0 
                ? `<span class="badge-custom bg-info ms-2">Diskon ${data.diskon_persen}%</span>` 
                : '';
            let statusBayarClass = data.status_pembayaran === 'Lunas' ? 'badge-lunas' : 'badge-belum';
            
            let html = `
                <div style="display: flex; flex-wrap: wrap; gap: 1.5rem;">
                    <div style="flex: 1; min-width: 250px;">
                        <table class="modal-detail-table">
                            <tr><th>Invoice</th><td><strong>${data.invoice}</strong></td>
                            <tr><th>Pelanggan</th><td>${data.customer}<br><span style="font-size:0.75rem;">${data.no_hp || '-'} | ${data.alamat || '-'}</span></td>
                            <tr><th>Tgl Pesan</th><td>${data.tanggal_pesan}</td>
                            <tr><th>Deadline</th><td>${data.deadline}</td>
                        </table>
                    </div>
                    <div style="flex: 1; min-width: 250px;">
                        <table class="modal-detail-table">
                            <tr><th>Status Produksi</th><td><span class="badge-custom badge-produksi">${data.status_produksi}</span></td>
                            <tr><th>Status Bayar</th><td><span class="badge-custom ${statusBayarClass}">${data.status_pembayaran}</span></td>
                            <tr><th>Total (sebelum diskon)</th><td>${formatRupiah(data.total_harga_raw)}</span></td>
                            <tr><th>Diskon</th><td>${diskonBadge || '0%'}</td>
                            <tr><th>Total Setelah Diskon</th><td><strong class="text-success">${formatRupiah(data.total_setelah_diskon)}</strong></td>
                            <tr><th>DP Dibayar</th><td>${formatRupiah(data.dp)}</span></td>
                            <tr><th>Sisa Tagihan</th><td><span class="${data.sisa_tagihan > 0 ? 'text-danger fw-bold' : 'text-success fw-bold'}">${formatRupiah(data.sisa_tagihan)}</span></td>
                        </table>
                    </div>
                </div>
                <hr style="margin: 1.2rem 0;">
                <h6 style="font-weight: 700; margin-bottom: 0.75rem;"><i class="fas fa-boxes"></i> Item Pesanan</h6>
                <div class="table-responsive">
                    <table class="items-table">
                        <thead>
                            <tr><th>Produk</th><th>Qty</th><th>Ukuran</th><th>Bahan/Warna</th><th>Desain</th><th>Harga Satuan</th><th>Subtotal</th><th>Logo</th></tr>
                        </thead>
                        <tbody>`;
            
            data.details.forEach(item => {
                let logoHtml = item.logo 
                    ? `<a href="${item.logo}" target="_blank"><img src="${item.logo}" class="logo-thumb" alt="logo"></a>` 
                    : '-';
                let desain = item.desain && item.desain !== '-' ? item.desain : '-';
                html += `<tr>
                    <td>${item.jenis_produk}</span></td>
                    <td>${item.jumlah}</span></span></td>
                    <td>${item.ukuran}</span></span></td>
                    <td>${item.bahan} / ${item.warna}</span></span></td>
                    <td>${desain}</span></span></td>
                    <td>${formatRupiah(item.harga_satuan)}</span></span></td>
                    <td>${formatRupiah(item.subtotal)}</span></span></td>
                    <td>${logoHtml}</span></span></td>
                </tr>`;
            });
            
            html += `</tbody>
                    </table>
                </div>`;
            
            if (data.payments && data.payments.length) {
                html += `<hr style="margin: 1.2rem 0;">
                         <h6 style="font-weight: 700; margin-bottom: 0.75rem;"><i class="fas fa-credit-card"></i> Riwayat Pembayaran</h6>
                         <table class="riwayat-table">
                             <thead><tr><th>Tanggal</th><th>Jumlah</th><th>Metode</th><th>Tipe</th></tr></thead>
                             <tbody>`;
                data.payments.forEach(p => {
                    html += `<tr><td>${p.tanggal}</span></td><td>${formatRupiah(p.jumlah)}</span></td><td>${p.metode}</span></td><td>${p.tipe}</span></tr>`;
                });
                html += `</tbody></table>`;
            }
            
            body.innerHTML = html;
        })
        .catch(err => {
            body.innerHTML = `<div class="alert alert-danger">Gagal memuat detail pesanan: ${err.message}</div>`;
            console.error(err);
        });
}

function closeModal() {
    document.getElementById('customModal').style.display = 'none';
}

// Tutup modal saat klik di luar area modal
window.onclick = function(event) {
    const modal = document.getElementById('customModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>
@endpush