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
        Schema::create('grammar_examples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained('jurumiyah_chapters')->cascadeOnDelete();
            $table->string('arabic_text');
            $table->string('translation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grammar_examples');
    }
};
