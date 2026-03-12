<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnoncesTable extends Migration
{
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('type'); // produit ou service
            $table->string('secteur');
            $table->decimal('prix', 12, 2)->nullable();
            $table->string('statut')->default('actif'); // actif, inactif
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('type');
            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
}
