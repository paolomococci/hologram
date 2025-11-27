<?php

use App\Livewire\Search;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Search::class)
        ->assertStatus(200);
});
