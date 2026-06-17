@extends('layouts.dashboard')

@section('title', 'Dashboard Owner')
@section('page-title', 'Selamat Datang, Owner!')
@section('page-subtitle')
Dashboard Utama Anita Konveksi — {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
@endsection

@section('sidebar-menu')
    @include('owner.sidebar')
@endsection

@push('styles')
<style>
    .chart-wrapper {
        position: relative;
        height: 280px;
        padding: 0 0.5rem;
    }
    .transaksi-table .status-pill {
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
</style>
@endpush

@section('dashboard-content')

{{-- Stat Cards Keuangan --}}
<h3 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: var(--primary); margin: 0 0 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;"><i class="fas fa-wallet" style="color:var(--accent); margin-right:6px;"></i> Ringkasan Keuangan</h3>
<div class="stats-grid" style="margin-bottom: 1.5rem;">
    <div class="stat-card dark">
        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        <div class="stat-value">Rp {{ number_format($totalOmset, 0, ',', '.') }}</div>
        <div class="stat-label">Total Omset Bulan Ini</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-hand-holding-usd"></i></div>
        <div class="stat-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
        <div class="stat-label">Pemasukan Bulan Ini</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        <div class="stat-label">Pengeluaran + Penggajian</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-scale-balanced"></i></div>
        <div class="stat-value">Rp {{ number_format($labaBersih, 0, ',', '.') }}</div>
        <div class="stat-label">Laba / Rugi Bulan Ini</div>
    </div>
</div>

{{-- Stat Cards Operasional --}}
<h3 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: var(--primary); margin: 1.5rem 0 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;"><i class="fas fa-tasks" style="color:var(--accent); margin-right:6px;"></i> Ringkasan Operasional & Produksi</h3>
<div class="stats-grid" style="margin-bottom: 1.5rem;">
    <div class="stat-card dark">
        <div class="stat-icon"><i class="fas fa-folder-open"></i></div>
        <div class="stat-value">{{ $opTotalPesanan }}</div>
        <div class="stat-label">Total Semua Pesanan</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-file-invoice-dollar"></i></div>
        <div class="stat-value">{{ $opMenungguDP }}</div>
        <div class="stat-label">Belum Lunas / Menunggu DP</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-shipping-fast"></i></div>
        <div class="stat-value">{{ $opSiapDiambil }}</div>
        <div class="stat-label">Pesanan Siap Diambil</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-check-double"></i></div>
        <div class="stat-value">{{ $opSelesai }}</div>
        <div class="stat-label">Pesanan Selesai</div>
    </div>
</div>


<div class="content-card" style="margin-bottom: 1.5rem;">
    <div class="card-body" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:.78rem; color:var(--text-muted); font-weight:600; text-transform:uppercase;">Pesanan Bulan Ini</div>
            <div style="font-size:1.25rem; font-weight:800; color:var(--text-main);">{{ $totalPesananBulanIni }} Pesanan</div>
        </div>
        <div>
            <div style="font-size:.78rem; color:var(--text-muted); font-weight:600; text-transform:uppercase;">Piutang Belum Lunas</div>
            <div style="font-size:1.25rem; font-weight:800; color:#dc3545;">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</div>
        </div>
        <div>
            <a href="{{ route('owner.laporan') }}" class="btn btn-dark btn-sm"><i class="fas fa-file-alt"></i> Lihat Laporan</a>
        </div>
    </div>
</div>

{{-- Grafik + Ringkasan Transaksi --}}
<div class="cards-grid">

    {{-- Grafik Pemasukan & Pengeluaran --}}
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-chart-area" style="color:var(--accent); margin-right:6px;"></i> Grafik Keuangan (6 Bulan)</h3>
        </div>
        <div class="card-body">
            <div class="chart-wrapper">
                <canvas id="keuanganChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Ringkasan Transaksi Terbaru --}}
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-receipt" style="color:var(--accent); margin-right:6px;"></i> Ringkasan Transaksi Terbaru</h3>
            <a href="{{ route('owner.transaksi') }}" class="btn btn-outline btn-sm">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div style="overflow-x:auto;" class="transaksi-table">
            @if($recentTransaksi->isEmpty())
                <div style="padding:2rem; text-align:center; color:var(--text-muted);">
                    <i class="fas fa-inbox" style="font-size:2rem;"></i>
                    <p style="margin-top:.5rem;">Belum ada transaksi.</p>
                </div>
            @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Sisa</th>
                        <th>Status Produksi</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransaksi as $order)
                    @php
                        $sp = $order->status_produksi;
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
                        <td style="font-weight:700; color:var(--accent);">{{ $order->invoice_number }}</td>
                        <td>{{ $order->customer->nama }}</td>
                        <td>{{ $order->tanggal_pesan->format('d M Y') }}</td>
                        <td style="font-weight:600;">Rp {{ number_format($order->total_setelah_diskon, 0, ',', '.') }}</td>
                        <td class="{{ $order->sisa_tagihan > 0 ? 'text-danger-fw' : 'text-success-fw' }}">
                            {{ $order->sisa_tagihan > 0 ? 'Rp '.number_format($order->sisa_tagihan, 0, ',', '.') : 'Lunas' }}
                        </td>
                        <td><span class="status-pill {{ $pillClass }}">{{ $order->status_label }}</span></td>
                        <td><span class="status-pill {{ $order->status_pembayaran === 'lunas' ? 'pay-lunas' : 'pay-belum' }}">
                            {{ $order->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum' }}
                        </span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels      = @json($chartLabels);
    const pemasukan   = @json($chartPemasukan);
    const pengeluaran = @json($chartPengeluaran);
    const labaRugi    = @json($chartLabaRugi);

    const ctx = document.getElementById('keuanganChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: pemasukan,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40,167,69,0.12)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#28a745',
                    pointRadius: 5,
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'Pengeluaran + Penggajian',
                    data: pengeluaran,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253,126,20,0.10)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#fd7e14',
                    pointRadius: 5,
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'Laba / Rugi',
                    data: labaRugi,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.08)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#0d6efd',
                    pointRadius: 5,
                    fill: false,
                    tension: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { font: { family: "'Inter', sans-serif", size: 12 } }
                },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            let val = ctx.parsed.y;
                            return ' Rp ' + val.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(val) {
                            if (val >= 1000000) return 'Rp ' + (val/1000000).toFixed(1) + 'Jt';
                            if (val >= 1000)    return 'Rp ' + (val/1000).toFixed(0) + 'Rb';
                            return 'Rp ' + val;
                        },
                        font: { family: "'Inter', sans-serif", size: 11 }
                    },
                    grid: { color: 'rgba(0,0,0,0.06)' }
                },
                x: {
                    ticks: { font: { family: "'Inter', sans-serif", size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endpush