<?php

namespace App\Livewire\Authentication;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Layout;

#[Lazy]
#[Layout('components.layouts.authentication')]
class Login extends Component
{
    public function render()
    {
        return view('livewire.authentication.login');
    }
}
