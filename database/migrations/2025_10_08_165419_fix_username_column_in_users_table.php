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
        Schema::table('users', function (Blueprint $table) {
            // Check if the unique constraint already exists
            $databaseName = config('database.connections.mysql.database');
            $uniqueExists = \DB::select("
                SELECT COUNT(*) as count 
                FROM information_schema.STATISTICS 
                WHERE TABLE_SCHEMA = ? 
                AND TABLE_NAME = 'users' 
                AND INDEX_NAME = 'users_username_unique'
            ", [$databaseName]);
            
            $hasUniqueConstraint = $uniqueExists[0]->count > 0;
            
            // Add username column if it doesn't exist
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable()->after('email');
            } elseif (!$hasUniqueConstraint) {
                // If username column exists but doesn't have unique constraint, add it
                $table->string('username')->unique()->nullable()->change();
            }
            // If both column and unique constraint exist, do nothing
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if the unique constraint exists before trying to drop it
            if (Schema::hasColumn('users', 'username')) {
                $databaseName = config('database.connections.mysql.database');
                $uniqueExists = \DB::select("
                    SELECT COUNT(*) as count 
                    FROM information_schema.STATISTICS 
                    WHERE TABLE_SCHEMA = ? 
                    AND TABLE_NAME = 'users' 
                    AND INDEX_NAME = 'users_username_unique'
                ", [$databaseName]);
                
                if ($uniqueExists[0]->count > 0) {
                    $table->dropUnique(['username']);
                }
                $table->dropColumn('username');
            }
        });
    }
};
