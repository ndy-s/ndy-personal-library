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
        Schema::create('art_libraries', function (Blueprint $table) {
            $table->id();
            $table->string('title_en')->default('N/A');
            $table->string('title_jp')->default('N/A');
            $table->string('original')->default('N/A');
            $table->string('series')->default('N/A');
            $table->string('author')->default('N/A');
            $table->string('studio')->default('N/A');
            $table->string('year')->default('N/A');
            $table->string('lang')->default('N/A');
            $table->integer('page');
            $table->enum('status', ['Completed','Not Completed', 'N/A']);
            $table->string('source')->default('N/A');
            $table->string('desc')->default('N/A');
            $table->string('type');
            $table->string('link')->default('N/A');
            $table->string('path')->default('N/A');
            $table->string('image_path')->default('default.webp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('art_libraries');
    }
};
