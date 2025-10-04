<div>

    <div x-data="{ showModalEditConfirmation: @entangle('showModalEditConfirmation') }" x-show="showModalEditConfirmation" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600/40 overflow-auto flex items-center justify-center z-50" style="display: none;">
        <div x-show="showModalEditConfirmation" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-gradient-to-r from-zinc-200 to-white rounded-xl max-w-xl w-full m-auto px-3">

            <header class="">


            </header>


            <!--   CONTENIDO PRINCIPAL-->
            <div class="block bg-white rounded-md shadow-lg p-5 mt-3 max-[768px]:text-center">

                <h2 class="font-bold text-xl text-center">¿Seguro que desea editar al usuario?</h2>

                <div class="flex justify-center mt-5 space-x-2 max-[768px]:justify-center">
                    <button wire:click="authEdit" wire:loading.attr="disabled" wire:target="authEdit" title="Confirmar"
                        class="disabled:opacity-50 disabled:cursor-progress flex justify-center px-8 py-2 bg-green-600 cursor-pointer text-white rounded shadow-lg shadow-black/50 transition duration-200 hover:bg-green-700 max-[768px]:px-4">

                        <span wire:loading.remove wire:target="authEdit">
                            <div class="flex justify-center">
                                Confirmar
                                <svg class="ml-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                    viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                    <path
                                        d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                </svg>

                            </div>
                        </span>
                        <span wire:loading.flex wire:target="authEdit" class="flex justify-center">
                            <svg class="mr-1 animate-spin" xmlns="http://www.w3.org/2000/svg" height="24px"
                                viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                <path
                                    d="M480-80q-83 0-156-31.5t-127-86Q143-252 111.5-325T80-480q0-157 104-270t256-128v120q-103 14-171.5 92.5T200-480q0 116 82 198t198 82q66 0 123.5-28t96.5-76l104 60q-54 75-139 119.5T480-80Zm366-238-104-60q9-24 13.5-49.5T760-480q0-107-68.5-185.5T520-758v-120q152 15 256 128t104 270q0 44-8 85t-26 77Z" />
                            </svg>
                            Confirmando<p class="font-bold">...</p>
                        </span>

                    </button>
                    <button wire:click="closeModalEditConfirmation" wire:loading.attr="disabled"
                        wire:target="closeModalEditConfirmation" title="Cancelar"
                        class="disabled:opacity-50 disabled:cursor-progress flex justify-center px-8 py-2 bg-red-600 cursor-pointer text-white rounded shadow-lg shadow-black/50 transition duration-200 hover:bg-red-700 max-[768px]:px-4">

                        <span wire:loading.remove wire:target="closeModalEditConfirmation">
                            <div class="flex justify-center">
                                Cancelar
                                <svg class="ml-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                    viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                    <path
                                        d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                </svg>

                            </div>
                        </span>
                        <span wire:loading.flex wire:target="closeModalEditConfirmation" class="flex justify-center">
                            <svg class="mr-1 animate-spin" xmlns="http://www.w3.org/2000/svg" height="24px"
                                viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                <path
                                    d="M480-80q-83 0-156-31.5t-127-86Q143-252 111.5-325T80-480q0-157 104-270t256-128v120q-103 14-171.5 92.5T200-480q0 116 82 198t198 82q66 0 123.5-28t96.5-76l104 60q-54 75-139 119.5T480-80Zm366-238-104-60q9-24 13.5-49.5T760-480q0-107-68.5-185.5T520-758v-120q152 15 256 128t104 270q0 44-8 85t-26 77Z" />
                            </svg>
                            Cancelando<p class="font-bold">...</p>
                        </span>

                    </button>
                </div>

            </div>

            <!--FOOTER-->
            <footer class="my-3 mx-5 max-[768px]:my-6">

            </footer>

        </div>

    </div>

</div>
