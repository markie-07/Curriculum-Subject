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
        Schema::table('curriculums', function (Blueprint $table) {
            if (!Schema::hasColumn('curriculums', 'expiration_date')) {
                $table->date('expiration_date')->nullable()->after('total_units');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('curriculums', function (Blueprint $table) {
            $table->dropColumn('expiration_date');
        });
    }
};
