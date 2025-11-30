<?php

namespace App\MoonShine\Resources\Forum\Membergroup\Pages;

use App\MoonShine\Resources\Forum\Member\MemberResource;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Pages\Crud\IndexPage as BaseIndexPage;
use MoonShine\UI\Fields\Color;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class IndexPage extends BaseIndexPage
{
    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'id_group')
                ->sortable(),

            Text::make(__('base.group'), 'group_name')
                ->sortable(),

            Textarea::make(__('base.description'), 'description'),

            Color::make(__('base.color'), 'online_color'),

            Number::make(__('base.min_messages'), 'min_posts')
                ->badge(),

            HasMany::make(__('base.users'), 'members', resource: MemberResource::class)
                ->relatedLink('group'),
        ];
    }
}
