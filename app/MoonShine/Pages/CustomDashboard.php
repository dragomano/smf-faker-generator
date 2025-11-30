<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Board;
use App\Models\Category;
use App\Models\Member;
use App\Models\Membergroup;
use App\Models\Message;
use App\Models\PortalBlock;
use App\Models\PortalCategory;
use App\Models\PortalPage;
use App\Models\PortalTag;
use App\Models\Topic;
use MoonShine\Apexcharts\Components\DonutChartMetric;
use MoonShine\Laravel\Pages\Page;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;

class CustomDashboard extends Page
{
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle()
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: __('moonshine::ui.dashboard');
    }

    protected function components(): iterable
    {
        return [
            Grid::make([
                ValueMetric::make(__('base.users'))
                    ->value(Member::count())
                    ->columnSpan(2),
                ValueMetric::make(__('base.groups'))
                    ->value(Membergroup::count())
                    ->columnSpan(2),
                ValueMetric::make(__('base.categories'))
                    ->value(Category::count())
                    ->columnSpan(2),
                ValueMetric::make(__('base.boards'))
                    ->value(Board::count())
                    ->columnSpan(2),
                ValueMetric::make(__('base.topics'))
                    ->value(Topic::count())
                    ->columnSpan(2),
                ValueMetric::make(__('base.messages'))
                    ->value(Message::count())
                    ->columnSpan(2),

                DonutChartMetric::make(__('base.portal'))
                    ->values([
                        __('base.blocks') => PortalBlock::count(),
                        __('base.pages') => PortalPage::count(),
                        __('base.categories') => PortalCategory::count(),
                        __('base.tags') => PortalTag::count(),
                    ])
                    ->columnSpan(12),
            ]),
        ];
    }
}
