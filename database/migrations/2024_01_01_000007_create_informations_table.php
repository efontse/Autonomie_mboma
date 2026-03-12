<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Supprime et recrée la table informations avec les bonnes catégories
        Schema::dropIfExists('informations');

        Schema::create('informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auteur_id')->constrained('users')->onDelete('cascade');
            $table->string('titre', 255);
            $table->longText('contenu');
            $table->enum('categorie', [
                'sante',
                'droits_justice',
                'agriculture',
                'education',
                'numerique',
                'annonces_locales',
            ])->default('annonces_locales');
            $table->string('image_url', 255)->nullable();
            $table->enum('statut', ['brouillon', 'publie', 'archive'])->default('brouillon');
            $table->unsignedInteger('vues')->default(0);
            $table->timestamps();

            $table->index('categorie');
            $table->index('statut');
            $table->index('auteur_id');
        });

        // Table commentaires_information (séparée des commentaires communautaires)
        Schema::create('commentaires_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('information_id')->constrained('informations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('contenu');
            $table->enum('statut', ['en_attente', 'approuve', 'rejete'])->default('approuve');
            $table->timestamps();

            $table->index(['information_id', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commentaires_information');
        Schema::dropIfExists('informations');
    }
};