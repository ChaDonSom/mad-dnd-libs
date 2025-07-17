<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->enum('result', ['victory', 'defeat']);
            $table->integer('total_damage_dealt');
            $table->integer('rounds_completed');
            $table->foreignId('mvp_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('team_score');
            $table->timestamps();

            $table->unique('game_id');
            $table->index('result');
        });

        Schema::create('superlatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category');
            $table->string('title');
            $table->text('description');
            $table->timestamps();

            $table->index(['game_id', 'category']);
            $table->index('user_id');
        });

        Schema::create('calling_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('character_summary');
            $table->json('best_attack_summary');
            $table->string('image_url')->nullable();
            $table->string('share_token')->unique();
            $table->timestamps();

            $table->unique(['game_id', 'user_id']);
            $table->index('share_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calling_cards');
        Schema::dropIfExists('superlatives');
        Schema::dropIfExists('game_results');
    }
};
