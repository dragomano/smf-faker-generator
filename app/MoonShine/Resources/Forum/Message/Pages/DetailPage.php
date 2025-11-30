<?php

namespace App\MoonShine\Resources\Forum\Message\Pages;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\DetailPage as BaseDetailPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class DetailPage extends BaseDetailPage
{
    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'id_msg'),

            BelongsTo::make(__('base.subject'), 'topic', 'firstMessage.subject'),

            Date::make(__('base.created_at'), 'poster_time')
                ->format('d.m.Y H:i'),

            Text::make(__('base.title'), 'subject'),

            Text::make(__('base.author'), 'poster_name'),

            Switcher::make(__('base.approved'), 'approved')
                ->updateOnPreview(),
        ];
    }
}
