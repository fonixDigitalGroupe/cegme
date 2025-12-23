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
        // Supprimer la table si elle existe déjà
        Schema::dropIfExists('offres');
        
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('acheteur')->nullable();
            $table->string('pays')->nullable();
            $table->date('date_limite_soumission')->nullable();
            $table->string('lien_source');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};
