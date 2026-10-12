<?php

namespace Modules\Member\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Core\Enums\UserImage;
use Modules\Member\Models\Member;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'avatar' => UserImage::AVATAR->value,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (Member $user) {

            $user->profile()->create([
                'is_public' => $this->faker->boolean(),
                'member_id' => $user->getKey(),
                'bio' => $this->faker->sentence(),
                'cover_photo' => UserImage::COVER->value,
            ]);
        });
    }
}
