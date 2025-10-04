<?php

namespace Database\Seeders;

use App\Models\Solicitud;
use App\Models\Visita;
use App\Models\Ambito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ambitos = Ambito::all();
        
        // Create sample solicitudes
        $solicitudes = [
            [
                'titulo' => 'Reparación de calle dañada',
                'descripcion' => 'Solicito la reparación de la calle principal del sector que presenta huecos y deterioro.',
                'estado' => 'Pendiente',
                'personas_cedula' => 11223344,
                'ambito_id' => $ambitos->where('titulo', 'Infraestructura')->first()->id ?? 1,
            ],
            [
                'titulo' => 'Mejora del servicio de agua',
                'descripcion' => 'El servicio de agua es irregular en nuestro sector, necesitamos mejoras.',
                'estado' => 'Pendiente',
                'personas_cedula' => 11223344,
                'ambito_id' => $ambitos->where('titulo', 'Servicios Públicos')->first()->id ?? 1,
            ],
            [
                'titulo' => 'Instalación de alumbrado público',
                'descripcion' => 'Solicito la instalación de alumbrado público en la calle secundaria.',
                'estado' => 'Aprobada',
                'personas_cedula' => 11223344,
                'ambito_id' => $ambitos->where('titulo', 'Infraestructura')->first()->id ?? 1,
            ],
        ];

        foreach ($solicitudes as $solicitud) {
            Solicitud::create($solicitud);
        }

        // Create sample visitas
        $visitas = [
            [
                'titulo' => 'Inspección de daños en calle',
                'descripcion' => 'Visita para evaluar los daños en la calle principal.',
                'fecha' => now()->addDays(3),
                'estado' => 'Programada',
                'personas_cedula' => 11223344,
                'ambito_id' => $ambitos->where('titulo', 'Infraestructura')->first()->id ?? 1,
            ],
            [
                'titulo' => 'Evaluación del sistema de agua',
                'descripcion' => 'Visita técnica para evaluar el sistema de distribución de agua.',
                'fecha' => now()->addDays(5),
                'estado' => 'Programada',
                'personas_cedula' => 11223344,
                'ambito_id' => $ambitos->where('titulo', 'Servicios Públicos')->first()->id ?? 1,
            ],
        ];

        foreach ($visitas as $visita) {
            Visita::create($visita);
        }
    }
}