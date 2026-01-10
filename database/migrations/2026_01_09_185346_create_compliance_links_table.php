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
        if (!Schema::hasTable('compliance_links')) {
            Schema::create('compliance_links', function (Blueprint $table) {
                $table->id();
                $table->string('agency'); // CHED or DepEd
                $table->string('year'); // e.g., 2024, 2025
                $table->string('title'); // Document title
                $table->text('url'); // Document URL
                $table->timestamps();
                
                // Index for faster queries
                $table->index(['agency', 'year']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliance_links');
    }
};
