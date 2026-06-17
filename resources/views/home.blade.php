@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="home" class="hero">
    <div class="light-rays-container" id="hero-light-rays"></div>
    <div class="container">
        <div class="hero-content">
            <h1>Solusi Konveksi Berkualitas<br>untuk Kebutuhan Seragam dan Atribut Profesional</h1>
            <p>Anita Konveksi & Sablon: Solusi Manufaktur Pakaian & Atribut Terpercaya.</p>
            <a href="#layanan" class="btn-cta">Lihat Layanan Kami</a>
        </div>
    </div>
</section>

<!-- Layanan Apparel & Clothing (Full Width) -->
<section id="layanan" class="services full-width">
    <div class="container-fluid">
        <h2 class="section-title scroll-reveal">Apparel & Clothing</h2>
        <p class="section-subtitle scroll-reveal">Menyediakan berbagai kebutuhan konveksi untuk instansi, perusahaan, dan komunitas</p>

        <div class="service-grid">
            <!-- Seragam Sekolah -->
            <a href="{{ route('portfolio', ['kategori' => 'seragam-sekolah']) }}" class="service-card scroll-reveal delay-1">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/seragam-sekolah/thumb.jpg') }}" alt="Seragam Sekolah">
                </div>
                <h3>Seragam Sekolah</h3>
                <p>PAUD, SD, SMP, SMA</p>
                <span class="card-link">Lihat Detail <i class="fas fa-arrow-right"></i></span>
            </a>

            <!-- Seragam Kantor -->
            <a href="{{ route('portfolio', ['kategori' => 'seragam-kantor']) }}" class="service-card scroll-reveal delay-2">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/seragam-kantor/thumb.jpg') }}" alt="Seragam Kantor">
                </div>
                <h3>Seragam Kantor</h3>
                <p>Karyawan, Eksekutif</p>
                <span class="card-link">Lihat Detail <i class="fas fa-arrow-right"></i></span>
            </a>

            <!-- Seragam Drumband -->
            <a href="{{ route('portfolio', ['kategori' => 'seragam-drumband']) }}" class="service-card scroll-reveal delay-3">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/seragam-drumband/thumb.jpg') }}" alt="Seragam Drumband">
                </div>
                <h3>Seragam Drumband</h3>
                <p>Marching band</p>
                <span class="card-link">Lihat Detail <i class="fas fa-arrow-right"></i></span>
            </a>

            <!-- Jas / Almamater -->
            <a href="{{ route('portfolio', ['kategori' => 'jas-almamater']) }}" class="service-card scroll-reveal delay-4">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/jas-almamater/thumb.jpg') }}" alt="Jas Almamater">
                </div>
                <h3>Jas / Almamater</h3>
                <p>Wisuda, organisasi</p>
                <span class="card-link">Lihat Detail <i class="fas fa-arrow-right"></i></span>
            </a>

            <!-- Topi -->
            <a href="{{ route('portfolio', ['kategori' => 'topi']) }}" class="service-card scroll-reveal delay-5">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/topi/thumb.jpg') }}" alt="Topi">
                </div>
                <h3>Topi</h3>
                <p>Custom, branded</p>
                <span class="card-link">Lihat Detail <i class="fas fa-arrow-right"></i></span>
            </a>

            <!-- Jaket -->
            <a href="{{ route('portfolio', ['kategori' => 'jaket']) }}" class="service-card scroll-reveal delay-6">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/jaket/thumb.jpg') }}" alt="Jaket">
                </div>
                <h3>Jaket</h3>
                <p>Jaket komunitas, bomber</p>
                <span class="card-link">Lihat Detail <i class="fas fa-arrow-right"></i></span>
            </a>

            <!-- PDL -->
            <a href="{{ route('portfolio', ['kategori' => 'pdl']) }}" class="service-card scroll-reveal delay-7">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/pdl/thumb.jpg') }}" alt="PDL">
                </div>
                <h3>PDL</h3>
                <p>Pakaian Dinas Lapangan</p>
                <span class="card-link">Lihat Detail <i class="fas fa-arrow-right"></i></span>
            </a>

            <!-- Dll -->
            <a href="{{ route('portfolio', ['kategori' => 'dll']) }}" class="service-card scroll-reveal delay-8">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/dll/thumb.jpg') }}" alt="Lainnya">
                </div>
                <h3>Dll</h3>
                <p>Tas, Totebag, dll</p>
                <span class="card-link">Lihat Detail <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</section>

<!-- Klien Kami (Marquee Logo) -->
<section class="clients-section">
    <div class="container">
        <h2 class="section-title scroll-reveal">Klien Kami</h2>
        <p class="section-subtitle scroll-reveal">Telah mempercayakan kebutuhan konveksinya kepada kami</p>
    </div>

    <div class="marquee-wrapper scroll-reveal">
        <div class="marquee marquee--right-to-left">
            <div class="marquee__content">
                <img src="{{ asset('images/clients/logo1.png') }}" alt="Client 1">
                <img src="{{ asset('images/clients/logo2.png') }}" alt="Client 2">
                <img src="{{ asset('images/clients/logo3.png') }}" alt="Client 3">
                <img src="{{ asset('images/clients/logo4.png') }}" alt="Client 4">
                <img src="{{ asset('images/clients/logo5.png') }}" alt="Client 5">
            </div>
            <div class="marquee__content" aria-hidden="true">
                <img src="{{ asset('images/clients/logo1.png') }}" alt="Client 1">
                <img src="{{ asset('images/clients/logo2.png') }}" alt="Client 2">
                <img src="{{ asset('images/clients/logo3.png') }}" alt="Client 3">
                <img src="{{ asset('images/clients/logo4.png') }}" alt="Client 4">
                <img src="{{ asset('images/clients/logo5.png') }}" alt="Client 5">
            </div>
        </div>
        <div class="marquee marquee--left-to-right">
            <div class="marquee__content">
                <img src="{{ asset('images/clients/logo6.png') }}" alt="Client 6">
                <img src="{{ asset('images/clients/logo7.png') }}" alt="Client 7">
                <img src="{{ asset('images/clients/logo8.png') }}" alt="Client 8">
                <img src="{{ asset('images/clients/logo9.png') }}" alt="Client 9">
                <img src="{{ asset('images/clients/logo10.png') }}" alt="Client 10">
            </div>
            <div class="marquee__content" aria-hidden="true">
                <img src="{{ asset('images/clients/logo6.png') }}" alt="Client 6">
                <img src="{{ asset('images/clients/logo7.png') }}" alt="Client 7">
                <img src="{{ asset('images/clients/logo8.png') }}" alt="Client 8">
                <img src="{{ asset('images/clients/logo9.png') }}" alt="Client 9">
                <img src="{{ asset('images/clients/logo10.png') }}" alt="Client 10">
            </div>
        </div>
    </div>
</section>

<!-- Tentang Kami -->
<section id="tentang" class="about">
    <div class="container">
        <!-- Intro Header -->
        <div class="about-intro scroll-reveal">
            <h2 class="about-intro-title">Konveksi Baju Berkualitas Terpercaya</h2>
            <p class="about-intro-text">Dari baju perusahaan hingga baju sekolah, dari baju instansi hingga baju olahraga, Anita Konveksi hadir untuk menjawab setiap kebutuhan konveksi baju Anda. Jadikan setiap momen bersama kami sebagai langkah menuju kesuksesan Anda.</p>
            <p class="about-intro-text"><strong>Apa saja yang bisa diproduksi di Anita Konveksi?</strong> Segala produk dari kategori konveksi baju seperti kaos sablon, jersey, kaos polo, seragam kemeja kantor, kemeja casual, kemeja PDL, kemeja PDH, kemeja tactical, jaket bomber, jaket varsity, jaket jumper hoodie, jaket zipper hoodie, jas lab, blazer, jas almamater, topi, tas, hingga atribut seperti umbul-umbul dan bendera.</p>
        </div>

        <!-- Alternating Rows Container -->
        <div class="about-rows-container">
            <!-- Row 1: Visualisasi Ide -->
            <div class="about-row scroll-reveal">
                <div class="about-col-text">
                    <h3 class="about-row-title">Visualisasi Ide Anda Menjadi Sebuah Desain</h3>
                    <div class="about-row-text">
                        <p>Setiap seragam yang kami buat merupakan hasil dari kolaborasi erat dengan Anda.</p>
                        <p><strong>Anita Konveksi</strong> siap membantu Anda dalam mengolah ide Anda menjadi sebuah desain yang kreatif dan fungsional sehingga siap untuk diproduksi.</p>
                    </div>
                    <div class="about-buttons">
                        <a href="#layanan" class="btn-about-outline">Referensi Desain</a>
                        <a href="https://wa.me/6285331300400?text=Halo%20Anita%20Konveksi,%20saya%20ingin%20berkonsultasi%20mengenai%20desain%20baju..." target="_blank" class="btn-about-solid">Bantuan Desain</a>
                    </div>
                </div>
                <div class="about-col-image">
                    <img src="{{ asset('images/about/desain.jpg') }}" alt="Visualisasi Ide Desain">
                </div>
            </div>

            <!-- Row 2: Konveksi Terbaik dari Ahlinya (Reverse Layout) -->
            <div class="about-row reverse scroll-reveal">
                <div class="about-col-text">
                    <h3 class="about-row-title">Konveksi Baju Terbaik Dari Ahlinya</h3>
                    <div class="about-row-text">
                        <p>Dengan menggunakan teknologi terkini dan tim produksi yang terampil, Anita Konveksi menjamin proses produksi yang cepat dan hasil yang memuaskan.</p>
                    </div>
                </div>
                <div class="about-col-image">
                    <img src="{{ asset('images/about/jahit.jpg') }}" alt="Proses Menjahit Ahli">
                </div>
            </div>

            <!-- Row 3: Kualitas Produk -->
            <div class="about-row scroll-reveal">
                <div class="about-col-text">
                    <h3 class="about-row-title">Kualitas Produk Pada Setiap Produksi</h3>
                    <div class="about-row-text">
                        <p>Dengan pengalaman bertahun-tahun dalam industri konveksi, kami memahami pentingnya baju yang tidak hanya menarik secara visual, tetapi juga nyaman dan tahan lama.</p>
                        <p>Inilah mengapa <strong>Anita Konveksi</strong> mengutamakan kualitas dalam setiap tahap produksi, dari desain hingga pengiriman akhir.</p>
                    </div>
                </div>
                <div class="about-col-image">
                    <img src="{{ asset('images/about/rak.jpg') }}" alt="Kualitas Produksi Bordir">
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.testimonials')

<!-- Lokasi & Kontak -->
<section id="kontak" class="location-contact">
    <div class="container">
        <h2 class="section-title scroll-reveal">Lokasi & Kontak Kami</h2>
        <div class="contact-wrapper">
            <!-- Kolom Peta -->
            <div class="contact-map scroll-reveal from-left">
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15814.965291211125!2d112.00934121716207!3d-7.710882013655649!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7851adff4af061%3A0x8aab27ed5bd66c29!2sAnita%20Konveksi%20Dan%20Sablon!5e0!3m2!1sen!2sid!4v1775485662380!5m2!1sen!2sid"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Kolom Form Kontak -->
            <div class="contact-form scroll-reveal from-right">
                <h3>Hubungi Kami</h3>
                <p>Isi form di bawah untuk mengirim pesan via email, atau hubungi langsung melalui WhatsApp.</p>

                <form action="https://formspree.io/f/your-form-id" method="POST" class="contact-form-input">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Nama Anda" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email Anda" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" rows="4" placeholder="Pesan Anda..." required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Kirim Pesan via Email</button>
                </form>

                <div class="whatsapp-link">
                    <a href="https://wa.me/6285331300400?text=Halo%20Anita%20Konveksi,%20saya%20ingin%20bertanya%20tentang%20..." target="_blank" class="btn-wa">
                        <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- OGL WebGL Library and LightRays implementation -->
<script src="https://cdn.jsdelivr.net/npm/ogl@0.0.106/dist/ogl.umd.js"></script>
<script src="{{ asset('js/light-rays.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('hero-light-rays');
        if (container) {
            new LightRays(container, {
                raysOrigin: 'top-center',
                raysColor: '#ffffff',
                raysSpeed: 1,
                lightSpread: 0.5,
                rayLength: 3,
                followMouse: true,
                mouseInfluence: 0.1,
                noiseAmount: 0,
                distortion: 0,
                pulsating: false,
                fadeDistance: 1,
                saturation: 1
            });
        }
    });
</script>
@endsection