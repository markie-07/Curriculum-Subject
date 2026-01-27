<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            \App\Models\Program::create([
                'code' => $program[0],
                'description' => $program[1],
                'department' => 'College',
            ]);
        }

        foreach ($shsPrograms as $program) {
            \App\Models\Program::create([
                'code' => $program[0],
                'description' => $program[1],
                'department' => 'Senior High',
            ]);
        }
    }
}
