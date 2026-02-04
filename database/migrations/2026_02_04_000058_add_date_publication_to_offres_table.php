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
        Schema::table('offres', function (Blueprint $table) {
            if (!Schema::hasColumn('offres', 'date_publication')) {
                $table->date('date_publication')->nullable()->after('notice_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offres', function (Blueprint $table) {
            if (Schema::hasColumn('offres', 'date_publication')) {
                $table->dropColumn('date_publication');
            }
        });
    }
};
