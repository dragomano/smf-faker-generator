<?php

namespace App\MoonShine\Resources\Portal\Category\Pages;

use App\MoonShine\Resources\Portal\Page\PageResource;
use Bugo\MoonShine\FontAwesome\Fields\IconSelect;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
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
            ID::make(__('base.id'), 'category_id'),

            IconSelect::make(__('base.icon'), 'icon'),

            Text::make(__('base.title'), 'title'),

            Textarea::make(__('base.description'), 'description'),

            Switcher::make(__('base.status'), 'status')
                ->updateOnPreview(),

            BelongsToMany::make(__('base.pages_in_category'), 'pages', resource: PageResource::class)
                ->relatedLink('category'),
        ];
    }
}
