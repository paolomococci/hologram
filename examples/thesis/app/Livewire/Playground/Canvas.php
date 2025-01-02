<?php

namespace App\Livewire\Playground;

use Livewire\Component;

class Canvas extends Component
{
    public string $title = '';

    public string $explanation = '';

    public function render()
    {
        return view('livewire.playground.canvas');
    }
}
