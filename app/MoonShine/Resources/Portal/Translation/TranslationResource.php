<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Portal\Translation;

use App\Models\PortalTranslation;
use App\MoonShine\Resources\Portal\Translation\Pages\FormPage;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<PortalTranslation>
 */
class TranslationResource extends ModelResource
{
    protected string $model = PortalTranslation::class;

    protected function pages(): array
    {
        return [
            FormPage::class,
        ];
    }
}
