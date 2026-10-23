<?php

namespace Modules\Acl\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Acl\Http\Middleware\CheckPermission;
use Modules\Acl\Http\Middleware\CheckRole;
use Modules\Acl\Http\Middleware\RedirectIfAdmin;
use Modules\Acl\Http\Middleware\RedirectIfNotAdmin;
use Modules\Acl\Models\User;
use Modules\Acl\Policies\UserPolicy;
use Modules\Acl\Services\PermissionSyncService;
use Modules\Core\Traits\LoadDataTrait;

class AclServiceProvider extends ServiceProvider
{
    use LoadDataTrait;
    
    public function register(): void
    {
        config()->set(['auth.providers.users.model' => User::class]);
    }

    public function boot(): void
    {
        $this->registerCommands();

        $this->loadHelpers()
             ->loadAndPublishConfigurations(['config','permission'])
             ->publishAssets();

        $router = $this->app['router'];

        $router->aliasMiddleware('admin', RedirectIfNotAdmin::class);
        $router->aliasMiddleware('admin.guest', RedirectIfAdmin::class);
        $router->aliasMiddleware('permission', CheckPermission::class);
        $router->aliasMiddleware('role', CheckRole::class);

        $this->registerBladeDirectives();
        $this->registerAuthorization();
        $this->registerAdminRoutes();

    }

    private function registerBladeDirectives(): void
    {
        Blade::if('role', function (string ...$roles): bool {
            $user = auth()->user();

            return $user !== null && method_exists($user, 'hasAnyRole') && $user->hasAnyRole($roles);
        });

        Blade::if('permission', function (string ...$permissions): bool {
            $user = auth()->user();

            return $user !== null && method_exists($user, 'hasAnyPermission') && $user->hasAnyPermission($permissions);
        });
    }

    private function registerAdminRoutes(): void
    {
        Route::prefix('admin')
            ->name('admin.')
            ->middleware(['web', 'admin'])
            ->group(__DIR__.'/../Routes/admin.php');
    }

    private function registerAuthorization(): void
    {
        Gate::policy(User::class, UserPolicy::class);

        Gate::before(function (object $user): ?bool {
            if (! $user instanceof User) {
                return null;
            }

            if ($user->isSuperUser() && $user->manage_supers) {
                return true;
            }

            return null;
        });

        foreach (app(PermissionSyncService::class)->discover() as $item) {
            $name = $item['name'];

            if (Gate::has($name)) {
                continue;
            }

            Gate::define($name, function (object $user) use ($name): bool {
                return $user instanceof User && $user->hasPermission($name);
            });
        }
    }

    private function registerCommands(): void
    {
        $this->app->register(CommandServiceProvider::class);
    }
}
