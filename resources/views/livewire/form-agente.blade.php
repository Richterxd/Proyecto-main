<form id="clientForm">
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
        <input type="text" id="name" name="name"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
        <input type="tel" id="phone" name="phone"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div class="mb-4">
        <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
        <input type="tel" id="cedula" name="cedula"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div class="mb-4">
        <label for="tipo_cliente" class="block text-sm font-medium text-gray-700">Tipo de Cliente</label>
        <select id="tipo_cliente" name="tipo_cliente"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            <option value="" selected disabled>Seleccione un tipo</option>
            <option value="">----</option>
            <option value="">----</option>
        </select>
    </div>
</form>