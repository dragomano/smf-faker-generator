<?php

namespace App\MoonShine\Resources\Portal\Block\Pages;

use App\Enums\Placement;
use App\Models\PortalBlock;
use Bugo\MoonShine\FontAwesome\Fields\IconSelect;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\Laravel\Pages\Crud\DetailPage as BaseDetailPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class DetailPage extends BaseDetailPage
{
    protected function modifyEditButton(ActionButtonContract $button): ActionButtonContract
    {
        return $button->onBeforeRender(function (ActionButtonContract $action) {
            /* @var PortalBlock $data */
            $data = $action->getData();
            $type = $data->type;
            $action->setUrl($action->getUrl() . '?type=' . $type);
        });
    }

    protected function fields(): iterable
    {
        return [
            ID::make(__('base.id'), 'block_id'),

            IconSelect::make(__('base.icon'), 'icon'),

            Text::make(__('base.title'), 'title'),

            Text::make(__('base.content_type'), 'type'),

            Select::make(__('base.placement'), 'placement')
                ->options(Placement::values()),

            Text::make(__('base.note'), 'description'),

            Switcher::make(__('base.status'), 'status')
                ->updateOnPreview(),
        ];
    }
}
