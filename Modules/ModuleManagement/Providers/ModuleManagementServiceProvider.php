<?php

namespace Modules\ModuleManagement\Providers;

use Ibrahimjml\LaravelModules\Console\ModuleMigrateCommand;
use Ibrahimjml\LaravelModules\Console\ModuleMigrateRollbackCommand;
use Illuminate\Support\ServiceProvider;

class ModuleManagementServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'modulemanagement');
    }

    public function boot(): void
    {
        // The package only registers its commands on the console, so re-register
        // the ones we drive via Artisan::call() from HTTP requests.
        if (! $this->app->runningInConsole()) {
            $this->commands([
                ModuleMigrateCommand::class,
                ModuleMigrateRollbackCommand::class,
            ]);
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../Config/config.php' => config_path('modulemanagement.php'),
            ], 'modulemanagement-config');
        }
    }
}
