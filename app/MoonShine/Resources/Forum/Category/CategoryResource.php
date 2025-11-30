<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Forum\Category;

use App\Models\Category;
use App\MoonShine\Resources\Forum\Category\Pages\DetailPage;
use App\MoonShine\Resources\Forum\Category\Pages\FormPage;
use App\MoonShine\Resources\Forum\Category\Pages\IndexPage;
use App\MoonShine\Resources\ReorderableResource;
use MoonShine\Support\Attributes\Icon;

#[Icon('folder')]
/**
 * @extends ReorderableResource<Category>
 */
class CategoryResource extends ReorderableResource
{
    protected string $model = Category::class;

    protected string $column = 'name';

    protected string $sortColumn = 'cat_order';

    protected bool $createInModal = true;

    protected bool $editInModal = true;

    protected array $with = ['boards'];

    public function getTitle(): string
    {
        return __('base.categories');
    }

    public function search(): array
    {
        return ['name', 'description'];
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
