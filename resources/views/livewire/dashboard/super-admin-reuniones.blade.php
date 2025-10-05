<div class="min-h-screen bg-gray-50">
    <style>
        @supports(-webkit-appearance: none) or (-moz-appearance: none) {
            input[type='checkbox'],
            input[type='radio'] {
                --active: #275EFE;
                --active-inner: #fff;
                --focus: 2px rgba(39, 94, 254, .3);
                --border: #BBC1E1;
                --border-hover: #275EFE;
                --background: #fff;
                --disabled: #F6F8FF;
                --disabled-inner: #E1E6F9;
                -webkit-appearance: none;
                -moz-appearance: none;
                height: 21px;
                outline: none;
                display: inline-block;
                vertical-align: top;
                position: relative;
                margin: 0;
                border: 1px solid var(--bc, var(--border));
                background: var(--b, var(--background));
                transition: background .3s, border-color .3s, box-shadow .2s;
                &:after {
                content: '';
                display: block;
                left: 0;
                top: 0;
                position: absolute;
                transition: transform var(--d-t, .3s) var(--d-t-e, ease), opacity var(--d-o, .2s);
                }
                &:checked {
                --b: var(--active);
                --bc: var(--active);
                --d-o: .3s;
                --d-t: .6s;
                --d-t-e: cubic-bezier(.2, .85, .32, 1.2);
                }
                &:disabled {
                --b: var(--disabled);
                cursor: not-allowed;
                opacity: .9;
                &:checked {
                    --b: var(--disabled-inner);
                    --bc: var(--border);
                }
                & + label {
                    cursor: not-allowed;
                }
                }
                &:focus {
                box-shadow: 0 0 0 var(--focus);
                }
                &:hover {
                &:not(:checked) {
                    &:not(:disabled) {
                    --bc: var(--border-hover);
                    }
                }
                }
            }
            input[type='checkbox'] {
                &:not(.switch) {
                width: 21px;
                &:after {
                    opacity: var(--o, 0);
                }
                &:checked {
                    --o: 1;
                }
                & + label {
                    font-size: 14px;
                    line-height: 21px;
                    display: inline-block;
                    vertical-align: top;
                    cursor: pointer;
                    margin-left: 4px;
                }
                }
                &:after {
                width: 5px;
                height: 9px;
                border: 2px solid var(--active-inner);
                border-top: 0;
                border-left: 0;
                left: 7px;
                top: 4px;
                transform: rotate(var(--r, 20deg));
                }
                &:checked {
                --r: 43deg;
                }
            }
            input[type='radio'] {
                border-radius: 50%;
                &:after {
                width: 19px;
                height: 19px;
                border-radius: 50%;
                background: var(--active-inner);
                opacity: 0;
                transform: scale(var(--s, .7));
                }
                &:checked {
                --s: .5;
                }
            }
        }
    </style>
    
    <!-- Tab Navigation -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center py-6">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                            <i class='bx bx-group text-white text-xl'></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Gestión de Reuniones</h1>
                            <p class="text-sm text-gray-600">Sistema Municipal CMBEY</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if($activeTab !== 'create' && Auth::user()->isSuperAdministrador())
                        <button wire:click="setActiveTab('create')" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                            <i class='bx bx-plus mr-2'></i>
                            Nueva Reunión
                        </button>
                    @endif
                    @if($activeTab !== 'list' && count($reuniones) > 0)
                        <button wire:click="setActiveTab('list')" 
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Ver Reuniones
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($activeTab === 'list')
            <!-- Reuniones List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <i class='bx bx-list-ul text-green-600 mr-2'></i>
                        @if(Auth::user()->isSuperAdministrador())
                            Todas las Reuniones
                        @elseif(Auth::user()->isAdministrador())
                            Reuniones (Solo Lectura)
                        @endif
                    </h2>
                    <div class="flex max-lg:flex-col sm:flex-row items-center space-y-4 sm:space-y-0 space-x-4 w-full sm:w-auto">
                        <div class="relative w-full sm:w-auto">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar reunión..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 w-full">
                            <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                        </div>
                        <span class="text-sm text-gray-500">{{ $reuniones->count() }} Reuniones</span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="orden('titulo')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <i class='bx bx-text'></i>
                                            Título
                                        </div>
                                        @if ($sort == 'titulo')
                                            @if ($direction == 'asc')
                                                <i class='bx bx-caret-up mr-2'></i>
                                            @else
                                                <i class='bx bx-caret-down mr-2'></i>
                                            @endif
                                        @else
                                            <i class='bx bx-carets-up-down mr-2'></i>
                                        @endif
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="orden('fecha_reunion')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <i class='bx bx-calendar'></i>
                                            Fecha
                                        </div>
                                        @if ($sort == 'fecha_reunion')
                                            @if ($direction == 'asc')
                                                <i class='bx bx-caret-up mr-2'></i>
                                            @else
                                                <i class='bx bx-caret-down mr-2'></i>
                                            @endif
                                        @else
                                            <i class='bx bx-carets-up-down mr-2'></i>
                                        @endif
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class='bx bx-building mr-2'></i>
                                    Institución
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class='bx bx-file mr-2'></i>
                                    Solicitud
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class='bx bx-users mr-2'></i>
                                    Asistentes
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class='bx bx-cog mr-2'></i>
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reuniones as $reunion)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                    <i class='bx bx-group text-green-600'></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $reunion->titulo }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($reunion->descripcion, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $reunion->fecha_reunion ? $reunion->fecha_reunion->format('d/m/Y') : 'Sin fecha' }}</span>
                                            <span class="text-gray-500 text-xs">{{ $reunion->fecha_reunion ? $reunion->fecha_reunion->format('H:i') : '' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $reunion->institucion->titulo ?? 'Sin institución' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($reunion->solicitud)
                                            <div class="flex flex-col">
                                                <span class="font-medium">{{ $reunion->solicitud->solicitud_id }}</span>
                                                <span class="text-gray-500 text-xs">{{ Str::limit($reunion->solicitud->titulo, 30) }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Sin solicitud asociada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $reunion->asistentes->count() }} asistentes
                                            </span>
                                            @if($reunion->consejales->count() > 0)
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    {{ $reunion->consejales->count() }} consejales
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <button wire:click="viewReunion({{ $reunion->id }})" 
                                                    class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition-colors"
                                                    title="Ver detalles">
                                                <i class='bx bx-show'></i>
                                            </button>
                                            @if(Auth::user()->isSuperAdministrador())
                                                <button wire:click="editReunion({{ $reunion->id }})" 
                                                        class="text-yellow-600 hover:text-yellow-900 p-2 hover:bg-yellow-50 rounded-lg transition-colors"
                                                        title="Editar">
                                                    <i class='bx bx-edit'></i>
                                                </button>
                                                <button wire:click="deleteReunion({{ $reunion->id }})" 
                                                        onclick="return confirm('¿Está seguro de eliminar esta reunión?')"
                                                        class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded-lg transition-colors"
                                                        title="Eliminar">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class='bx bx-group text-6xl text-gray-300 mb-4'></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay reuniones</h3>
                                            <p class="text-gray-500 mb-4">Aún no se han creado reuniones en el sistema.</p>
                                            @if(Auth::user()->isSuperAdministrador())
                                                <button wire:click="setActiveTab('create')" 
                                                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                                    <i class='bx bx-plus mr-2'></i>
                                                    Crear Primera Reunión
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        @elseif($activeTab === 'create' || $activeTab === 'edit')
            <!-- Formulario de Reunión -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                        <i class='bx {{ $activeTab === "create" ? "bx-plus" : "bx-edit" }} text-green-600 mr-2'></i>
                        {{ $activeTab === 'create' ? 'Crear Nueva Reunión' : 'Editar Reunión' }}
                    </h2>
                </div>

                <form wire:submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Título -->
                        <div class="md:col-span-2">
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-text mr-2'></i>Título de la Reunión
                            </label>
                            <input type="text" id="titulo" wire:model="titulo" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="Ingrese el título de la reunión">
                            @error('titulo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fecha y Hora -->
                        <div>
                            <label for="fecha_reunion" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-calendar mr-2'></i>Fecha y Hora
                            </label>
                            <input type="datetime-local" id="fecha_reunion" wire:model="fecha_reunion" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            @error('fecha_reunion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Ubicación -->
                        <div>
                            <label for="ubicacion" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-location-plus mr-2'></i>Ubicación
                            </label>
                            <input type="text" id="ubicacion" wire:model="ubicacion" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="Dirección o lugar de la reunión">
                            @error('ubicacion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Institución -->
                        <div>
                            <label for="institucion_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-building mr-2'></i>Institución
                            </label>
                            <select id="institucion_id" wire:model="institucion_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="">Seleccione una institución</option>
                                @foreach($instituciones as $institucion)
                                    <option value="{{ $institucion->id }}">{{ $institucion->titulo }}</option>
                                @endforeach
                            </select>
                            @error('institucion_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Solicitud (Opcional) -->
                        <div>
                            <label for="solicitud_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-file mr-2'></i>Solicitud Asociada (Opcional)
                            </label>
                            <select id="solicitud_id" wire:model="solicitud_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="">Sin solicitud asociada</option>
                                @foreach($solicitudes as $solicitud)
                                    <option value="{{ $solicitud->solicitud_id }}">{{ $solicitud->solicitud_id }} - {{ $solicitud->titulo }}</option>
                                @endforeach
                            </select>
                            @error('solicitud_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="md:col-span-2">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-align-left mr-2'></i>Descripción/Acta
                            </label>
                            <textarea id="descripcion" wire:model="descripcion" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                      placeholder="Describa los temas a tratar o el acta de la reunión"></textarea>
                            @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Sección de Asistentes -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class='bx bx-users mr-2'></i>Gestión de Asistentes
                        </h3>
                        
                        <!-- Buscar Personas -->
                        <div class="mb-4">
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.300ms="searchPersonas" 
                                       placeholder="Buscar personas por nombre, apellido o cédula..."
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                            </div>
                        </div>

                        <!-- Lista de Personas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($todasPersonas as $persona)
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" 
                                               wire:click="toggleAsistente('{{ $persona->cedula }}')"
                                               {{ in_array($persona->cedula, $selectedAsistentes) ? 'checked' : '' }}
                                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $persona->nombre }} {{ $persona->apellido }}
                                            </div>
                                            <div class="text-sm text-gray-500">CI: {{ $persona->cedula }}</div>
                                        </div>
                                    </div>
                                    @if(in_array($persona->cedula, $selectedAsistentes))
                                        <button type="button"
                                                wire:click="toggleConsejal('{{ $persona->cedula }}')"
                                                class="px-3 py-1 text-xs rounded-full transition-colors
                                                       {{ in_array($persona->cedula, $selectedConsejales) 
                                                          ? 'bg-purple-100 text-purple-800 border-purple-200' 
                                                          : 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                            {{ in_array($persona->cedula, $selectedConsejales) ? 'Consejal' : 'Marcar como Consejal' }}
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Resumen de Selección -->
                        @if(count($selectedAsistentes) > 0)
                            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm font-medium text-green-800">
                                        <i class='bx bx-users mr-2'></i>{{ count($selectedAsistentes) }} asistentes seleccionados
                                    </span>
                                    @if(count($selectedConsejales) > 0)
                                        <span class="text-sm font-medium text-purple-800">
                                            <i class='bx bx-crown mr-2'></i>{{ count($selectedConsejales) }} consejales
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <button type="button" wire:click="setActiveTab('list')" 
                                class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bx-x mr-2'></i>Cancelar
                        </button>
                        <button type="submit" 
                                class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class='bx {{ $activeTab === "create" ? "bx-plus" : "bx-save" }} mr-2'></i>
                            {{ $activeTab === 'create' ? 'Crear Reunión' : 'Actualizar Reunión' }}
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- Modal de Detalles -->
    @if($showingModal && $selectedReunion)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" 
             wire:click="closeModal">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white"
                 wire:click.stop>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class='bx bx-group mr-2'></i>Detalles de la Reunión
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class='bx bx-x text-xl'></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedReunion->titulo }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha y Hora</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $selectedReunion->fecha_reunion ? $selectedReunion->fecha_reunion->format('d/m/Y H:i') : 'No definida' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ubicación</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedReunion->ubicacion }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Institución</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedReunion->institucion->titulo ?? 'No definida' }}</p>
                        </div>
                        @if($selectedReunion->solicitud)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Solicitud Asociada</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $selectedReunion->solicitud->solicitud_id }} - {{ $selectedReunion->solicitud->titulo }}
                                </p>
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Descripción/Acta</label>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $selectedReunion->descripcion }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Asistentes</label>
                        <div class="space-y-2">
                            @forelse($selectedReunion->asistentes as $asistente)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                    <span class="text-sm text-gray-900">
                                        {{ $asistente->nombre }} {{ $asistente->apellido }} (CI: {{ $asistente->cedula }})
                                    </span>
                                    @if($asistente->pivot->es_consejal)
                                        <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">
                                            Consejal
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 italic">No hay asistentes registrados</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end mt-6">
                    <button wire:click="closeModal" 
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>