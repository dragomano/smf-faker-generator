<?php

namespace App\Providers;

use App\Models\PortalBlock;
use App\Models\PortalCategory;
use App\Models\PortalComment;
use App\Models\PortalPage;
use App\Models\PortalTag;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\LazyLoadingViolationException;
use Illuminate\Support\ServiceProvider;
use Log;
use Symfony\Component\VarDumper\VarDumper;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 15);

            foreach ($trace as $frame) {
                if (isset($frame['file']) && str_contains($frame['file'], 'moonshine')) {
                    Log::error('Lazy loading: ' . get_class($model) . ' -> ' . $relation, [
                        'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10)
                    ]);

                    return;
                }
            }

            throw new LazyLoadingViolationException($model, $relation);
        });

        Model::shouldBeStrict(! app()->isProduction());

        if (app()->environment('local') && class_exists(Debugbar::class)) {
            VarDumper::setHandler(function ($var) {
                Debugbar::info($var);
            });
        }

        Relation::enforceMorphMap([
            'block' => PortalBlock::class,
            'category' => PortalCategory::class,
            'comment' => PortalComment::class,
            'page' => PortalPage::class,
            'tag' => PortalTag::class,
        ]);
    }
}
