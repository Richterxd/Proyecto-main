<?php

namespace App\Livewire\Dashboard;

use App\Models\Solicitud;
use App\Models\Visita;
use App\Models\Ambito;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdministradorDashboard extends Component
{
    public $activeTab = 'dashboard';
    public $solicitudes;
    public $visitas;
    public $ambitos;
    public $usuarios;

    public function mount()
    {
        $this->activeTab = request()->get('tab', 'dashboard');
        $this->loadData();
    }

    public function loadData()
    {
        // Load all solicitudes for admin view (view-only)
        $this->solicitudes = Solicitud::with(['persona', 'ambito', 'personasAsociadas', 'visitadorAsignado'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Load all visitas for admin view
        $this->visitas = Visita::with(['persona', 'ambito'])
            ->orderBy('fecha', 'desc')
            ->get();
            
        $this->ambitos = Ambito::all();
        $this->usuarios = User::with('persona')->get();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.dashboard.administrador-dashboard')->layout('components.layouts.rbac');
    }

    // Add method to redirect to CRUD component
    public function redirectToCrud()
    {
        return redirect()->route('dashboard.administrador', ['tab' => 'crud']);
    }
}