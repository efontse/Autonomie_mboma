<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Renommer la colonne name en nom si elle existe
            if (Schema::hasColumn('users', 'name')) {
                $table->renameColumn('name', 'nom');
            }

            // Ajouter les nouvelles colonnes si elles n'existent pas
            if (!Schema::hasColumn('users', 'prenom')) {
                $table->string('prenom', 100)->nullable()->after('nom');
            }
            if (!Schema::hasColumn('users', 'telephone')) {
                $table->string('telephone', 20)->nullable()->after('prenom');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['femme', 'jeune_fille', 'entrepreneur', 'autre', 'admin', 'moderateur'])->default('femme')->after('telephone');
            }
            if (!Schema::hasColumn('users', 'statut')) {
                $table->enum('statut', ['actif', 'inactif', 'suspendu'])->default('actif')->after('role');
            }
            if (!Schema::hasColumn('users', 'photo_profil')) {
                $table->string('photo_profil')->nullable()->after('statut');
            }
            if (!Schema::hasColumn('users', 'date_naissance')) {
                $table->date('date_naissance')->nullable()->after('photo_profil');
            }
            if (!Schema::hasColumn('users', 'quartier')) {
                $table->string('quartier', 100)->nullable()->after('date_naissance');
            }
            if (!Schema::hasColumn('users', 'village')) {
                $table->string('village', 100)->nullable()->after('quartier');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('village');
            }
            if (!Schema::hasColumn('users', 'derniere_connexion')) {
                $table->timestamp('derniere_connexion')->nullable()->after('bio');
            }

            // Remplacer password par mot_de_passe si nécessaire
            if (Schema::hasColumn('users', 'password') && !Schema::hasColumn('users', 'mot_de_passe')) {
                $table->renameColumn('password', 'mot_de_passe');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cette migration est difficilement réversible
            // car elle modifie la structure existante
        });
    }
}

