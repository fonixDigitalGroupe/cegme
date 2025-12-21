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
        Schema::create('appel_offre_configs', function (Blueprint $table) {
            $table->id();
            $table->string('source_ptf'); // Source (PTF)
            $table->string('type_marche')->nullable(); // Type de Marché
            $table->string('zone_geographique')->nullable(); // Zone Géographique
            $table->string('site_officiel')->nullable(); // Site officiel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appel_offre_configs');
    }
};
