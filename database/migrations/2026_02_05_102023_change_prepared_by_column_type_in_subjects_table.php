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
        if (Schema::hasTable('subjects') && Schema::hasColumn('subjects', 'prepared_by')) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->text('prepared_by')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('subjects') && Schema::hasColumn('subjects', 'prepared_by')) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->string('prepared_by')->change();
            });
        }
    }
};
