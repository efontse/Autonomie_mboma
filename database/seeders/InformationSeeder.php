<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InformationSeeder extends Seeder
{
    public function run(): void
    {
        // Informations - Santé (categorie = 'sante')
        DB::table('informations')->insert([
            [
                'auteur_id' => 1,
                'titre' => 'Semaine de la santé maternelle: les services gratuits disponibles',
                'contenu' => '<h2>La santé maternelle, une priorité</h2><p>Durant cette semaine spéciale, de nombreux services de santé maternelle sont proposés gratuitement dans les centres de santé partenaires.</p><h3>Services disponibles</h3><ul><li>Consultations prénatales</li><li>Echographies de contrôle</li><li>Dépistage du diabète gestationnel</li><li>Vaccination des nouveau-nés</li></ul><p>Venez nombreuses faire vérifier votre état de santé et celui de votre bébé. Les sage-femmes sont disponibles pour répondre à toutes vos questions.</p>',
                'categorie' => 'sante',
                'image_url' => '/images/info-sante.jpg',
                'statut' => 'publie',
                'vues' => 234,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'auteur_id' => 1,
                'titre' => 'L\'importance de la vaccination des enfants',
                'contenu' => '<h2>Vacciner pour protéger</h2><p>La vaccination est l\'un des moyens les plus efficaces de protéger vos enfants contre les maladies graves.</p><h3>Le calendrier vaccinal</h3><p>Le Programme Elargi de Vaccination (PEV) recommande:</p><ul><li>BCG et Polio à la naissance</li><li>DTC, Hépatite B et Polio à 6, 10 et 14 semaines</li><li>Rougeole à 9 mois</li></ul><p>Les vaccins sont disponibles gratuitement dans tous les centres de santé publics.</p>',
                'categorie' => 'sante',
                'image_url' => '/images/info-vaccination.jpg',
                'statut' => 'publie',
                'vues' => 187,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Informations - Droits & Justice (categorie = 'droits_justice')
        DB::table('informations')->insert([
            [
                'auteur_id' => 1,
                'titre' => 'Nouvelle loi sur la protection des femmes contre les violences',
                'contenu' => '<h2>Une avancée majeure pour les droits des femmes</h2><p>Le gouvernement a adopté une nouvelle loi renforçant la protection des femmes contre toutes formes de violences.</p><h3>Points clés de la loi</h3><ul><li>Définition élargie des violences conjugales</li><li>Numéro vert gratuit pour les victimes</li><li>Protection immédiate des victimes avec placement en foyer sécurisé</li><li>Sanctions renforcées pour les auteurs de violences</li></ul><h3>Où obtenir de l\'aide?</h3><p>Contactez le 119 pour signaler une situation de violence et obtenir une assistance.</p>',
                'categorie' => 'droits_justice',
                'image_url' => '/images/info-violences.jpg',
                'statut' => 'publie',
                'vues' => 312,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'auteur_id' => 1,
                'titre' => 'Comment déclarer un mariage civil?',
                'contenu' => '<h2>L\'importance du mariage civil</h2><p>Le mariage civil est obligatoire pour bénéficier pleinement de vos droits et ceux de vos enfants.</p><h3>Documents nécessaires</h3><ul><li>Actes de naissance des futurs époux</li><li>Certificat de célibat</li><li>Pièces d\'identité</li><li>Certificat médical</li><li>Acte de consentement parental (pour les mineurs)</li></ul><h3>Procédure</h3><p>Déposez votre dossier à la mairie de votre domicile. Le mariage peut être célébré après un délai légal de 10 jours.</p>',
                'categorie' => 'droits_justice',
                'image_url' => '/images/info-mariage.jpg',
                'statut' => 'publie',
                'vues' => 156,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Informations - Agriculture (categorie = 'agriculture')
        DB::table('informations')->insert([
            [
                'auteur_id' => 1,
                'titre' => 'Formation gratuite en agriculture biologique',
                'contenu' => '<h2>Apprenez l\'agriculture biologique</h2><p>Le ministère de l\'Agriculture propose des formations gratuites en agriculture biologique pour les farmers.</p><h3>Contenu de la formation</h3><ul><li>Principes de l\'agriculture biologique</li><li>Fabrication de compost</li><li>Lutte biologique contre les parasites</li><li>Techniques de rotation des cultures</li></ul><h3>Inscriptions</h3><p>Les inscriptions sont ouvertes dans votre bureau agricole local. N\'hésitez pas à vous inscrire dès maintenant!</p>',
                'categorie' => 'agriculture',
                'image_url' => '/images/info-agriculture.jpg',
                'statut' => 'publie',
                'vues' => 198,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Informations - Education (categorie = 'education')
        DB::table('informations')->insert([
            [
                'auteur_id' => 1,
                'titre' => 'Rentrée scolaire 2024: nouvelles aides pour les familles',
                'contenu' => '<h2>Des aides pour la scolarité de vos enfants</h2><p>Le gouvernement a mis en place de nouvelles aides pour soutenir les familles lors de la rentrée scolaire.</p><h3>Aides disponibles</h3><ul><li>Fournitures scolaires gratuites pour les familles démunies</li><li>Bourses scolaires pour les enfants du primaire au secondaire</li><li>Programme de cantine scolaire à prix réduit</li></ul><h3>Comment en bénéficier?</h3><p>Contactez l\'inspecteur de votre zone scolaire ou le bureau d\'action sociale de votre commune.</p>',
                'categorie' => 'education',
                'image_url' => '/images/info-scolaire.jpg',
                'statut' => 'publie',
                'vues' => 267,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Informations - Numérique (categorie = 'numerique')
        DB::table('informations')->insert([
            [
                'auteur_id' => 1,
                'titre' => 'Centre de formation numérique: inscrivez-vous gratuitement',
                'contenu' => '<h2>Apprenez le numérique</h2><p>Un nouveau centre de formation numérique ouvre ses portes pour permettre à tous d\'acquérir des compétences digitales.</p><h3>Formations proposées</h3><ul><li>Initiation à l\'ordinateur</li><li>Utilisation du smartphone</li><li>Réseaux sociaux pour votre activité</li><li>Base de la programmation</li></ul><h3>Horaires</h3><p>Les formations sont organisées le matin et l\'après-midi, du lundi au samedi. L\'inscription est gratuite.</p>',
                'categorie' => 'numerique',
                'image_url' => '/images/info-numerique.jpg',
                'statut' => 'publie',
                'vues' => 145,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Informations - Annonces locales (categorie = 'annonces_locales')
        DB::table('informations')->insert([
            [
                'auteur_id' => 1,
                'titre' => 'Foire internationale de l\'artisanat local',
                'contenu' => '<h2>Participez à la grande foire artisanale</h2><p>Rejoignez-nous pour la traditionnelle foire de l\'artisanat local qui aura lieu le mois prochain.</p><h3>Informations pratiques</h3><ul><li><strong>Date:</strong> 15-20 du mois prochain</li><li><strong>Lieu:</strong> Palais des expositions</li><li><strong>Heure:</strong> 9h - 18h</li></ul><h3>Inscriptions exposants</h3><p>Les artisans interested peuvent s\'inscrire au bureau de la chambre de commerce. Places limitées!</p>',
                'categorie' => 'annonces_locales',
                'image_url' => '/images/info-foire.jpg',
                'statut' => 'publie',
                'vues' => 189,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'auteur_id' => 1,
                'titre' => 'Recrutement: agent de santé communautaire',
                'contenu' => '<h2>Emploi: Agent de santé communautaire</h2><p>L\'ONG Santé Pour Tous recrute des agents de santé communautaire pour renforcer ses équipes.</p><h3>Profil recherché</h3><ul><li>Résider dans la zone de santé</li><li>Avoir au moins le niveau BEPC</li><li>Etre disponible et motivé</li><li>Avoir des notions de français</li></ul><h3>Conditions</h3><p>Contrat à durée indéterminée, formation initiale fournie, avantages sociaux.</p><p>Envoyez votre CV par email ou déposez-le au bureau de l\'ONG.</p>',
                'categorie' => 'annonces_locales',
                'image_url' => '/images/info-recrutement.jpg',
                'statut' => 'publie',
                'vues' => 234,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('=================================================================');
        $this->command->info('INFORMATIONS CRÉÉES AVEC SUCCÈS');
        $this->command->info('=================================================================');
        $this->command->info('Total des informations: 9');
        $this->command->info('Catégories couvertes: santé, droits_justice, agriculture, education, numérique, annonces_locales');
        $this->command->info('=================================================================');
    }
}
