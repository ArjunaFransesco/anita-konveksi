@extends('layouts.dashboard')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User Baru')
@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')
<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <div style="margin-bottom: 15px;">
        <label>Nama Lengkap</label>
        <input type="text" name="name" required style="width:100%; padding:8px; margin-top:5px; border:1px solid #ddd; border-radius:6px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label>Username</label>
        <input type="text" name="username" required style="width:100%; padding:8px; margin-top:5px; border:1px solid #ddd; border-radius:6px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label>Password</label>
        <input type="password" name="password" required style="width:100%; padding:8px; margin-top:5px; border:1px solid #ddd; border-radius:6px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label>Role</label>
        <select name="role" required style="width:100%; padding:8px; margin-top:5px; border:1px solid #ddd; border-radius:6px;">
            <option value="owner">Owner</option>
            <option value="admin">Admin</option>
            <option value="kasir">Kasir</option>
        </select>
    </div>
    <button type="submit" style="background:#FF9F1C; border:none; padding:10px 20px; border-radius:6px; cursor:pointer;">Simpan</button>
    <a href="{{ route('admin.users.index') }}" style="margin-left:10px;">Batal</a>
</form>
@endsection