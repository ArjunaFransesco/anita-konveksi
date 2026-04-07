<!-- Testimoni dari Google Maps (Data Asli) -->
<section class="testimonials-section">
    <div class="container">
        <h2 class="section-title">Apa Kata Pelanggan Kami?</h2>
        <div class="testimonials-grid">
            @php
                $reviews = [
                    [
                        'name' => 'Redya Arwintara',
                        'rating' => 5,
                        'text' => 'Pelayanan sangat baik, hasil memuaskan.',
                        'date' => '1 bulan lalu'
                    ],
                    [
                        'name' => 'Army Cahyono',
                        'rating' => 5,
                        'text' => 'Murah, rapi, berkualitas.',
                        'date' => '2 bulan lalu'
                    ],
                    [
                        'name' => 'alfirohmatulula 943',
                        'rating' => 5,
                        'text' => 'bagusss bangetttt hasilnyaa makasiii',
                        'date' => '2 bulan lalu'
                    ],
                    [
                        'name' => 'Roro ayu Nevyta sari',
                        'rating' => 5,
                        'text' => 'jaitan nya bagus harga terjangkau',
                        'date' => '2 bulan lalu'
                    ],
                    [
                        'name' => 'Yadrin Damianto',
                        'rating' => 5,
                        'text' => 'Pelayanan cepat, Kualitas bagus',
                        'date' => '2 bulan lalu'
                    ],
                    [
                        'name' => 'Zafa armandika Dika',
                        'rating' => 5,
                        'text' => 'Memuaskan',
                        'date' => '2 bulan lalu'
                    ],
                ];
            @endphp

            @foreach($reviews as $review)
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    @for($i=1; $i<=5; $i++)
                        @if($i <= $review['rating'])
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                </div>
                <p class="testimonial-text">"{{ $review['text'] }}"</p>
                <div class="testimonial-author">{{ $review['name'] }}</div>
                <div class="testimonial-date">{{ $review['date'] }}</div>
            </div>
            @endforeach
        </div>
        <div class="testimonial-footer">
            <a href="https://maps.app.goo.gl/oyXuMJSyukVmHvGP8" target="_blank" class="btn-cta">
                ⭐ Lihat Semua Ulasan di Google Maps
            </a>
        </div>
    </div>
</section>