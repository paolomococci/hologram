<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tag'         => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            // pseudo-random generation of a boolean with specific probability, for example, that in 30% of cases it is equal to true
            'is_done'     => $this->faker->boolean(30),
        ];
    }
}
