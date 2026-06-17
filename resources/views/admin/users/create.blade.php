@extends('layouts.dashboard')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User Baru')
@section('page-subtitle', 'Buat akun pengguna sistem baru')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')

<div class="section-header">
    <div>
        <h2><i class="fas fa-user-plus" style="color:var(--accent); margin-right:8px;"></i>Tambah User Baru</h2>
        <p>Buat akun pengguna baru dan tentukan hak aksesnya</p>
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
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Nama Lengkap *</label>
                <input type="text" name="name" class="form-input" style="width:100%;" placeholder="Nama pengguna" value="{{ old('name') }}" required>
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Username *</label>
                <input type="text" name="username" class="form-input" style="width:100%;" placeholder="Username untuk login" value="{{ old('username') }}" required>
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Password *</label>
                <input type="password" name="password" class="form-input" style="width:100%;" placeholder="Min. 8 karakter" required>
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Role / Hak Akses *</label>
                <select name="role" class="form-select" style="width:100%;" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin"  {{ old('role')=='admin'  ?'selected':'' }}>Admin</option>
                    <option value="owner"  {{ old('role')=='owner'  ?'selected':'' }}>Owner</option>
                </select>
            </div>
            <div style="display:flex; gap:10px; padding-top:0.5rem; border-top:1px solid var(--border);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Buat Akun
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection