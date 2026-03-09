<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('prenom', 100)->nullable();
            $table->string('email', 191)->unique();
            $table->string('telephone', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mot_de_passe');
            $table->enum('role', ['femme', 'jeune_fille', 'entrepreneur', 'autre', 'admin', 'moderateur'])->default('femme');
            $table->enum('statut', ['actif', 'inactif', 'suspendu'])->default('actif');
            $table->string('photo_profil')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('quartier', 100)->nullable();
            $table->string('village', 100)->nullable();
            $table->text('bio')->nullable();
            $table->timestamp('derniere_connexion')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
