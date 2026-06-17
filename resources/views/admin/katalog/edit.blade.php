@extends('layouts.dashboard')

@section('title', 'Edit Katalog')
@section('page-title', 'Ubah Data Katalog')
@section('page-subtitle', 'Perbarui informasi dan kelola foto katalog ini')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('dashboard-content')
<div class="section-header">
    <div>
        <h2><i class="fas fa-edit" style="color:var(--accent); margin-right:8px;"></i>Ubah Katalog</h2>
        <p>Edit informasi kategori <strong>{{ $katalog->judul }}</strong></p>
    </div>
</div>

<div class="content-card" style="max-width: 800px;">
    <div class="card-header">
        <h3><i class="fas fa-images" style="color:var(--accent); margin-right:6px;"></i> Data Katalog</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.katalog.update', $katalog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Kategori (URL Slug) *</label>
                <input type="text" name="kategori" required value="{{ old('kategori', $katalog->kategori) }}" class="form-input" style="width:100%;">
                @error('kategori')<span class="text-danger" style="font-size: 0.8rem; display:block; margin-top:4px;">{{ $message }}</span>@enderror
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Judul Tampilan *</label>
                <input type="text" name="judul" required value="{{ old('judul', $katalog->judul) }}" class="form-input" style="width:100%;">
                @error('judul')<span class="text-danger" style="font-size: 0.8rem; display:block; margin-top:4px;">{{ $message }}</span>@enderror
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" class="form-input" style="width:100%; min-height:80px; resize:vertical;">{{ old('deskripsi', $katalog->deskripsi) }}</textarea>
            </div>

            <div style="margin-bottom:1.5rem; padding: 1rem; border: 1px solid var(--border); border-radius: var(--radius-sm); background: rgba(0,0,0,0.01);">
                <label style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 8px; margin-bottom: 12px; font-size:0.85rem; font-weight:600;">
                    <span>Foto Tersimpan</span>
                    <small class="text-muted"><i class="fas fa-info-circle"></i> Centang kotak merah untuk menghapus foto</small>
                </label>
                
                @if(is_array($katalog->gambar_list) && count($katalog->gambar_list) > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                        @foreach($katalog->gambar_list as $gambar)
                        <div style="position: relative; border: 1px solid var(--border); border-radius: var(--radius-sm); overflow: hidden; padding: 0.5rem; background: #fff;">
                            <img src="{{ str_starts_with($gambar, 'http') ? $gambar : asset($gambar) }}" alt="Gambar Katalog" style="width: 100%; height: 120px; object-fit: cover; border-radius: 4px;">
                            <div style="margin-top: 0.8rem; display: flex; align-items: center; gap: 0.5rem; background: rgba(220,53,69,0.05); padding: 5px; border-radius: 4px;">
                                <input type="checkbox" name="hapus_gambar[]" value="{{ $gambar }}" id="hapus_{{ $loop->index }}" style="width: 16px; height: 16px; accent-color: #dc3545; cursor: pointer;">
                                <label for="hapus_{{ $loop->index }}" style="font-size: 0.75rem; color: #dc3545; cursor: pointer; font-weight: 700; margin: 0;">Hapus Foto</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-muted" style="padding: 1rem; background: rgba(0,0,0,0.02); text-align: center; border-radius: 4px;">
                        <i class="fas fa-image" style="font-size: 1.5rem; display: block; margin-bottom: 5px; opacity: 0.5;"></i>
                        Belum ada foto tersimpan.
                    </div>
                @endif
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text-main); margin-bottom:6px;">Tambah Foto Baru</label>
                <input type="file" name="gambar[]" multiple accept="image/*" class="form-input" style="width:100%; padding: 0.5rem; background: rgba(14,35,93,0.02);">
                @error('gambar.*')<span class="text-danger" style="font-size: 0.8rem; display:block; margin-top:4px;">{{ $message }}</span>@enderror
                <p class="text-muted" style="font-size: 0.8rem; margin-top: 5px;">Pilih banyak file sekaligus jika ingin menambah lebih dari 1 foto.</p>
            </div>

            <div style="display:flex; gap:10px; padding-top:0.5rem; border-top:1px solid var(--border); margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.katalog.index') }}" class="btn btn-outline">Batal Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
