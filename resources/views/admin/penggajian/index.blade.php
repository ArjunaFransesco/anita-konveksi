@extends('layouts.dashboard')

@section('title', 'Kelola Penggajian')
@section('page-title', 'Kelola Penggajian')
@section('page-subtitle', 'Manajemen penggajian seluruh pegawai Anita Konveksi')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@push('styles')
<style>
    .filter-bar {
        background: #fff;
        padding: 1rem;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        margin-bottom: 1rem;
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
        border: 1px solid var(--border);
    }
    .filter-bar input,
    .filter-bar select {
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: 'Inter', sans-serif;
    }
    .initials-circle {
        width: 32px; height: 32px; 
        background: var(--accent-light); 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 0.8rem; 
        font-weight: 700; 
        color: var(--accent-dark); 
        flex-shrink: 0;
    }
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        display: none; align-items: center; justify-content: center;
        z-index: 1000;
    }
    .modal-box {
        background: #fff; border-radius: var(--radius-md);
        padding: 1.5rem; width: 400px; max-width: 90%;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
    .modal-header h3 { font-size: 1.1rem; margin: 0; }
    .btn-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #999; }
</style>
@endpush

@section('dashboard-content')

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

<div class="section-header">
    <div>
        <h2><i class="fas fa-money-bill-wave" style="color:var(--accent); margin-right:8px;"></i>Kelola Penggajian</h2>
        <p>Manajemen penggajian mingguan & bulanan</p>
    </div>
</div>

{{-- Summary cards --}}
<div class="stats-grid" style="grid-template-columns: repeat(3,1fr); margin-bottom:1.25rem;">
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-value">{{ $totalPegawai }}</div>
        <div class="stat-label">Total Pegawai (Aktif)</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-calendar-week"></i></div>
        <div class="stat-value">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</div>
        <div class="stat-label">Total Gaji Dibayar (Bulan Ini)</div>
    </div>
    <div class="stat-card dark">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-value">{{ $belumDiproses }}</div>
        <div class="stat-label">Belum Diproses (Periode Ini)</div>
    </div>
</div>

<div class="content-card">
    <form method="GET" action="{{ route('admin.penggajian.index') }}" class="filter-bar">
        <input type="month" name="bulan" value="{{ $bulan }}" required>
        <select name="minggu_ke">
            @for($i=1; $i<=5; $i++)
                <option value="{{ $i }}" {{ $minggu_ke == $i ? 'selected' : '' }}>Minggu ke-{{ $i }}</option>
            @endfor
        </select>
        <select name="tipe">
            <option value="">Semua Tipe</option>
            <option value="harian" {{ $tipe == 'harian' ? 'selected' : '' }}>Harian</option>
            <option value="mingguan" {{ $tipe == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
            <option value="borongan" {{ $tipe == 'borongan' ? 'selected' : '' }}>Borongan</option>
        </select>
        <button type="submit" class="btn btn-dark"><i class="fas fa-filter"></i> Filter</button>
    </form>

    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>Posisi</th>
                    <th>Tipe Gaji</th>
                    <th>Hari Kerja</th>
                    <th>Rate</th>
                    <th>Total Gaji</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penggajians as $i => $gaji)
                @php 
                    $emp = $gaji->employee; 
                    $initials = strtoupper(substr($emp->name, 0, 2));
                @endphp
                <tr>
                    <td style="color:var(--text-muted); font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="initials-circle">{{ $initials }}</div>
                            <span style="font-weight:600;">{{ $emp->name }}</span>
                        </div>
                    </td>
                    <td>{{ $emp->position ?? '-' }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($emp->employee_type) }}</span></td>
                    <td>{{ $gaji->hari_kerja }} hari</td>
                    <td>Rp {{ number_format($emp->salary_rate, 0, ',', '.') }}</td>
                    <td style="font-weight:700; color:var(--primary);">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                    <td>
                        @if($gaji->status === 'dibayar')
                            <span class="badge badge-success">Dibayar</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            @if($gaji->status === 'pending')
                                <button type="button" class="btn btn-primary btn-sm" onclick="openProsesModal({{ $gaji->id }}, '{{ $emp->name }}', {{ $gaji->hari_kerja }})">
                                    <i class="fas fa-check"></i> Proses
                                </button>
                            @else
                                <a href="{{ route('admin.penggajian.cetak', $gaji->id) }}" class="btn btn-outline btn-sm">
                                    <i class="fas fa-print"></i> Cetak
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding: 2rem;">Tidak ada data pegawai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Proses Penggajian --}}
<div class="modal-overlay" id="prosesModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Proses Penggajian</h3>
            <button class="btn-close" onclick="closeProsesModal()"><i class="fas fa-times"></i></button>
        </div>
        <form id="formProses" method="POST" action="">
            @csrf
            <p style="margin-bottom: 15px; font-size: 0.9rem; color: #555;">
                Proses gaji untuk <strong id="modalEmpName"></strong>. Silakan konfirmasi jumlah hari kerja.
            </p>
            <div style="margin-bottom: 1rem;">
                <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); margin-bottom:5px;">Hari Kerja</label>
                <input type="number" step="0.5" min="0" name="hari_kerja" id="modalHariKerja" class="form-input" style="width:100%; padding:8px;" required>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="closeProsesModal()">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan & Proses</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openProsesModal(gajiId, empName, hariKerja) {
        document.getElementById('prosesModal').style.display = 'flex';
        document.getElementById('modalEmpName').textContent = empName;
        document.getElementById('modalHariKerja').value = hariKerja;
        
        let url = "{{ route('admin.penggajian.proses', ':id') }}";
        url = url.replace(':id', gajiId);
        document.getElementById('formProses').action = url;
    }

    function closeProsesModal() {
        document.getElementById('prosesModal').style.display = 'none';
    }
</script>
@endpush
