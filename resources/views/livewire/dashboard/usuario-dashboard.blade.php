<div class="min-h-screen">
    <!-- Dashboard Content -->
    @if($activeTab === 'dashboard')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                ¡Bienvenido, {{ auth()->user()->persona->nombre }}!
            </h1>
            <p class="mt-2 text-gray-600">Panel de Usuario - Sistema Municipal CMBEY</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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
                        <h3 class="text-2xl font-bold">{{ $solicitudes->where('estado_detallado', 'Aprobada')->count() }}</h3>
                        <p class="text-blue-100">Aprobadas</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-700 to-blue-800 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center">
                    <i class='bx bx-time-five text-3xl mr-4 text-orange-500'></i>
                    <div>
                        <h3 class="text-2xl font-bold">{{ $solicitudes->where('estado_detallado', 'Pendiente')->count() }}</h3>
                        <p class="text-blue-100">Pendientes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel de Anuncios -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class='bx bx-megaphone text-blue-600 mr-2'></i>
                Anuncios y Noticias
            </h2>

            <div class="relative">
                <div id="carousel-container" class="relative h-64 overflow-hidden rounded-lg shadow-lg">
                    <!-- Slide 1 - Ciudad -->
                    <div class="carousel-slide active absolute inset-0 transition-opacity duration-1000">
                        <img src="{{ asset('img/1.jpg') }}" alt="Plaza Bolívar" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="text-lg font-bold mb-2">Plaza Bolívar de Chivacoa</h3>
                            <p class="text-sm opacity-90">Disfruta de nuestros espacios públicos renovados</p>
                        </div>
                    </div>

                    <!-- Slide 2 - Anuncio -->
                    <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0">
                        <div
                            class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                            <div class="text-center text-white p-8">
                                <i class='bx bx-calendar-event text-6xl mb-4'></i>
                                <h3 class="text-2xl font-bold mb-2">Nuevos Horarios de Atención</h3>
                                <p class="text-lg opacity-90">Lunes a Viernes: 8:00 AM - 4:00 PM</p>
                                <p class="text-sm opacity-75 mt-2">Efectivo desde el 15 de Marzo</p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 - Consejo -->
                    <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0">
                        <img src="{{ asset('img/3.jpg') }}" alt="Consejo Municipal" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="text-lg font-bold mb-2">Consejo Municipal de Bruzual</h3>
                            <p class="text-sm opacity-90">Trabajando por el desarrollo de nuestra comunidad</p>
                        </div>
                    </div>

                    <!-- Slide 4 - Anuncio de Servicios -->
                    <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0">
                        <div
                            class="w-full h-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center">
                            <div class="text-center text-white p-8">
                                <i class='bx bx-cog text-6xl mb-4'></i>
                                <h3 class="text-2xl font-bold mb-2">Nuevos Servicios Digitales</h3>
                                <p class="text-lg opacity-90">Gestiona tus solicitudes desde casa</p>
                                <p class="text-sm opacity-75 mt-2">Sistema disponible 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Indicators -->
                <div class="flex justify-center mt-4 space-x-2">
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-blue-600 active" data-slide="0"></button>
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-gray-300" data-slide="1"></button>
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-gray-300" data-slide="2"></button>
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-gray-300" data-slide="3"></button>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <a href="{{ route('dashboard.usuario.solicitud.crear', ['tab' => 'crear']) }}"
                class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-blue-500 block">
                <div class="text-center">
                    <i class='bx bx-plus-circle text-4xl text-blue-600 mb-3'></i>
                    <h3 class="font-bold text-gray-900">Nueva Solicitud</h3>
                    <p class="text-sm text-gray-600 mt-1">Crear solicitud completa</p>
                </div>
            </a>


            <a href="{{ route('dashboard.usuario.solicitud') }}"
                class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-blue-500 block">
                <div class="text-center">
                    <i class='bx bx-plus-circle text-4xl text-blue-600 mb-3'></i>
                    <h3 class="font-bold text-gray-900">Gestionar Solicitudes</h3>
                    <p class="text-sm text-gray-600 mt-1">Administracion de solicitudes</p>
                </div>
            </a>

            <button wire:click="setActiveTab('visitas')"
                class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-blue-500">
                <div class="text-center">
                    <i class='bx bx-calendar-check text-4xl text-blue-600 mb-3'></i>
                    <h3 class="font-bold text-gray-900">Mis Visitas</h3>
                    <p class="text-sm text-gray-600 mt-1">Programadas y realizadas</p>
                </div>
            </button>

            <button wire:click="setActiveTab('perfil')"
                class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-blue-500">
                <div class="text-center">
                    <i class='bx bx-user text-4xl text-blue-600 mb-3'></i>
                    <h3 class="font-bold text-gray-900">Mi Perfil</h3>
                    <p class="text-sm text-gray-600 mt-1">Actualizar información</p>
                </div>
            </button>
        </div>

        <!-- Recent Solicitudes -->
        @if($solicitudes->count() > 0)
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class='bx bx-history text-blue-600 mr-2'></i>
                Solicitudes Recientes
            </h2>
            <div class="space-y-4">
                @foreach($solicitudes->take(3) as $solicitud)
                <div
                    class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                            <i class='bx bx-file-blank text-blue-600'></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $solicitud->titulo }}</h3>
                            <p class="text-sm text-gray-600">{{ $solicitud->ambito->titulo ?? 'Sin ámbito' }}</p>
                            <p class="text-xs text-gray-500">{{ $solicitud->fecha_creacion->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($solicitud->estado_detallado === 'Pendiente') bg-yellow-100 text-yellow-800
                                    @elseif($solicitud->estado_detallado === 'Aprobada') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                        {{ $solicitud->estado_detallado }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Visualizar Solicitudes Tab -->
    @if($activeTab === 'visualizar')
    <div class="p-6">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class='bx bx-show text-blue-600 mr-3'></i>
                Mis Solicitudes
            </h2>

            @if($solicitudes->count() > 0)
            <div class="space-y-4">
                @foreach($solicitudes as $solicitud)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $solicitud->titulo }}</h3>
                            <p class="text-gray-600 mb-3">{{ Str::limit($solicitud->descripcion, 150) }}</p>
                            <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                <span><i class='bx bx-category mr-1'></i>{{ $solicitud->ambito->titulo ?? 'Sin ámbito'
                                    }}</span>
                                <span><i class='bx bx-map mr-1'></i>{{ Str::limit($solicitud->direccion, 30) }}</span>
                                <span><i class='bx bx-calendar mr-1'></i>{{ $solicitud->fecha_creacion->format('d/m/Y H:i')
                                    }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                            @if($solicitud->estado_detallado === 'Pendiente') bg-yellow-100 text-yellow-800
                                            @elseif($solicitud->estado_detallado === 'Aprobada') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                {{ $solicitud->estado_detallado }}
                            </span>
                            <div class="flex space-x-2">
                                <button wire:click="viewSolicitud({{ $solicitud->solicitud_id }})"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class='bx bx-show'></i>
                                </button>
                                @if($solicitud->estado_detallado === 'Pendiente')
                                <button wire:click="editSolicitud({{ $solicitud->solicitud_id }})"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button wire:click="deleteSolicitud({{ $solicitud->solicitud_id }})"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    onclick="return confirm('¿Estás seguro de eliminar esta solicitud?')">
                                    <i class='bx bx-trash'></i>
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
                <i class='bx bx-file-blank text-6xl text-gray-400 mb-4'></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No tienes solicitudes</h3>
                <p class="text-gray-600 mb-4">Comienza creando tu primera solicitud</p>
                <a href="{{ route('dashboard.usuario.solicitud.crear') }}"
                    class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Crear Solicitud
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Editar Solicitud Tab -->
    @if($activeTab === 'editar' && $editingSolicitud)
    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class='bx bx-edit text-blue-600 mr-3'></i>
                    Editar Solicitud
                </h2>

                <form wire:submit.prevent="updateSolicitud" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Título de la Solicitud</label>
                            <input type="text" wire:model="solicitudForm.titulo"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            @error('solicitudForm.titulo') <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ámbito</label>
                            <select wire:model="solicitudForm.ambito_id"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Seleccionar ámbito</option>
                                @foreach($ambitos as $ambito)
                                <option value="{{ $ambito->id }}">{{ $ambito->titulo }}</option>
                                @endforeach
                            </select>
                            @error('solicitudForm.ambito_id') <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción Detallada</label>
                        <textarea wire:model="solicitudForm.descripcion" rows="4"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"></textarea>
                        @error('solicitudForm.descripcion') <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                            <input type="text" wire:model="solicitudForm.direccion"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            @error('solicitudForm.direccion') <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono de Contacto</label>
                            <input type="tel" wire:model="solicitudForm.telefono_contacto"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            @error('solicitudForm.telefono_contacto') <span class="text-red-500 text-sm">{{ $message
                                }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="button" wire:click="setActiveTab('visualizar')"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                            Actualizar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Visitas Tab -->
    @if($activeTab === 'visitas')
    <div class="p-6">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class='bx bx-calendar-check text-blue-600 mr-3'></i>
                Mis Visitas
            </h2>

            @if($visitas->count() > 0)
            <div class="space-y-4">
                @foreach($visitas as $visita)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $visita->titulo ?? 'Visita
                                Municipal' }}</h3>
                            <p class="text-gray-600 mb-3">{{ $visita->descripcion ?? 'Sin descripción' }}</p>
                            <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                <span><i class='bx bx-calendar mr-1'></i>{{
                                    \Carbon\Carbon::parse($visita->fecha)->format('d/m/Y H:i') }}</span>
                                <span><i class='bx bx-category mr-1'></i>{{ $visita->ambito->titulo ?? 'Sin ámbito'
                                    }}</span>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                        @if($visita->estado === 'Programada') bg-blue-100 text-blue-800
                                        @elseif($visita->estado === 'Realizada') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                            {{ $visita->estado }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <i class='bx bx-calendar-x text-6xl text-gray-400 mb-4'></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay visitas programadas</h3>
                <p class="text-gray-600">Las visitas aparecerán aquí cuando sean programadas por el administrador</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Perfil Tab -->
    @if($activeTab === 'perfil')
    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Información Personal -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class='bx bx-user text-blue-600 mr-3'></i>
                        Información Personal
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                            <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                {{ auth()->user()->persona->nombre }} {{ auth()->user()->persona->apellido }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cédula</label>
                            <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                {{ auth()->user()->personas_cedula }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                {{ auth()->user()->persona->email ?? 'No registrado' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                {{ auth()->user()->persona->telefono ?? 'No registrado' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                            <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg text-blue-800 font-medium">
                                {{ auth()->user()->getRoleName() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cambiar Contraseña -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class='bx bx-lock text-blue-600 mr-3'></i>
                        Cambiar Contraseña
                    </h2>

                    <form wire:submit.prevent="updatePassword" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual</label>
                            <input type="password" wire:model="profileForm.current_password"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            @error('profileForm.current_password') <span class="text-red-500 text-sm">{{ $message
                                }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                            <input type="password" wire:model="profileForm.new_password"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            @error('profileForm.new_password') <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Mínimo 8 caracteres, una mayúscula y un carácter
                                especial</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nueva
                                Contraseña</label>
                            <input type="password" wire:model="profileForm.new_password_confirmation"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            @error('profileForm.new_password_confirmation') <span class="text-red-500 text-sm">{{
                                $message }}</span> @enderror
                        </div>

                        <button type="submit"
                            class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                            Actualizar Contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- CRUD Tab -->
    @if($activeTab === 'crud')
    <div class="p-6">
        <livewire:dashboard.solicitud-crud />
    </div>
    @endif

    <!-- Modal para Ver Solicitud -->
    @if($viewingSolicitud)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <h3 class="text-xl font-bold text-gray-900">Detalle de Solicitud</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <p class="text-gray-900 font-medium">{{ $viewingSolicitud->titulo }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ámbito</label>
                    <p class="text-gray-900">{{ $viewingSolicitud->ambito->titulo ?? 'Sin ámbito' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <p class="text-gray-900">{{ $viewingSolicitud->descripcion }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <p class="text-gray-900">{{ $viewingSolicitud->direccion }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <p class="text-gray-900">{{ $viewingSolicitud->telefono_contacto }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($viewingSolicitud->estado_detallado === 'Pendiente') bg-yellow-100 text-yellow-800
                                @elseif($viewingSolicitud->estado_detallado === 'Aprobada') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                            {{ $viewingSolicitud->estado_detallado }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Creación</label>
                        <p class="text-gray-900">{{ $viewingSolicitud->fecha_creacion->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200">
                <button wire:click="closeModal"
                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Carousel JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Solo ejecutar si el carousel existe (solo para usuarios)
    const carouselContainer = document.getElementById('carousel-container');
    if (!carouselContainer) return;
    
    const slides = document.querySelectorAll('.carousel-slide');
    const indicators = document.querySelectorAll('.carousel-indicator');
    let currentSlide = 0;
    let carouselInterval;

    function showSlide(index) {
        // Remove active class from all slides and indicators
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(indicator => indicator.classList.remove('active'));
        
        // Add active class to current slide and indicator
        if (slides[index]) {
            slides[index].classList.add('active');
            slides[index].style.opacity = '1';
            
            // Reset opacity for all other slides
            slides.forEach((slide, i) => {
                if (i !== index) {
                    slide.style.opacity = '0';
                }
            });
        }
        
        if (indicators[index]) {
            indicators[index].classList.add('active');
            indicators[index].style.backgroundColor = '#2563eb'; // blue-600
            
            // Reset other indicators
            indicators.forEach((indicator, i) => {
                if (i !== index) {
                    indicator.style.backgroundColor = '#d1d5db'; // gray-300
                }
            });
        }
        
        currentSlide = index;
    }

    function nextSlide() {
        const next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }

    function startCarousel() {
        carouselInterval = setInterval(nextSlide, 4000);
    }

    function stopCarousel() {
        if (carouselInterval) {
            clearInterval(carouselInterval);
        }
    }

    // Add click events to indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            stopCarousel();
            showSlide(index);
            startCarousel();
        });
    });

    // Pause on hover
    carouselContainer.addEventListener('mouseenter', stopCarousel);
    carouselContainer.addEventListener('mouseleave', startCarousel);

    // Initialize carousel
    if (slides.length > 0) {
        showSlide(0);
        startCarousel();
    }
});
</script>