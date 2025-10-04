<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->unsignedBigInteger('cedula')->primary()->unique();

            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');
            $table->string('telefono');
            $table->string('correo')->unique();
            $table->text('direccion');
            $table->string('zona_trabajo');
            $table->timestamps();
        });
    }
};
