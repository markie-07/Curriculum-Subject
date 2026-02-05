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
        // 1. Set Minor types
        DB::table('subjects')
            ->whereIn('course_classification', [
                'General Education', 
                'NSTP 1', 
                'NSTP 2', 
                'Core Subjects'
            ])
            ->update(['subject_type' => 'Minor']);

        // 2. Set Major types (Explicit List)
        DB::table('subjects')
            ->whereIn('course_classification', [
                'Research', 
                'OJT/Practicum', 
                'Applied Track Subjects', 
                'Specialized Subjects'
            ])
            ->update(['subject_type' => 'Major']);

        // 3. Set Major types (Wildcard for Professional Subjects)
        DB::table('subjects')
            ->where('course_classification', 'LIKE', 'Professional Subject%')
            ->update(['subject_type' => 'Major']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No easy reverse since we are overwriting data based on logic logic
    }
};
