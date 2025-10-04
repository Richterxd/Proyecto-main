<?php

namespace App\Livewire\Dashboard\Modal\Personas\Usuarios;

use App\Models\Personas;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class CreateUsuarios extends Component
{
    use WithPagination;

    public $nombre = '', $segundo_nombre = '', $apellido = '', $segundo_apellido = '';
    public $nacionalidad = '', $cedula = '';
    public $role = '';
    public $prefijo_telefono = '', $telefono = '';
    public $email = '';
    public $nacimiento = '', $genero = '';
    public $direccion = '';
    public $password = '', $password_confirmation = '';
    public $ageError = '';

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
        'role' => 'required|in:1,2,3',
        'genero' => 'required|in:masculino,femenino,no_binario,no_decir',
        'direccion' => 'required|string|max:100',
        'password' => 'required|string|min:8|confirmed',
    ];

    public $showModal = false;

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset([
            'nombre',
            'apellido',
            'segundo_nombre',
            'segundo_apellido',
            'cedula',
            'nacionalidad',
            'genero',
            'nacimiento',
            'direccion',
            'role',
            'prefijo_telefono',
            'telefono',
            'email',
            'password',
            'password_confirmation',
            'ageError'
        ]);
        $this->resetValidation();
        $this->showModal = false;
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

    public function save()
    {
        $this->validateAge();
        $this->validate();

        if ($this->ageError) {
            return;
        }

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

        $user = User::create([
            'personas_cedula' => $this->cedula,
            'role' => $this->role,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', '¡Nuevo suario con éxito!');
        $this->reset([
            'nombre',
            'apellido',
            'segundo_nombre',
            'segundo_apellido',
            'cedula',
            'nacionalidad',
            'genero',
            'nacimiento',
            'direccion',
            'role',
            'prefijo_telefono',
            'telefono',
            'email',
            'password',
            'password_confirmation',
            'ageError',
            'showModal'
        ]);
        $this->resetValidation();
        $this->dispatch('renderUsuario');
    }

    public function render()
    {
        return view('livewire.dashboard.modal.personas.usuarios.create-usuarios');
    }
}
