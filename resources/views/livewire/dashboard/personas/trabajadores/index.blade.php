@section('title', 'Personas')
@section('subTitle', '// Trabajadores')
<div class="m-auto ml-5 mb-5 mr-5 p-10 max-[768px]:m-1 max-[768px]:p-4">
    <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6 border-4 border-orange-300">
        <div class="flex justify-between items-center mb-4">
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Buscar"
                class="px-4 py-2 border rounded-lg w-1/3 focus:outline-none focus:ring-2 focus:ring-orange-300">
            <a href="{{ route('trabajadores.create') }}" wire:navigate
                class="bg-green-400 hover:bg-green-500 text-white font-semibold px-4 py-2 rounded shadow">Añadir
                <span class="ml-1">➕</span></a>
        </div>

        @if (session('success'))
            <div class="mb-4 text-green-700 font-medium bg-green-100 border border-green-300 rounded p-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full border border-orange-300 rounded-lg shadow">
                <thead class="bg-orange-300 text-gray-800 font-semibold text-sm uppercase">
                    <tr>
                        <th class="px-4 py-2 text-left">Nombre y Apellido</th>
                        <th class="px-4 py-2 text-left">Cédula</th>
                        <th class="px-4 py-2 text-left">Teléfono</th>
                        <th class="px-4 py-2 text-left">Correo</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50 divide-y divide-gray-200 text-sm">
                    @foreach ($trabajadores as $trabajador)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $trabajador->nombres }} {{ $trabajador->apellidos }}</td>
                            <td class="px-4 py-2">{{ $trabajador->nacionalidad }}-{{ $trabajador->cedula }}</td>
                            <td class="px-4 py-2">{{ $trabajador->telefono }}</td>
                            <td class="px-4 py-2">{{ $trabajador->correo }}</td>
                            <td class="px-4 py-2 flex flex-wrap gap-1">
                                <a href="#"
                                    class="bg-red-600 text-white px-2 py-1 rounded shadow hover:bg-red-700 text-xs">📄
                                    PDF</a>
                                <a href="{{ route('trabajadores.show', $trabajador) }}" wire:navigate
                                    class="bg-gray-700 text-white px-2 py-1 rounded shadow hover:bg-gray-800 text-xs">👁
                                    Info</a>
                                <a href="{{ route('trabajadores.edit', $trabajador) }}" wire:navigate
                                    class="bg-yellow-300 text-black px-2 py-1 rounded shadow hover:bg-yellow-400 text-xs">✏️
                                    Editar</a>
                                <form action="{{ route('trabajadores.destroy', $trabajador) }}" method="POST"
                                    class="inline-block">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('¿Eliminar trabajador?')"
                                        class="bg-pink-200 text-black px-2 py-1 rounded shadow hover:bg-pink-300 text-xs">❌
                                        Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
