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
        Schema::create('huruf_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bab_id')->constrained('bab_jurumiyah')->onDelete('cascade');
            $table->string('kata');
            $table->string('jenis_partikel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('huruf_tugas');
    }
};
