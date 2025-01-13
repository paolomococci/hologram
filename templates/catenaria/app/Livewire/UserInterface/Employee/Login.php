<?php

namespace App\Livewire\UserInterface\Employee;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Login extends Component
{
    public function render()
    {
        return view('livewire.user-interface.employee.login');
    }
}
