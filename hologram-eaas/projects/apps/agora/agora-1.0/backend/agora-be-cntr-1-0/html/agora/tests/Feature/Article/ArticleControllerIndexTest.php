<?php

use App\Models\Article;

test('test the number of articles stored in the database', function () {
    $response = $this->get('/articles');
    $response->assertOk();
    $response->assertJsonCount(Article::count());
});
