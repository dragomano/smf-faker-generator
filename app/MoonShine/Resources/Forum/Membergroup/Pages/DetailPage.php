<?php

namespace App\MoonShine\Resources\Forum\Membergroup\Pages;

use MoonShine\Laravel\Pages\Crud\DetailPage as BaseDetailPage;
use MoonShine\UI\Fields\Color;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class DetailPage extends BaseDetailPage
{
    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'id_group'),

            Text::make(__('base.group'), 'group_name'),

            Textarea::make(__('base.description'), 'description'),

            Color::make(__('base.color'), 'online_color'),

            Number::make(__('base.min_messages'), 'min_posts')
                ->badge(),
        ];
    }
}
