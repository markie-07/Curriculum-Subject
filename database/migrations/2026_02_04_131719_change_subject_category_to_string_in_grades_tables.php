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
        if (Schema::hasTable('grades') && Schema::hasColumn('grades', 'subject_category')) {
            Schema::table('grades', function (Blueprint $table) {
                $table->string('subject_category')->nullable()->change();
            });
        }

        if (Schema::hasTable('grade_versions') && Schema::hasColumn('grade_versions', 'subject_category')) {
            Schema::table('grade_versions', function (Blueprint $table) {
                $table->string('subject_category')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // down logic reserved
    }
};
