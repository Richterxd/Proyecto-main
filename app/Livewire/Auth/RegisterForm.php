<?php

namespace App\Livewire\Auth;

use App\Models\Personas;
use App\Models\User;
use App\Models\SecurityQuestion;
use App\Models\UserSecurityAnswer;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterForm extends Component
{
    public $currentStep = 1;
    public $nombre = '', $segundo_nombre = '', $apellido = '', $segundo_apellido = '';
    public $nacionalidad = '', $cedula = '';
    public $prefijo_telefono = '', $telefono = '';
    public $email = '';
    public $nacimiento = '', $genero = '';
    public $direccion = '';
    public $password = '', $password_confirmation = '';
    public $captchaQuestion = '', $captchaAnswer = '';
    public $ageError = '';
    
    // Security questions
    public $securityQuestions = [];
    public $selectedQuestions = [];
    public $securityAnswers = [];

    protected $rules = [
        'nombre' => 'required|string|max:50',
        'apellido' => 'required|string|max:50',
        'segundo_nombre' => 'required|string|max:50',
        'segundo_apellido' => 'required|string|max:50',
        'nacionalidad' => 'required|in:V,E,J',
        'cedula' => 'required|numeric|digits_between:6,8|unique:personas,cedula',
        'prefijo_telefono' => 'required|in:0412,0422,0414,0424,0416,0426',
        'telefono' => 'required|string|regex:/^\d{3}-\d{4}$/',
        'email' => 'required|string|email|max:100|unique:personas',
        'nacimiento' => 'required|date',
        'genero' => 'required|in:masculino,femenino,no_binario,no_decir',
        'direccion' => 'required|string|max:100',
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*()])/'
        ],
        'captchaAnswer' => 'required|numeric',
        'selectedQuestions.0' => 'required|different:selectedQuestions.1,selectedQuestions.2',
        'selectedQuestions.1' => 'required|different:selectedQuestions.0,selectedQuestions.2', 
        'selectedQuestions.2' => 'required|different:selectedQuestions.0,selectedQuestions.1',
        'securityAnswers.0' => 'required|string|min:2',
        'securityAnswers.1' => 'required|string|min:2',
        'securityAnswers.2' => 'required|string|min:2',
    ];

    protected $messages = [
        'nacimiento.before' => 'Debes ser mayor de 18 años para registrarte.',
        'password.regex' => 'La contraseña debe contener al menos una mayúscula y un carácter especial (!@#$%^&*()).',
        'selectedQuestions.*.different' => 'Debes seleccionar preguntas diferentes.',
        'securityAnswers.*.required' => 'Todas las respuestas de seguridad son obligatorias.',
        'securityAnswers.*.min' => 'Las respuestas deben tener al menos 2 caracteres.',
    ];

    public function mount()
    {
        $this->generateCaptcha();
        $this->securityQuestions = SecurityQuestion::where('is_active', true)->get();
        $this->selectedQuestions = ['', '', ''];
        $this->securityAnswers = ['', '', ''];
    }

    public function generateCaptcha()
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $this->captchaQuestion = "$num1 + $num2 = ?";
        $this->captchaAnswer = $num1 + $num2;
    }

    public function nextStep()
    {
        if ($this->currentStep == 2) {
            $this->validateAge();
            if ($this->ageError) return;
        }

        $this->validateStep();
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    private function validateStep()
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'nombre' => 'required',
                'apellido' => 'required',
                'segundo_nombre' => 'required',
                'segundo_apellido' => 'required'
            ]);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'nacionalidad' => 'required',
                'cedula' => 'required|numeric|digits_between:6,8|unique:personas,cedula',
                'prefijo_telefono' => 'required',
                'telefono' => 'required|regex:/^\d{3}-\d{4}$/',
                'email' => 'required|email|unique:personas',
                'nacimiento' => 'required|date',
                'genero' => 'required'
            ]);
        } elseif ($this->currentStep === 3) {
            $this->validate([
                'direccion' => 'required',
                'password' => [
                    'required',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*()])/'
                ]
            ], $this->messages);
        } elseif ($this->currentStep === 4) {
            $this->validate([
                'selectedQuestions.0' => 'required|different:selectedQuestions.1,selectedQuestions.2',
                'selectedQuestions.1' => 'required|different:selectedQuestions.0,selectedQuestions.2',
                'selectedQuestions.2' => 'required|different:selectedQuestions.0,selectedQuestions.1',
                'securityAnswers.0' => 'required|string|min:2',
                'securityAnswers.1' => 'required|string|min:2',
                'securityAnswers.2' => 'required|string|min:2',
            ], $this->messages);
        }
    }

    public function validateAge()
    {
        $this->ageError = '';
        $birthday = new \DateTime($this->nacimiento);
        $today = new \DateTime();
        $age = $today->diff($birthday)->y;

        if ($age < 18) {
            $this->ageError = 'Debes ser mayor de 18 años para registrarte.';
        }
    }

    public function register()
    {
        $this->validate();
        $this->validateAge();

        if ($this->ageError) {
            $this->currentStep = 2;
            return;
        }

        // Create persona
        $persona = Personas::create([
            'nombre' => $this->nombre,
            'segundo_nombre' => $this->segundo_nombre,
            'apellido' => $this->apellido,
            'segundo_apellido' => $this->segundo_apellido,
            'nacionalidad' => $this->nacionalidad,
            'cedula' => $this->cedula,
            'telefono' => $this->prefijo_telefono . '-' . $this->telefono,
            'email' => $this->email,
            'nacimiento' => $this->nacimiento,
            'genero' => $this->genero,
            'direccion' => $this->direccion,
        ]);

        // Create user
        $user = User::create([
            'persona_cedula' => $this->cedula,
            'role' => 3,
            'password' => Hash::make($this->password),
        ]);

        // Save security questions and answers
        for ($i = 0; $i < 3; $i++) {
            UserSecurityAnswer::create([
                'user_cedula' => $this->cedula,
                'security_question_id' => $this->selectedQuestions[$i],
                'answer_hash' => Hash::make(strtolower(trim($this->securityAnswers[$i]))),
            ]);
        }

        auth()->login($user);

        return $this->redirect('/dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register-form')->layout('auth.register');
    }
}
