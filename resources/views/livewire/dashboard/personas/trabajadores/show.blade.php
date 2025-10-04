<x-layouts.app>
    @section('title', 'Personas')
    @section('subTitle', '// Trabajadores > Información')
    <div>
        <style>
            label {
                font-weight: bold;
                display: block;
                margin-top: 10px;
            }

            p {
                margin-bottom: 5px;
            }
        </style>
        <div class="w-full mt-5 mx-auto max-w-3xl bg-white rounded-lg shadow-lg p-8 border-t-8 border-zinc-600">
            <div class="mb-5">
                <label>Nombres:</label>
                <p>{{ $trabajador->nombres }}</p>

                <label>Apellidos:</label>
                <p>{{ $trabajador->apellidos }}</p>

                <label>Nacionalidad y Cédula:</label>
                <p>{{ $trabajador->nacionalidad }}-{{ $trabajador->cedula }}</p>

                <label>Fecha de Nacimiento:</label>
                <p>{{ $trabajador->fecha_nacimiento }}</p>

                <label>Teléfono:</label>
                <p>{{ $trabajador->telefono }}</p>

                <label>Correo:</label>
                <p>{{ $trabajador->correo }}</p>

                <label>Dirección:</label>
                <p>{{ $trabajador->direccion }}</p>

                <label>Zona de Trabajo:</label>
                <p>{{ $trabajador->zona_trabajo }}</p>

                <label>Cantidad de Hijos:</label>
                <p>{{ $trabajador->cantidad_hijos }}</p>
            </div>


            <a href="{{ route('trabajador.indexDos') }}"
                class="bg-rose-400 mt-5 text-white font-semibold px-3 py-3 rounded hover:bg-rose-500 transition"
                wire:navigate>⬅
                Volver</a>
        </div>
    </div>
</x-layouts.app>
