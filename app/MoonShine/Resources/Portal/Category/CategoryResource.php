<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Portal\Category;

use App\Models\PortalCategory;
use App\MoonShine\Resources\Portal\Category\Pages\DetailPage;
use App\MoonShine\Resources\Portal\Category\Pages\FormPage;
use App\MoonShine\Resources\Portal\Category\Pages\IndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;

#[Icon('folder')]
/**
 * @extends ModelResource<PortalCategory>
 */
class CategoryResource extends ModelResource
{
    protected string $model = PortalCategory::class;

    protected ?string $alias = 'portal-category';

    protected string $column = 'title';

    protected array $with = ['pages', 'translations'];

    public function getTitle(): string
    {
        return __('base.categories');
    }

    public function search(): array
    {
        return ['translations.title', 'translations.description'];
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
