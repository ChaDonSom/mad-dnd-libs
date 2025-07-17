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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_user_id')->constrained('users')->onDelete('cascade');
            $table->string('room_code', 8)->unique();
            $table->string('name')->nullable();
            $table->enum('status', ['waiting', 'in_progress', 'completed', 'abandoned'])->default('waiting');
            $table->enum('current_phase', ['submission', 'selection', 'voting', 'battle', 'summary'])->nullable();
            $table->json('configuration')->nullable();
            $table->integer('max_players')->default(8);
            $table->timestamps();

            $table->index(['status', 'current_phase']);
            $table->index('host_user_id');
        });

        Schema::create('game_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['host', 'player', 'spectator'])->default('player');
            $table->enum('status', ['active', 'disconnected', 'kicked'])->default('active');
            $table->timestamp('joined_at');
            $table->timestamps();

            $table->unique(['game_id', 'user_id']);
            $table->index(['game_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_participants');
        Schema::dropIfExists('games');
    }
};
