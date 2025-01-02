<?php

namespace App\Livewire\Playground;

use Livewire\Component;

class Something extends Component
{
    public string $title = '';

    public string $explanation = '';

    public function render()
    {
        return view('livewire.playground.something');
    }
}
