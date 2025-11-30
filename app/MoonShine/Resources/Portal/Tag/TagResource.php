<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Portal\Tag;

use App\Models\PortalTag;
use App\MoonShine\Resources\Portal\Tag\Pages\DetailPage;
use App\MoonShine\Resources\Portal\Tag\Pages\FormPage;
use App\MoonShine\Resources\Portal\Tag\Pages\IndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;

#[Icon('tag')]
/**
 * @extends ModelResource<PortalTag>
 */
class TagResource extends ModelResource
{
    protected string $model = PortalTag::class;

    protected string $column = 'title';

    protected array $with = ['pages', 'translations'];

    public function getTitle(): string
    {
        return __('base.tags');
    }

    public function search(): array
    {
        return ['translations.title'];
    }

    protected function pages(): array
    {
        return [
            IndexPage::class,
            FormPage::class,
            DetailPage::class,
        ];
    }
}
