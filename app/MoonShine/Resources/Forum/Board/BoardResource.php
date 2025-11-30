<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Forum\Board;

use App\Models\Board;
use App\MoonShine\Resources\Forum\Board\Pages\DetailPage;
use App\MoonShine\Resources\Forum\Board\Pages\FormPage;
use App\MoonShine\Resources\Forum\Board\Pages\IndexPage;
use App\MoonShine\Resources\ReorderableResource;
use MoonShine\Support\Attributes\Icon;

#[Icon('folder-open')]
/**
 * @extends ReorderableResource<Board>
 */
class BoardResource extends ReorderableResource
{
    protected string $model = Board::class;

    protected string $column = 'name';

    protected string $sortColumn = 'board_order';

    protected bool $createInModal = true;

    protected bool $editInModal = true;

    protected array $with = ['topics'];

    public function getTitle(): string
    {
        return __('base.boards');
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
