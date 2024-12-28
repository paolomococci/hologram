<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::lower(fake()->firstName());
        $surname = Str::lower(fake()->lastName());
        $username = $name.'.'.$surname.(string) mt_rand(0, 9);

        return [
            'name' => $name,
            'surname' => $surname,
            'nickname' => fake()->word(),
            'email' => $username.'.'.fake()->safeEmailDomain(),
            'email_checked_at' => fake()->boolean(50) ? fake()->date() : null,
            'temporary_token' => Str::ulid()->toBase32(),
            'isSuspended' => fake()->numberBetween(0, 1),
        ];
    }
}
