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
        Schema::create('filtering_rule_countries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filtering_rule_id')->constrained()->onDelete('cascade');
            $table->string('country'); // Nom du pays
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filtering_rule_countries');
    }
};
