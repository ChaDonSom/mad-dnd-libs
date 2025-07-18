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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->json('madlibs_source')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->index(['game_id', 'is_available']);
        });

        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->json('madlibs_source')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->index(['game_id', 'is_available']);
        });

        Schema::create('attacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->json('madlibs_source')->nullable();
            $table->enum('animation_type', ['slash', 'thrust', 'magic', 'projectile', 'special'])->default('slash');
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->index(['game_id', 'is_available']);
            $table->index('animation_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attacks');
        Schema::dropIfExists('weapons');
        Schema::dropIfExists('characters');
    }
};
