<?php

namespace App\MoonShine\Resources\Forum\Category\Pages;

use MoonShine\Laravel\Pages\Crud\DetailPage as BaseDetailPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class DetailPage extends BaseDetailPage
{
    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'id_cat'),

            Text::make(__('base.title'), 'name'),

            Textarea::make(__('base.description'), 'description'),

            Switcher::make(__('base.collapsible'), 'can_collapse')
                ->updateOnPreview(),
        ];
    }
}
