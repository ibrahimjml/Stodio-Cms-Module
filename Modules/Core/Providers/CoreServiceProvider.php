<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'core');
    }

    public function boot(): void
    {
        $this->loadBladeDirectives();
        $this->loadHelpers();

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);

            $this->publishes([
                __DIR__.'/../Config/config.php' => config_path('core.php'),
            ], 'core-config');

            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/core'),
            ], 'assets-config');

        }

    }

    private function loadBladeDirectives(): void
    {
        Blade::directive('svg', function ($arguments) {
            return "<?php 
            \$args = [$arguments];
            \$name = \$args[0] ?? '';
            
            \$path = base_path(\"Modules/Core/Resources/svg/{\$name}.svg\");
            
            if (file_exists(\$path)) {
                \$svg = file_get_contents(\$path);
                echo \$svg;
            }
        ?>";
        });
    }

    private function loadHelpers(): void
    {
        $this->app->make('files')->requireOnce(__DIR__.'/../Helpers/helpers.php');
        $this->app->make('files')->requireOnce(__DIR__.'/../Helpers/constants.php');
    }
}
