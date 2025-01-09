<?php

namespace App\Livewire\UserInterface\Catenaria;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Welcome extends Component
{
    public function render()
    {
        return view('livewire.user-interface.catenaria.welcome');
    }
}
