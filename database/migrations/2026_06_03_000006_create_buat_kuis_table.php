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
        Schema::create('buat_kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bab_id')->constrained('bab_jurumiyah')->onDelete('cascade');
            $table->string('judul');
            $table->json('data_pertanyaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buat_kuis');
    }
};
