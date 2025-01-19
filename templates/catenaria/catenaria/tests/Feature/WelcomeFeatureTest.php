<?php

test('welcome feature test', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
