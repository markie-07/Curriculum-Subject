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
                if (Schema::hasColumn('subjects', 'prepared_by')) {
                    $table->text('prepared_by')->nullable()->change();
                }
                if (Schema::hasColumn('subjects', 'reviewed_by')) {
                    $table->text('reviewed_by')->nullable()->change();
                }
                if (Schema::hasColumn('subjects', 'approved_by')) {
                    $table->text('approved_by')->nullable()->change();
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
                // Revert strictness if needed, but safe to leave generally. 
                // Ideally we'd know previous state, but since we are fixing a bug, 
                // rolling back should likely revert to non-nullable strings? 
                // For now, let's reverse to string but keep nullable as original schema had them nullable.
                if (Schema::hasColumn('subjects', 'prepared_by')) {
                    $table->string('prepared_by')->nullable()->change();
                }
                if (Schema::hasColumn('subjects', 'reviewed_by')) {
                    $table->string('reviewed_by')->nullable()->change();
                }
                if (Schema::hasColumn('subjects', 'approved_by')) {
                    $table->string('approved_by')->nullable()->change();
                }
            });
        }
    }
};
