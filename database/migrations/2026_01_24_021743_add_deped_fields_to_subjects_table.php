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
            $table->text('q_1_performance_standards')->nullable();
            $table->text('q_1_performance_tasks')->nullable();
            $table->text('q_2_performance_standards')->nullable();
            $table->text('q_2_performance_tasks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn([
                'q_1_performance_standards',
                'q_1_performance_tasks',
                'q_2_performance_standards',
                'q_2_performance_tasks'
            ]);
        });
    }
};
