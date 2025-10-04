@section('title', 'Personas')
@section('subTitle', '// Usuarios')
<div class="m-auto">


    <div class="ml-5 mb-5 mr-5 p-10 max-[768px]:m-1 max-[768px]:p-4">

        <!--CARTAS INFORMATIVAS-->
        <div id="cards" class="mb-10 flex justify-between max-[768px]:inline-block max-[768px]:w-full">
            <div
                class="flex items-center bg-gradient-to-r from-blue-500 to-blue-400 w-55 h-30 rounded-2xl shadow-md max-[768px]:w-full">
                <div class="ml-5 mr-1 pt-5 pb-5 inline-block">
                    <h3 class="font-bold text-white text-xl">Personas totales</h3>
                    <h2 class="font-bold text-white text-3xl">{{ $usuariosTotal }}</h2>
                </div>
                <div class="ml-1 mr-5">
                    <svg xmlns="http://www.w3.org/2000/svg" height="60px" viewBox="0 -960 960 960" width="60px"
                        fill="#e3e3e3">
                        <path
                            d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z" />
                    </svg>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4 items-end max-[768px]:grid-cols-1 max-[768px]:gap-0 max-[768px]:mt-5">
                <div
                    class="flex inline-block py-2 bg-gradient-to-r from-blue-500 to-blue-400 w-35 h-20 rounded-2xl shadow-md max-[768px]:mt-2 max-[768px]:w-full">
                    <h3 class="font-bold text-white text-xl text-center">Super-Admin</h3>
                    <h2 class="font-bold text-white text-3xl text-center">{{ $sA }}</h2>
                </div>
                <div
                    class="flex inline-block py-2 bg-gradient-to-r from-blue-500 to-blue-400 w-35 h-20 rounded-2xl shadow-md max-[768px]:mt-2 max-[768px]:w-full">
                    <h3 class="font-bold text-white text-xl text-center">Admin</h3>
                    <h2 class="font-bold text-white text-3xl text-center">{{ $a }}</h2>
                </div>
                <div
                    class="flex inline-block py-2 bg-gradient-to-r from-blue-500 to-blue-400 w-35 h-20 rounded-2xl shadow-md max-[768px]:mt-2 max-[768px]:w-full">
                    <h3 class="font-bold text-white text-xl text-center">Usuarios</h3>
                    <h2 class="font-bold text-white text-3xl text-center">{{ $u }}</h2>
                </div>
            </div>
        </div>

        <!--TABLA DE USUARIOS-->
        <div id="table">
            <div class="w-full p-2 bg-orange-300 rounded-lg mb-3 flex justify-between">
                <input type="text" class="bg-white rounded p-1 w-55 max-[768px]:w-40 max-[640px]:w-30"
                    wire:model.live.debounce.500ms="search" placeholder="Buscar">

                @livewire('dashboard.modal.personas.usuarios.create-usuarios')
            </div>

            <div class="max-[768px]:overflow-x-auto rounded-lg p-1 bg-orange-300">
                <table class="table-fixed w-full max-[768px]:w-150">
                    <thead class="bg-orange-300">
                        <tr class="border-gray-600/50">

                            <th class="cursor-pointer p-1 text-gray-700 w-25" wire:click="orden('cedula')">
                                <div class="flex justify-between">
                                    Cédula

                                    @if ($sort == 'cedula')
                                        @if ($direction == 'asc')
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="">
                                                <path d="m280-400 200-200 200 200H280Z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="">
                                                <path d="M480-360 280-560h400L480-360Z" />
                                            </svg>
                                        @endif
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="">
                                            <path
                                                d="M480-120 300-300l58-58 122 122 122-122 58 58-180 180ZM358-598l-58-58 180-180 180 180-58 58-122-122-122 122Z" />
                                        </svg>
                                    @endif

                                </div>
                            </th>

                            <th class="cursor-pointer p-1 text-gray-700" wire:click="orden('nombre')">
                                <div class="flex justify-between">
                                    Nombres y Apellidos

                                    @if ($sort == 'nombre')
                                        @if ($direction == 'asc')
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="">
                                                <path d="m280-400 200-200 200 200H280Z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="">
                                                <path d="M480-360 280-560h400L480-360Z" />
                                            </svg>
                                        @endif
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="">
                                            <path
                                                d="M480-120 300-300l58-58 122 122 122-122 58 58-180 180ZM358-598l-58-58 180-180 180 180-58 58-122-122-122 122Z" />
                                        </svg>
                                    @endif

                                </div>
                            </th>

                            <th class="p-1 text-gray-700">Tipo de Usuario</th>

                            <th class="cursor-pointer p-1 text-gray-700" wire:click="orden('telefono')">
                                <div class="flex justify-between">
                                    Teléfono

                                    @if ($sort == 'telefono')
                                        @if ($direction == 'asc')
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="">
                                                <path d="m280-400 200-200 200 200H280Z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="">
                                                <path d="M480-360 280-560h400L480-360Z" />
                                            </svg>
                                        @endif
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="">
                                            <path
                                                d="M480-120 300-300l58-58 122 122 122-122 58 58-180 180ZM358-598l-58-58 180-180 180 180-58 58-122-122-122 122Z" />
                                        </svg>
                                    @endif

                                </div>
                            </th>

                            <th class="p-1 text-gray-700">Acciones</th>

                        </tr>
                    </thead>
                    <tbody class="bg-zinc-100">
                        @foreach ($personas as $persona)
                            <tr class="border-gray-300 border-t-6">
                                <td class="font-bold text-center">{{ $persona->cedula }}</td>
                                <td class="p-1">
                                    {{ $persona->nombre }}
                                    {{ $persona->segundo_nombre }}
                                    {{ $persona->apellido }}
                                    {{ $persona->segundo_apellido }}</td>
                                <td class="p-1 text-center">
                                    @if ($persona->usuario->role === 3)
                                        Usuario
                                    @endif
                                    @if ($persona->usuario->role === 2)
                                        Administrador
                                    @endif
                                    @if ($persona->usuario->role === 1)
                                        Super Administrador
                                    @endif
                                </td>
                                <td class="p-1">{{ $persona->telefono }}</td>
                                <td class="p-2 flex justify-center max-[768px]:grid max-[768px]:gap-3">
                                    <div class="w-full mx-1">
                                        <button
                                            class="bg-rose-600 flex justify-center py-1 w-full text-white cursor-pointer ring rounded-lg transition duration-200 hover:bg-rose-900 max-[768px]:px-6"
                                            title="Generar PDF">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                                <path
                                                    d="M360-460h40v-80h40q17 0 28.5-11.5T480-580v-40q0-17-11.5-28.5T440-660h-80v200Zm40-120v-40h40v40h-40Zm120 120h80q17 0 28.5-11.5T640-500v-120q0-17-11.5-28.5T600-660h-80v200Zm40-40v-120h40v120h-40Zm120 40h40v-80h40v-40h-40v-40h40v-40h-80v200ZM320-240q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Zm160-720v480-480Z" />
                                            </svg>
                                            PDF
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 gap-3 w-full mx-1">

                                        <!--MOSTRAR USUARIO-->
                                        <button wire:click="openModalShow({{ $persona->cedula }})"
                                            class="bg-white flex justify-center py-1 w-full cursor-pointer ring rounded-lg transition duration-200 hover:bg-zinc-200"
                                            title="Más Información">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px">
                                                <path
                                                    d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-480H200v480Zm280-80q-82 0-146.5-44.5T240-440q29-71 93.5-115.5T480-600q82 0 146.5 44.5T720-440q-29 71-93.5 115.5T480-280Zm0-60q56 0 102-26.5t72-73.5q-26-47-72-73.5T480-540q-56 0-102 26.5T306-440q26 47 72 73.5T480-340Zm0-100Zm0 60q25 0 42.5-17.5T540-440q0-25-17.5-42.5T480-500q-25 0-42.5 17.5T420-440q0 25 17.5 42.5T480-380Z" />
                                            </svg>
                                            Info
                                        </button>

                                        <!--EDITAR USUARIO-->
                                        <button wire:click="openModalEdit({{ $persona->cedula }})"
                                            class="bg-yellow-100 flex justify-center py-1 w-full cursor-pointer ring rounded-lg transition duration-200 hover:bg-zinc-200"
                                            title="Editar Usuario">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px">
                                                <path
                                                    d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z" />
                                            </svg>
                                            Editar
                                        </button>

                                        <!--ELIMINAR USUARIO-->
                                        <button wire:click="openModalDestroy({{ $persona->cedula }})"
                                            class="bg-red-100 flex justify-center py-1 px-full cursor-pointer ring rounded-lg transition duration-200 hover:bg-zinc-200"
                                            title="Eliminar Usuario">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px">
                                                <path
                                                    d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z" />
                                            </svg>
                                            Eliminar
                                        </button>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="m-6">
                    {{ $personas->links() }}
                </div>
            </div>
        </div>

    </div>

    <!--MODALES-->
    <span class="m-0 p-0 w-0 h-0">
        @livewire('dashboard.modal.personas.usuarios.edit-usuarios')
        @livewire('dashboard.modal.personas.usuarios.show-usuarios')
        @livewire('dashboard.modal.personas.usuarios.destroy-usuarios')
    </span>
</div>
