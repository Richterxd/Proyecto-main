<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class SuperadminUsuarios extends Component
{
    public function render()
    {
        return view('livewire.dashboard.superadmin-usuarios')->layout('components.layouts.rbac');
    }
}
