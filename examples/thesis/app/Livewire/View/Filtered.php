<?php

namespace App\Livewire\View;

use Livewire\Component;
use Livewire\Attributes\Reactive;

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
