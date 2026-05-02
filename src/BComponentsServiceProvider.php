<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Support\ComponentRegistry;
use Zakarialabib\BComponents\Support\Metadata\ComponentMetadataRepository;

class BComponentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPublishables();
        $this->registerBladeComponents();
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'bcomponents');

        if ($this->app->runningInConsole()) {
            $this->commands([
                // Add console commands here
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/bcomponents.php', 'bcomponents');

        $this->app->singleton('bcomponents', function ($app) {
            return new BladeComponentManager($app);
        });

        $this->app->singleton(ComponentRegistry::class, function () {
            return new ComponentRegistry();
        });

        $this->app->singleton(ComponentMetadataRepository::class, function () {
            return new ComponentMetadataRepository();
        });
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishables(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/bcomponents.php' => config_path('bcomponents.php'),
            ], 'bcomponents-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/bcomponents'),
            ], 'bcomponents-views');

            $this->publishes([
                __DIR__ . '/../resources/css' => public_path('vendor/bcomponents/css'),
                __DIR__ . '/../resources/js' => public_path('vendor/bcomponents/js'),
            ], 'bcomponents-assets');
        }
    }

    /**
     * Register the package's Blade components.
     *
     * @return void
     */
    private function registerBladeComponents(): void
    {
        $prefix = (string) config('bcomponents.prefix', 'b');
        $registry = $this->app->make(ComponentRegistry::class);

        foreach ($registry->aliases() as $alias => $class) {
            if (!$registry->enabled($alias)) {
                continue;
            }

            Blade::component($class, "{$prefix}-{$alias}");
        }
    }
}
