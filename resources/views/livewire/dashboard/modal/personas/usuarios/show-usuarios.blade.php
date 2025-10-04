<div id="{{ $persona->cedula }}-modal-show-usuarios">

    <div x-data="{ showModalShow: @entangle('showModalShow') }" x-show="showModalShow" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600/40 overflow-auto flex items-center justify-center z-50" style="display: none;">
        <div x-show="showModalShow" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-gradient-to-r from-zinc-200 to-white rounded-xl max-w-4xl w-full m-auto px-3">

            <header class="">
                <div class="w-full flex justify-end pr-5 pt-5 pb-2">
                    <button wire:click="openModalEdit({{ $persona->cedula }})" title="Editar Usuario"
                        class="cursor-pointer transition duration-200 hover:bg-zinc-300 p-1 rounded mr-4">
                        <svg wire:loading.remove wire:target="openModalEdit" xmlns="http://www.w3.org/2000/svg"
                            height="24px" viewBox="0 -960 960 960" width="24px">
                            <path
                                d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z" />
                        </svg>
                        <svg wire:loading.flex wire:target="openModalEdit" class="animate-spin"
                            xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#000000">
                            <path
                                d="M480-80q-83 0-156-31.5t-127-86Q143-252 111.5-325T80-480q0-157 104-270t256-128v120q-103 14-171.5 92.5T200-480q0 116 82 198t198 82q66 0 123.5-28t96.5-76l104 60q-54 75-139 119.5T480-80Zm366-238-104-60q9-24 13.5-49.5T760-480q0-107-68.5-185.5T520-758v-120q152 15 256 128t104 270q0 44-8 85t-26 77Z" />
                        </svg>
                    </button>

                    <button wire:click="closeModalShow" title="Cerrar"
                        class="relative flex justify-center text-white font-bold p-2 px-3 bg-red-600 rounded cursor-pointer transition duration-200 hover:bg-red-800">
                        Cerrar
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#FFFFFF">
                            <path
                                d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                        </svg>
                    </button>
                </div>

                <h2
                    class="text-center text-white bg-zinc-500/60 w-150 h-auto rounded-xl py-2 mx-auto font-extrabold text-4xl my-2 max-[768px]:w-auto">
                    {{ $persona->nombre }} {{ $persona->apellido }}</h2>

            </header>


            <!--   CONTENIDO PRINCIPAL-->
            <div class="block bg-white rounded-md shadow-lg p-5 max-[768px]:text-center">

                <div class="grid grid-cols-4 gap-4 max-[768px]:grid-cols-1">
                    <div>
                        <h3 class="font-bold text-lg">Nombre</h3>
                        <p class="mx-2 max-[768px]:mx-2">{{ $persona->nombre }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Segundo Nombre</h3>
                        <p class="mx-2 max-[768px]:mx-2">{{ $persona->segundo_nombre }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Aepllido</h3>
                        <p class="mx-2 max-[768px]:mx-2">{{ $persona->apellido }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Segundo Apellido</h3>
                        <p class="mx-2 max-[768px]:mx-2">{{ $persona->segundo_apellido }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Fecha de Nacimiento</h3>
                        <p class="mx-2 max-[768px]:mx-2">{{ $persona->nacimiento }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Cedula de Identidad</h3>
                        <p class="mx-2 max-[768px]:mx-2">{{ $persona->nacionalidad }}-{{ $persona->cedula }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Tipo de Usuario</h3>
                        <p class="mx-2 max-[768px]:mx-2">
                            @if ($user->role === 3)
                                Usuario
                            @endif
                            @if ($user->role === 2)
                                Administrador
                            @endif
                            @if ($user->role === 1)
                                Super Administrador
                            @endif
                        </p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Correo</h3>
                        <p class="mx-2 max-[768px]:mx-2">{{ $persona->email }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Teléfono</h3>
                        <p class="mx-2 max-[768px]:mx-2">{{ $persona->telefono }}</p>
                    </div>
                </div>
                <div>
                    <div class="mt-2">
                        <h3 class="font-bold text-lg">Dirección de Residencia</h3>
                        <p class="mx-2 max-[768px]:mx-2">{{ $persona->direccion }}</p>
                    </div>
                </div>

            </div>

            <!--FOOTER-->
            <footer class="my-3 mx-5 max-[768px]:my-6">

            </footer>

        </div>

    </div>

</div>
