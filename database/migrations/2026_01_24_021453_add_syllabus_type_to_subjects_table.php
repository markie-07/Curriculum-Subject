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
        Schema::table('subjects', function (Blueprint $table) {
            $table->string('syllabus_type')->default('CHED')->after('subject_type');
            
            // Add deped_data, time_allotment, schedule if they are missing
            // These might be in another migration, but to be safe and ensure everything exists
            if (!Schema::hasColumn('subjects', 'deped_data')) {
                $table->json('deped_data')->nullable();
            }
            if (!Schema::hasColumn('subjects', 'time_allotment')) {
                $table->string('time_allotment')->nullable();
            }
            if (!Schema::hasColumn('subjects', 'schedule')) {
                $table->string('schedule')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn(['syllabus_type', 'deped_data', 'time_allotment', 'schedule']);
        });
    }
};
