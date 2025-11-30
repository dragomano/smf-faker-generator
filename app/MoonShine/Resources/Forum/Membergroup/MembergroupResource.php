<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Forum\Membergroup;

use App\Models\Membergroup;
use App\MoonShine\Resources\Forum\Membergroup\Pages\DetailPage;
use App\MoonShine\Resources\Forum\Membergroup\Pages\FormPage;
use App\MoonShine\Resources\Forum\Membergroup\Pages\IndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;

#[Icon('user-group')]
/**
 * @extends ModelResource<Membergroup>
 */
class MembergroupResource extends ModelResource
{
    protected string $model = Membergroup::class;

    protected string $column = 'group_name';

    protected array $with = ['members'];

    protected bool $createInModal = true;

    protected bool $editInModal = true;

    public function getTitle(): string
    {
        return __('base.user_groups');
    }

    public function search(): array
    {
        return ['group_name', 'description'];
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
