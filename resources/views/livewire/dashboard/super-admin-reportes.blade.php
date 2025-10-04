<div class="min-h-screen bg-gray-50">
  <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center py-6">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class='bx bx-bar-chart text-xl text-white'></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Gestión de Reportes</h1>
                            <p class="text-sm text-gray-600">Sistema Municipal CMBEY</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
  
  {{-- BOTONES SUPERIORES --}}
  <div class="bg-gray-100/50 shadow-sm border-b border-gray-200 px-2 py-3" x-data="{active: 0}">
    <div class="w-full flex px-2 gap-4 space-x-4 max-lg:grid max-lg:grid-cols-2">
      <button class="w-full py-4 text-center max-sm:text-sm border border-zinc-100 border-2 rounded"
      wire:click="cambiarVista(0)" @click="active = 0"
      :class="{
          'bg-blue-500 text-white border-none scale-105 shadow-xl': active == 0,
          'bg-white text-gray-600 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-transparent hover:border-blue-500': active > 0
      }">Solicitudes</button>
      <button class="w-full py-4 text-center max-sm:text-sm border border-zinc-100 bg-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 rounded border-transparent hover:border-blue-500"
      wire:click="cambiarVista(1)" @click="active = 1"
      :class="{
          'bg-blue-500 text-white border-none scale-105 shadow-xl': active == 1,
          'bg-white text-gray-600 border border-zinc-100 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-transparent hover:border-blue-500': active != 1
      }">Mayores Problematicas</button>
      <button class="w-full py-4 text-center max-sm:text-sm border border-zinc-100 bg-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 rounded border-transparent hover:border-blue-500"
      wire:click="cambiarVista(2)" @click="active = 2"
      :class="{
          'bg-blue-500 text-white border-none scale-105 shadow-xl': active == 2,
          'bg-white text-gray-600 border border-zinc-100 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-transparent hover:border-blue-500': active != 2
      }">Reuniones y Visitas</button>
      <button class="w-full py-4 text-center max-sm:text-sm border border-zinc-100 bg-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 rounded border-transparent hover:border-blue-500"
      wire:click="cambiarVista(3)" @click="active = 3"
      :class="{
          'bg-blue-500 text-white border-none scale-105 shadow-xl': active == 3,
          'bg-white text-gray-600 border border-zinc-100 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-transparent hover:border-blue-500': active != 3
      }">Usuarios</button>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6" x-data="{ showChart1: true }">

    {{-- REPORTES DE SOLICITUDES --}}
    @if ($showVista === 0)
      {{-- GRAFICA SOLICITUDES 1 --}}
      <div class="relative w-full overflow-hidden">
        <div x-show="showChart1" x-init="$wire.dispatch('refreshChart1')"
        x-transition:enter="transition ease-out duration-700 transform"
        x-transition:enter-start="opacity-0 -translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200 transform absolute top-0 left-0 w-full"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-full"
        class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mt-6">
          <div class="flex flex-col max-lg:flex-col">

            {{----}}
            <div class="flex justify-between max-lg:flex-col">
              <h2 class="text-3xl ml-7 my-auto font-bold text-gray-900 max-lg:ml-0 max-lg:text-center">Reporte de Solicitudes</h2>
              <div class="flex gap-2 max-lg:flex-col">
                <p class="lg:hidden mt-3 text-black/50 text-center">Filtros</p>
                    <div class="flex gap-2 max-lg:justify-center">
                      <button class="w-30 max-lg:w-26 h-13 text-center text-black/50 rounded-md text-sm border border-zinc-300 bg-white shadow-md hover:shadow-lg transition-all duration-300 transform hover:bg-zinc-100 border-2"
                      wire:click="updateChart1(0)">
                        <div class="flex items-center place-content-center">
                          <i class='bx bx-bar-chart text-2xl text-black/50'></i>
                          <span class="max-lg:hidden">Todo</span>
                        </div>
                      </button>
                      <button class="w-30 max-lg:w-26 h-13 text-black/50 rounded-md text-sm border border-yellow-300 bg-yellow-100 shadow-md hover:shadow-lg transition-all duration-300 transform hover:bg-yellow-200 border-2"
                      wire:click="updateChart1(1)">
                        <div class="flex items-center place-content-center">
                          <i class='bx bx-time-five text-2xl text-yellow-500'></i>
                          <span class="max-lg:hidden">Pendientes</span>
                        </div>
                      </button>
                      <button class="w-30 max-lg:w-26 h-13 text-center text-black/50 rounded-md text-sm border border-green-300 bg-green-100 shadow-md hover:shadow-lg transition-all duration-300 transform hover:bg-green-200 border-2"
                      wire:click="updateChart1(2)">
                        <div class="flex items-center place-content-center">
                          <i class='bx bx-check-circle text-2xl text-green-500'></i>
                          <span class="max-lg:hidden">Aprobradas</span>
                        </div>
                      </button>
                    </div>
                    <div class="flex gap-2 max-lg:justify-center">
                      <button class="w-30 max-lg:w-26 h-13 text-center text-black/50 rounded-md text-sm border border-red-300 bg-pink-100 shadow-md hover:shadow-lg transition-all duration-300 transform hover:bg-pink-200 border-2"
                      wire:click="updateChart1(3)">
                        <div class="flex items-center place-content-center">
                          <i class='bx bx-x-circle text-2xl text-red-500'></i>
                          <span class="max-lg:hidden">Rechazadas</span>
                        </div>
                      </button>
                      <button class="w-30 max-lg:w-26 h-13 text-center text-black/50 rounded-md text-sm border border-blue-300 bg-blue-100 shadow-md hover:shadow-lg transition-all duration-300 transform hover:bg-blue-200 border-2"
                      wire:click="updateChart1(4)">
                        <div class="flex items-center place-content-center">
                          <i class='bx bx-user-plus text-2xl text-blue-500'></i>
                          <span class="max-lg:hidden">Asignadas</span>
                        </div>
                      </button>
                    </div>
              </div>
            </div>

          {{----}}
          <div class="w-full flex flex-col mx-auto ">
            <div class="w-auto my-5 grid grid-cols-4 gap-2 justify-center max-lg:grid-cols-2">
              <div class="flex flex-col py-3 items-center border border-zinc-100 bg-white shadow-sm border-2 rounded border-transparent">
                    <div class="my-auto">    
                      <div class="flex flex-col items-center text-center">
                        <i class='bx bx-time-five text-3xl text-yellow-500'></i>
                        <p class="text-zinc-800">Total Pendientes</p>
                      </div>
                      <h3 class="text-2xl font-bold text-center">{{ $solicitudes->where('estado_detallado', 'Pendiente')->count()}}</h3>
                    </div>
              </div>
              <div class="flex flex-col items-center border border-zinc-100 bg-white shadow-sm border-2 rounded border-transparent">
                    <div class="my-auto">    
                      <div class="flex flex-col items-center text-center">
                        <i class='bx bx-check-circle text-3xl text-green-400'></i>
                        <p class="text-zinc-800">Total Aprobadas</p>
                      </div>
                      <h3 class="text-2xl font-bold text-center">{{ $solicitudes->where('estado_detallado', 'Aprobada')->count()}}</h3>
                    </div>
              </div>
              <div class="flex flex-col items-center border border-zinc-100 bg-white shadow-sm border-2 rounded border-transparent">
                    <div class="my-auto">    
                      <div class="flex flex-col items-center text-center">
                        <i class='bx bx-x-circle text-3xl text-red-400'></i>
                        <p class="text-zinc-800">Total Rechazadas</p>
                      </div>
                      <h3 class="text-2xl font-bold text-center">{{ $solicitudes->where('estado_detallado', 'Rechazada')->count()}}</h3>
                    </div>
              </div>
              <div class="flex flex-col items-center border border-zinc-100 bg-white shadow-sm border-2 rounded border-transparent">
                    <div class="my-auto">    
                      <div class="flex flex-col items-center text-center">
                        <i class='bx bx-user-plus text-3xl text-blue-400'></i>
                        <p class="text-zinc-800">Total Asignadas</p>
                      </div>
                      <h3 class="text-2xl font-bold text-center">{{ $solicitudes->where('estado_detallado', 'Asignada')->count()}}</h3>
                    </div>
              </div>
            </div>
            {{--CHART1--}}
            <div class="mx-auto w-200 max-lg:w-full" wire:ignore>
              <canvas id="chart1"></canvas>
              <div class="flex">
                <div class="relative w-40 ml-3">
                  <select class="block w-full appearance-none bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                  wire:model.live="selectedPeriod">
                    <option value="today">Hoy</option>
                    <option value="last_7_days">Últimos 7 días</option>
                    <option value="last_30_days">Últimos 30 días</option>
                    <option value="this_month">Este mes</option>
                    <option value="this_year">Este año</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <i class='bx bx-chevron-down'></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex justify-end mt-3 gap-4">
          <button @click="showChart1 = true"
              class="w-10 h-10 rounded-3xl shadow-md text-white font-bold transition duration-300 flex items-center justify-center"
              :class="{ 'bg-blue-600 hover:bg-blue-700 hover:shadow-blue-900': !showChart1, 'bg-gray-400': showChart1 }">
              <i class='bx bx-caret-left text-3xl'></i>
          </button>
          <button @click="showChart1 = false"
              class="w-10 h-10 rounded-3xl shadow-md text-white font-bold transition duration-300 flex items-center justify-center"
              :class="{ 'bg-blue-600 hover:bg-blue-700 hover:shadow-blue-900': showChart1, 'bg-gray-400': !showChart1 }">
              <i class='bx bx-caret-right text-3xl'></i>
          </button>
        </div>
      </div>
      
      {{-- GRAFICA SOLICITUDES 2 --}}
      <div x-show="!showChart1" x-init="$wire.dispatch('refreshChart2')"
      x-transition:enter="transition ease-out duration-700 transform"
      x-transition:enter-start="opacity-0 translate-x-full"
      x-transition:enter-end="opacity-100 translate-x-0"
      x-transition:leave="transition ease-in duration-200 transform absolute top-0 left-0 w-full"
      x-transition:leave-start="opacity-100 translate-x-0"
      x-transition:leave-end="opacity-0 translate-x-full"
      class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mt-6">
        <div class="w-full">
          {{-- CHART2 --}}
          <div class="w-full px-10 max-lg:px-5">
            <h2 class="text-lg ml-7 my-5 font-bold text-gray-900 max-lg:mx-auto max-lg:text-center">Historial de Solicitudes</h2>
            <canvas class="mx-auto w-200 max-lg:w-full" id="chart2"></canvas>
          </div>
          <div class="relative w-40 ml-9">
            <select class="block w-full appearance-none bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
              wire:model.live="selectedPeriodChart2">
              <option value="today">Hoy</option>
              <option value="last_7_days">Últimos 7 días</option>
              <option value="last_30_days">Últimos 30 días</option>
              <option value="this_month">Este mes</option>
              <option value="this_year">Este año</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
              <i class='bx bx-chevron-down'></i>
            </div>
          </div>
        </div>
        <div class="flex justify-end mt-3 gap-4">
          <button @click="showChart1 = true"
              class="w-10 h-10 rounded-3xl shadow-md text-white font-bold transition duration-300 flex items-center justify-center"
              :class="{ 'bg-blue-600 hover:bg-blue-700 hover:shadow-blue-900': !showChart1, 'bg-gray-400': showChart1 }">
              <i class='bx bx-caret-left text-3xl'></i>
          </button>
          <button @click="showChart1 = false"
              class="w-10 h-10 rounded-3xl shadow-md text-white font-bold transition duration-300 flex items-center justify-center"
              :class="{ 'bg-blue-600 hover:bg-blue-700': showChart1, 'bg-gray-400': !showChart1 }">
              <i class='bx bx-caret-right text-3xl'></i>
          </button>
        </div>

    @endif

    {{-- REPORTES DE VISITAS --}}
    @if ($showVista === 1)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mt-6">
          <div wire:ignore class="w-full px-10 max-lg:px-5">
            <h2 class="text-lg ml-7 my-5 font-bold text-gray-900 max-lg:mx-auto max-lg:text-center">Historial de Visitas</h2>
            <canvas class="mx-auto w-full" id="chartVisitas"></canvas>
          </div>
        </div>
    @endif
    </div>
    
  </div>
</div>
