<?php

namespace App\Livewire\Dashboard;

use App\Models\Solicitud;
use App\Models\Ambito;
use App\Models\SolicitudPersonaAsociada;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SolicitudCrud extends Component
{
    use WithPagination;

    public $activeTab = 'list';
    public $solicitudes;
    public $selectedSolicitud = null;
    public $editingSolicitud = null;
    public $showingModal = false;
    
    // Form fields
    public $titulo = '';
    public $categoria = '';
    public $subcategoria = '';
    public $descripcion = '';
    public $parroquia = '';
    public $comunidad = '';
    public $direccion_detallada = '';
    
    // Admin fields
    public $estado_detallado = '';
    public $observaciones_admin = '';
    public $visitador_asignado = '';
    
    public $categories = [
        'servicios' => [
            'title' => 'Servicios',
            'subcategories' => [
                'agua' => 'Agua',
                'electricidad' => 'Electricidad',
                'telecomunicaciones' => 'Telecomunicaciones',
                'gas_comunal' => 'Gas Comunal',
                'gas_directo_tuberia' => 'Gas Directo por Tubería'
            ]
        ],
        'social' => [
            'title' => 'Social',
            'subcategories' => [
                'educacion_inicial' => 'Educación Inicial',
                'educacion_basica' => 'Educación Básica',
                'educacion_secundaria' => 'Educación Secundaria',
                'educacion_universitaria' => 'Educación Universitaria'
            ]
        ],
        'sucesos_naturales' => [
            'title' => 'Sucesos Naturales',
            'subcategories' => [
                'huracanes' => 'Huracanes',
                'tormentas_tropicales' => 'Tormentas Tropicales',
                'terremotos' => 'Terremotos'
            ]
        ]
    ];

    protected $rules = [
        'titulo' => 'required|min:5|max:100',
        'categoria' => 'required|in:servicios,social,sucesos_naturales',
        'subcategoria' => 'required',
        'descripcion' => 'required|min:50|max:5000',
        'parroquia' => 'required|min:3|max:50',
        'comunidad' => 'required|min:3|max:50',
        'direccion_detallada' => 'required|min:10|max:200',
    ];

    public function mount()
    {
        $this->loadSolicitudes();
    }

    public function loadSolicitudes()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador()) {
            // Super admin can see all solicitudes
            $this->solicitudes = Solicitud::with(['persona', 'ambito', 'personasAsociadas'])
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->isAdministrador()) {
            // Admin can see all solicitudes (read-only)
            $this->solicitudes = Solicitud::with(['persona', 'ambito', 'personasAsociadas'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Users can only see their own solicitudes
            $this->solicitudes = Solicitud::with(['ambito', 'personasAsociadas'])
                ->where('persona_cedula', $user->persona_cedula)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetForm();
    }

    public function viewSolicitud($solicitudId)
    {
        $this->selectedSolicitud = Solicitud::with(['persona', 'ambito', 'personasAsociadas'])
            ->find($solicitudId);
        
        if (!$this->selectedSolicitud) {
            session()->flash('error', 'Solicitud no encontrada');
            return;
        }
        
        // Check permissions
        if (!$this->canViewSolicitud($this->selectedSolicitud)) {
            session()->flash('error', 'No tienes permisos para ver esta solicitud');
            return;
        }
        
        $this->showingModal = true;
    }

    public function editSolicitud($solicitudId)
    {
        $solicitud = Solicitud::find($solicitudId);
        
        if (!$solicitud) {
            session()->flash('error', 'Solicitud no encontrada');
            return;
        }
        
        if (!$this->canEditSolicitud($solicitud)) {
            session()->flash('error', 'No tienes permisos para editar esta solicitud');
            return;
        }
        
        $this->editingSolicitud = $solicitud;
        $this->titulo = $solicitud->titulo;
        $this->categoria = $solicitud->categoria;
        $this->subcategoria = $solicitud->subcategoria;
        $this->descripcion = $solicitud->descripcion;
        $this->parroquia = $solicitud->parroquia;
        $this->comunidad = $solicitud->comunidad;
        $this->direccion_detallada = $solicitud->direccion_detallada;
        $this->estado_detallado = $solicitud->estado_detallado;
        $this->observaciones_admin = $solicitud->observaciones_admin;
        $this->visitador_asignado = $solicitud->visitador_asignado;
        
        $this->activeTab = 'edit';
    }

    public function updateSolicitud()
    {
        if (!$this->editingSolicitud) {
            session()->flash('error', 'No hay solicitud seleccionada para editar');
            return;
        }
        
        if (!$this->canEditSolicitud($this->editingSolicitud)) {
            session()->flash('error', 'No tienes permisos para editar esta solicitud');
            return;
        }
        
        $this->validate();
        
        try {
            $updateData = [
                'titulo' => $this->titulo,
                'categoria' => $this->categoria,
                'subcategoria' => $this->subcategoria,
                'descripcion' => $this->descripcion,
                'parroquia' => $this->parroquia,
                'comunidad' => $this->comunidad,
                'direccion_detallada' => $this->direccion_detallada,
                'fecha_actualizacion' => now()
            ];
            
            // Only super admin can update admin fields
            if (Auth::user()->isSuperAdministrador()) {
                $updateData['estado_detallado'] = $this->estado_detallado;
                $updateData['observaciones_admin'] = $this->observaciones_admin;
                $updateData['visitador_asignado'] = $this->visitador_asignado;
            }
            
            $this->editingSolicitud->update($updateData);
            
            $this->resetForm();
            $this->activeTab = 'list';
            $this->loadSolicitudes();
            
            session()->flash('success', 'Solicitud actualizada exitosamente');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar la solicitud: ' . $e->getMessage());
        }
    }

    public function deleteSolicitud($solicitudId)
    {
        $solicitud = Solicitud::find($solicitudId);
        
        if (!$solicitud) {
            session()->flash('error', 'Solicitud no encontrada');
            return;
        }
        
        if (!$this->canDeleteSolicitud($solicitud)) {
            session()->flash('error', 'No tienes permisos para eliminar esta solicitud');
            return;
        }
        
        try {
            // Delete associated persons first
            SolicitudPersonaAsociada::where('solicitud_id', $solicitud->id)->delete();
            
            // Delete solicitud
            $solicitud->delete();
            
            $this->loadSolicitudes();
            session()->flash('success', 'Solicitud eliminada exitosamente');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar la solicitud: ' . $e->getMessage());
        }
    }

    public function updateStatus($solicitudId, $newStatus)
    {
        $solicitud = Solicitud::find($solicitudId);
        
        if (!$solicitud) {
            session()->flash('error', 'Solicitud no encontrada');
            return;
        }
        
        if (!Auth::user()->isSuperAdministrador()) {
            session()->flash('error', 'No tienes permisos para cambiar el estado');
            return;
        }
        
        try {
            $solicitud->update([
                'estado_detallado' => $newStatus,
                'fecha_actualizacion' => now()
            ]);
            
            $this->loadSolicitudes();
            session()->flash('success', 'Estado actualizado exitosamente');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showingModal = false;
        $this->selectedSolicitud = null;
    }

    public function resetForm()
    {
        $this->titulo = '';
        $this->categoria = '';
        $this->subcategoria = '';
        $this->descripcion = '';
        $this->parroquia = '';
        $this->comunidad = '';
        $this->direccion_detallada = '';
        $this->estado_detallado = '';
        $this->observaciones_admin = '';
        $this->visitador_asignado = '';
        $this->editingSolicitud = null;
        $this->resetValidation();
    }

    // Permission check methods
    private function canViewSolicitud($solicitud)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador() || $user->isAdministrador()) {
            return true;
        }
        
        return $solicitud->persona_cedula === $user->persona_cedula;
    }

    private function canEditSolicitud($solicitud)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador()) {
            return true;
        }
        
        if ($user->isAdministrador()) {
            return false; // Admins can only view
        }
        
        return $solicitud->persona_cedula === $user->persona_cedula;
    }

    private function canDeleteSolicitud($solicitud)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador()) {
            return true;
        }
        
        if ($user->isAdministrador()) {
            return false; // Admins can only view
        }
        
        return $solicitud->persona_cedula === $user->persona_cedula;
    }

    public function render()
    {
        return view('livewire.dashboard.solicitud-crud')->layout('components.layouts.rbac');
    }
}