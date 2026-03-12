<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjetEntrepreneurialSeeder extends Seeder
{
    public function run(): void
    {
        // Projets entrepreneuriaux
        DB::table('projet_entrepreneurials')->insert([
            [
                'user_id' => 1,
                'titre' => 'Élevage de volailles bio',
                'description' => 'Création d\'un élevage de poules pondeuses et de pintades en plein air, avec alimentation biologique et respectueux du bien-être animal. Projet visant à approvisionner le marché local en œufs et viande de qualité.',
                'secteur' => 'Agriculture & Élevage',
                'budget' => 2500.00,
                'statut' => 'valide',
                'date_soumission' => now()->subDays(30),
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(30),
            ],
            [
                'user_id' => 1,
                'titre' => 'Transformation de fruits',
                'description' => 'Unitée de transformation de fruits locaux en jus, confitures et séchés. Le projet valorise les productions agricoles locales et crée des emplois pour les femmes du village.',
                'secteur' => 'Agro-alimentaire',
                'budget' => 5000.00,
                'statut' => 'valide',
                'date_soumission' => now()->subDays(25),
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(25),
            ],
            [
                'user_id' => 1,
                'titre' => 'Salon de coiffure et esthétique',
                'description' => 'Ouverture d\'un salon de coiffure mixte avec services d\'esthétique. Le projet inclut également une formation professionnelle pour les jeunes du quartier.',
                'secteur' => 'Services',
                'budget' => 3000.00,
                'statut' => 'valide',
                'date_soumission' => now()->subDays(20),
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20),
            ],
            [
                'user_id' => 1,
                'titre' => 'Maraîchage maraîcher bio',
                'description' => 'Exploitation maraîchère de 2 hectares produisant des légumes biologiques toute l\'année. Utilisation de techniques d\'irrigation goutte-à-goutte et de compostage.',
                'secteur' => 'Agriculture & Élevage',
                'budget' => 4000.00,
                'statut' => 'valide',
                'date_soumission' => now()->subDays(15),
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
            [
                'user_id' => 1,
                'titre' => 'École privée maternelle',
                'description' => 'Création d\'une école maternelle privée avec蒙 Early Childhood Education methodology. Le projet vise à offrir une éducation de qualité aux enfants de 3 à 6 ans.',
                'secteur' => 'Éducation',
                'budget' => 8000.00,
                'statut' => 'en_attente',
                'date_soumission' => now()->subDays(5),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'user_id' => 1,
                'titre' => 'Atelier de couture',
                'description' => 'Création d\'un atelier de confection de vêtements et de réparation textile. Le projet propose également des cours de couture pour les femmes interestedes.',
                'secteur' => 'Artisanat',
                'budget' => 1500.00,
                'statut' => 'valide',
                'date_soumission' => now()->subDays(10),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'user_id' => 1,
                'titre' => 'Pharmacie villageoise',
                'description' => 'Ouverture d\'une pharmacie communautaire offrant des médicaments essentiels et des conseils de santé de première nécessité.',
                'secteur' => 'Santé',
                'budget' => 6000.00,
                'statut' => 'en_attente',
                'date_soumission' => now()->subDays(3),
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'user_id' => 1,
                'titre' => 'Commerce de détail',
                'description' => 'Supérette de quartier offrant des produits de première nécessité, des produits locaux et des articles ménagers.',
                'secteur' => 'Commerce',
                'budget' => 2000.00,
                'statut' => 'valide',
                'date_soumission' => now()->subDays(8),
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
            [
                'user_id' => 1,
                'titre' => 'Transport moto',
                'description' => 'Flotte de motos taxis pour le transport de personnes et de colis dans la commune et les villages environnants.',
                'secteur' => 'Transport',
                'budget' => 7500.00,
                'statut' => 'rejete',
                'date_soumission' => now()->subDays(12),
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(12),
            ],
            [
                'user_id' => 1,
                'titre' => 'Restaurant local',
                'description' => 'Restaurant servant des plats traditionnels locaux avec des produits frais du marché. Le projet inclut un service de livraison à domicile.',
                'secteur' => 'Restauration',
                'budget' => 3500.00,
                'statut' => 'en_attente',
                'date_soumission' => now()->subDays(2),
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
        ]);

        $this->command->info('=================================================================');
        $this->command->info('PROJETS ENTREPRENEURIAUX CRÉÉS AVEC SUCCÈS');
        $this->command->info('=================================================================');
        $this->command->info('Total des projets: 10');
        $this->command->info('Validés: 6');
        $this->command->info('En attente: 3');
        $this->command->info('Rejetés: 1');
        $this->command->info('=================================================================');
    }
}
