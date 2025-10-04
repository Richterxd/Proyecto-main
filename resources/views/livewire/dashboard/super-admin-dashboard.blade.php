<div class="min-h-screen">
    <!-- Dashboard Content -->
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Panel de SuperAdministrador
            </h1>
            <p class="mt-2 text-gray-600">Bienvenido, {{ auth()->user()->persona->nombre }} - Control Total del Sistema
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center">
                    <i class='bx bx-file-blank text-3xl mr-4 text-gray-400'></i>
                    <div>
                        <h3 class="text-2xl font-bold">{{ $solicitudes->count() }}</h3>
                        <p class="text-blue-100">Total Solicitudes</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center">
                    <i class='bx bx-check-circle text-3xl mr-4 text-green-400'></i>
                    <div>
                        <h3 class="text-2xl font-bold">{{ $solicitudes->where('estado_detallado', 'Aprobada')->count()
                            }}</h3>
                        <p class="text-blue-100">Aprobadas</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-700 to-blue-800 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center">
                    <i class='bx bx-time-five text-3xl mr-4 text-orange-500'></i>
                    <div>
                        <h3 class="text-2xl font-bold">{{ $solicitudes->where('estado_detallado', 'Pendiente')->count()
                            }}</h3>
                        <p class="text-blue-100 ">Pendientes</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-800 to-blue-900 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center">
                    <i class='bx bx-calendar-check text-3xl mr-4 text-teal-300'></i>
                    <div>
                        <h3 class="text-2xl font-bold">{{ $visitas->count() }}</h3>
                        <p class="text-blue-100">Visitas en curso</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-900 to-blue-950 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center">
                    <i class='bx bx-user text-3xl mr-4 text-neutral-400'></i>
                    <div>
                        <h3 class="text-2xl font-bold">{{ $usuarios->count() }}</h3>
                        <p class="text-blue-100">Total Usuarios</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Management Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <button wire:click="setActiveTab('usuarios')"
                class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-blue-500">
                <div class="text-center">
                    <i class='bx bx-group text-4xl text-blue-600 mb-3'></i>
                    <h3 class="font-bold text-gray-900">Gestión de Usuarios</h3>
                    <p class="text-sm text-gray-600 mt-1">Administrar usuarios y roles</p>
                </div>
            </button>

            <button wire:click="setActiveTab('solicitudes')"
                class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-blue-500">
                <div class="text-center">
                    <i class='bx bx-file-blank text-blue-600 text-3xl mr-4'></i>
                    <h3 class="font-bold text-gray-900">Solicitudes Globales</h3>
                    <p class="text-sm text-gray-600 mt-1">Control total de solicitudes</p>
                </div>
            </button>

            <button wire:click="setActiveTab('reportes')"
                class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-blue-500">
                <div class="text-center">
                    <i class='bx bx-bar-chart-alt-2 text-4xl text-blue-600 mb-3'></i>
                    <h3 class="font-bold text-gray-900">Reportes Avanzados</h3>
                    <p class="text-sm text-gray-600 mt-1">Analíticas y estadísticas</p>
                </div>
            </button>

            <button wire:click="setActiveTab('configuracion')"
                class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-blue-500">
                <div class="text-center">
                    <i class='bx bx-shield text-4xl text-blue-600 mb-3'></i>
                    <h3 class="font-bold text-gray-900">Configuración</h3>
                    <p class="text-sm text-gray-600 mt-1">Configuración de la cuenta</p>
                </div>
            </button>
        </div>

        <!-- System Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Users -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-user-plus text-blue-600 mr-2'></i>
                    Usuarios Recientes
                </h2>
                <div class="space-y-4">
                    @foreach($usuarios->take(5) as $usuario)
                    <div
                        class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class='bx bx-user text-blue-600 text-sm'></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900 text-sm">{{ $usuario->persona->nombre ?? 'N/A' }}
                                    {{ $usuario->persona->apellido ?? '' }}</h3>
                                <p class="text-xs text-gray-600">{{ $usuario->getRoleName() }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $usuario->role === 1 ? 'Super' : ($usuario->role === 2 ? 'Admin' : 'User') }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Solicitudes -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-black-400 mb-4 flex items-center">
                    <i class='bx bxs-cake mr-2 text-blue-600'></i>
                     Proximo Cumpleañero
                </h2>
                <div class="space-y-4">
                    @foreach($solicitudes->where('estado_detallado', 'Pendiente')->take(5) as $solicitud)
                    <div
                        class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class='bx bx-file-blank text-blue-600 text-sm'></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900 text-sm">{{ Str::limit($solicitud->titulo, 25) }}
                                </h3>
                                <p class="text-xs text-gray-600">{{ $solicitud->persona->nombre ?? 'Usuario' }}</p>
                                @if($solicitud->solicitud_id)
                                <p class="text-xs text-blue-600">ID: {{ $solicitud->solicitud_id }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $solicitud->estado_detallado }}
                            </span>
                            @if($solicitud->categoria)
                            <p class="text-xs text-gray-500 mt-1">{{ $solicitud->categoria_formatted }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- System Stats -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-stats text-blue-600 mr-2'></i>
                    Estadísticas del Sistema
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                        <span class="text-sm font-medium text-blue-800">SuperAdministradores</span>
                        <span class="text-lg font-bold text-blue-600">{{ $usuarios->where('role', 1)->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                        <span class="text-sm font-medium text-blue-800">Administradores</span>
                        <span class="text-lg font-bold text-blue-600">{{ $usuarios->where('role', 2)->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                        <span class="text-sm font-medium text-blue-800">Usuarios</span>
                        <span class="text-lg font-bold text-blue-600">{{ $usuarios->where('role', 3)->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                        <span class="text-sm font-medium text-blue-800">Ámbitos</span>
                        <span class="text-lg font-bold text-blue-600">{{ $ambitos->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Content -->
        @if($activeTab === 'solicitudes')
        <div class="mt-8 bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class='bx bx-cog text-blue-600 mr-3'></i>
                Gestión Global de Solicitudes
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">ID
                            </th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Título</th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Usuario</th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Categoría</th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Tipo</th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Estado</th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Visitador</th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $solicitud)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                {{ $solicitud->solicitud_id ?? 'ID-' . $solicitud->id }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                {{ Str::limit($solicitud->titulo, 30) }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                {{ $solicitud->persona->nombre ?? 'N/A' }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                {{ $solicitud->categoria_formatted ?? 'N/A' }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $solicitud->tipo_solicitud === 'individual' ? 'Individual' : 'Colectivo' }}
                                </span>
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                <select wire:change="updateSolicitudStatus({{ $solicitud->id }}, $event.target.value)"
                                    class="text-xs border border-gray-300 rounded px-2 py-1 bg-white">
                                    <option value="Pendiente" {{ $solicitud->estado_detallado === 'Pendiente' ?
                                        'selected' : '' }}>Pendiente</option>
                                    <option value="Aprobada" {{ $solicitud->estado_detallado === 'Aprobada' ? 'selected'
                                        : '' }}>Aprobada</option>
                                    <option value="Rechazada" {{ $solicitud->estado_detallado === 'Rechazada' ?
                                        'selected' : '' }}>Rechazada</option>
                                    <option value="Asignada" {{ $solicitud->estado_detallado === 'Asignada' ? 'selected'
                                        : '' }}>Asignada</option>
                                </select>
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                <select wire:change="assignVisitor({{ $solicitud->id }}, $event.target.value)"
                                    class="text-xs border border-gray-300 rounded px-2 py-1 bg-white">
                                    <option value="">Sin asignar</option>
                                    @foreach($usuarios->where('role', '!=', 3) as $usuario)
                                    <option value="{{ $usuario->personas_cedula }}" {{ $solicitud->visitador_asignado ==
                                        $usuario->personas_cedula ? 'selected' : '' }}>
                                        {{ $usuario->persona->nombre ?? 'N/A' }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                <div class="flex space-x-2">
                                    <button wire:click="viewSolicitud({{ $solicitud->id }})"
                                        class="text-blue-600 hover:text-blue-800 p-1 rounded">
                                        <i class='bx bx-show'></i>
                                    </button>
                                    <button wire:click="editSolicitudObservations({{ $solicitud->id }})"
                                        class="text-blue-600 hover:text-blue-800 p-1 rounded">
                                        <i class='bx bx-edit'></i>
                                    </button>
                                    <button wire:click="deleteSolicitud({{ $solicitud->id }})"
                                        class="text-red-600 hover:text-red-800 p-1 rounded"
                                        onclick="return confirm('¿Está seguro de eliminar esta solicitud?')">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($activeTab === 'usuarios')
        <div class="mt-8 bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class='bx bx-group text-blue-600 mr-3'></i>
                Gestión de Usuarios
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Cédula</th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Nombre</th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Email</th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Teléfono</th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">Rol
                            </th>
                            <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                {{ $usuario->personas_cedula }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                {{ $usuario->persona->nombre ?? 'N/A' }} {{ $usuario->persona->apellido ?? '' }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                {{ $usuario->persona->email ?? 'N/A' }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                {{ $usuario->persona->telefono ?? 'N/A' }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                <select
                                    wire:change="changeUserRole({{ $usuario->personas_cedula }}, $event.target.value)"
                                    class="text-xs border border-gray-300 rounded px-2 py-1 bg-white">
                                    <option value="1" {{ $usuario->role === 1 ? 'selected' : '' }}>SuperAdministrador
                                    </option>
                                    <option value="2" {{ $usuario->role === 2 ? 'selected' : '' }}>Administrador
                                    </option>
                                    <option value="3" {{ $usuario->role === 3 ? 'selected' : '' }}>Usuario</option>
                                </select>
                            </td>
                            <td class="border border-gray-200 px-4 py-2 text-sm">
                                <div class="flex space-x-2">
                                    @if($usuario->personas_cedula !== auth()->user()->personas_cedula)
                                    <button wire:click="deleteUser({{ $usuario->personas_cedula }})"
                                        class="text-red-600 hover:text-red-800 p-1 rounded"
                                        onclick="return confirm('¿Está seguro de eliminar este usuario?')">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($activeTab === 'reportes')
        <div class="mt-8 bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class='bx bx-bar-chart-alt-2 text-blue-600 mr-3'></i>
                Reportes Avanzados
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-blue-50 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Solicitudes por Categoría</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Servicios:</span>
                            <span class="text-sm font-medium text-blue-600">{{ $solicitudes->where('categoria',
                                'servicios')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Social:</span>
                            <span class="text-sm font-medium text-blue-600">{{ $solicitudes->where('categoria',
                                'social')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Sucesos Naturales:</span>
                            <span class="text-sm font-medium text-blue-600">{{ $solicitudes->where('categoria',
                                'sucesos_naturales')->count() }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Usuarios por Rol</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">SuperAdministradores:</span>
                            <span class="text-sm font-medium text-blue-600">{{ $usuarios->where('role', 1)->count()
                                }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Administradores:</span>
                            <span class="text-sm font-medium text-blue-600">{{ $usuarios->where('role', 2)->count()
                                }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Usuarios:</span>
                            <span class="text-sm font-medium text-blue-600">{{ $usuarios->where('role', 3)->count()
                                }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Actividad Reciente</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Solicitudes Hoy:</span>
                            <span class="text-sm font-medium text-blue-600">{{ $solicitudes->where('fecha_creacion', '>=',
                                today())->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Solicitudes Esta Semana:</span>
                            <span class="text-sm font-medium text-blue-600">{{ $solicitudes->where('fecha_creacion', '>=',
                                now()->startOfWeek())->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Solicitudes Este Mes:</span>
                            <span class="text-sm font-medium text-blue-600">{{ $solicitudes->where('fecha_creacion', '>=',
                                now()->startOfMonth())->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($activeTab === 'configuracion')
        <div class="mt-8 bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class='bx bx-shield text-blue-600 mr-3'></i>
                Configuración del Sistema
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-blue-50 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Configuración General</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Sistema</label>
                            <input type="text" value="Sistema Municipal CMBEY"
                                class="w-full p-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email de Contacto</label>
                            <input type="email" value="admin@cmbey.gob.ve"
                                class="w-full p-2 border border-gray-300 rounded-lg">
                        </div>
                        <button
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Guardar Configuración
                        </button>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Estadísticas del Sistema</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Versión:</span>
                            <span class="text-sm font-medium text-blue-600">1.0.0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Última Actualización:</span>
                            <span class="text-sm font-medium text-blue-600">{{ now()->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Base de Datos:</span>
                            <span class="text-sm font-medium text-green-600">Conectada</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>