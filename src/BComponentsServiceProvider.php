<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Application;
use Zakarialabib\BComponents\Components\{
    AccordionComponent,
    AlertComponent,
    BadgeComponent,
    BreadcrumbComponent,
    ButtonComponent,
    CardComponent,
    CheckboxComponent,
    ContainerComponent,
    DividerComponent,
    DrawerComponent,
    FlexComponent,
    FooterComponent,
    FormGroupComponent,
    GridComponent,
    HeaderComponent,
    InputComponent,
    LoadingComponent,
    ModalComponent,
    RadioComponent,
    SelectComponent,
    SpacerComponent,
    TableComponent,
    TextareaComponent,
    ToastComponent,
    ToggleComponent
};
use Zakarialabib\BComponents\Components\Table\{
    TableHeaderComponent,
    TableBodyComponent,
    TableRowComponent,
    TableCellComponent
};

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
        
        // Load views from both package and published locations
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'bcomponents');
        
        // Also register the views without the namespace for direct access
        $this->loadViewsFrom(__DIR__ . '/../resources/views', null);
        
        // Load published views
        if (is_dir(resource_path('views/vendor/bcomponents'))) {
            $this->loadViewsFrom(resource_path('views/vendor/bcomponents'), 'bcomponents');
        }
        
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'bcomponents');

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
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/bcomponents'),
            ], 'bcomponents-translations');

            $this->publishes([
                __DIR__ . '/../public' => public_path('vendor/bcomponents'),
            ], 'bcomponents-assets');

            $this->publishes([
                __DIR__ . '/../stubs' => base_path('stubs/bcomponents'),
            ], 'bcomponents-stubs');
        }
    }

    /**
     * Register the package's Blade components.
     *
     * @return void
     */
    private function registerBladeComponents(): void
    {
        // Register component namespace
        Blade::componentNamespace('Zakarialabib\\BComponents\\Components', 'bcomponents');
        
        $prefix = Config::get('bcomponents.prefix', 'b');

        $components = [
            'accordion' => AccordionComponent::class,
            'alert' => AlertComponent::class,
            'badge' => BadgeComponent::class,
            'breadcrumb' => BreadcrumbComponent::class,
            'button' => ButtonComponent::class,
            'card' => CardComponent::class,
            'checkbox' => CheckboxComponent::class,
            'container' => ContainerComponent::class,
            'divider' => DividerComponent::class,
            'drawer' => DrawerComponent::class,
            'flex' => FlexComponent::class,
            'footer' => FooterComponent::class,
            'form-group' => FormGroupComponent::class,
            'grid' => GridComponent::class,
            'header' => HeaderComponent::class,
            'input' => InputComponent::class,
            'loading' => LoadingComponent::class,
            'modal' => ModalComponent::class,
            'radio' => RadioComponent::class,
            'select' => SelectComponent::class,
            'spacer' => SpacerComponent::class,
            'table' => TableComponent::class,
            'table.header' => TableHeaderComponent::class,
            'table.body' => TableBodyComponent::class,
            'table.row' => TableRowComponent::class,
            'table.cell' => TableCellComponent::class,
            'textarea' => TextareaComponent::class,
            'toast' => ToastComponent::class,
            'toggle' => ToggleComponent::class,
        ];

        foreach ($components as $alias => $class) {
            Blade::component($class, "{$prefix}-{$alias}");
        }
    }
}
