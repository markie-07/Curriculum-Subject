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
        Schema::table('compliance_links', function (Blueprint $table) {
            $table->string('group')->nullable()->after('year'); // For sub-headers like "ARTS..."
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compliance_links', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }
};
