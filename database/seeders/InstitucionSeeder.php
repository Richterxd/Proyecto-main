<?php

namespace Database\Seeders;

use App\Models\Institucion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instituciones = [
            ['titulo' => 'Alcaldía de Bruzual', 'descripcion' => 'Gobierno municipal principal'],
            ['titulo' => 'Consejo Municipal', 'descripcion' => 'Órgano legislativo municipal'],
            ['titulo' => 'Contraloría Municipal', 'descripcion' => 'Control fiscal municipal'],
            ['titulo' => 'Dirección de Obras Públicas', 'descripcion' => 'Infraestructura y construcción'],
            ['titulo' => 'Dirección de Servicios Públicos', 'descripcion' => 'Agua, electricidad, aseo urbano'],
            ['titulo' => 'Instituto Municipal de Cultura', 'descripcion' => 'Promoción cultural municipal'],
            ['titulo' => 'Instituto Municipal de Deportes', 'descripcion' => 'Desarrollo deportivo municipal'],
        ];

        foreach ($instituciones as $institucion) {
            Institucion::updateOrCreate(
                ['titulo' => $institucion['titulo']],
                $institucion
            );
        }
    }
}