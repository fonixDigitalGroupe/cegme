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
        Schema::table('filtering_rules', function (Blueprint $table) {
            // Modifier le type de colonne pour accepter null
            $table->string('market_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('filtering_rules', function (Blueprint $table) {
            // Remettre en enum non nullable (on perdra les valeurs null)
            $table->enum('market_type', ['bureau_d_etude', 'consultant_individuel'])->nullable(false)->change();
        });
    }
};
