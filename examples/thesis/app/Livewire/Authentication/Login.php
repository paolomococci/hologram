<?php

namespace App\Livewire\Authentication;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Validate;
use Livewire\Component;
use ReflectionClass;

#[Lazy]
#[Layout('components.layouts.authentication')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:12')]
    public string $password = '';

    // temporarily unused field
    public bool $rememberMe = false;

    public string $loginMessage = '';

    public function authentication()
    {
        // $reflector = new ReflectionClass(Auth::class);
        // dd($reflector);
        // dd($this->email, $this->password, $this->rememberMe);

        $this->validate();
        try {
            $isValid = Auth::attempt([
                'email' => $this->email,
                'password' => $this->password,
            ]);
            // use credential verification
            if ($isValid) {
                $this->redirectIntended('/dashboard');
            } else {
                $this->loginMessage = 'The credentials provided are not correct!';
                $this->redirect('/login');
            }
        } catch (\Exception $e) {
            // TODO: throw $e;
            $this->loginMessage = 'The credentials provided are not correct!';
            $this->redirectRoute('home');
        }
    }

    public function render()
    {
        return view('livewire.authentication.login');
    }
}
