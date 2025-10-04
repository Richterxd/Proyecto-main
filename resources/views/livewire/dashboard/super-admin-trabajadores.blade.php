<div class="min-h-screen bg-gray-50">

    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center py-6">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class="bx bx-book-content text-xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Gestión de Trabajadores</h1>
                            <p class="text-sm text-gray-600">Sistema Municipal CMBEY</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col-reverse sm:flex-row items-center gap-3">
                    <button wire:click="changeTab"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        <i class='bx bx-plus mr-2'></i>
                        Nuevo trabajador
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    @if ($currentStep==='list')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center mb-4 sm:mb-0">
                    <i class='bx bx-list-ul text-blue-600 mr-2'></i>
                    Lista de Empleados
                </h2>
                <div
                    class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                    <div class="relative w-full sm:w-auto">
                        <input type="text" placeholder="Buscar empleado..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                        <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                    </div>
                    <span class="text-sm text-gray-500">15 empleados</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                <div class="flex items-center">
                                    <i class='bx bx-user-circle mr-2'></i>
                                    Nombre
                                </div>
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                <div class="flex items-center">
                                    <i class='bx bx-id-card mr-2'></i>
                                    Cédula
                                </div>
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                <div class="flex items-center">
                                    <i class='bx bx-calendar mr-2'></i>
                                    Fecha Nacimiento
                                </div>
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                <div class="flex items-center">
                                    <i class='bx bx-briefcase mr-2'></i>
                                    Área de Trabajo
                                </div>
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                <div class="flex items-center">
                                    <i class='bx bx-cake mr-2'></i>
                                    Día para su cumpleaños
                                </div>
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:px-6">
                                <div class="flex items-center">
                                    <i class='bx bx-cog mr-2'></i>
                                    Acciones
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">


                    </tbody>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-4 sm:space-y-0">
                <div class="text-sm text-gray-700">
                    Mostrando <span class="font-medium"></span> a <span class="font-medium"></span> de <span
                        class="font-medium"></span> resultados
                </div>
                <div class="flex items-center space-x-2">
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Anterior</button>
                    <button class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm font-medium">1</button>
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">2</button>
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">3</button>
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($currentStep==='create')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-8">
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">
                            Nuevo Trabajador
                        </h2>
                        <div class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            <i class='bx bx-plus mr-1'></i>
                            Creando
                        </div>
                    </div>
                    <p class="text-gray-600">Complete los campos para registrar un nuevo trabajador.</p>
                </div>

                <form wire:submit.prevent="submitForm" class="space-y-6">

                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class='bx bx-user text-blue-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Información Personal</h3>
                                <p class="text-sm text-gray-600">Datos básicos del trabajador</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {{-- Campo Nombre --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                                <input type="text" id="name" name="name" placeholder="Ejemplo 'Juan' "
                                    wire:model='nombre' required
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>

                            {{-- Campo Apellido --}}
                            <div>
                                <label for="apellido"
                                    class="block text-sm font-medium text-gray-700 mb-2">Apellido</label>
                                <input type="text" id="apellido" name="apellido" placeholder="Ejemplo 'Perez' "
                                    wire:model='apellido'
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>

                            {{-- Campo Cédula --}}
                            <div>
                                <label for="cedula" class="block text-sm font-medium text-gray-700 mb-2">Cédula
                                    *</label>
                                <input type="text" id="cedula" name="cedula" placeholder="Ej: V-12345678"
                                    wire:model="cedula" required
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>

                            {{-- Campo Fecha de Nacimiento --}}
                            <div>
                                <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-2">Fecha de
                                    Nacimiento *</label>
                                <input type="date" id="birthdate" name="birthdate" required
                                    wire:model='fecha_nacimiento'
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>

                            {{-- Campo Teléfono --}}
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                <input type="tel" id="phone" name="phone" placeholder="Ej: 0412-1234567"
                                    wire:model='telefono'
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class='bx bx-briefcase text-blue-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Información Laboral</h3>
                                <p class="text-sm text-gray-600">Detalles del puesto de trabajo</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Campo Área de Trabajo --}}
                            <div>
                                <label for="job_area" class="block text-sm font-medium text-gray-700 mb-2">Área de
                                    Trabajo *</label>
                                <select id="job_area" name="job_area" required wire:model='area'
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">Seleccione un área</option>
                                    @foreach ($workAreas as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Campo Cargo --}}
                            <div>
                                <label for="job_position"
                                    class="block text-sm font-medium text-gray-700 mb-2">Cargo</label>
                                <input type="text" id="job_position" name="job_position"
                                    placeholder="Ej: Analista de Sistemas" wire:model='cargo'
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex flex-col justify-between sm:flex-row items-center pt-6 border-t border-gray-200 space-y-4 sm:space-y-0 sm:space-x-4">
                        {{-- Botón Atrás --}}
                        <button type="button" wire:click='changeTab'
                            class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            <i class='bx bx-arrow-back mr-2'></i>
                            Atrás
                        </button>
                        <div>
                            {{-- Botón Reiniciar Formulario --}}
                            <button type="button" wire:click='resetForm'
                                class="w-full sm:w-auto px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                                <i class='bx bx-refresh mr-2'></i>
                                Reiniciar Formulario
                            </button>
                            {{-- Botón Crear Trabajador --}}
                            <button type="submit"
                                class="w-full sm:w-auto px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg">
                                <i class='bx bx-check mr-2'></i>
                                Crear Trabajador
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif


</div>