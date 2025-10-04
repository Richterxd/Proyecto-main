<?php

namespace App\Livewire\Dashboard;

use App\Models\Solicitud;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class SuperAdminReportes extends Component
{
    public $selectedPeriod = 'last_30_days';
    public $selectedPeriodChart2 = 'last_30_days';
    public $chartActive = 0;
    public $solicitudes = 0;
    public $showVista = 0;

    public function loadData()
    {
        $this->solicitudes = Solicitud::orderBy('fecha_creacion', 'desc')
            ->get();
    }

    public function mount()
    {
        $this->loadData();
    }

    /* FILTROS DE LAS GRAFICAS */
    public function updatedSelectedPeriod()
    {
        $this->updateChart();
    }
    public function updatedSelectedPeriodChart2()
    {
        $this->updateChart2();
    }

    #[On('refreshChart1')]
    public function updateChart()
    {
        $datosFiltrados = $this->updateChart1($this->chartActive);
        $this->dispatch('chart-updated', id: 'chart1', datos: $datosFiltrados);
    }

    #[On('refreshChart2')]
    public function updateChart2()
    {
        $datosFiltrados = $this->getDatosChart2($this->selectedPeriodChart2);
        $this->dispatch('chart-updated', id: 'chart2', datos: $datosFiltrados);
    }

    public function updateChart1($chartId)
    {
        $estado = '';
        $titulo = '';
        $colors = [];
        $labels = [];
        $this->chartActive = $chartId;

        switch ($this->selectedPeriod) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                $this->selectedPeriod = 'today';
                break;
            case 'last_7_days':
                $startDate = now()->subDays(7)->startOfDay();
                $endDate = now()->endOfDay();
                $this->selectedPeriod = 'last_7_days';
                break;
            case 'last_30_days':
                $startDate = now()->subDays(30)->startOfDay();
                $endDate = now()->endOfDay();
                $this->selectedPeriod = 'last_30_days';
                break;
            case 'this_month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                $this->selectedPeriod = 'this_month';
                break;
            case 'this_year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                $this->selectedPeriod = 'this_year';
                break;
        }

        switch ($chartId) {
            case 1:
                $estado = 'Pendiente';
                $titulo = 'Fecha con Más Pendientes: ';
                $colors = [
                    'borderColor' => 'rgba(255, 206, 86, 1)',
                    'bgColor' => 'rgba(255, 206, 86, 0.2)'
                ];
                break;
            case 2:
                $estado = 'Aprobada';
                $titulo = 'Fecha con Más Aprobadas: ';
                $colors = [
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'bgColor' => 'rgba(75, 192, 192, 0.2)'
                ];
                
                break;
            case 3:
                $estado = 'Rechazada';
                $titulo = 'Fecha con Más Rechazadas: ';
                $colors = [
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'bgColor' => 'rgba(255, 99, 132, 0.2)'
                ];
                break;
            case 4:
                $estado = 'Asignada';
                $titulo = 'Fecha con Más Asignadas: ';
                $colors = [
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'bgColor' => 'rgba(54, 162, 235, 0.2)'
                ];
                break;
            default:
                $this->chartActive = 0;
                $datosGenerales = $this->getDatosChart1($startDate, $endDate);
                $this->dispatch('chart-updated', id: $datosGenerales['canvasId'], datos: $datosGenerales);
                return;
        }

        $resultados = DB::table('solicitudes')
            ->where('estado_detallado', $estado)
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->select(DB::raw('DATE(fecha_creacion) as fecha'), DB::raw('count(*) as total'))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
        
        $labels = $resultados->pluck('fecha')->toArray();
        $values = $resultados->pluck('total')->toArray();
        
        $data = [
            'canvasId' => 'chart1',
            'labels' => $labels,
            'values' => $values,
            'titulo' => $titulo . (count($labels) > 0 ? $labels[array_search(max($values), $values)] : 'N/A'),
            'tipo' => 'bar',
            'borderColor' => $colors['borderColor'],
            'bgColor' => $colors['bgColor']
        ];
        
        $this->dispatch('chart-updated', id: $data['canvasId'], datos: $data);
    }

    private function getDatosChart1($startDate, $endDate){
        $resultados = DB::table('solicitudes')
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->get();

        $conteoInicial = [
            'Pendiente' => 0,
            'Aprobada' => 0,
            'Rechazada' => 0,
            'Asignada' => 0,
        ];

        $conteoPorEstado = $resultados->mapToGroups(function ($item) {
            return [$item->estado_detallado => 1];
        })->map(function ($group) {
            return $group->count();
        })->toArray();

        $valoresFinales = array_values(array_merge($conteoInicial, $conteoPorEstado));

        $labelsFinales = ['Pendientes', 'Aprobadas', 'Rechazadas', 'Asignadas'];
        
        return [
            'canvasId' => 'chart1',
            'labels' => $labelsFinales,
            'values' => $valoresFinales,
            'tipo' => 'bar',
            'titulo' => 'Mayor Porcentaje',
            'bgColor' => ['rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
            'borderColor' => ['rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
        ];

    }

    private function getDatosChart2($chartType = 'line')
    {
        switch ($this->selectedPeriodChart2) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'last_7_days':
                $startDate = now()->subDays(7)->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'last_30_days':
                $startDate = now()->subDays(30)->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'this_month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'this_year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
        }

        $solicitudes = DB::table('solicitudes')
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->select(DB::raw('DATE(fecha_creacion) as fecha'), DB::raw('count(*) as total'))
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->get();

        $labels = $solicitudes->pluck('fecha')->toArray();
        $values = $solicitudes->pluck('total')->toArray();

        if($chartType == 'today'){
            $chartType = 'bar';
        }else{
            $chartType = 'line';
        }

        return [
            'canvasId' => 'chart2',
            'labels' => $labels,
            'values' => $values,
            'titulo' => 'Fecha con Más Solicitudes Ingresadas: ' . (count($labels) > 0 ? $labels[array_search(max($values), $values)] : 'N/A'),
            'tipo' => $chartType,
            'borderColor' => 'rgba(75, 192, 192, 1)',
            'bgColor' => 'rgba(75, 192, 192, 0.2)',
        ];
    }

    public function cambiarVista($vista)
    {
        $this->showVista = $vista;
        
        $this->dispatch('cambiarVistaEvento');
    }

    #[On('cambiarVistaEvento')]
    public function renderChartVistaEvento(){
        switch($this->showVista){
            case 0:
                $this->updateChart();
                $this->updateChart2();
                break;
            case 1:
                $startDate = now()->subDays(30)->startOfDay();
                $endDate = now()->endOfDay();

                $resultados = DB::table('solicitudes')
                    ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->get();

                $conteoInicial = [
                    'Pendiente' => 0,
                    'Aprobada' => 0,
                    'Rechazada' => 0,
                    'Asignada' => 0,
                ];

                $conteoPorEstado = $resultados->mapToGroups(function ($item) {
                    return [$item->estado_detallado => 1];
                })->map(function ($group) {
                    return $group->count();
                })->toArray();

                $valoresFinales = array_values(array_merge($conteoInicial, $conteoPorEstado));

                $labelsFinales = ['Pendientes', 'Aprobadas', 'Rechazadas', 'Asignadas'];
                
                $data = [
                    'canvasId' => 'chartVisitas',
                    'labels' => $labelsFinales,
                    'values' => $valoresFinales,
                    'tipo' => 'bar',
                    'titulo' => 'Mayor Porcentaje',
                    'bgColor' => ['rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                    'borderColor' => ['rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)']
                    ];

                $this->dispatch('chart-updated', id: 'chartVisitas', datos: $data);
                break;
            case 2:
                break;
            case 3:
                break;
            default:
                break;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.super-admin-reportes')->layout('components.layouts.rbac');
    }
}
