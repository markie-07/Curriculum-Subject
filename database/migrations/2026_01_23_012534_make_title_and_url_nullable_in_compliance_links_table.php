<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('compliance_links')) {
            if (Schema::hasColumn('compliance_links', 'title')) {
                DB::statement('ALTER TABLE `compliance_links` MODIFY `title` VARCHAR(500) NULL');
            }
            if (Schema::hasColumn('compliance_links', 'url')) {
                DB::statement('ALTER TABLE `compliance_links` MODIFY `url` TEXT NULL');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('compliance_links')) {
            if (Schema::hasColumn('compliance_links', 'title')) {
                DB::statement('ALTER TABLE `compliance_links` MODIFY `title` VARCHAR(500) NOT NULL');
            }
            if (Schema::hasColumn('compliance_links', 'url')) {
                DB::statement('ALTER TABLE `compliance_links` MODIFY `url` TEXT NOT NULL');
            }
        }
    }
};
