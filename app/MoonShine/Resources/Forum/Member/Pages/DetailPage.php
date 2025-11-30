<?php

namespace App\MoonShine\Resources\Forum\Member\Pages;

use App\MoonShine\Resources\Forum\Membergroup\MembergroupResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\DetailPage as BaseDetailPage;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class DetailPage extends BaseDetailPage
{
    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'id_member'),

            Text::make(__('base.nickname'), 'real_name'),

            BelongsTo::make(__('base.group'), 'group', 'group_name', MembergroupResource::class)
                ->badge(),

            Email::make(__('base.email'), 'email_address'),

            Switcher::make(__('base.activated'), 'is_activated')
                ->updateOnPreview(),
        ];
    }
}
