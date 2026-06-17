@extends('layouts.dashboard')

@section('title', 'Catat Pembayaran')
@section('page-title', 'Catat Pembayaran')
@section('page-subtitle', 'Input DP atau pelunasan dari pelanggan')

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@push('styles')
<style>
    .pay-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        align-items: start;
    }
    .pay-layout > div { min-width: 0; }
    @media (max-width: 900px) { .pay-layout { grid-template-columns: 1fr; } }

    .pay-card {
        background: #fff;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .pay-card-header {
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
    .pay-card-header i { color: var(--accent); }
    .pay-card-body { padding: 1.25rem; }

    .field-group { display: flex; flex-direction: column; gap: 4px; margin-bottom: 1rem; }
    .field-group label {
        font-size: 0.74rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .field-group .form-input,
    .field-group .form-select {
        width: 100%;
        padding: 9px 12px;
        font-size: 0.85rem;
    }
    .field-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

    /* Order summary box */
    .order-summary {
        background: #F8F9FA;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border);
        padding: 1rem;
        margin-bottom: 1rem;
        display: none;
    }
    .order-summary.active { display: block; }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 0;
        font-size: 0.83rem;
        border-bottom: 1px dashed var(--border);
    }
    .summary-row:last-child { border-bottom: none; }
    .summary-row .label { color: var(--text-muted); }
    .summary-row .value { font-weight: 700; color: var(--primary); }
    .summary-row.sisa .value { color: #dc3545; font-size: 1rem; }
    .summary-row.lunas .value { color: #28a745; }

    /* Payment history */
    .payment-item {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 0.85rem 1rem;
        margin-bottom: 0.6rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .payment-item .pi-left .pi-label { font-weight: 700; font-size: 0.85rem; color: var(--primary); }
    .payment-item .pi-left .pi-sub { font-size: 0.75rem; color: var(--text-muted); margin-top: 2px; }
    .payment-item .pi-amount { font-family: 'Montserrat', sans-serif; font-weight: 700; color: var(--primary); }

    .sisa-box {
        background: #FFF3CD;
        border: 1px solid #FFE69C;
        border-radius: var(--radius-sm);
        padding: 0.85rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .sisa-box .sb-label { font-size: 0.8rem; font-weight: 700; color: #856404; }
    .sisa-box .sb-amount { font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 800; color: #856404; }
    .lunas-box {
        background: rgba(40,167,69,0.1);
        border: 1px solid rgba(40,167,69,0.3);
        border-radius: var(--radius-sm);
        padding: 0.85rem 1rem;
        text-align: center;
        font-weight: 700;
        color: #28a745;
        font-size: 0.9rem;
    }

    .empty-history {
        text-align: center;
        padding: 2rem;
        color: var(--text-muted);
        font-size: 0.85rem;
    }
    .empty-history i { font-size: 2rem; opacity: 0.2; display: block; margin-bottom: 0.75rem; }
    /* Responsive Layout */
    @media (max-width: 900px) {
        .pay-layout { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .field-grid-2 { grid-template-columns: 1fr; gap: 0; }
    }
</style>
@endpush

@section('dashboard-content')

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
@endif

<div class="pay-layout">

    {{-- KIRI: Form --}}
    <div class="pay-card">
        <div class="pay-card-header">
            <i class="fas fa-file-invoice-dollar"></i> Form Catat Pembayaran
        </div>
        <div class="pay-card-body">
            <form action="{{ route('owner.pembayaran.store') }}" method="POST" id="formBayar" enctype="multipart/form-data">
            @csrf

            {{-- Pilih pesanan --}}
            <div class="field-group">
                <label>Pilih Pesanan (Invoice / Nama Pelanggan) <span style="color:#dc3545">*</span></label>
                <select name="order_id" id="orderSelect" class="form-select" required onchange="loadOrderDetail(this.value)">
                    <option value="">-- Pilih Pesanan --</option>
                    @foreach($orders as $o)
                        <option value="{{ $o->id }}" {{ (isset($selected) && $selected->id == $o->id) || old('order_id') == $o->id ? 'selected' : '' }}>
                            {{ $o->invoice_number }} — {{ $o->customer->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Summary box --}}
            <div class="order-summary {{ isset($selected) || old('order_id') ? 'active' : '' }}" id="orderSummary">
                <div class="summary-row">
                    <span class="label">Total Harga</span>
                    <span class="value" id="summTotal">-</span>
                </div>
                <div class="summary-row">
                    <span class="label">Sudah Dibayar</span>
                    <span class="value" id="summPaid">-</span>
                </div>
                <div class="summary-row sisa">
                    <span class="label">Sisa Tagihan</span>
                    <span class="value" id="summSisa">-</span>
                </div>
            </div>

            <div class="field-grid-2">
                <div class="field-group">
                    <label>Tipe Pembayaran <span style="color:#dc3545">*</span></label>
                    <select name="tipe" class="form-select" required>
                        <option value="dp"        {{ old('tipe') === 'dp'        ? 'selected' : '' }}>DP</option>
                        <option value="pelunasan"  {{ old('tipe') === 'pelunasan' ? 'selected' : '' }}>Pelunasan</option>
                    </select>
                </div>
                <div class="field-group">
                    <label>Metode <span style="color:#dc3545">*</span></label>
                    <select name="metode" class="form-select" required>
                        <option value="tunai"    {{ old('metode') === 'tunai'    ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ old('metode') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>
            </div>

            <div class="field-grid-2">
                <div class="field-group">
                    <label>Jumlah Bayar (Rp) <span style="color:#dc3545">*</span></label>
                    <input type="number" name="jumlah" class="form-input" placeholder="0" min="1" value="{{ old('jumlah') }}" required>
                </div>
                <div class="field-group">
                    <label>Tanggal Bayar <span style="color:#dc3545">*</span></label>
                    <input type="date" name="tanggal_bayar" class="form-input" value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="field-group">
                <label>Catatan (Opsional)</label>
                <input type="text" name="catatan" class="form-input" placeholder="Cth: Pembayaran tahap 2" value="{{ old('catatan') }}">
            </div>

            <div class="field-group">
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
            // Auto add one input on load
            document.addEventListener('DOMContentLoaded', function() {
                addBuktiInput();
            });
            </script>

            <div style="display:flex; gap:10px; margin-top:0.5rem;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('owner.dashboard') }}" class="btn btn-outline"><i class="fas fa-times"></i> Batal</a>
            </div>

            </form>
        </div>
    </div>

    {{-- KANAN: Riwayat Pembayaran --}}
    <div class="pay-card">
        <div class="pay-card-header">
            <i class="fas fa-history"></i> Riwayat Pembayaran
            <span id="riwayatInvoice" style="font-size:0.75rem; font-weight:400; color:rgba(255,255,255,0.6); margin-left:auto;"></span>
        </div>
        <div class="pay-card-body" id="riwayatBody">

            @if(isset($selected))
                @php $totalBayar = $selected->payments->sum('jumlah'); @endphp
                @forelse($selected->payments as $p)
                    <div class="payment-item">
                        <div class="pi-left">
                            <div class="pi-label">
                                {{ $p->tipe === 'dp' ? 'DP' : 'Pelunasan' }}
                                <span class="badge {{ $p->metode === 'tunai' ? 'badge-dark' : 'badge-info' }}" style="margin-left:4px;">{{ ucfirst($p->metode) }}</span>
                            </div>
                            <div class="pi-sub">
                                {{ $p->tanggal_bayar->format('d M Y') }}{{ $p->catatan ? ' · '.$p->catatan : '' }}
                                @if(!empty($p->bukti_transfer_array))
                                    @foreach($p->bukti_transfer_array as $index => $bukti)
                                         <a href="{{ file_exists(public_path($bukti)) ? asset($bukti) : asset('storage/' . $bukti) }}" target="_blank" style="color:var(--accent-dark); font-weight:700;">Lihat Bukti {{ count($p->bukti_transfer_array) > 1 ? $index + 1 : '' }}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="pi-amount">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</div>
                    </div>
                @empty
                    <div class="empty-history"><i class="fas fa-receipt"></i> Belum ada pembayaran</div>
                @endforelse

                @if($selected->status_pembayaran === 'lunas')
                    <div class="lunas-box"><i class="fas fa-check-circle"></i> LUNAS</div>
                @else
                    <div class="sisa-box">
                        <span class="sb-label">Sisa Tagihan</span>
                        <span class="sb-amount">Rp {{ number_format($selected->sisa_tagihan, 0, ',', '.') }}</span>
                    </div>
                @endif
            @else
                <div class="empty-history">
                    <i class="fas fa-hand-point-left"></i>
                    Pilih pesanan di sebelah kiri untuk melihat riwayat pembayaran.
                </div>
            @endif

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
const ajaxBase = "{{ route('owner.pembayaran.order', '__ID__') }}".replace('__ID__', '');
const headers  = { 'X-Requested-With': 'XMLHttpRequest' };

function formatRp(n) {
    return 'Rp ' + parseFloat(n).toLocaleString('id-ID', { minimumFractionDigits: 0 });
}

let sisaTagihanGlobal = 0;

function loadOrderDetail(id) {
    if (!id) {
        document.getElementById('orderSummary').classList.remove('active');
        document.getElementById('riwayatBody').innerHTML = `
            <div class="empty-history">
                <i class="fas fa-hand-point-left"></i>
                Pilih pesanan untuk melihat riwayat pembayaran.
            </div>`;
        document.getElementById('riwayatInvoice').textContent = '';
        sisaTagihanGlobal = 0;
        updateTipePembayaranState();
        return;
    }

    fetch(ajaxBase + id, { headers })
        .then(r => r.json())
        .then(data => {
            sisaTagihanGlobal = parseFloat(data.sisa_tagihan);
            
            // Update summary
            const totalBayar = data.payments.reduce((s, p) => s + parseFloat(p.jumlah), 0);
            document.getElementById('summTotal').textContent = formatRp(data.total_harga);
            document.getElementById('summPaid').textContent  = formatRp(totalBayar);
            document.getElementById('summSisa').textContent  = formatRp(data.sisa_tagihan);
            document.getElementById('orderSummary').classList.add('active');

            // Update invoice label
            document.getElementById('riwayatInvoice').textContent = data.invoice;

            // Build riwayat
            let html = '';
            if (data.payments.length === 0) {
                html = `<div class="empty-history"><i class="fas fa-receipt"></i> Belum ada pembayaran</div>`;
            } else {
                data.payments.forEach(p => {
                    const tipeLabel  = p.tipe === 'dp' ? 'DP' : 'Pelunasan';
                    const metodeClass = p.metode === 'tunai' ? 'badge-dark' : 'badge-info';
                    html += `
                    <div class="payment-item">
                        <div class="pi-left">
                            <div class="pi-label">
                                ${tipeLabel}
                                <span class="badge ${metodeClass}" style="margin-left:4px;">${p.metode.charAt(0).toUpperCase()+p.metode.slice(1)}</span>
                            </div>
                            <div class="pi-sub">${p.tanggal}${p.bukti ? ` · <a href="${p.bukti}" target="_blank" style="color:var(--accent-dark); font-weight:700;">Lihat Bukti</a>` : ''}</div>
                        </div>
                        <div class="pi-amount">${formatRp(p.jumlah)}</div>
                    </div>`;
                });
            }

            if (data.status_pembayaran === 'lunas') {
                html += `<div class="lunas-box"><i class="fas fa-check-circle"></i> LUNAS</div>`;
            } else {
                html += `
                <div class="sisa-box">
                    <span class="sb-label">Sisa Tagihan</span>
                    <span class="sb-amount">${formatRp(data.sisa_tagihan)}</span>
                </div>`;
            }
            document.getElementById('riwayatBody').innerHTML = html;
            
            updateTipePembayaranState();
        })
        .catch(() => {
            document.getElementById('riwayatBody').innerHTML =
                `<div class="empty-history">Gagal memuat data.</div>`;
        });
}

function updateTipePembayaranState() {
    const tipeSelect = document.querySelector('select[name="tipe"]');
    const jumlahInput = document.querySelector('input[name="jumlah"]');
    if (tipeSelect && jumlahInput) {
        if (tipeSelect.value === 'pelunasan') {
            jumlahInput.value = sisaTagihanGlobal;
            // Tidak dilock (readonly = false) agar user tetap bisa mengubahnya jika mau
            jumlahInput.readOnly = false;
            jumlahInput.style.backgroundColor = '#fff';
        } else {
            if (jumlahInput.value == sisaTagihanGlobal && sisaTagihanGlobal > 0) {
                jumlahInput.value = '';
            }
            jumlahInput.readOnly = false;
            jumlahInput.style.backgroundColor = '#fff';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const tipeSelect = document.querySelector('select[name="tipe"]');
    if (tipeSelect) {
        tipeSelect.addEventListener('change', updateTipePembayaranState);
    }
});

// Auto-load jika ada selected dari server-side
@if(isset($selected))
    loadOrderDetail({{ $selected->id }});
@endif
</script>
@endpush
