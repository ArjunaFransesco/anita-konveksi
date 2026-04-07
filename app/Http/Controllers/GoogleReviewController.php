<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GoogleReviewController extends Controller
{
    public function getReviews()
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $placeId = 'ChIJYfBK_61ReC4RKWzWW-0nq40'; // Place ID Anita Konveksi

        // Jika tidak ada API key, gunakan data statis
        if (empty($apiKey)) {
            return $this->staticReviews();
        }

        // Caching 24 jam
        $reviews = Cache::remember('anita_google_reviews', 60 * 24, function () use ($apiKey, $placeId) {
            $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                'place_id' => $placeId,
                'fields' => 'reviews',
                'key' => $apiKey,
            ]);

            if ($response->successful() && isset($response->json()['result']['reviews'])) {
                $rawReviews = $response->json()['result']['reviews'];
                // Format ulasan
                $formatted = [];
                foreach ($rawReviews as $rev) {
                    $formatted[] = [
                        'name' => $rev['author_name'],
                        'rating' => $rev['rating'],
                        'text' => $rev['text'],
                        'date' => date('d M Y', $rev['time']),
                    ];
                }
                return $formatted;
            }
            return $this->staticReviews();
        });

        return view('partials.testimonials', ['reviews' => $reviews]);
    }

    private function staticReviews()
    {
        return [
            ['name' => 'Budi Santoso', 'rating' => 5, 'text' => 'Pelayanan ramah, hasil jahitan rapi.', 'date' => '2 minggu lalu'],
            ['name' => 'Siti Aminah', 'rating' => 4, 'text' => 'Kualitas bahan bagus.', 'date' => '1 bulan lalu'],
            // tambahkan sesuai ulasan asli
        ];
    }
}