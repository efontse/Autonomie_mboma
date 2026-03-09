<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('informations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('titre');
            $table->text('contenu');
            $table->string('categorie', 100)->default('general');
            $table->string('image', 255)->nullable();
            $table->string('statut', 50)->default('publie');
            $table->unsignedInteger('vues')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('categorie');
            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informations');
    }
}

