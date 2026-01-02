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
            $table->string('memorandum')->nullable()->after('subject_type');
            $table->string('memorandum_year')->nullable()->after('memorandum');
            $table->string('memorandum_category')->nullable()->after('memorandum_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn(['memorandum', 'memorandum_year', 'memorandum_category']);
        });
    }
};
