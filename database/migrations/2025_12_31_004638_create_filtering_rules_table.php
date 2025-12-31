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
        Schema::create('filtering_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom de la règle (ex: "Règle BAD - Bureau d'études")
            $table->string('source'); // Source du scraper (ex: "African Development Bank", "AFD", etc.)
            $table->enum('market_type', ['bureau_d_etude', 'consultant_individuel']); // Type de marché obligatoire
            $table->boolean('is_active')->default(true); // Activer/désactiver la règle
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filtering_rules');
    }
};
