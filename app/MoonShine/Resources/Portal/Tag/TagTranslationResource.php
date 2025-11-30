<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Portal\Tag;

use App\Models\PortalTranslation;
use App\MoonShine\Resources\Portal\Tag\Pages\TranslationFormPage;
use App\MoonShine\Resources\Portal\Translation\TranslationResource;

/**
 * @extends TranslationResource<PortalTranslation>
 */
class TagTranslationResource extends TranslationResource
{
    protected function pages(): array
    {
        return [
            TranslationFormPage::class,
        ];
    }
}
