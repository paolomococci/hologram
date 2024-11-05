<?php

use App\Models\Author;
use Illuminate\Support\Str;

test('to test the possibility of registering a new author in the database', function () {
    $username = fake()->userName();
    $author = new Author([
        'name' => $username,
        'nickname' => fake()->word(),
        'email' => $username . '.' . fake()->safeEmailDomain(),
        'email_checked_at' => fake()->dateTimeBetween('-1 week', now()),
        'temporary_token' => Str::ulid()->toBase32(),
        'suspended' => fake()->numberBetween(0, 1),
    ]);

    $storedAuthor = Author::factory()->create([
        'name' => $author['name'],
        'nickname' => $author['nickname'],
        'email' => $author['email'],
        'email_checked_at' => $author['email_checked_at'],
        'temporary_token' => $author['temporary_token'],
        'suspended' => $author['suspended'],
    ]);

    expect($storedAuthor->name)->toBeString()->toBe($author['name']);
    expect($storedAuthor->nickname)->toBeString()->toBe($author['nickname']);
    expect($storedAuthor->email)->toBeString()->toBe($author['email']);
    expect($storedAuthor->email_checked_at)->not->toBeEmpty()->toBe($author['email_checked_at']);
    expect($storedAuthor->temporary_token)->toBeString()->toBe($author['temporary_token']);
    expect($storedAuthor->suspended)->toBeInt()->toBe($author['suspended']);
});
