<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Support\Action;
use Modules\Core\Support\Filter;
use Modules\Core\Traits\LoadDataTrait;

class CoreServiceProvider extends ServiceProvider
{
    use LoadDataTrait;

    public function register(): void
    {
        $this->loadAndPublishConfigurations(['config', 'permission']);
        $this->app->singleton('core.action', Action::class);
        $this->app->singleton('core.filter', Filter::class);
    }

    public function boot(): void
    {
        $this->loadBladeDirectives();
        $this->loadHelpers()
             ->publishAssets();

    }

    private function loadBladeDirectives(): void
    {
        Blade::directive('svg', function ($arguments) {
            return "<?php 
            \$args = [$arguments];
            \$name = \$args[0] ?? '';
            
            \$path = base_path(\"Modules/Core/Resources/svg/{\$name}.svg\");
            
            if (file_exists(\$path)) {
                \$svg = file_get_contents(\$path);
                echo \$svg;
            }
        ?>";
        });
    }

}
