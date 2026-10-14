<?php

namespace Modules\Auditlog\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auditlog\Console\ClearAllAuditlogCommand;
use Modules\Auditlog\Console\ClearOldAuditlogCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if($this->app->runningInConsole()){
            $this->commands([
               ClearAllAuditlogCommand::class,
               ClearOldAuditlogCommand::class
            ]);
        }
    }
}
