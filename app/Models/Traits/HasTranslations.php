<?php

namespace App\Models\Traits;

use App\Models\PortalTranslation;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasTranslations
{
    public function translations(): MorphMany
    {
        return $this->morphMany(PortalTranslation::class, 'translatable', 'type', 'item_id');
    }

    public function translation(): MorphOne
    {
        $lang = app()->currentLocale();

        if (! array_key_exists($lang, $this->languages())) {
            $lang = config('app.fallback_locale', 'en');
        }

        return $this->morphOne(PortalTranslation::class, 'translatable', 'type', 'item_id')
            ->where('lang', $this->languages()[$lang]);
    }

    public function getTranslatableFields(): array
    {
        return ['title', 'description', 'content'];
    }

    public function getAttribute($key)
    {
        if (in_array($key, $this->getTranslatableFields(), true)) {
            if ($this->relationLoaded('translation')) {
                return $this->translation?->{$key};
            }

            return $this->translate($key);
        }

        return call_user_func([get_parent_class($this), 'getAttribute'], $key);
    }

    public function translationFor(string $lang): ?PortalTranslation
    {
        return $this->translations()
            ->where('lang', $lang)
            ->first();
    }

    public function translate(string $attribute, ?string $lang = null): ?string
    {
        if ($lang === null) {
            $lang = app()->currentLocale();
        }

        if (! array_key_exists($lang, $this->languages())) {
            $lang = config('app.fallback_locale', 'en');
        }

        $translation = $this->translationFor($lang);

        return $translation?->$attribute;
    }

    protected function languages(): array
    {
        return config('app.languages', []);
    }

    protected static function bootHasTranslations(): void
    {
        static::deleting(static function (self $model): void {
            $model->translations()->delete();
        });
    }
}
