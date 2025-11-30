<?php

namespace App\MoonShine\Resources\Forum\Category\Pages;

use App\MoonShine\Resources\ReorderablePage;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class IndexPage extends ReorderablePage
{
    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'id_cat')
                ->sortable(),

            Text::make(__('base.title'), 'name')
                ->sortable(),

            Textarea::make(__('base.description'), 'description'),

            HasMany::make(__('base.boards'), 'boards')
                ->relatedLink(),

            Switcher::make(__('base.collapsible'), 'can_collapse')
                ->updateOnPreview(),
        ];
    }
}
