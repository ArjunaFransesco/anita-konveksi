@extends('layouts.app')

@section('content')
<section class="portfolio-page">
    <div class="container">
        <h1 class="section-title">Portofolio Produk</h1>
        @if($kategori != 'semua')
            <p class="section-subtitle">Menampilkan produk untuk kategori: 
                <strong>{{ ucfirst(str_replace('-', ' ', $kategori)) }}</strong>
            </p>
        @else
            <p class="section-subtitle">Semua produk unggulan kami</p>
        @endif

        <div class="portfolio-grid">
            @php
                // Data gambar berdasarkan kategori (minimal 3 gambar)
                $gambarList = [];
                switch($kategori) {
                    case 'seragam-sekolah':
                        $gambarList = [
                            asset('images/portofolio/seragam-sekolah/1.jpg'),
                            asset('images/portofolio/seragam-sekolah/2.jpg'),
                            asset('images/portofolio/seragam-sekolah/3.jpg'),
                            asset('images/portofolio/seragam-sekolah/4.jpg'), // optional
                        ];
                        break;
                    case 'seragam-kantor':
                        $gambarList = [
                            asset('images/portofolio/seragam-kantor/1.jpg'),
                            asset('images/portofolio/seragam-kantor/2.jpg'),
                            asset('images/portofolio/seragam-kantor/3.jpg'),
                        ];
                        break;
                    case 'pdl':
                        $gambarList = [
                            asset('images/portofolio/pdl/1.jpg'),
                            asset('images/portofolio/pdl/2.jpg'),
                            asset('images/portofolio/pdl/3.jpg'),
                        ];
                        break;
                    // Tambahkan case untuk kategori lainnya...
                    default:
                        $gambarList = [
                            'https://placehold.co/600x400?text=Contoh+1',
                            'https://placehold.co/600x400?text=Contoh+2',
                            'https://placehold.co/600x400?text=Contoh+3',
                        ];
                }
            @endphp

            @foreach($gambarList as $gambar)
            <div class="portfolio-item">
                <img src="{{ $gambar }}" alt="Produk {{ $kategori }}">
                <div class="portfolio-info">
                    <h3>{{ ucfirst(str_replace('-', ' ', $kategori)) }}</h3>
                    <p>Kualitas terbaik dari Anita Konveksi</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection