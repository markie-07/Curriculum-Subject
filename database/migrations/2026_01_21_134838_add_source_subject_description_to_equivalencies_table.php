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
        if (Schema::hasTable('equivalencies')) {
            Schema::table('equivalencies', function (Blueprint $table) {
                if (!Schema::hasColumn('equivalencies', 'source_subject_description')) {
                    $table->text('source_subject_description')->nullable()->after('source_subject_name');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('equivalencies') && Schema::hasColumn('equivalencies', 'source_subject_description')) {
            Schema::table('equivalencies', function (Blueprint $table) {
                $table->dropColumn('source_subject_description');
            });
        }
    }
};
