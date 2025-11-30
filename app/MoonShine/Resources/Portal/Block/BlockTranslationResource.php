<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Portal\Block;

use App\Models\PortalTranslation;
use App\MoonShine\Resources\Portal\Block\Pages\TranslationFormPage;
use App\MoonShine\Resources\Portal\Translation\TranslationResource;

/**
 * @extends TranslationResource<PortalTranslation>
 */
class BlockTranslationResource extends TranslationResource
{
    protected function pages(): array
    {
        return [
            TranslationFormPage::class,
        ];
    }
}
