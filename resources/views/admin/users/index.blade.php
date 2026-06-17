@extends('layouts.dashboard')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Kelola akun dan hak akses pengguna sistem')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')

<div class="section-header">
    <div>
        <h2><i class="fas fa-user-cog" style="color:var(--accent); margin-right:8px;"></i>Manajemen User</h2>
        <p>Kelola akun dan hak akses pengguna sistem Anita Konveksi</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah User
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
        <h3><i class="fas fa-users" style="color:var(--accent); margin-right:6px;"></i> Daftar Pengguna</h3>
        <span class="card-badge">{{ $users->count() }} user</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td style="color:var(--text-muted); font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:34px; height:34px; background:var(--accent-light); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.82rem; font-weight:700; color:var(--accent-dark); flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <span style="font-weight:600;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="color:var(--text-muted);">{{ $user->username }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge badge-dark"><i class="fas fa-shield-alt" style="font-size:0.65rem;"></i> Admin</span>
                        @elseif($user->role === 'kasir')
                            <span class="badge badge-info"><i class="fas fa-cash-register" style="font-size:0.65rem;"></i> Kasir</span>
                        @elseif($user->role === 'owner')
                            <span class="badge badge-warning"><i class="fas fa-crown" style="font-size:0.65rem;"></i> Owner</span>
                        @else
                            <span class="badge badge-dark">{{ ucfirst($user->role) }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @if(Auth::id() !== $user->id && $user->role !== 'owner')
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div><i class="fas fa-user-slash"></i></div>
                            <p>Belum ada data user. <a href="{{ route('admin.users.create') }}" style="color:var(--accent);">Tambah sekarang</a>.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection