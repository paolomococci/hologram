<?php

namespace App\Livewire\UserInterface\Employee;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Lazy]
#[Layout('components.layouts.app')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:12')]
    public string $password = '';

    public string $loginMessage = '';

    public function authentication() {
        // TODO: authentication of employee
    }

    public function render()
    {
        return view('livewire.user-interface.employee.login');
    }
}
