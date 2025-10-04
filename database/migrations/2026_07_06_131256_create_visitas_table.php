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
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha');
            $table->string('estado')->default('Programada'); // Programada, Realizada, Cancelada
            $table->unsignedBigInteger('persona_cedula');
            $table->unsignedBigInteger('ambito_id');
            $table->timestamps();

            $table->foreign('persona_cedula')->references('cedula')->on('personas')->onDelete('cascade');
            $table->foreign('ambito_id')->references('ambito_id')->on('ambitos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};