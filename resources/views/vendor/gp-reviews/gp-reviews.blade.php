{{-- resources/views/vendor/gp-reviews/gp-reviews.blade.php --}}
@if(isset($reviews) && count($reviews))
    <div class="gp-reviews">
        <div class="container">
            <h2 class="section-title">Apa Kata Mereka?</h2>
            <div class="reviews-list">
                @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="review-author">{{ $review['author_name'] }}</div>
                        <div class="review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa{{ $i <= $review['rating'] ? 's' : 'r' }} fa-star"></i>
                            @endfor
                        </div>
                        <p class="review-text">{{ \Illuminate\Support\Str::limit($review['text'], 200) }}</p>
                        <div class="review-date">{{ \Carbon\Carbon::createFromTimestamp($review['time'])->translatedFormat('d F Y') }}</div>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                <a href="https://maps.app.goo.gl/ReT2FiH6Wj95oiGz8" target="_blank" class="btn-cta">Lihat Semua Ulasan di Google Maps</a>
            </div>
        </div>
    </div>
@endif