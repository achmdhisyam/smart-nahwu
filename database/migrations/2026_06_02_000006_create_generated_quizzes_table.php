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
        Schema::create('generated_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained('jurumiyah_chapters')->cascadeOnDelete();
            $table->string('title');
            $table->json('questions_data');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_quizzes');
    }
};
