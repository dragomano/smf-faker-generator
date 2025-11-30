<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Portal\Block;

use App\Models\PortalBlock;
use App\MoonShine\Resources\Portal\Block\Pages\DetailPage;
use App\MoonShine\Resources\Portal\Block\Pages\FormPage;
use App\MoonShine\Resources\Portal\Block\Pages\IndexPage;
use App\MoonShine\Resources\ReorderableResource;
use MoonShine\Support\Attributes\Icon;

#[Icon('square-3-stack-3d')]
/**
 * @extends ReorderableResource<PortalBlock>
 */
class BlockResource extends ReorderableResource
{
    protected string $model = PortalBlock::class;

    protected string $column = 'title';

    protected string $sortColumn = 'priority';

    protected array $with = ['params', 'translations'];

    public function getTitle(): string
    {
        return __('base.blocks');
    }

    public function search(): array
    {
        return ['translations.title', 'translations.description', 'translations.content'];
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
