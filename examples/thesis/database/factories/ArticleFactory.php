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
        $sortableToken = Str::ulid()->toBase32();
        $notifications = [];
        array_push(
            $notifications,
            fake()->randomElement([
                'email',
                'bulletin_board',
                'phone',
            ])
        );
        return [
            'title' => fake()->realText(35) . ' (' . $sortableToken . ')',
            'subject' => fake()->realText(100),
            'content' => fake()->realText(1500),
            'isPublished' => fake()->numberBetween(0, 1),
            'isDeprecated' => fake()->numberBetween(0, 1),
            'notifications' => $notifications,
            'sortable_token' => $sortableToken,
        ];
    }
}
