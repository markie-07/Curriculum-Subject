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
        if (Schema::hasTable('subjects')) {
            Schema::table('subjects', function (Blueprint $table) {
                if (!Schema::hasColumn('subjects', 'q_1_performance_standards')) {
                    $table->text('q_1_performance_standards')->nullable();
                }
                if (!Schema::hasColumn('subjects', 'q_1_performance_tasks')) {
                    $table->text('q_1_performance_tasks')->nullable();
                }
                if (!Schema::hasColumn('subjects', 'q_2_performance_standards')) {
                    $table->text('q_2_performance_standards')->nullable();
                }
                if (!Schema::hasColumn('subjects', 'q_2_performance_tasks')) {
                    $table->text('q_2_performance_tasks')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('subjects')) {
            Schema::table('subjects', function (Blueprint $table) {
                $columnsToDrop = [];
                foreach (['q_1_performance_standards', 'q_1_performance_tasks', 'q_2_performance_standards', 'q_2_performance_tasks'] as $column) {
                    if (Schema::hasColumn('subjects', $column)) {
                        $columnsToDrop[] = $column;
                    }
                }
                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }
    }
};
