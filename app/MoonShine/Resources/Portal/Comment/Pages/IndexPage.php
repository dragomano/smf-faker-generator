<?php

namespace App\MoonShine\Resources\Portal\Comment\Pages;

use App\MoonShine\Resources\Portal\Comment\CommentResource;
use MoonShine\EasyMde\Fields\Markdown;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage as BaseIndexPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;

class IndexPage extends BaseIndexPage
{
    protected function filters(): iterable
    {
        return [
            BelongsTo::make(__('base.page'), 'page', 'title')
                ->nullable()
                ->searchable(),

            BelongsTo::make(__('base.author'), 'member', 'real_name')
                ->nullable()
                ->asyncSearch('real_name')
                ->asyncOnInit(),

            BelongsTo::make(__('base.parent_comment'), 'parent', resource: CommentResource::class)
                ->nullable()
                ->searchable(),
        ];
    }

    protected function fields(): iterable
    {
        return [
            ID::make()
                ->sortable(),

            Date::make(__('base.created_at'), 'created_at')
                ->format('d.m.Y H:i')
                ->sortable(),

            BelongsTo::make(__('base.page'), 'page', 'title')
                ->sortable('page_id'),

            BelongsTo::make(__('base.author'), 'member', 'real_name')
                ->sortable('author_id'),

            Markdown::make(__('base.content'), 'content'),
        ];
    }
}
