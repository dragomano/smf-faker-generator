<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Layouts\CustomLayout;
use App\MoonShine\Pages\CustomDashboard;
use App\MoonShine\Pages\Dashboard;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        $config->layout(CustomLayout::class);
        $config->changePage(Dashboard::class, CustomDashboard::class);
        $config->logo('/logo.svg');

        $core->autoload();
    }
}
