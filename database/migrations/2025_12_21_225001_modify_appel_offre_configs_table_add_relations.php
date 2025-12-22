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
        Schema::table('appel_offre_configs', function (Blueprint $table) {
            // Supprimer l'ancien champ type_marche (string)
            $table->dropColumn('type_marche');
            
            // Ajouter les nouvelles relations
            $table->foreignId('type_marche_id')->nullable()->constrained('type_marches')->onDelete('set null');
            $table->foreignId('pole_activite_id')->nullable()->constrained('pole_activites')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appel_offre_configs', function (Blueprint $table) {
            // Restaurer l'ancien champ
            $table->string('type_marche')->nullable();
            
            // Supprimer les relations
            $table->dropForeign(['type_marche_id']);
            $table->dropForeign(['pole_activite_id']);
            $table->dropColumn(['type_marche_id', 'pole_activite_id']);
        });
    }
};
