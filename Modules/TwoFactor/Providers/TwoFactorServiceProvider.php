<?php

namespace Modules\TwoFactor\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Generator;
use Modules\Acl\Models\User;
use Modules\Core\Traits\LoadDataTrait;
use Modules\Member\Models\Member;
use Modules\TwoFactor\Contracts\Services\TwoFactorAuthContract;
use Modules\TwoFactor\Services\TwoFactorService;

class TwoFactorServiceProvider extends ServiceProvider
{
    use LoadDataTrait;

    public function register(): void
    {
        
        $this->app->singleton(TwoFactorAuthContract::class, function ($app) {
            return new TwoFactorService(
                $app->make(Google2FA::class),
                $app->make(Generator::class)
            );
        });
    }
    
    public function boot(): void
    {
        $this->morphRelation();

        $this->loadHelpers()
             ->loadAndPublishConfigurations(['config','permission'])
             ->publishAssets();

        $this->adminRoutes();

       $this->app->booted(function (): void {
            $this->app->register(ActionServiceProvider::class);
        });
    }

    private function morphRelation()
    {
        Relation::morphMap([
           User::TABLE => User::class,
           Member::TABLE => Member::class
    ]);
    }

    private function adminRoutes()
    {
        Route::prefix('admin/twofactor')
            ->name('twofactor.')
            ->middleware('web')
            ->group(__DIR__.'/../Routes/admin.php');
    }
}
