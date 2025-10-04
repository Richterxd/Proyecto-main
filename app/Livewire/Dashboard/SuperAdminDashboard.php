<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use App\Models\Personas;
use App\Models\Solicitud;
use App\Models\Visita;
use App\Models\Ambito;
use App\Models\Institucion;
use App\Models\Role;
use Livewire\Component;

class SuperAdminDashboard extends Component
{
    public $activeTab = 'dashboard';
    public $usuarios;
    public $solicitudes;
    public $visitas;
    public $ambitos;
    public $instituciones;
    public $roles;

    // Solicitud management properties
    public $editingSolicitudId = null;
    public $editingSolicitudObservations = '';
    public $selectedVisitor = null;

    public function mount()
    {
        $this->activeTab = request()->get('tab', 'dashboard');
        $this->loadData();
    }

    public function loadData()
    {
        $this->usuarios = User::with('persona')->get();
        $this->solicitudes = Solicitud::with(['persona', 'ambito', 'personasAsociadas', 'visitadorAsignado'])
            ->orderBy('fecha_creacion', 'desc')
            ->get();
        $this->visitas = Visita::with(['persona', 'ambito'])->orderBy('fecha', 'desc')->get();
        $this->ambitos = Ambito::all();
        $this->instituciones = Institucion::all();
        $this->roles = Role::all();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function changeUserRole($userId, $newRole)
    {
        $user = User::find($userId);
        if ($user) {
            $user->role = $newRole;
            $user->save();
            $this->loadData();
            $this->dispatch('show-message', [
                'message' => 'Rol actualizado correctamente',
                'type' => 'success'
            ]);
        }
    }

    public function updateSolicitudStatus($solicitudId, $newStatus)
    {
        $solicitud = Solicitud::find($solicitudId);
        if ($solicitud) {
            $solicitud->estado_detallado = $newStatus;
            $solicitud->fecha_actualizacion = now();
            $solicitud->save();
            $this->loadData();
            $this->dispatch('show-message', [
                'message' => 'Estado de solicitud actualizado correctamente',
                'type' => 'success'
            ]);
        }
    }

    public function assignVisitor($solicitudId, $visitorId)
    {
        $solicitud = Solicitud::find($solicitudId);
        if ($solicitud) {
            $solicitud->visitador_asignado = $visitorId;
            $solicitud->estado_detallado = 'Asignada';
            $solicitud->fecha_actualizacion = now();
            $solicitud->save();
            $this->loadData();
            $this->dispatch('show-message', [
                'message' => 'Visitador asignado correctamente',
                'type' => 'success'
            ]);
        }
    }

    public function updateSolicitudObservations($solicitudId, $observations)
    {
        $solicitud = Solicitud::find($solicitudId);
        if ($solicitud) {
            $solicitud->observaciones_admin = $observations;
            $solicitud->fecha_actualizacion = now();
            $solicitud->save();
            $this->loadData();
            $this->dispatch('show-message', [
                'message' => 'Observaciones actualizadas correctamente',
                'type' => 'success'
            ]);
        }
    }

    public function editSolicitudObservations($solicitudId)
    {
        $this->editingSolicitudId = $solicitudId;
        $solicitud = Solicitud::find($solicitudId);
        if ($solicitud) {
            $this->editingSolicitudObservations = $solicitud->observaciones_admin ?? '';
        }
    }

    public function saveObservations()
    {
        if ($this->editingSolicitudId) {
            $this->updateSolicitudObservations($this->editingSolicitudId, $this->editingSolicitudObservations);
            $this->editingSolicitudId = null;
            $this->editingSolicitudObservations = '';
        }
    }

    public function cancelEditObservations()
    {
        $this->editingSolicitudId = null;
        $this->editingSolicitudObservations = '';
    }

    public function viewSolicitud($solicitudId)
    {
        // This method would open a modal or redirect to a detail view
        $this->dispatch('show-message', [
            'message' => 'Función de vista detallada en desarrollo',
            'type' => 'info'
        ]);
    }

    public function deleteSolicitud($id)
    {
        $solicitud = Solicitud::find($id);
        if ($solicitud) {
            $solicitud->delete();
            $this->loadData();
            $this->dispatch('show-message', [
                'message' => 'Solicitud eliminada correctamente',
                'type' => 'success'
            ]);
        }
    }

    public function deleteVisita($id)
    {
        $visita = Visita::find($id);
        if ($visita) {
            $visita->delete();
            $this->loadData();
            $this->dispatch('show-message', [
                'message' => 'Visita eliminada correctamente',
                'type' => 'success'
            ]);
        }
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);
        if ($user && $user->persona_cedula != auth()->user()->persona_cedula) {
            $user->delete();
            $this->loadData();
            $this->dispatch('show-message', [
                'message' => 'Usuario eliminado correctamente',
                'type' => 'success'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.super-admin-dashboard')->layout('components.layouts.rbac');
    }

    // Add method to redirect to CRUD component
    public function redirectToCrud()
    {
        return redirect()->route('dashboard.super-admin', ['tab' => 'crud']);
    }
}