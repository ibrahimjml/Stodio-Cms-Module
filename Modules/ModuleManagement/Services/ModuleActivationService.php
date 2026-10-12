<?php

namespace Modules\ModuleManagement\Services;

use Ibrahimjml\LaravelModules\ModuleManager;
use Illuminate\Support\Facades\File;
use Modules\Core\Models\Setting;

class ModuleActivationService
{
    public const SETTING_KEY = 'activated_modules';

    public function __construct(
        private readonly ModuleManager $modules,
    ) {}

    /**
     * Excluded Module names.
     *
     * @return array<int, string>
     */
    public function excluded(): array
    {
        return config('modulemanagement.excluded_modules', []);
    }

    /**
     * Module names that are currently activated.
     *
     * @return array<int, string>
     */
    public function activated(): array
    {
        return Setting::get(self::SETTING_KEY, []);
    }

    /**
     * Seed the activated modules into the settings table if not already set.
     */
    public function seedActivatedModules(): void
    {
        if (Setting::get(self::SETTING_KEY) !== null) {
            return;
        }

        Setting::set(self::SETTING_KEY, $this->modules->enabled()->keys()->all());
    }

    public function isActive(string $name): bool
    {
        return $this->isExcluded($name) || in_array($name, $this->activated(), true);
    }

    public function isExcluded(string $name): bool
    {
        return in_array($name, $this->excluded(), true);
    }

    public function activate(string $name): void
    {
        $activated = $this->activated();

        if (! in_array($name, $activated, true)) {
            $activated[] = $name;
            Setting::set(self::SETTING_KEY, $activated);
        }

        $this->modules->enable($name);
    }

    public function deactivate(string $name): void
    {
        $activated = array_values(array_filter(
            $this->activated(),
            fn (string $module): bool => $module !== $name,
        ));

        Setting::set(self::SETTING_KEY, $activated);

        $this->modules->disable($name);
    }

    /**
     * Forget a module that no longer exists on disk and re-sync the
     * activated modules stored in the settings table and the statuses file.
     */
    public function forget(string $name): void
    {
        $activated = array_values(array_filter(
            $this->activated(),
            fn (string $module): bool => $module !== $name,
        ));

        Setting::set(self::SETTING_KEY, $activated);

        $this->forgetStatus($name);

        $this->modules->forget();
    }

    /**
     * Remove the module entry from the statuses file so it no longer
     * lingers as enabled after the module directory is deleted.
     */
    private function forgetStatus(string $name): void
    {
        $path = (string) config('modules.statuses_file');

        if (! File::exists($path)) {
            return;
        }

        $statuses = json_decode(File::get($path), true) ?? [];

        if (array_key_exists($name, $statuses)) {
            unset($statuses[$name]);

            File::put(
                $path,
                json_encode($statuses, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL,
            );
        }
    }
}
