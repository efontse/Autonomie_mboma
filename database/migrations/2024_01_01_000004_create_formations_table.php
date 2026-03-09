<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Recrée les tables formations avec la bonne structure
        Schema::dropIfExists('inscriptions_formations');
        Schema::dropIfExists('formations');
        Schema::dropIfExists('categories_formation');

        // ── Catégories ────────────────────────────────────────
        Schema::create('categories_formation', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 150);
            $table->text('description')->nullable();
            $table->string('icone', 50)->nullable();
            $table->string('couleur', 20)->default('#C9923A');
            $table->timestamp('created_at')->useCurrent();
        });

        // ── Formations ────────────────────────────────────────
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->constrained('categories_formation');
            $table->foreignId('auteur_id')->constrained('users');
            $table->string('titre', 255);
            $table->text('description')->nullable();
            $table->longText('contenu')->nullable();       // Texte de la formation
            $table->enum('type', ['video', 'document', 'article', 'mixte'])->default('article');
            $table->string('video_url', 500)->nullable();  // URL YouTube/externe
            $table->string('document_url', 255)->nullable(); // Chemin fichier PDF
            $table->string('image_url', 255)->nullable();
            $table->smallInteger('duree_minutes')->unsigned()->nullable();
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance'])->default('debutant');
            $table->enum('statut', ['brouillon', 'publie', 'archive'])->default('brouillon');
            $table->unsignedInteger('vues')->default(0);
            $table->timestamps();

            $table->index(['statut', 'categorie_id']);
            $table->index('niveau');
        });

        // ── Inscriptions + progression ────────────────────────
        Schema::create('inscriptions_formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
            $table->tinyInteger('progression')->unsigned()->default(0); // 0-100%
            $table->boolean('termine')->default(false);
            $table->string('certificat_url', 255)->nullable();
            $table->timestamp('inscrit_le')->useCurrent();
            $table->timestamp('termine_le')->nullable();

            $table->unique(['user_id', 'formation_id']);
            $table->index(['user_id', 'termine']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscriptions_formations');
        Schema::dropIfExists('formations');
        Schema::dropIfExists('categories_formation');
    }
};

