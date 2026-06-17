<?php
// config/google-places-reviews.php
return [
    'place_ID' => 'ChIJYfBK_61ReC4RKWzWW-0nq40', // Place ID dari Anita Konveksi
    'business_name' => 'Anita Konveksi & Sablon',
    'min_star' => '1',
    'max_rows' => '5',
    'api_key' => env('GOOGLE_MAPS_API_KEY'), // Pastikan API Key Anda sudah di .env
    'cache_minutes' => 60 * 24,
    'show_empty_stars' => true,
    'order_by' => 'date_desc',
    'lang' => 'id',
    'show_business_name' => true,
    'show_see_more_button' => false,
];