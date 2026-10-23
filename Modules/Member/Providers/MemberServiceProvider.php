<?php

namespace Modules\Member\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\LoadDataTrait;
use Modules\Member\Http\Middleware\RedirectIfMember;
use Modules\Member\Http\Middleware\RedirectIfNotMember;
use Modules\Member\Models\Member;

class MemberServiceProvider extends ServiceProvider
{
    use LoadDataTrait;

    public function register(): void
    {
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

        $router = $this->app['router'];

        $router->aliasMiddleware('member', RedirectIfNotMember::class);
        $router->aliasMiddleware('member.guest', RedirectIfMember::class);
    }

    public function boot(): void
    {
        $this->loadHelpers()
              ->loadAndPublishConfigurations(['config','permission'])
              ->publishAssets();
              
        $this->registerAdminRoutes();
    }

    private function registerAdminRoutes(): void
    {
        Route::prefix('admin')
            ->name('admin.')
            ->middleware(['web', 'admin'])
            ->group(__DIR__.'/../Routes/admin.php');
    }
}
