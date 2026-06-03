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
        Schema::create('jurumiyah_chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('jurumiyah_chapters')->nullOnDelete();
            $table->string('title');
            $table->text('definition');
            $table->integer('order_num')->default(0)->index();
            $table->integer('learning_step')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurumiyah_chapters');
    }
};
