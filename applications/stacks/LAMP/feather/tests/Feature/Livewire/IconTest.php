<?php

use App\Livewire\Icon;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Icon::class)
        ->assertStatus(200);
});
