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
        Schema::create('grading_templates', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., 'gen_ed'
            $table->string('name'); // e.g., 'General Education'
            $table->text('description')->nullable();
            $table->json('periods'); // Stores prelim/midterm/finals weights
            $table->json('components'); // Stores class standing, project, exam structure
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading_templates');
    }
};
