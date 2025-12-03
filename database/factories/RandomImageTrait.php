<?php

namespace Database\Factories;

use Bugo\PexelsLaravel\Services\PexelsService;
use Illuminate\Support\Str;

trait RandomImageTrait
{
    public function withRandomImage(string $contentType, string $field = 'content'): self
    {
        return $this->state(function () use ($contentType, $field) {
            $imageContent = $this->generateImageContent($contentType);

            return [
                $field => $imageContent . fake()->paragraphs(rand(1, 6), true),
            ];
        });
    }

    protected function generateImageContent(string $format, bool $usePexels = true, bool $withAttribution = true): string
    {
        $imageData = $this->getRandomImageData($usePexels);

        return $this->formatImageWithAttribution($imageData, $format, $withAttribution);
    }

    protected function getRandomCategory(): string
    {
        $categories = ['nature', 'technology', 'business', 'people', 'travel', 'food', 'animals'];

        return $categories[array_rand($categories)];
    }

    protected function getRandomImageData($usePexels = true)
    {
        if (! $usePexels) {
            return [
                'url' => 'https://picsum.photos/600/300?random=' . md5(Str::random(8)),
                'alt' => 'Random image',
                'photographer' => '',
                'photographer_url' => '',
                'pexels_url' => '',
            ];
        }

        $pexelsService = app(PexelsService::class);

        $stats = $pexelsService->getUsageStats();

        $category = $this->getRandomCategory();

        if ($stats['remaining_hourly'] < 10 || $stats['remaining_monthly'] < 100) {
            return $pexelsService->getFallbackImageData($category);
        } else {
            return $pexelsService->getRandomImage($category);
        }
    }

    protected function formatImageWithAttribution(array $imageData, string $format, bool $withAttribution = true): string
    {
        switch ($format) {
            case 'bbc':
                $imageContent = '[img alt=' . $imageData['alt'] . ']' . $imageData['url'] . '[/img]';
                if ($withAttribution && ! empty($imageData['photographer'])) {
                    $imageContent .= '[br][size=3]'
                        . 'Photo by [url=' . $imageData['photographer_url'] . ']' . $imageData['photographer'] . '[/url]'
                        . ' on [url=' . $imageData['pexels_url'] . ']Pexels[/url][/size][br]';
                } else {
                    $imageContent .= '[br]';
                }
                break;

            case 'markdown':
                $imageContent = '![' . $imageData['alt'] . '](' . $imageData['url'] . ')';
                if ($withAttribution && ! empty($imageData['photographer'])) {
                    $imageContent .= "\n*Photo by [" . $imageData['photographer'] . ']('
                        . $imageData['photographer_url'] . ') on [Pexels](' . $imageData['pexels_url'] . ')*' . "\n";
                } else {
                    $imageContent .= "\n";
                }
                break;

            default: // html
                $imageContent = '<img src="' . $imageData['url'] . '" alt="' . $imageData['alt'] . '" style="max-width: 100%; height: auto;">';
                if ($withAttribution && ! empty($imageData['photographer'])) {
                    $imageContent .= '<br><div style="font-size: 12px; color: #666; margin-top: 5px;">Photo by '
                        . '<a href="' . $imageData['photographer_url'] . '" target="_blank">'
                        . $imageData['photographer'] . '</a> on <a href="' . $imageData['pexels_url']
                        . '" target="_blank">Pexels</a></div>';
                } else {
                    $imageContent .= '<br>';
                }
        }

        return $imageContent;
    }
}
