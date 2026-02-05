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
        if (Schema::hasTable('curriculum_subject')) {
            Schema::table('curriculum_subject', function (Blueprint $table) {
                if (Schema::hasColumn('curriculum_subject', 'year')) {
                    $table->integer('year')->nullable()->change();
                }
                if (Schema::hasColumn('curriculum_subject', 'semester')) {
                    $table->integer('semester')->nullable()->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('curriculum_subject')) {
            Schema::table('curriculum_subject', function (Blueprint $table) {
                if (Schema::hasColumn('curriculum_subject', 'year')) {
                    $table->integer('year')->nullable(false)->change();
                }
                if (Schema::hasColumn('curriculum_subject', 'semester')) {
                    $table->integer('semester')->nullable(false)->change();
                }
            });
        }
    }
};
