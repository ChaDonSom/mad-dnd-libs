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
        Schema::create('madlibs_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['bio', 'journey', 'battle']);
            $table->text('template_text');
            $table->json('required_word_types');
            $table->integer('difficulty_level')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'is_active']);
            $table->index('difficulty_level');
        });

        Schema::create('madlibs_prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->constrained('madlibs_templates')->onDelete('cascade');
            $table->string('word_type');
            $table->string('prompt_text');
            $table->integer('position_in_template');
            $table->boolean('is_required')->default(true);
            $table->timestamps();

            $table->index(['game_id', 'template_id']);
            $table->index('word_type');
        });

        Schema::create('madlibs_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('prompt_id')->constrained('madlibs_prompts')->onDelete('cascade');
            $table->string('submitted_word');
            $table->boolean('is_validated')->default(false);
            $table->timestamp('submitted_at');
            $table->timestamps();

            $table->unique(['game_id', 'user_id', 'prompt_id']);
            $table->index(['game_id', 'user_id']);
            $table->index('is_validated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('madlibs_submissions');
        Schema::dropIfExists('madlibs_prompts');
        Schema::dropIfExists('madlibs_templates');
    }
};
