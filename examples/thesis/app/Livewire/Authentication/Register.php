<?php

namespace App\Livewire\Authentication;

use App\Livewire\Forms\ApplicantForm;
use App\Models\Applicant;
use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Lazy]
#[Layout('components.layouts.authentication')]
class Register extends Component
{
    public ApplicantForm $applicantForm;

    #[Validate('required|min:8')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:12')]
    public string $password = '';

    // temporarily unused field
    public bool $rememberMe = false;

    public string $registerMessage = '';

    public function registerAnApplicant()
    {
        // dd($this->name, $this->email, $this->password, $this->rememberMe);
        $this->validate();
        try {
            $this->applicantForm->save(
                $this->name,
                $this->email,
                $this->password
            );
            $this->redirectRoute('home');
        } catch (\Exception $e) {
            // TODO: throw $e;
            $this->registerMessage = 'The credentials are not usable!';
            $this->redirectRoute('register');
        }
    }

    public function render()
    {
        return view('livewire.authentication.register');
    }
}
