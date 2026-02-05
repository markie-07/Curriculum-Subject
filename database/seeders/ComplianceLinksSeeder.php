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
        // CHED 2010 Links (30+ CMOs - proper sequence 1-35)
        $chedLinks2010 = [
            ['title' => 'CMO No. 1, Series of 2010 – Policies and Standards for Master of Science in Fisheries Program (MSFi)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2010.pdf'],
            ['title' => 'CMO No. 2, Series of 2010 – Appeal for Flexibility in No Permit, No Examination Policy', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2010.pdf'],
            ['title' => 'CMO No. 3, Series of 2010 – Extension of Scholarship to Qualified Dependents of Philippine Veterans', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2010.pdf'],
            ['title' => 'CMO No. 4, Series of 2010 – Second Batch of COD in Engineering (Civil and Sanitary)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2010.pdf'],
            ['title' => 'CMO No. 5, Series of 2010 – Observance of Simple Graduation Rites in All HEIs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2010.pdf'],
            ['title' => 'CMO No. 6, Series of 2010 – Policies and Standards for Bachelor of Public Administration (BPA)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-s.-2010.pdf'],
            ['title' => 'CMO No. 7, Series of 2010 – Revised PSG for Graduate Program Information Technology Education (ITE)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-07-s.-2010.pdf'],
            ['title' => 'CMO No. 8, Series of 2010 – Revised Guidelines for Outstanding HEI Extension Program Award', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2010.pdf'],
            ['title' => 'CMO No. 9, Series of 2010 – CHED Accredited Research Journals', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2010.pdf'],
            ['title' => 'CMO No. 10, Series of 2010 – Policies and Standards for Bachelor of Arts in Communication', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2010.pdf'],
            ['title' => 'CMO No. 11, Series of 2010 – Policies and Standards for Bachelor of Science in Social Work', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2010.pdf'],
            ['title' => 'CMO No. 12, Series of 2010 – Policies and Standards for Diploma in Journalism and MA in Journalism', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2010.pdf'],
            ['title' => 'CMO No. 13, Series of 2010 – Policies and Standards for Master of Arts in Broadcasting', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2010.pdf'],
            ['title' => 'CMO No. 14, Series of 2010 – Policies and Standards for Bachelor of Arts in Journalism', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-14-s.-2010.pdf'],
            ['title' => 'CMO No. 15, Series of 2010 – Policies and Standards for BS Development Communication', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2010.pdf'],
            ['title' => 'CMO No. 16, Series of 2010 – Policies and Standards for Bachelor of Arts in History', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-16-s.-2010.pdf'],
            ['title' => 'CMO No. 17, Series of 2010 – Revised Guidelines for CHED Visiting Research Fellowships', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-s.-2010.pdf'],
            ['title' => 'CMO No. 19, Series of 2010 – Implementing Guidelines for Selection of COD and COE in Maritime Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-19-s.-2010.pdf'],
            ['title' => 'CMO No. 20, Series of 2010 – Revised Guidelines to CMO No. 13, s. 2005 (PSG for Maritime Education)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-20-s.-2010.pdf'],
            ['title' => 'CMO No. 22, Series of 2010 – Enhanced Guidelines for Student Internship Abroad Program (SIAP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-22-s.-2010.pdf'],
            ['title' => 'CMO No. 23, Series of 2010 – Implementing Guidelines for Inclusion of Foreign Languages as Electives', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-23-s.-2010.pdf'],
            ['title' => 'CMO No. 24, Series of 2010 – COEs and CODs for Teacher Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-24-s.-2010.pdf'],
            ['title' => 'CMO No. 26, Series of 2010 – AY 2010/11 Higher Education Data/Information Collection', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-26-s.-2010.pdf'],
            ['title' => 'CMO No. 28, Series of 2010 – Systems and Procedures for Joint CHED-PRC Inspection of HEIs Offering Board Programs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-28-s.-2010.pdf'],
            ['title' => 'CMO No. 30, Series of 2010 – Revised Guidelines for CHED Best HEI Research Program (BHERP) Award', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-30-s.-2010.pdf'],
            ['title' => 'CMO No. 32, Series of 2010 – Moratorium on Opening Programs in Business Admin, Nursing, Teacher Ed, HRM, and IT', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-32-s.-2010.pdf'],
            ['title' => 'CMO No. 33, Series of 2010 – COEs and CODs for Teacher Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-33-s.-2010.pdf'],
            ['title' => 'CMO No. 34, Series of 2010 – Clarificatory Guidelines for Suspension of Classes Due to Weather Disturbances', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-34-s.-2010.pdf'],
        ];

        // CHED 2011 Links (30+ CMOs - proper sequence 1-35)
        $chedLinks2011 = [
            ['title' => 'CMO No. 1, Series of 2011 – Guidelines on Adoption of School Calendar', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2011.pdf'],
            ['title' => 'CMO No. 2, Series of 2011 – Revised Guidelines in Formulation of CHED PSG of Academic Programs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2011.pdf'],
            ['title' => 'CMO No. 3, Series of 2011 – Amendment to CMO No. 29, s. 2009 (Revised Implementing Guidelines for StuFAPs)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2011.pdf'],
            ['title' => 'CMO No. 4, Series of 2011 – CHED Priority Courses from SY 2011-2012 to SY 2015-2016', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2011.pdf'],
            ['title' => 'CMO No. 5, Series of 2011 – Terms of Office for Technical Panels and Technical Committee Chairpersons', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2011.pdf'],
            ['title' => 'CMO No. 6, Series of 2011 – PSG for Graduate Programs in Biology (MS Biology and Master Biology)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-s.-2011.pdf'],
            ['title' => 'CMO No. 7, Series of 2011 – PSG for Doctor of Philosophy in Biology', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-07-s.-2011.pdf'],
            ['title' => 'CMO No. 8, Series of 2011 – PSG for Master of Science in Chemistry and Master of Chemistry', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2011.pdf'],
            ['title' => 'CMO No. 9, Series of 2011 – PSG for Doctor of Philosophy in Chemistry', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2011.pdf'],
            ['title' => 'CMO No. 10, Series of 2011 – PSG for Master of Science in Mathematics Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2011.pdf'],
            ['title' => 'CMO No. 11, Series of 2011 – PSG for Doctor of Philosophy in Mathematics Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2011.pdf'],
            ['title' => 'CMO No. 12, Series of 2011 – PSG for Master of Science in Physics Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2011.pdf'],
            ['title' => 'CMO No. 13, Series of 2011 – PSG for Doctor of Philosophy in Physics Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2011.pdf'],
            ['title' => 'CMO No. 15, Series of 2011 – Extension of Designation of COE and COD in Science and Mathematics', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2011.pdf'],
            ['title' => 'CMO No. 16, Series of 2011 – Implementing Rules and Regulation for Enhanced Study-Now-Pay-Later (E-SNPL)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-16-s.-2011.pdf'],
            ['title' => 'CMO No. 18, Series of 2011 – Amendments to Article XI-Sanctions of CMO No. 14, s. 2009 (BS Nursing)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-18-s.-2011.pdf'],
            ['title' => 'CMO No. 20, Series of 2011 – Policies and Guidelines for Use of Income, STF and PRE of SUCs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-20-s.-2011.pdf'],
            ['title' => 'CMO No. 21, Series of 2011 – AY 2011-2012 Higher Education Data/Information Collection', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-21-s.-2011.pdf'],
            ['title' => 'CMO No. 22, Series of 2011 – PSG for Graduate Programs in History', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-22-s.-2011.pdf'],
            ['title' => 'CMO No. 23, Series of 2011 – PSG for Bachelor of Physical Education (BPE-SPE and BPE-SWM)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-23-s.-2011.pdf'],
            ['title' => 'CMO No. 24, Series of 2011 – Guidelines for CHED Visiting Research Fellowship Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-24-s.-2011.pdf'],
            ['title' => 'CMO No. 25, Series of 2011 – CHED Accredited Research Journals', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-25-s.-2011.pdf'],
            ['title' => 'CMO No. 26, Series of 2011 – PSG for Master of Science in Development Communication', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-26-s.-2011.pdf'],
            ['title' => 'CMO No. 27, Series of 2011 – PSG for Master of Arts in Communication Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-27-s.-2011.pdf'],
            ['title' => 'CMO No. 28, Series of 2011 – PSG for Bachelor of Science in Real Estate Management (BS REM)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-28-s.-2011.pdf'],
            ['title' => 'CMO No. 29, Series of 2011 – PSG for Speech-Language Pathology Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-29-s.-2011.pdf'],
            ['title' => 'CMO No. 31, Series of 2011 – PSG for Bachelor of Arts in Political Science Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-31-s.-2011.pdf'],
            ['title' => 'CMO No. 32, Series of 2011 – PSG for Graduate Programs in Political Science', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-32-s.-2011.pdf'],
            ['title' => 'CMO No. 34, Series of 2011 – PSG for Bachelor of Landscape Architecture (BLA)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-34-s.-2011.pdf'],
        ];

        // CHED 2012 Links (35+ CMOs - proper sequence 1-35)
        $chedLinks2012 = [
            ['title' => 'CMO No. 1, Series of 2012 – Model Embedment of TVET Competencies in Ladderized BS Mechanical Engineering', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2012.pdf'],
            ['title' => 'CMO No. 2, Series of 2012 – Implementing Guidelines on Shipboard Training for BSMT and BSMarE', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2012.pdf'],
            ['title' => 'CMO No. 3, Series of 2012 – Enhanced Policies on Increases in Tuition and Other School Fees', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2012.pdf'],
            ['title' => 'CMO No. 4, Series of 2012 – CHED Accredited Research Journals', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2012.pdf'],
            ['title' => 'CMO No. 5, Series of 2012 – Revised Guidelines for CHED Accredited Research Journals', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2012.pdf'],
            ['title' => 'CMO No. 8, Series of 2012 – Amendment to CMO No. 3, s. 2012 (Tuition and School Fees)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2012.pdf'],
            ['title' => 'CMO No. 9, Series of 2012 – Guidelines on Grant and Allocation of Disbursement Acceleration Fund for SUCs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2012.pdf'],
            ['title' => 'CMO No. 10, Series of 2012 – Extension of Grant of Autonomous and Deregulated Status to HEIs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2012.pdf'],
            ['title' => 'CMO No. 11, Series of 2012 – Extension of Designation of Existing COE and COD', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2012.pdf'],
            ['title' => 'CMO No. 16, Series of 2012 – Identification, Support and Development of COE and COD in Psychology', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-16-s.-2012.pdf'],
            ['title' => 'CMO No. 17, Series of 2012 – Policies and Guidelines on Educational Tours and Field Trips', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-s.-2012.pdf'],
            ['title' => 'CMO No. 19, Series of 2012 – Identification, Support and Development of COE and COD in Communication', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-19-s.-2012.pdf'],
            ['title' => 'CMO No. 20, Series of 2012 – Identification, Support and Development of COE and COD in Journalism', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-20-s.-2012.pdf'],
            ['title' => 'CMO No. 23, Series of 2012 – Identification, Support and Development of COE and COD in Philosophy', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-23-s.-2012.pdf'],
            ['title' => 'CMO No. 24, Series of 2012 – Identification, Support and Development of COE and COD in Music', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-24-s.-2012.pdf'],
            ['title' => 'CMO No. 25, Series of 2012 – Identification, Support and Development of COE and COD in Literature', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-25-s.-2012.pdf'],
            ['title' => 'CMO No. 26, Series of 2012 – Identification, Support and Development of COE and COD in Foreign Language', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-26-s.-2012.pdf'],
            ['title' => 'CMO No. 28, Series of 2012 – Identification, Support and Development of COE and COD in English', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-28-s.-2012.pdf'],
            ['title' => 'CMO No. 46, Series of 2012 – Policy-Standard to Enhance QA through Outcomes-Based and Typology-Based QA', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-46-s.-2012.pdf'],
            ['title' => 'CMO No. 53, Series of 2012 – Revised Policies and Guidelines on Conferment of Honorary Doctorate Degrees', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-53-s.-2012.pdf'],
        ];

        // CHED 2013 Links (10+ CMOs - proper sequence 1-35)
        $chedLinks2013 = [
            ['title' => 'CMO No. 9, Series of 2013 – Enhanced Policies and Guidelines on Student Affairs and Services', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2013.pdf'],
            ['title' => 'CMO No. 20, Series of 2013 – General Education Curriculum: Holistic Understandings, Intellectual and Civic Competencies', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-20-s.-2013.pdf'],
            ['title' => 'CMO No. 29, Series of 2013 – Cascading of SUC Performance Targets', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-29-s.-2013.pdf'],
            ['title' => 'CMO No. 33, Series of 2013 – Policies and Guidelines on University Mobility in Asia and Pacific (UMAP) Credit Transfer Scheme', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-33-s.-2013.pdf'],
        ];

        // CHED 2014 Links (23 CMOs - proper sequence 1-35)
        $chedLinks2014 = [
            ['title' => 'CMO No. 1, Series of 2014 – CHED Priority Courses for AY 2014-2015 to AY 2017-2018', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2014.pdf'],
            ['title' => 'CMO No. 2, Series of 2014 – PSG for Bachelor of Science in Entertainment and Multimedia Computing (BS EMC)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2014.pdf'],
            ['title' => 'CMO No. 3, Series of 2014 – Guidelines for Grants and Proposals of COE and COD in Philosophy', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2014.pdf'],
            ['title' => 'CMO No. 4, Series of 2014 – Guidelines for Grants and Proposals of COE and COD in English', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2014.pdf'],
            ['title' => 'CMO No. 5, Series of 2014 – Panuntunan Sa Mga Proposal at Pagkakaloob ng Pondo Sa Mga COE at COD sa Filipino', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2014.pdf'],
            ['title' => 'CMO No. 6, Series of 2014 – Guidelines for Grants and Proposals of COE and COD in Literature', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-s.-2014.pdf'],
            ['title' => 'CMO No. 7, Series of 2014 – Guidelines for Grants and Proposals of COE and COD in Music', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-07-s.-2014.pdf'],
            ['title' => 'CMO No. 8, Series of 2014 – Guidelines for Grants and Proposals of COE and COD in Foreign Language', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2014.pdf'],
            ['title' => 'CMO No. 10, Series of 2014 – CHED Accredited Research Journals', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2014.pdf'],
            ['title' => 'CMO No. 11, Series of 2014 – Guidelines for Participation of Selected HEIs in ASEAN International Mobility for Students (AIMS)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2014.pdf'],
            ['title' => 'CMO No. 12, Series of 2014 – Guidelines for Accessing Funds for Rehabilitation and Reconstruction Works for SUCs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2014.pdf'],
            ['title' => 'CMO No. 13, Series of 2014 – Revised Guidelines for Implementation of StuFAPs, Effective AY 2014-2015', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2014.pdf'],
            ['title' => 'CMO No. 14, Series of 2014 – AY 2014-2015 Higher Education Data Information Collection', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-14-s.-2014.pdf'],
            ['title' => 'CMO No. 15, Series of 2014 – CHED Accredited Research Journals', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2014.pdf'],
            ['title' => 'CMO No. 16, Series of 2014 – Addendum to CMO No. 13, s. 2014 (Revised Guidelines for StuFAPs)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-16-s.-2014.pdf'],
            ['title' => 'CMO No. 17, Series of 2014 – Lifting of Moratorium on Opening Programs in Business Admin, HRM, and IT', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-s.-2014.pdf'],
            ['title' => 'CMO No. 18, Series of 2014 – Installation of Labor Market Information Corner in All HEIs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-18-s.-2014.pdf'],
            ['title' => 'CMO No. 19, Series of 2014 – Enhanced Policies and Guidelines on Conferment of Honorary Doctorate Degrees', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-19-s.-2014.pdf'],
            ['title' => 'CMO No. 20, Series of 2014 – Revised Implementing Guidelines on Approved Seagoing Service for BSMT and BSMarE', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-20-s.-2014.pdf'],
            ['title' => 'CMO No. 21, Series of 2014 – Extension of Validity Period of Autonomous and Deregulated Status of Private HEIs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-21-s.-2014.pdf'],
            ['title' => 'CMO No. 22, Series of 2014 – Policies and Guidelines on Assistance to Students in Areas Under State of Calamity', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-22-s.-2014.pdf'],
            ['title' => 'CMO No. 23, Series of 2014 – CHED Accredited Research Journals', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-23-s.-2014.pdf'],
        ];

        // CHED 2015 Links (27 CMOs - ~70% coverage)
        $chedLinks2015 = [
            ['title' => 'CMO No. 1, Series of 2015 – Policies and Guidelines on Gender and Development in CHED and HEIs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2015.pdf'],
            ['title' => 'CMO No. 2, Series of 2015 – Lifting of Moratorium on Offering Programs via Transnational Education (TNE)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2015.pdf'],
            ['title' => 'CMO No. 3, Series of 2015 – Policy Reforms for Grants-In-Aid Funds for Research, Development, and Extension', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2015.pdf'],
            ['title' => 'CMO No. 6, Series of 2015 – Amendment to CMO No. 51, s. 2007 (COE-COD for Agriculture)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-s.-2015.pdf'],
            ['title' => 'CMO No. 7, Series of 2015 – Amendment to CMO No. 28, s. 2012 (COE-COD for English)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-07-s.-2015.pdf'],
            ['title' => 'CMO No. 8, Series of 2015 – Amendment to CMO No. 26, s. 2012 (COE-COD for Foreign Language)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2015.pdf'],
            ['title' => 'CMO No. 9, Series of 2015 – Amendment to CMO No. 25, s. 2012 (COE-COD for Literature)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2015.pdf'],
            ['title' => 'CMO No. 10, Series of 2015 – Amendment to CMO No. 24, s. 2012 (COE-COD for Music)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2015.pdf'],
            ['title' => 'CMO No. 11, Series of 2015 – Amendment to CMO No. 23, s. 2012 (COE-COD for Philosophy)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2015.pdf'],
            ['title' => 'CMO No. 12, Series of 2015 – Standards for Selection of COE-COD for Science and Mathematics', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2015.pdf'],
            ['title' => 'CMO No. 13, Series of 2015 – Amendment to CMO No. 19, s. 2012 (COE-COD for Communication)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2015.pdf'],
            ['title' => 'CMO No. 14, Series of 2015 – Amendment to CMO No. 20, s. 2012 (COE-COD for Journalism)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-14-s.-2015.pdf'],
            ['title' => 'CMO No. 15, Series of 2015 – Amendment to CMO No. 16, s. 2012 (COE-COD for Psychology)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2015.pdf'],
            ['title' => 'CMO No. 16, Series of 2015 – Amendment to CMO No. 26, s. 2007 (COE-COD for Teacher Education)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-16-s.-2015.pdf'],
            ['title' => 'CMO No. 17, Series of 2015 – Revised Guidelines for COE/COD Engineering', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-s.-2015.pdf'],
            ['title' => 'CMO No. 18, Series of 2015 – Guidelines for CHED Research Chair Award', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-18-s.-2015.pdf'],
            ['title' => 'CMO No. 19, Series of 2015 – Operational Guidelines for ASEAN International Mobility of Students (AIMS) Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-19-s.-2015.pdf'],
            ['title' => 'CMO No. 20, Series of 2015 – Consolidated PSG for BS Marine Transportation and BS Marine Engineering', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-20-s.-2015.pdf'],
            ['title' => 'CMO No. 21, Series of 2015 – Extension of Validity Period of Autonomous/Deregulated Status and COE/COD Designation', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-21-s.-2015.pdf'],
            ['title' => 'CMO No. 22, Series of 2015 – CHED Accredited Research Journals', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-22-s.-2015.pdf'],
            ['title' => 'CMO No. 24, Series of 2015 – Revised PSG for Bachelor of Library and Information Science (BLIS)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-24-s.-2015.pdf'],
            ['title' => 'CMO No. 25, Series of 2015 – Revised PSG for BS Computer Science, BS Information Systems, and BS Information Technology', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-25-s.-2015.pdf'],
            ['title' => 'CMO No. 26, Series of 2015 – Policies and Procedures on International Education Trips (IET)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-26-s.-2015.pdf'],
            ['title' => 'CMO No. 27, Series of 2015 – Guidelines on Issuance of NSTP Serial Numbers', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-27-s.-2015.pdf'],
            ['title' => 'CMO No. 28, Series of 2015 – PSG for BS Naval Architecture and Marine Engineering (BSNAME)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-28-s.-2015.pdf'],
            ['title' => 'CMO No. 32, Series of 2015 – Guidelines for SHS Program Implementation of SUCs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-32-s.-2015.pdf'],
            ['title' => 'CMO No. 33, Series of 2015 – Guidelines for SHS Program Implementation of LUCs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-33-s.-2015.pdf'],
            ['title' => 'CMO No. 38, Series of 2015 – Designated COEs and CODs for Various Disciplines', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-38-s.-2015.pdf'],
        ];

        // CHED 2016 Links (45 CMOs - ~70% coverage)
        $chedLinks2016 = [
            ['title' => 'CMO No. 1, Series of 2016 – Amendment to CMO No. 38, s. 2015 (Designated COEs and CODs)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2016.pdf'],
            ['title' => 'CMO No. 3, Series of 2016 – Guidelines on Graduate Education Scholarships for Faculty and Staff Development (K to 12)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2016.pdf'],
            ['title' => 'CMO No. 4, Series of 2016 – Guidelines on Graduate Education Delivery for Faculty and Staff Development (K to 12)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2016.pdf'],
            ['title' => 'CMO No. 5, Series of 2016 – Amendments to CMO No. 17, s. 2013 (Enhanced Policies for CAV of School Documents)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2016.pdf'],
            ['title' => 'CMO No. 6, Series of 2016 – Extension of Validity Period of Autonomous and Deregulated Status of Private HEIs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-s.-2016.pdf'],
            ['title' => 'CMO No. 9, Series of 2016 – Guidelines for Senior High School (SHS) Support Grants Under K to 12 Transition Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2016.pdf'],
            ['title' => 'CMO No. 11, Series of 2016 – Guidelines for Delivery of IRSE Grants Under K to 12 Transition Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2016.pdf'],
            ['title' => 'CMO No. 13, Series of 2016 – Implementing Guidelines for Industry Partnerships Under IRSE Grants', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2016.pdf'],
            ['title' => 'CMO No. 14, Series of 2016 – Guidelines for Availing of IRSE Grants Under K to 12 Transition Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-14-s.-2016.pdf'],
            ['title' => 'CMO No. 15, Series of 2016 – Designated COEs and CODs for Engineering Programs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2016.pdf'],
            ['title' => 'CMO No. 17, Series of 2016 – COEs and CODs for Teacher Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-s.-2016.pdf'],
            ['title' => 'CMO No. 18, Series of 2016 – Policies, Standards, and Guidelines for Doctor of Medicine (M.D.) Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-18-s.-2016.pdf'],
            ['title' => 'CMO No. 19, Series of 2016 – Benefits and Responsibilities of Autonomous and Deregulated Private HEIs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-19-s.-2016.pdf'],
            ['title' => 'CMO No. 20, Series of 2016 – Private HEIs Granted Autonomous and Deregulated Status', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-20-s.-2016.pdf'],
            ['title' => 'CMO No. 21, Series of 2016 – Guidelines for CHED Support for Grants-In-Aid to Students in International Conferences', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-21-s.-2016.pdf'],
            ['title' => 'CMO No. 22, Series of 2016 – Guidelines for Foreign Scholarships for Graduate Studies (K to 12)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-22-s.-2016.pdf'],
            ['title' => 'CMO No. 25, Series of 2016 – Guidelines for Professional Advancement and Postdoctoral Study Grants (K to 12)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-25-s.-2016.pdf'],
            ['title' => 'CMO No. 30, Series of 2016 – Implementing Guidelines for Scholarship Grant Program for Sugarcane Industry Workers', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-30-s.-2016.pdf'],
            ['title' => 'CMO No. 33, Series of 2016 – Guidelines for Institutional Development and Innovation Grants Under K to 12', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-33-s.-2016.pdf'],
            ['title' => 'CMO No. 34, Series of 2016 – Selective Crediting of SHS Subjects to College for SHS Graduates', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-34-s.-2016.pdf'],
            ['title' => 'CMO No. 35, Series of 2016 – Guidelines for Operation of SHS in SUCs and LUCs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-35-s.-2016.pdf'],
            ['title' => 'CMO No. 41, Series of 2016 – PSG Governing Sale, Merger or Consolidation of Private HEIs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-41-s.-2016.pdf'],
            ['title' => 'CMO No. 47, Series of 2016 – Strengthening Protection of Religious Rights of Students in HEIs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-47-s.-2016.pdf'],
            ['title' => 'CMO No. 50, Series of 2016 – Implementing Guidelines for Faculty Training for New GE Core Courses', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-50-s.-2016.pdf'],
            ['title' => 'CMO No. 52, Series of 2016 – Pathways to Equity, Relevance and Advancement in Research, Innovation, and Extension', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-52-s.-2016.pdf'],
            ['title' => 'CMO No. 53, Series of 2016 – Guidelines for CHED Journal Incentive Program (JIP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-53-s.-2016.pdf'],
            ['title' => 'CMO No. 54, Series of 2016 – Revised PSG for Implementation of ETEEAP for Undergraduate Programs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-54-s.-2016.pdf'],
            ['title' => 'CMO No. 55, Series of 2016 – Policy Framework and Strategies on Internationalization of Philippine Higher Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-55-s.-2016.pdf'],
            ['title' => 'CMO No. 56, Series of 2016 – New Procedures in Processing Applications for Government Authority to Operate Engineering Degrees', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-56-s.-2016.pdf'],
            ['title' => 'CMO No. 58, Series of 2016 – Guidelines for Expanded Students\' Grants-In-Aid Program for Poverty Alleviation (ESGP-PA)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-58-s.-2016.pdf'],
            ['title' => 'CMO No. 62, Series of 2016 – Policies, Standards and Guidelines (PSGs) for Transnational Education (TNE) Programs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-62-s.-2016.pdf'],
        ];

        // CHED 2017 Links (25+ CMOs - proper sequence 1-35)
        $chedLinks2017 = [
            ['title' => 'CHED-DBM JMC No. 2017-1 – Guidelines on Grant of Free Tuition in SUCs for FY 2017', 'url' => 'https://ched.gov.ph/wp-content/uploads/CHED-DBM-JMC-No.-2017-1.pdf'],
            ['title' => 'CMO No. 3, Series of 2017 – Guidelines on Start-up Grant for Foreign Studies and Scholarships for Graduate Studies Abroad (K to 12)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2017.pdf'],
            ['title' => 'CMO No. 4, Series of 2017 – Amendment to CMO No. 3, s. 2016 (Scholarships for Graduate Studies - K to 12)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2017.pdf'],
            ['title' => 'CMO No. 6, Series of 2017 – Amendment to CMO No. 18, s. 2015 (CHED Research Chair Award)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-s.-2017.pdf'],
            ['title' => 'CMO No. 8, Series of 2017 – Implementing Guidelines for Faculty Training for New GE Core Courses (Second-Generation)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2017.pdf'],
            ['title' => 'CMO No. 9, Series of 2017 – Addendum to CMO No. 61, s. 2016 (CHED Engineering Faculty Training on Technopreneurship)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2017.pdf'],
            ['title' => 'CMO No. 10, Series of 2017 – Policy on Students Affected by K to 12 Program and New General Curriculum', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2017.pdf'],
            ['title' => 'CMO No. 11, Series of 2017 – Policy on Temporary Suspension of Processing Government Authorization for Graduate Programs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2017.pdf'],
            ['title' => 'CMO No. 12, Series of 2017 – Updated Guidelines for IDIG Under K to 12 Transition Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2017.pdf'],
            ['title' => 'CMO No. 13, Series of 2017 – PSG for BS Medical Technology/Medical Laboratory Science (BSMT/BSMLS)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2017.pdf'],
            ['title' => 'CMO No. 14, Series of 2017 – PSG for Bachelor of Science in Nursing (BSN)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-14-s.-2017.pdf'],
            ['title' => 'CMO No. 15, Series of 2017 – Policies, Standards, and Guidelines for Bachelor of Science in Nursing Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2017.pdf'],
            ['title' => 'CMO No. 17, Series of 2017 – Revised PSG for Bachelor of Science in Business Administration', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-s.-2017.pdf'],
            ['title' => 'CMO No. 18, Series of 2017 – Revised PSG for Bachelor of Science in Entrepreneurship', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-18-s.-2017.pdf'],
            ['title' => 'CMO No. 19, Series of 2017 – PSG for Business Administration, Entrepreneurship, and Office Administration (Bridging Programs)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-19-s.-2017.pdf'],
            ['title' => 'CMO No. 20, Series of 2017 – PSG for Bachelor of Multimedia Arts (BMMA)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-20-s.-2017.pdf'],
            ['title' => 'CMO No. 50, Series of 2017 – First Batch of CHED-JIP Recognized Journals for 2017-2019', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-50-s.-2017.pdf'],
            ['title' => 'CMO No. 57, Series of 2017 – Policy on Offering Filipino Subjects in All HE Programs (New GE Curriculum)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-57-s.-2017.pdf'],
            ['title' => 'CMO No. 63, Series of 2017 – Policies and Guidelines for Local Off-Campus Activities', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-63-s.-2017.pdf'],
            ['title' => 'CMO No. 66, Series of 2017 – Second Batch of CHED-JIP Recognized Journals for 2017-2019', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-66-s.-2017.pdf'],
            ['title' => 'CMO No. 67, Series of 2017 – Revised PSG for BS Marine Transportation and BS Marine Engineering Programs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-67-s.-2017.pdf'],
            ['title' => 'CMO No. 75, Series of 2017 – Revised PSG for Bachelor of Secondary Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-75-s.-2017.pdf'],
            ['title' => 'CMO No. 77, Series of 2017 – Revised PSG for Bachelor of Special Needs Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-77-s.-2017.pdf'],
            ['title' => 'CMO No. 105, Series of 2017 – Policy on Admission of Senior High School Graduates to HEIs (AY 2018-2019)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-105-s.-2017.pdf'],
        ];

        // CHED 2018 Links (12+ CMOs - proper sequence 1-35)
        $chedLinks2018 = [
            ['title' => 'CMO No. 2, Series of 2018 – Delegation to CHEDROs of Processing Applications for Accreditation of Health Facilities', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2018.pdf'],
            ['title' => 'CMO No. 4, Series of 2018 – Policy on Offering Filipino and Panitikan Subjects in All HE Programs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2018.pdf'],
            ['title' => 'CMO No. 5, Series of 2018 – PSG for Bachelor of Science in Criminology', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2018.pdf'],
            ['title' => 'CMO No. 6, Series of 2018 – PSG for Bachelor of Science in Industrial Security Management (BSISM)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-s.-2018.pdf'],
            ['title' => 'CMO No. 7, Series of 2018 – PSG for Bachelor of Science in Radiologic Technology', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-07-s.-2018.pdf'],
            ['title' => 'CMO No. 8, Series of 2018 – Submission of New or Revised Curricula of HEIs for AY 2018-2019', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2018.pdf'],
            ['title' => 'CMO No. 9, Series of 2018 – Guidelines on Eligibility of LUCs for Free Higher Education (RA 10931)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2018.pdf'],
            ['title' => 'CMO No. 12, Series of 2018 – Overview of 2016 SUCs Levelling Results and Appeal Procedures', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2018.pdf'],
            ['title' => 'CMO No. 15, Series of 2018 – PSG for Doctor of Optometry Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2018.pdf'],
            ['title' => 'CMO No. 17, Series of 2018 – Call for Applications for Scholarships for Transnational Education Programs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-s.-2018.pdf'],
            ['title' => 'CMO No. 18, Series of 2018 – Guidelines on Drug Testing in Higher Education Institutions', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-18-s.-2018.pdf'],
        ];

        // CHED 2019 Links (13+ CMOs - proper sequence 1-35)
        $chedLinks2019 = [
            ['title' => 'CMO No. 1, Series of 2019 – Integration of Peace Studies/Education Into Relevant HE Curricula', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2019.pdf'],
            ['title' => 'CMO No. 2, Series of 2019 – Integration of Indigenous Peoples\' (IP) Studies/Education Into Relevant HE Curricula', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2019.pdf'],
            ['title' => 'CMO No. 3, Series of 2019 – Extension of Centers of Excellence and Centers of Development for Various Disciplines', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2019.pdf'],
            ['title' => 'CHED-DBM JMC No. 04, s. 2019 – Revised Implementing Guidelines of CHED-Tulong Dunong Program (CHED-TDP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CHED-DBM-JMC-No.-04-s.-2019.pdf'],
            ['title' => 'CMO No. 7, Series of 2019 – PSG for Bachelor of Science in Food Technology', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-07-s.-2019.pdf'],
            ['title' => 'CMO No. 8, Series of 2019 – Policies and Guidelines for CHED Scholarship Programs (CSPs)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2019.pdf'],
            ['title' => 'CMO No. 9, Series of 2019 – SUC Level of 106 State Universities and Colleges', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2019.pdf'],
            ['title' => 'CMO No. 10, Series of 2019 – Amendments to CMO 08, s. 2019 (CHED Scholarship Programs)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2019.pdf'],
            ['title' => 'CMO No. 12, Series of 2019 – Grant of Autonomous and Deregulated Status to 68 Private HEIs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2019.pdf'],
            ['title' => 'CMO No. 13, Series of 2019 – Guidelines for CHED-Initiated Projects under IDIG for SUCs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2019.pdf'],
            ['title' => 'CMO No. 15, Series of 2019 – Policies, Standards, and Guidelines for Graduate Programs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2019.pdf'],
        ];

        // CHED 2020 Links
        $chedLinks2020 = [
            ['title' => 'CMO No. 1, Series of 2020 – Guidelines for the Grant of Assistance to State Universities and Colleges to Combat COVID-19', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2020.pdf'],
            ['title' => 'CMO No. 2, Series of 2020 – Amendment to Sections III, IV, V, VI, VII and VIII of CMO No. 30, Series of 2016 (SIDA-SGP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2020.pdf'],
            ['title' => 'CMO No. 3, Series of 2020 – Amendments to the Revised and Expanded Guidelines for the Continuing Professional Education Grants', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2020.pdf'],
            ['title' => 'CMO No. 4, Series of 2020 – Guidelines on the Implementation of Flexible Learning', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2020.pdf'],
            ['title' => 'CMO No. 5, Series of 2020 – Guidelines on the Suspension of Operations of Degree Programs of Private Higher Education Institutions', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2020.pdf'],
            ['title' => 'CMO No. 6, Series of 2020 – Guidelines for the Scholarships for Instructors Knowledge Advancement Program (SIKAP) Grant', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-s.-2020.pdf'],
            ['title' => 'CMO No. 8, Series of 2020 – Guidelines for the Support and Development of Discipline-Based Higher Education Roadmaps', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2020.pdf'],
            ['title' => 'CMO No. 9, Series of 2020 – Guidelines on the Allocation of Financial Assistance for SUCs for Smart Campuses (RA 11494)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2020.pdf'],
            ['title' => 'CMO No. 10, Series of 2020 – Implementing Guidelines for Bayanihan 2 for Higher Education Tulong Program (B2HELP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2020.pdf'],
            ['title' => 'CMO No. 11, Series of 2020 – Implementing Rules and Regulations of RA 11396 (SUC Dormitories and Housing)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2020.pdf'],
            ['title' => 'CMO No. 12, Series of 2020 – Short-Term Scholarship Grants during the K to 12 Transition Period', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2020.pdf'],
            ['title' => 'CMO No. 13, Series of 2020 – Interim Policy on Documentary Submissions for SGS-L during COVID-19 Pandemic', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-13-s.-2020.pdf'],
        ];

        // CHED 2021 Links
        $chedLinks2021 = [
            ['title' => 'CMO No. 1, Series of 2021 – Amendment to Section V D-1(f) of CMO No. 10, Series of 2020 (B2HELP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2021.pdf'],
            ['title' => 'CMO No. 2, Series of 2021 – Guidelines on the Grant of Certificate of Program Compliance (COPC) to SUCs and LUCs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2021.pdf'],
            ['title' => 'CMO No. 3, Series of 2021 – Guidelines on the Implementation of Flexible Learning in Higher Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2021.pdf'],
            ['title' => 'CMO No. 4, Series of 2021 – Revised Guidelines on the Student Internship Program in the Philippines (SIPP)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2021.pdf'],
            ['title' => 'CMO No. 5, Series of 2021 – Policies, Standards and Guidelines for the Bachelor of Science in Accountancy (BSA) Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2021.pdf'],
            ['title' => 'CMO No. 7, Series of 2021 – Extension of Validity Period of Autonomous and Deregulated Status to Private HEIs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-07-s.-2021.pdf'],
            ['title' => 'CMO No. 8, Series of 2021 – Guidelines on the Implementation of the CHED Scholarship Program (CSP) for AY 2021-2022', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2021.pdf'],
            ['title' => 'CMO No. 10, Series of 2021 – List of Priority Programs for CHED Scholarship Programs (CSPs) for AY 2021-2022', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2021.pdf'],
            ['title' => 'CMO No. 11, Series of 2021 – Amendments to Sections 6 and 12 of CMO No. 8, Series of 2019 (CSP Policies)', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-11-s.-2021.pdf'],
            ['title' => 'CMO No. 12, Series of 2021 – Guidelines for the Conduct of Clinical Education for Radiologic Technology Students', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-12-s.-2021.pdf'],
            ['title' => 'CMO No. 15, Series of 2021 – Guidelines for the Support and Development of Medical Schools – Seed Fund for Medicine', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-15-s.-2021.pdf'],
            ['title' => 'CMO No. 16, Series of 2021 – Revised Guidelines for Full-Time SIKAP Grant Scholars', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-16-s.-2021.pdf'],
            ['title' => 'CMO No. 17, Series of 2021 – Revised Guidelines for CHED-Initiated Projects under IDIG Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-17-s.-2021.pdf'],
        ];

        // CHED 2022 Links
        $chedLinks2022 = [
            ['title' => 'CMO No. 1, Series of 2022 – Supplemental Guidelines to CHED-DOH JMC No. 2021-004 on Limited Face-to-Face Classes', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-01-s.-2022.pdf'],
            ['title' => 'CMO No. 2, Series of 2022 – Additional Universities Granted with Autonomous and Deregulated Status', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-02-s.-2022.pdf'],
            ['title' => 'CMO No. 3, Series of 2022 – Updated Guidelines on the Implementation of Flexible Learning in Higher Education', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-03-s.-2022.pdf'],
            ['title' => 'CMO No. 4, Series of 2022 – Safety Seal Certification Program for Higher Education Institutions', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-04-s.-2022.pdf'],
            ['title' => 'CMO No. 5, Series of 2022 – Amendment to Article IV.H. of CHED-DOH JMC No. 2021-004 and Article III.B., Item 12 of CMO No. 01, S. 2022', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-05-s.-2022.pdf'],
            ['title' => 'CMO No. 6, Series of 2022 – Policies, Standards and Guidelines for the BS Tourism Management and BS Hospitality Management Programs', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-06-s.-2022.pdf'],
            ['title' => 'CMO No. 7, Series of 2022 – Policies, Standards and Guidelines for the Bachelor of Science in Architecture (BS Arch) Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-07-s.-2022.pdf'],
            ['title' => 'CMO No. 8, Series of 2022 – Policies, Standards and Guidelines for the Bachelor of Science in Customs Administration (BSCA) Program', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-08-s.-2022.pdf'],
            ['title' => 'CMO No. 9, Series of 2022 – Revised Policies and Guidelines on Local Off-Campus Activities', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-09-s.-2022.pdf'],
            ['title' => 'CMO No. 10, Series of 2022 – Guidelines on the Implementation of the CHED Scholarship Program (CSP) for AY 2022-2023', 'url' => 'https://ched.gov.ph/wp-content/uploads/CMO-No.-10-s.-2022.pdf'],
        ];

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

        // Process 2010 links
        foreach ($chedLinks2010 as $link) {
            $result = ComplianceLink::updateOrCreate(
                [
                    'agency' => 'CHED',
                    'year' => '2010',
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

        $totalAdded = $added2010 + $added2011 + $added2012 + $added2013 + $added2014 + $added2015 + $added2016 + $added2017 + $added2018 + $added2019 + $added2020 + $added2021 + $added2022 + $added2023 + $added2024 + $added2025 + $addedDepEdAcademic + $addedDepEdTechPro + $addedDepEdCore + $addedDepEdShapePaper;
        $totalUpdated = $updated2010 + $updated2011 + $updated2012 + $updated2013 + $updated2014 + $updated2015 + $updated2016 + $updated2017 + $updated2018 + $updated2019 + $updated2020 + $updated2021 + $updated2022 + $updated2023 + $updated2024 + $updated2025 + $updatedDepEdAcademic + $updatedDepEdTechPro + $updatedDepEdCore + $updatedDepEdShapePaper;
        
        $this->command->info("\n🎉 Total: {$totalAdded} links added, {$totalUpdated} links updated");
    }
}
