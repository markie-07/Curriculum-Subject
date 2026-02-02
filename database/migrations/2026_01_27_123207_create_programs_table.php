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
        if (!Schema::hasTable('programs')) {
            Schema::create('programs', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('description');
                $table->string('department'); // College or Senior High
                $table->timestamps();
            });
        }

        // Insert Default Data
        $collegePrograms = [
            ['BLIS', 'Bachelor in Library Information Science'],
            ['BPED', 'Bachelor in Physical Education'],
            ['BEED', 'Bachelor of Elementary Education'],
            ['BSAIS', 'Bachelor of Science in Accounting Information System'],
            ['BSBA FM', 'Bachelor of Science in Business Administration major in Financial Management'],
            ['BSBA HRM', 'Bachelor of Science in Business Administration major in Human Resource Management'],
            ['BSBA MM', 'Bachelor of Science in Business Administration major in Marketing Management'],
            ['BSCPE', 'Bachelor of Science in Computer Engineering'],
            ['BSCRIM', 'Bachelor of Science in Criminology'],
            ['BSENTREP', 'Bachelor of Science in Entrepreneurship'],
            ['BSHM', 'Bachelor of Science in Hospitality Management'],
            ['BSIT', 'Bachelor of Science in Information Technology'],
            ['BSOA', 'Bachelor of Science in Office Administration'],
            ['BSP', 'Bachelor of Science in Psychology'],
            ['BSTM', 'Bachelor of Science in Tourism Management'],
            ['BSED English', 'Bachelor of Secondary Education major in English'],
            ['BSED Filipino', 'Bachelor of Secondary Education major in Filipino'],
            ['BSED Math', 'Bachelor of Secondary Education major in Mathematics'],
            ['BSED Science', 'Bachelor of Secondary Education major in Science'],
            ['BSED Social Studies', 'Bachelor of Secondary Education major in Social Studies'],
            ['BSED Values', 'Bachelor of Secondary Education major in Values'],
            ['BTLED', 'Bachelor of Technology and Livelihood Education'],
            ['CPE', 'Certificate of Professional Education'],
        ];

        $shsPrograms = [
            ['ABM', 'Accountancy, Business and Management'],
            ['GAS', 'General Academic Strand'],
            ['HECF', 'Home Economics - Culinary Arts and Food Services'],
            ['HEHRS', 'Home Economics - Hotel and Restaurant Services'],
            ['HEHO', 'Home Economics - Hotel Operation'],
            ['HETEM', 'Home Economics - Tourism and Event Management'],
            ['HUMSS', 'Humanities and Social Sciences'],
            ['ICT-HW', 'Information and Communications Technology – Hardware'],
            ['ICT-CP', 'Information and Communications Technology – Programming'],
            ['ICT Animation', 'Information Communications and Technology – Animation'],
            ['ICT CCS', 'Information Communications and Technology - Contact Center Services'],
            ['ICT Visual Graphics', 'Information Communications and Technology - Visual Graphics'],
            ['STEM', 'Science, Technology, Engineering and Mathematics'],
            ['STEM – PBM', 'STEM - Pre Baccalaureate Maritime'],
        ];

        foreach ($collegePrograms as $program) {
            \Illuminate\Support\Facades\DB::table('programs')->insertOrIgnore([
                'code' => $program[0],
                'description' => $program[1],
                'department' => 'College',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($shsPrograms as $program) {
            \Illuminate\Support\Facades\DB::table('programs')->insertOrIgnore([
                'code' => $program[0],
                'description' => $program[1],
                'department' => 'Senior High',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
