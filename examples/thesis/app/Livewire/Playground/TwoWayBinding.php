<?php

namespace App\Livewire\Playground;

use Livewire\Component;

class TwoWayBinding extends Component
{
    public string $title = '';

    public string $explanation = '';

    public function render()
    {
        return view('livewire.playground.two-way-binding');
    }
}
