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
        if (!Schema::hasTable('appels_offres')) {
            Schema::create('appels_offres', function (Blueprint $table) {
                $table->id();
                $table->string('titre');
                $table->string('source')->nullable();
                $table->string('type_marche')->nullable();
                $table->string('zone_geographique')->nullable();
                $table->text('description')->nullable();
                $table->string('acheteur')->nullable();
                $table->string('pays')->nullable();
                $table->date('date_limite')->nullable();
                $table->text('lien_source')->nullable();
                $table->boolean('is_actif')->default(true);
                $table->text('image')->nullable();
                $table->text('mots_cles')->nullable();
                $table->string('pole_activite')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appels_offres');
    }
};

