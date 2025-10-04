<?php

namespace Database\Seeders;

use App\Models\Personas;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create SuperAdmin user
        Personas::updateOrCreate(
            ['cedula' => 1234567],
            [
                'nombre' => 'Super',
                'apellido' => 'Admin',
                'segundo_nombre' => 'Usuario',
                'segundo_apellido' => 'Sistema',
                'nacionalidad' => 'V',
                'genero' => 'M',
                'nacimiento' => '1980-01-01',
                'direccion' => 'Bruzual, Estado Yaracuy',
                'telefono' => '04261234567',
                'email' => 'superadmin@cmbey.gov.ve'
            ]
        );

        User::updateOrCreate(
            ['persona_cedula' => 1234567],
            [
                'role' => 1, // SuperAdministrador
                'password' => Hash::make('Admin123$')
            ]
        );

        // Create Admin user
        Personas::updateOrCreate(
            ['cedula' => 29970399],
            [
                'nombre' => 'Admin',
                'apellido' => 'Municipal',
                'segundo_nombre' => 'del',
                'segundo_apellido' => 'Consejo',
                'nacionalidad' => 'V',
                'genero' => 'F',
                'nacimiento' => '1985-05-15',
                'direccion' => 'Centro de Bruzual',
                'telefono' => '04267654321',
                'email' => 'admin@cmbey.gov.ve'
            ]
        );

        User::updateOrCreate(
            ['persona_cedula' => 29970399],
            [
                'role' => 3, // Administrador
                'password' => Hash::make('Clave123$')
            ]
        );

        Personas::updateOrCreate(
            ['cedula' => 12345678],
            [
                'nombre' => 'Consejal',
                'apellido' => 'Ejemplo',
                'segundo_nombre' => 'Usuario',
                'segundo_apellido' => 'Municipal',
                'nacionalidad' => 'V',
                'genero' => 'M',
                'nacimiento' => '1990-07-20',
                'direccion' => 'Barrio Ejemplo, Bruzual',
                'telefono' => '04261239876',
                'email' => 'consejal@mama.com'
            ]
        );

        User::updateOrCreate(
            ['persona_cedula' => 12345678],
            [
                'role' => 2, // Consejal
                'password' => Hash::make('Consejal123$')
            ]
        );

        Personas::updateOrCreate(
            ['cedula' => 87654321],
            [
                'nombre' => 'Trabajador',
                'apellido' => 'Ejemplo',
                'segundo_nombre' => 'Usuario',
                'segundo_apellido' => 'Municipal',
                'nacionalidad' => 'V',
                'genero' => 'F',
                'nacimiento' => '1992-03-10',
                'direccion' => 'Barrio Trabajador, Bruzual',
                'telefono' => '04261234589',
                'email' => 'de@de.com'
            ]
        );

        User::updateOrCreate(
            ['persona_cedula' => 87654321],
            [
                'role' => 2, // Trabajador
                'password' => Hash::make('Trabajador123$')
            ]
        );
       
    }
}
