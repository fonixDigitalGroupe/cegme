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
        if (!Schema::hasTable('filtering_rule_activity_poles')) {
            Schema::create('filtering_rule_activity_poles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('filtering_rule_id')->constrained()->onDelete('cascade');
                $table->foreignId('activity_pole_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                
                // Éviter les doublons
                $table->unique(['filtering_rule_id', 'activity_pole_id'], 'frap_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filtering_rule_activity_poles');
    }
};
