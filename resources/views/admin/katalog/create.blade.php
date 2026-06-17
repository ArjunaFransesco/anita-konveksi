@extends('layouts.dashboard')

@section('title', 'Tambah Katalog')
@section('page-title', 'Tambah Katalog Baru')
@section('page-subtitle', 'Buat kategori katalog portofolio baru')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')
<div class="section-header">
    <div>
        <h2><i class="fas fa-plus-circle" style="color:var(--accent); margin-right:8px;"></i>Tambah Katalog</h2>
        <p>Silakan isi informasi kategori portofolio di bawah ini</p>
    </div>
</div>

<div class="content-card" style="max-width: 800px;">
    <div class="card-header">
        <h3><i class="fas fa-images" style="color:var(--accent); margin-right:6px;"></i> Data Katalog</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Kategori (URL Slug) *</label>
                <input type="text" name="kategori" class="form-input" required placeholder="Contoh: seragam-sekolah, jaket, pdl" value="{{ old('kategori') }}" style="width:100%;">
                @error('kategori')<span class="text-danger" style="font-size: 0.8rem; display:block; margin-top:4px;">{{ $message }}</span>@enderror
                <p class="text-muted" style="font-size: 0.8rem; margin-top: 5px;">Gunakan huruf kecil dan strip. Ini akan menjadi URL.</p>
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Judul Tampilan *</label>
                <input type="text" name="judul" class="form-input" required placeholder="Contoh: Seragam Sekolah Premium" value="{{ old('judul') }}" style="width:100%;">
                @error('judul')<span class="text-danger" style="font-size: 0.8rem; display:block; margin-top:4px;">{{ $message }}</span>@enderror
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Deskripsi Singkat (Opsional)</label>
                <textarea name="deskripsi" class="form-input" rows="3" placeholder="Keterangan mengenai portofolio ini" style="width:100%; min-height:80px; resize:vertical;">{{ old('deskripsi') }}</textarea>
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Unggah Gambar <small class="text-muted">(Bisa pilih lebih dari satu)</small></label>
                <input type="file" name="gambar[]" class="form-input" multiple accept="image/*" style="width:100%; padding: 0.5rem; background: rgba(14,35,93,0.02);">
                @error('gambar.*')<span class="text-danger" style="font-size: 0.8rem; display:block; margin-top:4px;">{{ $message }}</span>@enderror
                <p class="text-muted" style="font-size: 0.8rem; margin-top: 5px;"><i class="fas fa-info-circle"></i> Tahan tombol CTRL (Windows) / CMD (Mac) saat memilih untuk menandai banyak gambar sekaligus.</p>
            </div>

            <div style="display:flex; gap:10px; padding-top:0.5rem; border-top:1px solid var(--border); margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Katalog
                </button>
                <a href="{{ route('admin.katalog.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
