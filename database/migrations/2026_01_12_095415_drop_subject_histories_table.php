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
        // Drop the orphaned subject_histories table
        Schema::dropIfExists('subject_histories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally recreate the table if needed in the future
        // For now, we leave this empty as the table was orphaned
    }
};
