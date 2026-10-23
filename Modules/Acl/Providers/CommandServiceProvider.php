<?php

namespace Modules\Acl\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Acl\Console\CreateUserCommand;
use Modules\Acl\Console\SyncPermissionsCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if($this->app->runningInConsole()){
            $this->commands([
                CreateUserCommand::class,
                SyncPermissionsCommand::class
            ]);
        }
    }
}
