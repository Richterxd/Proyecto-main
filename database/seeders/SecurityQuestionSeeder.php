<?php

namespace Database\Seeders;

use App\Models\SecurityQuestion;
use Illuminate\Database\Seeder;

class SecurityQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            '¿Cuál es el nombre de tu primera mascota?',
            '¿En qué ciudad naciste?',
            '¿Cuál es el nombre de soltera de tu madre?',
            '¿Cuál es el nombre de tu primer colegio?',
            '¿Cuál es tu color favorito?',
            '¿Cómo se llama tu mejor amigo de la infancia?',
            '¿Cuál es el nombre de tu hermano mayor?',
            '¿En qué mes naciste?',
            '¿Cuál es tu comida favorita?',
            '¿Cuál es el nombre de tu profesor favorito?',
            '¿En qué calle vivías cuando eras niño?',
            '¿Cuál es tu número favorito?',
            '¿Cuál es el nombre de tu abuelo paterno?',
            '¿Cuál es el nombre de tu abuela materna?',
            '¿Cuál es tu equipo de fútbol favorito?',
            '¿Cuál es el nombre de tu primo favorito?',
            '¿En qué año te graduaste del bachillerato?',
            '¿Cuál es tu película favorita?',
            '¿Cuál es el modelo de tu primer carro?',
            '¿Cuál es el nombre de tu cantante favorito?'
        ];

        foreach ($questions as $question) {
            SecurityQuestion::create([
                'question_text' => $question,
                'is_active' => true,
            ]);
        }
    }
}