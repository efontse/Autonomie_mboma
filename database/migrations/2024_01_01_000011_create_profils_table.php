<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilsTable extends Migration
{
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('niveau_education', 100)->nullable();
            $table->string('situation_matrimoniale', 100)->nullable();
            $table->integer('nombre_enfants')->nullable();
            $table->string('activite_principale', 200)->nullable();
            $table->text('competences')->nullable();
            $table->text('centres_interet')->nullable();
            $table->string('langue_parlee', 100)->nullable();
            $table->text('besoins_specifiques')->nullable();
            $table->boolean('complete')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
}

