<?php

namespace Modules\Acl\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Acl\Models\Role;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->jobTitle(),
            'is_default' => false,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
