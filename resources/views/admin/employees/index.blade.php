@extends('layouts.dashboard')

@section('title', 'Kelola Pegawai')
@section('page-title', 'Daftar Pegawai')
@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')
<div style="display: flex; justify-content: space-between; margin-bottom:20px;">
    <h3>Data Pegawai</h3>
    <a href="{{ route('admin.employees.create') }}" class="btn-primary">+ Tambah Pegawai</a>
</div>
@if(session('success')) ... @endif
<table class="table">
    <thead>
        <tr><th>Nama</th><th>Posisi</th><th>Tipe</th><th>Rate</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
        @foreach($employees as $emp)
        <tr>
            <td>{{ $emp->name }}</td>
            <td>{{ $emp->position }}</td>
            <td>{{ ucfirst($emp->employee_type) }}</td>
            <td>Rp {{ number_format($emp->salary_rate,0) }}</td>
            <td>{{ $emp->is_active ? 'Aktif' : 'Nonaktif' }}</td>
            <td>
                <a href="{{ route('admin.employees.edit', $emp) }}">Edit</a>
                <form action="{{ route('admin.employees.destroy', $emp) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection