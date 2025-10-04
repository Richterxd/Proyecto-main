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
        Schema::create('solicitud_personas_asociadas', function (Blueprint $table) {
            $table->string('solicitud_id')->primary()->nullable();
            $table->string('nombre_completo');
            $table->string('cedula');
            $table->string('telefono');
            $table->timestamps();

            $table->foreign('solicitud_id')->references('solicitud_id')->on('solicitudes')->onDelete('cascade');
            $table->index(['solicitud_id', 'cedula']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_personas_asociadas');
    }
};