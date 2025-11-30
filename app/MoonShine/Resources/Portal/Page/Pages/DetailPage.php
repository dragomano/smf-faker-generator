<?php

namespace App\MoonShine\Resources\Portal\Page\Pages;

use App\Enums\PageStatus;
use App\Models\PortalPage;
use App\MoonShine\Resources\Forum\Member\MemberResource;
use App\MoonShine\Resources\Portal\Tag\TagResource;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Pages\Crud\DetailPage as BaseDetailPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

class DetailPage extends BaseDetailPage
{
    protected function modifyEditButton(ActionButtonContract $button): ActionButtonContract
    {
        return $button->onBeforeRender(function (ActionButtonContract $action) {
            /* @var PortalPage $data */
            $data = $action->getData();
            $type = $data->type;
            $action->setUrl($action->getUrl() . '?type=' . $type);
        });
    }

    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'page_id'),

            Date::make(__('base.created_at'), 'created_at')
                ->format('d.m.Y H:i'),

            Text::make(__('base.title'), 'title'),

            Text::make(__('base.category'), 'category')
                ->changeFill(fn(PortalPage $item) => $item->category?->title ?? __('base.none'))
                ->badge('secondary'),

            BelongsTo::make(__('base.author'), 'member', 'real_name', MemberResource::class),

            BelongsToMany::make(__('base.tags'), 'tags', 'translation', TagResource::class)
                ->relatedLink(),

            Text::make(__('base.content_type'), 'type')
                ->badge('red'),

            Select::make(__('base.status'), 'status')
                ->options(PageStatus::values())
                ->badge('blue'),

            Text::make(__('base.comments'), 'num_comments')
                ->badge(),
        ];
    }
}
