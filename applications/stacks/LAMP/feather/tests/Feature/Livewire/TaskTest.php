<?php

use App\Livewire\Task;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Task::class)
        ->assertStatus(200);
});
