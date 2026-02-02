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
        if (!Schema::hasColumn('compliance_links', 'group')) {
            Schema::table('compliance_links', function (Blueprint $table) {
                $table->string('group')->nullable()->after('year'); // For sub-headers like "ARTS..."
            });
        }

        // Insert Default Data
        $links = [
            // CHED 2023
            ['CHED', '2023', 'CMO No. 1, Series of 2023 – Amendment to Article IV.E of CMO No. 09, S. 2022 on Local Off-Campus Activities', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-1-S.-2023.pdf'],
            ['CHED', '2023', 'CMO No. 3, Series of 2023 – Policies, Standards, and Guidelines for the Bachelor of Science in Midwifery Program (BSM)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2023.pdf'],
            ['CHED', '2023', 'CMO No. 4, Series of 2023 – Updated Guidelines on Onsite Learning in Higher Education', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-4-s.-2023.pdf'],
            ['CHED', '2023', 'CMO No. 5, Series of 2023 – Revised Procedures in the Processing of Applications for Government Authority to Operate Undergraduate and Graduate Degrees in Engineering', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-5-series-of-2023.pdf'],
            ['CHED', '2023', 'CMO No. 6, Series of 2023 – Policies and Guidelines for the Grant of Autonomous  and Deregulated Status to Private Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-S.-2023.pdf'],
            ['CHED', '2023', 'CMO No. 7, Series of 2023 – List of Identified Priority Programs for CHED Merit Scholarship Program (CMSP) for Academic Years (AY) 2023-2024 to 2027-2028', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-7-S.-2023.pdf'],
            ['CHED', '2023', 'CMO No. 8, Series of 2023 – Guidelines on the Student Monetary Assistance for Recovery and Transition (SMART) Program', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-8-S.-2023.pdf'],
            ['CHED', '2023', 'CMO No. 9, Series of 2023 – Revised Policies and Guidelines on the Issuance of Certificate of Program  Compliance (COPC) to State Universities and Colleges (SUCs) and Local Universities and Colleges (LUCs)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-S.-2023.pdf.pdf'],
            ['CHED', '2023', 'CMO No. 10, Series of 2023 – Enhanced Policies, Standards and Guidelines (PSGs) on Student Internship Abroad Program (SIAP)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-S.-2023.pdf'],
            ['CHED', '2023', 'CMO No. 11, Series of 2023 – Accelerated Pathway for Medicine (APMed) Program: A Pilot Implementation for Development of Future-Ready Physicians', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-11-S.-2023.pdf.pdf'],
            ['CHED', '2023', 'CMO No. 12, Series of 2023 – Supplemental Policies and Guidelines for the Grant of Autonomous and Deregulated Status to Private Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-12-s-2023_Supplemental-Policies-and-Guidelines-for-the-grant-of-AD-status-to-private-HEIs.pdf'],
            ['CHED', '2023', 'CMO No. 13, Series of 2023 – Policies, Standards, and Guidelines for the Bachelor of Industrial Technology (BIndTech) Program', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-S.-2023-BInd-Tech.pdf'],
            ['CHED', '2023', 'CMO No. 14, Series of 2023 – Amended CHED Memorandum Order (CMO) No. 8, Series of 2023 Entitled "Guidelines on the Student Monetary Assistance for Recovery and Transition (SMART) Program"', 'https://ched.gov.ph/wp-content/uploads/CMO-14-s.-2023-SMART_SGD.pdf'],
            ['CHED', '2023', 'CMO No. 15, Series of 2023 – Guidelines and Policies of Continuing Professional Development Studies Grant (CPDSG)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-S.-2023_Guidelines-and-Policies-of-Continuing-Professional-Development-Studies-Grant-CPDSG.pdf'],
            ['CHED', '2023', 'CMO No. 16, Series of 2023 – Amendment to CMO No. 15, Series of 2021 Entitled "Guidelines for the Support and Development of Medical Schools – Seed Fund for Medicine (Programang Punla sa Medisina)"', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-16-S.-2023.pdf'],
            ['CHED', '2023', 'CMO No. 17, Series of 2023 – Operational Guidelines on the Implementation of the Scholarship Program for Coconut Farmers and their Families (CoScho) for Participating Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-S.-2023-Operational-Guidelines-on-the-Implementation-of-the-Scholarship-Program-for-Coconut-Farmers-and-their-Families-for-Higher-Education-Institution.pdf'],

            // CHED 2024
            ['CHED', '2024', 'CMO No 1, series of 2024 – Policies, Standards, and Guidelines for BS Public Health Major in Population Track and BS Public Health Major in Clinical Track Program', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-1-S-2024-PSG-for-BS-Public-Health-Population-Track-and-Clinical-Track.pdf'],
            ['CHED', '2024', 'CMO No 2, series of 2024 – Policies and Guidelines in the Nursing Review Program for the Clinical Care Associates (CCAs) per DOH-CHED Joint Administrative Order No. 2023-0001', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-2-S.-2024-Special-Nursing-Review-Program-CCAs.pdf'],
            ['CHED', '2024', 'CMO No 3, series of 2024 – Policies, Standards and Guidelines (PSG) for the Bachelor of Science in Meteorology (BS Met)', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-3-S.-2024-PSG-for-BS-Meteorology-1.pdf'],
            ['CHED', '2024', 'CMO No 4, series of 2024 – Amendments to the Specific Provisions of CMO No. 10, series of 2022 Entitled "Implementing Guidelines for CHED Scholarship for Future Statisticians (ESTATISKOLAR)"', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-4-s.-2024.pdf'],
            ['CHED', '2024', 'CMO No 5, series of 2024 – Policies, Standards, and Guidelines (PSG) for Master in Nursing Education (MNE)', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-5-S.-2024-PSG-Master-in-Nursing-Education.pdf'],
            ['CHED', '2024', 'CMO No 7, series of 2024 – Grant of Autonomous and Deregulated Status by Evaluation to Private Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-7-S.-2024.pdf'],
            ['CHED', '2024', 'CMO No 8, series of 2024 – Policies, Standards and Guidelines for Graduate Programs in Women and Gender Studies: Master of Arts in Women and Gender Studies (Academic Track) and Master in Women and Gender Studies ( Professional Track)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-S.-2024-GENDER.pdf'],
            ['CHED', '2024', 'CMO NO. 9, series of 2024 – Amendment to CMO No. 11, Series of 2022 Entitled "Guidelines for the Support and Development of Higher Education Institutions (HEIs) Offering Tourism Management and Hospitality Management (HM) Programs through the Sustainable Tourism Education Program – Upgrading Project (STEP-UP)', 'https://ched.gov.ph/wp-content/uploads/CMO_NO_9_S_2024_Amendment_to_CMO_11_s_2022_STEP_UP_Guidelines.pdf'],
            ['CHED', '2024', 'CMO NO. 10, Series of 2024 – Implementing Guidelines of Section 25 of CMO NOs. 74, 75, 76, 77, 78, 79, 80 and 82, Series of 2017', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-10-S.-2024.pdf'],
            ['CHED', '2024', 'CMO NO. 11, series of 2024 – Implementing Guidelines of the Scholarship Program for Future Medical Technologists and Pharmacists (MTP-SP)', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-11-S.-2024.pdf'],
            ['CHED', '2024', 'CMO NO. 13, series of 2024 – Policies, Standards and Guidelines (PSG) for the Bachelor of Science in Physics (BS Physics) and Bachelor of Science in Applied Physics (BS Applied Physics) Program', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-13-S.-2024-PSG-BS-PHYSICS-AND-BS-APPLIED-PHYSICS.pdf'],

            // CHED 2025
            ['CHED', '2025', 'CMO No. 1, series of 2025 – Guidelines for Micro-Credential Development, Approval, and Recognition in Higher Education', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-1-s.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 2, series of 2025 – Updated List of Private Higher Education Institutions Granted Autonomous and Deregulated Status by Evaluation', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-02-S.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 3, series of 2025 – Updated Guidelines for Securing Authority to Travel Abroad for State Universities and Colleges (SUCs)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-3-series-of-2025-Updated-Guidelines-for-Securing-Authority-to-Travel-Abroad-for-State-Universities-and-Colleges-SUCs.pdf'],
            ['CHED', '2025', 'CMO No. 4, series of 2025 – Revised Policies, Standards and Guidelines for Associate in Radiologictechnology Education (ART) Program', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-4-s.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 5, series of 2025 – Guidelines for the Accreditation of Hospitals and Primary Health Care Facilities for the Clinical Practice of Radiologic/X-RAY Technology Interns', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-5-s.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 6, series of 2025 – Application Process for Authority to Offer Transnational Higher Education Pursuant to Republic Act No. 11448 or The Transnational Higher Education Act', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-6-s.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 7, series of 2025 – Policies, Standards and Guidelines for the Implementation of the National Merchant Marine Aptitude Test (NaMMAT)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-7-s.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 9, series of 2025 – Updated Guidelines for the Scholarships for Staff and Instructors\' Knowledge Advancement Program (SIKAP) for Full-Time and Part-Time Study', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-9-s.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 10, series of 2025 – Policies and Standards on Centers of Excellence (COE) | Annex A', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 11, series of 2025 – Implementing Rules and Regulations of Republic Act No. 12124, "An Act Institutionalizing the Expanded Tertiary Education Equivalency and Accreditation Program (ETEEAP) and Providing Funds Therefor"', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 12, series of 2025 – Policies and Guidelines on Open Distance and e-Learning (ODeL)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 13, series of 2025 – Revised Policies and Guidelines for the CHED Merit Scholarship Program (CMSP)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 14, series of 2025 – Revised Implementing Guidelines for the CHED Scholarship Program for Future Statisticians (ESTATISKOLAR)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-14-s.-2025.pdf'],
            ['CHED', '2025', 'CMO No. 15, series of 2025 – Updated Policies and Guidelines for the Grant of Autonomous and Deregulated Status to Private Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2025.pdf'],
            
            // Core
            ['DepEd', 'Curriculum Guides (Core)', 'Effective Communication', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Effective-Communication.pdf', null],
            ['DepEd', 'Curriculum Guides (Core)', 'General Mathematics', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/General-Mathematics.pdf', null],
            ['DepEd', 'Curriculum Guides (Core)', 'General Science', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/General-Science.pdf', null],
            ['DepEd', 'Curriculum Guides (Core)', 'Life and Career Skills', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Life-and-Career-Skills.pdf', null],
            ['DepEd', 'Curriculum Guides (Core)', 'Mabisang Komunikasyon', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Mabisang-Komunikasyon.pdf', null],
            ['DepEd', 'Curriculum Guides (Core)', 'Pag-aaral ng Kasaysayan at Lipunang Pilipino', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Pag-aaral-ng-Kasaysayan-at-Lipunang-Pilipino.pdf', null],

            // Shape Paper
            ['DepEd', 'Shape Paper', 'The Strengthened Senior High School Program Shaping Paper', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/The-Strengthened-Senior-High-School-Program-Shaping-Paper.pdf', null],
        ];

        // Process simple links without groups first
        foreach ($links as $link) {
            \Illuminate\Support\Facades\DB::table('compliance_links')->updateOrInsert(
                [
                    'agency' => $link[0],
                    'year' => $link[1],
                    'title' => $link[2]
                ],
                [
                    'url' => $link[3],
                    'group' => $link[4] ?? null,
                    'is_category' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // DepEd Academic Links (with Groups)
        $depedAcademicLinks = [
            ['ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Arts 1 (Creative Industries - Visual Art, Literary Art, Media Art, Applied Art, and Traditional Art)', 'https://www.deped.gov.ph/wp-content/uploads/Arts-1-Creative-Industries-Visual-Art-Literary-Art-Media-Art-Applied-Art-and-Traditional-Art.pdf'],
            ['ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Arts 2 (Creative Industries II – Performing Arts)', 'https://www.deped.gov.ph/wp-content/uploads/Arts-2-Creative-Industries-II-%E2%80%93-Performing-Arts.pdf'],
            ['ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Social Science 1 (Introduction to Social Sciences)', 'https://www.deped.gov.ph/wp-content/uploads/Social-Science-1-Introduction-to-Social-Sciences.pdf'],
            ['ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Humanities 1 (Creative Writing)', 'https://www.deped.gov.ph/wp-content/uploads/Humanities-1-Creative-Writing.pdf'],
            ['ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Humanities 2 (Introduction to World Religions and Belief Systems)', 'https://www.deped.gov.ph/wp-content/uploads/Humanities-2-Introduction-to-World-Religions-and-Belief-Systems.pdf'],
            ['BUSINESS AND ENTREPRENEURSHIP', 'Business 1 (Business Enterprise Simulation)', 'https://www.deped.gov.ph/wp-content/uploads/Business-1-Business-Enterprise-Simulation.pdf'],
            ['BUSINESS AND ENTREPRENEURSHIP', 'Economics 1 (Introduction to Economics)', 'https://www.deped.gov.ph/wp-content/uploads/Economics-1-Introduction-to-Economics.pdf'],
            ['BUSINESS AND ENTREPRENEURSHIP', 'Management 1 (Fundamentals of Accountancy, Business, and Management)', 'https://www.deped.gov.ph/wp-content/uploads/Management-1-Fundamentals-of-Accountancy-Business-and-Management.pdf'],
            ['SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Engineering 1 (Calculus)', 'https://www.deped.gov.ph/wp-content/uploads/Engineering-1-Calculus.pdf'],
            ['SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Engineering 2 (Fundamentals of Programming)', 'https://www.deped.gov.ph/wp-content/uploads/Engineering-2-Fundamentals-of-Programming.pdf'],
            ['SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Engineering 3 (Basic Electricity and Electronics)', 'https://www.deped.gov.ph/wp-content/uploads/Engineering-3-Basic-Electricity-and-Electronics.pdf'],
            ['SPORTS, HEALTH, AND WELLNESS', 'Health Science 1 (Introduction to Health Science)', 'https://www.deped.gov.ph/wp-content/uploads/Health-Science-1-Introduction-to-Health-Science.pdf'],
            ['SPORTS, HEALTH, AND WELLNESS', 'Health Science 2 (Basic Human Anatomy and Physiology)', 'https://www.deped.gov.ph/wp-content/uploads/Health-Science-2-Basic-Human-Anatomy-and-Physiology.pdf'],
        ];

        foreach ($depedAcademicLinks as $link) {
            \Illuminate\Support\Facades\DB::table('compliance_links')->updateOrInsert(
                [
                    'agency' => 'DepEd',
                    'year' => 'Curriculum Guides (Academic)',
                    'title' => $link[1]
                ],
                [
                    'url' => $link[2],
                    'group' => $link[0],
                    'is_category' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // DepEd TechPro Links
        $depedTechProLinks = [
            ['INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'Digital Tools and Productivity Applications', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Digital-Tools-and-Productivity-Applications.pdf'],
            ['INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'Multimedia Development and Design', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Multimedia-Development-and-Design.pdf'],
            ['INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'Computer Systems and Network Administration', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Computer-Systems-and-Network-Administration.pdf'],
            ['INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'Web Development', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Web-Development.pdf'],
            ['INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'Computer Programming', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Computer-Programming.pdf'],
        ];

        foreach ($depedTechProLinks as $link) {
            \Illuminate\Support\Facades\DB::table('compliance_links')->updateOrInsert(
                [
                    'agency' => 'DepEd',
                    'year' => 'Curriculum Guides (TechPro)',
                    'title' => $link[1]
                ],
                [
                    'url' => $link[2],
                    'group' => $link[0],
                    'is_category' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
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
