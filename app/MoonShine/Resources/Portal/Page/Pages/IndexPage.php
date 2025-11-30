<?php

namespace App\MoonShine\Resources\Portal\Page\Pages;

use App\Enums\ContentType;
use App\Enums\PageStatus;
use App\Models\PortalPage;
use App\MoonShine\Resources\Portal\HasCustomCreateButtons;
use App\MoonShine\Resources\Portal\Tag\TagResource;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Pages\Crud\IndexPage as BaseIndexPage;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\DateRange;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

class IndexPage extends BaseIndexPage
{
    use HasCustomCreateButtons;

    protected function modifyEditButton(ActionButtonContract $button): ActionButtonContract
    {
        return $button->onBeforeRender(function (ActionButtonContract $action) {
            /* @var PortalPage $data */
            $data = $action->getData();
            $type = $data->type;
            $action->setUrl($action->getUrl() . '?type=' . $type);
        });
    }

    protected function filters(): iterable
    {
        return [
            DateRange::make(__('base.created_at'), 'created_at'),

            DateRange::make(__('base.updated_at'), 'updated_at'),

            BelongsTo::make(__('base.category'), 'category', 'title')
                ->nullable()
                ->asyncOnInit(),

            Select::make(__('base.content_type'), 'type')
                ->nullable()
                ->options(ContentType::values()),

            Select::make(__('base.status'), 'status')
                ->nullable()
                ->options(PageStatus::values()),

            BelongsToMany::make(__('base.tags'), 'tags', resource: TagResource::class)
                ->selectMode()
                ->searchable()
                ->selectMaxItems(6)
        ];
    }

    protected function queryTags(): array
    {
        return [
            QueryTag::make(
                __('base.pages_without_category'),
                fn(Builder $query) => $query->where('category_id', 0)
            )
        ];
    }

    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'page_id')
                ->sortable(),

            Date::make(__('base.created_at'), 'created_at')
                ->format('d.m.Y H:i')
                ->sortable(),

            Text::make(__('base.title'), 'title')
                ->sortable(),

            Text::make(__('base.category'), 'category')
                ->changeFill(fn(PortalPage $item) => $item->category?->title ?? __('base.none'))
                ->sortable()
                ->badge('secondary'),

            BelongsTo::make(__('base.author'), 'member', 'real_name')
                ->sortable('author_id'),

            Text::make(__('base.content_type'), 'type')
                ->changeFill(fn(PortalPage $item) => ContentType::values()[$item->type])
                ->sortable()
                ->badge('red'),

            Select::make(__('base.status'), 'status')
                ->options(PageStatus::values())
                ->sortable()
                ->badge('blue'),

            BelongsToMany::make(__('base.tags'), 'tags')
                ->onlyCount()
                ->badge(),

            Text::make(__('base.comments'), 'num_comments')
                ->sortable()
                ->badge(),
        ];
    }
}
