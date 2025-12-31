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
        Schema::create('activity_pole_keywords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_pole_id')->constrained()->onDelete('cascade');
            $table->string('keyword'); // Mot-clé à rechercher (insensible à la casse)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_pole_keywords');
    }
};
