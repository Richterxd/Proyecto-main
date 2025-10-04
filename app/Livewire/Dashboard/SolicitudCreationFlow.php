<?php

namespace App\Livewire\Dashboard;

use App\Models\Solicitud;
use App\Models\Ambito;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SolicitudCreationFlow extends Component
{
    // Personal data (read-only from database)
    public $personalData = [];
    
    // Form fields
    public $selectedCategory = '';
    public $selectedSubcategory = '';
    
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
    public $description = '';
    
    // Available categories
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
        'selectedCategory' => 'required|in:servicios,social,sucesos_naturales',
        'selectedSubcategory' => 'required',
        'detailedAddress.parroquia' => 'required|min:3|max:50',
        'detailedAddress.comunidad' => 'required|min:3|max:50',
        'detailedAddress.direccion_detallada' => 'required|min:10|max:200',
        'description' => 'required|min:50|max:5000',
    ];

    public function mount()
    {
        $this->loadPersonalData();
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

    public function submit()
    {
        $this->validate();
        
        try {
            // Find appropriate ambito based on category and subcategory
            $ambitoTitle = $this->categories[$this->selectedCategory]['title'] . ' - ' . 
                          $this->categories[$this->selectedCategory]['subcategories'][$this->selectedSubcategory];
            
            $ambito = Ambito::where('titulo', $ambitoTitle)->first();
            if (!$ambito) {
                $ambito = Ambito::first(); // Fallback to first ambito
            }
            
            // Generate unique solicitud ID
            $solicitudId = Solicitud::generateSolicitudId(Auth::user()->persona_cedula);
            
            // Create solicitud
            $solicitud = Solicitud::create([
                'solicitud_id' => $solicitudId,
                'titulo' => $this->categories[$this->selectedCategory]['subcategories'][$this->selectedSubcategory],
                'descripcion' => $this->description,
                'categoria' => $this->selectedCategory,
                'subcategoria' => $this->selectedSubcategory,
                'tipo_solicitud' => 'individual',
                'es_colectivo_indigena' => false,
                'pais' => $this->detailedAddress['pais'],
                'estado_region' => $this->detailedAddress['estado_region'],
                'municipio' => $this->detailedAddress['municipio'],
                'parroquia' => $this->detailedAddress['parroquia'],
                'comunidad' => $this->detailedAddress['comunidad'],
                'direccion_detallada' => $this->detailedAddress['direccion_detallada'],
                'estado' => 'Pendiente',
                'estado_detallado' => 'Pendiente',
                'fecha_creacion' => now(),
                'persona_cedula' => Auth::user()->persona_cedula,
                'ambito_id' => $ambito->id,
                'direccion' => $this->detailedAddress['direccion_detallada'],
                'telefono_contacto' => $this->personalData['telefono'],
            ]);
            
            session()->flash('success', 'Solicitud creada exitosamente con ID: ' . $solicitudId);
            
            return redirect()->route('dashboard.usuario', ['tab' => 'visualizar']);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear la solicitud: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->selectedCategory = '';
        $this->selectedSubcategory = '';
        $this->description = '';
        
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

    public function render()
    {
        return view('livewire.dashboard.solicitud-creation-flow');
    }
}