<?php

namespace App\Livewire\Dashboard;

use App\Models\Reunion;
use App\Models\Solicitud;
use App\Models\Institucion;
use App\Models\Personas;
use App\Models\Asisten;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SuperAdminReuniones extends Component
{
    use WithPagination;

    // pagination theme
    protected $paginationTheme = 'disenoPagination'; 

    // ordenar reuniones
    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';
    public $estadoSolicitud = 'todo';
    public $reuniones = [];
    public $solicitudes = [];
    public $instituciones = [];
    public $todasPersonas = [];
    public $consejales = [];

    // cambiar vistas
    public $activeTab = 'list';

    // data
    public $selectedReunion = null;
    public $editingReunion = null;
    public $showingModal = false;

    // Form fields
    public $titulo = '';
    public $descripcion = '';
    public $fecha_reunion = '';
    public $ubicacion = '';
    public $institucion_id = '';
    public $solicitud_id = '';
    
    // Asistentes
    public $selectedAsistentes = [];
    public $selectedConsejales = [];
    public $searchPersonas = '';

    protected $rules = [
        'titulo' => 'required|min:5|max:100',
        'descripcion' => 'required|min:10|max:1000',
        'fecha_reunion' => 'required|date|after_or_equal:today',
        'ubicacion' => 'required|min:5|max:200',
        'institucion_id' => 'required|exists:instituciones,id',
        'solicitud_id' => 'nullable|exists:solicitudes,solicitud_id',
    ];

    protected $messages = [
        'titulo.required' => 'El título es obligatorio',
        'titulo.min' => 'El título debe tener al menos 5 caracteres',
        'titulo.max' => 'El título no puede exceder los 100 caracteres',
        'descripcion.required' => 'La descripción es obligatoria',
        'descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
        'descripcion.max' => 'La descripción no puede exceder los 1000 caracteres',
        'fecha_reunion.required' => 'La fecha de reunión es obligatoria',
        'fecha_reunion.date' => 'La fecha debe ser una fecha válida',
        'fecha_reunion.after_or_equal' => 'La fecha no puede ser anterior a hoy',
        'ubicacion.required' => 'La ubicación es obligatoria',
        'ubicacion.min' => 'La ubicación debe tener al menos 5 caracteres',
        'ubicacion.max' => 'La ubicación no puede exceder los 200 caracteres',
        'institucion_id.required' => 'La institución es obligatoria',
        'institucion_id.exists' => 'La institución seleccionada no es válida',
        'solicitud_id.exists' => 'La solicitud seleccionada no es válida',
    ];

    public function mount($activeTab = 'list', $reunionId = null, $solicitudId = null)
    {
        $this->resetForm();
        
        $tab = request()->get('tab', $activeTab);

        // Si viene de una solicitud específica, prellenar el solicitud_id
        if ($solicitudId) {
            $this->solicitud_id = $solicitudId;
        }

        if ($tab === 'crear' || $tab === 'create') {
            $this->activeTab = 'create';
        } elseif ($tab === 'editar' || $tab === 'edit' && $reunionId) {
            $this->editReunion($reunionId);
        } else {
            $this->activeTab = 'list';
        }

        $this->loadReuniones();
        $this->loadInitialData();
    }

    public function loadInitialData()
    {
        $this->solicitudes = Solicitud::select('solicitud_id', 'titulo')->orderBy('fecha_creacion', 'desc')->get();
        $this->instituciones = Institucion::select('id', 'titulo')->orderBy('titulo')->get();
        $this->loadPersonas();
        $this->loadConsejales();
    }

    public function loadPersonas()
    {
        $query = Personas::query();

        if ($this->searchPersonas) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->searchPersonas . '%')
                  ->orWhere('apellido', 'like', '%' . $this->searchPersonas . '%')
                  ->orWhere('cedula', 'like', '%' . $this->searchPersonas . '%');
            });
        }

        $this->todasPersonas = $query->orderBy('nombre')->limit(50)->get();
    }

    public function loadConsejales()
    {
        // Consejales son usuarios con rol 1 (super admin)
        $this->consejales = User::where('role', 1)
                                ->with('persona')
                                ->get()
                                ->map(function($user) {
                                    return $user->persona;
                                })
                                ->filter()
                                ->values();
    }

    public function loadReuniones()
    {
        if (Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador()) {
            
            $query = Reunion::query()->with(['institucion', 'solicitud', 'asistentes']);

            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('titulo', 'like', '%' . $this->search . '%')
                        ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                        ->orWhere('ubicacion', 'like', '%' . $this->search . '%')
                        ->orWhere('fecha_reunion', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('institucion', function ($q) {
                    $q->where('titulo', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('solicitud', function ($q) {
                    $q->where('solicitud_id', 'like', '%' . $this->search . '%')
                      ->orWhere('titulo', 'like', '%' . $this->search . '%');
                });
            }
            
            $query->orderBy($this->sort, $this->direction);

            $this->reuniones = $query->get();
            
            return $query->paginate(10);

        } else {
            $this->dispatch('show-message', [
                'message' => 'Error al cargar las reuniones: No tienes permisos para ver esta sección',
                'type' => 'error'
            ]);
        }
    }

    public function setActiveTab($tab)
    {
        if ($tab === 'create' && !$this->canCreateReunion()) {
            session()->flash('error', 'No tienes permisos para crear reuniones');
            return;
        }

        $this->activeTab = $tab;
        $this->resetForm();
    }

    public function submit()
    {
        $this->validate();
        
        try {
            if ($this->editingReunion && Auth::user()->isSuperAdministrador()) {
                // Update existing reunion
                if (!$this->canEditReunion($this->editingReunion)) {
                    session()->flash('error', 'No tienes permisos para editar esta reunión');
                    return;
                }
                
                $this->editingReunion->update([
                    'titulo' => $this->titulo,
                    'descripcion' => $this->descripcion,
                    'fecha_reunion' => $this->fecha_reunion,
                    'ubicacion' => $this->ubicacion,
                    'institucion_id' => $this->institucion_id,
                    'solicitud_id' => $this->solicitud_id ?: null,
                ]);

                // Actualizar asistentes
                $this->updateAsistentes($this->editingReunion->id);
                
                $this->dispatch('show-message', [
                    'message' => 'Reunión actualizada exitosamente',
                    'type' => 'success'
                ]);

            } else {
                // Create new reunion
                $reunion = Reunion::create([
                    'titulo' => $this->titulo,
                    'descripcion' => $this->descripcion,
                    'fecha_reunion' => $this->fecha_reunion,
                    'ubicacion' => $this->ubicacion,
                    'institucion_id' => $this->institucion_id,
                    'solicitud_id' => $this->solicitud_id ?: null,
                ]);

                // Agregar asistentes
                $this->updateAsistentes($reunion->id);
                
                $this->dispatch('show-message', [
                    'message' => 'Reunión creada exitosamente',
                    'type' => 'success'
                ]);
            }
            
            $this->resetForm();
            $this->loadReuniones();
            $this->setActiveTab('list');
            
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'message' => 'Error al procesar la reunión: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    private function updateAsistentes($reunionId)
    {
        // Limpiar asistentes existentes
        Asisten::where('reunion_id', $reunionId)->delete();

        // Agregar nuevos asistentes
        foreach ($this->selectedAsistentes as $personaCedula) {
            Asisten::create([
                'reunion_id' => $reunionId,
                'persona_cedula' => $personaCedula,
                'es_consejal' => in_array($personaCedula, $this->selectedConsejales),
                'rol_asistencia' => in_array($personaCedula, $this->selectedConsejales) ? 'Consejal' : 'Asistente'
            ]);
        }
    }

    public function viewReunion($reunionId)
    {
        $this->selectedReunion = Reunion::with(['institucion', 'solicitud', 'asistentes'])
            ->find($reunionId);
        
        if (!$this->selectedReunion) {
            session()->flash('error', 'Reunión no encontrada');
            return;
        }
        
        if (!$this->canViewReunion($this->selectedReunion)) {
            session()->flash('error', 'No tienes permisos para ver esta reunión');
            return;
        }
        
        $this->showingModal = true;
    }

    public function editReunion($reunionId)
    {
        $reunion = Reunion::with(['asistentes'])->find($reunionId);
        
        if (!$reunion) {
            session()->flash('error', 'Reunión no encontrada');
            return;
        }
        
        if (!$this->canEditReunion($reunion)) {
            session()->flash('error', 'No tienes permisos para editar esta reunión');
            return;
        }
        
        $this->editingReunion = $reunion;
        $this->titulo = $reunion->titulo;
        $this->descripcion = $reunion->descripcion;
        $this->fecha_reunion = $reunion->fecha_reunion ? $reunion->fecha_reunion->format('Y-m-d\TH:i') : '';
        $this->ubicacion = $reunion->ubicacion;
        $this->institucion_id = $reunion->institucion_id;
        $this->solicitud_id = $reunion->solicitud_id;
        
        // Cargar asistentes existentes
        $this->selectedAsistentes = $reunion->asistentes->pluck('cedula')->toArray();
        $this->selectedConsejales = $reunion->asistentes->where('pivot.es_consejal', true)->pluck('cedula')->toArray();
        
        $this->loadInitialData();
        $this->activeTab = 'edit';
    }

    public function deleteReunion($reunionId)
    {
        $reunion = Reunion::find($reunionId);
        
        if (!$reunion) {
            session()->flash('error', 'Reunión no encontrada');
            return;
        }
        
        if (!$this->canDeleteReunion($reunion)) {
            session()->flash('error', 'No tienes permisos para eliminar esta reunión');
            return;
        }
        
        try {
            // Delete asistentes first
            Asisten::where('reunion_id', $reunion->id)->delete();
            
            // Delete reunion
            $reunion->delete();
            
            $this->loadReuniones();
            session()->flash('success', 'Reunión eliminada exitosamente');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar la reunión: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showingModal = false;
        $this->selectedReunion = null;
    }

    public function resetForm()
    {
        $this->titulo = '';
        $this->descripcion = '';
        $this->fecha_reunion = '';
        $this->ubicacion = '';
        $this->institucion_id = '';
        $this->solicitud_id = '';
        $this->selectedAsistentes = [];
        $this->selectedConsejales = [];
        $this->searchPersonas = '';
        $this->editingReunion = null;
        $this->resetValidation();
    }

    // Permission check methods
    private function canCreateReunion()
    {
        $user = Auth::user();
        return $user->isSuperAdministrador() || $user->isAdministrador();
    }

    private function canViewReunion($reunion)
    {
        $user = Auth::user();
        return $user->isSuperAdministrador() || $user->isAdministrador();
    }

    private function canEditReunion($reunion)
    {
        $user = Auth::user();
        return $user->isSuperAdministrador();
    }

    private function canDeleteReunion($reunion)
    {
        $user = Auth::user();
        return $user->isSuperAdministrador();
    }
    
    // Ordenar tabla
    public function orden($sort)
    {
        if ($this->sort == $sort) {
            $this->direction = ($this->direction == 'asc') ? 'desc' : 'asc';
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    // Agregar/quitar asistente
    public function toggleAsistente($personaCedula)
    {
        if (in_array($personaCedula, $this->selectedAsistentes)) {
            $this->selectedAsistentes = array_diff($this->selectedAsistentes, [$personaCedula]);
            $this->selectedConsejales = array_diff($this->selectedConsejales, [$personaCedula]);
        } else {
            $this->selectedAsistentes[] = $personaCedula;
        }
    }

    // Marcar/desmarcar como consejal
    public function toggleConsejal($personaCedula)
    {
        if (!in_array($personaCedula, $this->selectedAsistentes)) {
            $this->selectedAsistentes[] = $personaCedula;
        }
        
        if (in_array($personaCedula, $this->selectedConsejales)) {
            $this->selectedConsejales = array_diff($this->selectedConsejales, [$personaCedula]);
        } else {
            $this->selectedConsejales[] = $personaCedula;
        }
    }

    public function updatedSearchPersonas()
    {
        $this->loadPersonas();
    }

    public function render()
    {
        $reunionesRender = $this->loadReuniones();

        return view('livewire.dashboard.super-admin-reuniones', [
            'reunionesRender' => $reunionesRender,
        ])->layout('components.layouts.rbac');
    }
}