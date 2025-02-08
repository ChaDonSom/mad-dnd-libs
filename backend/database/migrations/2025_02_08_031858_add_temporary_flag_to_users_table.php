<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_temporary')->default(false);
            $table->string('temp_id')->nullable()->unique();
            $table->timestamp('expires_at')->nullable();
            $table->json('session_data')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_temporary', 'temp_id', 'expires_at', 'session_data']);
        });
    }
};
