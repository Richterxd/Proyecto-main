<?php

namespace App\Livewire\Dashboard;

use App\Models\Solicitud;
use App\Models\Visita;
use App\Models\Ambito;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioDashboard extends Component
{
    use WithPagination;

    public $activeTab = 'dashboard';
    public $solicitudes;
    public $visitas;
    public $ambitos;
    
    // Solicitud form properties
    public $solicitudForm = [
        'titulo' => '',
        'descripcion' => '',
        'ambito_id' => '',
        'direccion' => '',
        'telefono_contacto' => ''
    ];
    
    public $editingSolicitud = null;
    public $viewingSolicitud = null;
    
    // Profile form properties
    public $profileForm = [
        'current_password' => '',
        'new_password' => '',
        'new_password_confirmation' => ''
    ];

    protected $rules = [
        'solicitudForm.titulo' => 'required|min:5|max:100',
        'solicitudForm.descripcion' => 'required|min:10|max:500',
        'solicitudForm.ambito_id' => 'required|exists:ambitos,id',
        'solicitudForm.direccion' => 'required|min:10|max:200',
        'solicitudForm.telefono_contacto' => 'required|regex:/^[0-9]{10,15}$/'
    ];

    public function mount()
    {
        $this->activeTab = request()->get('tab', 'dashboard');
        $this->loadData();
    }

    public function loadData()
    {
        $this->solicitudes = Solicitud::with(['ambito'])
            ->where('persona_cedula', Auth::user()->persona_cedula)
            ->orderBy('fecha_creacion', 'desc')
            ->get();
            
        $this->visitas = Visita::with(['ambito'])
            ->where('persona_cedula', Auth::user()->persona_cedula)
            ->orderBy('fecha', 'desc')
            ->get();
            
        $this->ambitos = Ambito::all();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->reset(['editingSolicitud', 'viewingSolicitud']);
        $this->resetSolicitudForm();
    }

    public function resetSolicitudForm()
    {
        $this->solicitudForm = [
            'titulo' => '',
            'descripcion' => '',
            'ambito_id' => '',
            'direccion' => '',
            'telefono_contacto' => ''
        ];
        $this->resetValidation();
    }

    public function createSolicitud()
    {
        $this->validate();

        try {
            Solicitud::create([
                'titulo' => $this->solicitudForm['titulo'],
                'descripcion' => $this->solicitudForm['descripcion'],
                'ambito_id' => $this->solicitudForm['ambito_id'],
                'direccion' => $this->solicitudForm['direccion'],
                'telefono_contacto' => $this->solicitudForm['telefono_contacto'],
                'persona_cedula' => Auth::user()->persona_cedula,
                'estado_detallado' => 'Pendiente',
                'fecha_creacion' => now()
            ]);

            $this->resetSolicitudForm();
            $this->loadData();
            $this->dispatch('show-message', [
                'message' => 'Solicitud creada exitosamente',
                'type' => 'success'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'message' => 'Error al crear la solicitud: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function editSolicitud($solicitudId)
    {
        $solicitud = Solicitud::findOrFail($solicitudId);
        
        if ($solicitud->persona_cedula !== Auth::user()->persona_cedula) {
            $this->dispatch('show-message', [
                'message' => 'No tienes permisos para editar esta solicitud',
                'type' => 'error'
            ]);
            return;
        }

        $this->editingSolicitud = $solicitud;
        $this->solicitudForm = [
            'titulo' => $solicitud->titulo,
            'descripcion' => $solicitud->descripcion,
            'ambito_id' => $solicitud->ambito_id,
            'direccion' => $solicitud->direccion,
            'telefono_contacto' => $solicitud->telefono_contacto
        ];
        $this->activeTab = 'editar';
    }

    public function updateSolicitud()
    {
        $this->validate();

        try {
            $this->editingSolicitud->update([
                'titulo' => $this->solicitudForm['titulo'],
                'descripcion' => $this->solicitudForm['descripcion'],
                'ambito_id' => $this->solicitudForm['ambito_id'],
                'direccion' => $this->solicitudForm['direccion'],
                'telefono_contacto' => $this->solicitudForm['telefono_contacto']
            ]);

            $this->reset(['editingSolicitud']);
            $this->resetSolicitudForm();
            $this->loadData();
            $this->activeTab = 'visualizar';
            
            $this->dispatch('show-message', [
                'message' => 'Solicitud actualizada exitosamente',
                'type' => 'success'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'message' => 'Error al actualizar la solicitud: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function deleteSolicitud($solicitudId)
    {
        try {
            $solicitud = Solicitud::findOrFail($solicitudId);
            
            if ($solicitud->persona_cedula !== Auth::user()->persona_cedula) {
                $this->dispatch('show-message', [
                    'message' => 'No tienes permisos para eliminar esta solicitud',
                    'type' => 'error'
                ]);
                return;
            }

            $solicitud->delete();
            $this->loadData();
            
            $this->dispatch('show-message', [
                'message' => 'Solicitud eliminada exitosamente',
                'type' => 'success'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'message' => 'Error al eliminar la solicitud: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function viewSolicitud($solicitudId)
    {
        $this->viewingSolicitud = Solicitud::with('ambito')->findOrFail($solicitudId);
    }

    public function closeModal()
    {
        $this->viewingSolicitud = null;
    }

    public function updatePassword()
    {
        $this->validate([
            'profileForm.current_password' => 'required',
            'profileForm.new_password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>])/',
            'profileForm.new_password_confirmation' => 'required|same:profileForm.new_password'
        ], [
            'profileForm.new_password.regex' => 'La nueva contraseña debe tener al menos 8 caracteres, una mayúscula y un carácter especial.',
            'profileForm.new_password_confirmation.same' => 'La confirmación de contraseña no coincide.'
        ]);

        if (!Hash::check($this->profileForm['current_password'], Auth::user()->password)) {
            $this->addError('profileForm.current_password', 'La contraseña actual es incorrecta.');
            return;
        }

        try {
            Auth::user()->update([
                'password' => Hash::make($this->profileForm['new_password'])
            ]);

            $this->profileForm = [
                'current_password' => '',
                'new_password' => '',
                'new_password_confirmation' => ''
            ];

            $this->dispatch('show-message', [
                'message' => 'Contraseña actualizada exitosamente',
                'type' => 'success'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'message' => 'Error al actualizar la contraseña: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.usuario-dashboard')->layout('components.layouts.rbac');
    }

    // Add method to redirect to CRUD component
    public function redirectToCrud()
    {
        return redirect()->route('dashboard.usuario', ['tab' => 'crud']);
    }
}