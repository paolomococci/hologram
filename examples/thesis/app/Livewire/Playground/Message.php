<?php

namespace App\Livewire\Playground;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.playground')]
class Message extends Component
{
    public function render()
    {
        return view('livewire.playground.message');
    }
}
