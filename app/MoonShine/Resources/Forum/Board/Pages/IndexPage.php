<?php

namespace App\MoonShine\Resources\Forum\Board\Pages;

use App\MoonShine\Resources\ReorderablePage;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

class IndexPage extends ReorderablePage
{
    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'id_board')
                ->sortable(),

            Text::make(__('base.name'), 'name')
                ->sortable(),

            Text::make(__('base.description'), 'description'),

            HasMany::make(__('base.topics'), 'topics')
                ->relatedLink(),

            Number::make(__('base.messages'), 'num_posts')
                ->sortable()
                ->badge(),
        ];
    }
}
