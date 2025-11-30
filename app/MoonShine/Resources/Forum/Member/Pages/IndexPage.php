<?php

namespace App\MoonShine\Resources\Forum\Member\Pages;

use App\MoonShine\Resources\Forum\Membergroup\MembergroupResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage as BaseIndexPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class IndexPage extends BaseIndexPage
{
    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'id_member')
                ->sortable(),

            Text::make(__('base.nickname'), 'real_name')
                ->sortable(),

            Date::make(__('base.registered_date'), 'date_registered')
                ->format('d.m.Y H:i')
                ->sortable(),

            BelongsTo::make(
                __('base.group'),
                'group',
                'group_name',
                MembergroupResource::class
            )
                ->sortable()
                ->searchable()
                ->badge(),

            Email::make(__('base.email'), 'email_address')
                ->sortable(),

            Switcher::make(__('base.activated'), 'is_activated')
                ->sortable()
                ->updateOnPreview(),
        ];
    }
}
