<?php

use App\Models\ArtLibrary;
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
        Schema::create('sub_art_libraries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ArtLibrary::class);
            $table->string('title')->default('N/A');
            $table->string('sub_desc')->default('N/A');
            $table->string('link')->default('#');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_art_libraries');
    }
};
