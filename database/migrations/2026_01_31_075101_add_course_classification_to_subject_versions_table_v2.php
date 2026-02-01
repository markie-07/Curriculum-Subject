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
        if (Schema::hasTable('subject_versions')) {
            Schema::table('subject_versions', function (Blueprint $table) {
                if (!Schema::hasColumn('subject_versions', 'course_classification')) {
                    $table->string('course_classification')->nullable()->after('subject_type');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('subject_versions')) {
            Schema::table('subject_versions', function (Blueprint $table) {
                if (Schema::hasColumn('subject_versions', 'course_classification')) {
                    $table->dropColumn('course_classification');
                }
            });
        }
    }
};
