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
        Schema::create('bosses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->integer('max_health');
            $table->integer('current_health');
            $table->string('image_url')->nullable();
            $table->json('special_abilities')->nullable();
            $table->timestamps();

            $table->index('game_id');
        });

        Schema::create('battle_rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->integer('round_number');
            $table->integer('current_turn')->default(1);
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->timestamps();

            $table->index(['game_id', 'round_number']);
            $table->index('status');
        });

        Schema::create('battle_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('round_id')->constrained('battle_rounds')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('loadout_id')->constrained('player_loadouts')->onDelete('cascade');
            $table->integer('dice_roll');
            $table->integer('base_damage');
            $table->decimal('multiplier_bonus', 3, 2)->default(1.0);
            $table->integer('total_damage');
            $table->json('animation_data')->nullable();
            $table->enum('success_level', ['critical', 'hit', 'miss'])->default('hit');
            $table->timestamps();

            $table->index(['game_id', 'round_id']);
            $table->index(['user_id', 'round_id']);
            $table->index('success_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battle_actions');
        Schema::dropIfExists('battle_rounds');
        Schema::dropIfExists('bosses');
    }
};
