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
            if (!Schema::hasColumn('grades', 'curriculum_id')) {
                $table->unsignedBigInteger('curriculum_id')->nullable()->after('subject_id');
            }
            if (!Schema::hasColumn('grades', 'course_type')) {
                $table->enum('course_type', ['minor', 'major'])->nullable()->after('curriculum_id');
            }
            
            // Add foreign key constraint only if column was just added
            if (!Schema::hasColumn('grades', 'curriculum_id')) {
                // Foreign key will be added when column is created
            } else {
                // Check if foreign key doesn't already exist before adding
                try {
                    $table->foreign('curriculum_id')->references('id')->on('curriculums')->onDelete('cascade');
                } catch (\Exception $e) {
                    // Foreign key already exists, skip
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign(['curriculum_id']);
            $table->dropColumn(['curriculum_id', 'course_type']);
        });
    }
};
