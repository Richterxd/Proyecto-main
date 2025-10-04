<x-layouts.app>
    @section('title', 'Personas')
    @section('subTitle', '// Trabajadores > Editar Trabajador')
    <div class="m-5">
        <style>
            label {
                display: block;
                margin-top: 10px;
            }

            input,
            select,
            textarea {
                width: 100%;
                padding: 5px;
                border-radius: 5px;
            }
        </style>
        <div class="w-full mx-auto max-w-3xl bg-white rounded-lg shadow-lg p-8 border-t-8 border-blue-600">
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
            <form action="{{ route('trabajadores.update', $trabajador) }}" method="POST">

                @csrf
                @method('PUT')
                <!-- campos -->


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label>Nombres: <input type="text" name="nombres"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2"
                            value="{{ old('nombres', $trabajador->nombres) }}" required></label>
                    <label>Apellidos: <input type="text" name="apellidos"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2"
                            value="{{ old('nombres', $trabajador->apellidos) }}" required></label>
                    <label>Nacionalidad:
                        <select name="nacionalidad" class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2">
                            <option value="V" {{ $trabajador->nacionalidad == 'V' ? 'selected' : '' }}>V</option>
                            <option value="E" {{ $trabajador->nacionalidad == 'E' ? 'selected' : '' }}>E</option>
                        </select>
                    </label>
                    <label>Cédula: <input type="text" name="cedula"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2"
                            value="{{ old('nombres', $trabajador->cedula) }}"></label>
                    <label>Fecha de Nacimiento: <input type="date"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2" name="fecha_nacimiento"
                            value="{{ old('nombres', $trabajador->fecha_nacimiento) }}"></label>
                    <label>Teléfono: <input type="text" name="telefono"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2"
                            value="{{ old('nombres', $trabajador->telefono) }}"></label>
                    <label>Correo: <input type="email" name="correo"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2"
                            value="{{ old('nombres', $trabajador->correo) }}"></label>
                    <label>Dirección:
                        <textarea name="direccion" class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2">{{ $trabajador->direccion }}</textarea>
                    </label>
                    <label>Zona de Trabajo: <input type="text" name="zona_trabajo"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2"
                            value="{{ old('nombres', $trabajador->zona_trabajo) }}"></label>
                    <label>Cantidad de Hijos: <input type="number" name="cantidad_hijos"
                            class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2"
                            value="{{ old('nombres', $trabajador->cantidad_hijos) }}"></label>
                </div>
                <div class="flex mt-5">
                    <a href="{{ route('trabajador.indexDos') }}"
                        class="bg-rose-400 mr-4 text-white font-semibold px-3 py-3 rounded hover:bg-rose-500 transition"
                        wire:navigate>⬅
                        Volver</a>
                    <button type="submit"
                        class="bg-blue-400 mr-4 text-white font-semibold px-3 py-3 rounded hover:bg-blue-500 transition">Actualizar</button>
                </div>
            </form>
        </div>

    </div>
</x-layouts.app>
