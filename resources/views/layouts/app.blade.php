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
            <button class="navbar-toggler" id="navbarToggler" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}#home">Beranda</a></li>
                <li><a href="{{ route('home') }}#layanan">Layanan</a></li>
                <li><a href="{{ route('home') }}#tentang">Tentang</a></li>
                <li><a href="{{ route('home') }}#kontak">Kontak</a></li>
            </ul>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <a href="https://wa.me/6285331300400?text=Halo%20Anita%20Konveksi,%20saya%20ingin%20bertanya%20tentang%20..."
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
                        <li>📞 <span>+62 853-3130-0400</span></li>
                        <li>✉️ <span>info@anitakonveksi.com</span></li>
                        <li>🕒 <span>Senin - Sabtu: 08.00 - 17.00</span></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Anita Konveksi & Sablon. All rights reserved.</p>
                <p>Desain & Dikembangkan oleh <strong>Tim Anita Konveksi</strong></p>
            </div>
        </div>
    </footer>

    <!-- Navbar Toggler Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggler = document.getElementById('navbarToggler');
            const navMenu = document.getElementById('navMenu');
            
            if (toggler && navMenu) {
                toggler.addEventListener('click', function() {
                    navMenu.classList.toggle('active');
                });

                // Menutup hamburger menu saat salah satu link diklik
                const navLinks = navMenu.querySelectorAll('a');
                navLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        if (window.innerWidth <= 768) {
                            navMenu.classList.remove('active');
                        }
                    });
                });
            }
        });
    </script>

    <!-- Scroll Reveal Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revealElements = document.querySelectorAll('.scroll-reveal');

            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -80px 0px',
                threshold: 0.15
            };

            const revealObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            revealElements.forEach(function(el) {
                revealObserver.observe(el);
            });
        });
    </script>

    <!-- Smooth Scroll for Navbar Links -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.nav-menu a').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    var href = this.getAttribute('href');
                    
                    // Cek apakah link mengandung karakter '#'
                    if (href.includes('#')) {
                        var parts = href.split('#');
                        var targetId = parts[1];
                        var targetEl = document.getElementById(targetId);
                        
                        // Jika elemen target ada di halaman ini (Halaman Utama)
                        if (targetEl) {
                            e.preventDefault();
                            var navbar = document.querySelector('.navbar');
                            var navbarHeight = navbar ? navbar.offsetHeight : 0;
                            var targetPos = targetEl.getBoundingClientRect().top + window.pageYOffset - navbarHeight - 10;
                            window.scrollTo({ top: targetPos, behavior: 'smooth' });
                            
                            // Opsional: Perbarui URL di address bar tanpa reload
                            window.history.pushState(null, null, '#' + targetId);
                        }
                    }
                });
            });
        });
    </script>

    <!-- Hero Word-by-Word Animation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var h1 = document.querySelector('.hero-content h1');
            var heroP = document.querySelector('.hero-content > p');
            var cta = document.querySelector('.hero-content .btn-cta');

            if (!h1) return;

            // Wrap words in spans, preserving <br> tags
            function wrapWordsInElement(el, cssClass) {
                var html = el.innerHTML;
                var parts = html.split(/<br\s*\/?>/gi);
                var newHtml = parts.map(function(part) {
                    return part.trim().split(/\s+/).filter(function(w) {
                        return w.length > 0;
                    }).map(function(word) {
                        return '<span class="' + cssClass + '">' + word + '</span>';
                    }).join(' ');
                }).join('<br>');
                el.innerHTML = newHtml;
            }

            wrapWordsInElement(h1, 'hero-word');
            if (heroP) wrapWordsInElement(heroP, 'hero-subtitle-word');
            if (cta) cta.classList.add('hero-cta-animate');

            var wordDelay = 110;    // ms between each word
            var settleDelay = 380;  // ms before word turns white
            var pauseBeforeLoop = 3500; // ms pause before restarting

            function animateHero() {
                var allTitleWords = document.querySelectorAll('.hero-word');
                var allSubWords = document.querySelectorAll('.hero-subtitle-word');
                var allWords = [];
                allTitleWords.forEach(function(w) { allWords.push(w); });
                allSubWords.forEach(function(w) { allWords.push(w); });

                // Instant reset — disable transitions briefly
                allWords.forEach(function(w) {
                    w.style.transition = 'none';
                    w.classList.remove('visible', 'settled');
                });
                if (cta) {
                    cta.style.transition = 'none';
                    cta.classList.remove('visible');
                }

                // Force browser reflow so reset is applied instantly
                void document.body.offsetHeight;

                // Re-enable transitions after a tick
                setTimeout(function() {
                    allWords.forEach(function(w) {
                        w.style.transition = '';
                    });
                    if (cta) cta.style.transition = '';

                    // Reveal words one by one
                    allWords.forEach(function(word, i) {
                        // Word appears (orange)
                        setTimeout(function() {
                            word.classList.add('visible');
                        }, i * wordDelay);

                        // Word settles (turns white)
                        setTimeout(function() {
                            word.classList.add('settled');
                        }, i * wordDelay + settleDelay);
                    });

                    // Show CTA button after all words
                    var ctaShowTime = allWords.length * wordDelay + 500;
                    if (cta) {
                        setTimeout(function() {
                            cta.classList.add('visible');
                        }, ctaShowTime);
                    }

                    // Schedule next loop
                    var totalTime = allWords.length * wordDelay + pauseBeforeLoop;
                    setTimeout(animateHero, totalTime);
                }, 60);
            }

            // Start first animation after a short delay
            setTimeout(animateHero, 400);
        });
    </script>
</body>

</html>