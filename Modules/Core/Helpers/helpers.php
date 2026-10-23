<?php

use Ibrahimjml\LaravelModules\ModuleManager;
use Modules\Core\Models\Setting;
use Illuminate\Support\Str;

if (! function_exists('svg')) {

    function svg(string $name): string
    {
        $path = base_path("Modules/Core/Resources/svg/{$name}.svg");

        if (file_exists($path)) {
            return file_get_contents($path);
        }

        return '';
    }
}

if (! function_exists('module_enabled')) {

    /**
     * Determine whether a module is currently enabled in modules_statuses.json.
     *
     * Use this to guard any code that depends on an optional module so that
     * disabling the module skips the work instead of throwing.
     */
    function module_enabled(string $name): bool
    {
        return app(ModuleManager::class)->isEnabled($name);
    }
}

if (! function_exists('setting')) {

    /**
     * Read a value from the settings table from anywhere in the app.
     */
    function setting(string $key, $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('module_asset')) {

    function module_asset(string $module, string $path): string
    {
        $moduleName = Str::studly($module);

        return asset('vendor/core/' . $moduleName . '/' . ltrim($path, '/'));
    }
}