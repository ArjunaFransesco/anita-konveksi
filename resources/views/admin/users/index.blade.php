@extends('layouts.dashboard')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3>Daftar User</h3>
    <a href="{{ route('admin.users.create') }}" class="btn-primary" style="background: #FF9F1C; padding: 8px 16px; border-radius: 6px; text-decoration: none; color: #1A1A1A;">+ Tambah User</a>
</div>
@if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 6px; margin-bottom: 20px;">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 20px;">{{ session('error') }}</div>
@endif
<table style="width:100%; border-collapse: collapse; background: white;">
    <thead>
        <tr><th style="padding: 12px; border-bottom: 1px solid #ddd;">ID</th><th style="padding: 12px; border-bottom: 1px solid #ddd;">Nama</th><th style="padding: 12px; border-bottom: 1px solid #ddd;">Username</th><th style="padding: 12px; border-bottom: 1px solid #ddd;">Role</th><th style="padding: 12px; border-bottom: 1px solid #ddd;">Aksi</th></tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $user->id }}</td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $user->name }}</td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $user->username }}</td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ ucfirst($user->role) }}</td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                <a href="{{ route('admin.users.edit', $user) }}" style="color: #FF9F1C; margin-right: 10px;">Edit</a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none; border:none; color:red; cursor:pointer;">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection