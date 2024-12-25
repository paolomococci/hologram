<?php

namespace App\Livewire\View;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class Filtered extends Component
{
    #[Reactive]
    public $results = [];

    #[Reactive]
    public bool $show = false;

    public function render()
    {
        return view('livewire.view.filtered');
    }
}
