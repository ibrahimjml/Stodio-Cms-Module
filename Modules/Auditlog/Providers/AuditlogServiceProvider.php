<?php

namespace Modules\Auditlog\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Console\PruneCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Auditlog\Models\AuditLog;

class AuditlogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'auditlog');

    }

    public function boot(): void
    {
        $this->registerEvents();
        $this->registerCommands();
        $this->bindRoutes();

        if ($this->app->runningInConsole()) {
            
            $this->app->afterResolving(Schedule::class, function (Schedule $schedule): void {
                $schedule
                    ->command(PruneCommand::class, ['--model' => AuditLog::class])
                    ->dailyAt('00:30');
            });
        

            $this->publishes([
                __DIR__.'/../Config/config.php' => config_path('auditlog.php'),
            ], 'auditlog-config');
        }
    }

    private function registerEvents(): void
    {
        $this->app->register(EventServiceProvider::class);
    }
    private function registerCommands(): void
    {
        $this->app->register(CommandServiceProvider::class);
    }

    private function bindRoutes(): void
    {
        Route::prefix('admin')
            ->middleware(['web', 'admin'])
            ->group(__DIR__.'/../Routes/admin.php');
    }
}
