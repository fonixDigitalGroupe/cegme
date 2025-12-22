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
        Schema::table('appels_offres', function (Blueprint $table) {
            // Ajouter les colonnes seulement si elles n'existent pas déjà
            if (!Schema::hasColumn('appels_offres', 'source')) {
                $table->string('source')->nullable()->after('titre');
            }
            if (!Schema::hasColumn('appels_offres', 'type_marche')) {
                $table->string('type_marche')->nullable()->after('source');
            }
            if (!Schema::hasColumn('appels_offres', 'zone_geographique')) {
                $table->string('zone_geographique')->nullable()->after('type_marche');
            }
            if (!Schema::hasColumn('appels_offres', 'description')) {
                $table->text('description')->nullable()->after('zone_geographique');
            }
            if (!Schema::hasColumn('appels_offres', 'date_limite')) {
                $table->date('date_limite')->nullable()->after('pays');
            }
            if (!Schema::hasColumn('appels_offres', 'is_actif')) {
                $table->boolean('is_actif')->default(true)->after('lien_source');
            }
            if (!Schema::hasColumn('appels_offres', 'image')) {
                $table->text('image')->nullable()->after('is_actif');
            }
            if (!Schema::hasColumn('appels_offres', 'mots_cles')) {
                $table->text('mots_cles')->nullable()->after('image');
            }
            if (!Schema::hasColumn('appels_offres', 'pole_activite')) {
                $table->string('pole_activite')->nullable()->after('mots_cles');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appels_offres', function (Blueprint $table) {
            $columns = ['source', 'type_marche', 'zone_geographique', 'description', 'date_limite', 'is_actif', 'image', 'mots_cles', 'pole_activite'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('appels_offres', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
