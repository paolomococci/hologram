<?php

namespace App\Livewire\UserInterface\Candidate;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Lazy]
#[Layout('components.layouts.app')]
class Register extends Component
{
    #[Validate('required|min:3')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:12')]
    public string $password = '';

    public string $loginMessage = '';

    public function registration() {
        // TODO: registration of candidate
    }

    public function render()
    {
        return view('livewire.user-interface.candidate.register');
    }
}
