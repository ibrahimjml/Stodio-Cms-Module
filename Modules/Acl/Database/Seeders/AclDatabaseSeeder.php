<?php

namespace Modules\Acl\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Acl\Models\Permission;
use Modules\Acl\Models\Role;
use Modules\Acl\Models\User;
use Modules\Acl\Services\PermissionSyncService;

class AclDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $result = app(PermissionSyncService::class)->sync();

        $this->command?->info("Permissions synced. Total: {$result['total']}, created: {$result['created']}.");

        $adminRole = Role::query()->firstOrCreate(
            ['slug' => 'administrator'],
            ['name' => 'Administrator', 'is_default' => true, 'created_by' => 1, 'updated_by' => 1],
        );

        $adminRole->syncPermissions(
            Permission::query()->pluck('id')->all()
        );

        $superRole = Role::query()->firstOrCreate(
            ['slug' => 'super'],
            ['name' => 'Super Admin', 'is_default' => false, 'created_by' => 1, 'updated_by' => 1],
        );

        $superRole->syncPermissions(
            Permission::query()->pluck('id')->all()
        );

        User::query()->where('super_user', true)->each(
            fn (User $user) => $user->assignRole($superRole)
        );
    }
}
