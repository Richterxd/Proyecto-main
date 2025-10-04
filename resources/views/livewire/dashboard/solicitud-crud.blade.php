<div class="min-h-screen bg-gray-50"">
    <!-- Tab Navigation -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="flex border-b border-gray-200">
            <button wire:click="setActiveTab('list')" 
                    class="px-6 py-3 text-sm font-medium border-b-2 {{ $activeTab === 'list' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                <i class='bx bx-list-ul mr-2'></i>
                Lista de Solicitudes
            </button>
            
            @if(Auth::user()->isSuperAdministrador())
                <button wire:click="setActiveTab('create')" 
                        class="px-6 py-3 text-sm font-medium border-b-2 {{ $activeTab === 'create' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    <i class='bx bx-plus mr-2'></i>
                    Nueva Solicitud
                </button>
            @endif
        </div>
    </div>

    <!-- Content -->
    @if($activeTab === 'list')
        <!-- Solicitudes List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">
                        @if(Auth::user()->isSuperAdministrador())
                            Todas las Solicitudes
                        @elseif(Auth::user()->isAdministrador())
                            Solicitudes (Solo Lectura)
                        @else
                            Mis Solicitudes
                        @endif
                    </h2>
                    <span class="text-sm text-gray-500">{{ $solicitudes->count() }} solicitudes</span>
                </div>

                @if($solicitudes->isEmpty())
                    <div class="text-center py-8">
                        <i class='bx bx-file text-4xl text-gray-400 mb-4'></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay solicitudes</h3>
                        <p class="text-gray-500">
                            @if(Auth::user()->isUsuario())
                                Crea tu primera solicitud usando el botón "Nueva Solicitud"
                            @else
                                No se encontraron solicitudes en el sistema
                            @endif
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Solicitud
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Categoría
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha
                                    </th>
                                    @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Solicitante
                                        </th>
                                    @endif
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($solicitudes as $solicitud)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $solicitud->titulo }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    ID: {{ $solicitud->solicitud_id }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $solicitud->categoria_formatted }}</div>
                                            <div class="text-sm text-gray-500">{{ $solicitud->subcategoria_formatted }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $solicitud->estado_color === 'green' ? 'bg-green-100 text-green-800' : 
                                                   ($solicitud->estado_color === 'yellow' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($solicitud->estado_color === 'red' ? 'bg-red-100 text-red-800' : 
                                                   ($solicitud->estado_color === 'blue' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'))) }}">
                                                {{ $solicitud->estado_detallado }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $solicitud->fecha_creacion->format('d/m/Y H:i') }}
                                        </td>
                                        @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $solicitud->persona->nombre ?? 'N/A' }} {{ $solicitud->persona->apellido ?? '' }}
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <!-- View Button -->
                                                <button wire:click="viewSolicitud({{ $solicitud->solicitud_id }})" 
                                                        class="text-blue-600 hover:text-blue-900">
                                                    <i class='bx bx-show'></i>
                                                </button>
                                                
                                                <!-- Edit Button -->
                                                @if(Auth::user()->isSuperAdministrador() || (Auth::user()->isUsuario() && $solicitud->persona_cedula === Auth::user()->persona_cedula))
                                                    <button wire:click="editSolicitud({{ $solicitud->solicitud_id }})" 
                                                            class="text-blue-600 hover:text-blue-900">
                                                        <i class='bx bx-edit'></i>
                                                    </button>
                                                @endif
                                                
                                                <!-- Delete Button -->
                                                @if(Auth::user()->isSuperAdministrador() || (Auth::user()->isUsuario() && $solicitud->persona_cedula === Auth::user()->persona_cedula))
                                                    <button wire:click="deleteSolicitud({{ $solicitud->solicitud_id }})" 
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar esta solicitud?')"
                                                            class="text-red-600 hover:text-red-900">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                @endif
                                                
                                                <!-- Status Change (Super Admin Only) -->
                                                @if(Auth::user()->isSuperAdministrador())
                                                    <div class="relative inline-block text-left">
                                                        <select wire:change="updateStatus({{ $solicitud->solicitud_id }}, $event.target.value)" 
                                                                class="text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                                            <option value="Pendiente" {{ $solicitud->estado_detallado === 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                            <option value="Aprobada" {{ $solicitud->estado_detallado === 'Aprobada' ? 'selected' : '' }}>Aprobada</option>
                                                            <option value="Rechazada" {{ $solicitud->estado_detallado === 'Rechazada' ? 'selected' : '' }}>Rechazada</option>
                                                            <option value="Asignada" {{ $solicitud->estado_detallado === 'Asignada' ? 'selected' : '' }}>Asignada</option>
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if($activeTab === 'create')
        <!-- Create New Solicitud -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Nueva Solicitud</h2>
                
                <!-- Redirect to creation flow -->
                <div class="text-center py-8">
                    <i class='bx bx-plus-circle text-4xl text-blue-500 mb-4'></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Crear Nueva Solicitud</h3>
                    <p class="text-gray-500 mb-6">Utiliza el formulario completo para crear una nueva solicitud</p>
                    <a href="{{ route('dashboard.usuario', ['tab' => 'crear']) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class='bx bx-plus mr-2'></i>
                        Ir al Formulario de Creación
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if($activeTab === 'edit' && $editingSolicitud)
        <!-- Edit Solicitud -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Editar Solicitud</h2>
                
                <form wire:submit.prevent="updateSolicitud">
                    <div class="space-y-6">
                        <!-- Basic Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                                <input type="text" wire:model="titulo" 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('titulo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categoría *</label>
                                <select wire:model="categoria" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecciona una categoría</option>
                                    @foreach($categories as $key => $category)
                                        <option value="{{ $key }}">{{ $category['title'] }}</option>
                                    @endforeach
                                </select>
                                @error('categoria') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        @if($categoria)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Subcategoría *</label>
                                <select wire:model="subcategoria" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecciona una subcategoría</option>
                                    @foreach($categories[$categoria]['subcategories'] as $key => $subcategory)
                                        <option value="{{ $key }}">{{ $subcategory }}</option>
                                    @endforeach
                                </select>
                                @error('subcategoria') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <!-- Location -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Parroquia *</label>
                                <input type="text" wire:model="parroquia" 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('parroquia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Comunidad *</label>
                                <input type="text" wire:model="comunidad" 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('comunidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dirección Detallada *</label>
                            <textarea wire:model="direccion_detallada" rows="3" 
                                      class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            @error('direccion_detallada') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción *</label>
                            <textarea wire:model="descripcion" rows="4" 
                                      class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Super Admin Only Fields -->
                        @if(Auth::user()->isSuperAdministrador())
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Administración (Solo SuperAdmin)</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                        <select wire:model="estado_detallado" 
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="Pendiente">Pendiente</option>
                                            <option value="Aprobada">Aprobada</option>
                                            <option value="Rechazada">Rechazada</option>
                                            <option value="Asignada">Asignada</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Visitador Asignado</label>
                                        <input type="text" wire:model="visitador_asignado" 
                                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones Admin</label>
                                    <textarea wire:model="observaciones_admin" rows="3" 
                                              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                        <button type="button" wire:click="setActiveTab('list')" 
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Actualizar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal for viewing solicitud -->
    @if($showingModal && $selectedSolicitud)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg max-w-4xl w-full max-h-screen overflow-y-auto m-4">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Detalles de la Solicitud</h2>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <i class='bx bx-x text-2xl'></i>
                        </button>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Basic Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ID de Solicitud</label>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->solicitud_id }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->titulo }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->categoria_formatted }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subcategoría</label>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->subcategoria_formatted }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $selectedSolicitud->estado_color === 'green' ? 'bg-green-100 text-green-800' : 
                                           ($selectedSolicitud->estado_color === 'yellow' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($selectedSolicitud->estado_color === 'red' ? 'bg-red-100 text-red-800' : 
                                           ($selectedSolicitud->estado_color === 'blue' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'))) }}">
                                        {{ $selectedSolicitud->estado_detallado }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Creación</label>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->fecha_creacion->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Parroquia</label>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->parroquia }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Comunidad</label>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->comunidad }}</div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección Detallada</label>
                            <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->direccion_detallada }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->descripcion }}</div>
                        </div>

                        @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                            <!-- Solicitante Info -->
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Solicitante</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                        <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->persona->nombre ?? 'N/A' }} {{ $selectedSolicitud->persona->apellido ?? '' }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cédula</label>
                                        <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->persona->nacionalidad ?? '' }}{{ $selectedSolicitud->persona->cedula ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(Auth::user()->isSuperAdministrador() && $selectedSolicitud->observaciones_admin)
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Observaciones Administrativas</h3>
                                <div class="p-3 bg-gray-50 rounded-lg">{{ $selectedSolicitud->observaciones_admin }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>