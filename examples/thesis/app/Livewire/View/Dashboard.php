<?php

namespace App\Livewire\View;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.view.dashboard');
    }
}
