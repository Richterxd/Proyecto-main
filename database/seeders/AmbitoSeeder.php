<?php

namespace Database\Seeders;

use App\Models\Ambito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmbitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ambitos = [
            // Original ambitos - keep for backward compatibility
            ['titulo' => 'Servicios Públicos', 'descripcion' => 'Agua, electricidad, saneamiento'],
            ['titulo' => 'Infraestructura', 'descripcion' => 'Calles, veredas, alumbrado público'],
            ['titulo' => 'Educación', 'descripcion' => 'Escuelas, programas educativos'],
            ['titulo' => 'Salud', 'descripcion' => 'Centros de salud, programas sanitarios'],
            ['titulo' => 'Deportes y Recreación', 'descripcion' => 'Instalaciones deportivas, actividades recreativas'],
            ['titulo' => 'Cultura', 'descripcion' => 'Eventos culturales, preservación patrimonio'],
            ['titulo' => 'Medio Ambiente', 'descripcion' => 'Conservación, limpieza urbana'],
            ['titulo' => 'Seguridad', 'descripcion' => 'Policía municipal, prevención'],
            
            // New enhanced categories
            ['titulo' => 'Servicios - Agua', 'descripcion' => 'Solicitudes relacionadas con suministro de agua'],
            ['titulo' => 'Servicios - Electricidad', 'descripcion' => 'Solicitudes relacionadas con suministro eléctrico'],
            ['titulo' => 'Servicios - Telecomunicaciones', 'descripcion' => 'Solicitudes relacionadas con telecomunicaciones'],
            ['titulo' => 'Servicios - Gas Comunal', 'descripcion' => 'Solicitudes relacionadas con gas comunal'],
            ['titulo' => 'Servicios - Gas Directo por Tubería', 'descripcion' => 'Solicitudes relacionadas con gas directo por tubería'],
            
            ['titulo' => 'Social - Educación Inicial', 'descripcion' => 'Solicitudes relacionadas con educación inicial'],
            ['titulo' => 'Social - Educación Básica', 'descripcion' => 'Solicitudes relacionadas con educación básica'],
            ['titulo' => 'Social - Educación Secundaria', 'descripcion' => 'Solicitudes relacionadas con educación secundaria'],
            ['titulo' => 'Social - Educación Universitaria', 'descripcion' => 'Solicitudes relacionadas con educación universitaria'],
            
            ['titulo' => 'Sucesos Naturales - Huracanes', 'descripcion' => 'Solicitudes relacionadas con huracanes'],
            ['titulo' => 'Sucesos Naturales - Tormentas Tropicales', 'descripcion' => 'Solicitudes relacionadas con tormentas tropicales'],
            ['titulo' => 'Sucesos Naturales - Terremotos', 'descripcion' => 'Solicitudes relacionadas con terremotos'],
        ];

        foreach ($ambitos as $ambito) {
            Ambito::updateOrCreate(
                ['titulo' => $ambito['titulo']],
                $ambito
            );
        }
    }
}