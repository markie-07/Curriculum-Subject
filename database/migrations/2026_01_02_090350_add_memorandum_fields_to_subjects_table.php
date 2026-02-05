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
        if (Schema::hasTable('subjects')) {
            Schema::table('subjects', function (Blueprint $table) {
                if (!Schema::hasColumn('subjects', 'memorandum')) {
                    $table->string('memorandum')->nullable()->after('subject_type');
                }
                if (!Schema::hasColumn('subjects', 'memorandum_year')) {
                    $table->string('memorandum_year')->nullable()->after('memorandum');
                }
                if (!Schema::hasColumn('subjects', 'memorandum_category')) {
                    $table->string('memorandum_category')->nullable()->after('memorandum_year');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('subjects')) {
            Schema::table('subjects', function (Blueprint $table) {
                $columnsToDrop = [];
                foreach (['memorandum', 'memorandum_year', 'memorandum_category'] as $column) {
                    if (Schema::hasColumn('subjects', $column)) {
                        $columnsToDrop[] = $column;
                    }
                }
                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }
    }
};
