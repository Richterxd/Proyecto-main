<?php

namespace App\Livewire\Dashboard\Modal\Personas\Usuarios;

use App\Models\Personas;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class ShowUsuarios extends Component
{
    public $showModalShow = false;
    public $persona = null, $user = null;

    #[On('openModalShowFromUsuarios')]
    public function openModalShow(Personas $persona)
    {
        $this->persona = $persona;
        $this->user = User::where('personas_cedula', $persona->cedula)->first();
        $this->persona->nacimiento->format('d-m-Y');
        $this->showModalShow = true;
    }

    public function closeModalShow()
    {
        $this->persona = new Personas();
        $this->user = new User();
        $this->showModalShow = false;
    }

    public function openModalEdit(Personas $persona)
    {
        $this->dispatch('openModalEditFromShowUsuarios', persona: $persona);
        $this->persona = new Personas();
        $this->user = new User();
        $this->showModalShow = false;
    }

    public function mount()
    {
        $this->persona = new Personas();
        $this->user = new User();
    }

    public function render()
    {
        return view('livewire.dashboard.modal.personas.usuarios.show-usuarios');
    }
}
