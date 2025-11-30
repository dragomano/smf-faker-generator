<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Portal\Category;

use App\Models\PortalTranslation;
use App\MoonShine\Resources\Portal\Category\Pages\TranslationFormPage;
use App\MoonShine\Resources\Portal\Translation\TranslationResource;

/**
 * @extends TranslationResource<PortalTranslation>
 */
class CategoryTranslationResource extends TranslationResource
{
    protected function pages(): array
    {
        return [
            TranslationFormPage::class,
        ];
    }
}
