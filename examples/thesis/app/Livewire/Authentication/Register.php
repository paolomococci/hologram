<?php

namespace App\Livewire\Authentication;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Lazy]
#[Layout('components.layouts.authentication')]
class Register extends Component
{
    #[Validate('required|min:8')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:12')]
    public string $password = '';

    public bool $rememberMe = false;

    public string $registerMessage = '';

    public function registerAnApplicant() {
        dd(
            $this->name,
            $this->email,
            $this->password,
            $this->rememberMe
        );
    }

    public function render()
    {
        return view('livewire.authentication.register');
    }
}
