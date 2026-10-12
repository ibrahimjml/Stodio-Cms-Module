<?php

namespace Modules\ModuleManagement\Services;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\Artisan;

class ModuleMigrationRunner
{
    public function __construct(
        private readonly Migrator $migrator,
    ) {}

    public function migrationsPath(string $module): string
    {
        return (string) config('modules.path', base_path('Modules')).'/'.$module.'/Database/Migrations';
    }

    public function hasMigrations(string $module): bool
    {
        $path = $this->migrationsPath($module);

        return is_dir($path) && count(glob($path.'/*.php') ?: []) > 0;
    }

    /**
     * Number of migration files in the module that have not run yet.
     */
    public function pending(string $module): int
    {
        $path = $this->migrationsPath($module);

        if (! is_dir($path)) {
            return 0;
        }

        $ran = $this->migrator->getRepository()->getRan();

        return count(array_diff_key(
            $this->migrator->getMigrationFiles([$path]),
            array_flip($ran),
        ));
    }

    /**
     * @return array{success: bool, message: string}
     */
    public function run(string $module, bool $seed = false): array
    {
        try {
            Artisan::call('module:migrate', [
                'module' => $module,
                '--seed' => $seed,
            ]);

            return [
                'success' => true,
                'message' => trim(Artisan::output()) ?: "Migrations ran for module [{$module}].",
            ];
        } catch (\Throwable $exception) {
            return ['success' => false, 'message' => $exception->getMessage()];
        }
    }

    /**
     * Roll back every migration belonging to the given module.
     *
     * @return array{success: bool, message: string}
     */
    public function rollback(string $module): array
    {
        try {
            $exitCode = Artisan::call('module:migrate-rollback', [
                'module' => $module,
                '--force' => true,
            ]);

            return [
                'success' => $exitCode === 0,
                'message' => trim(Artisan::output()) ?: "Migrations rolled back for module [{$module}].",
            ];
        } catch (\Throwable $exception) {
            return ['success' => false, 'message' => $exception->getMessage()];
        }
    }
}
