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
        $username = fake()->userName();

        return [
            'name' => $username,
            'nickname' => fake()->word(),
            'email' => $username.'.'.fake()->safeEmailDomain(),
            'email_checked_at' => fake()->dateTimeBetween('-1 week', now()),
            'temporary_token' => Str::ulid()->toBase32(),
            'suspended' => fake()->numberBetween(0, 1),
        ];
    }

    /**
     * Indicates which field in the model may not have been verified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_checked_at' => null,
        ]);
    }
}
