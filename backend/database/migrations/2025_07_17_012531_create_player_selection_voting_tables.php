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
        Schema::create('player_loadouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('character_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('weapon_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('attack_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('selection_round')->default(1);
            $table->boolean('is_current')->default(true);
            $table->timestamps();

            $table->index(['game_id', 'user_id', 'is_current']);
            $table->index('selection_round');
        });

        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('voter_user_id')->constrained('users')->onDelete('cascade');
            $table->enum('category', ['character', 'weapon', 'attack']);
            $table->unsignedBigInteger('voted_item_id');
            $table->string('voted_item_type');
            $table->integer('rank')->comment('1st, 2nd, 3rd place etc.');
            $table->timestamps();

            $table->index(['game_id', 'category']);
            $table->index(['voter_user_id', 'category']);
            $table->index(['voted_item_id', 'voted_item_type']);
        });

        Schema::create('vote_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
            $table->string('item_type');
            $table->integer('total_score');
            $table->decimal('effectiveness_multiplier', 3, 2)->default(1.0);
            $table->integer('rank_position');
            $table->timestamps();

            $table->index(['game_id', 'item_type']);
            $table->index(['item_id', 'item_type']);
            $table->index('rank_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vote_results');
        Schema::dropIfExists('votes');
        Schema::dropIfExists('player_loadouts');
    }
};
