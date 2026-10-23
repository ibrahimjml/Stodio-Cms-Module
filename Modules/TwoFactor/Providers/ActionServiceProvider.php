<?php

namespace Modules\TwoFactor\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\TwoFactor\Actions\RedirectIfTwoFactorAuthenticatable;

class ActionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! setting('twofactor.enabled')) {
                return;
        }
        add_filter(ACL_LOGIN_PIPELINE, function (array $pipeline): array {
            if (! setting('twofactor.enabled')) {
                return $pipeline;
            }

            return array_merge([
                RedirectIfTwoFactorAuthenticatable::class,
            ], $pipeline);
        }, 999);
    }
}
