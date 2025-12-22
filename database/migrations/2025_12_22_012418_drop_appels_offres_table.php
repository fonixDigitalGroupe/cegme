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
        // Migration annulée - la table appels_offres doit être conservée
        // Schema::dropIfExists('appels_offres');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Migration annulée
    }
};
