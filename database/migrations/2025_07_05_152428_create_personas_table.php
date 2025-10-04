<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->unsignedBigInteger('cedula')->primary()->unique();

            $table->string('nombre', 50);
            $table->string('apellido', 50)->nullable();
            $table->string('segundo_nombre', 50)->nullable();
            $table->string('segundo_apellido', 50)->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('genero')->nullable();
            $table->date('nacimiento')->nullable();
            $table->string('direccion', 100)->nullable();
            $table->string('telefono', 15);
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
