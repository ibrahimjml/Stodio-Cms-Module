<?php

namespace Modules\Auditlog\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auditlog\Actions\CreateSystemAccessLog;
use Modules\Auditlog\Actions\CreateSystemLoggedOutLog;

class ActionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
         add_action(LOG_AUTH_ACTION_AFTER_LOGIN_SYSTEM, function ($user) {
           app(CreateSystemAccessLog::class)->logAccess($user);
        });

         add_action(LOG_AUTH_ACTION_AFTER_LOGOUT_SYSTEM, function ($user) {
           app(CreateSystemLoggedOutLog::class)->log($user);
        });
    }
}
