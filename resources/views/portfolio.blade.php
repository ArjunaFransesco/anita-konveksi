@extends('layouts.app')

@section('content')
<section class="portfolio-page">
    <div class="container">
        <div class="portfolio-header-wrap">
            <div class="portfolio-back-wrapper">
                <a href="{{ route('home') }}#layanan" class="btn-about-outline btn-back">
                    <i class="fas fa-arrow-left"></i> <span class="text-kembali">Kembali</span>
                </a>
            </div>
            <h1 class="section-title portfolio-title">Portofolio Produk</h1>
        </div>
        
        <div style="text-align: center; margin-bottom: 2rem;">
            @if($kategori != 'semua')
                <p class="section-subtitle" style="margin: 0 auto;">Menampilkan produk untuk kategori: 
                    <strong>{{ ucfirst(str_replace('-', ' ', $kategori)) }}</strong>
                </p>
            @else
                <p class="section-subtitle" style="margin: 0 auto;">Semua produk unggulan kami</p>
            @endif
        </div>

        <div class="portfolio-grid">
            @forelse($katalogs as $k)
                @if(is_array($k->gambar_list))
                    @foreach($k->gambar_list as $gambar)
                    <a href="https://wa.me/6285331300400?text=Halo%20Anita%20Konveksi,%20saya%20tertarik%20dengan%20produk%20{{ str_replace('-', '%20', $k->kategori) }}%20ini." target="_blank" style="text-decoration: none; color: inherit;">
                        <div class="portfolio-item">
                            <img src="{{ str_starts_with($gambar, 'http') ? $gambar : asset($gambar) }}" alt="{{ $k->judul }}">
                            <div class="portfolio-info">
                                <h3>{{ $k->judul }}</h3>
                                <p>{{ $k->deskripsi ?? 'Kualitas terbaik dari Anita Konveksi' }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                @endif
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--text-muted);">
                    Belum ada portofolio untuk kategori ini.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection