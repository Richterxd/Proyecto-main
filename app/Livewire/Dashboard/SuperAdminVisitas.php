<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class SuperAdminVisitas extends Component
{

    public $currentStep='list';

    public function render()
    {
        return view('livewire.dashboard.super-admin-visitas')->layout('components.layouts.rbac');
    }
}
