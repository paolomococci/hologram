<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Applicant;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApplicantForm extends Form
{
    public ?Applicant $applicant;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $remember_token = '';

    public function save(
        $name,
        $email,
        $password
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->password = Hash::make($this->password);
        $this->remember_token = Str::random(10);

        try {
            Applicant::create($this->only(
                'name',
                'email',
                'password',
                'remember_token',
            ));
        } catch (\Exception $e) {
            // TODO: throw $e;
        }
    }
}
