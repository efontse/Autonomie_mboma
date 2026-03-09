<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur ADMIN
        $admin = User::create([
            'nom' => 'Administrateur',
            'prenom' => 'Principal',
            'email' => 'admin@mboma.com',
            'mot_de_passe' => Hash::make('admin123'),
            'role' => 'admin',
            'telephone' => '+243000000000',
            'statut' => 'actif',
        ]);

        // Créer un utilisateur MODÉRATEUR
        $moderateur = User::create([
            'nom' => 'Modérateur',
            'prenom' => 'Assistant',
            'email' => 'moderateur@mboma.com',
            'mot_de_passe' => Hash::make('mod123'),
            'role' => 'moderateur',
            'telephone' => '+243000000001',
            'statut' => 'actif',
        ]);

        $this->command->info('=================================================================');
        $this->command->info('UTILISATEURS ADMINISTRATIFS CRÉÉS AVEC SUCCÈS');
        $this->command->info('=================================================================');
        $this->command->info('');
        $this->command->info('ADMINISTRATEUR:');
        $this->command->info('  Email: admin@mboma.com');
        $this->command->info('  Mot de passe: admin123');
        $this->command->info('  Rôle: admin (accès complet au dashboard admin)');
        $this->command->info('');
        $this->command->info('MODÉRATEUR:');
        $this->command->info('  Email: moderateur@mboma.com');
        $this->command->info('  Mot de passe: mod123');
        $this->command->info('  Rôle: moderateur (accès limité au dashboard admin)');
        $this->command->info('=================================================================');
    }
}
