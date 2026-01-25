<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComplianceLink;

class ComplianceLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CHED 2023 Links
        $chedLinks2023 = [
            ['title' => 'CMO No. 1, Series of 2023 – Amendment to Article IV.E of CMO No. 09, S. 2022 on Local Off-Campus Activities', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-1-S.-2023.pdf'],
            ['title' => 'CMO No. 3, Series of 2023 – Policies, Standards, and Guidelines for the Bachelor of Science in Midwifery Program (BSM)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2023.pdf'],
            ['title' => 'CMO No. 4, Series of 2023 – Updated Guidelines on Onsite Learning in Higher Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-4-s.-2023.pdf'],
            ['title' => 'CMO No. 5, Series of 2023 – Revised Procedures in the Processing of Applications for Government Authority to Operate Undergraduate and Graduate Degrees in Engineering', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-5-series-of-2023.pdf'],
            ['title' => 'CMO No. 6, Series of 2023 – Policies and Guidelines for the Grant of Autonomous  and Deregulated Status to Private Higher Education Institutions', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-S.-2023.pdf'],
            ['title' => 'CMO No. 7, Series of 2023 – List of Identified Priority Programs for CHED Merit Scholarship Program (CMSP) for Academic Years (AY) 2023-2024 to 2027-2028', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-7-S.-2023.pdf'],
            ['title' => 'CMO No. 8, Series of 2023 – Guidelines on the Student Monetary Assistance for Recovery and Transition (SMART) Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-8-S.-2023.pdf'],
            ['title' => 'CMO No. 9, Series of 2023 – Revised Policies and Guidelines on the Issuance of Certificate of Program  Compliance (COPC) to State Universities and Colleges (SUCs) and Local Universities and Colleges (LUCs)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-S.-2023.pdf.pdf'],
            ['title' => 'CMO No. 10, Series of 2023 – Enhanced Policies, Standards and Guidelines (PSGs) on Student Internship Abroad Program (SIAP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-S.-2023.pdf'],
            ['title' => 'CMO No. 11, Series of 2023 – Accelerated Pathway for Medicine (APMed) Program: A Pilot Implementation for Development of Future-Ready Physicians', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-11-S.-2023.pdf.pdf'],
            ['title' => 'CMO No. 12, Series of 2023 – Supplemental Policies and Guidelines for the Grant of Autonomous and Deregulated Status to Private Higher Education Institutions', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-12-s-2023_Supplemental-Policies-and-Guidelines-for-the-grant-of-AD-status-to-private-HEIs.pdf'],
            ['title' => 'CMO No. 13, Series of 2023 – Policies, Standards, and Guidelines for the Bachelor of Industrial Technology (BIndTech) Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-S.-2023-BInd-Tech.pdf'],
            ['title' => 'CMO No. 14, Series of 2023 – Amended CHED Memorandum Order (CMO) No. 8, Series of 2023 Entitled "Guidelines on the Student Monetary Assistance for Recovery and Transition (SMART) Program"', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-14-s.-2023-SMART_SGD.pdf'],
            ['title' => 'CMO No. 15, Series of 2023 – Guidelines and Policies of Continuing Professional Development Studies Grant (CPDSG)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-S.-2023_Guidelines-and-Policies-of-Continuing-Professional-Development-Studies-Grant-CPDSG.pdf'],
            ['title' => 'CMO No. 16, Series of 2023 – Amendment to CMO No. 15, Series of 2021 Entitled "Guidelines for the Support and Development of Medical Schools – Seed Fund for Medicine (Programang Punla sa Medisina)"', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-16-S.-2023.pdf'],
            ['title' => 'CMO No. 17, Series of 2023 – Operational Guidelines on the Implementation of the Scholarship Program for Coconut Farmers and their Families (CoScho) for Participating Higher Education Institutions', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-S.-2023-Operational-Guidelines-on-the-Implementation-of-the-Scholarship-Program-for-Coconut-Farmers-and-their-Families-for-Higher-Education-Institution.pdf'],
        ];

        // CHED 2024 Links
        $chedLinks2024 = [
            ['title' => 'CMO No 1, series of 2024 – Policies, Standards, and Guidelines for BS Public Health Major in Population Track and BS Public Health Major in Clinical Track Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-1-S-2024-PSG-for-BS-Public-Health-Population-Track-and-Clinical-Track.pdf'],
            ['title' => 'CMO No 2, series of 2024 – Policies and Guidelines in the Nursing Review Program for the Clinical Care Associates (CCAs) per DOH-CHED Joint Administrative Order No. 2023-0001', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-2-S.-2024-Special-Nursing-Review-Program-CCAs.pdf'],
            ['title' => 'CMO No 3, series of 2024 – Policies, Standards and Guidelines (PSG) for the Bachelor of Science in Meteorology (BS Met)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-3-S.-2024-PSG-for-BS-Meteorology-1.pdf'],
            ['title' => 'CMO No 4, series of 2024 – Amendments to the Specific Provisions of CMO No. 10, series of 2022 Entitled "Implementing Guidelines for CHED Scholarship for Future Statisticians (ESTATISKOLAR)"', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-4-s.-2024.pdf'],
            ['title' => 'CMO No 5, series of 2024 – Policies, Standards, and Guidelines (PSG) for Master in Nursing Education (MNE)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-5-S.-2024-PSG-Master-in-Nursing-Education.pdf'],
            ['title' => 'CMO No 7, series of 2024 – Grant of Autonomous and Deregulated Status by Evaluation to Private Higher Education Institutions', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-7-S.-2024.pdf'],
            ['title' => 'CMO No 8, series of 2024 – Policies, Standards and Guidelines for Graduate Programs in Women and Gender Studies: Master of Arts in Women and Gender Studies (Academic Track) and Master in Women and Gender Studies ( Professional Track)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-S.-2024-GENDER.pdf'],
            ['title' => 'CMO NO. 9, series of 2024 – Amendment to CMO No. 11, Series of 2022 Entitled "Guidelines for the Support and Development of Higher Education Institutions (HEIs) Offering Tourism Management and Hospitality Management (HM) Programs through the Sustainable Tourism Education Program – Upgrading Project (STEP-UP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO_NO_9_S_2024_Amendment_to_CMO_11_s_2022_STEP_UP_Guidelines.pdf'],
            ['title' => 'CMO NO. 10, Series of 2024 – Implementing Guidelines of Section 25 of CMO NOs. 74, 75, 76, 77, 78, 79, 80 and 82, Series of 2017', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-10-S.-2024.pdf'],
            ['title' => 'CMO NO. 11, series of 2024 – Implementing Guidelines of the Scholarship Program for Future Medical Technologists and Pharmacists (MTP-SP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-11-S.-2024.pdf'],
            ['title' => 'CMO NO. 13, series of 2024 – Policies, Standards and Guidelines (PSG) for the Bachelor of Science in Physics (BS Physics) and Bachelor of Science in Applied Physics (BS Applied Physics) Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-13-S.-2024-PSG-BS-PHYSICS-AND-BS-APPLIED-PHYSICS.pdf'],
        ];

        // CHED 2025 Links
        $chedLinks2025 = [
            ['title' => 'CMO No. 1, series of 2025 – Guidelines for Micro-Credential Development, Approval, and Recognition in Higher Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-1-s.-2025.pdf'],
            ['title' => 'CMO No. 2, series of 2025 – Updated List of Private Higher Education Institutions Granted Autonomous and Deregulated Status by Evaluation', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-02-S.-2025.pdf'],
            ['title' => 'CMO No. 3, series of 2025 – Updated Guidelines for Securing Authority to Travel Abroad for State Universities and Colleges (SUCs)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-3-series-of-2025-Updated-Guidelines-for-Securing-Authority-to-Travel-Abroad-for-State-Universities-and-Colleges-SUCs.pdf'],
            ['title' => 'CMO No. 4, series of 2025 – Revised Policies, Standards and Guidelines for Associate in Radiologictechnology Education (ART) Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-4-s.-2025.pdf'],
            ['title' => 'CMO No. 5, series of 2025 – Guidelines for the Accreditation of Hospitals and Primary Health Care Facilities for the Clinical Practice of Radiologic/X-RAY Technology Interns', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-5-s.-2025.pdf'],
            ['title' => 'CMO No. 6, series of 2025 – Application Process for Authority to Offer Transnational Higher Education Pursuant to Republic Act No. 11448 or The Transnational Higher Education Act', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-6-s.-2025.pdf'],
            ['title' => 'CMO No. 7, series of 2025 – Policies, Standards and Guidelines for the Implementation of the National Merchant Marine Aptitude Test (NaMMAT)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-7-s.-2025.pdf'],
            ['title' => 'CMO No. 9, series of 2025 – Updated Guidelines for the Scholarships for Staff and Instructors\' Knowledge Advancement Program (SIKAP) for Full-Time and Part-Time Study', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-9-s.-2025.pdf'],
            ['title' => 'CMO No. 10, series of 2025 – Policies and Standards on Centers of Excellence (COE) | Annex A', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2025.pdf'],
            ['title' => 'CMO No. 11, series of 2025 – Implementing Rules and Regulations of Republic Act No. 12124, "An Act Institutionalizing the Expanded Tertiary Education Equivalency and Accreditation Program (ETEEAP) and Providing Funds Therefor"', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2025.pdf'],
            ['title' => 'CMO No. 12, series of 2025 – Policies and Guidelines on Open Distance and e-Learning (ODeL)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2025.pdf'],
            ['title' => 'CMO No. 13, series of 2025 – Revised Policies and Guidelines for the CHED Merit Scholarship Program (CMSP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2025.pdf'],
            ['title' => 'CMO No. 14, series of 2025 – Revised Implementing Guidelines for the CHED Scholarship Program for Future Statisticians (ESTATISKOLAR)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-14-s.-2025.pdf'],
            ['title' => 'CMO No. 15, series of 2025 – Updated Policies and Guidelines for the Grant of Autonomous and Deregulated Status to Private Higher Education Institutions', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2025.pdf'],
        ];

        // DepEd Curriculum Guides (Academic)
        $depedAcademicLinks = [
            // ARTS, SOCIAL SCIENCE, AND HUMANITIES
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Arts 1 (Creative Industries - Visual Art, Literary Art, Media Art, Applied Art, and Traditional Art)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Arts-1-Creative-Industries-Visual-Art-Literary-Art-Media-Art-Applied-Art-and-Traditional-Art.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Arts 2 (Creative Industries II – Performing Arts)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Arts-2-Creative-Industries-II-%E2%80%93-Performing-Arts.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Social Science 1 (Introduction to Social Sciences)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Social-Science-1-Introduction-to-Social-Sciences.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Humanities 1 (Creative Writing)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Humanities-1-Creative-Writing.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Humanities 2 (Introduction to World Religions and Belief Systems)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Humanities-2-Introduction-to-World-Religions-and-Belief-Systems.pdf'],

            // BUSINESS AND ENTREPRENEURSHIP
            ['group' => 'BUSINESS AND ENTREPRENEURSHIP', 'title' => 'Business 1 (Business Enterprise Simulation)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Business-1-Business-Enterprise-Simulation.pdf'],
            ['group' => 'BUSINESS AND ENTREPRENEURSHIP', 'title' => 'Economics 1 (Introduction to Economics)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Economics-1-Introduction-to-Economics.pdf'],
            ['group' => 'BUSINESS AND ENTREPRENEURSHIP', 'title' => 'Management 1 (Fundamentals of Accountancy, Business, and Management)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Management-1-Fundamentals-of-Accountancy-Business-and-Management.pdf'],

            // SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Engineering 1 (Calculus)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Engineering-1-Calculus.pdf'],
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Engineering 2 (Fundamentals of Programming)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Engineering-2-Fundamentals-of-Programming.pdf'],
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Engineering 3 (Basic Electricity and Electronics)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Engineering-3-Basic-Electricity-and-Electronics.pdf'],

            // SPORTS, HEALTH, AND WELLNESS
            ['group' => 'SPORTS, HEALTH, AND WELLNESS', 'title' => 'Health Science 1 (Introduction to Health Science)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Health-Science-1-Introduction-to-Health-Science.pdf'],
            ['group' => 'SPORTS, HEALTH, AND WELLNESS', 'title' => 'Health Science 2 (Basic Human Anatomy and Physiology)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Health-Science-2-Basic-Human-Anatomy-and-Physiology.pdf'],
        ];

        // DepEd Curriculum Guides (TechPro)
        $depedTechProLinks = [
            // INFORMATION AND COMMUNICATIONS TECHNOLOGY
            ['group' => 'INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'title' => 'Digital Tools and Productivity Applications', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Digital-Tools-and-Productivity-Applications.pdf'],
            ['group' => 'INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'title' => 'Multimedia Development and Design', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Multimedia-Development-and-Design.pdf'],
            ['group' => 'INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'title' => 'Computer Systems and Network Administration', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Computer-Systems-and-Network-Administration.pdf'],
            ['group' => 'INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'title' => 'Web Development', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Web-Development.pdf'],
            ['group' => 'INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'title' => 'Computer Programming', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Computer-Programming.pdf'],
        ];

        // DepEd Curriculum Guides (Core)
        $depedCoreLinks = [
            ['title' => 'Effective Communication', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Effective-Communication.pdf'],
            ['title' => 'General Mathematics', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/General-Mathematics.pdf'],
            ['title' => 'General Science', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/General-Science.pdf'],
            ['title' => 'Life and Career Skills', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Life-and-Career-Skills.pdf'],
            ['title' => 'Mabisang Komunikasyon', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Mabisang-Komunikasyon.pdf'],
            ['title' => 'Pag-aaral ng Kasaysayan at Lipunang Pilipino', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Pag-aaral-ng-Kasaysayan-at-Lipunang-Pilipino.pdf'],
        ];



        // DepEd Shape Paper
        $depedShapePaperLinks = [
            ['title' => 'The Strengthened Senior High School Program Shaping Paper', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/2024/05/The-Strengthened-Senior-High-School-Program-Shaping-Paper.pdf'],
        ];


        $added2023 = 0;
        $updated2023 = 0;
        $added2024 = 0;
        $updated2024 = 0;
        $added2025 = 0;
        $updated2025 = 0;
        $addedDepEdAcademic = 0;
        $updatedDepEdAcademic = 0;
        $addedDepEdTechPro = 0;
        $updatedDepEdTechPro = 0;

        // Process 2023 links
        foreach ($chedLinks2023 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2023',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2023++;
            } else {
                $updated2023++;
            }
        }

        // Process 2024 links
        foreach ($chedLinks2024 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2024',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2024++;
            } else {
                $updated2024++;
            }
        }

        // Process 2025 links
        foreach ($chedLinks2025 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2025',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2025++;
            } else {
                $updated2025++;
            }
        }

        // Process DepEd Academic links
        foreach ($depedAcademicLinks as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'DepEd',
                    'year' => 'Curriculum Guides (Academic)',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'group' => $link['group'] ?? null,
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $addedDepEdAcademic++;
            } else {
                $updatedDepEdAcademic++;
            }
        }

        // Process DepEd TechPro links
        foreach ($depedTechProLinks as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'DepEd',
                    'year' => 'Curriculum Guides (TechPro)',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'group' => $link['group'] ?? null,
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $addedDepEdTechPro++;
            } else {
                $updatedDepEdTechPro++;
            }
        }

        $addedDepEdCore = 0;
        $updatedDepEdCore = 0;

        // Process DepEd Core links
        foreach ($depedCoreLinks as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'DepEd',
                    'year' => 'Curriculum Guides (Core)',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'group' => null, // Core links don't have subgroups in this context
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $addedDepEdCore++;
            } else {
                $updatedDepEdCore++;
            }
        }



        $addedDepEdShapePaper = 0;
        $updatedDepEdShapePaper = 0;

        // Process DepEd Shape Paper links
        foreach ($depedShapePaperLinks as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'DepEd',
                    'year' => 'Shape Paper',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'group' => null, // Shape Paper links don't have subgroups in this context
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $addedDepEdShapePaper++;
            } else {
                $updatedDepEdShapePaper++;
            }
        }

        // Display results
        $this->command->info("📅 CHED 2023:");
        $this->command->info("  ✅ Added {$added2023} new links");
        if ($updated2023 > 0) {
            $this->command->info("  📝 Updated {$updated2023} existing links");
        }

        $this->command->info("📅 CHED 2024:");
        $this->command->info("  ✅ Added {$added2024} new links");
        if ($updated2024 > 0) {
            $this->command->info("  📝 Updated {$updated2024} existing links");
        }

        $this->command->info("📅 CHED 2025:");
        $this->command->info("  ✅ Added {$added2025} new links");
        if ($updated2025 > 0) {
            $this->command->info("  📝 Updated {$updated2025} existing links");
        }

        $this->command->info("📚 DepEd Curriculum Guides (Academic):");
        $this->command->info("  ✅ Added {$addedDepEdAcademic} new links");
        if ($updatedDepEdAcademic > 0) {
            $this->command->info("  📝 Updated {$updatedDepEdAcademic} existing links");
        }

        $this->command->info("🔧 DepEd Curriculum Guides (TechPro):");
        $this->command->info("  ✅ Added {$addedDepEdTechPro} new links");
        if ($updatedDepEdTechPro > 0) {
            $this->command->info("  📝 Updated {$updatedDepEdTechPro} existing links");
        }

        $this->command->info("🔧 DepEd Curriculum Guides (Core):");
        $this->command->info("  ✅ Added {$addedDepEdCore} new links");
        if ($updatedDepEdCore > 0) {
            $this->command->info("  📝 Updated {$updatedDepEdCore} existing links");
        }

        $this->command->info("📄 DepEd Shape Paper:");
        $this->command->info("  ✅ Added {$addedDepEdShapePaper} new links");
        if ($updatedDepEdShapePaper > 0) {
            $this->command->info("  📝 Updated {$updatedDepEdShapePaper} existing links");
        }

        $totalAdded = $added2023 + $added2024 + $added2025 + $addedDepEdAcademic + $addedDepEdTechPro + $addedDepEdCore + $addedDepEdShapePaper;
        $totalUpdated = $updated2023 + $updated2024 + $updated2025 + $updatedDepEdAcademic + $updatedDepEdTechPro + $updatedDepEdCore + $updatedDepEdShapePaper;
        
        $this->command->info("\n🎉 Total: {$totalAdded} links added, {$totalUpdated} links updated");
    }
}
