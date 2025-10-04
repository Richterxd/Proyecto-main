<div id="{{ $cedula }}-modal-edit-usuarios">

    <div x-data="{ showModalEdit: @entangle('showModalEdit') }" x-show="showModalEdit" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600/40 overflow-auto flex items-center justify-center" style="display: none;">
        <div x-show="showModalEdit" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl max-w-3xl w-full m-auto px-1">

            <header class="">
                <div class="w-full flex justify-end pr-5 pt-5 pb-2">
                    <button wire:click="closeModalEdit" title="Cerrar"
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
                    class="text-center text-white bg-blue-400/60 w-150 h-15 rounded-xl pt-2 mx-auto font-extrabold text-4xl my-2 max-[768px]:w-auto">
                    Editar Usuario</h2>

            </header>


            <!--   CONTENIDO PRINCIPAL-->
            <form wire:submit.prevent="saveConfirmation({{ $cedula }})">
                <div class="block bg-white rounded-md shadow-lg p-5">

                    <!--MENSJAES DE ERROR-->
                    @if ($errors->any())
                        <div class="bg-rose-500/20 rounded-md p-2">
                            <ul class="list-disc">
                                @foreach ($errors->all() as $error)
                                    <li class="ml-5 text-zinc-800">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-4 gap-x-4 gap-y-5 my-5 max-[768px]:grid-cols-1 max-[768px]:gap-2">
                        <!--NOMBRE-->
                        <div class="flex flex-col-reverse">
                            <input id="nombre-input" type="text" wire:model.defer="nombre"
                                placeholder="{{ $nombre }}"
                                class="bg-gray-200 text-lg w-full p-1 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                required>
                            <label for="nombre-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Nombre</label>
                        </div>
                        <!--SEGUNDO NOMBRE-->
                        <div class="flex flex-col-reverse">
                            <input id="segundo_nombre-input" type="text" wire:model.defer="segundo_nombre"
                                placeholder="{{ $segundo_nombre }}" placeholder="Ejem.: Chaviel Lopez"
                                class="bg-gray-200 text-lg w-full p-1 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                required>
                            <label for="segundo_nombre-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Segundo Nombre</label>
                        </div>
                        <!--APELLIDO-->
                        <div class="flex flex-col-reverse">
                            <input id="apellido-input" type="text" wire:model.defer="apellido"
                                placeholder="{{ $apellido }}" placeholder="Ejem.: Juan Pablo"
                                class="bg-gray-200 text-lg w-full p-1 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                required>
                            <label for="apellido-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Apellido</label>
                        </div>
                        <!--SEGUNDO APELLIDO-->
                        <div class="flex flex-col-reverse">
                            <input id="segundo_apellido-input" type="text" wire:model.defer="segundo_apellido"
                                placeholder="{{ $segundo_apellido }}" placeholder="Ejem.: Chaviel Lopez"
                                class="bg-gray-200 text-lg w-full p-1 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                required>
                            <label for="segundo_apellido-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Segundo Apellido</label>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-10 gap-y-5 max-[768px]:grid-cols-1 max-[768px]:gap-2">
                        <!--NACIONALIDAD Y CEDULA-->
                        <div class="flex flex-col-reverse">
                            <div class="flex">
                                <select id="nacionalidad-select" wire:model.defer="nacionalidad"
                                    class="bg-gray-200 w-15 p-1 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                    required>
                                    <option value="" selected disabled>Nacionalidad</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                    <option value="J">J</option>
                                </select>
                                <input id="cedula-input" type="number" wire:model.defer="cedula"
                                    placeholder="{{ $cedula }}" placeholder="Ejem.: 12345678"
                                    class="bg-gray-200 text-lg w-full p-1 pl-2 ml-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                    required>
                            </div>
                            <label for="cedula-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Cedula de Identidad</label>
                        </div>

                        <!--TELEFONO-->
                        <div class="flex flex-col-reverse">
                            <div class="flex">
                                <select id="prefijo_telefono-select" wire:model.defer="prefijo_telefono"
                                    class="bg-gray-200 w-25 p-1 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                    required>
                                    <option value="" selected disabled>Prefijo</option>
                                    <option value="0412">0412</option>
                                    <option value="0422">0422</option>
                                    <option value="0414">0414</option>
                                    <option value="0424">0424</option>
                                    <option value="0416">0416</option>
                                    <option value="0426">0416</option>
                                </select>
                                <input id="telefono-input" type="text" wire:model.defer="telefono"
                                    placeholder="{{ $telefono }}" placeholder="XXX-XXXX" maxlength="8"
                                    pattern="\d{3}-\d{4}"
                                    oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{3})(\d{4})/, '$1-$2')"
                                    required
                                    class="bg-gray-200 text-lg w-full p-1 pl-2 ml-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                    required>
                            </div>
                            <label for="telefono-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Teléfono</label>
                        </div>
                    </div>

                    <div class="my-5">
                        <!--DIRECCION-->
                        <div class="flex flex-col-reverse">
                            <input id="direccion-input" type="text" wire:model.defer="direccion"
                                placeholder="{{ $direccion }}" placeholder="Ingrese la dirección donde recide"
                                class="bg-gray-200 text-lg w-full p-1 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                required>
                            <label for="direccion-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Dirección</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-x-10 gap-y-5 my-5 max-[768px]:grid-cols-1 max-[768px]:gap-2">
                        <!--ROLE-->
                        <div class="flex flex-col-reverse">
                            <select id="role-input" wire:model.defer="role"
                                class="bg-gray-200 text-lg w-full p-1 py-2 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                required>
                                <option value="" selected disabled>Seleccione un tipo de usuario</option>
                                <option value="3">Usuario</option>
                                <option value="2">Administrador</option>
                                <option value="1">Super Administrador</option>
                            </select>
                            <label for="role-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Tipo de Usuario</label>
                        </div>
                        <!--CORREO-->
                        <div class="flex flex-col-reverse">
                            <input id="email-input" type="email" wire:model.defer="email"
                                placeholder="{{ $email }}" placeholder="Ejem.: juan33@gmail.com"
                                class="bg-gray-200 text-lg w-full p-1 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                required>
                            <label for="email-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Correo</label>
                        </div>
                        <!--NACIMIENTO-->
                        <div class="flex flex-col-reverse">
                            <input id="nacimiento-input" type="date" wire:model.defer="nacimiento"
                                placeholder="{{ $nacimiento }}" value="{{ $nacimiento }}"
                                class="bg-gray-200 text-lg w-full p-1 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                required>
                            <label for="nacimiento-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Fecha de Nacimiento</label>
                        </div>
                        @if ($ageError)
                            <div class="error-text">{{ $ageError }}</div>
                        @endif
                        <!--GENERO-->
                        <div class="flex flex-col-reverse">
                            <select id="genero-input" wire:model.defer="genero"
                                class="bg-gray-200 text-lg w-full p-1 py-2 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer"
                                required>
                                <option value="" selected disabled>Seleccionar</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="no_binario">No Binario</option>
                                <option value="no_decir">No Decir</option>
                            </select>
                            <label for="genero-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Genero</label>
                        </div>

                        <!--CONTRASEÑA-->
                        <div class="flex flex-col-reverse">
                            <input id="password-input" type="password" wire:model.defer="password"
                                placeholder="Min: 6 - Max:15 caracteres"
                                class="bg-gray-200 text-lg w-full p-1 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer">
                            <label for="password-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Nueva Contraseña</label>
                        </div>
                        <div class="flex flex-col-reverse">
                            <input id="password_confirmation-input" type="password"
                                wire:model.defer="password_confirmation" placeholder="Repetir misma contraseña"
                                class="bg-gray-200 text-lg w-full p-1 pl-2 inset-shadow-sm rounded text-zinc-900 outline-none border-1 border-gray-600 focus:border-cyan-500 peer">
                            <label for="password_confirmation-input"
                                class="font-bold text-lg text-gray-600 transition-all duration-150 peer-focus:text-cyan-600 peer-focus:scale-105 peer-focus:translate-x-2">
                                Repetir Nueva
                                Contraseña</label>
                        </div>
                    </div>

                </div>

                <!--FOOTER-->
                <footer class="my-3 mx-5 max-[768px]:my-6">
                    <div class="flex justify-end space-x-2 max-[768px]:justify-center">
                        <button wire:click="saveConfirmation({{ $cedula }})" title="Editar"
                            class="flex justify-center px-8 py-2 bg-yellow-600 cursor-pointer text-white rounded shadow-lg shadow-black/50 transition duration-200 hover:bg-yellow-700 max-[768px]:px-15"
                            :class="{
                                'opacity-50 cursor-progress': @json($loadingEdit),
                            }">


                            @if ($loadingEdit)
                                <span class="flex justify-center">
                                    <svg class="mr-1 animate-spin" xmlns="http://www.w3.org/2000/svg" height="24px"
                                        viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                        <path
                                            d="M480-80q-83 0-156-31.5t-127-86Q143-252 111.5-325T80-480q0-157 104-270t256-128v120q-103 14-171.5 92.5T200-480q0 116 82 198t198 82q66 0 123.5-28t96.5-76l104 60q-54 75-139 119.5T480-80Zm366-238-104-60q9-24 13.5-49.5T760-480q0-107-68.5-185.5T520-758v-120q152 15 256 128t104 270q0 44-8 85t-26 77Z" />
                                    </svg>
                                    Guardando cambios<p class="font-bold">...</p>
                                </span>
                            @else
                                <span wire:loading.remove wire:target="save">
                                    <div class="flex justify-center">
                                        Editar
                                        <svg class="ml-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                            <path
                                                d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                        </svg>

                                    </div>
                                </span>
                            @endif



                        </button>
                    </div>
                </footer>
            </form>

        </div>

    </div>
    <!--MODAL-->
    <span>
        @livewire('dashboard.modal.personas.usuarios.edit-confirm-usuarios')
    </span>

</div>
