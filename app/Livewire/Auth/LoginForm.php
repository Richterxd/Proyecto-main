<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginForm extends Component
{
    public $cedula = '';
    public $password = '';

    protected $rules = [
        'cedula' => ['required'],
        'password' => ['required'],
    ];

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['persona_cedula' => $this->cedula, 'password' => $this->password])) {

            throw ValidationException::withMessages([
                'cedula' => trans('Verifique sus datos'),
            ]);
        }

        return redirect()->intended('/dashboard');
    }

    public function render()
    {
        return view('livewire.auth.login-form')->layout('auth.login');
    }
}
