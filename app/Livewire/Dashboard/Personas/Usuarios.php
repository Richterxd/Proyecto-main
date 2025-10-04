<?php

namespace App\Livewire\Dashboard\Personas;

use App\Models\Personas;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Usuarios extends Component
{
    use WithPagination;

    public $search = '', $sort = 'cedula', $direction = 'desc';

    public $usuariosTotal = 0, $sA = 0, $a = 0, $u = 0;

    //RENDERIZACION DE LOS MODALES
    public function openModalEdit($cedula_persona)
    {
        $this->dispatch('openModalEditFromUsuarios', persona: $cedula_persona);
    }

    public function openModalShow($cedula_persona)
    {
        $this->dispatch('openModalShowFromUsuarios', persona: $cedula_persona);
    }

    public function openModalDestroy($cedula_persona)
    {
        $this->dispatch('openModalDestroyFromUsuarios', persona: $cedula_persona);
    }
    //}}

    public function orden($sort)
    {
        if ($this->sort == $sort) {

            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function mount()
    {
        $users = User::all();

        foreach ($users as $user) {
            $this->usuariosTotal++;
            if ($user->role == 3) {
                $this->u++;
            } elseif ($user->role == 2) {
                $this->a++;
            } else {
                $this->sA++;
            }
        }
    }

    #[On('renderUsuario')]
    public function render()
    {

        $personas = Personas::query();

        if ($this->search) {

            $personas->where('cedula', 'like', '%' . $this->search . '%')
                ->orWhere('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('apellido', 'like', '%' . $this->search . '%')
                ->orWhere('segundo_nombre', 'like', '%' . $this->search . '%')
                ->orWhere('segundo_apellido', 'like', '%' . $this->search . '%')
                ->orWhere('telefono', 'like', '%' . $this->search . '%')
                ->orderBy($this->sort, $this->direction)
                ->get();
        }

        $personas->orderBy($this->sort, $this->direction);

        $personas = $personas->paginate(10);

        return view('livewire.dashboard.personas.usuarios', [
            'personas' => $personas
        ]);
    }
}
