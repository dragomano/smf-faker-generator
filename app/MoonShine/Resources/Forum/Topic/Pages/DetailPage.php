<?php

namespace App\MoonShine\Resources\Forum\Topic\Pages;

use App\MoonShine\Resources\Forum\Board\BoardResource;
use App\MoonShine\Resources\Forum\Member\MemberResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\DetailPage as BaseDetailPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class DetailPage extends BaseDetailPage
{
    protected function fields(): iterable
    {
        // return (new IndexPage($this->getCore()))->fields();
        return [
            ID::make(__('base.id'), 'id_topic'),

            Text::make(__('base.topic'), 'firstMessage.subject'),

            BelongsTo::make(__('base.board'), 'board', 'name', BoardResource::class)
                ->badge('secondary'),

            BelongsTo::make(__('base.author'), 'member', 'real_name', MemberResource::class),

            Number::make(__('base.replies'), 'num_replies')
                ->badge(),

            Number::make(__('base.views'), 'num_views')
                ->badge(),

            Switcher::make(__('base.closed'), 'locked')
                ->updateOnPreview(),

            Switcher::make(__('base.approved'), 'approved')
                ->updateOnPreview(),

            Switcher::make(__('base.sticky'), 'is_sticky')
                ->updateOnPreview(),
        ];
    }
}
