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
        Schema::create('progres_pengguna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bab_id')->constrained('bab_jurumiyah')->onDelete('cascade');
            $table->integer('jumlah_percobaan')->default(0);
            $table->decimal('skor_terbaik', 5, 2)->nullable();
            $table->string('status')->default('learning'); // learning, mastered
            $table->timestamps();

            $table->unique(['user_id', 'bab_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_pengguna');
    }
};
