<div class="fixed bg-blue-500 text-white min-h-screen p-4 space-y-2 transition-all duration-300 ease-in-out max-[768px]:z-50"
    :class="{
        'w-50': !@json($osultarSidebar),
        'w-20': @json($osultarSidebar),
        'max-[768px]:-left-20': @json($osultarSidebar)
    }">

    <!--PANTALLA OPACA-->
    <button wire:click="toggleSidebar"
        :class="{
            'hidden': @json($osultarSidebar),
            'absolute m-0 p-0 bg-black/15 bottom-0 left-50': !@json($osultarSidebar),
        }"
        @if (!$osultarSidebar) style="width: calc(100vw - 200px); height: 100vh;" @endif>
    </button>

    <!--BOTON DE MENU-->
    <div class="ml-1"
        :class="{
            'flex justify-end': !@json($osultarSidebar),
            'flex justify-center': @json($osultarSidebar),
            'max-[768px]:absolute max-[768px]:left-20 max-[768px]:top-1': @json($osultarSidebar){{-- boton responsive para celulares --}}
        }">
        <button wire:click="toggleSidebar" class="p-2 rounded hover:bg-blue-600 focus:outline-none"
            :class="{
                'max-[768px]:bg-blue-500 max-[768px]:p-0.5': @json($osultarSidebar)
            }">
            <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" height="28px" viewBox="0 -960 960 960"
                width="28px" fill="#FFFFFF">
                <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
            </svg>
        </button>
    </div>

    <!--LOGO + DASHBOARD-->
    <div class="flex items-center m-1"
        :class="{
            'flex-col items-center text-center': @json($osultarSidebar)
        }">
        <div class="bg-gray-300 w-10 h-10 rounded"
            :class="{ 'mr-1': !@json($osultarSidebar), 'mb-2 mr-0': @json($osultarSidebar) }">
            <p class="text-black text-sm">LOGO</p>
        </div>
        <h2 class="text-xl font-semibold"
            :class="{ 'hidden': @json($osultarSidebar), 'mb-4': !@json($osultarSidebar) }">
            Dashboard
        </h2>
    </div>

    <hr :class="{ 'hidden': @json($osultarSidebar) }">

    <nav class="space-y-1">

        <!--INICIO-->
        <a href="{{ route('dashboard') }}"
            class="flex items-center py-2.5 rounded transition duration-200 hover:bg-gray-500 hover:text-white group"
            :class="{
                'justify-center': @json($osultarSidebar),
                'px-4': !@json($osultarSidebar),
                'px-2': @json($osultarSidebar)
            }"
            title="Inicio" wire:navigate>


            <svg class="transition duration-600 ease-in-out group-hover:-translate-y-1"
                xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px"
                fill="#e3e3e3">
                <path d=" M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320
                240v480H520v-240h-80v240H160Zm320-350Z" />
            </svg>

            <span :class="{ 'hidden': @json($osultarSidebar), 'ml-3': !@json($osultarSidebar) }">
                Inicio
            </span>
        </a>

        <!--PERSONAS-->
        <div>
            <button wire:click="togglePersonasSubmenu"
                class="w-full text-left items-center justify-between py-2.5 rounded transition duration-200 hover:bg-gray-500 hover:text-white group
                @if ($showPersonasSubmenu) bg-blue-700 @endif"
                :class="{
                    'flex': !@json($osultarSidebar),
                    'block': @json($osultarSidebar),
                    'justify-center': @json($osultarSidebar),
                    'px-4': !@json($osultarSidebar),
                    'px-2': @json($osultarSidebar)
                }"
                title="Personas">
                <div class="flex items-center" :class="{ 'w-full justify-center': @json($osultarSidebar) }">
                    <svg class="transition duration-600 ease-in-out group-hover:-translate-y-1"
                        xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px"
                        fill="#e3e3e3">
                        <path
                            d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                    </svg>
                    <span :class="{ 'hidden': @json($osultarSidebar), 'ml-3': !@json($osultarSidebar) }">
                        Personas
                    </span>
                </div>
                <div :class="{ 'bg-blue-400 rounded': @json($osultarSidebar) }">
                    <svg class="transform transition-transform duration-200"
                        :class="{
                            'rotate-180': @json($showPersonasSubmenu),
                            'w-4 h-4': !@json($osultarSidebar),
                            'w-8 h-4': @json($osultarSidebar),
                        }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>

            </button>

            @if ($showPersonasSubmenu)
                <div class="bg-blue-600 my-1 space-y-1 rounded"
                    :class="{
                        'ml-5': !@json($osultarSidebar),
                        'ml-0': @json($osultarSidebar)
                    }">
                    <a href="{{ route('usuarios') }}" title="Usuarios"
                        class="block py-2 text-sm rounded transition duration-200 hover:bg-gray-400 hover:bg-opacity-50 hover:text-white"
                        :class="{
                            'px-4': !@json($osultarSidebar),
                            'px-2': @json($osultarSidebar)
                        }"
                        wire:navigate>
                        @if ($osultarSidebar)
                            {{ substr('Usuarios', 0, 4) }}.
                        @else
                            Usuarios
                        @endif
                    </a>
                    <a href="#" title="Afiliados"
                        class="block py-2 text-sm rounded transition duration-200 hover:bg-gray-400 hover:text-white"
                        :class="{
                            'px-4': !@json($osultarSidebar),
                            'px-2': @json($osultarSidebar)
                        }"
                        wire:navigate>
                        @if ($osultarSidebar)
                            {{ substr('Afiliados', 0, 4) }}.
                        @else
                            Afiliados
                        @endif
                    </a>
                    <a href="{{ route('trabajador.indexDos') }}" title="Trabajadores"
                        class="block py-2 text-sm rounded transition duration-200 hover:bg-gray-400 hover:text-white"
                        :class="{
                            'px-4': !@json($osultarSidebar),
                            'px-2': @json($osultarSidebar)
                        }"
                        wire:navigate>
                        @if ($osultarSidebar)
                            {{ substr('Trabajadores', 0, 4) }}.
                        @else
                            Trabajadores
                        @endif
                    </a>
                </div>
            @endif
        </div>

        <!--SOLICITUDES-->
        <div>
            <button wire:click="toggleSolicitudesSubmenu"
                class="w-full text-left items-center justify-between py-2.5 rounded transition duration-200 hover:bg-gray-500 hover:text-white group
                    @if ($showSolicitudesSubmenu) bg-blue-700 @endif"
                :class="{
                    'flex': !@json($osultarSidebar),
                    'block': @json($osultarSidebar),
                    'justify-center': @json($osultarSidebar),
                    'px-4': !@json($osultarSidebar),
                    'px-2': @json($osultarSidebar)
                }"
                title="Solicitudes">
                <div class="flex items-center" :class="{ 'w-full justify-center': @json($osultarSidebar) }">
                    <svg class="transition duration-600 ease-in-out group-hover:-translate-y-1"
                        xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px"
                        fill="#e3e3e3">
                        <path
                            d="M480.67-80q-48.34 0-82.17-33.33-33.83-33.34-33.83-82 0-7 .83-13.34.83-6.33 2.5-12.66l-94.33-53q-15.34 14.66-35.34 23.16-20 8.5-43 8.5-48.33 0-82.16-33.62-33.84-33.63-33.84-81.67t33.34-81.71q33.33-33.66 82-33.66 24.48 0 45.91 9.66Q262-454 278.33-437.33l129-64.67q-4.33-25 2.17-49t22.5-43.67l-40-60q-7.93 2.67-16.43 4-8.5 1.34-17.57 1.34-48.33 0-82.17-33.63Q242-716.59 242-764.63t33.76-81.7q33.77-33.67 82-33.67 48.24 0 81.57 33.64 33.34 33.64 33.34 81.69 0 20.67-6.84 39.17Q459-707 446.67-692L487-631.33q8-2.67 16.67-4 8.66-1.34 18-1.34 17.48 0 32.9 5Q570-626.67 584-618l74.67-61.33q-4.67-10.43-7-21.39-2.34-10.95-2.34-23.28 0-48.67 33.34-82 33.33-33.33 81.66-33.33 48.34 0 82 33.62Q880-772.08 880-724.04t-33.64 81.37q-33.64 33.34-81.69 33.34-17.97 0-33.82-4.84Q715-619 701-628.33l-74 61.66q4.67 10.65 7 21.83 2.33 11.17 2.33 23.51 0 48.05-33.64 81.69Q569.06-406 521-406q-25.33 0-46.5-10T437-442.67l-128.67 65q2 11.34 1.5 22.67-.5 11.33-3.16 22.67l94 53.33q16-14.67 36.5-23.17 20.5-8.5 43.5-8.5 47.77 0 81.22 33.63 33.44 33.63 33.44 81.67t-33.44 81.7Q528.44-80 480.67-80ZM195.38-309.33q20.38 0 34.17-14.17 13.78-14.17 13.78-34.5t-13.78-34.5q-13.79-14.17-34.17-14.17-20.38 0-34.88 14.17Q146-378.33 146-358t14.5 34.5q14.5 14.17 34.88 14.17Zm162.67-406q20.38 0 34.16-14.17Q406-743.67 406-764t-13.79-34.5q-13.78-14.17-34.16-14.17-20.38 0-34.88 14.17-14.5 14.17-14.5 34.5t14.5 34.5q14.5 14.17 34.88 14.17ZM480-146.67q20.33 0 34.5-14.16 14.17-14.17 14.17-34.5 0-20.34-14.17-34.5Q500.33-244 480-244t-34.5 14.17q-14.17 14.16-14.17 34.5 0 20.33 14.17 34.5 14.17 14.16 34.5 14.16Zm40.67-326q20.33 0 34.5-14.16 14.16-14.17 14.16-34.5 0-20.34-14.16-34.5Q541-570 520.67-570q-20.34 0-34.5 14.17Q472-541.67 472-521.33q0 20.33 14.17 34.5 14.16 14.16 34.5 14.16ZM764.71-676q20.38 0 34.17-13.79 13.79-13.78 13.79-34.16 0-20.38-13.79-34.55-13.79-14.17-34.17-14.17-20.38 0-34.88 14.17-14.5 14.17-14.5 34.55 0 20.38 14.5 34.16Q744.33-676 764.71-676Z" />
                    </svg>
                    <span :class="{ 'hidden': @json($osultarSidebar), 'ml-3': !@json($osultarSidebar) }">
                        Solicitudes
                    </span>
                </div>
                <div :class="{ 'bg-blue-400 rounded': @json($osultarSidebar) }">
                    <svg class="transform transition-transform duration-200"
                        :class="{
                            'rotate-180': @json($showSolicitudesSubmenu),
                            'w-4 h-4': !@json($osultarSidebar),
                            'w-8 h-4': @json($osultarSidebar),
                        }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </button>

            @if ($showSolicitudesSubmenu)
                <div class="bg-blue-600 my-1 space-y-1 rounded"
                    :class="{
                        'ml-5': !@json($osultarSidebar),
                        'ml-0': @json($osultarSidebar)
                    }">
                    <a href="#" title="oviedo"
                        class="block py-2 text-sm rounded transition duration-200 hover:bg-gray-400 hover:text-white"
                        :class="{
                            'px-4': !@json($osultarSidebar),
                            'px-2': @json($osultarSidebar)
                        }"
                        wire:navigate>
                        @if ($osultarSidebar)
                            {{ substr('oviedo', 0, 4) }}.
                        @else
                            oviedo
                        @endif
                    </a>
                </div>
            @endif
        </div>

        <!--REUNIONES-->
        <div>
            <button wire:click="toggleReunionesSubmenu"
                class="w-full text-left items-center justify-between py-2.5 rounded transition duration-200 hover:bg-gray-500 hover:text-white group
                    @if ($showReunionesSubmenu) bg-blue-700 @endif"
                :class="{
                    'flex': !@json($osultarSidebar),
                    'block': @json($osultarSidebar),
                    'justify-center': @json($osultarSidebar),
                    'px-4': !@json($osultarSidebar),
                    'px-2': @json($osultarSidebar)
                }"
                title="Reuniones">
                <div class="flex items-center" :class="{ 'w-full justify-center': @json($osultarSidebar) }">
                    <svg class="transition duration-600 ease-in-out group-hover:-translate-y-1"
                        xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px"
                        fill="#e3e3e3">
                        <path
                            d="M440-400v-80h80v80h-80Zm-160 0v-80h80v80h-80Zm320 0v-80h80v80h-80ZM440-240v-80h80v80h-80Zm-160 0v-80h80v80h-80Zm320 0v-80h80v80h-80ZM120-80v-720h120v-80h80v80h320v-80h80v80h120v720H120Zm80-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z" />
                    </svg>
                    <span :class="{ 'hidden': @json($osultarSidebar), 'ml-3': !@json($osultarSidebar) }">
                        Reuniones
                    </span>
                </div>
                <div :class="{ 'bg-blue-400 rounded': @json($osultarSidebar) }">
                    <svg class="transform transition-transform duration-200"
                        :class="{
                            'rotate-180': @json($showReunionesSubmenu),
                            'w-4 h-4': !@json($osultarSidebar),
                            'w-8 h-4': @json($osultarSidebar),
                        }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </button>

            @if ($showReunionesSubmenu)
                <div class="bg-blue-600 my-1 space-y-1 rounded"
                    :class="{
                        'ml-5': !@json($osultarSidebar),
                        'ml-0': @json($osultarSidebar)
                    }">
                    @if(Auth::user()->isSuperAdministrador() || Auth::user()->isAdministrador())
                        <a href="{{ route('dashboard.superadmin.reuniones') }}" title="Gestión de Reuniones"
                            class="block py-2 text-sm rounded transition duration-200 hover:bg-gray-400 hover:text-white"
                            :class="{
                                'px-4': !@json($osultarSidebar),
                                'px-2': @json($osultarSidebar)
                            }"
                            wire:navigate>
                            @if ($osultarSidebar)
                                {{ substr('Gestión', 0, 4) }}.
                            @else
                                Gestión de Reuniones
                            @endif
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!--VISITAS-->
        <a href="#"
            class="flex items-center py-2.5 rounded transition duration-200 hover:bg-gray-500 hover:text-white group"
            :class="{
                'justify-center': @json($osultarSidebar),
                'px-4': !
                    @json($osultarSidebar),
                'px-2': @json($osultarSidebar)
            }"
            title="Visitas" wire:navigate>
            <svg class="transition duration-600 ease-in-out group-hover:-translate-y-1"
                xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px"
                fill="#e3e3e3">
                <path
                    d="M240-200q-50 0-85-35t-35-85H40v-440h640l240 240v200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H360q0 50-35 85t-85 35Zm360-360h160L640-680h-40v120Zm-240 0h160v-120H360v120Zm-240 0h160v-120H120v120Zm120 290q21 0 35.5-14.5T290-320q0-21-14.5-35.5T240-370q-21 0-35.5 14.5T190-320q0 21 14.5 35.5T240-270Zm480 0q21 0 35.5-14.5T770-320q0-21-14.5-35.5T720-370q-21 0-35.5 14.5T670-320q0 21 14.5 35.5T720-270ZM120-400h32q17-18 39-29t49-11q27 0 49 11t39 29h304q17-18 39-29t49-11q27 0 49 11t39 29h32v-80H120v80Zm720-80H120h720Z" />
            </svg>
            <span
                :class="{ 'hidden': @json($osultarSidebar), 'ml-3': !@json($osultarSidebar) }">Visitas</span>
        </a>

        <!--AJUSTES-->
        <a href="#"
            class="flex items-center py-2.5 rounded transition duration-200 hover:bg-gray-500 hover:text-white group"
            :class="{
                'justify-center': @json($osultarSidebar),
                'px-4': !
                    @json($osultarSidebar),
                'px-2': @json($osultarSidebar)
            }"
            title="Ajustes" wire:navigate>
            <svg class="transition duration-600 ease-in-out group-hover:-translate-y-1"
                xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px"
                fill="#e3e3e3">
                <path
                    d="m382-80-18.67-126.67q-17-6.33-34.83-16.66-17.83-10.34-32.17-21.67L178-192.33 79.33-365l106.34-78.67q-1.67-8.33-2-18.16-.34-9.84-.34-18.17 0-8.33.34-18.17.33-9.83 2-18.16L79.33-595 178-767.67 296.33-715q14.34-11.33 32.34-21.67 18-10.33 34.66-16L382-880h196l18.67 126.67q17 6.33 35.16 16.33 18.17 10 31.84 22L782-767.67 880.67-595l-106.34 77.33q1.67 9 2 18.84.34 9.83.34 18.83 0 9-.34 18.5Q776-452 774-443l106.33 78-98.66 172.67-118-52.67q-14.34 11.33-32 22-17.67 10.67-35 16.33L578-80H382Zm55.33-66.67h85l14-110q32.34-8 60.84-24.5T649-321l103.67 44.33 39.66-70.66L701-415q4.33-16 6.67-32.17Q710-463.33 710-480q0-16.67-2-32.83-2-16.17-7-32.17l91.33-67.67-39.66-70.66L649-638.67q-22.67-25-50.83-41.83-28.17-16.83-61.84-22.83l-13.66-110h-85l-14 110q-33 7.33-61.5 23.83T311-639l-103.67-44.33-39.66 70.66L259-545.33Q254.67-529 252.33-513 250-497 250-480q0 16.67 2.33 32.67 2.34 16 6.67 32.33l-91.33 67.67 39.66 70.66L311-321.33q23.33 23.66 51.83 40.16 28.5 16.5 60.84 24.5l13.66 110Zm43.34-200q55.33 0 94.33-39T614-480q0-55.33-39-94.33t-94.33-39q-55.67 0-94.5 39-38.84 39-38.84 94.33t38.84 94.33q38.83 39 94.5 39ZM480-480Z" />
            </svg>
            <span
                :class="{ 'hidden': @json($osultarSidebar), 'ml-3': !@json($osultarSidebar) }">Ajustes</span>
        </a>
    </nav>


</div>
