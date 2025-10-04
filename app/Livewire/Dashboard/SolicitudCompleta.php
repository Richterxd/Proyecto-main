<?php

namespace App\Livewire\Dashboard;

use App\Models\Solicitud;
use App\Models\Ambito;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SolicitudCompleta extends Component
{
    //autoscroll to top on validation errors
    protected $scrollTo = true;

    // Current tab/mode
    public $currentTab = 'create';
    
    // Personal data (read-only from database)
    public $personalData = [];
    
    // Form fields for creation/editing
    public $categoria = '';
    public $subcategoria = '';

    public $parroquias = [
        'chivacoa' => 'Chivacoa',
        'campo_elias' => 'Campo Elías',
    ];
    
    // Address fields
    public $detailedAddress = [
        'pais' => 'Venezuela',
        'estado_region' => 'Yaracuy',
        'municipio' => 'Bruzual',
        'parroquia' => '',
        'comunidad' => '',
        'direccion_detallada' => ''
    ];
    
    // Description
    public $titulo = '';
    public $description = '';
    public $derecho_palabra = false;
    
    // Editing state
    public $editingId = null;
    public $solicitudes = [];
    
    // Viewing state
    public $selectedSolicitud = null;
    
    // Delete confirmation
    public $deleteId = null;
    
    // Available categories
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
        'titulo' => 'required|min:5|max:50',
        'categoria' => 'required|in:servicios,social,sucesos_naturales',
        'subcategoria' => 'required',
        'detailedAddress.parroquia' => 'required|min:3|max:50',
        'detailedAddress.comunidad' => 'required|min:3|max:50',
        'detailedAddress.direccion_detallada' => 'required|min:10|max:200',
        'description' => 'required|min:50|max:1000',
        'derecho_palabra' => 'boolean'
    ];

    protected $messages = [
        'categoria.required' => 'La categoría es obligatoria.',
        'categoria.in' => 'La categoría seleccionada no es válida.',
        'subcategoria.required' => 'La subcategoría es obligatoria.',
        'detailedAddress.parroquia.required' => 'La parroquia es obligatoria.',
        'detailedAddress.parroquia.min' => 'La parroquia debe tener al menos 3 caracteres.',
        'detailedAddress.parroquia.max' => 'La parroquia no debe exceder los 50 caracteres.',
        'detailedAddress.comunidad.required' => 'La comunidad es obligatoria.',
        'detailedAddress.comunidad.min' => 'La comunidad debe tener al menos 3 caracteres.',
        'detailedAddress.comunidad.max' => 'La comunidad no debe exceder los 50 caracteres.',
        'detailedAddress.direccion_detallada.required' => 'La dirección detallada es obligatoria.',
        'detailedAddress.direccion_detallada.min' => 'La dirección detallada debe tener al menos 10 caracteres.',
        'detailedAddress.direccion_detallada.max' => 'La dirección detallada no debe exceder los 200 caracteres.',
        'titulo.required' => 'El título es obligatorio.',
        'titulo.min' => 'El título debe tener al menos 5 caracteres.',
        'titulo.max' => 'El título no debe exceder los 50 caracteres.',
        'description.required' => 'La descripción es obligatoria.',
        'description.min' => 'La descripción debe tener al menos 50 caracteres.',
        'description.max' => 'La descripción no debe exceder los 1000 caracteres.',
        'derecho_palabra.boolean' => 'El valor de derecho a la palabra no es válido.'
    ];

    public function mount()
    {
        $tab = request()->get('tab', 'create');
        if ($tab === 'crear' || $tab === 'create') {
            $this->currentTab = 'create';
        } else {
            $this->currentTab = 'list';
        }
        
        $this->loadPersonalData();
        $this->loadSolicitudes();
    }

    public function loadPersonalData()
    {
        $user = Auth::user();
        $persona = $user->persona;
        
        if ($persona) {
            $this->personalData = [
                'cedula' => $persona->nacionalidad . $persona->cedula,
                'nombre_completo' => $persona->nombre . ' ' . $persona->apellido,
                'email' => $persona->email,
                'telefono' => $persona->telefono,
            ];
        }
    }

    public function loadSolicitudes()
    {
        $this->solicitudes = Solicitud::with(['ambito'])
            ->where('persona_cedula', Auth::user()->persona_cedula)
            ->orderBy('fecha_creacion', 'desc')
            ->get();
    }

    public function setCurrentTab($tab)
    {
        $this->currentTab = $tab;
        $this->selectedSolicitud = null;
        $this->resetForm();
        
        // Refresh the component to ensure the view updates
        $this->dispatch('tab-changed', ['tab' => $tab]);
    }

    public function resetForm()
    {
        $this->categoria = '';
        $this->subcategoria = '';
        $this->titulo = '';
        $this->description = '';
        $this->derecho_palabra = false;
        $this->editingId = null;
        
        $this->detailedAddress = [
            'pais' => 'Venezuela',
            'estado_region' => 'Yaracuy',
            'municipio' => 'Bruzual',
            'parroquia' => '',
            'comunidad' => '',
            'direccion_detallada' => ''
        ];
        
        $this->resetValidation();
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
            
            if ($this->editingId) {
                // Update existing solicitud
                $solicitud = Solicitud::find($this->editingId);
                
                if ($solicitud && $solicitud->persona_cedula === Auth::user()->persona_cedula) {
                    $solicitud->update([
                        'titulo' => $this->categories[$this->categoria]['subcategories'][$this->subcategoria] . ' - ' . $this->titulo,
                        'descripcion' => $this->description,
                        'categoria' => $this->categoria,
                        'subcategoria' => $this->subcategoria,
                        'parroquia' => $this->detailedAddress['parroquia'],
                        'comunidad' => $this->detailedAddress['comunidad'],
                        'direccion_detallada' => $this->detailedAddress['direccion_detallada'],
                        'fecha_actualizacion_usuario' => now(),
                        'ambito_id' => $ambito->ambito_id,
                        'derecho_palabra' => $this->derecho_palabra,
                        'direccion' => $this->detailedAddress['direccion_detallada'],
                    ]);
                    
                    $this->dispatch('show-message', [
                        'message' => 'Solicitud actualizada exitosamente',
                        'type' => 'success'
                    ]);
                }
            } else {
                // Create new solicitud
                $solicitudId = Solicitud::generateSolicitudId(Auth::user()->persona_cedula);
                
                Solicitud::create([
                    'solicitud_id' => $solicitudId,
                    'titulo' => $this->categories[$this->categoria]['subcategories'][$this->subcategoria] . ' - ' . $this->titulo,
                    'descripcion' => $this->description,
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
                    'persona_cedula' => Auth::user()->persona_cedula,
                    'ambito_id' => $ambito->ambito_id,
                    'derecho_palabra' => $this->derecho_palabra,
                    'direccion' => $this->detailedAddress['direccion_detallada'],
                ]);
                
                $this->dispatch('show-message', [
                    'message' => 'Solicitud creada exitosamente con ID: ' . $solicitudId,
                    'type' => 'success'
                ]);
            }
            
            $this->loadSolicitudes();
            $this->setCurrentTab('list');
            
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function editSolicitud($id)
    {
        $solicitud = Solicitud::find($id);
        
        if (!$solicitud || $solicitud->persona_cedula !== Auth::user()->persona_cedula) {
            $this->dispatch('show-message', [
                'message' => 'No tienes permisos para editar esta solicitud',
                'type' => 'error'
            ]);
            return;
        }
        
        $this->editingId = $id;
        $this->categoria = $solicitud->categoria;
        $this->subcategoria = $solicitud->subcategoria;
        $this->titulo = str_replace($this->categories[$this->categoria]['subcategories'][$this->subcategoria] . ' - ', '', $solicitud->titulo);
        $this->description = $solicitud->descripcion;
        $this->derecho_palabra = $solicitud->derecho_palabra;
        $this->detailedAddress = [
            'pais' => $solicitud->pais ?? 'Venezuela',
            'estado_region' => $solicitud->estado_region ?? 'Yaracuy',
            'municipio' => $solicitud->municipio ?? 'Bruzual',
            'parroquia' => $solicitud->parroquia,
            'comunidad' => $solicitud->comunidad,
            'direccion_detallada' => $solicitud->direccion_detallada
        ];
        
        $this->currentTab = 'create';
    }

    public function viewSolicitud($id)
    {
        $this->selectedSolicitud = Solicitud::with(['ambito'])->find($id);
        
        if (!$this->selectedSolicitud || $this->selectedSolicitud->persona_cedula !== Auth::user()->persona_cedula) {
            $this->dispatch('show-message', [
                'message' => 'No tienes permisos para ver esta solicitud',
                'type' => 'error'
            ]);
            return;
        }
        
        $this->currentTab = 'view';
    }

    public function getCharacterCount()
    {
        return strlen($this->description);
    }

    public function selectCategory($categoryKey)
    {
        $this->categoria = $categoryKey;
        $this->subcategoria = '';
    }

    public function render()
    {
        return view('livewire.dashboard.solicitud-completa')->layout('components.layouts.rbac');
    }
}