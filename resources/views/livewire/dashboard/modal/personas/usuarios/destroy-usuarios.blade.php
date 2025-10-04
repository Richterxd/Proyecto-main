<div id="{{ $persona->cedula }}-modal-destroy-usuarios">

    <div x-data="{ showModalDestroy: @entangle('showModalDestroy') }" x-show="showModalDestroy" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600/40 overflow-auto flex items-center justify-center z-50" style="display: none;">
        <div x-show="showModalDestroy" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-gradient-to-r from-rose-700 to-red-800 rounded-xl max-w-2xl w-full m-auto">

            <header class="">
                <div class="w-full flex justify-end pr-5 pt-5 pb-2">
                    <button wire:click="closeModalDestroy"
                        class="relative flex justify-center text-white font-bold p-2 px-3 bg-red-600 rounded cursor-pointer transition duration-200 hover:bg-red-800">
                        Cerrar
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#FFFFFF">
                            <path
                                d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                        </svg>
                    </button>
                </div>


                <div
                    class="text-center px-3 text-white bg-red-400 w-150 h-auto rounded-xl py-2 mx-auto font-extrabold text-4xl my-2 max-[768px]:w-auto">
                    <h2>¿Estas seguro de eliminar a {{ $persona->nombre }} {{ $persona->segundo_nombre }}
                        {{ $persona->apellido }} {{ $persona->segundo_apellido }}?</h2>
                    <h4 class="text-2xl font-bold text-">Este acción es permanente</h4>
                </div>



            </header>


            <!--   CONTENIDO PRINCIPAL-->
            <div class="block bg-white text-center rounded-md shadow-lg px-5 py-8 mx-15 my-5">

                <div class="w-full my-4 flex flex-col-reverse">
                    <input id="password-input-destroy" type="password" wire:model.defer="passwordDestroy"
                        placeholder="Ingrese su contraseña"
                        class="bg-gray-200 mx-auto mt-3 outline-none border-1 border-gray-600 text-lg w-100 p-1 pl-2 inset-shadow-sm rounded text-zinc-900 max-[768px]:w-full focus:border-cyan-500 peer">
                    <label for="password-input-destroy" class="font-bold text-zinc-700 text-lg">Para realizar esta
                        accion
                        debe
                        ingresar su
                        contraseña</label>
                </div>

            </div>

            <!--FOOTER-->
            <footer class="mt-3 mb-6 mx-5 max-[768px]:my-6">
                <div class="flex justify-center space-x-2 max-[768px]:justify-center">
                    <button wire:click="destroy({{ $persona->cedula }})" wire:loading.attr="disabled"
                        wire:target="destroy" title="Eliminar Usuario"
                        class="disabled:opacity-50 disabled:cursor-progress flex justify-center px-8 py-2 bg-red-600 cursor-pointer text-white rounded shadow-lg shadow-black/50 transition duration-200 hover:bg-red-700 max-[768px]:px-15">

                        <span wire:loading.remove wire:target="destroy">
                            <div class="flex justify-center">
                                Eliminar Usuario
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#FFFFFF">
                                    <path
                                        d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z" />
                                </svg>

                            </div>
                        </span>

                        <span wire:loading.flex wire:target="destroy" class="flex justify-center">
                            <svg class="mr-1 animate-spin" xmlns="http://www.w3.org/2000/svg" height="24px"
                                viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                <path
                                    d="M480-80q-83 0-156-31.5t-127-86Q143-252 111.5-325T80-480q0-157 104-270t256-128v120q-103 14-171.5 92.5T200-480q0 116 82 198t198 82q66 0 123.5-28t96.5-76l104 60q-54 75-139 119.5T480-80Zm366-238-104-60q9-24 13.5-49.5T760-480q0-107-68.5-185.5T520-758v-120q152 15 256 128t104 270q0 44-8 85t-26 77Z" />
                            </svg>
                            Eliminando Usuario<p class="font-bold">...</p>
                        </span>
                    </button>
                </div>
            </footer>

        </div>

    </div>

</div>
