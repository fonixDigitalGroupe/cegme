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
            if (!Schema::hasColumn('offres', 'link_type')) {
                $table->string('link_type')->nullable()->after('lien_source');
            }
            if (!Schema::hasColumn('offres', 'detail_url')) {
                $table->string('detail_url')->nullable()->after('link_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offres', function (Blueprint $table) {
            if (Schema::hasColumn('offres', 'link_type')) {
                $table->dropColumn('link_type');
            }
            if (Schema::hasColumn('offres', 'detail_url')) {
                $table->dropColumn('detail_url');
            }
        });
    }
};
