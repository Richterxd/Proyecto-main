<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('img/isotipo.png') }}">

    <title>@yield('title', 'CMBEY - Sistema Municipal')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Alpine.js -->
    <!--  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> -->



</head>

<body class="bg-white font-roboto">
    <div class="flex h-screen" x-data="{ sidebarOpen: false }">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 z-40 md:hidden"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"></div>

        <!-- Sidebar -->
        <div class="w-64 sidebar-gradient shadow-2xl flex flex-col sidebar-responsive" :class="{'open': sidebarOpen}"
            x-data="{ 
                solicitudesOpen: false,
                currentUser: @js(auth()->user()),
                userRole: @js(auth()->user()->role)
            }">
            <!-- Logo Section -->
            <div class="p-6 border-b border-white border-opacity-20">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('img/logotipo.png') }}" alt="CMBEY Logo" class="h-16 w-auto object-contain">
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-4 overflow-y-auto">
                <ul class="space-y-2">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
                            class="sidebar-item flex items-center p-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10">
                            <i class='bx bx-home text-xl mr-3'></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Solicitudes (Solo para Usuario) -->
                    <template x-if="userRole === 3">
                        <li>
                            <a href="{{ route('dashboard.usuario.solicitud') }}"
                                class="sidebar-item flex items-center p-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class='bx bx-file-blank text-xl mr-3'></i>
                                <span>Solicitudes</span>
                            </a>
                        </li>
                    </template>


                    <!-- Visitas (Solo para Usuario) -->
                    <template x-if="userRole === 3">
                        <li>
                            <a href="{{ route('dashboard.superadmin') }}?tab=visitas" @click="sidebarOpen = false"
                                class="sidebar-item flex items-center p-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class='bx bx-calendar-check text-xl mr-3'></i>
                                <span>Visitas</span>
                            </a>
                        </li>
                    </template>

                    <!-- Perfil (Solo para Usuario) -->
                    <template x-if="userRole === 3">
                        <li>
                            <a href="{{ route('dashboard.usuario') }}?tab=perfil" @click="sidebarOpen = false"
                                class="sidebar-item flex items-center p-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class='bx bx-user text-xl mr-3'></i>
                                <span>Perfil</span>
                            </a>
                        </li>
                    </template>

                    <!-- Gestión (Para Admin y SuperAdmin) -->
                    <template x-if="userRole <= 2">
                        <li>
                            <a href="{{route('dashboard.superadmin.usuarios')}}" @click="sidebarOpen = false"
                                class="sidebar-item flex items-center p-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class='bx bx-user text-xl mr-4'></i>
                                <span>Gestión Usuarios</span>
                            </a>
                        </li>
                    </template>

                    <!-- Visitas (Para Admin y SuperAdmin) -->

                    <template x-if="userRole <= 2">
                        <li>
                            <a href="{{route('dashboard.superadmin.visitas')}}" @click="sidebarOpen = false"
                                class="sidebar-item flex items-center p-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class='bx bx-calendar-check text-xl mr-4'></i>
                                <span>Gestión Visitas</span>
                            </a>
                        </li>
                    </template>

                    <!-- Reportes (Para Admin ) -->

                    <template x-if="userRole==1">
                        <li>
                            <a href="{{route('dashboard.superadmin.trabajadores')}}" @click="sidebarOpen = false"
                                class="sidebar-item flex items-center p-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class="bx bx-book-content text-xl mr-3"></i>
                                <span>Gestión Trabajadores</span>
                            </a>
                        </li>
                    </template>

                    <!-- Reportes (Para Admin y SuperAdmin) -->
                    <template x-if="userRole <= 2">
                        <li>
                            <a href="{{route('dashboard.superadmin.reportes')}}" @click="sidebarOpen = false"
                                class="sidebar-item flex items-center p-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class='bx bx-bar-chart-alt-2 text-xl mr-3'></i>
                                <span>Reportes</span>
                            </a>
                        </li>
                    </template>

                    <!-- Reportes (Para Admin y SuperAdmin) -->
                    <template x-if="userRole <= 2">
                        <li>
                            <a href="#" @click="sidebarOpen = false"
                                class="sidebar-item flex items-center p-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class='bx bx-message-square-dots mr-3 text-xl'></i>
                                <span>Chat</span>
                            </a>
                        </li>
                    </template>

                    <!-- Solicitudes (Para Admin y SuperAdmin) -->
                    <template x-if="userRole <= 2">
                        <li>
                            <a href="{{route('dashboard.superadmin.solicitudes')}}" @click="sidebarOpen = false"
                                class="sidebar-item flex items-center p-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class='bx bx-file-blank text-xl mr-3'></i>
                                <span>Solicitudes</span>
                            </a>
                        </li>
                    </template>
                </ul>
            </nav>



            <!-- Logout Button -->
            <div class="p-4 border-t border-white border-opacity-20">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="sidebar-item w-full flex items-center p-3 text-white rounded-lg hover:bg-red-600 hover:bg-opacity-80 transition-colors">
                        <i class='bx bx-log-out text-xl mr-3'></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden main-content-mobile">
            <!-- Top Navbar -->
            <header class="navbar-gradient shadow-lg">
                <div class="flex items-center justify-between px-4 md:px-6 py-4">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="text-white p-2 rounded-lg hover:bg-white hover:bg-opacity-10 mr-3 md:hidden">
                            <i class='bx bx-menu text-xl'></i>
                        </button>

                    </div>
                    <div class="flex items-center space-x-2 md:space-x-4">
                        <div class="text-right hidden md:block">
                            <p class="text-white text-sm font-medium">{{ auth()->user()->persona->nombre }} {{
                                auth()->user()->persona->apellido }}</p>
                            <p class="text-blue-100 text-xs">{{ auth()->user()->getRoleName() }}</p>
                        </div>
                        <div class="h-8 w-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class='bx bx-user text-white'></i>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                {{ $slot }}
            </main>
        </div>
    </div>

    <div x-data="{ show: false, message: '', type: 'success' }"
        @show-message.window="show = true; message = $event.detail.message || $event.detail; type = $event.detail.type || 'success'; setTimeout(() => show = false, 4000)"
        x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed top-4 right-4 z-50"
        style="display: none;">
        <div class="max-w-sm w-full shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
            :class="{
                'bg-green-50 border-green-200': type === 'success',
                'bg-red-50 border-red-200': type === 'error',
                'bg-yellow-50 border-yellow-200': type === 'warning',
                'bg-blue-50 border-blue-200': type === 'info'
             }">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="text-xl" :class="{
                              'bx bx-check-circle text-green-400': type === 'success',
                              'bx bx-x-circle text-red-400': type === 'error',
                              'bx bx-error-circle text-yellow-400': type === 'warning',
                              'bx bx-info-circle text-blue-400': type === 'info'
                           }"></i>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium" :class="{
                                'text-green-800': type === 'success',
                                'text-red-800': type === 'error',
                                'text-yellow-800': type === 'warning',
                                'text-blue-800': type === 'info'
                            }" x-text="message"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false"
                            class="rounded-md inline-flex focus:outline-none focus:ring-2 focus:ring-offset-2" :class="{
                                   'text-green-400 hover:text-green-500 focus:ring-green-500': type === 'success',
                                   'text-red-400 hover:text-red-500 focus:ring-red-500': type === 'error',
                                   'text-yellow-400 hover:text-yellow-500 focus:ring-yellow-500': type === 'warning',
                                   'text-blue-400 hover:text-blue-500 focus:ring-blue-500': type === 'info'
                                }">
                            <i class='bx bx-x text-lg'></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>