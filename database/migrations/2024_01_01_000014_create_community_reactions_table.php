<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityReactionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('community_reactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->string('type'); // like, love, clap, handshake
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('community_posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['post_id', 'user_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_reactions');
    }
}
