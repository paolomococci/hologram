<?php

use App\Models\Author;

test('test the number of authors stored in the database', function () {
    $response = $this->get('/authors');
    $response->assertOk();
    $response->assertJsonCount(Author::count());
});
