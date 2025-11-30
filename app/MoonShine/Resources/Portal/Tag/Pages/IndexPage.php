<?php

namespace App\MoonShine\Resources\Portal\Tag\Pages;

use App\Enums\Status;
use App\MoonShine\Resources\Portal\Page\PageResource;
use Bugo\MoonShine\FontAwesome\Fields\IconSelect;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Pages\Crud\IndexPage as BaseIndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class IndexPage extends BaseIndexPage
{
    protected function filters(): iterable
    {
        return [
            IconSelect::make(__('base.icon'), 'icon')
                ->nullable(),

            Select::make(__('base.status'), 'status')
                ->nullable()
                ->options(Status::values()),
        ];
    }

    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'tag_id')
                ->sortable(),

            IconSelect::make(__('base.icon'), 'icon')
                ->sortable()
                ->searchable(),

            Text::make(__('base.title'), 'title')
                ->sortable(),

            Switcher::make(__('base.status'), 'status')
                ->sortable()
                ->updateOnPreview(),

            BelongsToMany::make(__('base.pages_with_tag'), 'pages', resource: PageResource::class)
                ->relatedLink('tags'),
        ];
    }
}
