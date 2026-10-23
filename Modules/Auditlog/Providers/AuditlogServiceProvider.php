<?php

namespace Modules\Auditlog\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Console\PruneCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Auditlog\Models\AuditLog;
use Modules\Core\Traits\LoadDataTrait;

class AuditlogServiceProvider extends ServiceProvider
{
    use LoadDataTrait;

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerEvents();
        $this->registerCommands();
        
        $this->loadHelpers()
             ->loadAndPublishConfigurations(['config','permission'])
             ->publishAssets();

        $this->bindRoutes();

        if ($this->app->runningInConsole()) {
            
            $this->app->afterResolving(Schedule::class, function (Schedule $schedule): void {
                $schedule
                    ->command(PruneCommand::class, ['--model' => AuditLog::class])
                    ->dailyAt('00:30');
            });
        
        }

        $this->app->booted(function (): void {
            $this->app->register(ActionServiceProvider::class);
        });
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
