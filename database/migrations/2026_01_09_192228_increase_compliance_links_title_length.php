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
        if (Schema::hasTable('compliance_links') && Schema::hasColumn('compliance_links', 'title')) {
            Schema::table('compliance_links', function (Blueprint $table) {
                $table->text('title')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('compliance_links')) {
            Schema::table('compliance_links', function (Blueprint $table) {
                // $table->string('title')->change(); // Disabled to prevent SQLSTATE[22001] truncation error on rollback
            });
        }
    }
};
