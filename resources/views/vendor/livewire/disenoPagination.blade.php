<div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-4 sm:space-y-0">
    <div class="text-sm text-gray-700">
        Mostrando <span class="font-medium">{{ $paginator->firstItem() }}</span> a <span class="font-medium">{{ $paginator->lastItem() }}</span> de <span class="font-medium">{{ $paginator->total() }}</span> resultados
    </div>

    <div role="navigation" aria-label="Pagination Navigation" class="flex items-center space-x-2">
        {{-- Botón Anterior --}}
        @if ($paginator->onFirstPage())
            {{-- Clase 'disabled' --}}
        @else
            <button wire:click="previousPage" rel="prev" ...
                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Anterior</button>
        @endif

        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button aria-current="page" class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm font-medium">{{ $page }}</button>
                    @else
                        <button wire:click="gotoPage({{ $page }})"
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">{{ $page }}</button>

                    @endif
                @endforeach
            @endif
        @endforeach
        
        {{-- Botón Siguiente --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" rel="next" ...
                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Siguiente</button>
        @else
            {{-- Clase 'disabled' --}}
        @endif
    </div>
</div>