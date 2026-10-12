<?php

namespace Modules\Acl\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Acl\Models\Permission;

/**
 * @extends Factory<Permission>
 */
class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        $name = fake()->unique()->slug(2);

        return [
            'name' => $name,
            'module' => 'Acl',
            'description' => fake()->sentence(),
        ];
    }
}
