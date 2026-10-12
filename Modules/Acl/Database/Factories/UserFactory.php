<?php

namespace Modules\Acl\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Acl\Models\User;
use Modules\Core\Enums\UserImage;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'avatar' => UserImage::AVATAR->value,
            'remember_token' => Str::random(10),
            'super_user' => true,
            'manage_supers' => true,
        ];
    }
}
