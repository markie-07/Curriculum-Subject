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
        Schema::table('export_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('export_histories', 'export_type')) {
                $table->string('export_type')->default('curriculum')->after('format');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('export_histories', function (Blueprint $table) {
            if (Schema::hasColumn('export_histories', 'export_type')) {
                $table->dropColumn('export_type');
            }
        });
    }
};
