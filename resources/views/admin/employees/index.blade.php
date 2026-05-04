@extends('layouts.dashboard')

@section('title', 'Kelola Pegawai')
@section('page-title', 'Kelola Pegawai')
@section('page-subtitle')
{{ $employees->count() }} Pegawai aktif dalam sistem
@endsection

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')

<div class="section-header">
    <div>
        <h2><i class="fas fa-users" style="color:var(--accent); margin-right:8px;"></i>Kelola Pegawai</h2>
        <p>{{ $employees->count() }} Pegawai aktif terdaftar dalam sistem</p>
    </div>
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Pegawai
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

<div class="content-card">
    <div class="card-header">
        <h3><i class="fas fa-list" style="color:var(--accent); margin-right:6px;"></i> Daftar Pegawai</h3>
        <span class="card-badge">{{ $employees->count() }} data</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>Posisi</th>
                    <th>Tipe</th>
                    <th>Rate / Hari</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $i => $emp)
                <tr>
                    <td style="color:var(--text-muted); font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:34px; height:34px; background:var(--accent-light); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.82rem; font-weight:700; color:var(--accent-dark); flex-shrink:0;">
                                {{ strtoupper(substr($emp->name, 0, 2)) }}
                            </div>
                            <span style="font-weight:600;">{{ $emp->name }}</span>
                        </div>
                    </td>
                    <td>{{ $emp->position }}</td>
                    <td><span class="badge badge-dark">{{ ucfirst($emp->employee_type) }}</span></td>
                    <td style="font-weight:600; color:var(--primary);">Rp {{ number_format($emp->salary_rate, 0, ',', '.') }}</td>
                    <td>
                        @if($emp->is_active)
                            <span class="badge badge-success"><i class="fas fa-circle" style="font-size:0.55rem;"></i> Aktif</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-circle" style="font-size:0.55rem;"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.employees.edit', $emp) }}" class="btn btn-outline btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.employees.destroy', $emp) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div><i class="fas fa-users-slash"></i></div>
                            <p>Belum ada data pegawai. <a href="{{ route('admin.employees.create') }}" style="color:var(--accent);">Tambah sekarang</a>.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection