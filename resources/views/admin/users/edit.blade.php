@extends('layouts.dashboard')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('page-subtitle', 'Perbarui akun pengguna sistem dan hak aksesnya')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')

<div class="section-header">
    <div>
        <h2><i class="fas fa-user-edit" style="color:var(--accent); margin-right:8px;"></i>Edit Data User</h2>
        <p>Perbarui informasi akun <strong>{{ $user->username }}</strong></p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i>
    <div><strong>Terdapat kesalahan:</strong><br>
        @foreach($errors->all() as $e)<span>• {{ $e }}</span><br>@endforeach
    </div>
</div>
@endif

<div class="content-card" style="max-width: 520px;">
    <div class="card-header">
        <h3><i class="fas fa-user-shield" style="color:var(--accent); margin-right:6px;"></i> Informasi Akun</h3>
        <span class="card-badge">ID #{{ $user->id }}</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf @method('PUT')
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Nama Lengkap *</label>
                <input type="text" name="name" class="form-input" style="width:100%;" value="{{ old('name', $user->name) }}" required>
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Username *</label>
                <input type="text" name="username" class="form-input" style="width:100%;" value="{{ old('username', $user->username) }}" required>
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Password Baru</label>
                <input type="password" name="password" class="form-input" style="width:100%;" placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Role / Hak Akses *</label>
                <select name="role" class="form-select" style="width:100%;" required>
                    <option value="admin" {{ old('role', $user->role)=='admin' ? 'selected' : '' }}>Admin</option>
                    <option value="owner" {{ old('role', $user->role)=='owner' ? 'selected' : '' }}>Owner</option>
                </select>
            </div>
            <div style="display:flex; gap:10px; padding-top:0.5rem; border-top:1px solid var(--border);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection