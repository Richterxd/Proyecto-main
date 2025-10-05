<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reunion;
use App\Models\Solicitud;
use App\Models\Institucion;
use App\Models\Personas;
use App\Models\Asisten;

class ReunionesSeeder extends Seeder
{
    public function run(): void
    {
        // Get some existing data
        $solicitudes = Solicitud::limit(3)->get();
        $instituciones = Institucion::all();
        $personas = Personas::limit(10)->get();

        // Create sample reuniones
        $reuniones = [
            [
                'titulo' => 'Reunión de Seguimiento - Servicio de Agua Potable',
                'descripcion' => 'Reunión para evaluar el progreso de las gestiones realizadas para mejorar el servicio de agua potable en la comunidad El Progreso. Se discutieron los avances técnicos y se establecieron nuevos plazos de ejecución.',
                'fecha_reunion' => now()->addDays(rand(1, 30)),
                'ubicacion' => 'Oficinas del CMBEY - Sala de Conferencias',
                'institucion_id' => $instituciones->first()->id,
                'solicitud_id' => $solicitudes->first()->solicitud_id ?? null,
            ],
            [
                'titulo' => 'Mesa de Trabajo - Educación Básica Regional',
                'descripcion' => 'Mesa de trabajo para abordar las deficiencias en infraestructura educativa reportadas en las solicitudes ciudadanas. Participaron representantes de la Zona Educativa y directores de las instituciones afectadas.',
                'fecha_reunion' => now()->addDays(rand(1, 30)),
                'ubicacion' => 'Centro Cultural de Chivacoa',
                'institucion_id' => $instituciones->skip(1)->first()->id ?? $instituciones->first()->id,
                'solicitud_id' => $solicitudes->skip(1)->first()->solicitud_id ?? null,
            ],
            [
                'titulo' => 'Reunión Extraordinaria - Gestión de Emergencias Naturales',
                'descripcion' => 'Reunión extraordinaria para coordinar acciones preventivas ante la temporada de lluvias. Se establecieron protocolos de actuación y se designaron responsables por sector.',
                'fecha_reunion' => now()->subDays(rand(1, 15)),
                'ubicacion' => 'Sala de Crisis - Alcaldía de Bruzual',
                'institucion_id' => $instituciones->last()->id,
                'solicitud_id' => $solicitudes->last()->solicitud_id ?? null,
            ],
            [
                'titulo' => 'Audiencia Pública - Servicios de Telecomunicaciones',
                'descripcion' => 'Audiencia pública para atender las inquietudes ciudadanas sobre la calidad de los servicios de telecomunicaciones en el municipio. Se presentaron estadísticas de conectividad y planes de mejora.',
                'fecha_reunion' => now()->subDays(rand(5, 20)),
                'ubicacion' => 'Auditorio Municipal José Antonio Páez',
                'institucion_id' => $instituciones->first()->id,
                'solicitud_id' => null, // Reunión independiente
            ],
        ];

        foreach ($reuniones as $reunionData) {
            $reunion = Reunion::create($reunionData);

            // Add random attendees (3-6 people per meeting)
            $numAsistentes = rand(3, 6);
            $personasSeleccionadas = $personas->random($numAsistentes);
            
            foreach ($personasSeleccionadas as $index => $persona) {
                $esConsejal = $index < 2; // First 2 attendees are consejales
                
                Asisten::create([
                    'reunion_id' => $reunion->id,
                    'persona_cedula' => $persona->cedula,
                    'es_consejal' => $esConsejal,
                    'rol_asistencia' => $esConsejal ? 'Consejal' : 'Ciudadano',
                ]);
            }
        }

        $this->command->info('Se crearon ' . count($reuniones) . ' reuniones de ejemplo con sus respectivos asistentes.');
    }
}