<?php

namespace App\Livewire\Auth;

use App\Models\Personas;
use App\Models\SecurityQuestion;
use App\Models\User;
use App\Models\UserSecurityAnswer;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class PasswordRecoveryForm extends Component
{
    public $step = 1; // 1: cedula input, 2: security questions, 3: new password
    public $cedula = '';
    public $user = null;
    public $persona = null;
    public $securityQuestions = [];
    public $userAnswers = [];
    public $newPassword = '';
    public $confirmPassword = '';
    
    public $messages = [
        'cedula.required' => 'La cédula es obligatoria.',
        'cedula.exists' => 'No se encontró un usuario con esta cédula.',
        'userAnswers.*.required' => 'Esta respuesta es obligatoria.',
        'newPassword.required' => 'La nueva contraseña es obligatoria.',
        'newPassword.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'newPassword.regex' => 'La contraseña debe contener al menos una mayúscula y un carácter especial (!@#$%^&*()).',
        'confirmPassword.required' => 'Debe confirmar la nueva contraseña.',
        'confirmPassword.same' => 'Las contraseñas no coinciden.',
    ];

    public function findUser()
    {
        $this->validate([
            'cedula' => 'required|exists:personas,cedula'
        ], $this->messages);

        $this->persona = Personas::where('cedula', $this->cedula)->first();
        $this->user = User::where('persona_cedula', $this->cedula)->first();
        
        if (!$this->user) {
            $this->addError('cedula', 'No se encontró un usuario asociado a esta cédula.');
            return;
        }

        $userSecurityAnswers = $this->user->securityAnswers()->with('securityQuestion')->get();
        
        if ($userSecurityAnswers->isEmpty()) {
            $this->addError('cedula', 'Este usuario no tiene preguntas de seguridad configuradas.');
            return;
        }

        $this->securityQuestions = $userSecurityAnswers;
        $this->userAnswers = array_fill(0, $userSecurityAnswers->count(), '');
        $this->step = 2;
    }

    public function verifyAnswers()
    {
        // Validate all answers are provided
        $rules = [];
        foreach ($this->securityQuestions as $index => $question) {
            $rules["userAnswers.{$index}"] = 'required';
        }
        
        $this->validate($rules, $this->messages);

        // Check if all answers are correct
        $correctAnswers = 0;
        foreach ($this->securityQuestions as $index => $securityAnswer) {
            if ($securityAnswer->checkAnswer($this->userAnswers[$index])) {
                $correctAnswers++;
            }
        }

        // Require all answers to be correct
        if ($correctAnswers !== count($this->securityQuestions)) {
            $this->addError('general', 'Una o más respuestas son incorrectas. Por favor, verifica tus respuestas.');
            return;
        }

        $this->step = 3;
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*()])/'],
            'confirmPassword' => 'required|same:newPassword'
        ], $this->messages);

        // Update the user's password
        $this->user->update([
            'password' => Hash::make($this->newPassword)
        ]);

        session()->flash('success', 'Tu contraseña ha sido actualizada exitosamente.');
        return redirect()->route('login');
    }

    public function goBack()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function render()
    {
        return view('livewire.auth.password-recovery-form')
            ->layout('auth.password-recovery');
    }
}