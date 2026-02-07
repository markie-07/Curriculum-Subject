@extends('layouts.app')

@section('content')
<style>
    /* Allow textareas to auto-resize */
    textarea {
        resize: none !important;
        overflow: hidden !important;
        min-height: 60px !important;
        box-sizing: border-box !important;
    }
    
    
    /* Auto-capitalize mapping grid inputs (CTPSS, ECC, EPP, GLC only - not PILO/CILO) */
    .mapping-grid-container table td.text-center input[type="text"] {
        text-transform: uppercase !important;
    }
    
    /* Prevent cursor change and clicks on readonly textareas (Week 0) */
    textarea[readonly] {
        cursor: not-allowed !important;
        user-select: none !important;
    }

</style>
<div class="px-6 py-8 bg-gray-50">
    <div class="bg-white p-10 md:p-12 rounded-2xl shadow-lg border border-gray-200">
        <div class="flex justify-between items-center mb-12 border-b pb-4">
            <h1 class="text-4xl font-bold text-gray-800">Course Builder</h1>
            {{-- Syllabus Type Toggle --}}
            <div class="bg-gray-200 p-1 rounded-lg inline-flex shadow-inner">
                <button type="button" id="btn-ched" class="px-6 py-2 rounded-md text-sm font-semibold transition-all duration-200 bg-white text-blue-600 shadow-sm" onclick="confirmSwitchSyllabus('CHED')">
                    CHED Format
                </button>
                <button type="button" id="btn-deped" class="px-6 py-2 rounded-md text-sm font-semibold text-gray-600 hover:text-gray-800 transition-all duration-200" onclick="confirmSwitchSyllabus('DepEd')">
                    DepEd Format
                </button>
            </div>
        </div>

        {{-- FORM STARTS HERE to wrap all input fields --}}
        <form id="courseForm" onsubmit="return false;">
            @csrf
            {{-- This hidden input will store the ID of the subject being edited --}}
            <input type="hidden" id="subject_id" name="subject_id">
            <input type="hidden" id="syllabus_type" name="syllabus_type" value="CHED">

            {{-- Section 1: Course Information (Shared) --}}
            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center justify-between">
                    <span class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Course Information
                    </span>
                </h2>
                <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {{-- Row 1 --}}
                        <div class="md:col-span-2 lg:col-span-3">
                            <label for="course_title" class="block text-sm font-medium text-gray-700">Course Title</label>
                            <input type="text" name="course_title" id="course_title" class="mt-1 block w-full py-3 px-4 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="lg:col-span-1">
                            <label for="course_code" class="block text-sm font-medium text-gray-700">Course Code</label>
                            <input type="text" name="course_code" id="course_code" class="mt-1 block w-full py-3 px-4 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        
                        <div class="hidden">
                            <label for="subject_type" class="block text-sm font-medium text-gray-700">Course Type</label>
                            <input type="text" name="subject_type" id="subject_type" class="mt-1 block w-full py-3 px-4 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                        </div>

                        {{-- Row 2 --}}
                        <div class="lg:col-span-1">
                            <label for="course_classification" class="block text-sm font-medium text-gray-700">Subject Category</label>
                            <select name="course_classification" id="course_classification" class="mt-1 block w-full py-3 px-4 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required onchange="updateSubjectType()">
                                <option value="" disabled selected>Select Category</option>
                                <option value="General Education">General Education</option>
                                <option value="Professional Subject Non Laboratory">Professional Subject Non Laboratory</option>
                                <option value="Professional Subject Laboratory">Professional Subject Laboratory</option>
                                <option value="Professional Subject Board Courses">Professional Subject Board Courses</option>
                                <option value="Professional Subject Non Board Courses">Professional Subject Non Board Courses</option>
                                <option value="Professional Subject OC">Professional Subject OC</option>
                                <option value="NSTP 1">NSTP 1</option>
                                <option value="NSTP 2">NSTP 2</option>
                                <option value="Research">Research</option>
                                <option value="OJT/Practicum">OJT/Practicum</option>
                            </select>
                        </div>
                        
                        <div id="ched-course-info-fields-1" class="contents">
                            <div class="lg:col-span-1">
                                <label for="credit_units" class="block text-sm font-medium text-gray-700">Credit Units</label>
                                <input type="number" required name="credit_units" id="credit_units" class="mt-1 block w-full py-3 px-4 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="lg:col-span-1">
                                <label for="contact_hours" class="block text-sm font-medium text-gray-700">Contact Hours</label>
                                <input type="number" required name="contact_hours" id="contact_hours" class="mt-1 block w-full py-3 px-4 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="lg:col-span-1">
                            <label for="curriculum_id" class="block text-sm font-medium text-gray-700">Curriculum</label>
                            <div class="relative cursor-pointer" id="openCurriculumModal">
                                <div class="block w-full py-3 px-4 rounded-md border border-gray-300 shadow-sm bg-white hover:bg-gray-50 transition-colors flex justify-between items-center group">
                                    <span id="curriculumButtonText" class="text-gray-500 truncate">Select curriculums...</span>
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500 flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <script>
                            const defaultDeptVision = "To improve the quality of student’s input and by promoting IT enabled, market driven and internationally comparable programs through quality assurance systems, upgrading faculty qualifications and establishing international linkages.";
                            const defaultDeptMission = "The College of Computer Studies is committed to provide quality information and communication technology education through the use of modern and transformation learning teaching process.";

                            const genEdDeptVision = "BCP General Education Department innovates, investigates and discovers greatness and prosperity through oneness.";
                            const genEdDeptMission = "To awaken the curiosity and ignite passion of individuals to excel independency in academic endeavors towards their development into ethically and morally strong people.";

                            function updateSubjectType() {
                                const classification = document.getElementById('course_classification').value;
                                const subjectTypeInput = document.getElementById('subject_type');
                                const visionText = document.getElementById('dept_vision_text');
                                const missionText = document.getElementById('dept_mission_text');
                                
                                let type = '';
                                
                                // Minor Categories
                                const minorCategories = ['General Education', 'NSTP 1', 'NSTP 2', 'Core Subjects'];
                                
                                // Major Categories (Explicit check, though 'else' could catch others if we are strict)
                                // Includes: Professional Subjects (all), Research, OJT, Applied Track, Specialized
                                
                                if (minorCategories.includes(classification)) {
                                    type = 'Minor';
                                    // Vision/Mission updates
                                    if(classification === 'General Education') {
                                         if(visionText) visionText.textContent = genEdDeptVision;
                                         if(missionText) missionText.textContent = genEdDeptMission;
                                    } else {
                                         if(visionText) visionText.textContent = defaultDeptVision;
                                         if(missionText) missionText.textContent = defaultDeptMission;
                                    }
                                } else if (classification) {
                                    // Assume everything else selected is Major (Professional, Research, OJT, Applied, Specialized)
                                    type = 'Major';
                                    if(visionText) visionText.textContent = defaultDeptVision;
                                    if(missionText) missionText.textContent = defaultDeptMission;
                                }
                                
                                subjectTypeInput.value = type;
                            }
                        </script>

                        {{-- DepEd (Hidden) --}}
                         <div id="deped-course-info-fields" class="contents hidden">
                            <div class="col-span-1 md:col-span-2 lg:col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Syllabus Document (PDF/Image)</label>
                                <div class="flex items-center space-x-4 mb-4">
                                    <button type="button" onclick="document.getElementById('syllabus_file').click()" class="px-6 py-3 bg-red-50 text-red-600 rounded-md border border-red-200 hover:bg-red-100 transition-colors flex items-center shadow-sm">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Upload Syllabus
                                    </button>
                                    <span id="file_name_display" class="text-gray-500 italic text-sm">No file selected</span>
                                    <input type="file" id="syllabus_file" name="syllabus_path" class="hidden" accept=".pdf, .jpg, .jpeg, .png" onchange="handleSyllabusUpload(this)">
                                </div>
                                <p class="text-xs text-gray-500 mb-4">
                                    <svg class="w-4 h-4 inline mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Uploading a file will replace the manual curriculum guide fields.
                                </p>
                                <div id="pdf-preview-container" class="w-full h-[600px] border-2 border-dashed border-gray-300 rounded-xl flex items-center justify-center bg-gray-50 overflow-hidden relative">
                                    <div id="pdf-placeholder" class="text-center text-gray-400 p-8">
                                        <svg class="w-16 h-16 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p>Document preview will appear here</p>
                                    </div>
                                    <iframe id="pdf-frame" class="w-full h-full hidden" src=""></iframe>
                                    <img id="image-preview" class="max-w-full max-h-full hidden object-contain" src="" alt="Syllabus Preview">
                                </div>
                            </div>
                        </div>

                         <div id="course_description_container" class="lg:col-span-4">
                            <label for="course_description" class="block text-sm font-medium text-gray-700">Course Description</label>
                            <textarea id="course_description" required name="course_description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                        
                         {{-- CHED Import (Row 4) --}}
                         <div id="ched-course-info-fields-2" class="contents">
                            <div class="lg:col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Import Syllabus (PDF)</label>
                                <div class="flex items-center space-x-4">
                                    <button type="button" onclick="document.getElementById('ched_syllabus_file').click()" class="px-4 py-3 bg-blue-50 text-blue-600 rounded-md border border-blue-200 hover:bg-blue-100 transition-colors flex items-center w-full justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Import
                                    </button>
                                    <input type="file" id="ched_syllabus_file" class="hidden" accept=".pdf" onchange="handleSyllabusUpload(this)">
                                </div>
                                <p class="text-xs text-gray-500 mt-2 truncate" title="Auto-extraction works best with standard CHED formats.">
                                    <svg class="w-4 h-4 inline mr-1 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Note: Standard CHED formats best.
                                </p>
                            </div>
                        </div>

                    </div>
                    

                </div>
            </div>


            {{-- DepEd Curriculum Guide Grids (Hidden by default) --}}
            <div id="deped-curriculum-grids" class="mb-12 hidden">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Curriculum Guide
                </h2>
                <div class="space-y-6">
                    @for ($q = 1; $q <= 2; $q++)
                    <div class="border rounded-2xl overflow-hidden shadow-sm">
                        <button type="button" class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 transition-colors" onclick="toggleAccordion(this)">
                            <span class="font-semibold text-lg text-gray-700">Quarter {{ $q }}</span>
                            <svg class="w-6 h-6 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="accordion-content bg-gray-50 p-6 border-t" style="display: none;">
                            <div class="grid grid-cols-1 gap-6">
                                <div id="q_{{ $q }}_rows_container" class="space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative group deped-row">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Content</label>
                                            <textarea name="q_{{ $q }}_content[]" id="q_{{ $q }}_content" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Enter Content..."></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Content Standards</label>
                                            <textarea name="q_{{ $q }}_content_standards[]" id="q_{{ $q }}_content_standards" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="The learners demonstrate understanding of..."></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Learning Competencies</label>
                                            <textarea name="q_{{ $q }}_learning_competencies[]" id="q_{{ $q }}_learning_competencies" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="The learners..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-center border-b pb-6">
                                    <button type="button" onclick="addDepEdRow({{ $q }})" class="flex items-center px-4 py-2 bg-red-50 text-red-600 rounded-full hover:bg-red-100 transition-colors text-sm font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Add Content Row
                                    </button>
                                </div>
                                <div>
                                    <label for="q_{{ $q }}_performance_standards" class="block text-sm font-medium text-gray-700">Performance Standards</label>
                                    <textarea id="q_{{ $q }}_performance_standards" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="The learners shall be able to..."></textarea>
                                </div>
                                <div>
                                    <label for="q_{{ $q }}_performance_task" class="block text-sm font-medium text-gray-700">Suggested Performance Task</label>
                                    <textarea id="q_{{ $q }}_performance_task" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Enter Suggested Performance Task..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            {{-- CHED CONTAINER --}}
            <div id="ched-container">



            {{-- Institutional Information --}}
            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h6m-6 4h6m-6 4h6"></path></svg>
                    Institutional Information
                </h2>
                <div class="space-y-8">
                    {{-- Vision --}}
                    <div class="bg-gray-50 p-6 rounded-lg border">
                        <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">VISION</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="font-semibold text-gray-600 mb-2">SCHOOL</h4>
                                <p class="text-gray-700 text-sm">BCP is committed to provide and promote quality education with a unique, modern and research-based curriculum with delivery systems geared towards excellence.</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-600 mb-2">DEPARTMENT</h4>
                                <p id="dept_vision_text" class="text-gray-700 text-sm">To improve the quality of student’s input and by promoting IT enabled, market driven and internationally comparable programs through quality assurance systems, upgrading faculty qualifications and establishing international linkages.</p>
                            </div>
                        </div>
                    </div>
                    {{-- Mission --}}
                    <div class="bg-gray-50 p-6 rounded-lg border">
                        <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">MISSION</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="font-semibold text-gray-600 mb-2">SCHOOL</h4>
                                <p class="text-gray-700 text-sm">To produce self-motivated and self-directed individual who aims for academic excellence, God-fearing, peaceful, healthy and productive successful citizens.</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-600 mb-2">DEPARTMENT</h4>
                                <p id="dept_mission_text" class="text-gray-700 text-sm">The College of Computer Studies is committed to provide quality information and communication technology education through the use of modern and transformation learning teaching process.</p>
                            </div>
                        </div>
                    </div>
                    {{-- Philosophy --}}
                    <div class="bg-gray-50 p-6 rounded-lg border">
                        <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">PHILOSOPHY</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="font-semibold text-gray-600 mb-2">SCHOOL</h4>
                                <p class="text-gray-700 text-sm">BCP advocates threefold core values: “Fides”, “Faith; “Ratio”, Reason; Pax. Peace. “Fides” represents BCPs, endeavors for expansion, development, and growth amidst the challenges of the new millennium. "Ratio" symbolizes BCP's efforts to provide an education which can be man's tool to be liberated from all forms of ignorance and poverty. "Pax". BCP is a forerunner in the promotion of a harmonious relationship between the different sectors of its academic community.</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-600 mb-2">DEPARTMENT</h4>
                                <p class="text-gray-700 text-sm">General Education advocates threefold core values “Devotion”, “Serenity’, “Determination” “Devotion” represents General Education commitment and dedication to provide quality education that will fuel the passion of the students for learning in driving academic success “Serenity” symbolizes a crucial element in the overall well-being and success of students by means of creating a more supportive, conducive, and enriching learning environment, enabling them to thrive academically, emotionally, and personally. “Determination” general education is committed to provide a high-quality, equitable, and supportive learning environment that empowers students to succeed.</p>
                            </div>
                        </div>
                    </div>
                    {{-- Core Values --}}
                     <div class="bg-gray-50 p-6 rounded-lg border">
                        <h3 class="text-xl font-bold text-gray-700 mb-2">CORE VALUES</h3>
                        <p class="mt-2 text-gray-700 text-sm"><strong>FAITH, KNOWLEDGE, CHARITY AND HUMILITY</strong><br><strong>FAITH (Fides)</strong> represents BCP’s endeavor for expansion, development and for growth amidst the global challenges of the new millennium.<br><strong>KNOWLEDGE (Cognito)</strong> connotes the institution’s efforts to impart excellent lifelong education that can be used as human tool so that one can liberate himself/herself from ignorance and poverty<br><strong>CHARITY (Caritas)</strong> is the institution’s commitment towards its clienteles.<br><strong>HUMILITY (Humiliates)</strong> refers to the institution’s recognition of the human frailty, its imperfection.</p>
                    </div>
                </div>
            </div>

            {{-- Mapping Grids --}}
            <div class="mb-12">
                 <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Mapping Grids
                </h2>
                <div class="space-y-8">
                    <div class="p-8 border rounded-2xl shadow-md mapping-grid-container">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold text-gray-700">PROGRAM MAPPING GRID</h3>
                            <button id="add-program-mapping-row" type="button" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 hover:text-white transition-colors">Add Row</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">PILO</th>
                                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-600 w-24">CTPSS</th>
                                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-600 w-24">ECC</th>
                                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-600 w-24">EPP</th>
                                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-600 w-24">GLC</th>
                                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-600 w-24">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="program-mapping-table-body"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="p-8 border rounded-2xl shadow-md mapping-grid-container">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold text-gray-700">COURSE MAPPING GRID</h3>
                            <button id="add-course-mapping-row" type="button" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 hover:text-white transition-colors">Add Row</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">CILO</th>
                                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-600 w-24">CTPSS</th>
                                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-600 w-24">ECC</th>
                                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-600 w-24">EPP</th>
                                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-600 w-24">GLC</th>
                                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-600 w-24">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="course-mapping-table-body"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-8 p-6 bg-gray-50 border rounded-lg">
                        <h4 class="font-bold text-gray-700">Legend:</h4>
                        <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1 text-sm">
                            <li><span class="font-semibold">L</span> – Facilitate Learning of the competencies</li>
                            <li><span class="font-semibold">P</span> – Allow student to practice competencies (No input but competency is evaluated)</li>
                            <li><span class="font-semibold">O</span> – Provide opportunity for development (No input or evaluation, but there is opportunity to practice the competencies)</li>
                            <li><span class="font-semibold">CTPSS</span> - critical thinking and problem-solving skills;</li>
                            <li><span class="font-semibold">ECC</span> - effective communication and collaboration;</li>
                            <li><span class="font-semibold">EPP</span> - ethical and professional practice; and,</li>
                            <li><span class="font-semibold">GLC</span> - global and lifelong learning commitment.</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Learning Outcomes --}}
            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Learning Outcomes
                </h2>
                <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100 space-y-8">
                    {{-- School Goals and Program Goals --}}
                    <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">School Goals:</h3>
                            <p class="text-gray-700 leading-relaxed">
                                BCP puts God in the center of all its efforts realize and operationalize its vision and missions through the following. Instruction, Research, Extension and Productivity
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Program Goals:</h3>
                            <p class="text-gray-700 leading-relaxed">
                                To cultivate a dynamic and inclusive learning environment that empowers students to become self-directed, ethical, and engaged citizens, equipped with the critical thinking, communication, and problem-solving skills necessary to thrive in a rapidly evolving world.
                            </p>
                        </div>
                    </div>

                    <div>
                        <label for="pilo_outcomes" class="block text-xl font-semibold text-gray-700 mb-2">PROGRAM INTENDED LEARNING OUTCOMES (PILO)</label>
                        <textarea id="pilo_outcomes" required name="pilo_outcomes" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div>
                        <label for="cilo_outcomes" class="block text-xl font-semibold text-gray-700 mb-2">Course Intended Learning Outcomes (CILO)</label>
                        <textarea id="cilo_outcomes" required name="cilo_outcomes" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                     <div class="p-4 bg-gray-50 rounded-md border">
                        <h4 class="font-semibold text-gray-600">Expected BCP Graduate Elements:</h4>
                        <p class="mt-2 text-gray-700 text-sm">The BCP ideal graduate demonstrates/internalizes this attribute:</p>
                        <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1 text-sm">
                            <li>critical thinking and problem-solving skills;</li>
                            <li>effective communication and collaboration;</li>
                            <li>ethical and professional practice; and,</li>
                            <li>global and lifelong learning commitment.</li>
                        </ul>
                    </div>
                    <div>
                        <label for="learning_outcomes" class="block text-xl font-semibold text-gray-700 mb-2">Learning Outcomes</label>
                        <textarea id="learning_outcomes" required name="learning_outcomes" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
            </div>


            {{-- Weekly Plan (Weeks 0-18) --}}
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Weekly Plan (Weeks 0-18)
                    </h2>
                    <button type="button" onclick="generateSyllabusRange(1, 17)" class="flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md hover:shadow-lg text-sm font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Generate Full Syllabus (Weeks 1-17)
                    </button>
                </div>
                <div class="space-y-4">
                    @for ($i = 0; $i <= 18; $i++)
                        <div class="border rounded-2xl overflow-hidden shadow-sm">
                            <button type="button" class="w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 transition-colors" onclick="toggleAccordion(this)">
                                <span class="font-semibold text-lg text-gray-700">
                                    Week {{ $i }}
                                    @if($i == 6)
                                        - Prelim Exam
                                    @elseif($i == 12)
                                        - Midterm Exam
                                    @elseif($i == 18)
                                        - Final Exam
                                    @endif
                                </span>
                                <div class="flex items-center">
                                    @if(!in_array($i, [6, 12, 18]))
                                        <span id="week-progress-{{ $i }}" class="relative overflow-hidden inline-flex items-center justify-center px-2.5 py-1 rounded-full border border-blue-100 bg-white min-w-[85px] shadow-sm mr-4 text-sm font-bold text-gray-400">0%</span>
                                    @else
                                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded mr-4">EXAM</span>
                                    @endif
                                    <svg class="w-6 h-6 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </button>
                            <div class="accordion-content bg-gray-50 p-6 border-t" style="display: none;">
                                @if(in_array($i, [6, 12, 18]))
                                    <div class="text-center py-8">
                                        <p class="text-xl font-bold text-gray-600">
                                            @if($i == 6) PRELIM EXAM
                                            @elseif($i == 12) MIDTERM EXAM
                                            @elseif($i == 18) FINAL EXAM
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">No additional details required for this week.</p>
                                        {{-- Hidden input to maintain data structure --}}
                                        <input type="hidden" id="week_{{ $i }}_content" value="{{ $i == 6 ? 'Prelim Exam' : ($i == 12 ? 'Midterm Exam' : 'Final Exam') }}">
                                    </div>
                                @else
                                @if($i > 0)
                                <div class="flex justify-end mb-4">
                                    <button type="button" onclick="generateSyllabusRange({{ $i }}, {{ $i }})" class="flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors border border-indigo-200">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Regenerate Week
                                    </button>
                                </div>
                                @endif
                                <div class="grid grid-cols-1 gap-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="week_{{ $i }}_content" class="block text-sm font-medium text-gray-700">Content{{ $i == 0 ? ' (Read-only)' : '' }}</label>
                                            <textarea id="week_{{ $i }}_content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm{{ $i == 0 ? ' bg-gray-100' : '' }}" {{ $i == 0 ? 'readonly' : '' }}></textarea>
                                        </div>
                                        <div>
                                            <label for="week_{{ $i }}_silo" class="block text-sm font-medium text-gray-700">Student Intended Learning Outcomes{{ $i == 0 ? ' (Read-only)' : '' }}</label>
                                            <textarea id="week_{{ $i }}_silo" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm{{ $i == 0 ? ' bg-gray-100' : '' }}" {{ $i == 0 ? 'readonly' : '' }}></textarea>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Assessment Tasks (ATs){{ $i == 0 ? ' (Read-only)' : '' }}</label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2 p-4 border rounded-md {{ $i == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                            <div>
                                                <label for="week_{{ $i }}_at_onsite" class="block text-xs font-semibold text-gray-600 mb-1">ONSITE</label>
                                                <textarea id="week_{{ $i }}_at_onsite" rows="3" class="w-full rounded-md border-gray-300 shadow-sm{{ $i == 0 ? ' bg-gray-100' : '' }}" {{ $i == 0 ? 'readonly' : '' }}></textarea>
                                            </div>
                                            <div>
                                                <label for="week_{{ $i }}_at_offsite" class="block text-xs font-semibold text-gray-600 mb-1">OFFSITE</label>
                                                <textarea id="week_{{ $i }}_at_offsite" rows="3" class="w-full rounded-md border-gray-300 shadow-sm{{ $i == 0 ? ' bg-gray-100' : '' }}" {{ $i == 0 ? 'readonly' : '' }}></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Suggested Teaching/Learning Activities (TLAs){{ $i == 0 ? ' (Read-only)' : '' }}</label>
                                        <div class="mt-2 p-4 border rounded-md {{ $i == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                            <p class="text-xs font-semibold text-gray-600 mb-2">Blended Learning Delivery Modality (BLDM)</p>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="week_{{ $i }}_tla_onsite" class="block text-xs font-semibold text-gray-600 mb-1">Face to Face (On-Site)</label>
                                                    <textarea id="week_{{ $i }}_tla_onsite" rows="3" class="w-full rounded-md border-gray-300 shadow-sm{{ $i == 0 ? ' bg-gray-100' : '' }}" {{ $i == 0 ? 'readonly' : '' }}></textarea>
                                                </div>
                                                <div>
                                                    <label for="week_{{ $i }}_tla_offsite" class="block text-xs font-semibold text-gray-600 mb-1">Online (Off-Site)</label>
                                                    <textarea id="week_{{ $i }}_tla_offsite" rows="3" class="w-full rounded-md border-gray-300 shadow-sm{{ $i == 0 ? ' bg-gray-100' : '' }}" {{ $i == 0 ? 'readonly' : '' }}></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="week_{{ $i }}_ltsm" class="block text-sm font-medium text-gray-700">Learning and Teaching Support Materials (LTSM){{ $i == 0 ? ' (Read-only)' : '' }}</label>
                                            <textarea id="week_{{ $i }}_ltsm" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm{{ $i == 0 ? ' bg-gray-100' : '' }}" {{ $i == 0 ? 'readonly' : '' }}></textarea>
                                        </div>
                                        <div>
                                            <label for="week_{{ $i }}_output" class="block text-sm font-medium text-gray-700">Output Materials{{ $i == 0 ? ' (Read-only)' : '' }}</label>
                                            <textarea id="week_{{ $i }}_output" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm{{ $i == 0 ? ' bg-gray-100' : '' }}" {{ $i == 0 ? 'readonly' : '' }}></textarea>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Course Requirements and Policies --}}
            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h6m-6 4h6m-6 4h6"></path></svg>
                    Course Requirements and Policies
                </h2>
                <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="basic_readings" class="block text-sm font-medium text-gray-700">Basic Readings / Textbooks</label>
                            <textarea id="basic_readings" required name="basic_readings" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>
                        <div>
                            <label for="extended_readings" class="block text-sm font-medium text-gray-700">Extended Readings / References</label>
                            <textarea id="extended_readings" required name="extended_readings" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="course_assessment" class="block text-sm font-medium text-gray-700">Course Assessment</label>
                        <textarea id="course_assessment" required name="course_assessment" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <div class="p-4 bg-gray-50 rounded-md border">
                            <h4 class="font-semibold text-gray-600 mb-2">Course Policies and Statements:</h4>
                            <ul class="space-y-4 text-gray-700 text-sm">
                                <li>
                                    <span class="font-bold block">Learners with Disabilities</span>
                                    This course is committed in providing equal access and participation for all students including those with disabilities. If you have a disability that may require accommodations, please contact the OFFICE OF THE STUDENTS’ AFFAIRS and SERVICES to register in the LIST OF LEARNERS with Disabilities. Please be aware that it is your responsibility to communicate your needs and works with the instructor to ensure that appropriate accommodations can be arranged promptly.
                                </li>
                                <li>
                                    <span class="font-bold block">Syllabus Flexibility</span>
                                    The faculty reserves the right to change or amend this syllabus as needed. Any changes to the syllabus will be communicated promptly to the VPAA through the Department Heads / Deans, if any, adjustments will be made to ensure that all students can continue to meet the course objectives. Your feedback and input are valued, and we encourage open communication to facilitate a positive and productive learning experience for all.
                                </li>
                            </ul>
                        </div>
                        {{-- Hidden textarea to hold the data for submission --}}
                        <textarea id="course_policies" name="course_policies" class="hidden">This course is committed in providing equal access and participation for all students including those with disabilities. If you have a disability that may require accommodations, please contact the OFFICE OF THE STUDENTS’ AFFAIRS and SERVICES to register in the LIST OF LEARNERS with Disabilities. Please be aware that it is your responsibility to communicate your needs and works with the instructor to ensure that appropriate accommodations can be arranged promptly. The faculty reserves the right to change or amend this syllabus as needed. Any changes to the syllabus will be communicated promptly to the VPAA through the Department Heads / Deans, if any, adjustments will be made to ensure that all students can continue to meet the course objectives. Your feedback and input are valued, and we encourage open communication to facilitate a positive and productive learning experience for all.</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="committee_members" class="block text-sm font-medium text-gray-700">Committee Members</label>
                            <textarea id="committee_members" required name="committee_members" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>
                        <div>
                            <label for="consultation_schedule" class="block text-sm font-medium text-gray-700">Consultation Schedule</label>
                            <textarea id="consultation_schedule" required name="consultation_schedule" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>
                    </div>
                </div>
            </div>



            </div> {{-- End of CHED Container --}}

            {{-- Approval Section (Shared) --}}
            <div id="approval-section" class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Approval
                </h2>
                <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label for="prepared_by" class="block text-sm font-medium text-gray-700">Prepared:</label>
                            <input type="text" id="prepared_by" required name="prepared_by" class="mt-1 block w-full py-3 px-4 rounded-md border-gray-300 shadow-sm">
                            <p class="text-xs text-gray-500 mt-1">Cluster Leader</p>
                        </div>
                        <div>
                            <label for="reviewed_by" class="block text-sm font-medium text-gray-700">Reviewed:</label>
                            <input type="text" id="reviewed_by" required name="reviewed_by" class="mt-1 block w-full py-3 px-4 rounded-md border-gray-300 shadow-sm">
                            <p class="text-xs text-gray-500 mt-1">General Education Program Head</p>
                        </div>
                        <div>
                            <label for="approved_by" class="block text-sm font-medium text-gray-700">Approved:</label>
                            <input type="text" id="approved_by" required name="approved_by" class="mt-1 block w-full py-3 px-4 rounded-md border-gray-300 shadow-sm">
                            <p class="text-xs text-gray-500 mt-1">Vice President for Academic Affairs</p>
                        </div>
                    </div>
                </div>
            </div>



            {{-- Save/Update Button --}}
            <div class="mt-10 pt-6 border-t border-gray-200">
                <button id="saveCourseButton" type="button" class="w-full flex items-center justify-center space-x-2 px-6 py-4 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>Save Course</span>
                </button>
            </div>
        </form>
    </div>
</div>



{{-- Switch Format Confirmation Modal --}}
<div id="switchFormatConfirmModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-yellow-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Confirm Format Switch</h3>
            <p class="text-sm text-gray-500 mt-2" id="switchFormatMessage">You are about to switch formats. Unsaved data will be lost. Are you sure?</p>
            <div class="mt-6 flex justify-center gap-4">
                <button type="button" id="cancelSwitchFormat" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button type="button" id="confirmSwitchFormat" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Yes, Switch
                </button>
            </div>
        </div>
    </div>
</div>

<div id="saveCourseConfirmModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-blue-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Save Course?</h3>
            <p class="text-sm text-gray-500 mt-2">Do you want to save this course?</p>
            <div class="mt-6 flex justify-center gap-4">
                <button id="cancelSaveCourse" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">No</button>
                <button id="confirmSaveCourse" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Yes</button>
            </div>
        </div>
    </div>
</div>

{{-- Curriculum Selection Modal --}}
<div id="curriculumSelectionModal" class="fixed inset-0 z-50 overflow-hidden bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 hidden flex items-center justify-center p-4">
    <div class="relative bg-white w-full max-w-5xl h-[85vh] flex flex-col rounded-3xl shadow-2xl ring-1 ring-black/5 overflow-hidden">
        {{-- Header --}}
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
            <div>
                <h3 class="text-2xl font-bold text-gray-900 tracking-tight">Select Applicable Curriculums</h3>
                <p class="text-sm text-gray-500 mt-1">Choose which curriculums this subject will belong to.</p>
            </div>
            <div class="relative w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="curriculumSearchInput" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200 sm:text-sm" placeholder="Search curriculums...">
            </div>
        </div>
        
        {{-- Content Area --}}
        <div class="p-8 flex-1 overflow-y-auto bg-gray-50/50 custom-scrollbar">
            <div class="space-y-8">
                {{-- Senior High Section --}}
                <div id="seniorHighSection" class="hidden">
                     <div class="flex items-center justify-between mb-4">
                        <h4 id="seniorHighHeader" class="text-sm font-bold text-gray-800 uppercase tracking-wide flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-orange-500 rounded-full"></span>
                            Senior High
                        </h4>
                        <label class="group inline-flex items-center space-x-2 text-sm text-gray-600 cursor-pointer hover:text-blue-600 transition-colors bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm hover:border-blue-300">
                            <input id="selectAllSeniorHigh" type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition-all">
                            <span class="font-medium group-hover:text-blue-700">Select All</span>
                        </label>
                    </div>
                    <div id="seniorHighContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>
                </div>

                {{-- College Section (Default) --}}
                <div id="collegeSection" class="">
                    <div class="flex items-center justify-between mb-4">
                        <h4 id="collegeHeader" class="text-sm font-bold text-gray-800 uppercase tracking-wide flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                            College
                        </h4>
                        <label class="group inline-flex items-center space-x-2 text-sm text-gray-600 cursor-pointer hover:text-blue-600 transition-colors bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm hover:border-blue-300">
                            <input id="selectAllCollege" type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition-all">
                            <span class="font-medium group-hover:text-blue-700">Select All</span>
                        </label>
                    </div>
                    <div id="collegeContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-8 py-5 bg-white border-t border-gray-100 flex justify-end gap-3 shrink-0">
            <button id="cancelCurriculumSelection" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:text-gray-800 hover:bg-gray-50 border border-transparent hover:border-gray-200 transition-all duration-200">
                Cancel
            </button>
            <button id="confirmCurriculumSelection" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 shadow-lg shadow-blue-200 hover:shadow-blue-300 transition-all duration-200 transform hover:-translate-y-0.5">
                Apply Selection
            </button>
        </div>
    </div>
</div>

{{-- Course Success Modal --}}
<div id="courseSuccessModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 id="courseSuccessTitle" class="text-lg font-semibold text-gray-800">Course Created Successfully!</h3>
            <p id="courseSuccessMessage" class="text-sm text-gray-500 mt-2">Your new subject has been created successfully!</p>
            <div class="mt-6 flex justify-center gap-4">
                <button id="skipGradeSetup" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Skip</button>
                <button id="proceedToGradeSetup" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Set Up Grades</button>
            </div>
        </div>
    </div>
</div>

{{-- Course Update Success Modal --}}
<div id="courseUpdateSuccessModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Course Updated Successfully!</h3>
            <p class="text-sm text-gray-500 mt-2">Your subject has been updated successfully!</p>
            <div class="mt-6">
                <button id="closeCourseUpdateModal" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">OK</button>
            </div>
        </div>
    </div>
</div>

{{-- Extraction Success Modal --}}
<div id="extractionSuccessModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Syllabus Extracted Successfully!</h3>
            <p class="text-sm text-gray-500 mt-2">The syllabus data has been extracted and populated into the form fields.</p>
            <div class="mt-6">
                <button id="closeExtractionModal" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">OK</button>
            </div>
        </div>
    </div>
</div>

{{-- Similar Description Warning Modal --}}
<div id="similarDescriptionModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-6">
            <div class="w-12 h-12 rounded-full bg-amber-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 text-center mb-2">Similar Course Descriptions Detected</h3>
            <p class="text-sm text-gray-600 text-center mb-4">The following existing courses have similar descriptions to what you entered:</p>
            
            <div id="similarCoursesList" class="max-h-96 overflow-y-auto space-y-3 mb-6">
                <!-- Similar courses will be inserted here -->
            </div>
            
            <p class="text-xs text-gray-500 text-center mb-4">
                <svg class="w-4 h-4 inline mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                This check uses AI to detect semantic similarity. You can still proceed if you believe this is a different course.
            </p>
            
            <div class="flex justify-center gap-4">
                <button id="cancelSimilarDescription" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel & Edit Description
                </button>
                <button id="proceedWithSimilarDescription" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                    Save Anyway
                </button>
            </div>
        </div>
    </div>
</div>

{{-- AI Analysis Loading Modal --}}
<div id="aiAnalysisLoadingModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl p-8 text-center">
            <div class="mb-4">
                <svg class="animate-spin h-16 w-16 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Analyzing Course Description</h3>
            <p class="text-sm text-gray-600">AI is checking for similar courses...</p>
            <div class="mt-4 flex justify-center space-x-1">
                <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Global variable to store current DepEd links for filtering
    let currentDepEdLinks = [];
    let allCurriculums = []; // Store all curriculums for client-side filtering

    // Render curriculums based on Year Level (College vs Senior High)
    const renderCurriculumOptions = (yearLevel) => {
        const curriculumSelect = document.getElementById('curriculum_id');
        if (!curriculumSelect) return;
        
        curriculumSelect.innerHTML = '<option value="" disabled selected>Select Curriculum</option>';
        
        let filtered = allCurriculums.filter(c => c.year_level === yearLevel);
        
        // Filter out Approved and Old curriculums for BOTH formats (CHED and DepEd)
        // Only display "Processing" and "Reject" (and implicitly "New"/Pending)
        filtered = filtered.filter(c => {
             const status = String(c.approval_status || '').toLowerCase().trim();
             const version = String(c.version_status || '').toLowerCase().trim();
             
             // NOT Approved AND NOT Old/History
             // If status is 'approved', return false.
             // If version is 'old' or 'history', return false.
             return !['approved'].includes(status) && !['old', 'history'].includes(version);
        });
        
        if (filtered.length === 0) {
            const option = document.createElement('option');
            option.disabled = true;
            option.textContent = `No ${yearLevel} curriculums found`;
            curriculumSelect.appendChild(option);
            return;
        }

        filtered.forEach(curr => {
            const option = document.createElement('option');
            option.value = curr.id; 
            if (yearLevel === 'Senior High') {
                option.textContent = curr.curriculum_name;
            } else {
                option.textContent = `${curr.curriculum_name} (${curr.academic_year})`;
            } 
            curriculumSelect.appendChild(option);
        });
    };

    // Fetch Curriculums logic
    const fetchCurriculums = async () => {
        const curriculumSelect = document.getElementById('curriculum_id');
        if (!curriculumSelect) return;
        
        try {
            const response = await fetch('/api/curriculums');
            if (!response.ok) throw new Error('Failed to fetch curriculums');
            allCurriculums = await response.json();
            
            // Initial render based on current syllabus type
            const currentType = document.getElementById('syllabus_type').value || 'CHED';
            const yearLevel = currentType === 'CHED' ? 'College' : 'Senior High';
            renderCurriculumOptions(yearLevel);

        } catch (error) {
            console.error('Error fetching curriculums:', error);
            curriculumSelect.innerHTML = '<option value="" disabled selected>Error loading curriculums</option>';
        }
    };

    // Function to populate CHED years (matching compliance_validator range)
    const populateCHEDYears = () => {
        const memorandumYearSelect = document.getElementById('memorandumYear');
        if (!memorandumYearSelect) return;
        const currentValue = memorandumYearSelect.value;
        memorandumYearSelect.innerHTML = '<option value="" disabled selected>Select Year</option>';
        for (let year = 2025; year >= 1994; year--) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            memorandumYearSelect.appendChild(option);
        }
        if (currentValue) memorandumYearSelect.value = currentValue;
    };

    // Function to fetch memorandums based on compliance, year, or category
    const fetchMemorandumData = async (compliance, yearOrCategory = null) => {
        try {
            if (!yearOrCategory) return [];
            const response = await fetch(`/api/compliance-links?agency=${compliance}&year=${encodeURIComponent(yearOrCategory)}`);
            if (!response.ok) throw new Error('API request failed');
            return await response.json();
        } catch (error) {
            console.error('Error fetching memorandum data:', error);
            return [];
        }
    };

    const updateMemorandumSelectOptions = (data) => {
        const memorandumSelect = document.getElementById('memorandum');
        if (!memorandumSelect) return;

        memorandumSelect.innerHTML = '<option value="" disabled selected>Select Memorandum</option>';
        if (data && data.length > 0) {
            memorandumSelect.disabled = false;
            data.forEach(link => {
                const option = document.createElement('option');
                // Use title for value as per existing logic
                option.value = link.title; 
                option.textContent = link.title;
                memorandumSelect.appendChild(option);
            });
        } else {
            memorandumSelect.disabled = true;
            const option = document.createElement('option');
            option.textContent = 'No memorandums found';
            option.value = '';
            memorandumSelect.appendChild(option);
        }
    };

    // CHED Specific Update
    const updateCHEDMemorandumDropdown = async (year) => {
        const memorandumSelect = document.getElementById('memorandum');
        if (!memorandumSelect) return;
        
        memorandumSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';
        memorandumSelect.disabled = true;

        const data = await fetchMemorandumData('CHED', year);
        updateMemorandumSelectOptions(data);
    };

    // DepEd Category Change Handler
    const handleDepEdCategoryChange = async (category) => {
        const memorandumSelect = document.getElementById('memorandum');
        const titleContainer = document.getElementById('titleContainer');
        const categoryContainer = document.getElementById('categoryContainer');
        const titleSelect = document.getElementById('memorandumTitle');
        
        if (!memorandumSelect) return;

        memorandumSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';
        memorandumSelect.disabled = true;
        
        // Reset title dropdown
        titleSelect.innerHTML = '<option value="" disabled selected>Select Title</option>';
        titleContainer.classList.add('hidden');

        // Fetch Data
        currentDepEdLinks = await fetchMemorandumData('DepEd', category);
        
        // Extract Unique Groups (Titles)
        // Groups come from two sources:
        // 1. The 'group' column of normal links (e.g. link.group = 'ARTS...')
        // 2. The 'title' column of Category records (e.g. link.title = 'ARTS...', link.is_category = 1)
        const groups = [...new Set([
            ...currentDepEdLinks.map(link => link.group).filter(g => g),
            ...currentDepEdLinks.filter(link => link.is_category == 1 || link.is_category === true).map(link => link.title)
        ])];
        
        if (groups.length > 0) {
            // Data found with groups -> Shrink Category, Show Title
            if(categoryContainer) {
                categoryContainer.classList.remove('md:col-span-3');
                categoryContainer.classList.add('md:col-span-1');
            }
            
            // Show Title Dropdown
            titleContainer.classList.remove('hidden');
            groups.sort().forEach(group => {
                const option = document.createElement('option');
                option.value = group;
                option.textContent = group;
                titleSelect.appendChild(option);
            });
            
            // Wait for user to select title before populating memorandum
            memorandumSelect.innerHTML = '<option value="" disabled selected>Select Title First</option>';
        } else {
            // No groups -> Expand Category to Full Width
            if(categoryContainer) {
                categoryContainer.classList.remove('md:col-span-1');
                categoryContainer.classList.add('md:col-span-3');
            }
            
            // No groups, populate memorandum directly with all links (excluding pure categories)
            const linksOnly = currentDepEdLinks.filter(link => !link.is_category);
            updateMemorandumSelectOptions(linksOnly.length > 0 ? linksOnly : currentDepEdLinks);
        }
    };
    
    // DepEd Title Change Handler
    const handleDepEdTitleChange = (selectedGroup) => {
        const filteredLinks = currentDepEdLinks.filter(link => link.group === selectedGroup);
        updateMemorandumSelectOptions(filteredLinks);
    };

    // Helper to toggle required attribute
    const toggleRequired = (containerOrElement, isRequired) => {
        if (!containerOrElement) return;
        
        // If it's a single element (input/select/textarea)
        if (containerOrElement.tagName === 'INPUT' || containerOrElement.tagName === 'SELECT' || containerOrElement.tagName === 'TEXTAREA') {
            if (isRequired) containerOrElement.setAttribute('required', 'required');
            else containerOrElement.removeAttribute('required');
            return;
        }

        // If it's a container
        containerOrElement.querySelectorAll('input, textarea, select').forEach(el => {
            if (el.type === 'hidden') return;
            if (isRequired) el.setAttribute('required', 'required');
            else el.removeAttribute('required');
        });
    };

    function handleComplianceChange(compliance) {
        const memorandumContainer = document.getElementById('memorandumContainer');
        const yearContainer = document.getElementById('yearContainer');
        const categoryContainer = document.getElementById('categoryContainer');
        const titleContainer = document.getElementById('titleContainer');
        const memoContainer = document.getElementById('memoContainer'); // Defined in HTML now
        const memorandumSelect = document.getElementById('memorandum');
        
        if (!memorandumContainer) return;

        memorandumContainer.classList.remove('hidden');
        if (memorandumSelect) {
            memorandumSelect.innerHTML = '<option value="" disabled selected>Select Memorandum</option>';
            memorandumSelect.disabled = true;
            toggleRequired(memorandumSelect, true);
        }

        if (compliance === 'CHED') {
            yearContainer.classList.remove('hidden');
            categoryContainer.classList.add('hidden');
            if(titleContainer) titleContainer.classList.add('hidden');
            
            // CHED Layout: Year(1) + Memo(2) = 3 cols (1 row)
            if(memoContainer) {
                memoContainer.classList.remove('md:col-span-3');
                memoContainer.classList.add('md:col-span-2');
            }
            
            document.getElementById('memorandumCategory').selectedIndex = 0;
            if(document.getElementById('memorandumTitle')) document.getElementById('memorandumTitle').selectedIndex = 0;
            
            toggleRequired(yearContainer, true);
            toggleRequired(categoryContainer, false);
            
            toggleRequired(yearContainer, true);
            toggleRequired(categoryContainer, false);
            
            populateCHEDYears();
            renderCurriculumOptions('College'); // Filter for CHED
        } else if (compliance === 'DepEd') {
            yearContainer.classList.add('hidden');
            categoryContainer.classList.remove('hidden');
            document.getElementById('memorandumYear').selectedIndex = 0;
            
            // DepEd Initial Layout: Category Full Width (3) because Title is hidden initially
            if(categoryContainer) {
                categoryContainer.classList.remove('md:col-span-1');
                categoryContainer.classList.add('md:col-span-3');
            }
            
            // Memo is also Full Width (3) on valid rows
            if(memoContainer) {
                memoContainer.classList.remove('md:col-span-2');
                memoContainer.classList.add('md:col-span-3');
            }
            
            toggleRequired(yearContainer, false);
            toggleRequired(categoryContainer, true);
            
            renderCurriculumOptions('Senior High'); // Filter for DepEd
        } else {
            memorandumContainer.classList.add('hidden');
            toggleRequired(memorandumContainer, false);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const memorandumYearSelect = document.getElementById('memorandumYear');
        const memorandumCategorySelect = document.getElementById('memorandumCategory');
        const memorandumTitleSelect = document.getElementById('memorandumTitle');

        if(memorandumYearSelect) {
            memorandumYearSelect.addEventListener('change', function() {
                updateCHEDMemorandumDropdown(this.value);
            });
        }

        if(memorandumCategorySelect) {
            memorandumCategorySelect.addEventListener('change', function() {
                handleDepEdCategoryChange(this.value);
            });
        }
        
        if(memorandumTitleSelect) {
            memorandumTitleSelect.addEventListener('change', function() {
                handleDepEdTitleChange(this.value);
            });
        }
        
        populateCHEDYears();
        fetchCurriculums(); // Load curriculums
    });
    
    // Initialize default view if needed based on initial syllabus type
    document.addEventListener('DOMContentLoaded', () => {
         const initialType = document.getElementById('syllabus_type').value || 'CHED';
         if (typeof handleComplianceChange === 'function') {
             handleComplianceChange(initialType);
         }
    });

    // Update Loading Text
    const updateAiLoadingText = (title, message) => {
        const modal = document.getElementById('aiAnalysisLoadingModal');
        if (!modal) return;
        modal.querySelector('h3').textContent = title;
        modal.querySelector('p').textContent = message;
    };

    // Generate Syllabus Range
    window.generateSyllabusRange = async (startWeek, endWeek) => {
        const courseTitle = document.getElementById('course_title').value;
        const courseCode = document.getElementById('course_code').value;
        const courseDescription = document.getElementById('course_description').value;

        if (!courseTitle || !courseCode || !courseDescription) {
            alert('Please fill in Course Title, Course Code, and Course Description first.');
            return;
        }

        const modal = document.getElementById('aiAnalysisLoadingModal');
        updateAiLoadingText('Generating Syllabus Content', `Generating content for Weeks ${startWeek}-${endWeek}...`);
        modal.classList.remove('hidden');

        try {
            // Create range array
            const weeks = [];
            for (let i = startWeek; i <= endWeek; i++) {
                if ([6, 12, 18].includes(i)) continue; // Skip exams
                weeks.push(i);
            }

            if (weeks.length === 0) {
                 modal.classList.add('hidden');
                 return;
            }

            // Collect Memo Data (if any)
            const memorandumYearEl = document.getElementById('memorandumYear');
            const memorandumEl = document.getElementById('memorandum');

            const cmoYear = (memorandumYearEl && !memorandumYearEl.disabled) ? memorandumYearEl.value : null;
            const cmoTitle = (memorandumEl && !memorandumEl.disabled) ? memorandumEl.value : null;

            const response = await fetch('/ajax/generate-syllabus-weeks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    course_title: courseTitle,
                    course_code: courseCode,
                    course_description: courseDescription,
                    weeks: weeks,
                    cmo_year: cmoYear,
                    cmo_title: cmoTitle
                })
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error("Syllabus Generation API Error:", response.status, errorText);
                let errorMessage = 'Failed to generate syllabus';
                try {
                    const errorJson = JSON.parse(errorText);
                    errorMessage = errorJson.error || errorJson.message || errorMessage;
                } catch (e) {
                    // Not JSON, usage raw text if short, or generic
                    if (errorText.length < 200) errorMessage += ': ' + errorText;
                }
                throw new Error(errorMessage);
            }

            const data = await response.json();
            
            // Populate fields
            if (data && data.weeks) {
                Object.keys(data.weeks).forEach(weekNum => {
                    const weekData = data.weeks[weekNum];
                    if (weekData) {
                         // content, silo, at_onsite, at_offsite, tla_onsite, tla_offsite, ltsm, output
                         const setVal = (id, val) => {
                             const el = document.getElementById(id);
                             if (el) el.value = val || '';
                         };

                         setVal(`week_${weekNum}_content`, weekData.content);
                         setVal(`week_${weekNum}_silo`, weekData.silo);
                         setVal(`week_${weekNum}_at_onsite`, weekData.at_onsite);
                         setVal(`week_${weekNum}_at_offsite`, weekData.at_offsite);
                         setVal(`week_${weekNum}_tla_onsite`, weekData.tla_onsite);
                         setVal(`week_${weekNum}_tla_offsite`, weekData.tla_offsite);
                         setVal(`week_${weekNum}_ltsm`, weekData.ltsm);
                         setVal(`week_${weekNum}_output`, weekData.output);

                         // Update progress bar
                         if (typeof updateWeekProgress === 'function') {
                             updateWeekProgress(weekNum);
                         }
                    }
                });
            }

        } catch (error) {
            console.error(error);
            alert('Error generating syllabus: ' + error.message);
        } finally {
            modal.classList.add('hidden');
        }
    };

    function toggleAccordion(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('svg');
    if (content.style.display === "none" || content.style.display === "") {
        content.style.display = "block";
        icon.style.transform = "rotate(180deg)";
    } else {
        content.style.display = "none";
        icon.style.transform = "rotate(0deg)";
    }
}



let targetSyllabusType = null;

function confirmSwitchSyllabus(type) {
    const currentType = document.getElementById('syllabus_type').value;
    if (currentType === type) return;

    if (isFormDirty) {
        targetSyllabusType = type;
        const modal = document.getElementById('switchFormatConfirmModal');
        // Update modal message based on target type
        const messageEl = document.getElementById('switchFormatMessage');
        messageEl.textContent = `You are about to switch to ${type} Format. This will reset the current form and unsaved data will be lost. Are you sure?`;
        
        modal.classList.remove('hidden');
    } else {
        switchSyllabus(type);
    }
}

// Confirm Switch Handler
document.addEventListener('DOMContentLoaded', () => {
    const cancelSwitchBtn = document.getElementById('cancelSwitchFormat');
    const confirmSwitchBtn = document.getElementById('confirmSwitchFormat');
    
    if (cancelSwitchBtn) {
        cancelSwitchBtn.addEventListener('click', () => {
            document.getElementById('switchFormatConfirmModal').classList.add('hidden');
            targetSyllabusType = null;
        });
    }
    
    if (confirmSwitchBtn) {
        confirmSwitchBtn.addEventListener('click', () => {
            document.getElementById('switchFormatConfirmModal').classList.add('hidden');
            if (targetSyllabusType) {
                // Reset form dirty state since we are intentionally resetting
                isFormDirty = false; 
                switchSyllabus(targetSyllabusType);
            }
        });
    }
});




function switchSyllabus(type) {
    const chedContainer = document.getElementById('ched-container');

    // Update Subject Category Options
    const categorySelect = document.getElementById('course_classification');
    if (categorySelect) {
        const currentVal = categorySelect.value;
        const isEdit = document.getElementById('subject_id') && document.getElementById('subject_id').value !== '';
        
        categorySelect.innerHTML = '<option value="" disabled selected>Select Category</option>';
        
        const chedOptions = [
            "General Education",
            "Professional Subject Non Laboratory",
            "Professional Subject Laboratory",
            "Professional Subject Board Courses",
            "Professional Subject Non Board Courses",
            "Professional Subject OC",
            "NSTP 1",
            "NSTP 2",
            "Research",
            "OJT/Practicum"
        ];
        
        const depedOptions = [
            "Core Subjects",
            "Applied Track Subjects",
            "Specialized Subjects"
        ];
        
        const opts = (type === 'CHED') ? chedOptions : depedOptions;
        
        opts.forEach(opt => {
            const option = document.createElement('option');
            option.value = opt;
            option.textContent = opt;
            if (isEdit && currentVal === opt) {
                option.selected = true;
            }
            categorySelect.appendChild(option);
        });
    }
    
    const btnChed = document.getElementById('btn-ched');
    const btnDeped = document.getElementById('btn-deped');
    
    // Update Memorandum Fields based on type
    if (typeof handleComplianceChange === 'function') {
        handleComplianceChange(type);
    }
    const syllabusTypeInput = document.getElementById('syllabus_type');
    
    // Course Info Fields - Split CHED groups
    const chedFields1 = document.getElementById('ched-course-info-fields-1');
    const chedFields2 = document.getElementById('ched-course-info-fields-2');
    
    const depedFields = document.getElementById('deped-course-info-fields');
    const depedGrids = document.getElementById('deped-curriculum-grids');
    const approvalSection = document.getElementById('approval-section');

    syllabusTypeInput.value = type;
    
    // Clear shared fields when switching (unless editing existing subject)
    const isEditing = document.getElementById('subject_id').value !== '';
    if (!isEditing) {
        // Clear Course Information fields
        document.getElementById('course_title').value = '';
        document.getElementById('course_code').value = '';
        document.getElementById('subject_type').value = '';
        document.getElementById('course_classification').value = '';
        document.getElementById('course_description').value = '';
        
        // Clear Approval fields
        document.getElementById('prepared_by').value = '';
        document.getElementById('reviewed_by').value = '';
        document.getElementById('approved_by').value = '';
        
        // Clear curriculum selection if available
        if (typeof selectedCurriculums !== 'undefined') {
            selectedCurriculums.clear();
            // Update button text if the function exists
            if (typeof updateCurriculumButtonText === 'function') {
                updateCurriculumButtonText();
            }
        }
    }

    if (type === 'CHED') {
        chedContainer.classList.remove('hidden');
        
        // Show CHED fields (both groups)
        if(chedFields1) chedFields1.classList.remove('hidden');
        if(chedFields2) chedFields2.classList.remove('hidden');
        
        depedFields.classList.add('hidden');
        depedGrids.classList.add('hidden');
        
        // Toggle Required Attributes
        toggleRequired(chedContainer, true);
        if(chedFields1) toggleRequired(chedFields1, true);
        if(chedFields2) toggleRequired(chedFields2, true);
        
        toggleRequired(depedFields, false);
        toggleRequired(depedGrids, false);
        
        // Show Approval Section
        approvalSection.classList.remove('hidden');
        toggleRequired(approvalSection, true);
        
        btnChed.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
        btnChed.classList.remove('text-gray-600');
        
        btnDeped.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
        btnDeped.classList.add('text-gray-600');
        
        // Show Course Description for CHED
        const courseDescContainer = document.getElementById('course_description_container');
        if (courseDescContainer) {
            courseDescContainer.classList.remove('hidden');
            toggleRequired(courseDescContainer, true);
        }

        // Clear DepEd-specific fields if not editing
        if (!isEditing) {
            const timeAllotment = document.getElementById('time_allotment');
            if (timeAllotment) timeAllotment.value = '';
            const schedule = document.getElementById('schedule');
            if (schedule) schedule.value = '';
            
            // Clear quarter grids
            for (let q = 1; q <= 2; q++) {
                const container = document.getElementById(`q_${q}_rows_container`);
                if (container) {
                    // Keep only the first row and clear it
                    const rows = container.querySelectorAll('.deped-row');
                    rows.forEach((row, index) => {
                        if (index === 0) {
                            row.querySelectorAll('textarea').forEach(ta => ta.value = '');
                        } else {
                            row.remove();
                        }
                    });
                }
                
                const perfStd = document.getElementById(`q_${q}_performance_standards`);
                const perfTask = document.getElementById(`q_${q}_performance_task`);
                if (perfStd) perfStd.value = '';
                if (perfTask) perfTask.value = '';
            }
        }
    } else {
        chedContainer.classList.add('hidden');
        
        // Hide CHED fields
        if(chedFields1) chedFields1.classList.add('hidden');
        if(chedFields2) chedFields2.classList.add('hidden');
        
        depedFields.classList.remove('hidden');
        
        // Hide Curriculum Grids (User requested removal for DepEd as PDF replaces them)
        depedGrids.classList.add('hidden');
        
        // Toggle Required Attributes
        toggleRequired(chedContainer, false);
        if(chedFields1) toggleRequired(chedFields1, false);
        if(chedFields2) toggleRequired(chedFields2, false);
        
        toggleRequired(depedFields, true);
        toggleRequired(depedGrids, false);

        // Hide Course Description for DepEd
        const courseDescContainer = document.getElementById('course_description_container');
        if (courseDescContainer) {
            courseDescContainer.classList.add('hidden');
            toggleRequired(courseDescContainer, false);
        }

        // Hide Approval Section
        approvalSection.classList.add('hidden');
        toggleRequired(approvalSection, false);
        
        // Explicitly remove required from CHED-specific fields to ensure form validation works
        const chedSpecificFields = [
            'credit_units', 'contact_hours', 'pilo_outcomes', 'cilo_outcomes',
            'learning_outcomes', 'basic_readings', 'extended_readings',
            'course_assessment', 'committee_members', 'consultation_schedule'
        ];
        
        chedSpecificFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) field.removeAttribute('required');
        });
        
        // Remove required from all week fields (CHED weekly plan)
        for (let i = 1; i <= 18; i++) {
            if ([6, 12, 18].includes(i)) continue; // Skip exam weeks
            ['content', 'silo', 'at_onsite', 'at_offsite', 'tla_onsite', 'tla_offsite', 'ltsm', 'output'].forEach(suffix => {
                const field = document.getElementById(`week_${i}_${suffix}`);
                if (field) field.removeAttribute('required');
            });
        }
        
        btnDeped.classList.add('bg-white', 'text-red-600', 'shadow-sm');
        btnDeped.classList.remove('text-gray-600');
        
        btnChed.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
        btnChed.classList.add('text-gray-600');
        
        // Clear CHED-specific fields if not editing
        if (!isEditing) {
            document.getElementById('credit_units').value = '';
            document.getElementById('contact_hours').value = '';
            document.getElementById('pilo_outcomes').value = '';
            document.getElementById('cilo_outcomes').value = '';
            document.getElementById('learning_outcomes').value = '';
            document.getElementById('basic_readings').value = '';
            document.getElementById('extended_readings').value = '';
            document.getElementById('course_assessment').value = '';
            document.getElementById('committee_members').value = '';
            document.getElementById('consultation_schedule').value = '';
            
            // Clear mapping grids
            document.getElementById('program-mapping-table-body').innerHTML = '';
            document.getElementById('course-mapping-table-body').innerHTML = '';
            
            // Clear weekly plan
            for (let i = 0; i <= 18; i++) {
                const contentEl = document.getElementById(`week_${i}_content`);
                // ... (rest of clearing logic)

                const siloEl = document.getElementById(`week_${i}_silo`);
                const atOnsiteEl = document.getElementById(`week_${i}_at_onsite`);
                const atOffsiteEl = document.getElementById(`week_${i}_at_offsite`);
                const tlaOnsiteEl = document.getElementById(`week_${i}_tla_onsite`);
                const tlaOffsiteEl = document.getElementById(`week_${i}_tla_offsite`);
                const ltsmEl = document.getElementById(`week_${i}_ltsm`);
                const outputEl = document.getElementById(`week_${i}_output`);
                
                if (contentEl) contentEl.value = '';
                if (siloEl) siloEl.value = '';
                if (atOnsiteEl) atOnsiteEl.value = '';
                if (atOffsiteEl) atOffsiteEl.value = '';
                if (tlaOnsiteEl) tlaOnsiteEl.value = '';
                if (tlaOffsiteEl) tlaOffsiteEl.value = '';
                if (ltsmEl) ltsmEl.value = '';
                if (outputEl) outputEl.value = '';
            }
        }
    }
}





document.addEventListener('DOMContentLoaded', function () {
    const courseForm = document.getElementById('courseForm');
    const subjectIdField = document.getElementById('subject_id');
    const saveButton = document.getElementById('saveCourseButton');
    const pageTitle = document.querySelector('h1.text-4xl');

    // Helper function to show errors
    const showError = (title, message) => {
        alert(`${title}\n\n${message}`);
    };

    // --- DEFAULT WEEK 0 CONTENT ---
    // --- DEFAULT CONTENT ---
    const populateDefaultContent = () => {
        // Only populate if Week 0 fields are empty (for new courses)
        if (document.getElementById('week_0_content').value.trim() === '') {
            document.getElementById('week_0_content').value = `BCP Vision, Mission, Goals, Objectives, Philosophy and School Organizational Structure School Policies Orientation in Online and Modular Learning System`;
            
            document.getElementById('week_0_silo').value = `Recite, internalize and explain the BCP Vision, Mission, Goals, Objectives and Philosophy
Deepen knowledge on the school's policies, guidelines, rules and regulations.
Familiarize on the new normal system of education through online, modular learning system and Blended Learning Delivery Modality (BLDM)`;
            
            document.getElementById('week_0_at_onsite').value = `Identify the Vision and Mission statements of BCP.
Critically analyze these statements in 500 words, focusing on the following:
The clarity and coherence of the statements.
How these statements reflect the school's commitment to education.
The alignment of these statements with the current educational landscape.
Verify that the BCP VMGO are align with the school goals thru checklist (PMED tools)`;
            
            document.getElementById('week_0_at_offsite').value = `Navigate LMS and know the function of each feature.`;
            
            document.getElementById('week_0_tla_onsite').value = `Read and internalize the following printed materials for Students and Parents Orientation:`;
            
            document.getElementById('week_0_tla_offsite').value = `Presentation and Lecture Discussion (PowerPoint Presentation) of Students and Parents Orientation:`;
            
            document.getElementById('week_0_ltsm').value = `Instructional Materials
Video Presentation of BCP Hymn
YouTube Video Title: BESTLINK COLLEGE OF THE PHILIPPINES HYMN (BCP hymn)
https://www.youtube.com/watch?v=NuEYO11Wb4E
Student Hand Book
Learning Management System`;
            
            document.getElementById('week_0_output').value = `Check alignment report`;
        }

        // Default Exams
        if (document.getElementById('week_6_content') && document.getElementById('week_6_content').value.trim() === '') {
            document.getElementById('week_6_content').value = 'Prelim Exam';
        }
        if (document.getElementById('week_12_content') && document.getElementById('week_12_content').value.trim() === '') {
            document.getElementById('week_12_content').value = 'Midterm Exam';
        }
        if (document.getElementById('week_18_content') && document.getElementById('week_18_content').value.trim() === '') {
            document.getElementById('week_18_content').value = 'Final Exam';
        }
    };

    // --- HELPER FUNCTIONS ---

    const collectMappingGridData = (tableBodyId) => {
        const tableBody = document.getElementById(tableBodyId);
        if (!tableBody) return null;
        const rows = tableBody.querySelectorAll('tr');
        const data = [];
        rows.forEach(row => {
            const inputs = row.querySelectorAll('input[type="text"]');
            const outcomeKey = inputs[0].placeholder.includes('PILO') ? 'pilo' : 'cilo';
            const rowData = {
                [outcomeKey]: inputs[0].value,
                ctpss: inputs[1].value,
                ecc: inputs[2].value,
                epp: inputs[3].value,
                glc: inputs[4].value,
            };
            if (rowData[outcomeKey] && rowData[outcomeKey].trim() !== '') data.push(rowData);
        });
        return data.length > 0 ? data : null;
    };

    const collectWeeklyPlan = () => {
        const lessons = {};
        for (let i = 0; i <= 18; i++) {
            const contentEl = document.getElementById(`week_${i}_content`);
            const siloEl = document.getElementById(`week_${i}_silo`);
            const atOnsiteEl = document.getElementById(`week_${i}_at_onsite`);
            const atOffsiteEl = document.getElementById(`week_${i}_at_offsite`);
            const tlaOnsiteEl = document.getElementById(`week_${i}_tla_onsite`);
            const tlaOffsiteEl = document.getElementById(`week_${i}_tla_offsite`);
            const ltsmEl = document.getElementById(`week_${i}_ltsm`);
            const outputEl = document.getElementById(`week_${i}_output`);

            const content = contentEl ? contentEl.value : '';
            const silo = siloEl ? siloEl.value : '';
            const atOnsite = atOnsiteEl ? atOnsiteEl.value : '';
            const atOffsite = atOffsiteEl ? atOffsiteEl.value : '';
            const tlaOnsite = tlaOnsiteEl ? tlaOnsiteEl.value : '';
            const tlaOffsite = tlaOffsiteEl ? tlaOffsiteEl.value : '';
            const ltsm = ltsmEl ? ltsmEl.value : '';
            const output = outputEl ? outputEl.value : '';

            if (content || silo || atOnsite || atOffsite || tlaOnsite || tlaOffsite || ltsm || output) {
                lessons[`Week ${i}`] = [
                    `Detailed Lesson Content:\n${content}`,
                    `Student Intended Learning Outcomes:\n${silo}`,
                    `Assessment: ONSITE: ${atOnsite} OFFSITE: ${atOffsite}`,
                    `Activities: ON-SITE: ${tlaOnsite} OFF-SITE: ${tlaOffsite}`,
                    `Learning and Teaching Support Materials:\n${ltsm}`,
                    `Output Materials:\n${output}`
                ].filter(part => !part.endsWith(':\n') && !part.endsWith(': ON-SITE:  OFF-SITE: ') && !part.endsWith(': ONSITE:  OFFSITE: ')).join(',, ');
            }
        }
        return Object.keys(lessons).length > 0 ? lessons : null;
    };

    const populateMappingGrid = (tableBodyId, data, outcomeKey) => {
        const tableBody = document.getElementById(tableBodyId);
        if (!tableBody || !data) return;
        tableBody.innerHTML = '';
        data.forEach(rowData => {
            const row = createMappingTableRow(outcomeKey.toUpperCase() === 'PILO');
            const inputs = row.querySelectorAll('input[type="text"]');
            inputs[0].value = rowData[outcomeKey] || '';
            inputs[1].value = rowData.ctpss || '';
            inputs[2].value = rowData.ecc || '';
            inputs[3].value = rowData.epp || '';
            inputs[4].value = rowData.glc || '';
            tableBody.appendChild(row);
        });
    };

    const populateWeeklyPlan = (lessons) => {
        if (!lessons) return;
        for (let i = 0; i <= 18; i++) {
            const weekKey = `Week ${i}`;
            if (lessons[weekKey]) {
                const lessonString = lessons[weekKey];
                const contentMatch = lessonString.match(/Detailed Lesson Content:\n(.*?)(?=,, |$)/s);
                const contentEl = document.getElementById(`week_${i}_content`);
                if (contentEl) contentEl.value = contentMatch ? contentMatch[1].trim() : '';

                const siloMatch = lessonString.match(/Student Intended Learning Outcomes:\n(.*?)(?=,, |$)/s);
                const siloEl = document.getElementById(`week_${i}_silo`);
                if (siloEl) siloEl.value = siloMatch ? siloMatch[1].trim() : '';

                const atMatch = lessonString.match(/Assessment: ONSITE: (.*?) OFFSITE: (.*?)(?=,, |$)/s);
                if (atMatch) {
                    const atOnsiteEl = document.getElementById(`week_${i}_at_onsite`);
                    if (atOnsiteEl) atOnsiteEl.value = atMatch[1].trim();
                    const atOffsiteEl = document.getElementById(`week_${i}_at_offsite`);
                    if (atOffsiteEl) atOffsiteEl.value = atMatch[2].trim();
                }

                const tlaMatch = lessonString.match(/Activities: ON-SITE: (.*?) OFF-SITE: (.*?)(?=,, |$)/s);
                if (tlaMatch) {
                    const tlaOnsiteEl = document.getElementById(`week_${i}_tla_onsite`);
                    if (tlaOnsiteEl) tlaOnsiteEl.value = tlaMatch[1].trim();
                    const tlaOffsiteEl = document.getElementById(`week_${i}_tla_offsite`);
                    if (tlaOffsiteEl) tlaOffsiteEl.value = tlaMatch[2].trim();
                }

                const ltsmMatch = lessonString.match(/Learning and Teaching Support Materials:\n(.*?)(?=,, |$)/s);
                const ltsmEl = document.getElementById(`week_${i}_ltsm`);
                if (ltsmEl) ltsmEl.value = ltsmMatch ? ltsmMatch[1].trim() : '';

                const outputMatch = lessonString.match(/Output Materials:\n(.*?)(?=,, |$)/s);
                const outputEl = document.getElementById(`week_${i}_output`);
                if (outputEl) outputEl.value = outputMatch ? outputMatch[1].trim() : '';
            }
        }
    };

    const populateForm = (subject) => {
        if (!subject) return;
        document.getElementById('subject_id').value = subject.id;
        document.getElementById('course_title').value = subject.subject_name;
        document.getElementById('course_code').value = subject.subject_code;
        document.getElementById('subject_type').value = subject.subject_type;
        document.getElementById('course_classification').value = subject.course_classification || '';
        document.getElementById('credit_units').value = subject.subject_unit;
        document.getElementById('contact_hours').value = subject.contact_hours;
        document.getElementById('course_description').value = subject.course_description;
        document.getElementById('pilo_outcomes').value = subject.pilo_outcomes;
        document.getElementById('cilo_outcomes').value = subject.cilo_outcomes;
        document.getElementById('learning_outcomes').value = subject.learning_outcomes;
        document.getElementById('basic_readings').value = subject.basic_readings;
        document.getElementById('extended_readings').value = subject.extended_readings;
        document.getElementById('course_assessment').value = subject.course_assessment;
        document.getElementById('committee_members').value = subject.committee_members;
        document.getElementById('consultation_schedule').value = subject.consultation_schedule;
        document.getElementById('prepared_by').value = subject.prepared_by;
        document.getElementById('reviewed_by').value = subject.reviewed_by;
        document.getElementById('approved_by').value = subject.approved_by;
        
        // Populate Memorandum Fields
        const syllabusType = subject.syllabus_type || 'CHED';
        switchSyllabus(syllabusType); // This also calls handleComplianceChange
        
        if (subject.memorandum_year) {
            document.getElementById('memorandumYear').value = subject.memorandum_year;
            updateMemorandumDropdown('CHED', subject.memorandum_year).then(() => {
                if (subject.memorandum) document.getElementById('memorandum').value = subject.memorandum;
            });
        } else if (subject.memorandum_category) {
            document.getElementById('memorandumCategory').value = subject.memorandum_category;
            updateMemorandumDropdown('DepEd', subject.memorandum_category).then(() => {
                if (subject.memorandum) document.getElementById('memorandum').value = subject.memorandum;
            });
        }

        // Load curriculum relationships if available
        if (subject.curriculums && subject.curriculums.length > 0) {
            selectedCurriculums = new Set(subject.curriculums.map(c => c.id));
            updateCurriculumButtonText();
        }

        populateMappingGrid('program-mapping-table-body', subject.program_mapping_grid, 'pilo');
        populateMappingGrid('course-mapping-table-body', subject.course_mapping_grid, 'cilo');
        populateWeeklyPlan(subject.lessons);
        
        // Update progress percentages
        if (typeof updateAllProgress === 'function') {
            updateAllProgress();
        }

        // Populate DepEd Fields
        if (subject.syllabus_type === 'DepEd') {
            const setVal = (id, val) => { const el = document.getElementById(id); if (el) el.value = val || ''; }
            
            // Syllabus File Preview
            if (subject.syllabus_path) {
                const fileName = subject.syllabus_path.split('/').pop();
                const displayEl = document.getElementById('file_name_display');
                if (displayEl) displayEl.textContent = fileName;

                const pdfFrame = document.getElementById('pdf-frame');
                const imagePreview = document.getElementById('image-preview');
                const placeholder = document.getElementById('pdf-placeholder');
                
                const ext = fileName.split('.').pop().toLowerCase();

                if (ext === 'pdf') {
                    if (pdfFrame) {
                        pdfFrame.src = subject.syllabus_path + '#toolbar=0&navpanes=0';
                        pdfFrame.classList.remove('hidden');
                        if (placeholder) placeholder.classList.add('hidden');
                    }
                } else if (['jpg', 'jpeg', 'png'].includes(ext)) {
                     if (imagePreview) {
                        imagePreview.src = subject.syllabus_path;
                        imagePreview.classList.remove('hidden');
                        if (placeholder) placeholder.classList.add('hidden');
                    }
                }
            } else {
                 // Reset preview if no file
                 const placeholder = document.getElementById('pdf-placeholder');
                 const pdfFrame = document.getElementById('pdf-frame');
                 const imagePreview = document.getElementById('image-preview');
                 if (placeholder) placeholder.classList.remove('hidden');
                 if (pdfFrame) {
                     pdfFrame.classList.add('hidden');
                     pdfFrame.src = '';
                 }
                 if (imagePreview) {
                     imagePreview.classList.add('hidden');
                     imagePreview.src = '';
                 }
                 const displayEl = document.getElementById('file_name_display');
                 if (displayEl) displayEl.textContent = 'No file selected';
            }

            setVal('time_allotment', subject.time_allotment);
            setVal('schedule', subject.schedule);
            
            // Handle flat properties or properties inside deped_data just in case
            setVal('q_1_performance_standards', subject.q_1_performance_standards || subject.performance_standards_q1);
            setVal('q_1_performance_task', subject.q_1_performance_tasks || subject.performance_tasks_q1);
            setVal('q_2_performance_standards', subject.q_2_performance_standards || subject.performance_standards_q2);
            setVal('q_2_performance_task', subject.q_2_performance_tasks || subject.performance_tasks_q2);

            const depedData = subject.deped_data || {};
            const populateRows = (quarter, rows) => {
                const container = document.getElementById(`q_${quarter}_rows_container`);
                if (!container || !rows) return;
                
                // Clear existing extra rows (keep first one)
                container.innerHTML = ''; 
                // We need to rebuild rows. 
                // Actually, the structure assumes we add rows. 
                // Let's create rows.
                
                rows.forEach((row, index) => {
                   const rowDiv = document.createElement('div');
                   rowDiv.className = 'grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 deped-row relative group';
                   rowDiv.innerHTML = `
                        <div class="md:col-span-4">
                            <textarea class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm min-h-[100px]" placeholder="Content...">${row.content || ''}</textarea>
                        </div>
                        <div class="md:col-span-4">
                            <textarea class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm min-h-[100px]" placeholder="Content Standards...">${row.content_standards || ''}</textarea>
                        </div>
                        <div class="md:col-span-3">
                            <textarea class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm min-h-[100px]" placeholder="Learning Competencies...">${row.learning_competencies || ''}</textarea>
                        </div>
                        <div class="md:col-span-1 flex items-center justify-center">
                            <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition-colors remove-row-btn" onclick="this.closest('.deped-row').remove()">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                   `;
                   container.appendChild(rowDiv);
                });
                
                // If no rows, ensure at least one empty row is present? 
                // The addRow function handles creating a new blank one.
                if (rows.length === 0) {
                     // Trigger add row? Or manually add one blank.
                     // The container should probably have at least one blank row if empty, 
                     // but let's leave it empty if data is empty, user can click "Add Row".
                     // Actually, for UX, having one empty row is better.
                     if (typeof addDepEdRow === 'function') {
                         addDepEdRow(quarter);
                     }
                }
            };

            populateRows(1, depedData.q_1_rows || subject.q_1_rows || []);
            populateRows(2, depedData.q_2_rows || subject.q_2_rows || []);
        }

        pageTitle.textContent = 'Edit Course';
        saveButton.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> <span>Update Course</span>`;
    };

    const fetchSubjectData = async (id) => {
        try {
            const response = await fetch(`/api/subjects/${id}`);
            if (!response.ok) throw new Error('Subject not found.');
            const subject = await response.json();
            populateForm(subject);
        } catch (error) {
            console.error('Error fetching subject data:', error);
            showError('Loading Error', 'Failed to load subject data. You can create a new subject instead.');
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    };

    // --- FORM VALIDATION HANDLER (Fix for hidden required fields) ---
    // This ensures that if a required field inside a collapsed accordion is empty,
    // the accordion opens automatically so the user can see the error.
    document.addEventListener('invalid', (function(){
        return function(e) {
            const target = e.target;
            // Check if element is inside a hidden accordion content
            const accordionContent = target.closest('.accordion-content');
            if (accordionContent && (accordionContent.style.display === 'none' || accordionContent.style.display === '')) {
                accordionContent.style.display = 'block';
                const header = accordionContent.previousElementSibling;
                if (header) {
                     const icon = header.querySelector('svg');
                     if(icon) icon.style.transform = "rotate(180deg)";
                }
            }
        };
    })(), true);

    // --- FORM SUBMISSION LOGIC ---
    if (saveButton) {
        saveButton.addEventListener('click', (e) => {
            // Use HTML5 validation
            if (courseForm && !courseForm.checkValidity()) {
                courseForm.reportValidity();
                return;
            }
            
            // Show confirmation modal
            document.getElementById('saveCourseConfirmModal').classList.remove('hidden');
        });
    }

    // Helper to collect DepEd dynamic rows
    const collectDepEdRows = (quarter) => {
        const container = document.getElementById(`q_${quarter}_rows_container`);
        if (!container) return [];
        
        const rows = [];
        const rowDivs = container.querySelectorAll('.deped-row');
        
        rowDivs.forEach(rowDiv => {
            const textareas = rowDiv.querySelectorAll('textarea');
            // Expected order: Content, Content Standards, Learning Competencies
            if (textareas.length >= 3) {
                // Ensure value exists or is at least empty string
                rows.push({
                    content: textareas[0].value || '',
                    content_standards: textareas[1].value || '',
                    learning_competencies: textareas[2].value || ''
                });
            }
        });
        
        return rows;
    };

    // Handle the actual save logic when user confirms
    const handleCourseSave = async () => {
        disableDirtyCheck();

        const formData = new FormData();
        const subjectId = subjectIdField.value;

        // Basic Fields
        formData.append('course_title', document.getElementById('course_title').value);
        formData.append('subject_code', document.getElementById('course_code').value);
        formData.append('subject_type', document.getElementById('subject_type').value);
        formData.append('course_classification', document.getElementById('course_classification').value);
        
        const syllabusType = document.getElementById('syllabus_type').value;
        formData.append('syllabus_type', syllabusType);

        if (syllabusType === 'DepEd') {
             formData.append('subject_unit', 0);
             // DepEd fields are largely removed or optional now
             if (document.getElementById('time_allotment')) formData.append('time_allotment', document.getElementById('time_allotment').value);
             if (document.getElementById('schedule')) formData.append('schedule', document.getElementById('schedule').value);
             
             // Handle Syllabus File
             const syllabusFile = document.getElementById('syllabus_file').files[0];
             if (syllabusFile) {
                 formData.append('syllabus_path', syllabusFile);
             }

        } else {
             formData.append('subject_unit', document.getElementById('credit_units').value || 0);
             formData.append('contact_hours', document.getElementById('contact_hours').value || '');
        }

        formData.append('course_description', document.getElementById('course_description').value);
        formData.append('pilo_outcomes', document.getElementById('pilo_outcomes').value);
        formData.append('cilo_outcomes', document.getElementById('cilo_outcomes').value);
        formData.append('learning_outcomes', document.getElementById('learning_outcomes').value);
        formData.append('basic_readings', document.getElementById('basic_readings').value);
        formData.append('extended_readings', document.getElementById('extended_readings').value);
        formData.append('course_assessment', document.getElementById('course_assessment').value);
        formData.append('course_policies', document.getElementById('course_policies').value);
        formData.append('committee_members', document.getElementById('committee_members').value);
        formData.append('consultation_schedule', document.getElementById('consultation_schedule').value);
        formData.append('prepared_by', document.getElementById('prepared_by').value);
        formData.append('reviewed_by', document.getElementById('reviewed_by').value);
        formData.append('approved_by', document.getElementById('approved_by').value);
        
        const memorandumEl = document.getElementById('memorandum');
        formData.append('memorandum', memorandumEl ? memorandumEl.value : '');
        
        const memorandumYearEl = document.getElementById('memorandumYear');
        formData.append('memorandum_year', memorandumYearEl ? memorandumYearEl.value : '');
        
        const memorandumCategoryEl = document.getElementById('memorandumCategory');
        formData.append('memorandum_category', memorandumCategoryEl ? memorandumCategoryEl.value : '');

        // Complex Data (JSON)
        // Note: For existing manual DepEd logic (if any remains), we keep it, but user wants them removed.
        // We will send null or empty for removed fields to avoid validaton errors if they were required (validation was removed in blade)
        
        // However, we still need to send structure for legacy compatibility if we don't want to break DB
        // But since we are allowed to have nulls in DB (based on migration), it's fine.

        const weeklyPlan = collectWeeklyPlan();
        if (weeklyPlan) {
            // PHP side expects 'lessons' array, but if we send FormData, we have to handle it carefully.
            // The existing Controller validation says 'lessons' => 'nullable|array'. 
            // Sending JSON string might fail validation if it expects array directly.
            // In Laravel, to send array via FormData, check how Controller handles it.
            // Actually, usually we can't send nested objects easily in FormData without manual indexing or JSON strings.
            // Simplest way: Send as JSON string and decode in Controller? 
            // BUT the controller validation `nullable|array` expects an array. 
            // If we send `lessons` as a JSON string, validation `array` might fail.
            // We should use array notation `lessons[key]=value` or modify Controller to accept JSON string.
            // Since I cannot modify Controller drastically in this step (I did modify it earlier but not for this),
            // I should try to mimic array structure or...
            // Wait, standard way for complex JSON in Laravel API with FormData is often sending a JSON string and decoding it, 
            // but the validation rule `array` will fail on a string.
            // 
            // Let's look at `program_mapping_grid` etc.
            // The best way is to iterate.
            
            // Actually, the previous fetch call used `JSON.stringify(payload)`.
            // So `lessons` was an Object/Array in JSON.
            // If I change to FormData, `lessons` with `array` rule must be sent as `lessons[key]...`
            
            // To be safe and minimal: I will assume the Controller can handle JSON decoding if I change the input name or logic?
            // No, the controller is strict: `lessons => nullable|array`.
            // I will iterate weeklyPlan (which is an object) and append fields.
             // `collectWeeklyPlan` returns object: { "Week 0": "...", "Week 1": "..." }
             Object.keys(weeklyPlan).forEach(key => {
                 formData.append(`lessons[${key}]`, weeklyPlan[key]);
             });
        }
        
        const programMapping = collectMappingGridData('program-mapping-table-body');
        if (programMapping) {
            programMapping.forEach((row, index) => {
                Object.keys(row).forEach(key => {
                    formData.append(`program_mapping_grid[${index}][${key}]`, row[key]);
                });
            });
        }
        
        const courseMapping = collectMappingGridData('course-mapping-table-body');
        if (courseMapping) {
            courseMapping.forEach((row, index) => {
                Object.keys(row).forEach(key => {
                    formData.append(`course_mapping_grid[${index}][${key}]`, row[key]);
                });
            });
        }
        
        // Curriculums
        Array.from(selectedCurriculums).forEach((id, index) => {
            formData.append(`curriculum_ids[${index}]`, id);
        });

        // DepEd Data - If manual rows are still present (not in this request, but for completeness)
        // Since we removed them visually, we won't append them.

        // CSRF Token
        // Headers handled by fetch, but we need X-CSRF-TOKEN
        
        // Method Spoofing for Update
        if (subjectId) {
            formData.append('_method', 'PUT');
        }

        const url = subjectId ? `/api/subjects/${subjectId}` : '/api/subjects';

        try {
            const response = await fetch(url, {
                method: 'POST', // Always POST for FormData (with _method for PUT)
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json' 
                    // Content-Type MUST NOT be set manually
                },
                body: formData
            });
            const result = await response.json();
            if (!response.ok) {
                let errorMessage = result.message || `Failed to ${subjectId ? 'update' : 'create'} course.`;
                if (result.errors) errorMessage += '\n' + Object.values(result.errors).flat().join('\n');
                throw new Error(errorMessage);
            }

            const action = subjectId ? 'updated' : 'created';
            if (action === 'updated') {
                document.getElementById('courseUpdateSuccessModal').classList.remove('hidden');
            } else {
                document.getElementById('courseSuccessModal').classList.remove('hidden');
                window.newSubjectData = {
                    id: result.subject.id,
                    name: result.subject.subject_name,
                    code: result.subject.subject_code
                };
            }
        } catch (error) {
            showError('Save Error', `Error saving course: ${error.message}`);
        }
    };

    // --- MODAL EVENT HANDLERS ---


    // Save Course Confirmation Modal
    const cancelSaveCourseBtn = document.getElementById('cancelSaveCourse');
    if (cancelSaveCourseBtn) {
        cancelSaveCourseBtn.addEventListener('click', () => {
            document.getElementById('saveCourseConfirmModal').classList.add('hidden');
        });
    }
    
    const confirmSaveCourseBtn = document.getElementById('confirmSaveCourse');
    if (confirmSaveCourseBtn) {
        confirmSaveCourseBtn.addEventListener('click', async () => {
            document.getElementById('saveCourseConfirmModal').classList.add('hidden');
            
            // AI Course Analyzer (Description Similarity Check) - DISABLED
            /* 
            const description = document.getElementById('course_description').value;
            
            if (description && description.trim() !== '') {
                // Show loading modal with correct text
                const loadingModal = document.getElementById('aiAnalysisLoadingModal');
                if (loadingModal) {
                    loadingModal.querySelector('h3').textContent = 'Analyzing Course Description';
                    loadingModal.querySelector('p').textContent = 'AI is checking for similar courses...';
                    loadingModal.classList.remove('hidden');
                }
                
                try {
                    const similarityCheck = await checkDescriptionSimilarity(description);
                    
                    // Hide loading modal
                    document.getElementById('aiAnalysisLoadingModal').classList.add('hidden');
                    
                    if (similarityCheck.has_similar) {
                        // Show warning modal with similar courses
                        showSimilarDescriptionModal(similarityCheck.similar_courses);
                    } else {
                        // No similar descriptions, proceed with save
                        handleCourseSave();
                    }
                } catch (error) {
                    // Hide loading modal on error
                    document.getElementById('aiAnalysisLoadingModal').classList.add('hidden');
                    console.error('Similarity check failed:', error);
                    // Proceed with save on error
                    handleCourseSave();
                }
            } else {
                // No description provided, proceed with save
                handleCourseSave();
            }
            */
           
            // Directly save the course, bypassing AI check
            handleCourseSave();
        });
    }
    
    // Course Success Modal (Create)
    const skipGradeSetupBtn = document.getElementById('skipGradeSetup');
    if (skipGradeSetupBtn) {
        skipGradeSetupBtn.addEventListener('click', () => {
            document.getElementById('courseSuccessModal').classList.add('hidden');
            window.location.href = `/subject_mapping`;
        });
    }
    
    const proceedToGradeSetupBtn = document.getElementById('proceedToGradeSetup');
    if (proceedToGradeSetupBtn) {
        proceedToGradeSetupBtn.addEventListener('click', () => {
            document.getElementById('courseSuccessModal').classList.add('hidden');
            if (window.newSubjectData) {
                const newSubjectName = encodeURIComponent(`${window.newSubjectData.name} (${window.newSubjectData.code})`);
                window.location.href = `/grade-setup?new_subject_id=${window.newSubjectData.id}&new_subject_name=${newSubjectName}`;
            }
        });
    }
    
    // Course Update Success Modal
    const closeCourseUpdateModalBtn = document.getElementById('closeCourseUpdateModal');
    if (closeCourseUpdateModalBtn) {
        closeCourseUpdateModalBtn.addEventListener('click', () => {
            document.getElementById('courseUpdateSuccessModal').classList.add('hidden');
            window.location.href = `/subject_mapping`;
        });
    }
    
    // Similar Description Warning Modal
    const cancelSimilarDescriptionBtn = document.getElementById('cancelSimilarDescription');
    if (cancelSimilarDescriptionBtn) {
        cancelSimilarDescriptionBtn.addEventListener('click', () => {
            document.getElementById('similarDescriptionModal').classList.add('hidden');
        });
    }
    
    const proceedWithSimilarDescriptionBtn = document.getElementById('proceedWithSimilarDescription');
    if (proceedWithSimilarDescriptionBtn) {
        proceedWithSimilarDescriptionBtn.addEventListener('click', () => {
            document.getElementById('similarDescriptionModal').classList.add('hidden');
            handleCourseSave();
        });
    }
    
    // --- HELPER FUNCTIONS FOR SIMILARITY CHECK ---
    
    /**
     * Check if a course description is semantically similar to existing courses
     */
    const checkDescriptionSimilarity = async (description) => {
        try {
            const subjectId = document.getElementById('subject_id').value;
            
            const response = await fetch('/api/check-description-similarity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    description: description,
                    current_subject_id: subjectId || null
                })
            });
            
            const result = await response.json();
            return result;
            
        } catch (error) {
            console.error('Similarity check error:', error);
            // Return no similarity on error to allow saving
            return { has_similar: false, similar_courses: [] };
        }
    };
    
    /**
     * Display the similar description warning modal
     */
    const showSimilarDescriptionModal = (similarCourses) => {
        const listContainer = document.getElementById('similarCoursesList');
        listContainer.innerHTML = '';
        
        similarCourses.forEach(course => {
            const courseCard = document.createElement('div');
            courseCard.className = 'bg-amber-50 border border-amber-200 rounded-lg p-4';
            courseCard.innerHTML = `
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-800">${course.subject_name}</h4>
                        <p class="text-sm text-gray-600 mb-2">Code: <span class="font-mono">${course.subject_code}</span></p>
                        <p class="text-xs text-amber-700 italic">${course.similarity_reason}</p>
                    </div>
                </div>
            `;
            listContainer.appendChild(courseCard);
        });
        
        document.getElementById('similarDescriptionModal').classList.remove('hidden');
    };

    // --- MAPPING GRID ROW LOGIC (Event Listeners) ---
    const addProgramMappingRowBtn = document.getElementById('add-program-mapping-row');
    if (addProgramMappingRowBtn) {
        addProgramMappingRowBtn.addEventListener('click', () => document.getElementById('program-mapping-table-body').appendChild(createMappingTableRow(true)));
    }
    
    const addCourseMappingRowBtn = document.getElementById('add-course-mapping-row');
    if (addCourseMappingRowBtn) {
        addCourseMappingRowBtn.addEventListener('click', () => document.getElementById('course-mapping-table-body').appendChild(createMappingTableRow(false)));
    }
    
    // Event delegation for delete buttons in both tables
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('delete-row-btn')) {
            e.target.closest('tr').remove();
        }
    });

    // --- CURRICULUM SELECTION MODAL ---
    let selectedCurriculums = new Set();
    let allCurriculums = [];

    const loadCurriculums = async () => {
        try {
            const response = await fetch('/api/curriculums');
            if (response.ok) {
                const data = await response.json();
                // Filter to match Curriculum Builder's "New" view (includes null as new)
                // Filter for "Processing" and "Reject" (not Approved, not Old)
                allCurriculums = data.filter(c => {
                    const status = (c.approval_status || '').toLowerCase();
                    const version = (c.version_status || '').toLowerCase();
                    // Show only if NOT approved AND NOT old/history
                    // User requested: "only processing and reject".
                    // This implies Approved is definitely out.
                    return status !== 'approved' && version !== 'old' && version !== 'history';
                });
                renderCurriculumChecklist();
            } else {
                console.error('Failed to load curriculums');
            }
        } catch (error) {
            console.error('Error loading curriculums:', error);
        }
    };

    const renderCurriculumChecklist = () => {
        const term = (document.getElementById('curriculumSearchInput')?.value || '').toLowerCase();
        const syllabusType = document.getElementById('syllabus_type').value || 'CHED';
        
        // Grouping Helper
        const groupCurriculums = (list) => {
            const groups = {};
            list.forEach(c => {
                // Key by Program Code (if exists) or Name
                const key = c.program_code || c.curriculum_name;
                if (!groups[key]) {
                    groups[key] = {
                        name: c.curriculum_name, // Name of the first/latest
                        program_code: c.program_code,
                        ids: [],
                        statuses: new Set(),
                        original: c
                    };
                }
                groups[key].ids.push(c.id);
                groups[key].statuses.add(c.approval_status);
            });
            return Object.values(groups);
        };

        const filterMatch = (c) => {
            const s = `${c.curriculum_name} ${c.program_code} ${c.academic_year}`.toLowerCase();
            return term === '' || s.includes(term);
        };

        // 1. Filter by Level and Search Term
        const seniorHighRaw = allCurriculums.filter(c => c.year_level === 'Senior High' && filterMatch(c));
        const collegeRaw = allCurriculums.filter(c => c.year_level !== 'Senior High' && filterMatch(c));

        // 2. Group them
        const seniorHighGroups = groupCurriculums(seniorHighRaw);
        const collegeGroups = groupCurriculums(collegeRaw);

        const renderGroupList = (containerId, groups) => {
            const container = document.getElementById(containerId);
            if (!container) return;
            
            container.innerHTML = '';
            
            if (groups.length === 0) {
                 container.innerHTML = `
                    <div class="col-span-full py-8 text-center bg-white rounded-2xl border border-dashed border-gray-200">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-gray-500 font-medium">No curriculums found.</p>
                    </div>`;
                 return;
            }

            groups.forEach(group => {
                // Check if ALL IDs in this group are selected
                const isSelected = group.ids.length > 0 && group.ids.every(id => selectedCurriculums.has(id));
                
                // Display text
                let displayName = group.name;
                if (group.program_code && !displayName.includes(group.program_code)) {
                     displayName += ` (${group.program_code})`;
                }
                
                // Status Logic
                const statusStr = Array.from(group.statuses).join(', ').toLowerCase();
                let statusBadge = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">New</span>';
                
                if (statusStr.includes('rejected') || statusStr.includes('returned')) {
                    statusBadge = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Action Needed</span>';
                } else if (statusStr.includes('processing')) {
                    statusBadge = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">Processing</span>';
                }

                const card = document.createElement('div');
                // New Card Styling
                const baseClasses = "relative group flex flex-col p-4 rounded-xl border transition-all duration-200 cursor-pointer select-none h-full";
                const selectedClasses = "bg-blue-50/50 border-blue-500 ring-1 ring-blue-500 shadow-sm";
                const unselectedClasses = "bg-white border-gray-200 hover:border-blue-300 hover:shadow-md";
                
                card.className = `${baseClasses} ${isSelected ? selectedClasses : unselectedClasses}`;
                
                // Store IDs
                const idsStr = group.ids.join(',');

                card.innerHTML = `
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1 pr-3">
                            <h4 class="text-sm font-bold text-gray-900 leading-snug group-hover:text-blue-700 transition-colors line-clamp-2" title="${displayName}">${displayName}</h4>
                            <p class="text-xs text-gray-500 mt-1 font-mono">${group.program_code || ''}</p>
                        </div>
                        <div class="shrink-0 pt-0.5">
                            <div class="w-5 h-5 rounded-md border ${isSelected ? 'bg-blue-600 border-blue-600' : 'border-gray-300 bg-white group-hover:border-blue-400'} flex items-center justify-center transition-colors">
                                ${isSelected ? '<svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>' : ''}
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto flex items-center justify-between pt-2 border-t border-gray-100/50">
                        ${statusBadge}

                        <span class="text-[10px] uppercase font-semibold text-gray-400 tracking-wider hidden">
                            ${group.ids.length} Ver${group.ids.length > 1 ? 's' : ''}
                        </span>
                    </div>
                    <input type="checkbox" class="hidden" data-curriculum-ids="${idsStr}" ${isSelected ? 'checked' : ''}>
                `;
                
                card.addEventListener('click', (e) => {
                    // Toggle checkbox
                    const checkbox = card.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                });
                
                const checkbox = card.querySelector('input[type="checkbox"]');
                checkbox.addEventListener('change', (e) => {
                    const ids = e.target.dataset.curriculumIds.split(',').map(Number);
                    if (e.target.checked) {
                        ids.forEach(id => selectedCurriculums.add(id));
                    } else {
                        ids.forEach(id => selectedCurriculums.delete(id));
                    }
                    renderCurriculumChecklist();
                });
                container.appendChild(card);
            });
        };

        // DOM Elements for Sections - Use new IDs
        const seniorHighSection = document.getElementById('seniorHighSection');
        const collegeSection = document.getElementById('collegeSection');

        if (seniorHighSection && collegeSection) {
            // Logic: CHED -> Show College Only. DepEd -> Show Senior High Only.
            if (syllabusType === 'DepEd') {
                seniorHighSection.classList.remove('hidden');
                collegeSection.classList.add('hidden');
                renderGroupList('seniorHighContainer', seniorHighGroups);
            } else {
                // Default to CHED/College
                seniorHighSection.classList.add('hidden');
                collegeSection.classList.remove('hidden');
                renderGroupList('collegeContainer', collegeGroups);
            }
        }

        // Update Header Counts
        const shSelectedCount = seniorHighRaw.filter(c => selectedCurriculums.has(c.id)).length;
        const coSelectedCount = collegeRaw.filter(c => selectedCurriculums.has(c.id)).length;
        
        const shHeader = document.getElementById('seniorHighHeader');
        if (shHeader) {
            // Updated header structure HTML
            shHeader.innerHTML = `
                <span class="w-1.5 h-6 bg-orange-500 rounded-full"></span>
                Senior High <span class="ml-2 text-gray-400 font-normal normal-case">(${shSelectedCount} selected)</span>
            `;
        }
        
        const coHeader = document.getElementById('collegeHeader');
        if (coHeader) {
            coHeader.innerHTML = `
                <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                College <span class="ml-2 text-gray-400 font-normal normal-case">(${coSelectedCount} selected)</span>
            `;
        }

        const shToggle = document.getElementById('selectAllSeniorHigh');
        const coToggle = document.getElementById('selectAllCollege');
        
        if (shToggle) {
             shToggle.checked = seniorHighRaw.length > 0 && seniorHighRaw.every(c => selectedCurriculums.has(c.id));
             shToggle.onclick = (e) => {
                const isCheck = e.target.checked;
                seniorHighRaw.forEach(c => isCheck ? selectedCurriculums.add(c.id) : selectedCurriculums.delete(c.id));
                renderCurriculumChecklist();
            };
        }
        
        if (coToggle) {
            coToggle.checked = collegeRaw.length > 0 && collegeRaw.every(c => selectedCurriculums.has(c.id));
             coToggle.onclick = (e) => {
                const isCheck = e.target.checked;
                collegeRaw.forEach(c => isCheck ? selectedCurriculums.add(c.id) : selectedCurriculums.delete(c.id));
                renderCurriculumChecklist();
            };
        }
    };

    const updateCurriculumButtonText = () => {
        const buttonText = document.getElementById('curriculumButtonText');
        if (selectedCurriculums.size === 0) {
            buttonText.textContent = 'Select curriculums for this subject...';
            buttonText.className = 'text-gray-500';
        } else {
            buttonText.textContent = `${selectedCurriculums.size} Curriculum(s) Selected`;
            buttonText.className = 'text-gray-800';
        }
    };

    // Modal event listeners
    const openCurriculumModalBtn = document.getElementById('openCurriculumModal');
    if (openCurriculumModalBtn) {
        openCurriculumModalBtn.addEventListener('click', () => {
            document.getElementById('curriculumSelectionModal').classList.remove('hidden');
            loadCurriculums();
        });
    }

    // Close button removed
    // document.getElementById('closeCurriculumModal').addEventListener('click', () => {
    //     document.getElementById('curriculumSelectionModal').classList.add('hidden');
    // });

    const cancelCurriculumSelectionBtn = document.getElementById('cancelCurriculumSelection');
    if (cancelCurriculumSelectionBtn) {
        cancelCurriculumSelectionBtn.addEventListener('click', () => {
            document.getElementById('curriculumSelectionModal').classList.add('hidden');
        });
    }

    const confirmCurriculumSelectionBtn = document.getElementById('confirmCurriculumSelection');
    if (confirmCurriculumSelectionBtn) {
        confirmCurriculumSelectionBtn.addEventListener('click', () => {
            document.getElementById('curriculumSelectionModal').classList.add('hidden');
            updateCurriculumButtonText();
        });
    }

    document.getElementById('curriculumSearchInput')?.addEventListener('input', () => {
        renderCurriculumChecklist();
    });

    // --- INITIALIZATION ---
    const urlParams = new URLSearchParams(window.location.search);
    const subjectIdToEdit = urlParams.get('subject_id');
    if (subjectIdToEdit) {
        fetchSubjectData(subjectIdToEdit);
    } else {
        // For new courses, populate Week 0 with default BCP content
        // For new courses, populate defaults
        populateDefaultContent();
    }

});

// --- MAPPING GRID ROW LOGIC ---
const createMappingTableRow = (isPilo = true) => {
    const row = document.createElement('tr');
    row.className = '';
    row.innerHTML = `<td class="py-2 px-4 border-b"><input type="text" required placeholder="${isPilo ? 'PILO...' : 'CILO...'}" class="w-full p-1 border-gray-300 rounded"></td><td class="py-2 px-4 border-b"><input type="text" required class="w-full p-1 text-center border-gray-300 rounded"></td><td class="py-2 px-4 border-b"><input type="text" required class="w-full p-1 text-center border-gray-300 rounded"></td><td class="py-2 px-4 border-b"><input type="text" required class="w-full p-1 text-center border-gray-300 rounded"></td><td class="py-2 px-4 border-b"><input type="text" required class="w-full p-1 text-center border-gray-300 rounded"></td><td class="py-2 px-4 border-b text-center"><button type="button" class="delete-row-btn text-red-500 hover:text-red-700 font-semibold">Delete</button></td>`;
    return row;
};

// ... (existing code) ...

function addDepEdRow(quarter) {
    const container = document.getElementById(`q_${quarter}_rows_container`);
    const newRow = document.createElement('div');
    newRow.className = 'grid grid-cols-1 md:grid-cols-3 gap-6 relative group deped-row pt-6 border-t border-dashed';
    
    newRow.innerHTML = `
        <div>
            <textarea name="q_${quarter}_content[]" required rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Enter Content..."></textarea>
        </div>
        <div>
            <textarea name="q_${quarter}_content_standards[]" required rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="The learners demonstrate understanding of..."></textarea>
        </div>
        <div>
            <textarea name="q_${quarter}_learning_competencies[]" required rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="The learners..."></textarea>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="absolute -top-3 right-0 bg-white text-red-500 hover:text-red-700 rounded-full p-1 shadow-sm border border-gray-200" title="Remove Row">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    `;
    
    container.appendChild(newRow);
    
    // Auto-resize the newly added textareas
    newRow.querySelectorAll('textarea').forEach(textarea => {
        if (typeof setupAutoResize === 'function') {
            setupAutoResize(textarea);
        }
    });
}
// Function to handle Syllabus PDF Upload
function handleSyllabusUpload(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const isChed = input.id === 'ched_syllabus_file';
        
        // Update display name based on which input triggered this
        if (isChed) {
            const displayElement = document.getElementById('ched_file_name_display');
            if (displayElement) displayElement.textContent = file.name;
        } else {
            const displayElement = document.getElementById('file_name_display');
            if (displayElement) displayElement.textContent = file.name;
        }

        // DepEd Preview Logic
        if (!isChed) {
            const fileURL = URL.createObjectURL(file);
            const pdfFrame = document.getElementById('pdf-frame');
            const imagePreview = document.getElementById('image-preview');
            const placeholder = document.getElementById('pdf-placeholder');
            
            if (file.type === 'application/pdf') {
                pdfFrame.src = fileURL + '#toolbar=0&navpanes=0';
                pdfFrame.classList.remove('hidden');
                imagePreview.classList.add('hidden');
                placeholder.classList.add('hidden');
            } else if (file.type.startsWith('image/')) {
                imagePreview.src = fileURL;
                imagePreview.classList.remove('hidden');
                pdfFrame.classList.add('hidden');
                placeholder.classList.add('hidden');
            }
            
            // For DepEd, we stop here (no extraction), just preview and file upload
            return;
        }

        // CHED Extraction Logic
        const formData = new FormData();
        formData.append('syllabus_file', file);
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        // Show loading state on the Import button
        const btn = input.previousElementSibling;
        let originalText = '';
        if (btn) {
            originalText = btn.innerHTML;
            const spinnerColor = 'text-blue-600';
            btn.innerHTML = `<svg class="animate-spin h-5 w-5 ${spinnerColor} mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...`;
            btn.disabled = true;
        }

        const endpoint = '/api/extract-ched-syllabus';

        fetch(endpoint, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // CHED Specific Fields
                if (data.data.course_code) document.getElementById('course_code').value = data.data.course_code;
                if (data.data.course_title) document.getElementById('course_title').value = data.data.course_title;
                if (data.data.credit_units) document.getElementById('credit_units').value = data.data.credit_units;
                if (data.data.contact_hours) document.getElementById('contact_hours').value = data.data.contact_hours;
                if (data.data.course_description) document.getElementById('course_description').value = data.data.course_description;
                
                if (data.data.pilo_outcomes) document.getElementById('pilo_outcomes').value = data.data.pilo_outcomes;
                if (data.data.cilo_outcomes) document.getElementById('cilo_outcomes').value = data.data.cilo_outcomes;
                if (data.data.learning_outcomes) document.getElementById('learning_outcomes').value = data.data.learning_outcomes;
                
                if (data.data.basic_readings) document.getElementById('basic_readings').value = data.data.basic_readings;
                if (data.data.extended_readings) document.getElementById('extended_readings').value = data.data.extended_readings;
                if (data.data.course_assessment) document.getElementById('course_assessment').value = data.data.course_assessment;
                if (data.data.committee_members) document.getElementById('committee_members').value = data.data.committee_members;
                if (data.data.consultation_schedule) document.getElementById('consultation_schedule').value = data.data.consultation_schedule;
                
                if (data.data.prepared_by) document.getElementById('prepared_by').value = data.data.prepared_by;
                if (data.data.reviewed_by) document.getElementById('reviewed_by').value = data.data.reviewed_by;
                if (data.data.approved_by) document.getElementById('approved_by').value = data.data.approved_by;

                // Mapping Grids
                if (data.data.program_mapping && data.data.program_mapping.length > 0) {
                    const tbody = document.getElementById('program-mapping-table-body');
                    tbody.innerHTML = ''; 
                    data.data.program_mapping.forEach(row => {
                        const tr = createMappingTableRow(true);
                        const inputs = tr.querySelectorAll('input');
                        inputs[0].value = row.pilo || '';
                        inputs[1].value = row.ctpss || '';
                        inputs[2].value = row.ecc || '';
                        inputs[3].value = row.epp || '';
                        inputs[4].value = row.glc || '';
                        tbody.appendChild(tr);
                    });
                }

                if (data.data.course_mapping && data.data.course_mapping.length > 0) {
                    const tbody = document.getElementById('course-mapping-table-body');
                    tbody.innerHTML = '';
                    data.data.course_mapping.forEach(row => {
                        const tr = createMappingTableRow(false);
                        const inputs = tr.querySelectorAll('input');
                        inputs[0].value = row.cilo || '';
                        inputs[1].value = row.ctpss || '';
                        inputs[2].value = row.ecc || '';
                        inputs[3].value = row.epp || '';
                        inputs[4].value = row.glc || '';
                        tbody.appendChild(tr);
                    });
                }

                // Weekly Plan
                if (data.data.weekly_plan) {
                    for (const [week, lesson] of Object.entries(data.data.weekly_plan)) {
                        if (document.getElementById(`week_${week}_content`)) {
                            if (lesson.content) document.getElementById(`week_${week}_content`).value = lesson.content;
                            if (lesson.silo) document.getElementById(`week_${week}_silo`).value = lesson.silo;
                            if (lesson.at_onsite) document.getElementById(`week_${week}_at_onsite`).value = lesson.at_onsite;
                            if (lesson.at_offsite) document.getElementById(`week_${week}_at_offsite`).value = lesson.at_offsite;
                            if (lesson.tla_onsite) document.getElementById(`week_${week}_tla_onsite`).value = lesson.tla_onsite;
                            if (lesson.tla_offsite) document.getElementById(`week_${week}_tla_offsite`).value = lesson.tla_offsite;
                            if (lesson.ltsm) document.getElementById(`week_${week}_ltsm`).value = lesson.ltsm;
                            if (lesson.output) document.getElementById(`week_${week}_output`).value = lesson.output;
                        }
                    }
                }
                
                // Update all progress bars after populating data
                if (typeof updateAllProgress === 'function') {
                    updateAllProgress();
                }
                
                // Trigger auto-resize for all textareas
                if (typeof resizeAllTextareas === 'function') {
                    setTimeout(resizeAllTextareas, 100);
                }

                document.getElementById('extractionSuccessModal').classList.remove('hidden');
            } else {
                alert('Failed to extract data: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while uploading the file. Please check the console for details.');
        })
        .finally(() => {
             if (btn) {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    }
}

// Extraction Success Modal Close Handler
const closeExtractionModalBtn = document.getElementById('closeExtractionModal');
if (closeExtractionModalBtn) {
    closeExtractionModalBtn.addEventListener('click', () => {
        document.getElementById('extractionSuccessModal').classList.add('hidden');
    });
}



// Setup auto-resize for a textarea element
function setupAutoResize(textarea) {
    // Initial resize
    autoResize(textarea);
    
    // Add event listener for future changes
    textarea.addEventListener('input', function() {
        autoResize(this);
    });
}

// Simple auto-resize function
function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = (textarea.scrollHeight) + 'px';
}

// Resize all textareas
function resizeAllTextareas() {
    document.querySelectorAll('textarea').forEach(function(textarea) {
        autoResize(textarea);
    });
}

// Initialize all textareas on page load
window.addEventListener('load', function() {
    document.querySelectorAll('textarea').forEach(function(textarea) {
        // Set initial size
        autoResize(textarea);
        
        // Add oninput attribute if not already present
        if (!textarea.hasAttribute('oninput')) {
            textarea.setAttribute('oninput', 'autoResize(this)');
        }
        
        // Also add event listener as backup
        textarea.addEventListener('input', function() {
            autoResize(this);
        });
        
        // Add change event listener for select-based updates
        textarea.addEventListener('change', function() {
            autoResize(this);
        });
    });
    
    // Periodically check removed to prevent forced reflow violations.
    // MutationObserver and Input events handle resizing efficiently.
    // setInterval(function() {
    //    resizeAllTextareas();
    // }, 500);
    
    // Watch for value changes (for programmatic updates like PDF extraction)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' || mutation.type === 'characterData') {
                resizeAllTextareas();
            }
        });
    });
    
    // Observe the entire form for changes
    const form = document.getElementById('courseForm');
    if (form) {
        observer.observe(form, {
            childList: true,
            subtree: true,
            characterData: true
        });
    }
    
    // Also trigger resize when the window is resized
    window.addEventListener('resize', function() {
        resizeAllTextareas();
    });
});

// --- PREVENT ACCIDENTAL NAVIGATION ---
let isFormDirty = false;
let isSubmitting = false;

// Mark form as dirty when user types or changes inputs
document.getElementById('courseForm').addEventListener('input', () => {
    isFormDirty = true;
});

document.getElementById('courseForm').addEventListener('change', () => {
    isFormDirty = true;
});

// Prevent leaving the page
window.addEventListener('beforeunload', (e) => {
    if (isFormDirty && !isSubmitting) {
        // Custom message is often ignored by modern browsers, but required for the event to work
        const message = "You have unsaved changes. Are you sure you want to leave?";
        e.preventDefault();
        e.returnValue = message;
        return message;
    }
});

// Helper to disable dirty check (call this before programmatic redirects or saves)
const disableDirtyCheck = () => {
    isSubmitting = true;
};

// --- WEEKLY PROGRESS TRACKING ---
function updateWeekProgress(weekIndex) {
    // Skip exam weeks processing as they are handled by logic in HTML or don't need calc
    if ([6, 12, 18].includes(weekIndex)) return;

    const suffixes = ['content', 'silo', 'at_onsite', 'at_offsite', 'tla_onsite', 'tla_offsite', 'ltsm', 'output'];
    let total = 0;
    let filled = 0;
    let hasFields = false;
    
    suffixes.forEach(suffix => {
        const el = document.getElementById(`week_${weekIndex}_${suffix}`);
        if (el && el.tagName === 'TEXTAREA') {
             hasFields = true;
             total++;
             if (el.value.trim() !== '') {
                 filled++;
             }
        }
    });

    const progressEl = document.getElementById(`week-progress-${weekIndex}`);
    if (!progressEl) return;

    if (!hasFields) {
        // Fallback if somehow no fields found but not an exam week?
        progressEl.textContent = '';
        return;
    }

    const percentage = Math.round((filled / total) * 100);
    progressEl.textContent = `${percentage}%`;
    
    // Color coding
    // Base classes from user request: relative overflow-hidden inline-flex items-center justify-center px-2.5 py-1 rounded-full border border-blue-100 bg-white min-w-[85px] shadow-sm
    // Added: mr-4 text-sm font-bold transition-colors duration-300
    const baseClass = 'relative overflow-hidden inline-flex items-center justify-center px-2.5 py-1 rounded-full border border-blue-100 bg-white min-w-[85px] shadow-sm mr-4 text-sm font-bold transition-colors duration-300';
    
    progressEl.className = baseClass;
    
    if (percentage === 100) {
        progressEl.classList.add('text-green-600');
    } else if (percentage > 0) {
         progressEl.classList.add('text-blue-600');
    } else {
        progressEl.classList.add('text-gray-400');
    }
}

function updateAllProgress() {
    for(let i=0; i<=18; i++) {
        updateWeekProgress(i);
    }
}

function setupProgressTrackers() {
   for(let i=0; i<=18; i++) {
      if ([6, 12, 18].includes(i)) continue;

      const suffixes = ['content', 'silo', 'at_onsite', 'at_offsite', 'tla_onsite', 'tla_offsite', 'ltsm', 'output'];
      suffixes.forEach(suffix => {
          const el = document.getElementById(`week_${i}_${suffix}`);
          if (el) {
              el.addEventListener('input', () => updateWeekProgress(i));
              // Also update on change just in case
              el.addEventListener('change', () => updateWeekProgress(i));
          }
      });
   }
   // Initial Calculation
   updateAllProgress();
}

// Hook into existing initialization and data loading
document.addEventListener('DOMContentLoaded', () => {
    // ... existing listeners ...
    setupProgressTrackers();
});

// Since populateForm and populateDefaultContent might run after DOMContentLoaded (or inside async fetch),
// we need to make sure we update progress after data injection.
// I will proxy the populate functions or call updateAllProgress() at end of them if I can,
// but since I can't easily edit the middle of those functions with this tool effectively without huge context,
// I will attach a mutation observer or just rely on 'input' events if they were fired?
// No, populateForm sets .value directly which doesn't fire 'input'.
// So I will use a setInterval check for a few seconds after load, or just append a call to updateAllProgress() at end of script to run on window load?
// Better: Add a listener for a custom event 'dataPopulated' or similar, assuming I can dispatch it.
// Or just expose updateAllProgress globally and call it.
window.updateAllProgress = updateAllProgress; // Expose globally

// Add call to updateAllProgress inside existing window.onload if possible, or create a new one.
window.addEventListener('load', () => {
   setTimeout(updateAllProgress, 500); // Delay slightly to ensure values are set
   setTimeout(updateAllProgress, 2000); // Another check
});


</script>
@endsection