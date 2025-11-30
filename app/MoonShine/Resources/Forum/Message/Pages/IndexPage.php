<?php

namespace App\MoonShine\Resources\Forum\Message\Pages;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage as BaseIndexPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class IndexPage extends BaseIndexPage
{
    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'id_msg')
                ->sortable(),

            BelongsTo::make(__('base.subject'), 'topic', 'firstMessage.subject')
                ->sortable(),

            Date::make(__('base.created_at'), 'poster_time')
                ->format('d.m.Y H:i')
                ->sortable(),

            Text::make(__('base.title'), 'subject')
                ->sortable(),

            Text::make(__('base.author'), 'poster_name')
                ->sortable(),

            Switcher::make(__('base.approved'), 'approved')
                ->sortable()
                ->updateOnPreview(),
        ];
    }
}
