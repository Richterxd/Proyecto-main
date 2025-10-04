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
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
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
                    @if($currentTab !== 'create')
                        <button wire:click="setCurrentTab('create')" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                            <i class='bx bx-plus mr-2'></i>
                            Nueva Solicitud
                        </button>
                    @endif
                    @if($currentTab !== 'list' && count($solicitudes) > 0)
                        <button wire:click="setCurrentTab('list')" 
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Ver Solicitudes
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($currentTab === 'list')
            <!-- Solicitudes List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class='bx bx-show text-blue-600 mr-2'></i>
                            Mis Solicitudes
                        </h2>
                        <span class="text-sm text-gray-500">{{ count($solicitudes) }} solicitudes</span>
                    </div>
                    
                    @if(count($solicitudes) > 0)
                        <div class="space-y-4">
                            @foreach($solicitudes as $solicitud)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-all duration-200 bg-white">
                                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                                        <div class="flex-1 mb-4 lg:mb-0">
                                            <div class="flex items-start space-x-4">
                                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class='bx {{ $categories[$solicitud->categoria]['icon'] ?? 'bx-file-blank' }} text-blue-600 text-xl'></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex space-x-2 items-center mb-1">
                                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $solicitud->titulo }}</h3>
                                                        @if($solicitud->fecha_actualizacion_usuario)
                                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-600/20">
                                                                Editado
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <p class="text-gray-600 mb-3 line-clamp-2">{{ Str::limit($solicitud->descripcion, 150) }}</p>
                                                    <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                                        <span class="flex items-center">
                                                            <i class='bx bx-category mr-1'></i>
                                                            {{ $categories[$solicitud->categoria]['title'] ?? 'Sin categoría' }}
                                                        </span>
                                                        <span class="flex items-center">
                                                            <i class='bx bx-map-pin mr-1'></i>
                                                            {{ $solicitud->parroquia }}, {{ $solicitud->comunidad }}
                                                        </span>
                                                        <span class="flex items-center">
                                                            <i class='bx bx-calendar mr-1'></i>
                                                            {{ $solicitud->fecha_creacion->format('d/m/Y H:i') }}
                                                        </span>
                                                        @if($solicitud->solicitud_id)
                                                            <span class="flex items-center">
                                                                <i class='bx bx-id-card mr-1'></i>
                                                                ID: {{ $solicitud->solicitud_id }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                                @if($solicitud->estado_detallado === 'Pendiente') bg-yellow-100 text-yellow-800
                                                @elseif($solicitud->estado_detallado === 'Aprobada') bg-green-100 text-green-800
                                                @elseif($solicitud->estado_detallado === 'Rechazada') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $solicitud->estado_detallado }}
                                            </span>
                                            <div class="flex items-center space-x-2">
                                                <button wire:click="viewSolicitud({{ $solicitud->solicitud_id }})" 
                                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                        title="Ver detalles">
                                                    <i class='bx bx-show'></i>
                                                </button>
                                                @if($solicitud->estado_detallado === 'Pendiente')
                                                    <button wire:click="editSolicitud({{ $solicitud->solicitud_id }})" 
                                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                            title="Editar">
                                                        <i class='bx bx-edit'></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class='bx bx-file-blank text-4xl text-gray-400'></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No tienes solicitudes</h3>
                            <p class="text-gray-600 mb-6">Comienza creando tu primera solicitudaa</p>
                            <button wire:click="setCurrentTab('create')" 
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                <i class='bx bx-plus mr-2'></i>
                                Crear Primera Solicitud
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($currentTab === 'create')
            <!-- Create/Edit Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-8">
                    <!-- Form Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ $editingId ? 'Editar Solicitud' : 'Nueva Solicitud Completa' }}
                            </h2>
                            <div class="flex items-center space-x-2">
                                @if($editingId)
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
                        <p class="text-gray-600">Complete todos los campos requeridos para {{ $editingId ? 'actualizar' : 'crear' }} su solicitud</p>
                    </div>

                    <!-- Progress Steps -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                        <i class='bx bx-check'></i>
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-blue-600">Datos Personales</span>
                                </div>
                                <div class="w-8 h-1 bg-blue-600 rounded"></div>
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
                                <div class="w-8 h-1 {{ strlen($description) >= 50 ? 'bg-blue-600' : 'bg-gray-300' }} rounded"></div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 {{ strlen($description) >= 50 ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-bold">
                                        {{ strlen($description) >= 50 ? '✓' : '4' }}
                                    </div>
                                    <span class="ml-2 text-sm font-medium {{ strlen($description) >= 50 ? 'text-blue-600' : 'text-gray-500' }}">Descripción</span>
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
                                    <p class="text-sm text-gray-600">Información registrada en el sistema</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cédula de Identidad</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-id-card text-blue-600 mr-2'></i>
                                        <span class="font-medium text-gray-900">{{ $personalData['cedula'] ?? 'No registrado' }}</span>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-user text-blue-600 mr-2'></i>
                                        <span class="font-medium text-gray-900">{{ $personalData['nombre_completo'] ?? 'No registrado' }}</span>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-envelope text-blue-600 mr-2'></i>
                                        <span class="font-medium text-gray-900">{{ $personalData['email'] ?? 'No registrado' }}</span>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                    <div class="flex items-center">
                                        <i class='bx bx-phone text-blue-600 mr-2'></i>
                                        <span class="font-medium text-gray-900">{{ $personalData['telefono']    }}</span>
                                    </div>
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
                                            @foreach ($parroquias as $vale => $parroquia)
                                                <option value="{{$parroquia}}">{{$parroquia}}</option>
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
                                    
                                <textarea wire:model.live="description" rows="8" 
                                          class="w-full p-4 mt-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                          placeholder="Describa detalladamente su solicitud. Incluya información relevante como el problema específico"></textarea>
                                
                                <div class="flex justify-between items-center mt-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class='bx bx-info-circle mr-1'></i>
                                        <span>Caracteres: {{ strlen($description) }}/5000 (mínimo 50)</span>
                                    </div>
                                    <div class="flex items-center">
                                        @if($description)
                                            @if(strlen($description) >= 50 && strlen($description) <= 5000)
                                                <i class='bx bx-check-circle text-green-500 mr-1'></i>
                                                <span class="text-green-600 text-sm font-medium">Válida</span>
                                            @elseif(strlen($description) < 50)
                                                <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                <span class="text-red-600 text-sm font-medium">Muy corto</span>
                                            @else
                                                <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                                <span class="text-red-600 text-sm font-medium">Muy largo</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                                @error('description') 
                                    <div class="flex justify-end items-center text-red-600 text-sm mt-2">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Checkbox Derecho de Palabra -->
                        <div class="space-y-6">
                            <div class="flex justify-end gap-2 items-center mt-4 pr-4">
                                <input wire:model.live="derecho_palabra" id="s1" type="checkbox" class="switch">
                                <label for="s1">Solicitar Derecho de Palabra</label>
                            </div>
                        </div>
                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row justify-between items-center pt-8 border-t border-gray-200 space-y-4 sm:space-y-0">
                            <button type="button" wire:click="resetForm" 
                                    class="w-full sm:w-auto px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                                <i class='bx bx-refresh mr-2'></i>
                                Reiniciar Formulario
                            </button>

                            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <button type="button" wire:click="setCurrentTab('list')" 
                                       class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                                    <i class='bx bx-arrow-back mr-2'></i>
                                    Cancelar
                                </button>
                                <button type="submit" 
                                        class="w-full sm:w-auto px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg">
                                    <i class='bx {{ $editingId ? 'bx-save' : 'bx-check' }} mr-2'></i>
                                    {{ $editingId ? 'Actualizar Solicitud' : 'Crear Solicitud' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- View -->
        @if($currentTab === 'view' && $selectedSolicitud)
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
    </div>
</div>