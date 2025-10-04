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
        Schema::create('user_security_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_cedula');
            $table->unsignedBigInteger('security_question_id');
            $table->string('answer_hash'); // Store hashed answers for security
            $table->timestamps();
            
            $table->foreign('user_cedula')
                ->references('persona_cedula')
                ->on('usuarios')
                ->onDelete('cascade');
                
            $table->foreign('security_question_id')
                ->references('id')
                ->on('security_questions')
                ->onDelete('cascade');
                
            $table->unique(['user_cedula', 'security_question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_security_answers');
    }
};