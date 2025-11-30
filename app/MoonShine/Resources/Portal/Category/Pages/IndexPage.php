<?php

namespace App\MoonShine\Resources\Portal\Category\Pages;

use App\Enums\Status;
use Bugo\MoonShine\FontAwesome\Fields\IconSelect;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Pages\Crud\IndexPage as BaseIndexPage;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

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

    protected function queryTags(): array
    {
        return [
            QueryTag::make(
                __('base.categories_without_description'),
                fn(Builder $query) => $query->whereHas('translation', function (Builder $translationQuery) {
                    $translationQuery
                        ->whereNull('description')
                        ->orWhere('description', '');
                })
            )
        ];
    }

    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'category_id')
                ->sortable(),

            IconSelect::make(__('base.icon'), 'icon')
                ->sortable()
                ->searchable(),

            Text::make(__('base.title'), 'title')
                ->sortable(),

            Textarea::make(__('base.description'), 'description'),

            Switcher::make(__('base.status'), 'status')
                ->updateOnPreview(),

            BelongsToMany::make(__('base.pages_in_category'), 'pages')
                ->relatedLink('category'),
        ];
    }
}
