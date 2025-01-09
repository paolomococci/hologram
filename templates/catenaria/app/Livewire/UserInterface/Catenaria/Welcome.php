<?php

namespace App\Livewire\UserInterface\Catenaria;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Welcome extends Component
{
    public function render()
    {
        return view('livewire.user-interface.catenaria.welcome');
    }
}
