<div class="p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Nueva Solicitud Completa</h1>
                <p class="mt-2 text-gray-600">Complete todos los campos para crear su solicitud municipal</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    <i class='bx bx-check-circle mr-1'></i>
                    Solicitud Unificada
                </div>
                <a href="{{ route('dashboard.usuario') }}" 
                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class='bx bx-arrow-back mr-1'></i>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        1
                    </div>
                    <span class="ml-2 text-sm font-medium text-blue-600">Datos Personales</span>
                </div>
                <div class="w-16 h-1 bg-blue-600 rounded"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium text-blue-600">Categoría</span>
                </div>
                <div class="w-16 h-1 bg-blue-600 rounded"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        3
                    </div>
                    <span class="ml-2 text-sm font-medium text-blue-600">Ubicación</span>
                </div>
                <div class="w-16 h-1 bg-blue-600 rounded"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        4
                    </div>
                    <span class="ml-2 text-sm font-medium text-blue-600">Descripción</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-green-600 text-xl mr-3'></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <i class='bx bx-x-circle text-red-600 text-xl mr-3'></i>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Form Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <form wire:submit.prevent="submit" class="p-8">
            <!-- Step 1: Personal Data Display -->
            <div class="mb-10">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class='bx bx-user text-blue-600 text-xl'></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Datos Personales</h2>
                        <p class="text-gray-600">Información registrada en el sistema</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cédula de Identidad</label>
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center">
                                    <i class='bx bx-id-card text-blue-600 mr-2'></i>
                                    <span class="font-medium text-blue-900">{{ $personalData['cedula'] ?? 'No registrado' }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre Completo</label>
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center">
                                    <i class='bx bx-user text-blue-600 mr-2'></i>
                                    <span class="font-medium text-blue-900">{{ $personalData['nombre_completo'] ?? 'No registrado' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center">
                                    <i class='bx bx-envelope text-blue-600 mr-2'></i>
                                    <span class="font-medium text-blue-900">{{ $personalData['email'] ?? 'No registrado' }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono de Contacto</label>
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center">
                                    <i class='bx bx-phone text-blue-600 mr-2'></i>
                                    <span class="font-medium text-blue-900">{{ $personalData['telefono'] ?? 'No registrado' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Category Selection -->
            <div class="mb-10">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class='bx bx-category text-blue-600 text-xl'></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Categoría de Solicitud</h2>
                        <p class="text-gray-600">Seleccione el tipo de solicitud que desea realizar</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    @foreach ($categories as $key => $category)
                        <div class="border-2 rounded-xl p-6 cursor-pointer transition-all duration-300 hover:shadow-md
                            {{ $selectedCategory === $key ? 'border-blue-500 bg-blue-50 shadow-lg' : 'border-gray-200 hover:border-blue-300' }}"
                            wire:click="$set('selectedCategory', '{{ $key }}')">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
                                    <i class='bx {{ $key === 'servicios' ? 'bx-wrench' : ($key === 'social' ? 'bx-group' : 'bx-cloud-lightning') }} text-3xl text-blue-600'></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $category['title'] }}</h3>
                                <p class="text-sm text-gray-600">{{ count($category['subcategories']) }} subcategorías disponibles</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('selectedCategory') 
                    <div class="flex items-center text-red-600 text-sm mt-2">
                        <i class='bx bx-error-circle mr-1'></i>
                        {{ $message }}
                    </div>
                @enderror

                <!-- Subcategory Selection -->
                @if ($selectedCategory)
                    <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            Subcategorías de {{ $categories[$selectedCategory]['title'] }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($categories[$selectedCategory]['subcategories'] as $key => $subcategory)
                                <div class="border-2 rounded-lg p-4 cursor-pointer transition-all duration-300
                                    {{ $selectedSubcategory === $key ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300' }}"
                                    wire:click="$set('selectedSubcategory', '{{ $key }}')">
                                    <div class="text-center">
                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <i class='bx bx-check text-white text-sm'></i>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $subcategory }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('selectedSubcategory') 
                            <div class="flex items-center text-red-600 text-sm mt-2">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endif
            </div>

            <!-- Step 3: Location Details -->
            <div class="mb-10">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class='bx bx-map text-blue-600 text-xl'></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Ubicación de la Solicitud</h2>
                        <p class="text-gray-600">Proporcione los detalles de ubicación donde se requiere el servicio</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">País</label>
                            <div class="p-3 bg-white border border-gray-300 rounded-lg">
                                <div class="flex items-center">
                                    <i class='bx bx-world text-gray-500 mr-2'></i>
                                    <span class="text-gray-900">{{ $detailedAddress['pais'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Estado</label>
                            <div class="p-3 bg-white border border-gray-300 rounded-lg">
                                <div class="flex items-center">
                                    <i class='bx bx-map-pin text-gray-500 mr-2'></i>
                                    <span class="text-gray-900">{{ $detailedAddress['estado_region'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Municipio</label>
                            <div class="p-3 bg-white border border-gray-300 rounded-lg">
                                <div class="flex items-center">
                                    <i class='bx bx-buildings text-gray-500 mr-2'></i>
                                    <span class="text-gray-900">{{ $detailedAddress['municipio'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Parroquia *</label>
                            <input type="text" wire:model="detailedAddress.parroquia" 
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Ejemplo: Chivacoa">
                            @error('detailedAddress.parroquia') 
                                <div class="flex items-center text-red-600 text-sm mt-1">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Comunidad *</label>
                        <input type="text" wire:model="detailedAddress.comunidad" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="Ejemplo: Sector Los Pinos">
                        @error('detailedAddress.comunidad') 
                            <div class="flex items-center text-red-600 text-sm mt-1">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dirección Detallada *</label>
                        <textarea wire:model="detailedAddress.direccion_detallada" rows="4" 
                                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                  placeholder="Proporcione la dirección completa incluyendo puntos de referencia importantes..."></textarea>
                        @error('detailedAddress.direccion_detallada') 
                            <div class="flex items-center text-red-600 text-sm mt-1">
                                <i class='bx bx-error-circle mr-1'></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Step 4: Description -->
            <div class="mb-10">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class='bx bx-edit text-blue-600 text-xl'></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Descripción de la Solicitud</h2>
                        <p class="text-gray-600">Describa detalladamente su solicitud (mínimo 50 caracteres)</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6">
                    <textarea wire:model="description" rows="8" 
                              class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                              placeholder="Describa detalladamente su solicitud. Incluya información relevante como el problema específico, la urgencia, el impacto en la comunidad, etc..."></textarea>
                    
                    <div class="flex justify-between items-center mt-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class='bx bx-info-circle mr-1'></i>
                            <span>Caracteres: {{ strlen($description) }}/5000 (mínimo 50)</span>
                        </div>
                        <div class="flex items-center">
                            @if(strlen($description) >= 50)
                                <i class='bx bx-check-circle text-green-500 mr-1'></i>
                                <span class="text-green-600 text-sm font-medium">Descripción válida</span>
                            @else
                                <i class='bx bx-error-circle text-red-500 mr-1'></i>
                                <span class="text-red-600 text-sm font-medium">Descripción muy corta</span>
                            @endif
                        </div>
                    </div>
                    
                    @error('description') 
                        <div class="flex items-center text-red-600 text-sm mt-2">
                            <i class='bx bx-error-circle mr-1'></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-between items-center pt-8 border-t border-gray-200">
                <button type="button" wire:click="resetForm" 
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    <i class='bx bx-refresh mr-2'></i>
                    Reiniciar Formulario
                </button>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard.usuario') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        <i class='bx bx-arrow-back mr-2'></i>
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg">
                        <i class='bx bx-check mr-2'></i>
                        Crear Solicitud
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>