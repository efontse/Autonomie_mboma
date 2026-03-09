<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('titre')->nullable();
            $table->text('contenu');
            $table->string('categorie')->nullable();
            $table->string('statut')->default('approuve'); // en_attente, approuve, rejete
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('vue')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
}

