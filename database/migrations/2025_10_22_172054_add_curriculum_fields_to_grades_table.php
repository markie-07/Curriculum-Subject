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
        });
        
        // Add foreign key constraint in a separate schema call to check if it exists
        Schema::table('grades', function (Blueprint $table) {
            // Check if foreign key constraint already exists
            $databaseName = config('database.connections.mysql.database');
            $foreignKeyExists = \DB::select("
                SELECT COUNT(*) as count 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = ? 
                AND TABLE_NAME = 'grades' 
                AND COLUMN_NAME = 'curriculum_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$databaseName]);
            
            if ($foreignKeyExists[0]->count == 0 && Schema::hasColumn('grades', 'curriculum_id')) {
                $table->foreign('curriculum_id')->references('id')->on('curriculums')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('grades')) {
            Schema::table('grades', function (Blueprint $table) {
                // Check if foreign key exists before dropping
                $databaseName = config('database.connections.mysql.database');
                $foreignKeyExists = \DB::select("
                    SELECT COUNT(*) as count 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = ? 
                    AND TABLE_NAME = 'grades' 
                    AND COLUMN_NAME = 'curriculum_id' 
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ", [$databaseName]);
                
                if ($foreignKeyExists[0]->count > 0) {
                    $table->dropForeign(['curriculum_id']);
                }
                
                if (Schema::hasColumn('grades', 'curriculum_id')) {
                    $table->dropColumn('curriculum_id');
                }
                if (Schema::hasColumn('grades', 'course_type')) {
                    $table->dropColumn('course_type');
                }
            });
        }
    }
};
