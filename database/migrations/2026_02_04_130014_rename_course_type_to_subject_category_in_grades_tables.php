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
        if (Schema::hasTable('grades') && Schema::hasColumn('grades', 'course_type') && !Schema::hasColumn('grades', 'subject_category')) {
            Schema::table('grades', function (Blueprint $table) {
                $table->renameColumn('course_type', 'subject_category');
            });
        }

        if (Schema::hasTable('grade_versions') && Schema::hasColumn('grade_versions', 'course_type') && !Schema::hasColumn('grade_versions', 'subject_category')) {
            Schema::table('grade_versions', function (Blueprint $table) {
                $table->renameColumn('course_type', 'subject_category');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('grades') && Schema::hasColumn('grades', 'subject_category')) {
            Schema::table('grades', function (Blueprint $table) {
                $table->renameColumn('subject_category', 'course_type');
            });
        }

        if (Schema::hasTable('grade_versions') && Schema::hasColumn('grade_versions', 'subject_category')) {
            Schema::table('grade_versions', function (Blueprint $table) {
                $table->renameColumn('subject_category', 'course_type');
            });
        }
    }
};
