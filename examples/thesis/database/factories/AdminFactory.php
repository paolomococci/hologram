<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // temporary code, later I will refer to an email already registered in the table `users`.
        $name = Str::replace(['. ', ' ', '\'', '`', '"'], ['.', '.', '.', '.', '.'], Str::lower(fake()->name()));
        $name .= (string) mt_rand(0, 9);
        $email = $name.(fake()->boolean(50) ? '@thesis.local' : '@example.local');

        return [
            'email' => $email,
            'password' => Hash::make($email),
            'remember_token' => Str::random(10),
        ];
    }
}
