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
        Schema::create('grammar_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained('jurumiyah_chapters')->cascadeOnDelete();
            $table->string('rule_code', 50)->unique()->index();
            $table->text('rule_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grammar_rules');
    }
};
