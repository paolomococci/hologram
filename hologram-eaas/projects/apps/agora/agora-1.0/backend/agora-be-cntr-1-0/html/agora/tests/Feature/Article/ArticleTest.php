<?php

use App\Models\Article;
use Illuminate\Support\Str;

test('to test the possibility of registering a new article in the database', function () {
    $article = new Article([
        'title' => fake()->sentence(3),
        'subject' => fake()->words(5, true),
        'summary' => fake()->words(7, true),
        'content' => fake()->paragraph(10),
        'sortable_token' => Str::ulid()->toBase32(),
        'deprecated' => fake()->numberBetween(0, 1),
    ]);

    $storedArticle = Article::factory()->create([
        'title' => $article['title'],
        'subject' => $article['subject'],
        'summary' => $article['summary'],
        'content' => $article['content'],
        'sortable_token' => $article['sortable_token'],
        'deprecated' => $article['deprecated'],
    ]);

    expect($storedArticle->title)->toBeString()->toBe($article['title']);
    expect($storedArticle->subject)->toBeString()->toBe($article['subject']);
    expect($storedArticle->summary)->toBeString()->toBe($article['summary']);
    expect($storedArticle->content)->toBeString()->toBe($article['content']);
    expect($storedArticle->sortable_token)->toBeString()->toBe($article['sortable_token']);
    expect($storedArticle->deprecated)->toBeInt()->toBe($article['deprecated']);
});
