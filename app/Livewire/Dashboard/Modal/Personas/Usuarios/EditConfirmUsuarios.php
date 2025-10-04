<?php

namespace App\Livewire\Dashboard\Modal\Personas\Usuarios;

use Livewire\Component;
use Livewire\Attributes\On;

class EditConfirmUsuarios extends Component
{
    public $showModalEditConfirmation = false;
    public $persona = '';

    public function closeModalEditConfirmation()
    {
        $loadingEdit = false;
        $this->showModalEditConfirmation = !$this->showModalEditConfirmation;
        $this->dispatch('loadingEditFromEditConfirmation', loadingEdit: $loadingEdit);
    }

    public function authEdit()
    {
        $this->dispatch('authEditUsuariosFromEditConfirmation', cedula_persona: $this->persona);
        $this->reset(['persona']);
        $this->showModalEditConfirmation = false;
    }

    #[On('editUsuariosSaveConfirmation')]
    public function openModalEditConfirmation($cedula_persona)
    {
        $this->persona = $cedula_persona;
        $this->showModalEditConfirmation = true;
    }

    public function render()
    {
        return view('livewire.dashboard.modal.personas.usuarios.edit-confirm-usuarios');
    }
}
