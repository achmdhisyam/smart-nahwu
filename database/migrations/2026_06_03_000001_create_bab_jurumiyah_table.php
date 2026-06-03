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
        Schema::create('bab_jurumiyah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('induk_id')->nullable()->constrained('bab_jurumiyah')->nullOnDelete();
            $table->string('judul');
            $table->text('definisi');
            $table->integer('nomor_urut')->default(0)->index();
            $table->integer('langkah_belajar')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bab_jurumiyah');
    }
};
