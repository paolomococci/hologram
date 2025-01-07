<?php

namespace App\Livewire\View;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Reactive;
use Livewire\Component;

#[Lazy]
class Results extends Component
{
    #[Reactive]
    public $results = [];

    #[Reactive]
    public bool $show = false;

    public function render()
    {
        return view('livewire.view.results');
    }
}
