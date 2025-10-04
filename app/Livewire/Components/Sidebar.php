<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Sidebar extends Component
{
    public $showPersonasSubmenu = false;
    public $showSolicitudesSubmenu = false;
    public $showReunionesSubmenu = false;
    public $osultarSidebar = true;

    public function toggleSidebar()
    {
        $this->osultarSidebar = !$this->osultarSidebar;
    }

    public function togglePersonasSubmenu()
    {
        $this->showPersonasSubmenu = !$this->showPersonasSubmenu;
    }

    public function toggleSolicitudesSubmenu()
    {
        $this->showSolicitudesSubmenu = !$this->showSolicitudesSubmenu;
    }

    public function toggleReunionesSubmenu()
    {
        $this->showReunionesSubmenu = !$this->showReunionesSubmenu;
    }

    public function render()
    {
        return view('livewire.components.sidebar');
    }
}
