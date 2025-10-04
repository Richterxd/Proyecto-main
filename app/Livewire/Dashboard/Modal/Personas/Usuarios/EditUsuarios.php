<?php

namespace App\Livewire\Dashboard\Modal\Personas\Usuarios;

use App\Models\Personas;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EditUsuarios extends Component
{
    public $showModalEdit = false;
    public $loadingEdit = false;

    public $nombre = '', $segundo_nombre = '', $apellido = '', $segundo_apellido = '';
    public $nacionalidad = '', $cedula = '1';
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
        'cedula' => 'required|numeric|digits_between:6,8',
        'prefijo_telefono' => 'required|in:0412,0422,0414,0424,0416,0426',
        'telefono' => 'required|string|regex:/^\d{3}-\d{4}$/',
        'email' => 'required|string|email|max:100',
        'nacimiento' => 'required|date',
        'role' => 'required|in:1,2,3',
        'genero' => 'required|in:masculino,femenino,no_binario,no_decir',
        'direccion' => 'required|string|max:100',
        'password' => 'nullable|string|min:8|confirmed',
    ];

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'segundo_nombre' => 'required|string|max:50',
            'segundo_apellido' => 'required|string|max:50',
            'nacionalidad' => 'required|in:V,E,J',
            'cedula' => 'required|numeric|digits_between:6,8|unique:personas,cedula,' . $this->cedula . ',cedula',
            'prefijo_telefono' => 'required|in:0412,0422,0414,0424,0416,0426',
            'telefono' => 'required|string|regex:/^\d{3}-\d{4}$/',
            'email' => 'required|string|email|max:100|unique:personas,email,' . $this->cedula . ',cedula',
            'nacimiento' => 'required|date',
            'role' => 'required|in:1,2,3',
            'genero' => 'required|in:masculino,femenino,no_binario,no_decir',
            'direccion' => 'required|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function closeModalEdit()
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
        $this->showModalEdit = false;
    }

    #[On('openModalEditFromShowUsuarios')]
    #[On('openModalEditFromUsuarios')]
    public function openModalEdit(Personas $persona)
    {
        $this->showModalEdit = true;

        preg_match('/^(\d{4})[- ]?(.*)/', $persona->telefono, $matches);

        $this->nombre = $persona->nombre;
        $this->apellido = $persona->apellido;
        $this->segundo_nombre = $persona->segundo_nombre;
        $this->segundo_apellido = $persona->segundo_apellido;
        $this->cedula = $persona->cedula;
        $this->nacionalidad = $persona->nacionalidad;
        $this->nacimiento = $persona->nacimiento->format('Y-m-d');
        $this->genero = $persona->genero;
        $this->direccion = $persona->direccion;
        $this->role = $persona->usuario->role ?? 3;
        $this->prefijo_telefono = $matches[1] ?? 0416;
        $this->telefono = $matches[2] ?? 1;
        $this->email = $persona->email;
    }

    #[On('loadingEditFromEditConfirmation')]
    public function loadingEdit($loadingEdit)
    {
        $this->loadingEdit = $loadingEdit;
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

    public function saveConfirmation($cedula_persona)
    {
        $this->validate();
        $this->dispatch('editUsuariosSaveConfirmation', cedula_persona: $cedula_persona);
        $this->loadingEdit = true;
    }

    #[On('authEditUsuariosFromEditConfirmation')]
    public function save($cedula_persona)
    {
        $this->validateAge();
        $this->validate();
        $this->dispatch('loadingEdit');

        $edit = Personas::find($cedula_persona);

        $edit->nombre = $this->nombre;
        $edit->apellido = $this->apellido;
        $edit->segundo_nombre = $this->segundo_nombre;
        $edit->segundo_apellido = $this->segundo_apellido;
        $edit->cedula = $this->cedula;
        $edit->nacionalidad = $this->nacionalidad;
        $edit->genero = $this->genero;
        $edit->nacimiento = $this->nacimiento;
        $edit->direccion = $this->direccion;
        $edit->telefono = $this->prefijo_telefono . '-' . $this->telefono;
        $edit->email = $this->email;

        $edit->usuario->role = $this->role;
        $edit->usuario->password = Hash::make($this->password);

        $edit->save();

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
        $this->showModalEdit = false;
        $this->loadingEdit = false;
        $this->dispatch('renderUsuario');
    }

    public function render()
    {
        return view('livewire.dashboard.modal.personas.usuarios.edit-usuarios');
    }
}
