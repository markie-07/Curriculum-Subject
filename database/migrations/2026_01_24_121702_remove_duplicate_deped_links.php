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
        DB::table('compliance_links')
            ->where('agency', 'DepEd')
            ->whereIn('year', ['Curriculum Guides (Academic)', 'Curriculum Guides (TechPro)'])
            ->whereNull('group') // Only delete the ones without groups (the duplicates)
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse needed as we can't restore deleted data without a backup,
        // and re-seeding would restore them anyway.
    }
};
