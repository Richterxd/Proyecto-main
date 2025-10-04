<?php

namespace App\Livewire\Dashboard\Personas\Trabajadores;

use App\Models\Trabajador;
use Livewire\Component;

class Index extends Component
{
    public $search = '';

    public function render()
    {
        $trabajador = Trabajador::query();

        if ($this->search) {

            $trabajador->where('cedula', 'like', '%' . $this->search . '%')
                ->orWhere('nombres', 'like', '%' . $this->search . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                ->orWhere('telefono', 'like', '%' . $this->search . '%')
                ->orWhere('correo', 'like', '%' . $this->search . '%')
                ->get();
        }

        $trabajador = $trabajador->paginate(10);

        return view('livewire.dashboard.personas.trabajadores.index', [
            'trabajadores' => $trabajador
        ]);
    }
}
