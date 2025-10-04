<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CMBEY - Home</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <style>
        .sidebar {
            transition: all 0.3s ease;
            width: 70px;
            background: linear-gradient(to bottom, #93c5fd, #3b82f6, #1e3a8a);
        }

        .sidebar:hover {
            width: 250px;
        }

        .sidebar-item span {
            opacity: 0;
            transition: opacity 0.2s ease 0.1s;
            white-space: nowrap;
        }

        .sidebar:hover .sidebar-item span {
            opacity: 1;
        }

        .dropdown {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: rgba(30, 58, 138, 0.8);
        }

        .dropdown.active {
            max-height: 500px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-item span {
                opacity: 1 !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar izquierdo -->
        <aside class="sidebar fixed md:relative left-0 top-0 h-full text-white shadow-lg z-10">
            <!-- Botón móvil -->
            <button class="md:hidden absolute right-0 top-0 bg-blue-900 text-white p-3" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Logo y título -->
            <div class="p-4 flex items-center border-b border-blue-400/30">
                <div class="w-10 h-10 rounded-full bg-blue-500/80 flex items-center justify-center">
                    <img src="{{asset('img/isotipo.png')}}" alt="">
                </div>
                <span class="ml-3 font-semibold text-lg hidden">Mi App</span>
            </div>

            <!-- Menú de navegación -->
            <a href="{{route('clientHome')}}"
                class="sidebar-item flex items-center px-4 py-3 text-white hover:bg-blue-500/30 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="ml-3">Inicio</span>
            </a>

            <!-- Botón con dropdown 1 -->
            <div class="relative">
                <button onclick="toggleDropdown(event, 'dropdown1')"
                    class="sidebar-item w-full flex items-center px-4 py-3 text-white hover:bg-blue-500/30 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="ml-3">Personas</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="dropdown1" class="dropdown">
                    <a href="#" class="block px-4 py-2 pl-14 text-sm text-white hover:bg-blue-500/40">Usuarios</a>
                    <a href="#" class="block px-4 py-2 pl-14 text-sm text-white hover:bg-blue-500/40">Trabajadores</a>
                    <a href="{{route('agente')}}"
                        class="block px-4 py-2 pl-14 text-sm text-white hover:bg-blue-500/40">Agente</a>
                </div>
            </div>

            <!-- Botón con dropdown 2 -->
            <div class="relative">
                <button onclick="toggleDropdown(event, 'dropdown2')"
                    class="sidebar-item w-full flex items-center px-4 py-3 text-white hover:bg-blue-500/30 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="ml-3">Analitica</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="dropdown2" class="dropdown">
                    <a href="#" class="block px-4 py-2 pl-14 text-sm text-white hover:bg-blue-500/40">Estadisticas</a>
                    <a href="#" class="block px-4 py-2 pl-14 text-sm text-white hover:bg-blue-500/40">Areas
                        afectadas</a>
                    <a href="#" class="block px-4 py-2 pl-14 text-sm text-white hover:bg-blue-500/40">Inventario</a>
                </div>
            </div>

            <a href="#"
                class="sidebar-item flex items-center px-4 py-3 text-white hover:bg-blue-500/30 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="ml-3">Configuración</span>
            </a>

            <a href="#"
                class="sidebar-item flex items-center px-4 py-3 text-white hover:bg-blue-500/30 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="ml-3">Salir</span>
            </a>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 overflow-y-auto p-6">
            <button class="md:hidden mb-4 bg-blue-600 text-white p-2 rounded" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Principal</h1>
                <p class="mt-2 text-gray-600">Contenido de tu aplicación aquí</p>

                <!-- Sección de tarjetas -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-semibold text-lg">Estadísticas</h3>
                        <p class="mt-2 text-gray-600">Información relevante</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-semibold text-lg">Actividad Reciente</h3>
                        <p class="mt-2 text-gray-600">Últimas acciones</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-semibold text-lg">Notificaciones</h3>
                        <p class="mt-2 text-gray-600">Alertas importantes</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Variable para rastrear si hay dropdowns abiertos
        let dropdownOpen = false;

        // Función para móviles
        function toggleSidebar() {
            if (!dropdownOpen) {
                document.querySelector('.sidebar').classList.toggle('active');
            }
        }

        // Función para dropdowns
        function toggleDropdown(event, id) {
            event.stopPropagation(); // Evita que el evento llegue al document
            
            const dropdown = document.getElementById(id);
            const isActive = dropdown.classList.contains('active');
            
            // Cerrar todos los dropdowns primero
            document.querySelectorAll('.dropdown').forEach(d => {
                if (d.id !== id) d.classList.remove('active');
            });
            
            // Alternar el dropdown clickeado
            dropdown.classList.toggle('active');
            
            // Actualizar estado
            dropdownOpen = dropdown.classList.contains('active');
        }

        // Cerrar sidebar y dropdowns al hacer clic fuera
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.querySelector('[onclick="toggleSidebar()"]');
            const isDropdownClick = event.target.closest('.dropdown') || 
                                  event.target.closest('[onclick^="toggleDropdown"]');
            
            // Si no es un click en el sidebar o sus elementos
            if (!sidebar.contains(event.target) && !event.target.closest('[onclick="toggleSidebar()"]')) {
                // Cerrar dropdowns primero
                if (!isDropdownClick) {
                    document.querySelectorAll('.dropdown').forEach(d => {
                        d.classList.remove('active');
                    });
                    dropdownOpen = false;
                }
                
                // Cerrar sidebar solo en móviles y si no hay dropdowns abiertos
                if (window.innerWidth <= 768 && !dropdownOpen) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Cerrar dropdowns al cambiar tamaño de pantalla (responsive)
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.querySelectorAll('.dropdown').forEach(d => {
                    d.classList.remove('active');
                });
                dropdownOpen = false;
            }
        });
    </script>
</body>

</html>

</html>