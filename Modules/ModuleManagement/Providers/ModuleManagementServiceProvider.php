<?php

namespace Modules\ModuleManagement\Providers;

use Ibrahimjml\LaravelModules\Console\ModuleMigrateCommand;
use Ibrahimjml\LaravelModules\Console\ModuleMigrateRollbackCommand;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\LoadDataTrait;

class ModuleManagementServiceProvider extends ServiceProvider
{
    use LoadDataTrait;

    public function register(): void
    {
       //
    }

    public function boot(): void
    {
         $this->loadHelpers()
              ->loadAndPublishConfigurations(['config', 'permission'])
              ->publishAssets();

        if (! $this->app->runningInConsole()) {
            $this->commands([
                ModuleMigrateCommand::class,
                ModuleMigrateRollbackCommand::class,
            ]);
        }
    }
}
