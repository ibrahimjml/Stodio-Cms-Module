<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'admin');
    }

    public function boot(): void
    {

        $this->loadHelpers();

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);

            $this->publishes([
                __DIR__.'/../Config/config.php' => config_path('admin.php'),
            ], 'admin-config');
        }
    }

    private function loadHelpers(): void
    {
        $this->app->make('files')->requireOnce(__DIR__.'/../Helpers/MenuHelper.php');
    }
}
