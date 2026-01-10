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

        $added2023 = 0;
        $updated2023 = 0;
        $added2024 = 0;
        $updated2024 = 0;
        $added2025 = 0;
        $updated2025 = 0;

        // Process 2023 links
        foreach ($chedLinks2023 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2023',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url']
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
                    'url' => $link['url']
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
                    'url' => $link['url']
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2025++;
            } else {
                $updated2025++;
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
    }
}
