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

        // Formations - Santé & Bien-être (categorie_id = 1)
        DB::table('formations')->insert([
            [
                'categorie_id' => 1,
                'auteur_id' => 1,
                'titre' => 'Nutrition équilibrée pour les femmes enceintes',
                'description' => 'Apprenez les bases d\'une alimentation saine pendant la grossesse pour vous et votre bébé.',
                'contenu' => '<h2>Introduction à la nutrition maternelle</h2><p>Une alimentation équilibrée est essentielle pendant la grossesse. Elle fournit les nutriments nécessaires au développement du bébé et maintient la santé de la mère.</p><h3>Les nutriments clés</h3><ul><li><strong>Fer</strong>: Prévenir l\'anémie</li><li><strong>Calcium</strong>: Développement osseux du bébé</li><li><strong>Acide folique</strong>: Prévention des malformations</li><li><strong>Protéines</strong>: Croissance cellulaire</li></ul><h3>Recommandations alimentaires</h3><p>Privilégiez les aliments riches en nutriments: légumes verts, fruits, légumineuses, produits laitiers, viandes maigres et poissons.</p>',
                'type' => 'article',
                'image_url' => '/images/formation-sante.jpg',
                'duree_minutes' => 45,
                'niveau' => 'debutant',
                'statut' => 'publie',
                'vues' => 125,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categorie_id' => 1,
                'auteur_id' => 1,
                'titre' => 'Premiers secours pour les nourrissons',
                'description' => 'Guide pratique pour gérer les urgences courantes chez les nourrissons de 0 à 12 mois.',
                'contenu' => '<h2>Les urgences courantes chez le nourrisson</h2><p>En tant que parent ou aidant, il est essentiel de connaître les gestes de premiers secours.</p><h3>La réanimation cardio-respiratoire</h3><p>Si le nourrisson ne respire pas:</p><ol><li>Placez le bébé sur une surface dure</li><li>Comprimez le sternum avec 2 doigts</li><li>Donnez 2 insufflations</li></ol><h3>Les brûlures</h3><p>Passez la zone brûlée sous l\'eau froide pendant 10 minutes. Ne mettez jamais de glace ou de beurre.</p>',
                'type' => 'article',
                'image_url' => '/images/formation-secours.jpg',
                'duree_minutes' => 60,
                'niveau' => 'intermediaire',
                'statut' => 'publie',
                'vues' => 89,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Formations - Agriculture & Élevage (categorie_id = 2)
        DB::table('formations')->insert([
            [
                'categorie_id' => 2,
                'auteur_id' => 1,
                'titre' => 'Maraîchage écologique',
                'description' => 'Techniques de culture maraîchère respectueuses de l\'environnement pour maximiser vos récoltes.',
                'contenu' => '<h2>Le maraîchage écologique</h2><p>Le maraîchage écologique permet de produire des légumes de qualité tout en préservant l\'environnement.</p><h3>Principes de base</h3><ul><li>Rotation des cultures</li><li>Compostage</li><li>Lutte biologique contre les ravageurs</li><li>Paillage pour conserver l\'humidité</li></ul><h3>Calendrier des semis</h3><p>Janvier-Février: Semis en intérieur<br>Mars-Avril: Repiquage en pleine terre<br>Mai-Juin: Récoltes précoces</p>',
                'type' => 'article',
                'image_url' => '/images/formation-maraichage.jpg',
                'duree_minutes' => 90,
                'niveau' => 'debutant',
                'statut' => 'publie',
                'vues' => 203,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categorie_id' => 2,
                'auteur_id' => 1,
                'titre' => 'Élevage de poules pondeuses',
                'description' => 'Guide complet pour démarrer un élevage de poules pondeuses rentable.',
                'contenu' => '<h2>Élever des poules pondeuses</h2><p>L\'élevage de poules pondeuses est une activité accessible et rentable pour les familles rurales.</p><h3>Choisir ses races</h3><p>Les races locales sont mieux adaptées aux conditions climatiques. Préférez des poules rustiques et bonnes pondeuses.</p><h3>Alimentation et soins</h3><p>Une ponte optimale nécessite:</p><ul><li>Une alimentation riche en protéines</li><li>De l\'eau fraîche toujours disponible</li><li>Un espace de parcours suffisant</li><li>Des pondoirs propres et sécurisés</li></ul>',
                'type' => 'article',
                'image_url' => '/images/formation-poules.jpg',
                'duree_minutes' => 75,
                'niveau' => 'debutant',
                'statut' => 'publie',
                'vues' => 156,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Formations - Entrepreneuriat (categorie_id = 3)
        DB::table('formations')->insert([
            [
                'categorie_id' => 3,
                'auteur_id' => 1,
                'titre' => 'Initiation à la gestion d\'entreprise',
                'description' => 'Les bases de la gestion d\'entreprise pour les entrepreneurs débutants.',
                'contenu' => '<h2>Les fondamentaux de la gestion d\'entreprise</h2><p>Toute entreprise, même petite, nécessite une bonne gestion pour réussir.</p><h3>Le business plan</h3><p>Le business plan est un document essentiel qui définit:</p><ul><li>Votre activité et vos objectifs</li><li>Votre marché et vos clients</li><li>Vos charges et vos revenus prévisionnels</li><li>Votre stratégie commerciale</li></ul><h3>La comptabilité simplifiée</h3><p>Notez toutes vos recettes et dépenses. Utilisez un cahier ou un tableur simple pour suivre votre trésorerie.</p>',
                'type' => 'article',
                'image_url' => '/images/formation-gestion.jpg',
                'duree_minutes' => 120,
                'niveau' => 'debutant',
                'statut' => 'publie',
                'vues' => 312,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categorie_id' => 3,
                'auteur_id' => 1,
                'titre' => 'Marketing digital pour petites entreprises',
                'description' => 'Apprenez à promouvoir votre activité sur les réseaux sociaux et Internet.',
                'contenu' => '<h2>Le marketing digital accessible à tous</h2><p>Avec un smartphone et une connexion Internet, vous pouvez atteindre des milliers de clients potentiels.</p><h3>Les réseaux sociaux</h3><p>Facebook, WhatsApp et Instagram sont des outils puissants pour:</p><ul><li>Présenter vos produits ou services</li><li>Interagir avec vos clients</li><li>Recueillir les témoignages satisfaits</li><li>Organiser des promotions</li></ul><h3>Conseils pratiques</h3><p>Publiez régulièrement, responded à tous les messages, et partagez du contenu de qualité qui intéressera votre audience.</p>',
                'type' => 'article',
                'image_url' => '/images/formation-marketing.jpg',
                'duree_minutes' => 60,
                'niveau' => 'debutant',
                'statut' => 'publie',
                'vues' => 245,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Formations - Droits & Citoyenneté (categorie_id = 4)
        DB::table('formations')->insert([
            [
                'categorie_id' => 4,
                'auteur_id' => 1,
                'titre' => 'Connaissez vos droits',
                'description' => 'Guide des droits fondamentaux des femmes et des citoyens.',
                'contenu' => '<h2>Les droits des citoyens</h2><p>Connaître ses droits est la première étape pour les faire valoir.</p><h3>Droits des femmes</h3><ul><li>Droit à l\'éducation et au travail</li><li>Droit de vote et d\'éligibilité</li><li>Droit à la propriété</li><li>Protection contre les violences</li></ul><h3>Comment faire valoir ses droits?</h3><p>En cas de violation de vos droits, usted peut:</p><ol><li>Contacter une association de défense des droits</li><li>Porter plainte auprès des autorités</li><li>Consulter un avocat ou un médiateur</li></ol>',
                'type' => 'article',
                'image_url' => '/images/formation-droits.jpg',
                'duree_minutes' => 45,
                'niveau' => 'debutant',
                'statut' => 'publie',
                'vues' => 178,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Formations - Numérique (categorie_id = 5)
        DB::table('formations')->insert([
            [
                'categorie_id' => 5,
                'auteur_id' => 1,
                'titre' => 'Initiation à l\'informatique',
                'description' => 'Apprenez les bases de l\'utilisation d\'un ordinateur.',
                'contenu' => '<h2>L\'informatique pour les débutants</h2><p>L\'informatique n\'est plus un luxe, c\'est une nécessité.</p><h3>Les bases</h3><ul><li>Allumer et arrêter l\'ordinateur</li><li>Utiliser le clavier et la souris</li><li>Gérer les fichiers et dossiers</li><li>Naviguer sur Internet</li></ul><h3>Les erreurs à éviter</h3><p>Ne cliquez pas sur des liens suspects, ne partagez pas vos mots de passe, et faites des sauvegardes régulières de vos données importantes.</p>',
                'type' => 'article',
                'image_url' => '/images/formation-informatique.jpg',
                'duree_minutes' => 90,
                'niveau' => 'debutant',
                'statut' => 'publie',
                'vues' => 134,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Formations - Artisanat & Couture (categorie_id = 6)
        DB::table('formations')->insert([
            [
                'categorie_id' => 6,
                'auteur_id' => 1,
                'titre' => 'Couture de base',
                'description' => 'Apprenez les techniques essentielles de couture à la main et à la machine.',
                'contenu' => '<h2>La couture pour toutes</h2><p>La couture est un savoir-faire précieux qui permet de créer et de réparer vos vêtements.</p><h3>Les outils indispensables</h3><ul><li>Aiguilles de différentes tailles</li><li>Fil à coudre de qualité</li><li>Ciseaux de couture</li><li>Epingles et découd-vite</li></ul><h3>Les points de base</h3><p>Maîtrisez d\'abord le point droit, le point arrière, le point de couture et le point invisible avant de passer aux modèles plus complexes.</p>',
                'type' => 'article',
                'image_url' => '/images/formation-couture.jpg',
                'duree_minutes' => 75,
                'niveau' => 'debutant',
                'statut' => 'publie',
                'vues' => 189,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('=================================================================');
        $this->command->info('CATÉGORIES ET FORMATIONS CRÉÉES AVEC SUCCÈS');
        $this->command->info('=================================================================');
        $this->command->info('Catégories: 6');
        $this->command->info('Formations: 9');
        $this->command->info('=================================================================');
    }
}
