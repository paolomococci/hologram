<?php

namespace App\Livewire\Playground;

use Livewire\Component;

class Binding extends Component
{
    public string $title = '';

    public string $explanation = '';

    public function render()
    {
        return view('livewire.playground.binding');
    }
}
