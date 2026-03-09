<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetEntrepreneurialsTable extends Migration
{
    public function up(): void
    {
        Schema::create('projet_entrepreneurials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('secteur')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->string('statut')->default('en_attente'); // en_attente, valide, rejete
            $table->timestamp('date_soumission')->useCurrent();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projet_entrepreneurials');
    }
}

