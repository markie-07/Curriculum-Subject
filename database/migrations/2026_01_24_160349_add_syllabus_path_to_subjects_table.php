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
                if (!Schema::hasColumn('subjects', 'syllabus_path')) {
                    $table->string('syllabus_path')->nullable()->after('deped_data');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('subjects') && Schema::hasColumn('subjects', 'syllabus_path')) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->dropColumn('syllabus_path');
            });
        }
    }
};
