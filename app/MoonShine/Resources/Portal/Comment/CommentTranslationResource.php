<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Portal\Comment;

use App\Models\PortalTranslation;
use App\MoonShine\Resources\Portal\Comment\Pages\TranslationFormPage;
use App\MoonShine\Resources\Portal\Translation\TranslationResource;

/**
 * @extends TranslationResource<PortalTranslation>
 */
class CommentTranslationResource extends TranslationResource
{
    protected function pages(): array
    {
        return [
            TranslationFormPage::class,
        ];
    }
}
