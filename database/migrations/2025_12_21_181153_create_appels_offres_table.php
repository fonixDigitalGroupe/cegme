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
        Schema::create('appels_offres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('acheteur')->nullable(); // Nom de l'institution
            $table->string('pays')->nullable();
            $table->date('date_limite_soumission')->nullable();
            $table->text('lien_source')->nullable(); // URL de la source
            $table->boolean('is_published')->default(false); // Pour publication automatique
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appels_offres');
    }
};
