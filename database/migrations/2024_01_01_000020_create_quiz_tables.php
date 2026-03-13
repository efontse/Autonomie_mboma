<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Table des quiz pour chaque formation
        Schema::create('quiz_formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
            $table->string('titre')->default('Quiz de fin de formation');
            $table->text('description')->nullable();
            $table->integer('score_minimum')->default(70); // Pourcentage minimum pour réussir
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        // Table des questions
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quiz_formations')->onDelete('cascade');
            $table->text('question');
            $table->string('type')->default('choix_unique'); // choix_unique ou choix_multiple
            $table->integer('ordre')->default(0);
            $table->timestamps();
        });

        // Table des réponses possibles
        Schema::create('quiz_reponses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('quiz_questions')->onDelete('cascade');
            $table->text('reponse');
            $table->boolean('est_correcte')->default(false);
            $table->integer('ordre')->default(0);
            $table->timestamps();
        });

        // Table des tentatives de quiz par utilisateur
        Schema::create('quiz_tentatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained('quiz_formations')->onDelete('cascade');
            $table->integer('score')->default(0);
            $table->boolean('reussie')->default(false);
            $table->timestamp('termine_le')->nullable();
            $table->timestamps();
        });

        // Table des réponses de l'utilisateur à chaque question
        Schema::create('quiz_reponses_utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tentative_id')->constrained('quiz_tentatives')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('quiz_questions')->onDelete('cascade');
            $table->foreignId('reponse_id')->constrained('quiz_reponses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_reponses_utilisateurs');
        Schema::dropIfExists('quiz_tentatives');
        Schema::dropIfExists('quiz_reponses');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quiz_formations');
    }
}
