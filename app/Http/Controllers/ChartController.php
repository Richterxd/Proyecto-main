<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getData(){
        $dates = [
            'chart1' => [
                'canvasId' => 'chart1',
                'labels' => ['Pendientes', 'Aprobadas', 'Rechazadas', 'Asignadas'],
                'values' => [50, 19, 3, 5],
                'tipo' => 'bar',
                'titulo' => 'Mayor Porcentaje'
            ],
            'chart2' => [
                'canvasId' => 'chart2',
                'labels' => ['Enero', 'Febrero', 'Marzo', 'Abril'],
                'values' => [100, 19, 3, 5],
                'tipo' => 'pie',
                'titulo' => 'pepin'
            ],
            'chart3' => [
                'canvasId' => 'chart3',
                'labels' => ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
                'values' => [5, 5, 3, 5, 2, 3],
                'titulo' => 'Historial de Pendientes',
                'tipo' => 'bar',
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'bgColor' => 'rgba(255, 99, 132, 0.2)'
            ]
        ];

        return response()->json($dates);
    }
}
