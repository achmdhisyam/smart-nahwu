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
        Schema::create('arabic_particles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained('jurumiyah_chapters')->cascadeOnDelete();
            $table->string('particle_text', 50)->index();
            $table->enum('particle_type', ['jar', 'nashab', 'jazm', 'athaf'])->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arabic_particles');
    }
};
