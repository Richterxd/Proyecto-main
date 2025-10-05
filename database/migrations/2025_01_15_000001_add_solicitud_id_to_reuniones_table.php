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
        Schema::table('reuniones', function (Blueprint $table) {
            $table->string('solicitud_id')->nullable()->after('institucion_id');
            
            $table->foreign('solicitud_id')
                  ->references('solicitud_id')
                  ->on('solicitudes')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reuniones', function (Blueprint $table) {
            $table->dropForeign(['solicitud_id']);
            $table->dropColumn('solicitud_id');
        });
    }
};