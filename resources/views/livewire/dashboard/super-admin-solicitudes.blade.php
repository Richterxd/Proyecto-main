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
                &:hover {
                &:not(:checked) {
                    &:not(:disabled) {
                    --bc: var(--border-hover);
                    }
                }
                }
                &:focus {
                box-shadow: 0 0 0 var(--focus);
                }
                &:not(.switch) {
                width: 21px;
                &:after {
                    opacity: var(--o, 0);
                }
                &:checked {
                    --o: 1;
                }
                }
                & + label {
                font-size: 14px;
                line-height: 21px;
                display: inline-block;
                vertical-align: top;
                margin-left: 4px;
                }
            }
            input[type='checkbox'] {
                &:not(.switch) {
                border-radius: 7px;
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
                &.switch {
                width: 38px;
                border-radius: 11px;
                &:after {
                    left: 2px;
                    top: 2px;
                    border-radius: 50%;
                    width: 15px;
                    height: 15px;
                    background: var(--ab, var(--border));
                    transform: translateX(var(--x, 0));
                }
                &:checked {
                    --ab: var(--active-inner);
                    --x: 17px;
                }
                &:disabled {
                    &:not(:checked) {
                    &:after {
                        opacity: .6;
                    }
                    }
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
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class='bx bx-file-blank text-white text-xl'></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Gestión de Solicitudes</h1>
                            <p class="text-sm text-gray-600">Sistema Municipal CMBEY</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if($activeTab !== 'create' && Auth::user()->isSuperAdministrador())
                        <button wire:click="setActiveTab('create')" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                            <i class='bx bx-plus mr-2'></i>
                            Nueva Solicitud
                        </button>
                    @endif
                    @if($activeTab !== 'list' && count($solicitudes) > 0)
                        <button wire:click="setActiveTab('list')" 
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Ver Solicitudes
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($activeTab === 'list')
            <!-- Solicitudes List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <div class="">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <i class='bx bx-list-ul text-blue-600 mr-2'></i>
                            @if(Auth::user()->isSuperAdministrador())
                                Todas las Solicitudes
                            @elseif(Auth::user()->isAdministrador())
                                Solicitudes (Solo Lectura)
                            @endif
                        </h2>
                        <div class="flex max-lg:flex-col sm:flex-row items-center space-y-4 sm:space-y-0 space-x-4 w-full sm:w-auto">
                            <div class="relative w-full sm:w-auto">
                                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar solicitud..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                                <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                            </div>
                            <span class="text-sm text-gray-500">{{ $solicitudes->count() }} Solicitudes</span>
                        </div>
                    </div>
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                            wire:click="orden('solicitud_id')">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <i class='bx bx-purchase-tag-alt'></i>
                                                    Solicitud
                                                </div>
                                                @if ($sort == 'solicitud_id')
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
                                            wire:click="orden('categoria')">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <i class='bx bx-folder'></i>
                                                    Categoría
                                                </div>
                                                @if ($sort == 'categoria')
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
                                            <div class="flex justify-between items-center" x-data="{selectActive: 0}">
                                                <div>
                                                    <i class='bx bx-check-shield'></i>
                                                    Estado
                                                </div>
                                                <div class="relative items-center space-x-1">
                                                    <div class="w-10 h-6 rounded-full flex items-center justify-center cursor-pointer transition-colors
                                                    {{ $estadoSolicitud === 'Aprobada' ? 'bg-green-100 hover:bg-green-300' : 
                                                    ($estadoSolicitud === 'Pendiente' ? 'bg-yellow-100 hover:bg-yellow-300' : 
                                                    ($estadoSolicitud === 'Rechazada' ? 'bg-red-100 hover:bg-red-300' : 
                                                    ($estadoSolicitud === 'Asignada' ? 'bg-blue-100 hover:bg-blue-300' : 'bg-gray-200 hover:bg-gray-300'))) }}"
                                                    @click="selectActive = selectActive === 1 ? 0 : 1">
                                                        <i class='bx bx-caret-down text-xl
                                                        {{ $estadoSolicitud === 'Aprobada' ? 'text-green-800' : 
                                                        ($estadoSolicitud === 'Pendiente' ? 'text-yellow-800' : 
                                                        ($estadoSolicitud === 'Rechazada' ? 'text-red-800' : 
                                                        ($estadoSolicitud === 'Asignada' ? ' text-blue-800' : 'text-gray-500'))) }}'
                                                        :class="{
                                                            'transform rotate-180': selectActive === 1,
                                                        }"></i>
                                                    </div>
                                                    <div class="absolute mt-1 bg-white border border-gray-200 rounded-lg shadow-lg"
                                                        x-show="selectActive === 1" x-transition
                                                        @click.away="selectActive = 0"
                                                        x-cloak
                                                        x-bind
                                                    :class="{
                                                        'hidden': selectActive !== 1,
                                                    }">
                                                        <ul>
                                                            <li class="p-2 transition-colors cursor-default hover:bg-gray-200 hover:text-gray-800"
                                                            wire:click="ordenEstados('todo')">Todo</li>
                                                            <li class="p-2 transition-colors cursor-default hover:bg-yellow-100 hover:text-yellow-800"
                                                            wire:click="ordenEstados('Pendiente')">Pendientes</li>
                                                            <li class="p-2 transition-colors cursor-default hover:bg-green-100 hover:text-green-800"
                                                            wire:click="ordenEstados('Aprobada')">Aprobadas</li>
                                                            <li class="p-2 transition-colors cursor-default hover:bg-red-100 hover:text-red-800"
                                                            wire:click="ordenEstados('Rechazada')">Rechazadas</li>
                                                            <li class="p-2 transition-colors cursor-default hover:bg-blue-100 hover:text-blue-800"
                                                            wire:click="ordenEstados('Asignada')">Asignadas</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                            wire:click="orden('fecha_creacion')">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <i class='bx bx-calendar-alt'></i>
                                                    Fecha
                                                </div>
                                                @if ($sort == 'fecha_creacion')
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
                                        @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                                wire:click="orden('persona.nombre')">
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <i class='bx bx-user'></i>
                                                        Solicitante
                                                    </div>
                                                    @if ($sort == 'persona.nombre')
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
                                        @endif
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                            <div class="flex justify-start items-center">
                                                <i class='bx bx-cog'></i>
                                                Acciones
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($solicitudes as $solicitud)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 w-60 truncate " title="{{ $solicitud->titulo }}">
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
                                                {{ $solicitud->fecha_creacion->format('d/m/Y') }}
                                            </td>
                                            @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $solicitud->persona->nombre ?? 'N/A' }} {{ $solicitud->persona->apellido ?? '' }}
                                                </td>
                                            @endif
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium w-50">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <!-- View Button -->
                                                    <button wire:click="viewSolicitud({{ $solicitud->solicitud_id }})" 
                                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                    title="Ver detalles">
                                                        <i class='bx bx-show'></i>
                                                    </button>
                                                    
                                                    <!-- Edit Button -->
                                                    @if(Auth::user()->isSuperAdministrador())
                                                        <button wire:click="editSolicitud({{ $solicitud->solicitud_id }})" 
                                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                        title="Editar">
                                                            <i class='bx bx-edit'></i>
                                                        </button>
                                                    @endif
                                                    
                                                    <!-- Delete Button -->
                                                    @if(Auth::user()->isSuperAdministrador())
                                                        <button wire:click="deleteSolicitud({{ $solicitud->solicitud_id }})" 
                                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta solicitud?')"
                                                        class="p-2 text-red-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                        title="Editar">
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
                                @if($solicitudesRender->isEmpty() && $solicitudesRender->currentPage() == 1)
                                    <div class="text-center py-8">
                                        <i class='bx bx-file text-4xl text-gray-400 mb-4'></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay solicitudes</h3>
                                        <p class="text-gray-500">
                                            No se encontraron solicitudes en el sistema
                                        </p>
                                    </div>
                                @else
                                    <div class="mx-5">
                                        {{ $solicitudesRender->links() }}
                                    </div>
                                @endif
                        </div>
                </div>
            </div>
        @endif

        @if($activeTab === 'create' || $activeTab === 'edit' && $editingSolicitud)
            <!-- Create/Edit Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-8">
                    <!-- Form Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ $editingSolicitud ? 'Editar Solicitud' : 'Nueva Solicitud Completa' }}
                            </h2>
                            <div class="flex items-center space-x-2">
                                @if($editingSolicitud)
                                    <div class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        <i class='bx bx-edit mr-1'></i>
                                        Editando
                                    </div>
                                @else
                                    <div class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        <i class='bx bx-plus mr-1'></i>
                                        Creando
                                    </div>
                                @endif
                            </div>
                        </div>
                        <p class="text-gray-600">Complete todos los campos requeridos para {{ $editingSolicitud ? 'actualizar' : 'crear' }} su solicitud</p>
                    </div>

                    <!-- Progress Steps -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 {{ $personalData['cedula'] && $personalData['nombre_completo'] && $personalData['telefono'] && $personalData['email'] ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $personalData['cedula'] && $personalData['nombre_completo'] && $personalData['telefono'] && $personalData['email'] ? '✓' : '1' }}
                                    </div>
                                    <span class="ml-2 text-sm font-medium {{ $personalData['cedula'] && $personalData['nombre_completo'] && $personalData['telefono'] && $personalData['email'] ? 'text-blue-600' : 'text-gray-500' }}">Datos Personales</span>
                                </div>
                                <div class="w-8 h-1 {{ $personalData['cedula'] && $personalData['nombre_completo'] && $personalData['telefono'] && $personalData['email'] ? 'bg-blue-600' : 'bg-gray-300' }} rounded"></div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 {{ $categoria ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $categoria ? '✓' : '2' }}
                                    </div>
                                    <span class="ml-2 text-sm font-medium {{ $categoria ? 'text-blue-600' : 'text-gray-500' }}">Categoría</span>
                                </div>
                                <div class="w-8 h-1 {{ $categoria && $subcategoria ? 'bg-blue-600' : 'bg-gray-300' }} rounded"></div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 {{ $detailedAddress['parroquia'] ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $detailedAddress['parroquia'] ? '✓' : '3' }}
                                    </div>
                                    <span class="ml-2 text-sm font-medium {{ $detailedAddress['parroquia'] ? 'text-blue-600' : 'text-gray-500' }}">Ubicación</span>
                                </div>
                                <div class="w-8 h-1 {{ strlen($descripcion) >= 50 ? 'bg-blue-600' : 'bg-gray-300' }} rounded"></div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 {{ strlen($descripcion) >= 50 ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-bold">
                                        {{ strlen($descripcion) >= 50 ? '✓' : '4' }}
                                    </div>
                                    <span class="ml-2 text-sm font-medium {{ strlen($descripcion) >= 50 ? 'text-blue-600' : 'text-gray-500' }}">Descripción</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="submit" class="space-y-8">
                        
                        <!-- Step 1: Personal Data Display -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-user text-blue-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Datos Personales</h3>
                                    @if($personalData['cedula'] && $personalData['nombre_completo'] && $personalData['telefono'] && $personalData['email'])
                                        <p class="text-sm text-gray-600">Información registrada en el sistema</p>
                                    @else
                                        <p class="text-sm text-gray-600">Ingresar información personal</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cédula de Identidad</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-id-card text-blue-600 mr-2'></i>
                                        @if($personalData['cedula'] && $editingSolicitud)
                                            <span class="font-medium text-gray-900">{{ $personalData['cedula'] ?? 'No registrado' }}</span>
                                        @else
                                            <input type="text" maxlength="8" wire:model.live="personalData.cedula" class="font-medium text-gray-900 focus:outline-none" placeholder="Escribir Cédula...">
                                        @endif
                                    </div>
                                    @error('personalData.cedula') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-user text-blue-600 mr-2'></i>
                                        @if($personalData['nombre_completo'] && $editingSolicitud)
                                            <span class="font-medium text-gray-900">{{ $personalData['nombre_completo'] ?? 'No registrado' }}</span>
                                        @else
                                            <input type="text" wire:model.live="personalData.nombre_completo" class="font-medium text-gray-900 focus:outline-none" placeholder="Escribir Nombre Completo...">
                                        @endif
                                    </div>
                                    @error('personalData.nombre_completo') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-envelope text-blue-600 mr-2'></i>
                                        @if($personalData['email'] && $editingSolicitud)
                                            <span class="font-medium text-gray-900">{{ $personalData['email'] ?? 'No registrado' }}</span>
                                        @else
                                            <input type="email" wire:model.live="personalData.email" class="font-medium text-gray-900 focus:outline-none" placeholder="Escribir Correo...">
                                        @endif
                                    </div>
                                    @error('personalData.email') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition duration-150 ease-in-out">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-phone text-blue-600 mr-2'></i>
                                        @if($personalData['telefono'] && $editingSolicitud)
                                            <span class="font-medium text-gray-900">{{ $personalData['telefono'] ?? 'No registrado' }}</span>
                                        @else
                                        <input type="text" id="telefono_solicitud" wire:model.live="personalData.telefono" class="font-medium text-gray-900 focus:outline-none"                 
                                            pattern="\d{4}-\d{3}-\d{4}"
                                            oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{4})(\d{3})(\d{4})/, '$1-$2-$3').slice(0, 13);"
                                            placeholder="XXXX-XXX-XXXX" maxlength="13">
                                        @endif
                                    </div>
                                    @error('personalData.telefono') 
                                        <div class="flex items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Category Selection -->
                        <div class="space-y-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-category text-blue-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Categoría de Solicitud</h3>
                                    <p class="text-sm text-gray-600">Seleccione el tipo de solicitud que desea realizar</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach ($categories as $key => $category)
                                    <div class="border-2 rounded-xl p-6 cursor-pointer transition-all duration-300 hover:shadow-lg transform hover:scale-105
                                        {{ $categoria === $key ? 'border-blue-500 bg-blue-50 shadow-lg' : 'border-gray-200 hover:border-blue-300' }}"
                                        wire:click="$set('categoria', '{{ $key }}')">
                                        <div class="text-center">
                                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                                <i class='bx {{ $category['icon'] }} text-3xl text-blue-600'></i>
                                            </div>
                                            <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $category['title'] }}</h4>
                                            <p class="text-sm text-gray-600">{{ count($category['subcategories']) }} opciones</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('categoria') 
                                <div class="flex justify-end items-center text-red-600 text-sm mt-2">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- Subcategory Selection -->
                            @if ($categoria)
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="text-lg font-bold text-gray-900 mb-4">
                                        Subcategorías de {{ $categories[$categoria]['title'] }}
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach ($categories[$categoria]['subcategories'] as $key => $subcategory)
                                            <div class="border-2 rounded-lg p-4 cursor-pointer transition-all duration-300 hover:shadow-md
                                                {{ $subcategoria === $key ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300' }}"
                                                wire:click="$set('subcategoria', '{{ $key }}')">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                                        <i class='bx bx-check text-white text-sm'></i>
                                                    </div>
                                                    <span class="font-medium text-gray-900">{{ $subcategory }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('subcategoria') 
                                        <div class="flex justify-end items-center text-red-600 text-sm mt-2">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <!-- Step 3: Location Details -->
                        <div class="space-y-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-map text-blue-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Ubicación de la Solicitud</h3>
                                    <p class="text-sm text-gray-600">Proporcione los detalles de ubicación donde se requiere el servicio</p>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">País</label>
                                        <div class="flex items-center">
                                            <i class='bx bx-world text-gray-500 mr-2'></i>
                                            <span class="text-gray-900">{{ $detailedAddress['pais'] }}</span>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                        <div class="flex items-center">
                                            <i class='bx bx-map-pin text-gray-500 mr-2'></i>
                                            <span class="text-gray-900">{{ $detailedAddress['estado_region'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Municipio</label>
                                        <div class="flex items-center">
                                            <i class='bx bx-buildings text-gray-500 mr-2'></i>
                                            <span class="text-gray-900">{{ $detailedAddress['municipio'] }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Parroquia *</label>
                                        <select wire:model.live="detailedAddress.parroquia" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                            <option value="" disabled selected>Seleccione una parroquia</option>
                                            @foreach ($parroquias as $key => $parroquia)
                                                <option value="{{$key}}">{{$parroquia}}</option>
                                            @endforeach
                                        </select>
                                        @error('detailedAddress.parroquia') 
                                            <div class="flex items-center text-red-600 text-sm mt-1">
                                                <i class='bx bx-error-circle mr-1'></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Comunidad *</label>
                                    <input type="text" wire:model.live="detailedAddress.comunidad" 
                                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                           placeholder="Ejemplo: Sector Los Pinos">
                                    <div class="flex justify-between items-center mt-4">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class='bx bx-info-circle mr-1'></i>
                                            <span>Caracteres: {{ strlen($detailedAddress['comunidad']) }}/50 (mínimo 5)</span>
                                        </div>
                                        <div class="flex items-center">
                                            @if($detailedAddress['comunidad'])
                                                @if(strlen($detailedAddress['comunidad']) >= 5 && strlen($detailedAddress['comunidad']) <= 50)
                                                    <i class='bx bx-check-circle text-green-500 mr-1'></i>
                                                    <span class="text-green-600 text-sm font-medium">Válida</span>
                                                @elseif(strlen($detailedAddress['comunidad']) < 5)
                                                    <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                    <span class="text-red-600 text-sm font-medium">Muy corto</span>
                                                @else
                                                    <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                    <span class="text-red-600 text-sm font-medium">Muy largo</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    @error('detailedAddress.comunidad') 
                                        <div class="flex justify-end items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Dirección Detallada *</label>
                                    <textarea wire:model.live="detailedAddress.direccion_detallada" rows="4" 
                                              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                              placeholder="Proporcione la dirección completa incluyendo puntos de referencia importantes..."></textarea>
                                    <div class="flex justify-between items-center mt-2">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class='bx bx-info-circle mr-1'></i>
                                            <span>Caracteres: {{ strlen($detailedAddress['direccion_detallada']) }}/200 (mínimo 10)</span>
                                        </div>
                                        <div class="flex items-center">
                                            @if($detailedAddress['direccion_detallada'])
                                                @if(strlen($detailedAddress['direccion_detallada']) >= 10 && strlen($detailedAddress['direccion_detallada']) <= 200)
                                                    <i class='bx bx-check-circle text-green-500 mr-1'></i>
                                                    <span class="text-green-600 text-sm font-medium">Válida</span>
                                                @elseif(strlen($detailedAddress['direccion_detallada']) < 10)
                                                    <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                    <span class="text-red-600 text-sm font-medium">Muy corto</span>
                                                @else
                                                    <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                    <span class="text-red-600 text-sm font-medium">Muy largo</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    @error('detailedAddress.direccion_detallada') 
                                        <div class="flex justify-end items-center text-red-600 text-sm mt-1">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Description -->
                        <div class="space-y-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class='bx bx-edit text-blue-600 text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Descripción de la Solicitud</h3>
                                    <p class="text-sm text-gray-600">Describa detalladamente su solicitud (mínimo 50 caracteres)</p>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Titulo *</label>
                                <input type="text" wire:model.live="titulo" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Escriba un breve titulo para su solicitud">
                                <div class="flex justify-between items-center mt-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class='bx bx-info-circle mr-1'></i>
                                        <span>Caracteres: {{ strlen($titulo) }}/50 (mínimo 5)</span>
                                    </div>
                                    <div class="flex items-center">
                                        @if($titulo)
                                            @if(strlen($titulo) >= 5 && strlen($titulo) <= 50)
                                                <i class='bx bx-check-circle text-green-500 mr-1'></i>
                                                <span class="text-green-600 text-sm font-medium">Válida</span>
                                            @elseif(strlen($titulo) < 5)
                                                <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                <span class="text-red-600 text-sm font-medium">Muy corto</span>
                                            @else
                                                <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                <span class="text-red-600 text-sm font-medium">Muy largo</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                @error('titulo') 
                                    <div class="flex justify-end items-center text-red-600 text-sm mt-2">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                    
                                <textarea wire:model.live="descripcion" rows="8" 
                                          class="w-full p-4 mt-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                          placeholder="Describa detalladamente su solicitud. Incluya información relevante como el problema específico"></textarea>
                                
                                <div class="flex justify-between items-center mt-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class='bx bx-info-circle mr-1'></i>
                                        <span>Caracteres: {{ strlen($descripcion) }}/5000 (mínimo 50)</span>
                                    </div>
                                    <div class="flex items-center">
                                        @if($descripcion)
                                            @if(strlen($descripcion) >= 50 && strlen($descripcion) <= 5000)
                                                <i class='bx bx-check-circle text-green-500 mr-1'></i>
                                                <span class="text-green-600 text-sm font-medium">Válida</span>
                                            @elseif(strlen($descripcion) < 50)
                                                <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                <span class="text-red-600 text-sm font-medium">Muy corto</span>
                                            @else
                                                <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                <span class="text-red-600 text-sm font-medium">Muy largo</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                                @error('descripcion') 
                                    <div class="flex justify-end items-center text-red-600 text-sm mt-2">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Super Admin Only Fields -->
                        @if(Auth::user()->isSuperAdministrador() && $editingSolicitud)
                            <div class="space-y-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class='bx bx-map text-blue-600 text-xl'></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Administración</h3>
                                        <p class="text-sm text-gray-600">Control y monitoreo de la solicitud</p>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach ($solicitudEstados as $key => $estado)
                                            <div class="border-2 rounded-xl p-6 cursor-pointer transition-all duration-300 hover:shadow-lg transform hover:scale-105
                                                {{ $estado_detallado === $key ? 'border-blue-500 bg-blue-50 shadow-lg' : 'border-gray-200 hover:border-blue-300' }}"
                                                wire:click="$set('estado_detallado', '{{ $key }}')">
                                                <div class="text-center">
                                                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                                        <i class='bx {{ $estado === 'Pendiente' ? 'bx-time-five text-yellow-500' :
                                                                        ($estado === 'Aprobada' ? 'bx-check-circle text-green-500' :
                                                                        ($estado === 'Rechazada' ? 'bx-x-circle text-red-500' : 'bx-user-check text-blue-500'))
                                                                        }} text-3xl text-blue-600'></i>
                                                    </div>
                                                    <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $estado }}</h4>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <div class="grid grid-cols-1">
                                        @if ($estado_detallado === 'Asignada' && $editingSolicitud)
                                            <h4 class="text-lg font-bold text-gray-900 mb-4">
                                                Asignar la visita
                                            </h4>
                                            <div class="relative w-full mb-4 sm:w-auto">
                                                <input type="text" wire:model.live.debounce.300ms="searchAsignador" placeholder="Buscar..."
                                                    class="pl-10 pr-4 bg-white py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                                                <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                                            </div>
                                            <div class="grid grid-cols-2 lg:grid-cols-3 space-x-4 gap-4 mb-4">
                                                @if ($trabajadoresYUsuarios)
                                                    @foreach ($trabajadoresYUsuarios as $trabajadorYUsuario)
                                                        <div class="border-2 rounded-xl p-6 cursor-pointer transition-all duration-300 hover:shadow-lg transform hover:scale-105
                                                            {{ $visitador_asignado === $trabajadorYUsuario->persona_cedula ? 'border-blue-500 bg-blue-50 shadow-lg' : 'border-gray-200 hover:border-blue-300' }}"
                                                            wire:click="$set('visitador_asignado', {{ $trabajadorYUsuario->persona_cedula }})">
                                                            <div class="flex items-center">
                                                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                                                    <i class='bx bx-check text-white text-sm'></i>
                                                                </div>
                                                                <div class="">
                                                                    <span class="font-bold text-gray-900">{{ $trabajadorYUsuario->persona->nombre}}</span>
                                                                    <p class="text-sm text-gray-600">Consejal y Trabajador</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                @if ($consejales)
                                                    @foreach ($consejales as $consejal)
                                                        <div class="border-2 rounded-xl p-6 cursor-pointer transition-all duration-300 hover:shadow-lg transform hover:scale-105
                                                            {{ $visitador_asignado === $consejal->persona_cedula ? 'border-blue-500 bg-blue-50 shadow-lg' : 'border-gray-200 hover:border-blue-300' }}"
                                                            wire:click="$set('visitador_asignado', {{ $consejal->persona_cedula }})">
                                                            <div class="flex items-center">
                                                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                                                    <i class='bx bx-check text-white text-sm'></i>
                                                                </div>
                                                                <div class="">
                                                                    <span class="font-bold text-gray-900">{{ $consejal->persona->nombre }} {{$consejal->persona->apellido}}</span>
                                                                    <p class="text-sm text-gray-600">Consejal</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                @if ($trabajadores)
                                                    @foreach ($trabajadores as $trabajador)
                                                        <div class="border-2 rounded-xl p-6 cursor-pointer transition-all duration-300 hover:shadow-lg transform hover:scale-105
                                                            {{ $visitador_asignado === $trabajador->cedula ? 'border-blue-500 bg-blue-50 shadow-lg' : 'border-gray-200 hover:border-blue-300' }}"
                                                            wire:click="$set('visitador_asignado', {{ $trabajador->cedula }})">
                                                            <div class="flex items-center">
                                                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                                                    <i class='bx bx-check text-white text-sm'></i>
                                                                </div>
                                                                <div class="">
                                                                    <span class="font-bold text-gray-900">{{ $trabajador->nombres }} {{$trabajador->apellidos}}</span>
                                                                    <p class="text-sm text-gray-600">Trabajador</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                        <div class="">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                {{$estado_detallado === 'Aprobada' ? 'Motivos de aprobación' : 
                                                  ($estado_detallado === 'Rechazada' ? 'Motivo de rechazo' :
                                                ($estado_detallado === 'Asignada' ? 'Aclaraciones de la asignación': 'Observaciones de la solicitud'))}}</label>
                                            <textarea wire:model="observaciones_admin" rows="3" 
                                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                        </div>
                                    </div>
                                    

                                </div>
                            </div>
                        @endif

                        <!-- Checkbox Derecho de Palabra -->
                        <div class="space-y-6">
                            <div class="flex justify-end gap-2 items-center mt-4 pr-4">
                                <input wire:model.live="derecho_palabra" id="s1" type="checkbox" class="switch">
                                <label for="s1">Solicitar Derecho de Palabra</label>
                            </div>
                        </div>
                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row items-center pt-8 border-t border-gray-200 space-y-4 sm:space-y-0"
                        :class="{
                            'justify-between': @json($activeTab === 'create' && !$editingSolicitud),
                            'justify-end': @json(!($activeTab === 'create' && !$editingSolicitud))
                        }">
                            @if($activeTab === 'create' && !$editingSolicitud)
                                <button type="button" wire:click="resetForm" 
                                        class="w-full sm:w-auto px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                                    <i class='bx bx-refresh mr-2'></i>
                                    Reiniciar Formulario
                                </button>
                            @endif

                            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <button type="button" wire:click="setActiveTab('list')"
                                       class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                                    <i class='bx bx-arrow-back mr-2'></i>
                                    Cancelar
                                </button>
                                <button type="submit" 
                                        class="w-full sm:w-auto px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg">
                                    <i class='bx {{ $editingSolicitud ? 'bx-save' : 'bx-check' }} mr-2'></i>
                                    {{ $editingSolicitud ? 'Actualizar Solicitud' : 'Crear Solicitud' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- View -->
        @if($activeTab === 'view' && $selectedSolicitud)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class='bx bx-show text-blue-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Detalle de Solicitud</h3>
                                <p class="text-sm text-gray-600">ID: {{ $selectedSolicitud->solicitud_id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900 font-medium">{{ $selectedSolicitud->titulo }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estados</label>
                            <div class="p-3 bg-gray-50 rounded-lg space-x-2">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($selectedSolicitud->estado_detallado === 'Pendiente') bg-yellow-100 text-yellow-800
                                    @elseif($selectedSolicitud->estado_detallado === 'Aprobada') bg-green-100 text-green-800
                                    @elseif($selectedSolicitud->estado_detallado === 'Rechazada') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $selectedSolicitud->estado_detallado }}
                                </span>
                                @if($selectedSolicitud->derecho_palabra)
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-600/20 text-blue-800">
                                        Derecho de Palabra
                                    </span>
                                @endif
                                @if($selectedSolicitud->fecha_actualizacion_usuario)
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-600/20">
                                        Editado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900">{{ $categories[$selectedSolicitud->categoria]['title'] ?? 'Sin categoría' }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subcategoría</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900">{{ $categories[$selectedSolicitud->categoria]['subcategories'][$selectedSolicitud->subcategoria] ?? 'Sin subcategoría' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-900">{{ $selectedSolicitud->descripcion }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Parroquia</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900">{{ $selectedSolicitud->parroquia }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Comunidad</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900">{{ $selectedSolicitud->comunidad }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dirección Detallada</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-900">{{ $selectedSolicitud->direccion_detallada }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Creación</label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-gray-900">{{ $selectedSolicitud->fecha_creacion->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @if($selectedSolicitud->fecha_actualizacion_usuario)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Última Actualización</label>
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <p class="text-gray-900">{{ $selectedSolicitud->fecha_actualizacion_usuario->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="p-6 border-t border-gray-200">
                    <button wire:click="setCurrentTab('list')" 
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Volver a la Lista
                    </button>
                </div>
            </div>
        @endif

        
        <!-- Modal for viewing solicitud -->
        @if($activeTab === 'show' && $selectedSolicitud)
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
                            @else
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Sin observaciones</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.hook('element.updated', () => {
                initToggles();
                initInputs();
            });

            const initInputs = () => {
                const phoneInput = document.getElementById('telefono_solicitud');
                if (phoneInput) {
                    const newPhoneInput = phoneInput.cloneNode(true);
                    phoneInput.parentNode.replaceChild(newPhoneInput, phoneInput);
                    
                    newPhoneInput.addEventListener('input', (e) => {
                        let value = e.target.value.replace(/\D/g, '');
                        if (value.length > 3) {
                            value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7, 11);
                        }
                        e.target.value = value;
                    });
                }
            };

            initToggles();
            initInputs();
        });
    </script>
</div>