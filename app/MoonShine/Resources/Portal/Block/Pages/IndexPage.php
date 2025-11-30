<?php

namespace App\MoonShine\Resources\Portal\Block\Pages;

use App\Enums\ContentType;
use App\Enums\Placement;
use App\Enums\Status;
use App\Models\PortalBlock;
use App\MoonShine\Resources\Portal\HasCustomCreateButtons;
use App\MoonShine\Resources\ReorderablePage;
use Bugo\MoonShine\FontAwesome\Fields\IconSelect;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class IndexPage extends ReorderablePage
{
    use HasCustomCreateButtons;

    protected function modifyEditButton(ActionButtonContract $button): ActionButtonContract
    {
        return $button->onBeforeRender(function (ActionButtonContract $action) {
            /* @var PortalBlock $data */
            $data = $action->getData();
            $type = $data->type;
            $action->setUrl($action->getUrl() . '?type=' . $type);
        });
    }

    protected function filters(): iterable
    {
        return [
            Select::make(__('base.content_type'), 'type')
                ->nullable()
                ->options(ContentType::values()),

            Select::make(__('base.placement'), 'placement')
                ->nullable()
                ->options(Placement::values()),

            Select::make(__('base.status'), 'status')
                ->nullable()
                ->options(Status::values()),
        ];
    }

    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'block_id')
                ->sortable(),

            IconSelect::make(__('base.icon'), 'icon')
                ->sortable(),

            Text::make(__('base.title'), 'title')
                ->sortable(),

            Text::make(__('base.content_type'), 'type')
                ->changeFill(fn(PortalBlock $item) => ContentType::values()[$item->type])
                ->sortable()
                ->badge('red'),

            Select::make(__('base.placement'), 'placement')
                ->options(Placement::values())
                ->sortable()
                ->badge('green'),

            Text::make(__('base.note'), 'description'),

            Switcher::make(__('base.status'), 'status')
                ->sortable()
                ->updateOnPreview(),
        ];
    }
}
