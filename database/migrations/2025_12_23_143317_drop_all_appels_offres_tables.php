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
        // Supprimer les tables dans l'ordre inverse de création (pour respecter les clés étrangères)
        Schema::dropIfExists('appels_offres');
        Schema::dropIfExists('appel_offre_configs');
        Schema::dropIfExists('type_marches');
        Schema::dropIfExists('pole_activites');
        Schema::dropIfExists('mots_cles');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cette migration ne peut pas être annulée car elle supprime définitivement les tables
        // Pour restaurer, il faudrait réexécuter toutes les migrations de création
    }
};
