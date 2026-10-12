<?php

namespace Modules\Auditlog\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuditlogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'auditlog');

    }

    public function boot(): void
    {
        $this->registerEvents();
        $this->bindRoutes();

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);

            $this->publishes([
                __DIR__.'/../Config/config.php' => config_path('auditlog.php'),
            ], 'auditlog-config');
        }
    }

    private function registerEvents(): void
    {
        $this->app->register(EventServiceProvider::class);
    }

    private function bindRoutes(): void
    {
        Route::prefix('admin')
            ->middleware(['web', 'auth'])
            ->group(function () {
                require base_path('Modules/Auditlog/Routes/admin.php');
            });
    }
}
