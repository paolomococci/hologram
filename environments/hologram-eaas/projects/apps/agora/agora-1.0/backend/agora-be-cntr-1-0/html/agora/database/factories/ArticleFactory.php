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
            'summary' => fake()->words(7, true),
            'content' => fake()->paragraph(10),
            'sortable_token' => Str::ulid()->toBase32(),
            'deprecated' => fake()->numberBetween(0, 1),
        ];
    }
}
