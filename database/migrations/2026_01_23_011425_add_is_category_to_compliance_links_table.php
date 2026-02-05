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
        if (Schema::hasTable('compliance_links')) {
            Schema::table('compliance_links', function (Blueprint $table) {
                if (!Schema::hasColumn('compliance_links', 'is_category')) {
                    $table->boolean('is_category')->default(false)->after('agency');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('compliance_links') && Schema::hasColumn('compliance_links', 'is_category')) {
            Schema::table('compliance_links', function (Blueprint $table) {
                $table->dropColumn('is_category');
            });
        }
    }
};
