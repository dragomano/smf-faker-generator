<?php

namespace App\Services;

use Devscast\Pexels\Client;
use Devscast\Pexels\Parameter\PaginationParameters;
use Devscast\Pexels\Parameter\SearchParameters;
use Exception;
use Illuminate\Support\Facades\Cache;

class PexelsService
{
    protected Client $client;

    protected int $maxRequestsPerHour = 180;

    protected int $maxRequestsPerMonth = 19000;

    public function __construct()
    {
        $this->client = new Client(token: config('services.pexels_api_key'));
    }

    public function getRandomImageWithAttribution(string $query = 'nature'): array
    {
        if (! $this->checkRateLimits()) {
            return $this->getFallbackImageData($query);
        }

        return Cache::remember("pexels_random_$query", 3600, function () use ($query) {
            try {
                $response = $this->client->searchPhotos(
                    $query,
                    new SearchParameters(page: rand(1, 5), per_page: 15)
                );

                if ($response->total_results > 0 && ! empty($response->photos)) {
                    $randomPhoto = $response->photos[array_rand($response->photos)];

                    return [
                        'url' => $randomPhoto->src->original,
                        'photographer' => $randomPhoto->photographer,
                        'photographer_url' => $randomPhoto->photographer_url,
                        'pexels_url' => $randomPhoto->url,
                        'alt' => $randomPhoto->alt ?? "$query image",
                        'query' => $query,
                        'from_api' => true,
                    ];
                }

            } catch (Exception $e) {
                report($e);
            }

            return $this->getFallbackImageData($query);
        });
    }

    public function getCuratedImageWithAttribution(): array
    {
        return Cache::remember('pexels_curated', 3600, function () {
            try {
                $response = $this->client->curatedPhotos(
                    new PaginationParameters(page: rand(1, 5), per_page: 15)
                );

                if ($response->total_results > 0 && ! empty($response->photos)) {
                    $randomPhoto = $response->photos[array_rand($response->photos)];

                    return [
                        'url' => $randomPhoto->src->original,
                        'photographer' => $randomPhoto->photographer,
                        'photographer_url' => $randomPhoto->photographer_url,
                        'pexels_url' => $randomPhoto->url,
                        'alt' => $randomPhoto->alt ?? "featured image",
                        'query' => 'curated',
                    ];
                }

            } catch (Exception $e) {
                report($e);
            }

            return [
                'url' => "https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg",
                'photographer' => "Pexels",
                'photographer_url' => "https://www.pexels.com",
                'pexels_url' => "https://www.pexels.com",
                'alt' => "featured image",
                'query' => 'curated',
            ];
        });
    }

    public function getFallbackImageData(string $query = 'nature'): array
    {
        $fallbacks = [
            'nature' => [
                'url' => 'https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg',
                'photographer' => 'Pexels',
                'photographer_url' => 'https://www.pexels.com/@pexels',
                'pexels_url' => 'https://www.pexels.com/photo/414612/',
                'alt' => 'Beautiful nature landscape',
            ],
            'technology' => [
                'url' => 'https://images.pexels.com/photos/177598/pexels-photo-177598.jpeg',
                'photographer' => 'Pexels',
                'photographer_url' => 'https://www.pexels.com/@pexels',
                'pexels_url' => 'https://www.pexels.com/photo/177598/',
                'alt' => 'Technology concept',
            ],
            'food' => [
                'url' => 'https://images.pexels.com/photos/376464/pexels-photo-376464.jpeg',
                'photographer' => 'Pexels',
                'photographer_url' => 'https://www.pexels.com/@pexels',
                'pexels_url' => 'https://www.pexels.com/photo/376464/',
                'alt' => 'Delicious food',
            ]
        ];

        return $fallbacks[$query] ?? $fallbacks['nature'];
    }

    public function getUsageStats(): array
    {
        $hourlyKey = 'pexels_requests_hour_' . now()->format('Y-m-d-H');
        $monthlyKey = 'pexels_requests_month_' . now()->format('Y-m');

        return [
            'hourly' => Cache::get($hourlyKey, 0),
            'hourly_limit' => $this->maxRequestsPerHour,
            'monthly' => Cache::get($monthlyKey, 0),
            'monthly_limit' => $this->maxRequestsPerMonth,
            'remaining_hourly' => $this->maxRequestsPerHour - Cache::get($hourlyKey, 0),
            'remaining_monthly' => $this->maxRequestsPerMonth - Cache::get($monthlyKey, 0),
        ];
    }

    protected function checkRateLimits(): bool
    {
        $hourlyKey = 'pexels_requests_hour_' . now()->format('Y-m-d-H');
        $monthlyKey = 'pexels_requests_month_' . now()->format('Y-m');

        $hourlyCount = Cache::get($hourlyKey, 0);
        $monthlyCount = Cache::get($monthlyKey, 0);

        if ($hourlyCount >= $this->maxRequestsPerHour) {
            report(new Exception('Pexels API hourly limit exceeded'));
            return false;
        }

        if ($monthlyCount >= $this->maxRequestsPerMonth) {
            report(new Exception('Pexels API monthly limit exceeded'));
            return false;
        }

        Cache::put($hourlyKey, $hourlyCount + 1, now()->addHour());
        Cache::put($monthlyKey, $monthlyCount + 1, now()->addMonth());

        return true;
    }
}
