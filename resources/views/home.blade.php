@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="home" class="hero">
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
        <h2 class="section-title">Apparel & Clothing</h2>
        <p class="section-subtitle">Menyediakan berbagai kebutuhan konveksi untuk instansi, perusahaan, dan komunitas</p>

        <div class="service-grid">
            <!-- Seragam Sekolah -->
            <a href="{{ route('portfolio', ['kategori' => 'seragam-sekolah']) }}" class="service-card">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/seragam-sekolah/thumb.jpg') }}" alt="Seragam Sekolah">
                </div>
                <h3>Seragam Sekolah</h3>
                <p>PAUD, SD, SMP, SMA</p>
            </a>

            <!-- Seragam Kantor -->
            <a href="{{ route('portfolio', ['kategori' => 'seragam-kantor']) }}" class="service-card">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/seragam-kantor/thumb.jpg') }}" alt="Seragam Kantor">
                </div>
                <h3>Seragam Kantor</h3>
                <p>Karyawan, Eksekutif</p>
            </a>

            <!-- Seragam Drumband -->
            <a href="{{ route('portfolio', ['kategori' => 'seragam-drumband']) }}" class="service-card">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/seragam-drumband/thumb.jpg') }}" alt="Seragam Drumband">
                </div>
                <h3>Seragam Drumband</h3>
                <p>Marching band</p>
            </a>

            <!-- Jas / Almamater -->
            <a href="{{ route('portfolio', ['kategori' => 'jas-almamater']) }}" class="service-card">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/jas-almamater/thumb.jpg') }}" alt="Jas Almamater">
                </div>
                <h3>Jas / Almamater</h3>
                <p>Wisuda, organisasi</p>
            </a>

            <!-- Umbul-umbul / Bendera -->
            <a href="{{ route('portfolio', ['kategori' => 'umbul-umbul']) }}" class="service-card">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/umbul-umbul/thumb.jpg') }}" alt="Umbul-umbul">
                </div>
                <h3>Umbul-umbul / Bendera</h3>
                <p>Event, kampanye</p>
            </a>

            <!-- Topi -->
            <a href="{{ route('portfolio', ['kategori' => 'topi']) }}" class="service-card">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/topi/thumb.jpg') }}" alt="Topi">
                </div>
                <h3>Topi</h3>
                <p>Custom, branded</p>
            </a>

            <!-- Jaket -->
            <a href="{{ route('portfolio', ['kategori' => 'jaket']) }}" class="service-card">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/jaket/thumb.jpg') }}" alt="Jaket">
                </div>
                <h3>Jaket</h3>
                <p>Jaket komunitas, bomber</p>
            </a>

            <!-- PDL -->
            <a href="{{ route('portfolio', ['kategori' => 'pdl']) }}" class="service-card">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/pdl/thumb.jpg') }}" alt="PDL">
                </div>
                <h3>PDL</h3>
                <p>Pakaian Dinas Lapangan</p>
            </a>

            <!-- Dll -->
            <a href="{{ route('portfolio', ['kategori' => 'dll']) }}" class="service-card">
                <div class="card-image">
                    <img src="{{ asset('images/layanan/dll/thumb.jpg') }}" alt="Lainnya">
                </div>
                <h3>Dll</h3>
                <p>Tas, Totebag, dll</p>
            </a>
        </div>
    </div>
</section>

<!-- Klien Kami (Marquee Logo) -->
<section class="clients-section">
    <div class="container">
        <h2 class="section-title">Klien Kami</h2>
        <p class="section-subtitle">Telah mempercayakan kebutuhan konveksinya kepada kami</p>
    </div>

    <div class="marquee-wrapper">
        <!-- Baris Atas: Bergerak dari Kanan ke Kiri -->
        <div class="marquee marquee--right-to-left">
            <div class="marquee__content">
                <img src="{{ asset('images/clients/logo1.png') }}" alt="Client 1">
                <img src="{{ asset('images/clients/logo2.png') }}" alt="Client 2">
                <img src="{{ asset('images/clients/logo3.png') }}" alt="Client 3">
                <img src="{{ asset('images/clients/logo4.png') }}" alt="Client 4">
                <img src="{{ asset('images/clients/logo5.png') }}" alt="Client 5">
                <img src="{{ asset('images/clients/logo6.png') }}" alt="Client 6">
            </div>
            <div class="marquee__content" aria-hidden="true">
                <!-- Duplikasi untuk efek seamless -->
                <img src="{{ asset('images/clients/logo1.png') }}" alt="Client 1">
                <img src="{{ asset('images/clients/logo2.png') }}" alt="Client 2">
                <img src="{{ asset('images/clients/logo3.png') }}" alt="Client 3">
                <img src="{{ asset('images/clients/logo4.png') }}" alt="Client 4">
                <img src="{{ asset('images/clients/logo5.png') }}" alt="Client 5">
                <img src="{{ asset('images/clients/logo6.png') }}" alt="Client 6">
            </div>
        </div>

        <!-- Baris Bawah: Bergerak dari Kiri ke Kanan -->
        <div class="marquee marquee--left-to-right">
            <div class="marquee__content">
                <img src="{{ asset('images/clients/logo7.png') }}" alt="Client 7">
                <img src="{{ asset('images/clients/logo8.png') }}" alt="Client 8">
                <img src="{{ asset('images/clients/logo9.png') }}" alt="Client 9">
                <img src="{{ asset('images/clients/logo10.png') }}" alt="Client 10">
            </div>
            <div class="marquee__content" aria-hidden="true">
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
        <h2 class="section-title">Tentang Anita Konveksi & Sablon</h2>
        <div class="about-content">
            <p>Anita Konveksi & Sablon adalah mitra produksi pakaian yang berfokus pada kualitas, ketepatan waktu, dan kepuasan pelanggan. Kami melayani berbagai kebutuhan konveksi baik untuk skala instansi pendidikan, perusahaan, organisasi, hingga komunitas dengan teknik produksi modern dan tenaga ahli berpengalaman.</p>

            <h3>Layanan Unggulan Kami:</h3>
            <ul>
                <li><strong>Seragam Formal:</strong> Seragam Sekolah (PAUD - SMA), Seragam Kantor, dan Almamater.</li>
                <li><strong>Pakaian Khusus:</strong> Seragam Drumband, Jaket Komunitas, dan Kaos Sablon.</li>
                <li><strong>Atribut & Aksesoris:</strong> Produksi Topi, Tas/Totebag, Umbul-umbul, serta Bendera.</li>
                <li><strong>Teknik Bordir & Sablon:</strong> Menggunakan teknologi bordir komputer dan sablon berkualitas tinggi untuk hasil yang presisi dan tahan lama.</li>
            </ul>
            <p>Kami memahami bahwa seragam adalah identitas. Oleh karena itu, Anita Konveksi berkomitmen memberikan hasil jahitan yang rapi dengan pemilihan bahan terbaik yang nyaman digunakan untuk aktivitas sehari-hari.</p>
        </div>
    </div>
</section>

@include('partials.testimonials')
<!-- Lokasi -->
<!-- Lokasi & Kontak -->
<section id="kontak" class="location-contact">
    <div class="container">
        <h2 class="section-title">Lokasi & Kontak Kami</h2>
        <div class="contact-wrapper">
            <!-- Kolom Peta -->
            <div class="contact-map">
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
            <div class="contact-form">
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
                    <a href="https://wa.me/6281234567890?text=Halo%20Anita%20Konveksi,%20saya%20ingin%20bertanya%20tentang%20..." target="_blank" class="btn-wa">
                        <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection