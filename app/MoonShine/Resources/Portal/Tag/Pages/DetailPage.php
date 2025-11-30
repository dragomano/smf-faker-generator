<?php

namespace App\MoonShine\Resources\Portal\Tag\Pages;

use Bugo\MoonShine\FontAwesome\Fields\IconSelect;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Pages\Crud\DetailPage as BaseDetailPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class DetailPage extends BaseDetailPage
{
    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'tag_id'),

            IconSelect::make(__('base.icon'), 'icon'),

            Text::make(__('base.title'), 'title'),

            Switcher::make(__('base.status'), 'status')
                ->updateOnPreview(),

            BelongsToMany::make(__('base.pages_with_tag'), 'pages')
                ->relatedLink('tags'),
        ];
    }
}
