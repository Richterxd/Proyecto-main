<?php

namespace App\Livewire\Dashboard;

use App\Models\Solicitud;
use App\Models\Ambito;
use App\Models\Personas;
use App\Models\SolicitudPersonaAsociada;
use App\Models\Trabajador;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;    
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\search;

class SuperAdminSolicitudes extends Component
{
    use WithPagination;

    // pagination theme
    protected $paginationTheme = 'disenoPagination'; 

    //ordenar solicitudes
    public $search = '', $sort = 'fecha_creacion', $direction = 'desc';
    public $searchAsignador = '';
    public $estadoSolicitud = 'todo';
    public $solicitudes = [];
    public $consejales = [];
    public $trabajadores = [];
    public $trabajadoresYUsuarios = [];
    public $solicitudEstados = [
        'Pendiente' => 'Pendiente',
        'Aprobada' => 'Aprobada',
        'Rechazada' => 'Rechazada',
        'Asignada' => 'Asignada'
    ];

    //cambiar vistas
    public $activeTab = 'list';

    //data
    public $selectedSolicitud = null;
    public $editingSolicitud = null;

    
    // Personal data (read-only from database)
    public $personalData = [
        'cedula' => '',
        'nombre_completo' => '',
        'telefono' => '',
        'email' => ''
    ];

    // Form fields
    public $titulo = '';
    public $categoria = '';
    public $subcategoria = '';
    public $descripcion = '';
    public $derecho_palabra = false;
    
    // Admin fields
    public $estado_detallado = '';
    public $observaciones_admin = '';
    public $visitador_asignado = '';

    public $parroquias = [
        'chivacoa' => 'Chivacoa',
        'campo_elias' => 'Campo Elías',
    ];

    public $detailedAddress = [
        'pais' => 'Venezuela',
        'estado_region' => 'Yaracuy',
        'municipio' => 'Bruzual',
        'parroquia' => '',
        'comunidad' => '',
        'direccion_detallada' => ''
    ];
    
    public $categories = [
        'servicios' => [
            'title' => 'Servicios',
            'icon' => 'bx-wrench',
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
            'icon' => 'bx-group',
            'subcategories' => [
                'educacion_inicial' => 'Educación Inicial',
                'educacion_basica' => 'Educación Básica',
                'educacion_secundaria' => 'Educación Secundaria',
                'educacion_universitaria' => 'Educación Universitaria'
            ]
        ],
        'sucesos_naturales' => [
            'title' => 'Sucesos Naturales',
            'icon' => 'bx-cloud-lightning',
            'subcategories' => [
                'huracanes' => 'Huracanes',
                'tormentas_tropicales' => 'Tormentas Tropicales',
                'terremotos' => 'Terremotos'
            ]
        ]
    ];

    protected $rules = [
        'personalData.nombre_completo' => 'required|max:100',
        'personalData.cedula' => 'required|min:7|max:8',
        'personalData.telefono' => 'required|max:13',
        'personalData.email' => 'required|email|max:100',
        'titulo' => 'required|min:5|max:50',
        'categoria' => 'required|in:servicios,social,sucesos_naturales',
        'subcategoria' => 'required',
        'detailedAddress.parroquia' => 'required|min:5|max:50',
        'detailedAddress.comunidad' => 'required|min:5|max:50',
        'detailedAddress.direccion_detallada' => 'required|min:10|max:200',
        'descripcion' => 'required|min:50|max:5000',
        'derecho_palabra' => 'boolean',
    ];

    protected $messages = [
        'personalData.cedula.required' => 'La cédula es obligatoria',
        'personalData.cedula.min' => 'La cédula debe tener al menos 7 caracteres',
        'personalData.cedula.max' => 'La cédula no puede exceder los 8 caracteres',
        'personalData.email.email' => 'El correo electrónico debe ser una dirección válida',
        'personalData.email.required' => 'El correo electrónico es obligatorio',
        'personalData.email.max' => 'El correo electrónico no puede exceder los 100 caracteres',
        'personalData.telefono.required' => 'El teléfono es obligatorio',
        'personalData.telefono.max' => 'El teléfono no puede exceder los 13 caracteres',
        'personalData.nombre_completo.required' => 'El nombre completo es obligatorio',
        'personalData.nombre_completo.max' => 'El nombre completo no puede exceder los 100 caracteres',
        'titulo.required' => 'El título es obligatorio',
        'titulo.min' => 'El título debe tener al menos 5 caracteres',
        'titulo.max' => 'El título no puede exceder los 50 caracteres',
        'categoria.required' => 'La categoría es obligatoria',
        'categoria.in' => 'La categoría seleccionada no es válida',
        'subcategoria.required' => 'La subcategoría es obligatoria',
        'detailedAddress.parroquia.required' => 'La parroquia es obligatoria',
        'detailedAddress.parroquia.min' => 'La parroquia debe tener al menos 5 caracteres',
        'detailedAddress.parroquia.max' => 'La parroquia no puede exceder los 50 caracteres',
        'detailedAddress.comunidad.required' => 'La comunidad es obligatoria',
        'detailedAddress.comunidad.min' => 'La comunidad debe tener al menos 5 caracteres',
        'detailedAddress.comunidad.max' => 'La comunidad no puede exceder los 50 caracteres',
        'detailedAddress.direccion_detallada.required' => 'La dirección detallada es obligatoria',
        'detailedAddress.direccion_detallada.min' => 'La dirección detallada debe tener al menos 10 caracteres',
        'detailedAddress.direccion_detallada.max' => 'La dirección detallada no puede exceder los 200 caracteres',
        'descripcion.required' => 'La descripción es obligatoria',
        'descripcion.min' => 'La descripción debe tener al menos 50 caracteres',
        'descripcion.max' => 'La descripción no puede exceder los 5000 caracteres',
        'derecho_palabra.boolean' => 'El valor de derecho a la palabra debe ser verdadero o falso',
    ];

    public function mount($activeTab = 'edit', $solicitudId = '2025092196c099')
    {        
        $this->resetForm();
        
        $tab = request()->get('tab', $activeTab);

        if ($tab === 'crear' || $tab === 'create') {
            $this->activeTab = 'create';
        } elseif ($tab === 'editar' || $tab === 'edit' && $solicitudId) {
            $this->editSolicitud($solicitudId);
        } else {
            $this->activeTab = 'list';
        }

        $this->loadSolicitudes();
    }

    public function loadSolicitudes()
    {
        if (Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador()) {
            
            $query = Solicitud::query()->with(['persona', 'ambito', 'personasAsociadas']);

            if ($this->estadoSolicitud !== 'todo') {
                $query->where('estado_detallado', $this->estadoSolicitud);
            }

            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('solicitud_id', 'like', '%' . $this->search . '%')
                        ->orWhere('titulo', 'like', '%' . $this->search . '%')
                        ->orWhere('categoria', 'like', '%' . $this->search . '%')
                        ->orWhere('subcategoria', 'like', '%' . $this->search . '%')
                        ->orWhere('fecha_creacion', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('persona', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%')
                        ->orwhere('apellido', 'like', '%' . $this->search . '%');
                })->where('estado_detallado', $this->estadoSolicitud);
            }

            
            if (strpos($this->sort, '.') !== false) {
                list($table, $column) = explode('.', $this->sort);
                
                $query->leftJoin($table . 's', $table . 's.cedula', '=', 'solicitudes.' . $table . '_cedula')
                    ->select('solicitudes.*')
                    ->orderBy($table . 's.' . $column, $this->direction);
            } else {
                $query->orderBy($this->sort, $this->direction);
            }

            $this->solicitudes = $query->get();
            
            return $query->paginate(10);

        } else {
            $this->dispatch('show-message', [
                'message' => 'Error al cargar las solicitudes: No tienes permisos para ver esta sección',
                'type' => 'error'
            ]);
        }
    }

    public function loadAsignadores()
    {
        $consejalesQuery = User::where('role', 2)->with('persona');

        $trabajadoresQuery = Trabajador::query();

            $searchTerm = '%' . $this->searchAsignador . '%';

            $consejales = $consejalesQuery->where(function ($q) use ($searchTerm) {
                $q->where('persona_cedula', 'like', $searchTerm)
                ->orWhereHas('persona', function ($qPersona) use ($searchTerm) {
                    $qPersona->where('nombre', 'like', $searchTerm)
                            ->orWhere('apellido', 'like', $searchTerm);
                });
            })->get();

            $trabajadores = $trabajadoresQuery->where(function ($q) use ($searchTerm) {
                $q->where('cedula', 'like', $searchTerm)
                ->orWhere('nombres', 'like', $searchTerm)
                ->orWhere('apellidos', 'like', $searchTerm); 
            })->get();

        $cedulasTrabajadores = $trabajadores->pluck('cedula')->toArray();
        
        $this->trabajadoresYUsuarios = $consejales->filter(function ($consejal) use ($cedulasTrabajadores) {
            return in_array($consejal->persona_cedula, $cedulasTrabajadores);
        });

        $cedulasDobleRol = $this->trabajadoresYUsuarios->pluck('persona_cedula')->toArray();

        $this->consejales = $consejales->reject(function ($consejal) use ($cedulasDobleRol) {
            return in_array($consejal->persona_cedula, $cedulasDobleRol);
        });

        $this->trabajadores = $trabajadores->reject(function ($trabajador) use ($cedulasDobleRol) {
            return in_array($trabajador->cedula, $cedulasDobleRol);
        });
    }

    //open create
    public function setActiveTab($tab)
    {
        if($tab === 'create' && !$this->canCreateSolicitud()){
            session()->flash('error', 'No tienes permisos para ver esta solicitud');
            return;
        }

        $this->activeTab = $tab;
        $this->resetForm();
    }

    public function submit()
    {
        $this->validate(); 
        
        try {
            // Find appropriate ambito based on category and subcategory
            $ambitoTitle = $this->categories[$this->categoria]['title'] . ' - ' . 
                          $this->categories[$this->categoria]['subcategories'][$this->subcategoria];
            
            $ambito = Ambito::where('titulo', $ambitoTitle)->first();

            if (!$ambito) {
                $ambito = Ambito::first(); // Fallback to first ambito
            }
            
            if ($this->editingSolicitud && Auth::user()->isSuperAdministrador()) {
                // Update existing solicitud
                    
                if (!$this->canEditSolicitud($this->editingSolicitud)) {
                    session()->flash('error', 'No tienes permisos para editar esta solicitud');
                    return;
                }
                
                $this->editingSolicitud->update([
                    'titulo' => $this->categories[$this->categoria]['subcategories'][$this->subcategoria] . ' - ' . $this->titulo,
                    'descripcion' => $this->descripcion,
                    'categoria' => $this->categoria,
                    'subcategoria' => $this->subcategoria,
                    'tipo_solicitud' => 'individual',
                    'es_colectivo_indigena' => false,
                    'pais' => $this->detailedAddress['pais'],
                    'estado_region' => $this->detailedAddress['estado_region'],
                    'municipio' => $this->detailedAddress['municipio'],
                    'parroquia' => $this->detailedAddress['parroquia'],
                    'comunidad' => $this->detailedAddress['comunidad'],
                    'direccion_detallada' => $this->detailedAddress['direccion_detallada'],
                    'estado_detallado' => $this->estado_detallado,
                    'fecha_actualizacion_super_admin' => now(),
                    'ambito_id' => $ambito->ambito_id,
                    'derecho_palabra' => $this->derecho_palabra,
                    'direccion' => $this->detailedAddress['direccion_detallada'],
                    'observaciones_admin' => $this->observaciones_admin,
                    'visitador_asignado' => $this->visitador_asignado,
                ]);
                
                $this->dispatch('show-message', [
                    'message' => 'Solicitud actualizada exitosamente',
                    'type' => 'success'
                ]);

            } else {

                $persona = Personas::find($this->personalData['cedula']);

                if (!$persona) {
                    Personas::create([
                        'cedula' => $this->personalData['cedula'],
                        'nombre' => $this->personalData['nombre_completo'],
                        'telefono' => $this->personalData['telefono'],
                        'email' => $this->personalData['email'],
                    ]);
                }
                
                // Create new solicitud
                $solicitudId = Solicitud::generateSolicitudId($this->personalData['cedula']);
                
                Solicitud::create([
                    'solicitud_id' => $solicitudId,
                    'titulo' => $this->categories[$this->categoria]['subcategories'][$this->subcategoria] . ' - ' . $this->titulo,
                    'descripcion' => $this->descripcion,
                    'categoria' => $this->categoria,
                    'subcategoria' => $this->subcategoria,
                    'tipo_solicitud' => 'individual',
                    'es_colectivo_indigena' => false,
                    'pais' => $this->detailedAddress['pais'],
                    'estado_region' => $this->detailedAddress['estado_region'],
                    'municipio' => $this->detailedAddress['municipio'],
                    'parroquia' => $this->detailedAddress['parroquia'],
                    'comunidad' => $this->detailedAddress['comunidad'],
                    'direccion_detallada' => $this->detailedAddress['direccion_detallada'],
                    'estado_detallado' => 'Pendiente',
                    'fecha_creacion' => now(),
                    'persona_cedula' => $this->personalData['cedula'],
                    'ambito_id' => $ambito->ambito_id,
                    'derecho_palabra' => $this->derecho_palabra,
                    'direccion' => $this->detailedAddress['direccion_detallada'],
                ]);
                
                $this->dispatch('show-message', [
                    'message' => 'Solicitud creada exitosamente con ID: ' . $solicitudId,
                    'type' => 'success'
                ]);
            }
            
            $this->resetForm();
            $this->loadSolicitudes();
            $this->setActiveTab('list');
            
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
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

        $persona = Personas::find($solicitud->persona_cedula);

        if ($persona) {
            $this->personalData['cedula'] = $persona->cedula;
            $this->personalData['nombre_completo'] = $persona->nombre . ' ' . $persona->apellido;
            $this->personalData['telefono'] = $persona->telefono;
            $this->personalData['email'] = $persona->email;
        }
        
        $this->editingSolicitud = $solicitud;
        $this->titulo = $solicitud->titulo;
        $this->categoria = $solicitud->categoria;
        $this->subcategoria = $solicitud->subcategoria;
        $this->detailedAddress = [
            'pais' => $solicitud->pais ?? 'Venezuela',
            'estado_region' => $solicitud->estado_region ?? 'Yaracuy',
            'municipio' => $solicitud->municipio ?? 'Bruzual',
            'parroquia' => $solicitud->parroquia,
            'comunidad' => $solicitud->comunidad,
            'direccion_detallada' => $solicitud->direccion_detallada
        ];
        $this->descripcion = $solicitud->descripcion;
        $this->estado_detallado = $solicitud->estado_detallado;
        $this->observaciones_admin = $solicitud->observaciones_admin;
        $this->visitador_asignado = $solicitud->visitador_asignado;
        
        $this->loadAsignadores();

        $this->activeTab = 'edit';
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
            SolicitudPersonaAsociada::where('solicitud_id', $solicitud->solicitud_id)->delete();
            
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
                'updated_at' => now()
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
        $this->personalData = [
            'cedula' => '',
            'nombre_completo' => '',
            'telefono' => '',
            'email' => ''
        ];
        $this->categoria = '';
        $this->subcategoria = '';
        
        $this->titulo = '';
        $this->categoria = '';
        $this->subcategoria = '';
        $this->detailedAddress = [
            'pais' => 'Venezuela',
            'estado_region' => 'Yaracuy',
            'municipio' => 'Bruzual',
            'parroquia' => '',
            'comunidad' => '',
            'direccion_detallada' => ''
        ];

        $this->descripcion = '';
        $this->estado_detallado = '';
        $this->observaciones_admin = '';
        $this->visitador_asignado = '';
        $this->editingSolicitud = null;
        $this->resetValidation();
    }

    // Permission check methods
    private function canCreateSolicitud()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdministrador()){
            return true;
        }

        if ($user->isAdministrador()) {
            return false; // Admins can only view
        }
        
        return false; // Regular users can create
    }

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
    
   /*  ordernar labla */
    public function orden($sort)
    {
        if ($this->sort == $sort) {
            $this->direction = ($this->direction == 'asc') ? 'desc' : 'asc';
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function ordenEstados($estado){
        
        $this->estadoSolicitud = $estado === 'todo' ? 'todo' : $estado;
    }

    public function render()
    {
        $solicitudesRender = $this->loadSolicitudes();

        return view('livewire.dashboard.super-admin-solicitudes' , [
            'solicitudesRender' => $solicitudesRender,
        ])->layout('components.layouts.rbac');
    }
}