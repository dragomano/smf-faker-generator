<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\SortDirection;

abstract class ReorderableResource extends ModelResource
{
    protected bool $usePagination = false;

    protected SortDirection $sortDirection = SortDirection::ASC;

    public function getReorderableConfig(): array
    {
        return [$this->getModel()->getKeyName(), $this->sortColumn];
    }
}
