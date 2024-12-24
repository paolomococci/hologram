<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Article;
use App\Models\Contributor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contributor>
 */
class ContributorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $exist = true;

        while ($exist) {
            $randomArticleId = rand(1, Article::all()->count());
            $randomAuthorId = rand(1, Author::all()->count());
            $result = Contributor::where('article_id', $randomArticleId)->where('author_id', $randomAuthorId)->first();
            $exist = ($result != null);
        }

        return [
            'is_main_author' => fake()->boolean(50) ? 1 : 0,
            'article_id' => $randomArticleId,
            'author_id' => $randomAuthorId,
        ];
    }
}
