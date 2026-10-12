<?php

namespace Modules\Member\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Member\Http\Middleware\RedirectIfMember;
use Modules\Member\Http\Middleware\RedirectIfNotMember;
use Modules\Member\Models\Member;

class MemberServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'member');

        config([
            'auth.guards.member' => [
                'driver' => 'session',
                'provider' => 'members',
            ],
            'auth.providers.members' => [
                'driver' => 'eloquent',
                'model' => Member::class,
            ],
            'auth.passwords.members' => [
                'provider' => 'members',
                'table' => 'member_password_resets',
                'expire' => 60,
            ],
        ]);

    }

    public function boot(): void
    {
        $router = $this->app['router'];

        $router->aliasMiddleware('member', RedirectIfNotMember::class);
        $router->aliasMiddleware('member.guest', RedirectIfMember::class);

        $this->registerAdminRoutes();

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);

            $this->publishes([
                __DIR__.'/../Config/config.php' => config_path('member.php'),
            ], 'member-config');

            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/member'),
            ], 'member-assets');
        }
          if ($this->app->make('files')->exists(__DIR__.'/../Helpers/helpers.php')) {
            $this->app->make('files')->requireOnce(__DIR__.'/../Helpers/helpers.php');
        }
    }

    private function registerAdminRoutes(): void
    {
        Route::prefix('admin')
            ->name('admin.')
            ->middleware(['web', 'admin'])
            ->group(__DIR__.'/../Routes/admin.php');
    }
}
