<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Quiz pour la formation "Nutrition équilibrée pour les femmes enceintes" (formation_id = 1)
        $quiz1Id = DB::table('quiz_formations')->insertGetId([
            'formation_id' => 1,
            'titre' => 'Quiz de fin de formation',
            'description' => 'Testez vos connaissances sur la nutrition pendant la grossesse',
            'score_minimum' => 70,
            'actif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Questions pour le quiz 1
        $q1Id = DB::table('quiz_questions')->insertGetId([
            'quiz_id' => $quiz1Id,
            'question' => 'Quel nutriment est essentiel pour prévenir les malformations du tube neural chez le bébé ?',
            'type' => 'choix_unique',
            'ordre' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('quiz_reponses')->insert([
            ['question_id' => $q1Id, 'reponse' => 'Le fer', 'est_correcte' => false, 'ordre' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q1Id, 'reponse' => 'L\'acide folique', 'est_correcte' => true, 'ordre' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q1Id, 'reponse' => 'Le calcium', 'est_correcte' => false, 'ordre' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q1Id, 'reponse' => 'Les protéines', 'est_correcte' => false, 'ordre' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $q2Id = DB::table('quiz_questions')->insertGetId([
            'quiz_id' => $quiz1Id,
            'question' => 'Pourquoi est-il important de consommer des produits laitiers pendant la grossesse ?',
            'type' => 'choix_unique',
            'ordre' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('quiz_reponses')->insert([
            ['question_id' => $q2Id, 'reponse' => 'Pour le calcium', 'est_correcte' => true, 'ordre' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q2Id, 'reponse' => 'Pour les protéines', 'est_correcte' => false, 'ordre' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q2Id, 'reponse' => 'Pour le fer', 'est_correcte' => false, 'ordre' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q2Id, 'reponse' => 'Pour les vitamines', 'est_correcte' => false, 'ordre' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Quiz pour la formation "Premiers secours pour les nourrissons" (formation_id = 2)
        $quiz2Id = DB::table('quiz_formations')->insertGetId([
            'formation_id' => 2,
            'titre' => 'Quiz de fin de formation',
            'description' => 'Testez vos connaissances sur les premiers secours chez les nourrissons',
            'score_minimum' => 70,
            'actif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $q3Id = DB::table('quiz_questions')->insertGetId([
            'quiz_id' => $quiz2Id,
            'question' => 'Que devez-vous faire si un nourrisson ne respire pas ?',
            'type' => 'choix_unique',
            'ordre' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('quiz_reponses')->insert([
            ['question_id' => $q3Id, 'reponse' => 'Le secouer pour le réveiller', 'est_correcte' => false, 'ordre' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q3Id, 'reponse' => 'Commencer la réanimation cardio-respiratoire', 'est_correcte' => true, 'ordre' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q3Id, 'reponse' => 'Lui donner de l\'eau', 'est_correcte' => false, 'ordre' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q3Id, 'reponse' => 'Attendre que ça passe', 'est_correcte' => false, 'ordre' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Quiz pour la formation "Maraîchage écologique" (formation_id = 3)
        $quiz3Id = DB::table('quiz_formations')->insertGetId([
            'formation_id' => 3,
            'titre' => 'Quiz de fin de formation',
            'description' => 'Testez vos connaissances sur le maraîchage écologique',
            'score_minimum' => 70,
            'actif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $q4Id = DB::table('quiz_questions')->insertGetId([
            'quiz_id' => $quiz3Id,
            'question' => 'Qu\'est-ce que la rotation des cultures ?',
            'type' => 'choix_unique',
            'ordre' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('quiz_reponses')->insert([
            ['question_id' => $q4Id, 'reponse' => 'Faire pousser plusieurs légumes ensemble', 'est_correcte' => false, 'ordre' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q4Id, 'reponse' => 'Cultiver différentes plantes sur la même parcelle au fil des saisons', 'est_correcte' => true, 'ordre' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q4Id, 'reponse' => 'Arroser les plantes chaque jour', 'est_correcte' => false, 'ordre' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => $q4Id, 'reponse' => 'Utiliser des pesticides', 'est_correcte' => false, 'ordre' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
