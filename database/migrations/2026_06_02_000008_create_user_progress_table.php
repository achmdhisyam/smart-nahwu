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
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('chapter_id')->constrained('jurumiyah_chapters')->cascadeOnDelete();
            $table->enum('status', ['locked', 'learning', 'mastered'])->default('locked');
            $table->integer('attempts_count')->default(0);
            $table->decimal('best_score', 5, 2)->nullable();
            $table->timestamp('last_attempt_at')->nullable();
            $table->timestamps();

            // Cegah duplikasi record user-chapter
            $table->unique(['user_id', 'chapter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
