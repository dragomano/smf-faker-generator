<?php

namespace App\MoonShine\Resources\Portal\Comment\Pages;

use App\MoonShine\Resources\Forum\Member\MemberResource;
use App\MoonShine\Resources\Portal\Page\PageResource;
use MoonShine\EasyMde\Fields\Markdown;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\DetailPage as BaseDetailPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;

class DetailPage extends BaseDetailPage
{
    protected function fields(): iterable
    {
        return [
            ID::make(),

            Date::make(__('base.created_at'), 'created_at')
                ->format('d.m.Y H:i'),

            BelongsTo::make(__('base.page'), 'page', 'title', PageResource::class),

            BelongsTo::make(__('base.author'), 'member', 'real_name', MemberResource::class),

            Markdown::make(__('base.content'), 'content'),
        ];
    }
}
