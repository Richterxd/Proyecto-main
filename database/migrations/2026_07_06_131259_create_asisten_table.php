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
        Schema::create('asisten', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reunion_id');
            $table->unsignedBigInteger('persona_cedula');
            $table->boolean('es_consejal')->default(false);
            $table->string('rol_asistencia')->nullable(); // Rol específico en la reunión
            $table->timestamps();

            $table->foreign('reunion_id')->references('id')->on('reuniones')->onDelete('cascade');
            $table->foreign('persona_cedula')->references('cedula')->on('personas')->onDelete('cascade');
            
            // Evitar duplicados
            $table->unique(['reunion_id', 'persona_cedula']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asisten');
    }
};