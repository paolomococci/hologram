<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Applicant>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $username = Str::replace(['. ', ' ', '\'', '`', '"'], ['.', '.', '.', '.', '.'], Str::lower($name));
        $username .= (string) mt_rand(0, 9);
        $email = $username.(fake()->boolean(50) ? '@thesis.local' : '@example.local');

        return [
            'name' => $name,
            'email' => $email,
            'email_verified_at' => fake()->boolean(50) ? now() : null,
            'password' => Hash::make($email),
            'remember_token' => Str::random(10),
        ];
    }
}
