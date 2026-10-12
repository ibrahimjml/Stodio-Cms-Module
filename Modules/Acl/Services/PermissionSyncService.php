<?php

namespace Modules\Acl\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Acl\Models\Permission;

class PermissionSyncService
{
    // Discover all permissions declared in each module's Config permission file.
    public function discover(): Collection
    {
        $permissions = collect();

        foreach (glob(base_path('Modules/*/Config/permission.php')) ?: [] as $file) {
            $config = require $file;

            if (! is_array($config)) {
                continue;
            }

            $module = $config['module'] ?? basename(dirname(dirname($file)));
            $items = $config['permissions'] ?? [];

            foreach ($items as $item) {
                if (is_string($item)) {
                    $item = ['name' => $item];
                }

                if (empty($item['name'])) {
                    continue;
                }

                $permissions->push([
                    'name' => $item['name'],
                    'module' => $item['module'] ?? $module,
                    'description' => $item['description'] ?? null,
                ]);
            }
        }

        return $permissions->unique('name')->values();
    }

    /**
     * Sync discovered permissions into the database.
     *
     * @return array{created: int, updated: int, total: int}
     */
    public function sync(): array
    {
        $discovered = $this->discover();
        $created = 0;
        $updated = 0;

        foreach ($discovered as $item) {
            $permission = Permission::query()->firstOrNew(['name' => $item['name']]);
            $isNew = ! $permission->exists;

            $permission->fill([
                'slug' => $permission->slug ?: Str::slug($item['name']),
                'module' => $item['module'],
                'description' => $item['description'],
            ]);
            $permission->save();

            if ($isNew) {
                $created++;
            } else {
                $updated++;
            }
        }

        return ['created' => $created, 'updated' => $updated, 'total' => $discovered->count()];
    }
}
