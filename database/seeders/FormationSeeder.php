<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormationSeeder extends Seeder
{
    public function run(): void
    {
        // Catégories avec couleurs
        DB::table('categories_formation')->insert([
            ['nom' => 'Santé & Bien-être',     'description' => 'Soins, nutrition, santé maternelle',        'icone' => 'heart',     'couleur' => '#E74C3C'],
            ['nom' => 'Agriculture & Élevage', 'description' => 'Techniques agricoles, maraîchage, élevage', 'icone' => 'leaf',      'couleur' => '#27AE60'],
            ['nom' => 'Entrepreneuriat',        'description' => 'Gestion, comptabilité, marketing',           'icone' => 'briefcase', 'couleur' => '#C9923A'],
            ['nom' => 'Droits & Citoyenneté',  'description' => 'Droits des femmes, participation civique',   'icone' => 'scale',     'couleur' => '#2980B9'],
            ['nom' => 'Numérique',              'description' => 'Informatique de base, réseaux sociaux',      'icone' => 'monitor',   'couleur' => '#8E44AD'],
            ['nom' => 'Artisanat & Couture',   'description' => 'Couture, tissage, art',                      'icone' => 'scissors',  'couleur' => '#D35400'],
        ]);
    }
}
