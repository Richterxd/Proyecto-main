<x-layouts.app>
    @section('title', 'Personas')
    @section('subTitle', '// Trabajadores > Nuevo Trabajador')
    <div class="my-5 mx-auto p-10">
        <div class="w-full mx-auto max-w-3xl bg-white rounded-lg shadow-lg p-8 border-t-8 border-green-600">
            <!--MENSJAES DE ERROR-->
            @if ($errors->any())
                <div class="bg-rose-500/20 rounded-md p-2 mb-5">
                    <ul class="list-disc">
                        @foreach ($errors->all() as $error)
                            <li class="ml-5 text-zinc-800">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('trabajadores.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold">Nombre</label>
                        <input type="text" name="nombres" value="{{ old('nombres') }}"
                            placeholder="Ejem.: Juan Pablo" class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2"
                            required>
                    </div>
                    <div>
                        <label class="block font-semibold">Apellido</label>
                        <input type="text" name="apellidos" value="{{ old('apellidos') }}"
                            placeholder="Ejem.: Chaviel Lopez"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block font-semibold">Cédula de Identidad</label>
                        <div class="flex gap-2">
                            <select name="nacionalidad" class="w-1/4 rounded border-gray-300 bg-gray-100 px-2">
                                <option value="V">V</option>
                                <option value="E">E</option>
                            </select>
                            <input type="text" name="cedula" value="{{ old('cedula') }}"
                                placeholder="Ejem.: 12345678"
                                class="w-3/4 rounded border-gray-300 bg-gray-100 px-3 py-2" required>
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                            placeholder="dd/mm/aaaa" class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2"
                            required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-semibold">Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}"
                            placeholder="Ingrese la dirección donde reside"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block font-semibold">Zona de Trabajo</label>
                        <input type="text" name="zona_trabajo" value="{{ old('zona_trabajo') }}"
                            placeholder="Ejem.: Área de Atención"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block font-semibold">Correo</label>
                        <input type="email" name="correo" value="{{ old('correo') }}"
                            placeholder="Ejem.: juan33@gmail.com"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block font-semibold">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}"
                            placeholder="Ejem.: 04160000000"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block font-semibold">Cantidad de Hijos</label>
                        <input type="number" name="cantidad_hijos" value="{{ old('cantidad_hijos') }}" min="0"
                            value="0" class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2" required>
                    </div>
                </div>

                <div class="text-center pt-4">
                    <a href="{{ route('trabajador.indexDos') }}"
                        class="bg-rose-400 mr-4 text-white font-semibold px-3 py-3 rounded hover:bg-rose-500 transition"
                        wire:navigate>⬅
                        Volver</a>
                    <button type="submit"
                        class="bg-green-400 text-white font-semibold px-6 py-2 rounded hover:bg-green-500 transition">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
