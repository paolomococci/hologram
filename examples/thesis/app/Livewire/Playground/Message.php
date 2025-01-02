<?php

namespace App\Livewire\Playground;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.playground')]
class Message extends Component
{
    public function render()
    {
        return view('livewire.playground.message');
    }
}
