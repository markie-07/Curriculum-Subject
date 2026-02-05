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
        Schema::table('curriculums', function (Blueprint $table) {
            // Check if the unique constraint exists before trying to drop it
            $databaseName = config('database.connections.mysql.database');
            $uniqueExists = \DB::select("
                SELECT COUNT(*) as count 
                FROM information_schema.STATISTICS 
                WHERE TABLE_SCHEMA = ? 
                AND TABLE_NAME = 'curriculums' 
                AND INDEX_NAME = 'curriculums_program_code_unique'
            ", [$databaseName]);
            
            if ($uniqueExists[0]->count > 0) {
                $table->dropUnique(['program_code']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('curriculums') && Schema::hasColumn('curriculums', 'program_code')) {
            Schema::table('curriculums', function (Blueprint $table) {
                // Check if unique constraint doesn't already exist before adding it
                $databaseName = config('database.connections.mysql.database');
                $uniqueExists = \DB::select("
                    SELECT COUNT(*) as count 
                    FROM information_schema.STATISTICS 
                    WHERE TABLE_SCHEMA = ? 
                    AND TABLE_NAME = 'curriculums' 
                    AND INDEX_NAME = 'curriculums_program_code_unique'
                ", [$databaseName]);
                
                if ($uniqueExists[0]->count == 0) {
                    $table->unique('program_code');
                }
            });
        }
    }
};
