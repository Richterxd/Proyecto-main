<?php

namespace App\Livewire\Dashboard\Modal\Personas\Usuarios;

use App\Models\Personas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\On;

class DestroyUsuarios extends Component
{
    public $showModalDestroy = false;
    public $persona = null;

    public $passwordDestroy = '';

    #[On('openModalDestroyFromUsuarios')]
    public function openModalDestroy(Personas $persona)
    {
        $this->persona = $persona;
        $this->showModalDestroy = true;
    }

    public function closeModalDestroy()
    {
        $this->showModalDestroy = false;
        $this->persona = new Personas();
    }

    public function destroy(Personas $persona)
    {
        if (Hash::check($this->passwordDestroy, Auth::user()->password)) {

            $persona->delete();

            $this->showModalDestroy = false;
            $this->dispatch('renderUsuario');
        }
    }

    public function mount()
    {
        $this->persona = new Personas();
    }

    public function render()
    {
        return view('livewire.dashboard.modal.personas.usuarios.destroy-usuarios');
    }
}
