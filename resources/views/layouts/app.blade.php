<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anita Konveksi & Sablon - Solusi Seragam & Atribut Profesional</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Anita Konveksi" class="logo-img">
                <div class="logo-text">
                    <h2>Anita Konveksi</h2>
                    <span>& Sablon</span>
                </div>
            </div>
            <ul class="nav-menu">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#layanan">Layanan</a></li>
                <li><a href="#tentang">Tentang</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <a href="https://wa.me/6287753462865?text=Halo%20Anita%20Konveksi,%20saya%20ingin%20bertanya%20tentang%20..."
        class="floating-wa"
        target="_blank"
        rel="noopener noreferrer">
        <i class="fab fa-whatsapp"></i>
    </a>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Kolom 1: Brand -->
                <div class="footer-col">
                    <h3>Anita Konveksi <span>& Sablon</span></h3>
                    <p>Solusi Manufaktur Pakaian & Atribut Terpercaya sejak 2015. Melayani instansi pendidikan, perusahaan, organisasi, dan komunitas.</p>
                    <div class="social-links">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Kolom 2: Layanan Cepat -->
                <div class="footer-col">
                    <h4>Layanan Kami</h4>
                    <ul>
                        <li><a href="#">Seragam Sekolah</a></li>
                        <li><a href="#">Seragam Kantor</a></li>
                        <li><a href="#">Seragam Drumband</a></li>
                        <li><a href="#">Jaket & Almamater</a></li>
                        <li><a href="#">Sablon & Bordir</a></li>
                        <li><a href="#">Atribut & Aksesoris</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Informasi -->
                <div class="footer-col">
                    <h4>Informasi</h4>
                    <ul>
                        <li><a href="#tentang">Tentang Kami</a></li>
                        <li><a href="#">Cara Pemesanan</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Testimoni</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Kontak & Lokasi -->
                <div class="footer-col">
                    <h4>Hubungi Kami</h4>
                    <ul class="contact-info">
                        <li>📍 <span>Sanggrahan Prambon, Nganjuk, Jawa Timur 64484</span></li>
                        <li>📞 <span>+62 812-3456-7890</span></li>
                        <li>✉️ <span>info@anitakonveksi.com</span></li>
                        <li>🕒 <span>Senin - Sabtu: 08.00 - 17.00</span></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 Anita Konveksi & Sablon. All rights reserved.</p>
                <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; justify-content: center;">
                    <!-- Tombol Login Staff kecil & terlihat -->
                    <button onclick="document.getElementById('staffLoginModal').style.display='flex'"
                        style="background: none; border: none; color: #ccc; font-size: 0.75rem; cursor: pointer; padding: 4px 8px; border-radius: 4px; transition: background 0.2s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                        onmouseout="this.style.background='none'">
                        🔒 Login Staff
                    </button>
                    <p>Desain & Dikembangkan oleh <strong>Tim Anita Konveksi</strong></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Modal Login Staff (tersembunyi) -->
    <div id="staffLoginModal" style="display: none; position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
        <div style="background:white; padding:2rem; border-radius:8px; width:90%; max-width:400px;">
            <h3 style="margin-bottom:1rem;">Login Staff</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="text" name="username" placeholder="Username" required style="width:100%; padding:10px; margin:8px 0; border:1px solid #ddd; border-radius:6px;">
                <input type="password" name="password" placeholder="Password" required style="width:100%; padding:10px; margin:8px 0; border:1px solid #ddd; border-radius:6px;">
                <button type="submit" style="background:#1A1A1A; color:white; padding:10px; border:none; width:100%; border-radius:6px; cursor:pointer;">Login</button>
            </form>
            @if($errors->any())
            <p style="color:red; font-size:0.8rem; margin-top:0.5rem;">{{ $errors->first() }}</p>
            @endif
        </div>
    </div>

    <script>
        // Triple-click trigger pada teks credit di footer
        let clickCount = 0;
        let timeout;
        const trigger = document.getElementById('hidden-login-trigger');
        if (trigger) {
            trigger.addEventListener('click', function(e) {
                clickCount++;
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    clickCount = 0;
                }, 800);
                if (clickCount === 3) {
                    document.getElementById('staffLoginModal').style.display = 'flex';
                    clickCount = 0;
                }
            });
        }
        // Tutup modal jika klik di luar area
        window.onclick = function(event) {
            const modal = document.getElementById('staffLoginModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>

</html>