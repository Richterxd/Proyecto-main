<?php

namespace Database\Seeders;

use App\Models\Solicitud;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SolicitudesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Solicitud::updateOrCreate(
            ['solicitud_id' => now()->format('Ymd') . substr(md5(uniqid(rand(), true)), 0, 6)],
            [
                'titulo' => 'Solicitud de agua potable',
                'descripcion' => 'Necesitamos mejorar el suministro de agua en nuestra comunidad.',
                'estado_detallado' => 'Pendiente',
                'persona_cedula' => 1234567,
                'direccion' => 'Calle Falsa 123, Ciudad, País',
                'ambito_id' => 1,
                'derecho_palabra' => true,
                'categoria' => 'servicios',
                'subcategoria' => 'agua',
                'tipo_solicitud' => 'colectivo_institucional',
                'es_colectivo_indigena' => false,
                'nombre_rif_institucion' => 'Comunidad XYZ - J-12345678-9',
                'pais' => 'Venezuela',
                'estado_region' => 'Yaracuy',
                'municipio' => 'Bruzual',
                'parroquia' => 'Parroquia Central',
                'comunidad' => 'Comunidad ABC',
                'direccion_detallada' => 'Calle Falsa 123, Ciudad, País',
                'fecha_creacion' => now(),
            ]
        );

        Solicitud::updateOrCreate(
            ['solicitud_id' => now()->subDays(7)->startOfDay()->format('Ymd') . substr(md5(uniqid(rand(), true)), 0, 6)],
            [
                'titulo' => 'Reparación de carreteras',
                'descripcion' => 'Las carreteras principales están en mal estado y necesitan reparación urgente.',
                'estado_detallado' => 'Pendiente',
                'persona_cedula' => 1234567,
                'direccion' => 'Avenida Siempre Viva 742, Ciudad, País',
                'ambito_id' => 2,
                'derecho_palabra' => false,
                'categoria' => 'servicios',
                'subcategoria' => 'infraestructura',
                'tipo_solicitud' => 'individual',
                'es_colectivo_indigena' => false,
                'nombre_rif_institucion' => null,
                'pais' => 'Venezuela',
                'estado_region' => 'Yaracuy',
                'municipio' => 'Bruzual',
                'parroquia' => 'Parroquia Norte',
                'comunidad' => 'Comunidad DEF',
                'direccion_detallada' => 'Avenida Siempre Viva 742, Ciudad, País',
                'fecha_creacion' => now()->subDays(7)->startOfDay(),
            ]
        );

        Solicitud::updateOrCreate(
            ['solicitud_id' => now()->format('Ymd') . substr(md5(uniqid(rand(), true)), 0, 6)],
            [
                'titulo' => 'Apoyo tras desastre natural',
                'descripcion' => 'Nuestra comunidad fue afectada por una inundación y necesitamos ayuda urgente.',
                'estado_detallado' => 'Aprobada',
                'persona_cedula' => 29970399,
                'direccion' => 'Barrio La Esperanza, Ciudad, País',
                'ambito_id' => 3,
                'derecho_palabra' => true,
                'categoria' => 'sucesos naturales',
                'subcategoria' => 'inundación',
                'tipo_solicitud' => 'colectivo_institucional',
                'es_colectivo_indigena' => true,
                'nombre_rif_institucion' => 'Comunidad Indígena ABC - J-98765432-1',
                'pais' => 'Venezuela',
                'estado_region' => 'Yaracuy',
                'municipio' => 'Bruzual',
                'parroquia' => 'Parroquia Sur',
                'comunidad' => 'Comunidad GHI',
                'direccion_detallada' => 'Barrio La Esperanza, Ciudad, País',
                'fecha_creacion' => now()->subDays(2)->startOfDay(),
            ]
        );

        Solicitud::updateOrCreate(
            ['solicitud_id' => now()->subDays(3)->startOfDay()->format('Ymd') . substr(md5(uniqid(rand(), true)), 0, 6)],
            [
                'titulo' => 'Mejora del sistema de salud',
                'descripcion' => 'El centro de salud local carece de recursos y personal adecuado.',
                'estado_detallado' => 'Asignada',
                'persona_cedula' => 29970399,
                'direccion' => 'Calle Salud 456, Ciudad, País',
                'ambito_id' => 4,
                'derecho_palabra' => false,
                'categoria' => 'servicios',
                'subcategoria' => 'salud',
                'tipo_solicitud' => 'individual',
                'es_colectivo_indigena' => false,
                'nombre_rif_institucion' => null,
                'pais' => 'Venezuela',
                'estado_region' => 'Yaracuy',
                'municipio' => 'Bruzual',
                'parroquia' => 'Parroquia Este',
                'comunidad' => 'Comunidad JKL',
                'direccion_detallada' => 'Calle Salud 456, Ciudad, País',
                'fecha_creacion' => now()->subDays(3)->startOfDay(),
            ]
        );

        Solicitud::updateOrCreate(
            ['solicitud_id' => now()->subDays(10)->startOfDay()->format('Ymd') . substr(md5(uniqid(rand(), true)), 0, 6)],
            [
                'titulo' => 'Instalación de alumbrado público',
                'descripcion' => 'Las calles de nuestra comunidad son inseguras debido a la falta de iluminación.',
                'estado_detallado' => 'Rechazada',
                'persona_cedula' => 29970399,
                'direccion' => 'Plaza Central, Ciudad, País',
                'ambito_id' => 5,
                'derecho_palabra' => true,
                'categoria' => 'servicios',
                'subcategoria' => 'alumbrado',
                'tipo_solicitud' => 'colectivo_institucional',
                'es_colectivo_indigena' => false,
                'nombre_rif_institucion' => 'Asociación Vecinal - J-11223344-5',
                'pais' => 'Venezuela',
                'estado_region' => 'Yaracuy',
                'municipio' => 'Bruzual',
                'parroquia' => 'Parroquia Oeste',
                'comunidad' => 'Comunidad MNO',
                'direccion_detallada' => 'Plaza Central, Ciudad, País',
                'fecha_creacion' => now()->subDays(10)->startOfDay(),
            ]
        );
    }
}
