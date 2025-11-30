<?php

namespace App\MoonShine\Resources\Forum\Board\Pages;

use MoonShine\Laravel\Pages\Crud\DetailPage as BaseDetailPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

class DetailPage extends BaseDetailPage
{
    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'id_board'),

            Text::make(__('base.name'), 'name'),

            Text::make(__('base.description'), 'description'),

            Number::make(__('base.topics'), 'num_topics')
                ->badge('blue'),

            Number::make(__('base.messages'), 'num_posts')
                ->badge(),
        ];
    }
}
