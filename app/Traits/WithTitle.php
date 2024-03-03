<?php

namespace App\Traits;

trait WithTitle
{
    public function getTitleAttribute(): string
    {
        $languages = [
            'en' => 'english',
            'ru' => 'russian',
        ];

        $titles = $this->titles ?? [];

        foreach ($titles as $title) {
            if ($title['lang'] === $languages[config('app.locale')]) {
                return $title['title'];
            }
        }

        return '';
    }
}
