<?php

test('welcome feature test status is ok', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
