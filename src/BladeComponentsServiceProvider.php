<?php

namespace AdzChappers\BladeComponents;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeComponentsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/blade-components.php' => config_path('blade-components.php'),
        ], 'blade-components-config');

        // Load in the component form views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'blade-components');

        // Create Blade components
        foreach (config('blade-components.components') as $k => $v) {
            Blade::component($k, $v['class'], config('blade-components.prefix'));
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/blade-components.php',
            'blade-components'
        );
    }
}
