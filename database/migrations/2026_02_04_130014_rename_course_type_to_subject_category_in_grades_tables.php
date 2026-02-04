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
        Schema::table('grades', function (Blueprint $table) {
            $table->renameColumn('course_type', 'subject_category');
        });

        Schema::table('grade_versions', function (Blueprint $table) {
            $table->renameColumn('course_type', 'subject_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->renameColumn('subject_category', 'course_type');
        });

        Schema::table('grade_versions', function (Blueprint $table) {
            $table->renameColumn('subject_category', 'course_type');
        });
    }
};
