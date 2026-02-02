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
        if (!Schema::hasTable('system_settings')) {
            Schema::create('system_settings', function (Blueprint $table) {
                $table->id();
                $table->string('category', 100); // e.g., 'vision', 'mission', 'legend', 'policies'
                $table->string('key', 100); // e.g., 'school_vision', 'dept_vision_default'
                $table->text('value'); // The actual content
                $table->text('description')->nullable(); // Optional description
                $table->timestamps();
                
                // Make category + key unique
                $table->unique(['category', 'key']);
            });
        }

        // Insert Default Data
        $settings = [
            // ================== VISION ==================
            [
                'category' => 'vision',
                'key' => 'school',
                'value' => 'BCP is committed to provide and promote quality education with a unique, modern and research-based curriculum with delivery systems geared towards excellence.',
                'description' => 'School Vision Statement',
            ],
            [
                'category' => 'vision',
                'key' => 'dept_default',
                'value' => "To improve the quality of student's input and by promoting IT enabled, market driven and internationally comparable programs through quality assurance systems, upgrading faculty qualifications and establishing international linkages.",
                'description' => 'Default Department Vision (for Professional Subjects)',
            ],
            [
                'category' => 'vision',
                'key' => 'dept_general_education',
                'value' => 'BCP General Education Department innovates, investigates and discovers greatness and prosperity through oneness.',
                'description' => 'General Education Department Vision',
            ],

            // ================== MISSION ==================
            [
                'category' => 'mission',
                'key' => 'school',
                'value' => 'To produce self-motivated and self-directed individual who aims for academic excellence, God-fearing, peaceful, healthy and productive successful citizens.',
                'description' => 'School Mission Statement',
            ],
            [
                'category' => 'mission',
                'key' => 'dept_default',
                'value' => 'The College of Computer Studies is committed to provide quality information and communication technology education through the use of modern and transformation learning teaching process.',
                'description' => 'Default Department Mission (for Professional Subjects)',
            ],
            [
                'category' => 'mission',
                'key' => 'dept_general_education',
                'value' => 'To awaken the curiosity and ignite passion of individuals to excel independency in academic endeavors towards their development into ethically and morally strong people.',
                'description' => 'General Education Department Mission',
            ],

            // ================== PHILOSOPHY ==================
            [
                'category' => 'philosophy',
                'key' => 'school',
                'value' => "BCP advocates threefold core values: \"Fides\", \"Faith; \"Ratio\", Reason; Pax. Peace. \"Fides\" represents BCPs, endeavors for expansion, development, and growth amidst the challenges of the new millennium. \"Ratio\" symbolizes BCP's efforts to provide an education which can be man's tool to be liberated from all forms of ignorance and poverty. \"Pax\". BCP is a forerunner in the promotion of a harmonious relationship between the different sectors of its academic community.",
                'description' => 'School Philosophy',
            ],
            [
                'category' => 'philosophy',
                'key' => 'dept_general_education',
                'value' => "General Education advocates threefold core values \"Devotion\", \"Serenity', \"Determination\" \"Devotion\" represents General Education commitment and dedication to provide quality education that will fuel the passion of the students for learning in driving academic success \"Serenity\" symbolizes a crucial element in the overall well-being and success of students by means of creating a more supportive, conducive, and enriching learning environment, enabling them to thrive academically, emotionally, and personally. \"Determination\" general education is committed to provide a high-quality, equitable, and supportive learning environment that empowers students to succeed.",
                'description' => 'General Education Department Philosophy',
            ],

            // ================== CORE VALUES ==================
            [
                'category' => 'core_values',
                'key' => 'text',
                'value' => "FAITH, KNOWLEDGE, CHARITY AND HUMILITY\nFAITH (Fides) represents BCP's endeavor for expansion, development and for growth amidst the global challenges of the new millennium.\nKNOWLEDGE (Cognito) connotes the institution's efforts to impart excellent lifelong education that can be used as human tool so that one can liberate himself/herself from ignorance and poverty\nCHARITY (Caritas) is the institution's commitment towards its clienteles.\nHUMILITY (Humiliates) refers to the institution's recognition of the human frailty, its imperfection.",
                'description' => 'BCP Core Values',
            ],

            // ================== LEGEND ==================
            [
                'category' => 'legend',
                'key' => 'l',
                'value' => 'Facilitate Learning of the competencies',
                'description' => 'L - Facilitate Learning',
            ],
            [
                'category' => 'legend',
                'key' => 'p',
                'value' => 'Allow student to practice competencies (No input but competency is evaluated)',
                'description' => 'P - Practice',
            ],
            [
                'category' => 'legend',
                'key' => 'o',
                'value' => 'Provide opportunity for development (No input or evaluation, but there is opportunity to practice the competencies)',
                'description' => 'O - Opportunity',
            ],
            [
                'category' => 'legend',
                'key' => 'ctpss',
                'value' => 'critical thinking and problem-solving skills',
                'description' => 'CTPSS Abbreviation',
            ],
            [
                'category' => 'legend',
                'key' => 'ecc',
                'value' => 'effective communication and collaboration',
                'description' => 'ECC Abbreviation',
            ],
            [
                'category' => 'legend',
                'key' => 'epp',
                'value' => 'ethical and professional practice',
                'description' => 'EPP Abbreviation',
            ],
            [
                'category' => 'legend',
                'key' => 'glc',
                'value' => 'global and lifelong learning commitment',
                'description' => 'GLC Abbreviation',
            ],

            // ================== LEARNING OUTCOMES ==================
            [
                'category' => 'learning_outcomes',
                'key' => 'school_goals',
                'value' => 'BCP puts God in the center of all its efforts realize and operationalize its vision and missions through the following. Instruction, Research, Extension and Productivity',
                'description' => 'School Goals',
            ],
            [
                'category' => 'learning_outcomes',
                'key' => 'program_goals',
                'value' => 'To cultivate a dynamic and inclusive learning environment that empowers students to become self-directed, ethical, and engaged citizens, equipped with the critical thinking, communication, and problem-solving skills necessary to thrive in a rapidly evolving world.',
                'description' => 'Program Goals',
            ],
            [
                'category' => 'learning_outcomes',
                'key' => 'expected_graduate_elements',
                'value' => "critical thinking and problem-solving skills;\neffective communication and collaboration;\nethical and professional practice; and,\nglobal and lifelong learning commitment.",
                'description' => 'Expected BCP Graduate Elements',
            ],

            // ================== POLICIES ==================
            [
                'category' => 'policies',
                'key' => 'learners_with_disabilities',
                'value' => "This course is committed in providing equal access and participation for all students including those with disabilities. If you have a disability that may require accommodations, please contact the OFFICE OF THE STUDENTS' AFFAIRS and SERVICES to register in the LIST OF LEARNERS with Disabilities. Please be aware that it is your responsibility to communicate your needs and works with the instructor to ensure that appropriate accommodations can be arranged promptly.",
                'description' => 'Policy for Learners with Disabilities',
            ],
            [
                'category' => 'policies',
                'key' => 'syllabus_flexibility',
                'value' => 'The faculty reserves the right to change or amend this syllabus as needed. Any changes to the syllabus will be communicated promptly to the VPAA through the Department Heads / Deans, if any, adjustments will be made to ensure that all students can continue to meet the course objectives. Your feedback and input are valued, and we encourage open communication to facilitate a positive and productive learning experience for all.',
                'description' => 'Syllabus Flexibility Policy',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('system_settings')->insertOrIgnore([
                'category' => $setting['category'],
                'key' => $setting['key'],
                'value' => $setting['value'],
                'description' => $setting['description'],
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
        Schema::dropIfExists('system_settings');
    }
};
