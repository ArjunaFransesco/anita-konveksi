@extends('layouts.dashboard')

@section('title', 'Manajemen Katalog')
@section('page-title', 'Kelola Katalog Portofolio')
@section('page-subtitle', 'Tambah, ubah, dan atur gambar produk portofolio')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')

<div class="section-header">
    <div>
        <h2><i class="fas fa-images" style="color:var(--accent); margin-right:8px;"></i>Manajemen Katalog</h2>
        <p>Kelola seluruh gambar portofolio produk yang tampil di halaman utama</p>
    </div>
    <a href="{{ route('admin.katalog.create') }}" class="btn btn-primary" style="text-decoration: none;">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="content-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Total Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($katalogs as $k)
                <tr>
                    <td><strong>{{ $k->kategori }}</strong></td>
                    <td>{{ $k->judul }}</td>
                    <td>
                        <span style="background: rgba(0,123,255,0.12); color: #0056b3; padding: 0.3rem 0.6rem; border-radius: 20px; font-weight: 600; font-size: 0.75rem;">
                            <i class="fas fa-image"></i> {{ is_array($k->gambar_list) ? count($k->gambar_list) : 0 }} foto
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.katalog.edit', $k->id) }}" class="btn btn-outline" style="padding: 0.3rem 0.6rem; font-size: 0.75rem; text-decoration: none;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.katalog.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini? Semua gambar di dalamnya akan hilang!');" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.3rem 0.6rem; font-size: 0.75rem; border: none; cursor: pointer;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                        <i class="fas fa-folder-open" style="font-size: 2rem; color: var(--border); margin-bottom: 1rem; display: block;"></i>
                        Belum ada katalog portofolio. Silakan tambah baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
