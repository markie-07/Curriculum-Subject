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
        // 1. Handle 'grades' table - Check if columns exist first to prevent duplication on retry
        if (Schema::hasTable('grades') && !Schema::hasColumn('grades', 'effectivity_start_date')) {
            Schema::table('grades', function (Blueprint $table) {
                $table->date('effectivity_start_date')->nullable()->after('course_type');
                $table->date('effectivity_end_date')->nullable()->after('effectivity_start_date');
            });
        }

        // 2. Handle 'grade_versions' table - Recover if missing
        if (Schema::hasTable('grade_versions')) {
            // Table exists, just add columns if they don't exist
            if (!Schema::hasColumn('grade_versions', 'effectivity_start_date')) {
                Schema::table('grade_versions', function (Blueprint $table) {
                    $table->date('effectivity_start_date')->nullable()->after('course_type');
                    $table->date('effectivity_end_date')->nullable()->after('effectivity_start_date');
                });
            }
        } else {
            // Table MISSING: Re-create it (Self-healing)
            Schema::create('grade_versions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');
                $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
                $table->unsignedBigInteger('version_number');
                $table->json('components'); // Store the complete grade components as JSON
                $table->foreignId('curriculum_id')->nullable()->constrained('curriculums')->onDelete('cascade');
                $table->string('course_type')->nullable(); // 'minor' or 'major'
                $table->text('change_reason')->nullable();
                $table->string('changed_by')->nullable();
                
                // Add the new fields directly during creation
                $table->date('effectivity_start_date')->nullable();
                $table->date('effectivity_end_date')->nullable();
                
                $table->timestamps();
                
                // Index for faster lookups
                $table->index(['grade_id', 'version_number']);
                $table->index('subject_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('grades')) {
            Schema::table('grades', function (Blueprint $table) {
                $columnsToDrop = [];
                if (Schema::hasColumn('grades', 'effectivity_start_date')) {
                    $columnsToDrop[] = 'effectivity_start_date';
                }
                if (Schema::hasColumn('grades', 'effectivity_end_date')) {
                    $columnsToDrop[] = 'effectivity_end_date';
                }
                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }

        if (Schema::hasTable('grade_versions')) {
            Schema::table('grade_versions', function (Blueprint $table) {
                $columnsToDrop = [];
                if (Schema::hasColumn('grade_versions', 'effectivity_start_date')) {
                    $columnsToDrop[] = 'effectivity_start_date';
                }
                if (Schema::hasColumn('grade_versions', 'effectivity_end_date')) {
                    $columnsToDrop[] = 'effectivity_end_date';
                }
                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }
    }
};
