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
        if (!Schema::hasColumn('compliance_links', 'group')) {
            Schema::table('compliance_links', function (Blueprint $table) {
                $table->string('group')->nullable()->after('year'); // For sub-headers like "ARTS..."
            });
        }

        // Truncate existing data to start fresh
        DB::table('compliance_links')->truncate();

        // Insert all compliance links data
        $links = [
            // CHED 2020
            ['CHED', '0', '2020', NULL, 'CMO No. 1, Series of 2020 – Guidelines for the Grant of Assistance to State Universities and Colleges to Combat COVID-19', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2020.pdf'],
            ['CHED', '0', '2020', NULL, 'CMO No. 2, Series of 2020 – Amendment to Sections III, IV, V, VI, VII and VIII of CMO No. 30, Series of 2016 (SIDA-SGP)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2020.pdf'],
            ['CHED', '0', '2020', NULL, 'CMO No. 3, Series of 2020 – Amendments to the Revised and Expanded Guidelines for the Continuing Professional Education Grants', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2020.pdf'],
            ['CHED', '0', '2020', NULL, 'CMO No. 4, Series of 2020 – Guidelines on the Implementation of Flexible Learning', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2020.pdf'],
            ['CHED', '0', '2020', NULL, 'CMO No. 5, Series of 2020 – Guidelines on the Suspension of Operations of Degree Programs of Private Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2020.pdf'],
            ['CHED', '0', '2020', NULL, 'CMO No. 6, Series of 2020 – Guidelines for the Scholarships for Instructors Knowledge Advancement Program (SIKAP) Grant', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-s.-2020.pdf'],
            ['CHED', '0', '2020', NULL, 'CMO No. 8, Series of 2020 – Guidelines for the Support and Development of Discipline-Based Higher Education Roadmaps', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2020.pdf'],
            ['CHED', '0', '2020', NULL, 'CMO No. 9, Series of 2020 – Guidelines on the Allocation of Financial Assistance for SUCs for Smart Campuses (RA 11494)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2020.pdf'],
            ['CHED', '0', '2020', NULL, 'CMO No. 10, Series of 2020 – Implementing Guidelines for Bayanihan 2 for Higher Education Tulong Program (B2HELP)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2020.pdf'],
            ['CHED', '0', '2020', NULL, 'CMO No. 11, Series of 2020 – Implementing Rules and Regulations of RA 11396 (SUC Dormitories and Housing)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2020.pdf'],
            ['CHED', '0', '2020', NULL, 'CMO No. 12, Series of 2020 – Short-Term Scholarship Grants during the K to 12 Transition Period', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2020.pdf'],
            ['CHED', '0', '2020', NULL, 'CMO No. 13, Series of 2020 – Interim Policy on Documentary Submissions for SGS-L during COVID-19 Pandemic', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2020.pdf'],
            
            // CHED 2021
            ['CHED', '0', '2021', NULL, 'CMO No. 1, Series of 2021 – Amendment to Section V D-1(f) of CMO No. 10, Series of 2020 (B2HELP)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 2, Series of 2021 – Guidelines on the Grant of Certificate of Program Compliance (COPC) to SUCs and LUCs', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 3, Series of 2021 – Guidelines on the Implementation of Flexible Learning in Higher Education', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 4, Series of 2021 – Revised Guidelines on the Student Internship Program in the Philippines (SIPP)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 5, Series of 2021 – Policies, Standards and Guidelines for the Bachelor of Science in Accountancy (BSA) Program', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 7, Series of 2021 – Extension of Validity Period of Autonomous and Deregulated Status to Private HEIs', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-07-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 8, Series of 2021 – Guidelines on the Implementation of the CHED Scholarship Program (CSP) for AY 2021-2022', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 10, Series of 2021 – List of Priority Programs for CHED Scholarship Programs (CSPs) for AY 2021-2022', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 11, Series of 2021 – Amendments to Sections 6 and 12 of CMO No. 8, Series of 2019 (CSP Policies)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 12, Series of 2021 – Guidelines for the Conduct of Clinical Education for Radiologic Technology Students', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 15, Series of 2021 – Guidelines for the Support and Development of Medical Schools – Seed Fund for Medicine', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 16, Series of 2021 – Revised Guidelines for Full-Time SIKAP Grant Scholars', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-16-s.-2021.pdf'],
            ['CHED', '0', '2021', NULL, 'CMO No. 17, Series of 2021 – Revised Guidelines for CHED-Initiated Projects under IDIG Program', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-s.-2021.pdf'],
            
            // CHED 2022
            ['CHED', '0', '2022', NULL, 'CMO No. 1, Series of 2022 – Supplemental Guidelines to CHED-DOH JMC No. 2021-004 on Limited Face-to-Face Classes', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2022.pdf'],
            ['CHED', '0', '2022', NULL, 'CMO No. 2, Series of 2022 – Additional Universities Granted with Autonomous and Deregulated Status', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2022.pdf'],
            ['CHED', '0', '2022', NULL, 'CMO No. 3, Series of 2022 – Updated Guidelines on the Implementation of Flexible Learning in Higher Education', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2022.pdf'],
            ['CHED', '0', '2022', NULL, 'CMO No. 4, Series of 2022 – Safety Seal Certification Program for Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2022.pdf'],
            ['CHED', '0', '2022', NULL, 'CMO No. 5, Series of 2022 – Amendment to Article IV.H. of CHED-DOH JMC No. 2021-004 and Article III.B., Item 12 of CMO No. 01, S. 2022', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2022.pdf'],
            ['CHED', '0', '2022', NULL, 'CMO No. 6, Series of 2022 – Policies, Standards and Guidelines for the BS Tourism Management and BS Hospitality Management Programs', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-s.-2022.pdf'],
            ['CHED', '0', '2022', NULL, 'CMO No. 7, Series of 2022 – Policies, Standards and Guidelines for the Bachelor of Science in Architecture (BS Arch) Program', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-07-s.-2022.pdf'],
            ['CHED', '0', '2022', NULL, 'CMO No. 8, Series of 2022 – Policies, Standards and Guidelines for the Bachelor of Science in Customs Administration (BSCA) Program', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2022.pdf'],
            ['CHED', '0', '2022', NULL, 'CMO No. 9, Series of 2022 – Revised Policies and Guidelines on Local Off-Campus Activities', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2022.pdf'],
            ['CHED', '0', '2022', NULL, 'CMO No. 10, Series of 2022 – Guidelines on the Implementation of the CHED Scholarship Program (CSP) for AY 2022-2023', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2022.pdf'],
            
            // CHED 2023
            ['CHED', '0', '2023', NULL, 'CMO No. 1, Series of 2023 – Amendment to Article IV.E of CMO No. 09, S. 2022 on Local Off-Campus Activities', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-1-S.-2023.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 3, Series of 2023 – Policies, Standards, and Guidelines for the Bachelor of Science in Midwifery Program (BSM)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2023.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 4, Series of 2023 – Updated Guidelines on Onsite Learning in Higher Education', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-4-s.-2023.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 5, Series of 2023 – Revised Procedures in the Processing of Applications for Government Authority to Operate Undergraduate and Graduate Degrees in Engineering', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-5-series-of-2023.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 6, Series of 2023 – Policies and Guidelines for the Grant of Autonomous  and Deregulated Status to Private Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-S.-2023.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 7, Series of 2023 – List of Identified Priority Programs for CHED Merit Scholarship Program (CMSP) for Academic Years (AY) 2023-2024 to 2027-2028', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-7-S.-2023.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 8, Series of 2023 – Guidelines on the Student Monetary Assistance for Recovery and Transition (SMART) Program', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-8-S.-2023.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 9, Series of 2023 – Revised Policies and Guidelines on the Issuance of Certificate of Program  Compliance (COPC) to State Universities and Colleges (SUCs) and Local Universities and Colleges (LUCs)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-S.-2023.pdf.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 10, Series of 2023 – Enhanced Policies, Standards and Guidelines (PSGs) on Student Internship Abroad Program (SIAP)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-S.-2023.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 11, Series of 2023 – Accelerated Pathway for Medicine (APMed) Program: A Pilot Implementation for Development of Future-Ready Physicians', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-11-S.-2023.pdf.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 12, Series of 2023 – Supplemental Policies and Guidelines for the Grant of Autonomous and Deregulated Status to Private Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-12-s-2023_Supplemental-Policies-and-Guidelines-for-the-grant-of-AD-status-to-private-HEIs.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 13, Series of 2023 – Policies, Standards, and Guidelines for the Bachelor of Industrial Technology (BIndTech) Program', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-S.-2023-BInd-Tech.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 14, Series of 2023 – Amended CHED Memorandum Order (CMO) No. 8, Series of 2023 Entitled "Guidelines on the Student Monetary Assistance for Recovery and Transition (SMART) Program"', 'https://ched.gov.ph/wp-content/uploads/CMO-14-s.-2023-SMART_SGD.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 15, Series of 2023 – Guidelines and Policies of Continuing Professional Development Studies Grant (CPDSG)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-S.-2023_Guidelines-and-Policies-of-Continuing-Professional-Development-Studies-Grant-CPDSG.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 16, Series of 2023 – Amendment to CMO No. 15, Series of 2021 Entitled "Guidelines for the Support and Development of Medical Schools – Seed Fund for Medicine (Programang Punla sa Medisina)"', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-16-S.-2023.pdf'],
            ['CHED', '0', '2023', NULL, 'CMO No. 17, Series of 2023 – Operational Guidelines on the Implementation of the Scholarship Program for Coconut Farmers and their Families (CoScho) for Participating Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-S.-2023-Operational-Guidelines-on-the-Implementation-of-the-Scholarship-Program-for-Coconut-Farmers-and-their-Families-for-Higher-Education-Institution.pdf'],
            
            // CHED 2024
            ['CHED', '0', '2024', NULL, 'CMO No 1, series of 2024 – Policies, Standards, and Guidelines for BS Public Health Major in Population Track and BS Public Health Major in Clinical Track Program', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-1-S-2024-PSG-for-BS-Public-Health-Population-Track-and-Clinical-Track.pdf'],
            ['CHED', '0', '2024', NULL, 'CMO No 2, series of 2024 – Policies and Guidelines in the Nursing Review Program for the Clinical Care Associates (CCAs) per DOH-CHED Joint Administrative Order No. 2023-0001', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-2-S.-2024-Special-Nursing-Review-Program-CCAs.pdf'],
            ['CHED', '0', '2024', NULL, 'CMO No 3, series of 2024 – Policies, Standards and Guidelines (PSG) for the Bachelor of Science in Meteorology (BS Met)', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-3-S.-2024-PSG-for-BS-Meteorology-1.pdf'],
            ['CHED', '0', '2024', NULL, 'CMO No 4, series of 2024 – Amendments to the Specific Provisions of CMO No. 10, series of 2022 Entitled "Implementing Guidelines for CHED Scholarship for Future Statisticians (ESTATISKOLAR)"', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-4-s.-2024.pdf'],
            ['CHED', '0', '2024', NULL, 'CMO No 5, series of 2024 – Policies, Standards, and Guidelines (PSG) for Master in Nursing Education (MNE)', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-5-S.-2024-PSG-Master-in-Nursing-Education.pdf'],
            ['CHED', '0', '2024', NULL, 'CMO No 7, series of 2024 – Grant of Autonomous and Deregulated Status by Evaluation to Private Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-7-S.-2024.pdf'],
            ['CHED', '0', '2024', NULL, 'CMO No 8, series of 2024 – Policies, Standards and Guidelines for Graduate Programs in Women and Gender Studies: Master of Arts in Women and Gender Studies (Academic Track) and Master in Women and Gender Studies ( Professional Track)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-S.-2024-GENDER.pdf'],
            ['CHED', '0', '2024', NULL, 'CMO NO. 9, series of 2024 – Amendment to CMO No. 11, Series of 2022 Entitled "Guidelines for the Support and Development of Higher Education Institutions (HEIs) Offering Tourism Management and Hospitality Management (HM) Programs through the Sustainable Tourism Education Program – Upgrading Project (STEP-UP)', 'https://ched.gov.ph/wp-content/uploads/CMO_NO_9_S_2024_Amendment_to_CMO_11_s_2022_STEP_UP_Guidelines.pdf'],
            ['CHED', '0', '2024', NULL, 'CMO NO. 10, Series of 2024 – Implementing Guidelines of Section 25 of CMO NOs. 74, 75, 76, 77, 78, 79, 80 and 82, Series of 2017', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-10-S.-2024.pdf'],
            ['CHED', '0', '2024', NULL, 'CMO NO. 11, series of 2024 – Implementing Guidelines of the Scholarship Program for Future Medical Technologists and Pharmacists (MTP-SP)', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-11-S.-2024.pdf'],
            ['CHED', '0', '2024', NULL, 'CMO NO. 13, series of 2024 – Policies, Standards and Guidelines (PSG) for the Bachelor of Science in Physics (BS Physics) and Bachelor of Science in Applied Physics (BS Applied Physics) Program', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-13-S.-2024-PSG-BS-PHYSICS-AND-BS-APPLIED-PHYSICS.pdf'],
            
            // CHED 2025
            ['CHED', '0', '2025', NULL, 'CMO No. 1, series of 2025 – Guidelines for Micro-Credential Development, Approval, and Recognition in Higher Education', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-1-s.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 2, series of 2025 – Updated List of Private Higher Education Institutions Granted Autonomous and Deregulated Status by Evaluation', 'https://ched.gov.ph/wp-content/uploads/CMO-NO.-02-S.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 3, series of 2025 – Updated Guidelines for Securing Authority to Travel Abroad for State Universities and Colleges (SUCs)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-3-series-of-2025-Updated-Guidelines-for-Securing-Authority-to-Travel-Abroad-for-State-Universities-and-Colleges-SUCs.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 4, series of 2025 – Revised Policies, Standards and Guidelines for Associate in Radiologictechnology Education (ART) Program', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-4-s.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 5, series of 2025 – Guidelines for the Accreditation of Hospitals and Primary Health Care Facilities for the Clinical Practice of Radiologic/X-RAY Technology Interns', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-5-s.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 6, series of 2025 – Application Process for Authority to Offer Transnational Higher Education Pursuant to Republic Act No. 11448 or The Transnational Higher Education Act', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-6-s.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 7, series of 2025 – Policies, Standards and Guidelines for the Implementation of the National Merchant Marine Aptitude Test (NaMMAT)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-7-s.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 9, series of 2025 – Updated Guidelines for the Scholarships for Staff and Instructors\' Knowledge Advancement Program (SIKAP) for Full-Time and Part-Time Study', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-9-s.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 10, series of 2025 – Policies and Standards on Centers of Excellence (COE) | Annex A', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 11, series of 2025 – Implementing Rules and Regulations of Republic Act No. 12124, "An Act Institutionalizing the Expanded Tertiary Education Equivalency and Accreditation Program (ETEEAP) and Providing Funds Therefor"', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 12, series of 2025 – Policies and Guidelines on Open Distance and e-Learning (ODeL)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 13, series of 2025 – Revised Policies and Guidelines for the CHED Merit Scholarship Program (CMSP)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 14, series of 2025 – Revised Implementing Guidelines for the CHED Scholarship Program for Future Statisticians (ESTATISKOLAR)', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-14-s.-2025.pdf'],
            ['CHED', '0', '2025', NULL, 'CMO No. 15, series of 2025 – Updated Policies and Guidelines for the Grant of Autonomous and Deregulated Status to Private Higher Education Institutions', 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2025.pdf'],
            
            // DepEd Shape Paper
            ['DepEd', '0', 'Shape Paper', NULL, 'The Strengthened Senior High School Program Shaping Paper', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/The-Strengthened-Senior-High-School-Program-Shaping-Paper.pdf'],
            
            // DepEd Core
            ['DepEd', '0', 'Curriculum Guides (Core)', NULL, 'Effective Communication', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Effective-Communication.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Core)', NULL, 'General Mathematics', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/General-Mathematics.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Core)', NULL, 'General Science', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/General-Science.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Core)', NULL, 'Life and Career Skills', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Life-and-Career-Skills.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Core)', NULL, 'Mabisang Komunikasyon', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Mabisang-Komunikasyon.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Core)', NULL, 'Pag-aaral ng Kasaysayan at Lipunang Pilipino', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Pag-aaral-ng-Kasaysayan-at-Lipunang-Pilipino.pdf'],
            
            // DepEd Academic - ARTS, SOCIAL SCIENCE, AND HUMANITIES
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Arts 1 (Creative Industries - Visual Art, Literary Art, Media Art, Applied Art, and Traditional Art)', 'https://www.deped.gov.ph/wp-content/uploads/Arts-1-Creative-Industries-Visual-Art-Literary-Art-Media-Art-Applied-Art-and-Traditional-Art.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Arts 2 (Creative Industries - Music, Dance, and Theater)', 'https://www.deped.gov.ph/wp-content/uploads/Arts-2-Creative-Industries-Music-Dance-and-Theater.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Citizenship and Civic Engagement', 'https://www.deped.gov.ph/wp-content/uploads/Citizenship-and-Civic-Engagement.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Contemporary Literature 1', 'https://www.deped.gov.ph/wp-content/uploads/Contemporary-Literature-1.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Contemporary Literature 2', 'https://www.deped.gov.ph/wp-content/uploads/Contemporary-Literature-2.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Creative Composition 1', 'https://www.deped.gov.ph/wp-content/uploads/Creative-Composition-1.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Creative Composition 2', 'https://www.deped.gov.ph/wp-content/uploads/Creative-Composition-2.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Filipino 1 (Wika at Komunikasyon sa Akademikong Filipino)', 'https://www.deped.gov.ph/wp-content/uploads/Filipino-1-Wika-at-Komunikasyon-sa-Akademikong-Filipino.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Filipino 2 (Filipino para sa Larang Teknikal-Propesyonal)', 'https://www.deped.gov.ph/wp-content/uploads/Filipino-2-Filipino-para-sa-Larang-Teknikal-Propesyonal.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Filipino 2 (Filipino sa Isports)', 'https://www.deped.gov.ph/wp-content/uploads/Filipino-2-Filipino-sa-Isports.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Filipino 2 (Filipino sa Sining at Disenyo)', 'https://www.deped.gov.ph/wp-content/uploads/Filipino-2-Filipino-sa-Sining-at-Disenyo.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Filipino Identity Through the Arts', 'https://www.deped.gov.ph/wp-content/uploads/Filipino-Identity-Through-the-Arts.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Introduction to Philosophy', 'https://www.deped.gov.ph/wp-content/uploads/Introduction-to-Philosophy.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Leadership Management in the Arts', 'https://www.deped.gov.ph/wp-content/uploads/Leadership-and-Mangement-in-the-Arts.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Malikhaing Pagsulat', 'https://www.deped.gov.ph/wp-content/uploads/Malikhaing-Pagsulat.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Philippine Governance (Philippine Politics and Governance)', 'https://www.deped.gov.ph/wp-content/uploads/Philippine-Governance-Philippine-Politics-and-Governance.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Social Sciences (Theory and Practice)', 'https://www.deped.gov.ph/wp-content/uploads/Social-Sciences-Theory-and-Practice.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Arts 2 (Creative Industries II – Performing Arts)', 'https://www.deped.gov.ph/wp-content/uploads/Arts-2-Creative-Industries-II-%E2%80%93-Performing-Arts.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Social Science 1 (Introduction to Social Sciences)', 'https://www.deped.gov.ph/wp-content/uploads/Social-Science-1-Introduction-to-Social-Sciences.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Humanities 1 (Creative Writing)', 'https://www.deped.gov.ph/wp-content/uploads/Humanities-1-Creative-Writing.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'Humanities 2 (Introduction to World Religions and Belief Systems)', 'https://www.deped.gov.ph/wp-content/uploads/Humanities-2-Introduction-to-World-Religions-and-Belief-Systems.pdf'],
            
            // DepEd Academic - BUSINESS AND ENTREPRENEURSHIP
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'BUSINESS AND ENTREPRENEURSHIP', 'Business 1 (Basic Accounting)', 'https://www.deped.gov.ph/wp-content/uploads/Business-1-Basic-Accounting.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'BUSINESS AND ENTREPRENEURSHIP', 'Business 2 (Business Finance and Income Taxation)', 'https://www.deped.gov.ph/wp-content/uploads/Business-2-Business-Finance-and-Income-Taxation.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'BUSINESS AND ENTREPRENEURSHIP', 'Business 3 (Business Economics)', 'https://www.deped.gov.ph/wp-content/uploads/Business-3-Business-Economics.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'BUSINESS AND ENTREPRENEURSHIP', 'Contemporary Marketing', 'https://www.deped.gov.ph/wp-content/uploads/Contemprary-Marketing.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'BUSINESS AND ENTREPRENEURSHIP', 'Entrepreneurship', 'https://www.deped.gov.ph/wp-content/uploads/Entrepreneurship.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'BUSINESS AND ENTREPRENEURSHIP', 'Introduction to Organization and Management', 'https://www.deped.gov.ph/wp-content/uploads/Introduction-to-Organization-and-Management.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'BUSINESS AND ENTREPRENEURSHIP', 'Business 1 (Business Enterprise Simulation)', 'https://www.deped.gov.ph/wp-content/uploads/Business-1-Business-Enterprise-Simulation.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'BUSINESS AND ENTREPRENEURSHIP', 'Economics 1 (Introduction to Economics)', 'https://www.deped.gov.ph/wp-content/uploads/Economics-1-Introduction-to-Economics.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'BUSINESS AND ENTREPRENEURSHIP', 'Management 1 (Fundamentals of Accountancy, Business, and Management)', 'https://www.deped.gov.ph/wp-content/uploads/Management-1-Fundamentals-of-Accountancy-Business-and-Management.pdf'],
            
            // DepEd Academic - SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Biology 1', 'https://www.deped.gov.ph/wp-content/uploads/Biology-1.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Biology 2', 'https://www.deped.gov.ph/wp-content/uploads/Biology-2.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Chemistry 1', 'https://www.deped.gov.ph/wp-content/uploads/Chemistry-1.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Chemistry 2', 'https://www.deped.gov.ph/wp-content/uploads/Chemistry-2.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Earth and Space Science 1', 'https://www.deped.gov.ph/wp-content/uploads/Earth-and-Space-Science-1.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Earth and Space Science 2', 'https://www.deped.gov.ph/wp-content/uploads/Earth-and-Space-Science-2.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Finite Mathematics 1', 'https://www.deped.gov.ph/wp-content/uploads/Finite-Mathematics-1.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Finite Mathematics 2', 'https://www.deped.gov.ph/wp-content/uploads/Finite-Mathematics-2.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Physics 1', 'https://www.deped.gov.ph/wp-content/uploads/Physics-1.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Physics 2', 'https://www.deped.gov.ph/wp-content/uploads/Physics-2.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Engineering 1 (Calculus)', 'https://www.deped.gov.ph/wp-content/uploads/Engineering-1-Calculus.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Engineering 2 (Fundamentals of Programming)', 'https://www.deped.gov.ph/wp-content/uploads/Engineering-2-Fundamentals-of-Programming.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'Engineering 3 (Basic Electricity and Electronics)', 'https://www.deped.gov.ph/wp-content/uploads/Engineering-3-Basic-Electricity-and-Electronics.pdf'],
            
            // DepEd Academic - SPORTS, HEALTH, AND WELLNESS
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SPORTS, HEALTH, AND WELLNESS', 'Human Movement 1 (Basic Anatomy in Sports and Exercise)', 'https://www.deped.gov.ph/wp-content/uploads/Human-Movement-1-Basic-Anatomy-in-Sports-and-Exercise.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SPORTS, HEALTH, AND WELLNESS', 'Human Movement 2 (Motor Skills Development)', 'https://www.deped.gov.ph/wp-content/uploads/Human-Movement-2-Motor-Skills-Development.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SPORTS, HEALTH, AND WELLNESS', 'Physical Education 1 (Fitness and Recreation)', 'https://www.deped.gov.ph/wp-content/uploads/Physical-Education-1-Fitness-and-Recreation.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SPORTS, HEALTH, AND WELLNESS', 'Physical Education 2 (Sports and Dance)', 'https://www.deped.gov.ph/wp-content/uploads/Physical-Education-2-Sports-and-Dance.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SPORTS, HEALTH, AND WELLNESS', 'Sports Activity Management', 'https://www.deped.gov.ph/wp-content/uploads/Sports-Activity-Management.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SPORTS, HEALTH, AND WELLNESS', 'Sports Coaching', 'https://www.deped.gov.ph/wp-content/uploads/Sports-Coaching.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SPORTS, HEALTH, AND WELLNESS', 'Sports Officiating', 'https://www.deped.gov.ph/wp-content/uploads/Sports-Officiating.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SPORTS, HEALTH, AND WELLNESS', 'Health Science 1 (Introduction to Health Science)', 'https://www.deped.gov.ph/wp-content/uploads/Health-Science-1-Introduction-to-Health-Science.pdf'],
            ['DepEd', '0', 'Curriculum Guides (Academic)', 'SPORTS, HEALTH, AND WELLNESS', 'Health Science 2 (Basic Human Anatomy and Physiology)', 'https://www.deped.gov.ph/wp-content/uploads/Health-Science-2-Basic-Human-Anatomy-and-Physiology.pdf'],
            
            // DepEd TechPro - INFORMATION AND COMMUNICATIONS TECHNOLOGY
            ['DepEd', '0', 'Curriculum Guides (TechPro)', 'INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'Digital Tools and Productivity Applications', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Digital-Tools-and-Productivity-Applications.pdf'],
            ['DepEd', '0', 'Curriculum Guides (TechPro)', 'INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'Multimedia Development and Design', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Multimedia-Development-and-Design.pdf'],
            ['DepEd', '0', 'Curriculum Guides (TechPro)', 'INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'Computer Systems and Network Administration', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Computer-Systems-and-Network-Administration.pdf'],
            ['DepEd', '0', 'Curriculum Guides (TechPro)', 'INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'Web Development', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Web-Development.pdf'],
            ['DepEd', '0', 'Curriculum Guides (TechPro)', 'INFORMATION AND COMMUNICATIONS TECHNOLOGY', 'Computer Programming', 'https://www.deped.gov.ph/wp-content/uploads/2024/05/Computer-Programming.pdf'],
        ];

        foreach ($links as $link) {
            DB::table('compliance_links')->insert([
                'agency' => $link[0],
                'is_category' => $link[1],
                'year' => $link[2],
                'group' => $link[3],
                'title' => $link[4],
                'url' => $link[5],
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
        if (Schema::hasColumn('compliance_links', 'group')) {
            Schema::table('compliance_links', function (Blueprint $table) {
                $table->dropColumn('group');
            });
        }
    }
};
