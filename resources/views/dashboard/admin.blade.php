@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle')
Tugas Hari ini — {{ \Carbon\Carbon::now()->isoFormat("D MMMM YYYY") }}
@endsection

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')

{{-- Page Header --}}
<div class="section-header">
    <div>
        <h2>Selamat datang, {{ Auth::user()->name }}</h2>
        <p>Ringkasan operasional bisnis Anita Konveksi — {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
    </div>
</div>

{{-- Stats Cards --}}
<div class="stats-grid">
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
        <div class="stat-value">{{ $totalPesananAktif }}</div>
        <div class="stat-label">Pesanan Aktif</div>
    </div>
    <div class="stat-card dark">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-value">{{ $totalPegawai }}</div>
        <div class="stat-label">Pegawai Aktif</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-value">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
        <div class="stat-label">Pendapatan Bulan Ini</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-value">{{ $pesananMenunggu }}</div>
        <div class="stat-label">Pesanan Belum Lunas</div>
    </div>
</div>

{{-- Bottom Two Cards --}}
<div class="cards-grid">

    {{-- Pesanan Terbaru --}}
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-clipboard-list" style="color:var(--accent); margin-right:6px;"></i> Pesanan Terbaru</h3>
            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline btn-sm">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div style="overflow-x:auto;">
            @if($recentOrders->isEmpty())
                <div class="empty-state" style="padding:2rem; text-align:center;">
                    <i class="fas fa-inbox" style="font-size:2rem; color:var(--text-muted);"></i>
                    <p style="margin-top:.5rem; color:var(--text-muted);">Belum ada pesanan.</p>
                </div>
            @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    @php
                        $sp = $order->status_produksi;
                        $badgeClass = match(true) {
                            in_array($sp, ['nunggu_konfirmasi','menunggu_bahan'])           => 'badge-warning',
                            in_array($sp, ['proses_potong','proses_jahit','proses_sablon_bordir']) => 'badge-info',
                            $sp === 'quality_control'                                       => 'badge-info',
                            $sp === 'siap_diambil'                                          => 'badge-success',
                            $sp === 'selesai'                                               => 'badge-success',
                            default                                                         => 'badge-warning',
                        };
                    @endphp
                    <tr>
                        <td style="font-weight:600; color:var(--accent);">{{ $order->invoice_number }}</td>
                        <td>{{ $order->customer->nama }}</td>
                        <td>{{ $order->details->first()?->jenis_produk ?? '-' }}</td>
                        <td><span class="badge {{ $badgeClass }}">{{ $order->status_label }}</span></td>
                        <td style="font-weight:600;">Rp {{ number_format($order->total_setelah_diskon, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    {{-- Jadwal Penggajian --}}
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-money-check-alt" style="color:var(--accent); margin-right:6px;"></i> Jadwal Penggajian</h3>
            <span class="card-badge">Minggu ini</span>
        </div>
        <div class="card-body">
            @forelse($jadwalGaji as $pegawai)
            @php
                $initials = collect(explode(' ', $pegawai->name))->map(fn($w)=>strtoupper($w[0]))->take(2)->join('');
            @endphp
            <div class="payroll-item">
                <div class="pi-left">
                    <div class="pi-avatar">{{ $initials }}</div>
                    <div>
                        <div class="pi-name">{{ $pegawai->name }}</div>
                        <div class="pi-position">{{ $pegawai->position }}</div>
                    </div>
                </div>
                <div>
                    <div class="pi-amount">Rp {{ number_format($pegawai->salary_rate, 0, ',', '.') }}</div>
                    <div style="font-size:0.72rem; color:var(--text-muted); text-align:right;">
                        {{ $pegawai->employee_type === 'harian' ? 'Harian' : 'Mingguan' }}
                    </div>
                </div>
            </div>
            @empty
            <div style="padding:1.5rem; text-align:center; color:var(--text-muted);">
                <i class="fas fa-users-slash" style="font-size:1.5rem;"></i>
                <p style="margin-top:.5rem;">Belum ada pegawai aktif.</p>
            </div>
            @endforelse
        </div>
        <div style="padding: 0.9rem 1.25rem; border-top: 1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:0.8rem; color:var(--text-muted);">Total gaji minggu ini</span>
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="font-family:'Montserrat',sans-serif; font-weight:800; font-size:1rem; color:var(--primary);">
                    Rp {{ number_format($totalGajiMingguIni, 0, ',', '.') }}
                </span>
                <a href="{{ route('admin.penggajian.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-money-bill-wave"></i> Proses Penggajian
                </a>
            </div>
        </div>
    </div>

</div>

@endsection