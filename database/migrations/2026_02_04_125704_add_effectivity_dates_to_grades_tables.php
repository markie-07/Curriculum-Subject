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
            $table->date('effectivity_start_date')->nullable()->after('course_type');
            $table->date('effectivity_end_date')->nullable()->after('effectivity_start_date');
        });

        Schema::table('grade_versions', function (Blueprint $table) {
            $table->date('effectivity_start_date')->nullable()->after('course_type');
            $table->date('effectivity_end_date')->nullable()->after('effectivity_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn(['effectivity_start_date', 'effectivity_end_date']);
        });

        Schema::table('grade_versions', function (Blueprint $table) {
            $table->dropColumn(['effectivity_start_date', 'effectivity_end_date']);
        });
    }
};
