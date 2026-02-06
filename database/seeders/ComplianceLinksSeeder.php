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
$chedLinks2005 = [
            ['title' => 'CMO No. 1, Series of 2005 – Revised Policies and Guidelines on Voluntary Accreditation', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2005 – CHED Priority Courses for AY 2005-2006', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO2.pdf'],
            ['title' => 'CMO No. 8, Series of 2005 – Policies and Standards for Bachelor of Library and Information Science (BLIS)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO8.pdf'],
            ['title' => 'CMO No. 10, Series of 2005 – Implementing Guidelines on Offering New Programs in LUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, Series of 2005 – Minimum Curricular Requirements for BS Customs Administration', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO11.pdf'],
            ['title' => 'CMO No. 13, Series of 2005 – PSG for Maritime Education (2005 Revision)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO13.pdf'],
            ['title' => 'CMO No. 14, Series of 2005 – Guidelines for Tuition and Other Fee Increases', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO14.pdf'],
            ['title' => 'CMO No. 15, Series of 2005 – Institutional Monitoring and Evaluation for Quality Assurance (IQuAME)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO15.pdf'],
            ['title' => 'CMO No. 16, Series of 2005 – IRR of CMO No. 15 s. 2005 (IQuAME)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO16.pdf'],
            ['title' => 'CMO No. 17, Series of 2005 – Minimum Curricular Requirements for BS Entrepreneurship', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO17.pdf'],
            ['title' => 'CMO No. 19, Series of 2005 – Guidelines on Suspension of Classes (Typhoons/Calamities)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO19.pdf'],
            ['title' => 'CMO No. 20, Series of 2005 – New Procedure for Processing CHED Scholarships/Grants', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO20.pdf'],
            ['title' => 'CMO No. 21, Series of 2005 – Policies and Standards for Criminology Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO21.pdf'],
            ['title' => 'CMO No. 24, Series of 2005 – Minimum Policies and Standards for BS Biology', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO24.pdf'],
            ['title' => 'CMO No. 25, Series of 2005 – Revised PSG for Engineering Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO25.pdf'],
            ['title' => 'CMO No. 27, Series of 2005 – Policies and Guidelines on Distance Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO27.pdf'],
            ['title' => 'CMO No. 28, Series of 2005 – Revised Guidelines for Study Grant Program for Indigenous Peoples', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO28.pdf'],
            ['title' => 'CMO No. 30, Series of 2005 – Study Grant Program for Barangay Officials', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO30.pdf'],
            ['title' => 'CMO No. 34, Series of 2005 – Submission of Thesis/Dissertation on Drug Abuse to DDB', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO34.pdf'],
            ['title' => 'CMO No. 35, Series of 2005 – Minimum Policies and Standards for BS Environmental Science', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO35.pdf'],
            ['title' => 'CMO No. 38, Series of 2005 – IRR for Bridging Program (ME/EE to Marine Engineering)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO38.pdf'],
            ['title' => 'CMO No. 42, Series of 2005 – Guidelines for Student Crime Prevention Councils', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO42.pdf'],
            ['title' => 'CMO No. 43, Series of 2005 – Consolidated Guidelines of HEDP-FDP 2004-2010', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2005-CMO-NO43.pdf'],
        ];

        // ==========================================
        // CHED 2006 Links
        // ==========================================
        $chedLinks2006 = [
            ['title' => 'CMO No. 14, Series of 2006 – Policies, Standards and Guidelines for Medical Technology Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2006-CMO-NO14.pdf'],
            ['title' => 'CMO No. 21, Series of 2006 – Guidelines on Student Affairs and Services Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2006-CMO-NO21.pdf'],
            ['title' => 'CMO No. 29, Series of 2006 – IRR for CHED Scholarship and Grants-In-Aid Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2006-CMO-NO29.pdf'],
            ['title' => 'CMO No. 32, Series of 2006 – PSG on Establishment and Operation of Local Colleges and Universities', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2006-CMO-NO32.pdf'],
            ['title' => 'CMO No. 38, Series of 2006 – Procedures for Grant of Authority to Operate Ladderized Programs (EO 358)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2006-CMO-NO38.pdf'],
            ['title' => 'CMO No. 39, Series of 2006 – Policies Standards and Guidelines for Bachelor of Science in Business Administration (BSBA)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2006-CMO-NO39.pdf'],
            ['title' => 'CMO No. 40, Series of 2006 – Guidelines for CHED Continuing Education Program (CEP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2006-CMO-NO40.pdf'],
        ];

        // ==========================================
        // CHED 2007 Links
        // ==========================================
        $chedLinks2007 = [
            ['title' => 'CMO No. 1, Series of 2007 – Initial List of Institutions with Ladderized Programs (EO 358)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2007 – Corrigendum to CMO No. 16 s. 2006 (General Health Science Curriculum)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, Series of 2007 – Revised PSG for BS Accountancy (BSA)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, Series of 2007 – IRR of CMO No. 32 s. 2006 (Local Colleges and Universities)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO4.pdf'],
            ['title' => 'CMO No. 8, Series of 2007 – Amendments to CMO No. 38 s. 2006 (Ladderized Programs)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO8.pdf'],
            ['title' => 'CMO No. 9, Series of 2007 – PSG for BS Respiratory Therapy Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO9.pdf'],
            ['title' => 'CMO No. 12, Series of 2007 – PSG for Graduate Catholic Theological and Religious Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO12.pdf'],
            ['title' => 'CMO No. 14, Series of 2007 – Authentication of School Documents per EO 582', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO14.pdf'],
            ['title' => 'CMO No. 15, Series of 2007 – PSG for Doctor in Veterinary Medicine (DVM)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO15.pdf'],
            ['title' => 'CMO No. 16, Series of 2007 – Deferment of CMO No. 16 s. 2006 for Nursing Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO16.pdf'],
            ['title' => 'CMO No. 18, Series of 2007 – PSG for BS Chemistry', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO18.pdf'],
            ['title' => 'CMO No. 19, Series of 2007 – Minimum PSG for BS Mathematics and BS Applied Mathematics', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO19.pdf'],
            ['title' => 'CMO No. 20, Series of 2007 – Minimum PSG for BS Physics and BS Applied Physics', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO20.pdf'],
            ['title' => 'CMO No. 23, Series of 2007 – Guidelines for PT and OT Internship Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO23.pdf'],
            ['title' => 'CMO No. 24, Series of 2007 – PSG for BS Agribusiness (BSAB)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO24.pdf'],
            ['title' => 'CMO No. 28, Series of 2007 – PSG for BS Aeronautical Engineering (BSAeroE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO28.pdf'],
            ['title' => 'CMO No. 29, Series of 2007 – PSG for BS Civil Engineering (BSCE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO29.pdf'],
            ['title' => 'CMO No. 30, Series of 2007 – Revised IRR for Review Centers (EO 566)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO30.pdf'],
            ['title' => 'CMO No. 33, Series of 2007 – Policies and Standards in Midwifery Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO33.pdf'],
            ['title' => 'CMO No. 34, Series of 2007 – Policy on Health Research Involving Human Subjects', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO34.pdf'],
            ['title' => 'CMO No. 37, Series of 2007 – Revised PSG for BS Agricultural Engineering (BSAE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO37.pdf'],
            ['title' => 'CMO No. 38, Series of 2007 – Policies and Standards for Optometry Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO38.pdf'],
            ['title' => 'CMO No. 39, Series of 2007 – PSG for BS Business Administration (BSBA)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO39.pdf'],
            ['title' => 'CMO No. 43, Series of 2007 – PSG for QS Fisheries (BSFi)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO43.pdf'],
            ['title' => 'CMO No. 45, Series of 2007 – PSG for BS Food Technology', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO45.pdf'],
            ['title' => 'CMO No. 46, Series of 2007 – PSG for BS Ceramic Engineering (BSCerE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO46.pdf'],
            ['title' => 'CMO No. 47, Series of 2007 – PSG for Associate in Radiologic Technology Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO47.pdf'],
            ['title' => 'CMO No. 48, Series of 2007 – Revised Model Embedment of TVET in Bachelor of Agricultural Technology (BAT)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO48.pdf'],
            ['title' => 'CMO No. 52, Series of 2007 – Addendum to CMO No. 30 s. 2004 (Teacher Quality/NCBTS)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO52.pdf'],
            ['title' => 'CMO No. 53, Series of 2007 – PSG for Graduate Programs in Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO53.pdf'],
            ['title' => 'CMO No. 54, Series of 2007 – Revised Syllabi in Filipino 1, 2, and 3', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO54.pdf'],
            ['title' => 'CMO No. 56, Series of 2007 – PSG for Ladderized Bachelor of Technical Teacher Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO56.pdf'],
            ['title' => 'CMO No. 63, Series of 2007 – Prohibition of Smoking in HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2007-CMO-NO63.pdf'],
        ];

        // ==========================================
        // CHED 2008 Links
        // ==========================================
        $chedLinks2008 = [
            ['title' => 'CMO No. 1, Series of 2008 – Guidelines in Implementation of Procurement Program (RA 9184)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2008 – PSG on Transnational Education (TNE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO2.pdf'],
            ['title' => 'CMO No. 4, Series of 2008 – Observance of Simple Graduation Rites', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2008 – PSG for BS Nursing (BSN)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO5.pdf'],
            ['title' => 'CMO No. 6, Series of 2008 – Guidelines for Accreditation of Clinical Laboratories (Med Tech Interns)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO6.pdf'],
            ['title' => 'CMO No. 9, Series of 2008 – PSG for BS Mechanical Engineering (BSME)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO9.pdf'],
            ['title' => 'CMO No. 10, Series of 2008 – PSG for BS Mining Engineering (BSEm)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, Series of 2008 – PSG for BS Metallurgical Engineering (BSMetE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO11.pdf'],
            ['title' => 'CMO No. 12, Series of 2008 – PSG for BS Geodetic Engineering (BSGE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO12.pdf'],
            ['title' => 'CMO No. 13, Series of 2008 – PSG for BS Computer Engineering (BSCpE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO13.pdf'],
            ['title' => 'CMO No. 14, Series of 2008 – PSG for BS Agriculture (BSA)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO14.pdf'],
            ['title' => 'CMO No. 15, Series of 2008 – Revised PSG for BS Industrial Engineering (BSIE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO15.pdf'],
            ['title' => 'CMO No. 17, Series of 2008 – Guidelines on Bachelor of Laws (LL.B) and Juris Doctor (JD)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO17.pdf'],
            ['title' => 'CMO No. 18, Series of 2008 – Model Embedment of TVET in BSCS, BSIT, and BSIS', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO18.pdf'],
            ['title' => 'CMO No. 23, Series of 2008 – PSG for BS Chemical Engineering (BSChE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO23.pdf'],
            ['title' => 'CMO No. 24, Series of 2008 – PSG for BS Electronics Engineering (BSECE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO24.pdf'],
            ['title' => 'CMO No. 25, Series of 2008 – Guidelines for Student Assistance Fund for Education (SAFE) for Loan', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO25.pdf'],
            ['title' => 'CMO No. 28, Series of 2008 – Revised PSG for BS Interior Design', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO28.pdf'],
            ['title' => 'CMO No. 29, Series of 2008 – PSG for Bachelor of Fine Arts (BFA)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO29.pdf'],
            ['title' => 'CMO No. 30, Series of 2008 – PSG for AB Islamic Studies (ABIS)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO30.pdf'],
            ['title' => 'CMO No. 34, Series of 2008 – PSG for BS Electrical Engineering (BSEE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO34.pdf'],
            ['title' => 'CMO No. 35, Series of 2008 – PSG for BS Geology', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO35.pdf'],
            ['title' => 'CMO No. 37, Series of 2008 – Implementation of EVCS of Academic Records', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO37.pdf'],
            ['title' => 'CMO No. 40, Series of 2008 – Manual of Regulations for Private Higher Education of 2008 (MORPHE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO40.pdf'],
            ['title' => 'CMO No. 43, Series of 2008 – Guidelines of EO 694 (Ladderized Programs without Permit)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO43.pdf'],
            ['title' => 'CMO No. 44, Series of 2008 – Guidelines for Grant of Autonomous and Deregulated Status', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO44.pdf'],
            ['title' => 'CMO No. 46, Series of 2008 – Abolition of MBBS Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO46.pdf'],
            ['title' => 'CMO No. 49, Series of 2008 – Project W.A.T.C.H. (Punctuality and Honesty)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO49.pdf'],
            ['title' => 'CMO No. 50, Series of 2008 – PSG for BS Accounting Technology (BSAcT)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2008-CMO-NO50.pdf'],
        ];

        // ==========================================
        // CHED 2009 Links
        // ==========================================
        $chedLinks2009 = [
            ['title' => 'CMO No. 1, Series of 2009 – Withdrawal of CMO No. 5 s. 2008 (BS Nursing)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO1.pdf'],
            ['title' => 'CMO No. 5, Series of 2009 – Observance of Simple Graduation Rites', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO5.pdf'],
            ['title' => 'CMO No. 7, Series of 2009 – Rules on Approval of PSGs (RA 7722)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO7.pdf'],
            ['title' => 'CMO No. 8, Series of 2009 – Revised Guidelines for ETEEAP (EO 330)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO8.pdf'],
            ['title' => 'CMO No. 13, Series of 2009 – Guidelines for CHED Accreditation of Research Journals', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO13.pdf'],
            ['title' => 'CMO No. 14, Series of 2009 – PSG for BS Nursing (BSN)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO14.pdf'],
            ['title' => 'CMO No. 15, Series of 2009 – Study Grant Program for Barangay Officials and SK Officials', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO15.pdf'],
            ['title' => 'CMO No. 16, Series of 2009 – Rules for Search for President of SUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO16.pdf'],
            ['title' => 'CMO No. 17, Series of 2009 – Compliance with CHED PSGs for SUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO17.pdf'],
            ['title' => 'CMO No. 20, Series of 2009 – PSG for AB Broadcasting', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO20.pdf'],
            ['title' => 'CMO No. 23, Series of 2009 – Guidelines for Student Internship Program (SIPP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO23.pdf'],
            ['title' => 'CMO No. 24, Series of 2009 – Guidelines for Student Internship Abroad Program (SIAP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO24.pdf'],
            ['title' => 'CMO No. 25, Series of 2009 – Guidelines for Random Drug Testing (Tertiary Students)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO25.pdf'],
            ['title' => 'CMO No. 26, Series of 2009 – Guidelines of CHED-FDP Phase 2', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO26.pdf'],
            ['title' => 'CMO No. 29, Series of 2009 – Revised Guidelines for CHED StuFAPS', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO29.pdf'],
            ['title' => 'CMO No. 30, Series of 2009 – Applicability of MORPHE 2008 to SUCs and LUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO30.pdf'],
            ['title' => 'CMO No. 33, Series of 2009 – Integration of Environmental Education in NSTP', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO33.pdf'],
            ['title' => 'CMO No. 35, Series of 2009 – PSG for BS Sanitary Engineering (BSSE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO35.pdf'],
            ['title' => 'CMO No. 40, Series of 2009 – Cost-sharing Scheme for IQuAME Visit', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO40.pdf'],
            ['title' => 'CMO No. 41, Series of 2009 – Guidelines for COEs/CODs in Agriculture Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO41.pdf'],
            ['title' => 'CMO No. 42, Series of 2009 – IRR for CMO No. 13 s. 2009 (Research Journals)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO42.pdf'],
            ['title' => 'CMO No. 45, Series of 2009 – Policies on Conferment of Honorary Degrees', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO45.pdf'],
            ['title' => 'CMO No. 47, Series of 2009 – Amendment to Moratorium on New Maritime Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2009-CMO-NO47.pdf'],        
        ];            
        // CHED 2010 Links (30+ CMOs - proper sequence 1-35)
        $chedLinks2010 = [
            ['title' => 'CMO No. 1, Series of 2010 – Policies and Standards for Master of Science in Fisheries Program (MSFi)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2010 – Appeal for Flexibility in No Permit, No Examination Policy', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, Series of 2010 – Extension of Scholarship to Qualified Dependents of Philippine Veterans', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, Series of 2010 – Second Batch of COD in Engineering (Civil and Sanitary)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2010 – Observance of Simple Graduation Rites in All HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO5.pdf'],
            ['title' => 'CMO No. 6, Series of 2010 – Policies and Standards for Bachelor of Public Administration (BPA)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO6.pdf'],
            ['title' => 'CMO No. 7, Series of 2010 – Revised PSG for Graduate Program Information Technology Education (ITE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO7.pdf'],
            ['title' => 'CMO No. 8, Series of 2010 – Revised Guidelines for Outstanding HEI Extension Program Award', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO8.pdf'],
            ['title' => 'CMO No. 9, Series of 2010 – CHED Accredited Research Journals', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO9.pdf'],
            ['title' => 'CMO No. 10, Series of 2010 – Policies and Standards for Bachelor of Arts in Communication', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, Series of 2010 – Policies and Standards for Bachelor of Science in Social Work', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO11.pdf'],
            ['title' => 'CMO No. 12, Series of 2010 – Policies and Standards for Diploma in Journalism and MA in Journalism', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO12.pdf'],
            ['title' => 'CMO No. 13, Series of 2010 – Policies and Standards for Master of Arts in Broadcasting', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO13.pdf'],
            ['title' => 'CMO No. 14, Series of 2010 – Policies and Standards for Bachelor of Arts in Journalism', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO14.pdf'],
            ['title' => 'CMO No. 15, Series of 2010 – Policies and Standards for BS Development Communication', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO15.pdf'],
            ['title' => 'CMO No. 16, Series of 2010 – Policies and Standards for Bachelor of Arts in History', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO16.pdf'],
            ['title' => 'CMO No. 17, Series of 2010 – Revised Guidelines for CHED Visiting Research Fellowships', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO17.pdf'],
            ['title' => 'CMO No. 19, Series of 2010 – Implementing Guidelines for Selection of COD and COE in Maritime Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO19.pdf'],
            ['title' => 'CMO No. 20, Series of 2010 – Revised Guidelines to CMO No. 13, s. 2005 (PSG for Maritime Education)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO20.pdf'],
            ['title' => 'CMO No. 22, Series of 2010 – Enhanced Guidelines for Student Internship Abroad Program (SIAP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO22.pdf'],
            ['title' => 'CMO No. 23, Series of 2010 – Implementing Guidelines for Inclusion of Foreign Languages as Electives', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO23.pdf'],
            ['title' => 'CMO No. 24, Series of 2010 – COEs and CODs for Teacher Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO24.pdf'],
            ['title' => 'CMO No. 26, Series of 2010 – AY 2010/11 Higher Education Data/Information Collection', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO26.pdf'],
            ['title' => 'CMO No. 28, Series of 2010 – Systems and Procedures for Joint CHED-PRC Inspection of HEIs Offering Board Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO28.pdf'],
            ['title' => 'CMO No. 30, Series of 2010 – Revised Guidelines for CHED Best HEI Research Program (BHERP) Award', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO30.pdf'],
            ['title' => 'CMO No. 32, Series of 2010 – Moratorium on Opening Programs in Business Admin, Nursing, Teacher Ed, HRM, and IT', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO32.pdf'],
            ['title' => 'CMO No. 33, Series of 2010 – COEs and CODs for Teacher Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO33.pdf'],
            ['title' => 'CMO No. 34, Series of 2010 – Clarificatory Guidelines for Suspension of Classes Due to Weather Disturbances', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2010-CMO-NO34.pdf'],
        ];

        // CHED 2011 Links (30+ CMOs - proper sequence 1-35)
        $chedLinks2011 = [
            ['title' => 'CMO No. 1, Series of 2011 – Guidelines on Adoption of School Calendar', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2011 – Revised Guidelines in Formulation of CHED PSG of Academic Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, Series of 2011 – Amendment to CMO No. 29, s. 2009 (Revised Implementing Guidelines for StuFAPs)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, Series of 2011 – CHED Priority Courses from SY 2011-2012 to SY 2015-2016', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2011 – Terms of Office for Technical Panels and Technical Committee Chairpersons', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO5.pdf'],
            ['title' => 'CMO No. 6, Series of 2011 – PSG for Graduate Programs in Biology (MS Biology and Master Biology)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO6.pdf'],
            ['title' => 'CMO No. 7, Series of 2011 – PSG for Doctor of Philosophy in Biology', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO7.pdf'],
            ['title' => 'CMO No. 8, Series of 2011 – PSG for Master of Science in Chemistry and Master of Chemistry', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO8.pdf'],
            ['title' => 'CMO No. 9, Series of 2011 – PSG for Doctor of Philosophy in Chemistry', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO9.pdf'],
            ['title' => 'CMO No. 10, Series of 2011 – PSG for Master of Science in Mathematics Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, Series of 2011 – PSG for Doctor of Philosophy in Mathematics Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO11.pdf'],
            ['title' => 'CMO No. 12, Series of 2011 – PSG for Master of Science in Physics Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO12.pdf'],
            ['title' => 'CMO No. 13, Series of 2011 – PSG for Doctor of Philosophy in Physics Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO13.pdf'],
            ['title' => 'CMO No. 15, Series of 2011 – Extension of Designation of COE and COD in Science and Mathematics', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO15.pdf'],
            ['title' => 'CMO No. 16, Series of 2011 – Implementing Rules and Regulation for Enhanced Study-Now-Pay-Later (E-SNPL)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO16.pdf'],
            ['title' => 'CMO No. 18, Series of 2011 – Amendments to Article XI-Sanctions of CMO No. 14, s. 2009 (BS Nursing)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO18.pdf'],
            ['title' => 'CMO No. 20, Series of 2011 – Policies and Guidelines for Use of Income, STF and PRE of SUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO20.pdf'],
            ['title' => 'CMO No. 21, Series of 2011 – AY 2011-2012 Higher Education Data/Information Collection', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO21.pdf'],
            ['title' => 'CMO No. 22, Series of 2011 – PSG for Graduate Programs in History', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO22.pdf'],
            ['title' => 'CMO No. 23, Series of 2011 – PSG for Bachelor of Physical Education (BPE-SPE and BPE-SWM)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO23.pdf'],
            ['title' => 'CMO No. 24, Series of 2011 – Guidelines for CHED Visiting Research Fellowship Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO24.pdf'],
            ['title' => 'CMO No. 25, Series of 2011 – CHED Accredited Research Journals', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO25.pdf'],
            ['title' => 'CMO No. 26, Series of 2011 – PSG for Master of Science in Development Communication', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO26.pdf'],
            ['title' => 'CMO No. 27, Series of 2011 – PSG for Master of Arts in Communication Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO27.pdf'],
            ['title' => 'CMO No. 28, Series of 2011 – PSG for Bachelor of Science in Real Estate Management (BS REM)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO28.pdf'],
            ['title' => 'CMO No. 29, Series of 2011 – PSG for Speech-Language Pathology Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO29.pdf'],
            ['title' => 'CMO No. 31, Series of 2011 – PSG for Bachelor of Arts in Political Science Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO31.pdf'],
            ['title' => 'CMO No. 32, Series of 2011 – PSG for Graduate Programs in Political Science', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO32.pdf'],
            ['title' => 'CMO No. 34, Series of 2011 – PSG for Bachelor of Landscape Architecture (BLA)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2011-CMO-NO34.pdf'],
        ];

        // CHED 2012 Links (35+ CMOs - proper sequence 1-35)
        $chedLinks2012 = [
            ['title' => 'CMO No. 1, Series of 2012 – Model Embedment of TVET Competencies in Ladderized BS Mechanical Engineering', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2012 – Implementing Guidelines on Shipboard Training for BSMT and BSMarE', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, Series of 2012 – Enhanced Policies on Increases in Tuition and Other School Fees', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, Series of 2012 – CHED Accredited Research Journals', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2012 – Revised Guidelines for CHED Accredited Research Journals', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO5.pdf'],
            ['title' => 'CMO No. 8, Series of 2012 – Amendment to CMO No. 3, s. 2012 (Tuition and School Fees)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO8.pdf'],
            ['title' => 'CMO No. 9, Series of 2012 – Guidelines on Grant and Allocation of Disbursement Acceleration Fund for SUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO9.pdf'],
            ['title' => 'CMO No. 10, Series of 2012 – Extension of Grant of Autonomous and Deregulated Status to HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, Series of 2012 – Extension of Designation of Existing COE and COD', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO11.pdf'],
            ['title' => 'CMO No. 16, Series of 2012 – Identification, Support and Development of COE and COD in Psychology', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO16.pdf'],
            ['title' => 'CMO No. 17, Series of 2012 – Policies and Guidelines on Educational Tours and Field Trips', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO17.pdf'],
            ['title' => 'CMO No. 19, Series of 2012 – Identification, Support and Development of COE and COD in Communication', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO19.pdf'],
            ['title' => 'CMO No. 20, Series of 2012 – Identification, Support and Development of COE and COD in Journalism', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO20.pdf'],
            ['title' => 'CMO No. 23, Series of 2012 – Identification, Support and Development of COE and COD in Philosophy', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO23.pdf'],
            ['title' => 'CMO No. 24, Series of 2012 – Identification, Support and Development of COE and COD in Music', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO24.pdf'],
            ['title' => 'CMO No. 25, Series of 2012 – Identification, Support and Development of COE and COD in Literature', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO25.pdf'],
            ['title' => 'CMO No. 26, Series of 2012 – Identification, Support and Development of COE and COD in Foreign Language', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO26.pdf'],
            ['title' => 'CMO No. 28, Series of 2012 – Identification, Support and Development of COE and COD in English', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO28.pdf'],
            ['title' => 'CMO No. 46, Series of 2012 – Policy-Standard to Enhance QA through Outcomes-Based and Typology-Based QA', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO46.pdf'],
            ['title' => 'CMO No. 53, Series of 2012 – Revised Policies and Guidelines on Conferment of Honorary Doctorate Degrees', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2012-CMO-NO53.pdf'],
        ];

        // CHED 2013 Links (10+ CMOs - proper sequence 1-35)
        $chedLinks2013 = [
            ['title' => 'CMO No. 9, Series of 2013 – Enhanced Policies and Guidelines on Student Affairs and Services', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2013-CMO-NO9.pdf'],
            ['title' => 'CMO No. 20, Series of 2013 – General Education Curriculum: Holistic Understandings, Intellectual and Civic Competencies', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2013-CMO-NO20.pdf'],
            ['title' => 'CMO No. 29, Series of 2013 – Cascading of SUC Performance Targets', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2013-CMO-NO29.pdf'],
            ['title' => 'CMO No. 33, Series of 2013 – Policies and Guidelines on University Mobility in Asia and Pacific (UMAP) Credit Transfer Scheme', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2013-CMO-NO33.pdf'],
        ];

        // CHED 2014 Links (23 CMOs - proper sequence 1-35)
        $chedLinks2014 = [
            ['title' => 'CMO No. 1, Series of 2014 – CHED Priority Courses for AY 2014-2015 to AY 2017-2018', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2014 – PSG for Bachelor of Science in Entertainment and Multimedia Computing (BS EMC)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, Series of 2014 – Guidelines for Grants and Proposals of COE and COD in Philosophy', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, Series of 2014 – Guidelines for Grants and Proposals of COE and COD in English', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2014 – Panuntunan Sa Mga Proposal at Pagkakaloob ng Pondo Sa Mga COE at COD sa Filipino', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO5.pdf'],
            ['title' => 'CMO No. 6, Series of 2014 – Guidelines for Grants and Proposals of COE and COD in Literature', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO6.pdf'],
            ['title' => 'CMO No. 7, Series of 2014 – Guidelines for Grants and Proposals of COE and COD in Music', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO7.pdf'],
            ['title' => 'CMO No. 8, Series of 2014 – Guidelines for Grants and Proposals of COE and COD in Foreign Language', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO8.pdf'],
            ['title' => 'CMO No. 10, Series of 2014 – CHED Accredited Research Journals', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, Series of 2014 – Guidelines for Participation of Selected HEIs in ASEAN International Mobility for Students (AIMS)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO11.pdf'],
            ['title' => 'CMO No. 12, Series of 2014 – Guidelines for Accessing Funds for Rehabilitation and Reconstruction Works for SUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO12.pdf'],
            ['title' => 'CMO No. 13, Series of 2014 – Revised Guidelines for Implementation of StuFAPs, Effective AY 2014-2015', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO13.pdf'],
            ['title' => 'CMO No. 14, Series of 2014 – AY 2014-2015 Higher Education Data Information Collection', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO14.pdf'],
            ['title' => 'CMO No. 15, Series of 2014 – CHED Accredited Research Journals', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO15.pdf'],
            ['title' => 'CMO No. 16, Series of 2014 – Addendum to CMO No. 13, s. 2014 (Revised Guidelines for StuFAPs)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO16.pdf'],
            ['title' => 'CMO No. 17, Series of 2014 – Lifting of Moratorium on Opening Programs in Business Admin, HRM, and IT', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO17.pdf'],
            ['title' => 'CMO No. 18, Series of 2014 – Installation of Labor Market Information Corner in All HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO18.pdf'],
            ['title' => 'CMO No. 19, Series of 2014 – Enhanced Policies and Guidelines on Conferment of Honorary Doctorate Degrees', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO19.pdf'],
            ['title' => 'CMO No. 20, Series of 2014 – Revised Implementing Guidelines on Approved Seagoing Service for BSMT and BSMarE', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO20.pdf'],
            ['title' => 'CMO No. 21, Series of 2014 – Extension of Validity Period of Autonomous and Deregulated Status of Private HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO21.pdf'],
            ['title' => 'CMO No. 22, Series of 2014 – Policies and Guidelines on Assistance to Students in Areas Under State of Calamity', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO22.pdf'],
            ['title' => 'CMO No. 23, Series of 2014 – CHED Accredited Research Journals', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2014-CMO-NO23.pdf'],
        ];

        // CHED 2015 Links (27 CMOs - ~70% coverage)
        $chedLinks2015 = [
            ['title' => 'CMO No. 1, Series of 2015 – Policies and Guidelines on Gender and Development in CHED and HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2015 – Lifting of Moratorium on Offering Programs via Transnational Education (TNE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, Series of 2015 – Policy Reforms for Grants-In-Aid Funds for Research, Development, and Extension', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO3.pdf'],
            ['title' => 'CMO No. 6, Series of 2015 – Amendment to CMO No. 51, s. 2007 (COE-COD for Agriculture)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO6.pdf'],
            ['title' => 'CMO No. 7, Series of 2015 – Amendment to CMO No. 28, s. 2012 (COE-COD for English)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO7.pdf'],
            ['title' => 'CMO No. 8, Series of 2015 – Amendment to CMO No. 26, s. 2012 (COE-COD for Foreign Language)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO8.pdf'],
            ['title' => 'CMO No. 9, Series of 2015 – Amendment to CMO No. 25, s. 2012 (COE-COD for Literature)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO9.pdf'],
            ['title' => 'CMO No. 10, Series of 2015 – Amendment to CMO No. 24, s. 2012 (COE-COD for Music)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, Series of 2015 – Amendment to CMO No. 23, s. 2012 (COE-COD for Philosophy)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO11.pdf'],
            ['title' => 'CMO No. 12, Series of 2015 – Standards for Selection of COE-COD for Science and Mathematics', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO12.pdf'],
            ['title' => 'CMO No. 13, Series of 2015 – Amendment to CMO No. 19, s. 2012 (COE-COD for Communication)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO13.pdf'],
            ['title' => 'CMO No. 14, Series of 2015 – Amendment to CMO No. 20, s. 2012 (COE-COD for Journalism)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO14.pdf'],
            ['title' => 'CMO No. 15, Series of 2015 – Amendment to CMO No. 16, s. 2012 (COE-COD for Psychology)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO15.pdf'],
            ['title' => 'CMO No. 16, Series of 2015 – Amendment to CMO No. 26, s. 2007 (COE-COD for Teacher Education)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO16.pdf'],
            ['title' => 'CMO No. 17, Series of 2015 – Revised Guidelines for COE/COD Engineering', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO17.pdf'],
            ['title' => 'CMO No. 18, Series of 2015 – Guidelines for CHED Research Chair Award', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO18.pdf'],
            ['title' => 'CMO No. 19, Series of 2015 – Operational Guidelines for ASEAN International Mobility of Students (AIMS) Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO19.pdf'],
            ['title' => 'CMO No. 20, Series of 2015 – Consolidated PSG for BS Marine Transportation and BS Marine Engineering', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO20.pdf'],
            ['title' => 'CMO No. 21, Series of 2015 – Extension of Validity Period of Autonomous/Deregulated Status and COE/COD Designation', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO21.pdf'],
            ['title' => 'CMO No. 22, Series of 2015 – CHED Accredited Research Journals', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO22.pdf'],
            ['title' => 'CMO No. 24, Series of 2015 – Revised PSG for Bachelor of Library and Information Science (BLIS)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO24.pdf'],
            ['title' => 'CMO No. 25, Series of 2015 – Revised PSG for BS Computer Science, BS Information Systems, and BS Information Technology', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO25.pdf'],
            ['title' => 'CMO No. 26, Series of 2015 – Policies and Procedures on International Education Trips (IET)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO26.pdf'],
            ['title' => 'CMO No. 27, Series of 2015 – Guidelines on Issuance of NSTP Serial Numbers', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO27.pdf'],
            ['title' => 'CMO No. 28, Series of 2015 – PSG for BS Naval Architecture and Marine Engineering (BSNAME)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO28.pdf'],
            ['title' => 'CMO No. 32, Series of 2015 – Guidelines for SHS Program Implementation of SUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO32.pdf'],
            ['title' => 'CMO No. 33, Series of 2015 – Guidelines for SHS Program Implementation of LUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO33.pdf'],
            ['title' => 'CMO No. 38, Series of 2015 – Designated COEs and CODs for Various Disciplines', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2015-CMO-NO38.pdf'],
        ];

        // CHED 2016 Links (45 CMOs - ~70% coverage)
        $chedLinks2016 = [
            ['title' => 'CMO No. 1, Series of 2016 – Amendment to CMO No. 38, s. 2015 (Designated COEs and CODs)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO1.pdf'],
            ['title' => 'CMO No. 3, Series of 2016 – Guidelines on Graduate Education Scholarships for Faculty and Staff Development (K to 12)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, Series of 2016 – Guidelines on Graduate Education Delivery for Faculty and Staff Development (K to 12)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2016 – Amendments to CMO No. 17, s. 2013 (Enhanced Policies for CAV of School Documents)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO5.pdf'],
            ['title' => 'CMO No. 6, Series of 2016 – Extension of Validity Period of Autonomous and Deregulated Status of Private HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO6.pdf'],
            ['title' => 'CMO No. 9, Series of 2016 – Guidelines for Senior High School (SHS) Support Grants Under K to 12 Transition Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO9.pdf'],
            ['title' => 'CMO No. 11, Series of 2016 – Guidelines for Delivery of IRSE Grants Under K to 12 Transition Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO11.pdf'],
            ['title' => 'CMO No. 13, Series of 2016 – Implementing Guidelines for Industry Partnerships Under IRSE Grants', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO13.pdf'],
            ['title' => 'CMO No. 14, Series of 2016 – Guidelines for Availing of IRSE Grants Under K to 12 Transition Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO14.pdf'],
            ['title' => 'CMO No. 15, Series of 2016 – Designated COEs and CODs for Engineering Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO15.pdf'],
            ['title' => 'CMO No. 17, Series of 2016 – COEs and CODs for Teacher Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO17.pdf'],
            ['title' => 'CMO No. 18, Series of 2016 – Policies, Standards, and Guidelines for Doctor of Medicine (M.D.) Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO18.pdf'],
            ['title' => 'CMO No. 19, Series of 2016 – Benefits and Responsibilities of Autonomous and Deregulated Private HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO19.pdf'],
            ['title' => 'CMO No. 20, Series of 2016 – Private HEIs Granted Autonomous and Deregulated Status', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO20.pdf'],
            ['title' => 'CMO No. 21, Series of 2016 – Guidelines for CHED Support for Grants-In-Aid to Students in International Conferences', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO21.pdf'],
            ['title' => 'CMO No. 22, Series of 2016 – Guidelines for Foreign Scholarships for Graduate Studies (K to 12)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO22.pdf'],
            ['title' => 'CMO No. 25, Series of 2016 – Guidelines for Professional Advancement and Postdoctoral Study Grants (K to 12)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO25.pdf'],
            ['title' => 'CMO No. 30, Series of 2016 – Implementing Guidelines for Scholarship Grant Program for Sugarcane Industry Workers', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO30.pdf'],
            ['title' => 'CMO No. 33, Series of 2016 – Guidelines for Institutional Development and Innovation Grants Under K to 12', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO33.pdf'],
            ['title' => 'CMO No. 34, Series of 2016 – Selective Crediting of SHS Subjects to College for SHS Graduates', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO34.pdf'],
            ['title' => 'CMO No. 35, Series of 2016 – Guidelines for Operation of SHS in SUCs and LUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO35.pdf'],
            ['title' => 'CMO No. 41, Series of 2016 – PSG Governing Sale, Merger or Consolidation of Private HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO41.pdf'],
            ['title' => 'CMO No. 47, Series of 2016 – Strengthening Protection of Religious Rights of Students in HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO47.pdf'],
            ['title' => 'CMO No. 50, Series of 2016 – Implementing Guidelines for Faculty Training for New GE Core Courses', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO50.pdf'],
            ['title' => 'CMO No. 52, Series of 2016 – Pathways to Equity, Relevance and Advancement in Research, Innovation, and Extension', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO52.pdf'],
            ['title' => 'CMO No. 53, Series of 2016 – Guidelines for CHED Journal Incentive Program (JIP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO53.pdf'],
            ['title' => 'CMO No. 54, Series of 2016 – Revised PSG for Implementation of ETEEAP for Undergraduate Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO54.pdf'],
            ['title' => 'CMO No. 55, Series of 2016 – Policy Framework and Strategies on Internationalization of Philippine Higher Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO55.pdf'],
            ['title' => 'CMO No. 56, Series of 2016 – New Procedures in Processing Applications for Government Authority to Operate Engineering Degrees', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO56.pdf'],
            ['title' => 'CMO No. 58, Series of 2016 – Guidelines for Expanded Students\' Grants-In-Aid Program for Poverty Alleviation (ESGP-PA)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO58.pdf'],
            ['title' => 'CMO No. 62, Series of 2016 – Policies, Standards and Guidelines (PSGs) for Transnational Education (TNE) Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2016-CMO-NO62.pdf'],
        ];

        // CHED 2017 Links (25+ CMOs - proper sequence 1-35)
        // CHED 2017 Links (Updated sequence 1-80+)
        $chedLinks2017 = [
            ['title' => 'CHED-DBM JMC No. 2017-1 – Guidelines on Grant of Free Tuition in SUCs for FY 2017', 'url' => 'https://ched.gov.ph/wp-content/uploads/CHED-DBM-JMC-No.-2017-1.pdf'],
            ['title' => 'CMO No. 2, Series of 2017 – Amendment to CMO No. 4, s. 2016 (Guidelines on Graduate Education Delivery for Faculty and Staff Development in the K to 12 Transition Period)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, Series of 2017 – Guidelines on Start-up Grant for Foreign Studies and Scholarships for Graduate Studies Abroad (K to 12)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, Series of 2017 – Amendment to CMO No. 3, s. 2016 (Scholarships for Graduate Studies - K to 12)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2017 – Suspension of the National Veterinary Admission Test (NVAT) Effective AY 2017-2018', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO5.pdf'],
            ['title' => 'CMO No. 6, Series of 2017 – Amendment to CMO No. 18, s. 2015 (CHED Research Chair Award)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO6.pdf'],
            ['title' => 'CMO No. 7, Series of 2017 – Guidelines for Implementation of CHED-British Council Joint Development of Niche Programmes Thru Philippine-United Kingdom Linkages Project', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO7.pdf'],
            ['title' => 'CMO No. 8, Series of 2017 – Implementing Guidelines for Faculty Training for New GE Core Courses (Second-Generation)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO8.pdf'],
            ['title' => 'CMO No. 9, Series of 2017 – Addendum to CMO No. 61, s. 2016 (CHED Engineering Faculty Training on Technopreneurship)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO9.pdf'],
            ['title' => 'CMO No. 10, Series of 2017 – Policy on Students Affected by K to 12 Program and New General Curriculum', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, Series of 2017 – Policy on Temporary Suspension of Processing Government Authorization for Graduate Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO11.pdf'],
            ['title' => 'CMO No. 12, Series of 2017 – Updated Guidelines for IDIG Under K to 12 Transition Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO12.pdf'],
            ['title' => 'CMO No. 13, Series of 2017 – PSG for BS Medical Technology/Medical Laboratory Science (BSMT/BSMLS)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO13.pdf'],
            ['title' => 'CMO No. 14, Series of 2017 – PSG for Bachelor of Science in Nursing (BSN)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO14.pdf'],
            ['title' => 'CMO No. 15, Series of 2017 – Policies, Standards, and Guidelines for Bachelor of Science in Nursing Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO15.pdf'],
            ['title' => 'CMO No. 17, Series of 2017 – Revised PSG for Bachelor of Science in Business Administration', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO17.pdf'],
            ['title' => 'CMO No. 18, Series of 2017 – Revised PSG for Bachelor of Science in Entrepreneurship', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO18.pdf'],
            ['title' => 'CMO No. 19, Series of 2017 – PSG for Business Administration, Entrepreneurship, and Office Administration (Bridging Programs)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO19.pdf'],
            ['title' => 'CMO No. 20, Series of 2017 – PSG for Bachelor of Multimedia Arts (BMMA)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO20.pdf'],
            ['title' => 'CMO No. 21, Series of 2017 – PSG for Bachelor of Arts in Literature (AB Literature)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO21.pdf'],
            ['title' => 'CMO No. 24, Series of 2017 – PSG for Bachelor of Arts in English Language (AB English Language)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO24.pdf'],
            ['title' => 'CMO No. 27, Series of 2017 – Revised PSG for Bachelor of Science in Accountancy (BSA)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO27.pdf'],
            ['title' => 'CMO No. 28, Series of 2017 – Revised PSG for Bachelor of Science in Management Accounting (BSMA)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO28.pdf'],
            ['title' => 'CMO No. 30, Series of 2017 – Policies, Standards and Guidelines (PSGs) for the Bachelor of Science in Accounting Information Systems (BSAIS)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO30.pdf'],
            ['title' => 'CMO No. 34, Series of 2017 – Policies and Standards for Undergraduate Programs in Psychology', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO34.pdf'],
            ['title' => 'CMO No. 35, Series of 2017 – Revised PSG for Bachelor of Arts in Communication (BA Comm) Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO35.pdf'],
            ['title' => 'CMO No. 36, Series of 2017 – Revised PSG for Bachelor of Science in Development Communication (BS DevCom)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO36.pdf'],
            ['title' => 'CMO No. 38, Series of 2017 – PSG for Bachelor of Arts in History (BA History)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO38.pdf'],
            ['title' => 'CMO No. 40, Series of 2017 – PSG for Bachelor of Arts in Sociology (BA Sociology)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO40.pdf'],
            ['title' => 'CMO No. 49, Series of 2017 – PSG for Bachelor of Science in Biology (BS Biology)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO49.pdf'],
            ['title' => 'CMO No. 50, Series of 2017 – First Batch of CHED-JIP Recognized Journals for 2017-2019', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO50.pdf'],
            ['title' => 'CMO No. 57, Series of 2017 – Policy on Offering Filipino Subjects in All HE Programs (New GE Curriculum)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO57.pdf'],
            ['title' => 'CMO No. 61, Series of 2017 – PSG for Bachelor of Science in Architecture (BS Arch)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO61.pdf'],
            ['title' => 'CMO No. 62, Series of 2017 – Policies, Standards and Guidelines for Bachelor of Science in Tourism Management (BSTM)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO62.pdf'],
            ['title' => 'CMO No. 62, Series of 2017 – Policies, Standards and Guidelines for Bachelor of Science in Hospitality Management (BSHM)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO62.pdf'],
            ['title' => 'CMO No. 63, Series of 2017 – Policies and Guidelines for Local Off-Campus Activities', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO63.pdf'],
            ['title' => 'CMO No. 66, Series of 2017 – Second Batch of CHED-JIP Recognized Journals for 2017-2019', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO66.pdf'],
            ['title' => 'CMO No. 67, Series of 2017 – Revised PSG for BS Marine Transportation and BS Marine Engineering Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO67.pdf'],
            ['title' => 'CMO No. 74, Series of 2017 – PSG for Bachelor of Elementary Education (BEEd)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO74.pdf'],
            ['title' => 'CMO No. 75, Series of 2017 – Revised PSG for Bachelor of Secondary Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO75.pdf'],
            ['title' => 'CMO No. 76, Series of 2017 – PSG for Bachelor of Early Childhood Education (BECEd)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO76.pdf'],
            ['title' => 'CMO No. 77, Series of 2017 – Revised PSG for Bachelor of Special Needs Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO77.pdf'],
            ['title' => 'CMO No. 78, Series of 2017 – PSG for Bachelor of Technology and Livelihood Education (BTLEd)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO78.pdf'],
            ['title' => 'CMO No. 79, Series of 2017 – PSG for Bachelor of Technical-Vocational Teacher Education (BTVTEd)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO79.pdf'],
            ['title' => 'CMO No. 80, Series of 2017 – PSG for Bachelor of Physical Education (BPEd)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO80.pdf'],
            ['title' => 'CMO No. 87, Series of 2017 – Policies, Standards and Guidelines for the Bachelor of Science in Computer Engineering (BSCpE) Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO87.pdf'],
            ['title' => 'CMO No. 105, Series of 2017 – Policy on Admission of Senior High School Graduates to HEIs (AY 2018-2019)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2017-CMO-NO105.pdf'],
        ];

        // CHED 2018 Links (12+ CMOs - proper sequence 1-35)
        $chedLinks2018 = [
            ['title' => 'CMO No. 2, Series of 2018 – Delegation to CHEDROs of Processing Applications for Accreditation of Health Facilities', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2018-CMO-NO2.pdf'],
            ['title' => 'CMO No. 4, Series of 2018 – Policy on Offering Filipino and Panitikan Subjects in All HE Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2018-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2018 – PSG for Bachelor of Science in Criminology', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2018-CMO-NO5.pdf'],
            ['title' => 'CMO No. 6, Series of 2018 – PSG for Bachelor of Science in Industrial Security Management (BSISM)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2018-CMO-NO6.pdf'],
            ['title' => 'CMO No. 7, Series of 2018 – PSG for Bachelor of Science in Radiologic Technology', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2018-CMO-NO7.pdf'],
            ['title' => 'CMO No. 8, Series of 2018 – Submission of New or Revised Curricula of HEIs for AY 2018-2019', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2018-CMO-NO8.pdf'],
            ['title' => 'CMO No. 9, Series of 2018 – Guidelines on Eligibility of LUCs for Free Higher Education (RA 10931)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2018-CMO-NO9.pdf'],
            ['title' => 'CMO No. 12, Series of 2018 – Overview of 2016 SUCs Levelling Results and Appeal Procedures', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2018-CMO-NO12.pdf'],
            ['title' => 'CMO No. 15, Series of 2018 – PSG for Doctor of Optometry Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2018-CMO-NO15.pdf'],
            ['title' => 'CMO No. 17, Series of 2018 – Call for Applications for Scholarships for Transnational Education Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2018-CMO-NO17.pdf'],
            ['title' => 'CMO No. 18, Series of 2018 – Guidelines on Drug Testing in Higher Education Institutions', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2018-CMO-NO18.pdf'],
        ];

        // CHED 2019 Links (13+ CMOs - proper sequence 1-35)
        $chedLinks2019 = [
            ['title' => 'CMO No. 1, Series of 2019 – Integration of Peace Studies/Education Into Relevant HE Curricula', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2019-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2019 – Integration of Indigenous Peoples\' (IP) Studies/Education Into Relevant HE Curricula', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2019-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, Series of 2019 – Extension of Centers of Excellence and Centers of Development for Various Disciplines', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2019-CMO-NO3.pdf'],
            ['title' => 'CHED-DBM JMC No. 04, s. 2019 – Revised Implementing Guidelines of CHED-Tulong Dunong Program (CHED-TDP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CHED-DBM-JMC-No.-04-s.-2019.pdf'],
            ['title' => 'CMO No. 7, Series of 2019 – PSG for Bachelor of Science in Food Technology', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2019-CMO-NO7.pdf'],
            ['title' => 'CMO No. 8, Series of 2019 – Policies and Guidelines for CHED Scholarship Programs (CSPs)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2019-CMO-NO8.pdf'],
            ['title' => 'CMO No. 9, Series of 2019 – SUC Level of 106 State Universities and Colleges', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2019-CMO-NO9.pdf'],
            ['title' => 'CMO No. 10, Series of 2019 – Amendments to CMO 08, s. 2019 (CHED Scholarship Programs)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2019-CMO-NO10.pdf'],
            ['title' => 'CMO No. 12, Series of 2019 – Grant of Autonomous and Deregulated Status to 68 Private HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2019-CMO-NO12.pdf'],
            ['title' => 'CMO No. 13, Series of 2019 – Guidelines for CHED-Initiated Projects under IDIG for SUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2019-CMO-NO13.pdf'],
            ['title' => 'CMO No. 15, Series of 2019 – Policies, Standards, and Guidelines for Graduate Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2019-CMO-NO15.pdf'],
        ];

        // CHED 2020 Links
        $chedLinks2020 = [
            ['title' => 'CMO No. 1, Series of 2020 – Guidelines for the Grant of Assistance to State Universities and Colleges to Combat COVID-19', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2020 – Amendment to Sections III, IV, V, VI, VII and VIII of CMO No. 30, Series of 2016 (SIDA-SGP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, Series of 2020 – Amendments to the Revised and Expanded Guidelines for the Continuing Professional Education Grants', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, Series of 2020 – Guidelines on the Implementation of Flexible Learning', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2020 – Guidelines on the Suspension of Operations of Degree Programs of Private Higher Education Institutions', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO5.pdf'],
            ['title' => 'CMO No. 6, Series of 2020 – Guidelines for the Scholarships for Instructors Knowledge Advancement Program (SIKAP) Grant', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO6.pdf'],
            ['title' => 'CMO No. 8, Series of 2020 – Guidelines for the Support and Development of Discipline-Based Higher Education Roadmaps', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO8.pdf'],
            ['title' => 'CMO No. 9, Series of 2020 – Guidelines on the Allocation of Financial Assistance for SUCs for Smart Campuses (RA 11494)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO9.pdf'],
            ['title' => 'CMO No. 10, Series of 2020 – Implementing Guidelines for Bayanihan 2 for Higher Education Tulong Program (B2HELP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, Series of 2020 – Implementing Rules and Regulations of RA 11396 (SUC Dormitories and Housing)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO11.pdf'],
            ['title' => 'CMO No. 12, Series of 2020 – Short-Term Scholarship Grants during the K to 12 Transition Period', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO12.pdf'],
            ['title' => 'CMO No. 13, Series of 2020 – Interim Policy on Documentary Submissions for SGS-L during COVID-19 Pandemic', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2020-CMO-NO13.pdf'],
        ];

        // CHED 2021 Links
        $chedLinks2021 = [
            ['title' => 'CMO No. 1, Series of 2021 – Amendment to Section V D-1(f) of CMO No. 10, Series of 2020 (B2HELP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2021 – Guidelines on the Grant of Certificate of Program Compliance (COPC) to SUCs and LUCs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, Series of 2021 – Guidelines on the Implementation of Flexible Learning in Higher Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, Series of 2021 – Revised Guidelines on the Student Internship Program in the Philippines (SIPP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2021 – Policies, Standards and Guidelines for the Bachelor of Science in Accountancy (BSA) Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO5.pdf'],
            ['title' => 'CMO No. 7, Series of 2021 – Extension of Validity Period of Autonomous and Deregulated Status to Private HEIs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO7.pdf'],
            ['title' => 'CMO No. 8, Series of 2021 – Guidelines on the Implementation of the CHED Scholarship Program (CSP) for AY 2021-2022', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO8.pdf'],
            ['title' => 'CMO No. 10, Series of 2021 – List of Priority Programs for CHED Scholarship Programs (CSPs) for AY 2021-2022', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, Series of 2021 – Amendments to Sections 6 and 12 of CMO No. 8, Series of 2019 (CSP Policies)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO11.pdf'],
            ['title' => 'CMO No. 12, Series of 2021 – Guidelines for the Conduct of Clinical Education for Radiologic Technology Students', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO12.pdf'],
            ['title' => 'CMO No. 15, Series of 2021 – Guidelines for the Support and Development of Medical Schools – Seed Fund for Medicine', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO15.pdf'],
            ['title' => 'CMO No. 16, Series of 2021 – Revised Guidelines for Full-Time SIKAP Grant Scholars', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO16.pdf'],
            ['title' => 'CMO No. 17, Series of 2021 – Revised Guidelines for CHED-Initiated Projects under IDIG Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2021-CMO-NO17.pdf'],
        ];

        // CHED 2022 Links
        $chedLinks2022 = [
            ['title' => 'CMO No. 1, Series of 2022 – Supplemental Guidelines to CHED-DOH JMC No. 2021-004 on Limited Face-to-Face Classes', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2022-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, Series of 2022 – Additional Universities Granted with Autonomous and Deregulated Status', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2022-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, Series of 2022 – Updated Guidelines on the Implementation of Flexible Learning in Higher Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2022-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, Series of 2022 – Safety Seal Certification Program for Higher Education Institutions', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2022-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2022 – Amendment to Article IV.H. of CHED-DOH JMC No. 2021-004 and Article III.B., Item 12 of CMO No. 01, S. 2022', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2022-CMO-NO5.pdf'],
            ['title' => 'CMO No. 6, Series of 2022 – Policies, Standards and Guidelines for the BS Tourism Management and BS Hospitality Management Programs', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2022-CMO-NO6.pdf'],
            ['title' => 'CMO No. 7, Series of 2022 – Policies, Standards and Guidelines for the Bachelor of Science in Architecture (BS Arch) Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2022-CMO-NO7.pdf'],
            ['title' => 'CMO No. 8, Series of 2022 – Policies, Standards and Guidelines for the Bachelor of Science in Customs Administration (BSCA) Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2022-CMO-NO8.pdf'],
            ['title' => 'CMO No. 9, Series of 2022 – Revised Policies and Guidelines on Local Off-Campus Activities', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2022-CMO-NO9.pdf'],
            ['title' => 'CMO No. 10, Series of 2022 – Guidelines on the Implementation of the CHED Scholarship Program (CSP) for AY 2022-2023', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2022-CMO-NO10.pdf'],
        ];

        // CHED 2023 Links
        $chedLinks2023 = [
            ['title' => 'CMO No. 1, Series of 2023 – Amendment to Article IV.E of CMO No. 09, S. 2022 on Local Off-Campus Activities', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO1.pdf'],
            ['title' => 'CMO No. 3, Series of 2023 – Policies, Standards, and Guidelines for the Bachelor of Science in Midwifery Program (BSM)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, Series of 2023 – Updated Guidelines on Onsite Learning in Higher Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, Series of 2023 – Revised Procedures in the Processing of Applications for Government Authority to Operate Undergraduate and Graduate Degrees in Engineering', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO5.pdf'],
            ['title' => 'CMO No. 6, Series of 2023 – Policies and Guidelines for the Grant of Autonomous  and Deregulated Status to Private Higher Education Institutions', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO6.pdf'],
            ['title' => 'CMO No. 7, Series of 2023 – List of Identified Priority Programs for CHED Merit Scholarship Program (CMSP) for Academic Years (AY) 2023-2024 to 2027-2028', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO7.pdf'],
            ['title' => 'CMO No. 8, Series of 2023 – Guidelines on the Student Monetary Assistance for Recovery and Transition (SMART) Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO8.pdf'],
            ['title' => 'CMO No. 9, Series of 2023 – Revised Policies and Guidelines on the Issuance of Certificate of Program  Compliance (COPC) to State Universities and Colleges (SUCs) and Local Universities and Colleges (LUCs)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO9.pdf'],
            ['title' => 'CMO No. 10, Series of 2023 – Enhanced Policies, Standards and Guidelines (PSGs) on Student Internship Abroad Program (SIAP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, Series of 2023 – Accelerated Pathway for Medicine (APMed) Program: A Pilot Implementation for Development of Future-Ready Physicians', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO11.pdf'],
            ['title' => 'CMO No. 12, Series of 2023 – Supplemental Policies and Guidelines for the Grant of Autonomous and Deregulated Status to Private Higher Education Institutions', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO12.pdf'],
            ['title' => 'CMO No. 13, Series of 2023 – Policies, Standards, and Guidelines for the Bachelor of Industrial Technology (BIndTech) Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO13.pdf'],
            ['title' => 'CMO No. 14, Series of 2023 – Amended CHED Memorandum Order (CMO) No. 8, Series of 2023 Entitled "Guidelines on the Student Monetary Assistance for Recovery and Transition (SMART) Program"', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO14.pdf'],
            ['title' => 'CMO No. 15, Series of 2023 – Guidelines and Policies of Continuing Professional Development Studies Grant (CPDSG)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO15.pdf'],
            ['title' => 'CMO No. 16, Series of 2023 – Amendment to CMO No. 15, Series of 2021 Entitled "Guidelines for the Support and Development of Medical Schools – Seed Fund for Medicine (Programang Punla sa Medisina)"', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO16.pdf'],
            ['title' => 'CMO No. 17, Series of 2023 – Operational Guidelines on the Implementation of the Scholarship Program for Coconut Farmers and their Families (CoScho) for Participating Higher Education Institutions', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2023-CMO-NO17.pdf'],
        ];

        // CHED 2024 Links
        $chedLinks2024 = [
            ['title' => 'CMO No 1, series of 2024 – Policies, Standards, and Guidelines for BS Public Health Major in Population Track and BS Public Health Major in Clinical Track Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2024-CMO-NO1.pdf'],
            ['title' => 'CMO No 2, series of 2024 – Policies and Guidelines in the Nursing Review Program for the Clinical Care Associates (CCAs) per DOH-CHED Joint Administrative Order No. 2023-0001', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2024-CMO-NO2.pdf'],
            ['title' => 'CMO No 3, series of 2024 – Policies, Standards and Guidelines (PSG) for the Bachelor of Science in Meteorology (BS Met)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2024-CMO-NO3.pdf'],
            ['title' => 'CMO No 4, series of 2024 – Amendments to the Specific Provisions of CMO No. 10, series of 2022 Entitled "Implementing Guidelines for CHED Scholarship for Future Statisticians (ESTATISKOLAR)"', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2024-CMO-NO4.pdf'],
            ['title' => 'CMO No 5, series of 2024 – Policies, Standards, and Guidelines (PSG) for Master in Nursing Education (MNE)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2024-CMO-NO5.pdf'],
            ['title' => 'CMO No 7, series of 2024 – Grant of Autonomous and Deregulated Status by Evaluation to Private Higher Education Institutions', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2024-CMO-NO7.pdf'],
            ['title' => 'CMO No 8, series of 2024 – Policies, Standards and Guidelines for Graduate Programs in Women and Gender Studies: Master of Arts in Women and Gender Studies (Academic Track) and Master in Women and Gender Studies ( Professional Track)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2024-CMO-NO8.pdf'],
            ['title' => 'CMO NO. 9, series of 2024 – Amendment to CMO No. 11, Series of 2022 Entitled "Guidelines for the Support and Development of Higher Education Institutions (HEIs) Offering Tourism Management and Hospitality Management (HM) Programs through the Sustainable Tourism Education Program – Upgrading Project (STEP-UP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2024-CMO-NO9.pdf'],
            ['title' => 'CMO NO. 10, Series of 2024 – Implementing Guidelines of Section 25 of CMO NOs. 74, 75, 76, 77, 78, 79, 80 and 82, Series of 2017', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2024-CMO-NO10.pdf'],
            ['title' => 'CMO NO. 11, series of 2024 – Implementing Guidelines of the Scholarship Program for Future Medical Technologists and Pharmacists (MTP-SP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2024-CMO-NO11.pdf'],
            ['title' => 'CMO NO. 13, series of 2024 – Policies, Standards and Guidelines (PSG) for the Bachelor of Science in Physics (BS Physics) and Bachelor of Science in Applied Physics (BS Applied Physics) Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2024-CMO-NO13.pdf'],
        ];

        // CHED 2025 Links
        $chedLinks2025 = [
            ['title' => 'CMO No. 1, series of 2025 – Guidelines for Micro-Credential Development, Approval, and Recognition in Higher Education', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO1.pdf'],
            ['title' => 'CMO No. 2, series of 2025 – Updated List of Private Higher Education Institutions Granted Autonomous and Deregulated Status by Evaluation', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO2.pdf'],
            ['title' => 'CMO No. 3, series of 2025 – Updated Guidelines for Securing Authority to Travel Abroad for State Universities and Colleges (SUCs)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO3.pdf'],
            ['title' => 'CMO No. 4, series of 2025 – Revised Policies, Standards and Guidelines for Associate in Radiologictechnology Education (ART) Program', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO4.pdf'],
            ['title' => 'CMO No. 5, series of 2025 – Guidelines for the Accreditation of Hospitals and Primary Health Care Facilities for the Clinical Practice of Radiologic/X-RAY Technology Interns', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO5.pdf'],
            ['title' => 'CMO No. 6, series of 2025 – Application Process for Authority to Offer Transnational Higher Education Pursuant to Republic Act No. 11448 or The Transnational Higher Education Act', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO6.pdf'],
            ['title' => 'CMO No. 7, series of 2025 – Policies, Standards and Guidelines for the Implementation of the National Merchant Marine Aptitude Test (NaMMAT)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO7.pdf'],
            ['title' => 'CMO No. 9, series of 2025 – Updated Guidelines for the Scholarships for Staff and Instructors\' Knowledge Advancement Program (SIKAP) for Full-Time and Part-Time Study', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO9.pdf'],
            ['title' => 'CMO No. 10, series of 2025 – Policies and Standards on Centers of Excellence (COE) | Annex A', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO10.pdf'],
            ['title' => 'CMO No. 11, series of 2025 – Implementing Rules and Regulations of Republic Act No. 12124, "An Act Institutionalizing the Expanded Tertiary Education Equivalency and Accreditation Program (ETEEAP) and Providing Funds Therefor"', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO11.pdf'],
            ['title' => 'CMO No. 12, series of 2025 – Policies and Guidelines on Open Distance and e-Learning (ODeL)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO12.pdf'],
            ['title' => 'CMO No. 13, series of 2025 – Revised Policies and Guidelines for the CHED Merit Scholarship Program (CMSP)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO13.pdf'],
            ['title' => 'CMO No. 14, series of 2025 – Revised Implementing Guidelines for the CHED Scholarship Program for Future Statisticians (ESTATISKOLAR)', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO14.pdf'],
            ['title' => 'CMO No. 15, series of 2025 – Updated Policies and Guidelines for the Grant of Autonomous and Deregulated Status to Private Higher Education Institutions', 'url' => 'https://cms-cdn.e.gov.ph/CHED/pdf/2025-CMO-NO15.pdf'],
        ];

        // DepEd Curriculum Guides (Academic)
        $depedAcademicLinks = [
            // ARTS, SOCIAL SCIENCE, AND HUMANITIES
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Arts 1 (Creative Industries - Visual Art, Literary Art, Media Art, Applied Art, and Traditional Art)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Arts-1.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Arts 2 (Creative Industries - Music, Dance, and Theater)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Arts-2.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Citizenship and Civic Engagement', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Citizenship-and-Civic-Engagement.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Contemporary Literature 1', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Contemporary-Literature-1.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Contemporary Literature 2', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Contemporary-Literature-2.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Creative Composition 1', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Creative-Composition-1.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Creative Composition 2', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Creative-Composition-2.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Filipino 1 (Wika at Komunikasyon sa Akademikong Filipino)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Filipino-1.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Filipino 2 (Filipino para sa Larang Teknikal-Propesyonal)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Filipino-2-Teknikal-Propesyonal.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Filipino 2 (Filipino sa Isports)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Filipino-2-Isports.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Filipino 2 (Filipino sa Sining at Disenyo)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Filipino-2-Sining-at-Disenyo.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Filipino Identity Through the Arts', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Filipino-Identity-Through-the-Arts.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Introduction to Philosophy', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Introduction-to-Philosophy.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Leadership Management in the Arts', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Leadership-Management-in-the-Arts.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Malikhaing Pagsulat', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Malikhaing-Pagsulat.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Philippine Governance (Philippine Politics and Governance)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Philippine-Governance.pdf'],
            ['group' => 'ARTS, SOCIAL SCIENCE, AND HUMANITIES', 'title' => 'Social Sciences (Theory and Practice)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Social-Sciences.pdf'],

            // BUSINESS AND ENTREPRENEURSHIP
            ['group' => 'BUSINESS AND ENTREPRENEURSHIP', 'title' => 'Business 1 (Basic Accounting)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Business-1.pdf'],
            ['group' => 'BUSINESS AND ENTREPRENEURSHIP', 'title' => 'Business 2 (Business Finance and Income Taxation)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Business-2.pdf'],
            ['group' => 'BUSINESS AND ENTREPRENEURSHIP', 'title' => 'Business 3 (Business Economics)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Business-3.pdf'],
            ['group' => 'BUSINESS AND ENTREPRENEURSHIP', 'title' => 'Contemporary Marketing', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Contemporary-Marketing.pdf'],
            ['group' => 'BUSINESS AND ENTREPRENEURSHIP', 'title' => 'Entrepreneurship', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Entrepreneurship.pdf'],
            ['group' => 'BUSINESS AND ENTREPRENEURSHIP', 'title' => 'Introduction to Organization and Management', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Introduction-to-Organization-and-Management.pdf'],

            // SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Biology 1', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Biology-1.pdf'],
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Biology 2', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Biology-2.pdf'],
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Chemistry 1', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Chemistry-1.pdf'],
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Chemistry 2', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Chemistry-2.pdf'],
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Earth and Space Science 1', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Earth-and-Space-Science-1.pdf'],
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Earth and Space Science 2', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Earth-and-Space-Science-2.pdf'],
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Finite Mathematics 1', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Finite-Mathematics-1.pdf'],
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Finite Mathematics 2', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Finite-Mathematics-2.pdf'],
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Physics 1', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Physics-1.pdf'],
            ['group' => 'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS', 'title' => 'Physics 2', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Physics-2.pdf'],

            // SPORTS, HEALTH, AND WELLNESS
            ['group' => 'SPORTS, HEALTH, AND WELLNESS', 'title' => 'Human Movement 1 (Basic Anatomy in Sports and Exercise)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Human-Movement-1.pdf'],
            ['group' => 'SPORTS, HEALTH, AND WELLNESS', 'title' => 'Human Movement 2 (Motor Skills Development)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Human-Movement-2.pdf'],
            ['group' => 'SPORTS, HEALTH, AND WELLNESS', 'title' => 'Physical Education 1 (Fitness and Recreation)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Physical-Education-1.pdf'],
            ['group' => 'SPORTS, HEALTH, AND WELLNESS', 'title' => 'Physical Education 2 (Sports and Dance)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Physical-Education-2.pdf'],
            ['group' => 'SPORTS, HEALTH, AND WELLNESS', 'title' => 'Sports Activity Management', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Sports-Activity-Management.pdf'],
            ['group' => 'SPORTS, HEALTH, AND WELLNESS', 'title' => 'Sports Coaching', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Sports-Coaching.pdf'],
            ['group' => 'SPORTS, HEALTH, AND WELLNESS', 'title' => 'Sports Officiating', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Sports-Officiating.pdf'],
        ];

        // DepEd Curriculum Guides (TechPro)
        $depedTechProLinks = [
            // AESTHETIC, WELLNESS, AND HUMAN CARE
            ['group' => 'AESTHETIC, WELLNESS, AND HUMAN CARE', 'title' => 'Aesthetic Services (Beauty Care)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Aesthetic-Services-Beauty-Care.pdf'],
            ['group' => 'AESTHETIC, WELLNESS, AND HUMAN CARE', 'title' => 'Caregiving (Adult Care)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Caregiving-Adult-Care.pdf'],
            ['group' => 'AESTHETIC, WELLNESS, AND HUMAN CARE', 'title' => 'Caregiving (Child Care)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Caregiving-Child-Care.pdf'],
            ['group' => 'AESTHETIC, WELLNESS, AND HUMAN CARE', 'title' => 'Hairdressing', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Hairdressing.pdf'],

            // AGRI-FISHERY BUSINESS AND FOOD INNOVATION
            ['group' => 'AGRI-FISHERY BUSINESS AND FOOD INNOVATION', 'title' => 'Agricultural Crops Production', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Agricultural-Crops-Production.pdf'],
            ['group' => 'AGRI-FISHERY BUSINESS AND FOOD INNOVATION', 'title' => 'Agro-Entrepreneurship', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Agro-Entrepreneurship.pdf'],
            ['group' => 'AGRI-FISHERY BUSINESS AND FOOD INNOVATION', 'title' => 'Aquaculture', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Aquaculture.pdf'],
            ['group' => 'AGRI-FISHERY BUSINESS AND FOOD INNOVATION', 'title' => 'Fish Capture', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Fish-Capture.pdf'],
            ['group' => 'AGRI-FISHERY BUSINESS AND FOOD INNOVATION', 'title' => 'Food Processing', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Food-Processing.pdf'],
            ['group' => 'AGRI-FISHERY BUSINESS AND FOOD INNOVATION', 'title' => 'Organic Agriculture Production', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Organic-Agriculture-Production.pdf'],
            ['group' => 'AGRI-FISHERY BUSINESS AND FOOD INNOVATION', 'title' => 'Poultry Production (Chicken)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Poultry-Production-Chicken.pdf'],
            ['group' => 'AGRI-FISHERY BUSINESS AND FOOD INNOVATION', 'title' => 'Ruminants Production', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Ruminants-Production.pdf'],
            ['group' => 'AGRI-FISHERY BUSINESS AND FOOD INNOVATION', 'title' => 'Swine Production', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Swine-Production.pdf'],

            // ARTISANRY AND CREATIVE ENTERPRISE
            ['group' => 'ARTISANRY AND CREATIVE ENTERPRISE', 'title' => 'Garments Artisanry', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Garments-Artisanry.pdf'],
            ['group' => 'ARTISANRY AND CREATIVE ENTERPRISE', 'title' => 'Handicrafts (Weaving)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Handicrafts-Weaving.pdf'],

            // AUTOMOTIVE AND SMALL ENGINE TECHNOLOGIES
            ['group' => 'AUTOMOTIVE AND SMALL ENGINE TECHNOLOGIES', 'title' => 'Automotive Servicing (Electrical Repair)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Automotive-Servicing-Electrical-Repair.pdf'],
            ['group' => 'AUTOMOTIVE AND SMALL ENGINE TECHNOLOGIES', 'title' => 'Automotive Servicing (Engine and Chassis Repairs)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Automotive-Servicing-Engine-and-Chassis-Repairs.pdf'],
            ['group' => 'AUTOMOTIVE AND SMALL ENGINE TECHNOLOGIES', 'title' => 'Driving and Automotive Servicing', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Driving-and-Automotive-Servicing.pdf'],
            ['group' => 'AUTOMOTIVE AND SMALL ENGINE TECHNOLOGIES', 'title' => 'Motorcycle and Small Engine Servicing', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Motorcycle-and-Small-Engine-Servicing.pdf'],

            // CONSTRUCTION AND BUILDING TECHNOLOGY
            ['group' => 'CONSTRUCTION AND BUILDING TECHNOLOGY', 'title' => 'Carpentry', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Carpentry.pdf'],
            ['group' => 'CONSTRUCTION AND BUILDING TECHNOLOGY', 'title' => 'Construction Operation', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Construction-Operation.pdf'],
            ['group' => 'CONSTRUCTION AND BUILDING TECHNOLOGY', 'title' => 'Manual Metal Arc Welding', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Manual-Metal-Arc-Welding.pdf'],
            ['group' => 'CONSTRUCTION AND BUILDING TECHNOLOGY', 'title' => 'Technical Drafting', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Technical-Drafting.pdf'],

            // CREATIVE ARTS AND DESIGN TECHNOLOGY
            ['group' => 'CREATIVE ARTS AND DESIGN TECHNOLOGY', 'title' => 'Animation', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Animation.pdf'],
            ['group' => 'CREATIVE ARTS AND DESIGN TECHNOLOGY', 'title' => 'Illustration', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Illustration.pdf'],
            ['group' => 'CREATIVE ARTS AND DESIGN TECHNOLOGY', 'title' => 'Visual Graphic Design', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Visual-Graphic-Design.pdf'],

            // HOSPITALITY AND TOURISM
            ['group' => 'HOSPITALITY AND TOURISM', 'title' => 'Bakery Operations', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Bakery-Operations.pdf'],
            ['group' => 'HOSPITALITY AND TOURISM', 'title' => 'Events Management Services', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Events-Management-Services.pdf'],
            ['group' => 'HOSPITALITY AND TOURISM', 'title' => 'Food and Beverage Operation', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Food-and-Beverage-Operation.pdf'],
            ['group' => 'HOSPITALITY AND TOURISM', 'title' => 'Hotel Operation (Front Office Services)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Hotel-Operation-Front-Office-Services.pdf'],
            ['group' => 'HOSPITALITY AND TOURISM', 'title' => 'Hotel Operation (Housekeeping Services)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Hotel-Operation-Housekeeping-Services.pdf'],
            ['group' => 'HOSPITALITY AND TOURISM', 'title' => 'Kitchen Operations', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Kitchen-Operations.pdf'],
            ['group' => 'HOSPITALITY AND TOURISM', 'title' => 'Tourism Services', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Tourism-Services.pdf'],

            // ICT SUPPORT AND COMPUTER PROGRAMMING TECHNOLOGIES
            ['group' => 'ICT SUPPORT AND COMPUTER PROGRAMMING TECHNOLOGIES', 'title' => 'Broadband Installation', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Broadband-Installation.pdf'],
            ['group' => 'ICT SUPPORT AND COMPUTER PROGRAMMING TECHNOLOGIES', 'title' => 'Computer Programming (.NET Technology)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Computer-Programming-NET-Technology.pdf'],
            ['group' => 'ICT SUPPORT AND COMPUTER PROGRAMMING TECHNOLOGIES', 'title' => 'Computer Programming (Java)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Computer-Programming-Java.pdf'],
            ['group' => 'ICT SUPPORT AND COMPUTER PROGRAMMING TECHNOLOGIES', 'title' => 'Computer Programming (Oracle Database)', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Computer-Programming-Oracle-Database.pdf'],
            ['group' => 'ICT SUPPORT AND COMPUTER PROGRAMMING TECHNOLOGIES', 'title' => 'Computer Systems Servicing', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Computer-Systems-Servicing.pdf'],
            ['group' => 'ICT SUPPORT AND COMPUTER PROGRAMMING TECHNOLOGIES', 'title' => 'Contact Center Services', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Contact-Center-Services.pdf'],

            // INDUSTRIAL TECHNOLOGIES
            ['group' => 'INDUSTRIAL TECHNOLOGIES', 'title' => 'Commercial Air-Conditioning Installation and Servicing', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Commercial-Air-Conditioning-Installation-and-Servicing.pdf'],
            ['group' => 'INDUSTRIAL TECHNOLOGIES', 'title' => 'Domestic Refrigeration and Air-Conditioning Servicing', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Domestic-Refrigeration-and-Air-Conditioning-Servicing.pdf'],
            ['group' => 'INDUSTRIAL TECHNOLOGIES', 'title' => 'Electrical Installation Maintenance', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Electrical-Installation-Maintenance.pdf'],
            ['group' => 'INDUSTRIAL TECHNOLOGIES', 'title' => 'Electronics Product and Assembly Servicing', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Electronics-Product-and-Assembly-Servicing.pdf'],
            ['group' => 'INDUSTRIAL TECHNOLOGIES', 'title' => 'Mechatronics', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Mechatronics.pdf'],
            ['group' => 'INDUSTRIAL TECHNOLOGIES', 'title' => 'Photovoltaic Systems Installation', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Photovoltaic-Systems-Installation.pdf'],

            // MARITIME
            ['group' => 'MARITIME', 'title' => 'Marine Engineering at the Support Level', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Marine-Engineering-at-the-Support-Level.pdf'],
            ['group' => 'MARITIME', 'title' => 'Marine Transportation at the Support Level', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Marine-Transportation-at-the-Support-Level.pdf'],
            ['group' => 'MARITIME', 'title' => 'Ships Catering Services', 'url' => 'https://www.deped.gov.ph/wp-content/uploads/Ships-Catering-Services.pdf'],
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

        $added2005 = 0;
        $updated2005 = 0;
        $added2006 = 0;
        $updated2006 = 0;
        $added2007 = 0;
        $updated2007 = 0;
        $added2008 = 0;
        $updated2008 = 0;
        $added2009 = 0;
        $updated2009 = 0;
        $added2010 = 0;
        $updated2010 = 0;
        $added2011 = 0;
        $updated2011 = 0;
        $added2012 = 0;
        $updated2012 = 0;
        $added2013 = 0;
        $updated2013 = 0;
        $added2014 = 0;
        $updated2014 = 0;
        $added2015 = 0;
        $updated2015 = 0;
        $added2016 = 0;
        $updated2016 = 0;
        $added2017 = 0;
        $updated2017 = 0;
        $added2018 = 0;
        $updated2018 = 0;
        $added2019 = 0;
        $updated2019 = 0;
        $added2020 = 0;
        $updated2020 = 0;
        $added2021 = 0;
        $updated2021 = 0;
        $added2022 = 0;
        $updated2022 = 0;
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

        // Process 2005 links
        foreach ($chedLinks2005 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2005',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2005++;
            } else {
                $updated2005++;
            }
        }

        // Process 2006 links
        foreach ($chedLinks2006 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2006',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2006++;
            } else {
                $updated2006++;
            }
        }

        // Process 2007 links
        foreach ($chedLinks2007 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2007',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2007++;
            } else {
                $updated2007++;
            }
        }

        // Process 2008 links
        foreach ($chedLinks2008 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2008',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2008++;
            } else {
                $updated2008++;
            }
        }

        // Process 2009 links
        foreach ($chedLinks2009 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2009',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2009++;
            } else {
                $updated2009++;
            }
        }

        // Process 2010 links
        foreach ($chedLinks2010 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '20',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2010++;
            } else {
                $updated2010++;
            }
        }

        // Process 2011 links
        foreach ($chedLinks2011 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2011',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2011++;
            } else {
                $updated2011++;
            }
        }

        // Process 2012 links
        foreach ($chedLinks2012 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2012',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2012++;
            } else {
                $updated2012++;
            }
        }

        // Process 2013 links
        foreach ($chedLinks2013 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2013',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2013++;
            } else {
                $updated2013++;
            }
        }

        // Process 2014 links
        foreach ($chedLinks2014 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2014',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2014++;
            } else {
                $updated2014++;
            }
        }

        // Process 2015 links
        foreach ($chedLinks2015 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2015',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2015++;
            } else {
                $updated2015++;
            }
        }

        // Process 2016 links
        foreach ($chedLinks2016 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2016',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2016++;
            } else {
                $updated2016++;
            }
        }

        // Process 2017 links
        foreach ($chedLinks2017 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2017',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2017++;
            } else {
                $updated2017++;
            }
        }

        // Process 2018 links
        foreach ($chedLinks2018 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2018',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2018++;
            } else {
                $updated2018++;
            }
        }

        // Process 2019 links
        foreach ($chedLinks2019 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2019',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2019++;
            } else {
                $updated2019++;
            }
        }

        // Process 2020 links
        foreach ($chedLinks2020 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2020',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2020++;
            } else {
                $updated2020++;
            }
        }

        // Process 2021 links
        foreach ($chedLinks2021 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2021',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2021++;
            } else {
                $updated2021++;
            }
        }

        // Process 2022 links
        foreach ($chedLinks2022 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2022',
                    'title' => $link['title']
                ],
                [
                    'url' => $link['url'],
                    'is_category' => false
                ]
            );

            if ($result->wasRecentlyCreated) {
                $added2022++;
            } else {
                $updated2022++;
            }
        }

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
        $this->command->info("📅 CHED 2005:");
        $this->command->info("  ✅ Added {$added2005} new links");
        if ($updated2005 > 0) {
            $this->command->info("  📝 Updated {$updated2005} existing links");
        }

        $this->command->info("📅 CHED 2006:");
        $this->command->info("  ✅ Added {$added2006} new links");
        if ($updated2006 > 0) {
            $this->command->info("  📝 Updated {$updated2006} existing links");
        }

        $this->command->info("📅 CHED 2007:");
        $this->command->info("  ✅ Added {$added2007} new links");
        if ($updated2007 > 0) {
            $this->command->info("  📝 Updated {$updated2007} existing links");
        }

        $this->command->info("📅 CHED 2008:");
        $this->command->info("  ✅ Added {$added2008} new links");
        if ($updated2008 > 0) {
            $this->command->info("  📝 Updated {$updated2008} existing links");
        }

        $this->command->info("📅 CHED 2009:");
        $this->command->info("  ✅ Added {$added2009} new links");
        if ($updated2009 > 0) {
            $this->command->info("  📝 Updated {$updated2009} existing links");
        }

        $this->command->info("📅 CHED 2010:");
        $this->command->info("  ✅ Added {$added2010} new links");
        if ($updated2010 > 0) {
            $this->command->info("  📝 Updated {$updated2010} existing links");
        }

        $this->command->info("📅 CHED 2011:");
        $this->command->info("  ✅ Added {$added2011} new links");
        if ($updated2011 > 0) {
            $this->command->info("  📝 Updated {$updated2011} existing links");
        }

        $this->command->info("📅 CHED 2012:");
        $this->command->info("  ✅ Added {$added2012} new links");
        if ($updated2012 > 0) {
            $this->command->info("  📝 Updated {$updated2012} existing links");
        }

        $this->command->info("📅 CHED 2013:");
        $this->command->info("  ✅ Added {$added2013} new links");
        if ($updated2013 > 0) {
            $this->command->info("  📝 Updated {$updated2013} existing links");
        }

        $this->command->info("📅 CHED 2014:");
        $this->command->info("  ✅ Added {$added2014} new links");
        if ($updated2014 > 0) {
            $this->command->info("  📝 Updated {$updated2014} existing links");
        }

        $this->command->info("📅 CHED 2015:");
        $this->command->info("  ✅ Added {$added2015} new links");
        if ($updated2015 > 0) {
            $this->command->info("  📝 Updated {$updated2015} existing links");
        }

        $this->command->info("📅 CHED 2016:");
        $this->command->info("  ✅ Added {$added2016} new links");
        if ($updated2016 > 0) {
            $this->command->info("  📝 Updated {$updated2016} existing links");
        }

        $this->command->info("📅 CHED 2017:");
        $this->command->info("  ✅ Added {$added2017} new links");
        if ($updated2017 > 0) {
            $this->command->info("  📝 Updated {$updated2017} existing links");
        }

        $this->command->info("📅 CHED 2018:");
        $this->command->info("  ✅ Added {$added2018} new links");
        if ($updated2018 > 0) {
            $this->command->info("  📝 Updated {$updated2018} existing links");
        }

        $this->command->info("📅 CHED 2019:");
        $this->command->info("  ✅ Added {$added2019} new links");
        if ($updated2019 > 0) {
            $this->command->info("  📝 Updated {$updated2019} existing links");
        }

        $this->command->info("📅 CHED 2020:");
        $this->command->info("  ✅ Added {$added2020} new links");
        if ($updated2020 > 0) {
            $this->command->info("  📝 Updated {$updated2020} existing links");
        }

        $this->command->info("📅 CHED 2021:");
        $this->command->info("  ✅ Added {$added2021} new links");
        if ($updated2021 > 0) {
            $this->command->info("  📝 Updated {$updated2021} existing links");
        }

        $this->command->info("📅 CHED 2022:");
        $this->command->info("  ✅ Added {$added2022} new links");
        if ($updated2022 > 0) {
            $this->command->info("  📝 Updated {$updated2022} existing links");
        }

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

        $totalAdded = $added2005 + $added2006 + $added2007 + $added2008 + $added2009 + $added2010 + $added2011 + $added2012 + $added2013 + $added2014 + $added2015 + $added2016 + $added2017 + $added2018 + $added2019 + $added2020 + $added2021 + $added2022 + $added2023 + $added2024 + $added2025 + $addedDepEdAcademic + $addedDepEdTechPro + $addedDepEdCore + $addedDepEdShapePaper;
        $totalUpdated = $updated2005 + $updated2006 + $updated2007 + $updated2008 + $updated2009 + $updated2010 + $updated2011 + $updated2012 + $updated2013 + $updated2014 + $updated2015 + $updated2016 + $updated2017 + $updated2018 + $updated2019 + $updated2020 + $updated2021 + $updated2022 + $updated2023 + $updated2024 + $updated2025 + $updatedDepEdAcademic + $updatedDepEdTechPro + $updatedDepEdCore + $updatedDepEdShapePaper;
        
        $this->command->info("\n🎉 Total: {$totalAdded} links added, {$totalUpdated} links updated");
    }
}
