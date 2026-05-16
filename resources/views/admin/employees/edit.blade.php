@extends('layouts.dashboard')

@section('title', 'Edit Pegawai')
@section('page-title', 'Edit Pegawai')
@section('page-subtitle', 'Perbarui data pegawai — {{ $employee->name }}')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')

<div class="section-header">
    <div>
        <h2><i class="fas fa-user-edit" style="color:var(--accent); margin-right:8px;"></i>Edit Data Pegawai</h2>
        <p>Perbarui informasi pegawai <strong>{{ $employee->name }}</strong></p>
    </div>
    <a href="{{ route('admin.employees.index') }}" class="btn btn-outline">
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

<div class="content-card" style="max-width: 700px;">
    <div class="card-header">
        <h3><i class="fas fa-id-card" style="color:var(--accent); margin-right:6px;"></i> Data Pegawai</h3>
        <span class="card-badge">ID #{{ $employee->id }}</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
            @csrf @method('PUT')
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Nama Lengkap *</label>
                    <input type="text" name="name" class="form-input" style="width:100%;" value="{{ old('name', $employee->name) }}" required>
                </div>
                <div>
                    <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Posisi / Jabatan</label>
                    <input type="text" name="position" class="form-input" style="width:100%;" value="{{ old('position', $employee->position) }}">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Tipe Pegawai *</label>
                    <select name="employee_type" class="form-select" style="width:100%;" required>
                        <option value="harian"   {{ old('employee_type',$employee->employee_type)=='harian'  ?'selected':'' }}>Harian</option>
                        <option value="mingguan" {{ old('employee_type',$employee->employee_type)=='mingguan'?'selected':'' }}>Mingguan</option>
                        <option value="borongan" {{ old('employee_type',$employee->employee_type)=='borongan'?'selected':'' }}>Borongan</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Rate / Upah (Rp)</label>
                    <input type="number" name="salary_rate" class="form-input" style="width:100%;" step="1000" value="{{ old('salary_rate', $employee->salary_rate) }}">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">No. HP / WhatsApp</label>
                    <input type="text" name="phone" class="form-input" style="width:100%;" value="{{ old('phone', $employee->phone) }}">
                </div>
                <div>
                    <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Tanggal Bergabung</label>
                    <input type="date" name="join_date" class="form-input" style="width:100%;" value="{{ old('join_date', $employee->join_date) }}">
                </div>
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Alamat</label>
                <textarea name="address" class="form-input" style="width:100%; min-height:80px; resize:vertical;">{{ old('address', $employee->address) }}</textarea>
            </div>
            <div style="display:flex; align-items:center; gap:10px; padding:12px 14px; background:var(--bg-main); border-radius:var(--radius-sm); margin-bottom:1rem;">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ $employee->is_active ? 'checked' : '' }} style="width:16px; height:16px; accent-color:var(--accent);">
                <label for="is_active" style="font-size:0.85rem; font-weight:500; cursor:pointer;">Pegawai dalam status <strong>Aktif</strong></label>
            </div>
            <div style="display:flex; gap:10px; padding-top:0.5rem; border-top:1px solid var(--border);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection