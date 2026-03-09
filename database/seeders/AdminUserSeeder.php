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
        // Créer un utilisateur admin
        $admin = User::create([
            'nom' => 'Admin',
            'prenom' => 'Mboma',
            'email' => 'admin@mboma.com',
            'mot_de_passe' => Hash::make('admin123'),
            'role' => 'admin',
            'telephone' => '+243000000000',
        ]);

        // Créer un utilisateur modérateur
        $moderateur = User::create([
            'nom' => 'Moderateur',
            'prenom' => 'Mboma',
            'email' => 'moderateur@mboma.com',
            'mot_de_passe' => Hash::make('mod123'),
            'role' => 'moderateur',
            'telephone' => '+243000000001',
        ]);

        $this->command->info('Utilisateurs admin créés avec succès!');
        $this->command->info('Email: admin@mboma.com / Mot de passe: admin123');
        $this->command->info('Email: moderateur@mboma.com / Mot de passe: mod123');
    }
}
