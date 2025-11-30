<?php

namespace App\MoonShine\Resources\Forum\Topic\Pages;

use App\MoonShine\Resources\Forum\Board\BoardResource;
use App\MoonShine\Resources\Forum\Member\MemberResource;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage as BaseIndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class IndexPage extends BaseIndexPage
{
    protected function filters(): iterable
    {
        return [
            BelongsTo::make(__('base.board'), 'board', 'name')
                ->nullable()
                ->asyncSearch('name')
                ->asyncOnInit(),
        ];
    }

    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'id_topic')
                ->sortable(),

            Text::make(__('base.topic'), 'firstMessage.subject')
                ->sortable(function (Builder $query, string $column, string $direction) {
                    $query
                        ->leftJoin('messages as fm', 'topics.id_first_msg', '=', 'fm.id_msg')
                        ->orderBy('fm.subject', $direction)
                        ->select('topics.*');
                }),

            BelongsTo::make(__('base.board'), 'board', 'name', BoardResource::class)
                ->sortable()
                ->badge('secondary'),

            BelongsTo::make(__('base.author'), 'member', 'real_name', MemberResource::class)
                ->searchable()
                ->sortable(),

            Number::make(__('base.replies'), 'num_replies')
                ->sortable()
                ->badge(),

            Number::make(__('base.views'), 'num_views')
                ->sortable()
                ->badge(),

            Switcher::make(__('base.closed'), 'locked')
                ->sortable()
                ->updateOnPreview(),

            Switcher::make(__('base.approved'), 'approved')
                ->sortable()
                ->updateOnPreview(),

            Switcher::make(__('base.sticky'), 'is_sticky')
                ->sortable()
                ->updateOnPreview(),
        ];
    }
}
