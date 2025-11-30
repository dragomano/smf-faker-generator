<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\Forum\Board\BoardResource;
use App\MoonShine\Resources\Forum\Category\CategoryResource;
use App\MoonShine\Resources\Forum\Member\MemberResource;
use App\MoonShine\Resources\Forum\Membergroup\MembergroupResource;
use App\MoonShine\Resources\Forum\Message\MessageResource;
use App\MoonShine\Resources\Forum\Topic\TopicResource;
use App\MoonShine\Resources\Portal\Block\BlockResource;
use App\MoonShine\Resources\Portal\Category\CategoryResource as PortalCategoryResource;
use App\MoonShine\Resources\Portal\Comment\CommentResource;
use App\MoonShine\Resources\Portal\Page\PageResource;
use App\MoonShine\Resources\Portal\Tag\TagResource;
use MoonShine\ColorManager\Palettes\GrayPalette;
use MoonShine\Crud\Components\Layout\Locales;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\Breadcrumbs;
use MoonShine\UI\Components\Layout\Burger;
use MoonShine\UI\Components\Layout\Div;
use MoonShine\UI\Components\Layout\Footer;
use MoonShine\UI\Components\Layout\Header;

class CustomLayout extends AppLayout
{
    protected ?string $palette = GrayPalette::class;

    protected function getHeaderComponent(): Header
    {
        return Header::make([
            Div::make([
                Burger::make(),
            ])
                ->class('menu-burger'),

            Breadcrumbs::make($this->getPage()->getBreadcrumbs())
                ->prepend($this->getHomeUrl(), label: __('base.home')),

            $this->getSearchComponent(),

            Locales::make(),
        ]);
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make(__('base.forum'),
                $this->menuItems([
                    __('base.members') => MemberResource::class,
                    __('base.groups') => MembergroupResource::class,
                    __('base.categories') => CategoryResource::class,
                    __('base.boards') => BoardResource::class,
                    __('base.topics') => TopicResource::class,
                    __('base.messages') => MessageResource::class,
                ])
            )->icon('building-library'),

            MenuGroup::make(__('base.portal'),
                $this->menuItems([
                    __('base.blocks') => BlockResource::class,
                    __('base.pages') => PageResource::class,
                    __('base.comments') => CommentResource::class,
                    __('base.categories') => PortalCategoryResource::class,
                    __('base.tags') => TagResource::class,
                ])
            )->icon('building-storefront'),
        ];
    }

    protected function menuItems(array $items): array
    {
        return collect($items)->map(function ($config, $label) {
            if (is_array($config)) {
                [$resourceClass, $withBadge] = $config;
            } else {
                $resourceClass = $config;
                $withBadge = true;
            }

            return $this->menuItem($resourceClass, $label, $withBadge);
        })->toArray();
    }

    protected function menuItem(string $resourceClass, string $label, bool $withBadge = true): MenuItem
    {
        $item = MenuItem::make($resourceClass, $label);

        if ($withBadge) {
            $item->badge(fn() => app($resourceClass)->getModel()::count());
        }

        return $item;
    }

    protected function getFooterComponent(): Footer
    {
        return Footer::make()
            ->copyright(sprintf(
                "<strong>%s</strong> &copy; %d, Bugo",
                config('app.name'),
                now()->year
            ))
            ->menu([
                'https://github.com/moonshine-software/moonshine' => 'MoonShine',
                'https://github.com/SimpleMachines/SMF' => 'Simple Machines Forum',
                'https://github.com/dragomano/Light-Portal' => 'Light Portal',
            ]);
    }
}
