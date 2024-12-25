<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'subject' => fake()->words(5, true),
            'content' => fake()->paragraph(20),
            'deprecated' => fake()->numberBetween(0, 1),
            'published' => fake()->numberBetween(0, 1),
            'sortable_token' => Str::ulid()->toBase32(),
        ];
    }
}
