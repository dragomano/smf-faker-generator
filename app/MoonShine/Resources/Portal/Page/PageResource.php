<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Portal\Page;

use App\Models\PortalPage;
use App\MoonShine\Resources\Portal\Page\Pages\DetailPage;
use App\MoonShine\Resources\Portal\Page\Pages\FormPage;
use App\MoonShine\Resources\Portal\Page\Pages\IndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;

#[Icon('clipboard')]
/**
 * @extends ModelResource<PortalPage>
 */
class PageResource extends ModelResource
{
    protected string $model = PortalPage::class;

    protected string $column = 'title';

    protected array $with = ['category', 'member', 'tags', 'comments', 'params', 'translations'];

    public function getTitle(): string
    {
        return __('base.pages');
    }

    public function search(): array
    {
        return [
            'category.translations.title',
            'member.real_name',
            'alias',
            'translations.description',
            'translations.content',
            'translations.title',
        ];
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
