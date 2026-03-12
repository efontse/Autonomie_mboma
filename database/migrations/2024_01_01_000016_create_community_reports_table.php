<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityReportsTable extends Migration
{
    public function up(): void
    {
        Schema::create('community_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('motif', ['spam', 'harcelement', 'contenu_inapproprie', 'fausse_information', 'autre']);
            $table->text('details')->nullable();
            $table->enum('statut', ['en_attente', 'traite', 'rejete'])->default('en_attente');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('community_posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['post_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_reports');
    }
}
