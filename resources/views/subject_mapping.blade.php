@extends('layouts.app')

@section('content')
<style>
    /* Icon background styles */
    .icon-bg-default { background-color: #F3F4F6; border: 2px solid #E5E7EB; } /* Default Gray */
    .icon-bg-major { background-color: #DBEAFE; border: 2px solid #BFDBFE; }   /* Blue */
    .icon-bg-minor { background-color: #E9D5FF; border: 2px solid #D8B4FE; }   /* Violet */
    .icon-bg-elective { background-color: #FEE2E2; border: 2px solid #FECACA; } /* Red */
    .icon-bg-general { background-color: #FFEDD5; border: 2px solid #FED7AA; } /* Orange */

    /* Icon colors - commented out as we now use text-white for assigned cards */
    /* .icon-major { color: #3B82F6; } */
    /* .icon-minor { color: #8B5CF6; } */
    /* .icon-elective { color: #EF4444; } */
    /* .icon-general { color: #F97316; } */
    .assigned-major { background-color: #DBEAFE; border-color: #BFDBFE; }
    .assigned-minor { background-color: #E9D5FF; border-color: #D8B4FE; }
    .assigned-elective { background-color: #FEE2E2; border-color: #FECACA; }
    .assigned-general { background-color: #FFEDD5; border-color: #FED7AA; }

    .assigned-card {
        background-color: #e0e7ff; 
        border-color: #a5b4fc;
    }
    .assigned-card .subject-name {
        color: #4338ca;
    }
    
    /* Complete semester styling */
    .semester-complete {
        border-color: #10b981 !important; /* Green border for completed semesters */
        border-width: 2px !important;
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2), 0 2px 4px -1px rgba(16, 185, 129, 0.1) !important; /* Green-tinted shadow */
    }
    
    .semester-complete .add-subject-btn {
        display: none !important;
    }
    
    .semester-complete::before {
        content: "✓ Complete";
        position: absolute;
        top: 8px;
        right: 8px;
        background: #10b981;
        color: white;
        font-size: 10px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 4px;
        z-index: 10;
    }
    
    /* Custom checkbox styling with checkmark */
    .add-subject-checkbox input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #D1D5DB;
        border-radius: 0.25rem;
        background-color: white;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .add-subject-checkbox input[type="checkbox"]:hover {
        border-color: #9CA3AF;
    }
    
    .add-subject-checkbox input[type="checkbox"]:checked {
        background-color: #2563EB;
        border-color: #2563EB;
    }
    
    .add-subject-checkbox input[type="checkbox"]:checked::after {
        content: "✓";
        display: block;
        color: white;
        font-size: 1rem;
        font-weight: bold;
        line-height: 1;
        text-align: center;
    }
    
    .add-subject-checkbox input[type="checkbox"]:focus {
        outline: 2px solid #3B82F6;
        outline-offset: 2px;
    }

    /* Force white color for icons in assigned cards */
    .subject-card svg.text-white,
    .subject-tag svg.text-white {
        color: white !important;
        stroke: white !important;
    }
    
    /* Hide all + Select Subject buttons when there are pending subjects */
    body.has-pending-subjects .add-subject-btn-placeholder {
        display: none !important;
    }
</style>
<main class="flex-1 overflow-y-auto bg-gray-100 p-6 flex flex-col">
    <div class="bg-white rounded-2xl shadow-xl p-8 flex-1 flex flex-col">
        
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-bold text-gray-800">Subject Mapping</h1>
                <p class="text-sm text-gray-500 mt-1">Drag and drop subjects to build the curriculum.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 flex-1 min-h-0">
            
            <div class="lg:col-span-1 bg-gray-50 border border-gray-200 rounded-xl p-6 flex flex-col h-full">
                <div class="pb-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Available Subjects</h2>
                    <p class="text-sm text-gray-500">Find and select subjects to add to the curriculum.</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 my-4">
                    <div class="relative flex-grow">
                        <input type="text" id="searchInput" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Search subject...">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <select id="typeFilter" class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="All Types">All Types</option>
                        <option value="Major">Major</option>
                        <option value="Minor">Minor</option>
                    </select>
                </div>



                <div id="availableSubjects" class="flex-1 pr-2 -mr-2 space-y-3 pt-2.5">
                    <p class="text-gray-500 text-center mt-4">Select a curriculum to view subjects.</p>
                </div>
            </div>

            <div class="lg:col-span-2 bg-gray-50 border border-gray-200 rounded-xl p-6 flex flex-col">
                <div class="pb-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2 sm:mb-0">Curriculum Overview</h2>
                    <div class="relative w-full sm:w-auto">
                        <div id="curriculumDropdown" class="relative">
                            <button type="button" id="curriculumDropdownButton" class="w-full sm:w-[850px] border border-gray-300 rounded-lg p-2 bg-white text-left focus:outline-none focus:ring-2 focus:ring-blue-500 transition flex justify-between items-center">
                                <span id="curriculumDropdownText" class="text-gray-500 truncate">Select a Curriculum</span>
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div id="curriculumDropdownMenu" class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-80 overflow-hidden">
                                <div class="p-2 border-b border-gray-200">
                                    <input type="text" id="curriculumSearchInput" placeholder="Search curriculums..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                </div>
                                <div id="curriculumOptions" class="max-h-60 overflow-y-auto">
                                    <!-- Options will be populated here -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hidden select for form compatibility -->
                        <select id="curriculumSelector" class="hidden">
                            <option value="">Select a Curriculum</option>
                        </select>
                    </div>
                </div>


                <div class="px-1">
                    <div id="curriculumOverview" class="mt-4 space-y-6">
                        <p class="text-gray-500 text-center mt-4">Select a curriculum from the dropdown to start mapping subjects.</p>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between items-center gap-4 mb-4">
                        <div id="grand-total-container" class="hidden px-5 py-3 bg-white border-2 border-blue-200 text-gray-700 rounded-xl flex items-center gap-3 shadow-md border-l-4 border-l-blue-500">
                            <div class="bg-blue-100 p-2.5 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-semibold text-gray-600">Total Curriculum Units:</span>
                                <span id="grand-total-units" class="text-2xl font-bold text-blue-700">0</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button id="editCurriculumButton" class="px-6 py-3 rounded-lg text-sm font-semibold text-white bg-blue-700 border-2 border-blue-700 hover:bg-white hover:text-blue-700 hover:shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-md hidden">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"></path></svg>
                                Revise
                            </button>
                            <button id="saveCurriculumButton" class="px-6 py-3 rounded-lg text-sm font-semibold text-white bg-green-700 border-2 border-green-700 hover:bg-white hover:text-green-700 hover:shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-md hidden" disabled>
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v6a2 2 0 002 2h6m4-4H9m0 0V9m0 0V5a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2h-3m-4-4V9"></path></svg>
                                Save the Mapping
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
 {{-- CHED Subject Details Modal --}}
<div id="chedSubjectDetailsModal" class="fixed inset-0 z-[100] overflow-y-auto bg-black bg-opacity-60 transition-opacity duration-300 ease-out hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-7xl max-h-[95vh] rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col" id="ched-modal-details-panel">
            <div class="flex justify-between items-center px-10 py-6 border-b border-gray-200 bg-white z-10 rounded-t-2xl shrink-0">
                 <div>
                    <h2 id="chedSubjectName" class="text-3xl font-bold text-gray-800">Subject Details (CHED)</h2>
                 </div>
                <button id="closeChedDetailsModal" class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200 p-2 rounded-full hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-8 md:p-10 bg-gray-50 overflow-y-auto flex-1">
                <!-- Section 1: Course Information -->
                <div class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Course Information
                    </h2>
                    <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                             <div><label class="block text-sm font-medium text-gray-700 mb-2">Course Title</label><div id="chedCourseTitle" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Course Code</label><div id="chedSubjectCode" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Course Type</label><div id="chedSubjectType" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Credit Units</label><div id="chedSubjectUnit" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Contact Hours</label><div id="chedContactHours" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Memorandum Year</label><div id="chedMemorandumYear" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Credit Prerequisites</label><div id="chedPrerequisites" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-2">Pre-requisite to</label><div id="chedPrereqTo" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>

                            <div class="md:col-span-3"><label class="block text-sm font-medium text-gray-700 mb-2">Official Memorandum</label><div id="chedMemorandum" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium break-words"></div></div>
                            <div class="md:col-span-3"><label class="block text-sm font-medium text-gray-700 mb-2">Course Description</label><div id="chedCourseDescription" class="p-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 text-sm whitespace-pre-wrap leading-relaxed"></div></div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Mapping Grids -->
                <div class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Mapping Grids
                    </h2>
                    <div class="space-y-6">
                        <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">PROGRAM MAPPING GRID</h3>
                            <div id="chedProgramMapping"></div>
                        </div>
                        <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                             <h3 class="text-lg font-semibold text-gray-700 mb-4">COURSE MAPPING GRID</h3>
                            <div id="chedCourseMapping"></div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Learning Outcomes -->
                <div class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Learning Outcomes
                    </h2>
                    <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100 space-y-8">
                         <div><label class="block text-lg font-semibold text-gray-700 mb-3">PROGRAM INTENDED LEARNING OUTCOMES (PILO)</label><div id="chedPILO" class="p-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 text-sm whitespace-pre-wrap leading-relaxed"></div></div>
                        <div><label class="block text-lg font-semibold text-gray-700 mb-3">Course Intended Learning Outcomes (CILO)</label><div id="chedCILO" class="p-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 text-sm whitespace-pre-wrap leading-relaxed"></div></div>
                        <div><label class="block text-lg font-semibold text-gray-700 mb-3">Learning Outcomes</label><div id="chedLearningOutcomes" class="p-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 text-sm whitespace-pre-wrap leading-relaxed"></div></div>
                    </div>
                </div>

                <!-- Section 4: Weekly Plan -->
                <div class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Weekly Plan (Weeks 0-18)
                    </h2>
                    <div id="chedLessonsContainer" class="space-y-4">
                        <p class="text-gray-500 italic p-4">Loading weekly plan...</p>
                    </div>
                </div>

                <!-- Section 5: Course Requirements -->
                <div class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h6m-6 4h6m-6 4h6"></path></svg>
                        Course Requirements and Policies
                    </h2>
                    <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                             <div><label class="block text-sm font-medium text-gray-700 mb-2">Basic Readings / Textbooks</label><div id="chedBasicReadings" class="p-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 text-sm whitespace-pre-wrap min-h-[100px]"></div></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Extended Readings / References</label><div id="chedExtendedReadings" class="p-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 text-sm whitespace-pre-wrap min-h-[100px]"></div></div>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-2">Course Assessment</label><div id="chedCourseAssessment" class="p-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 text-sm whitespace-pre-wrap min-h-[100px]"></div></div>
                    </div>
                </div>

                <!-- Section 6: Approval -->
                <div class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Committee and Approval
                    </h2>
                     <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                        <div class="grid grid-cols-1 gap-8 mb-8">
                             <div><label class="block text-sm font-medium text-gray-700 mb-2">Committee Members</label><div id="chedCommitteeMembers" class="p-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 text-sm whitespace-pre-wrap"></div></div>
                             <div><label class="block text-sm font-medium text-gray-700 mb-2">Consultation Schedule</label><div id="chedConsultationSchedule" class="p-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 text-sm whitespace-pre-wrap"></div></div>
                        </div>
                         <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                             <div><label class="block text-sm font-medium text-gray-700 mb-2">Prepared By</label><div id="chedPreparedBy" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                             <div><label class="block text-sm font-medium text-gray-700 mb-2">Reviewed By</label><div id="chedReviewedBy" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Approved By</label><div id="chedApprovedBy" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                        </div>
                    </div>
                </div>
            </div>
            
             <div class="flex justify-between items-center p-6 border-t border-gray-200 bg-white rounded-b-2xl shrink-0 z-10">
                <div class="text-sm text-gray-500">
                    <span class="font-semibold">Created:</span>
                    <span id="chedDetailsCreatedAt"></span>
                </div>
                <div>
                     <button id="exportChedPdfButton" class="px-6 py-2.5 text-sm font-bold text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors shadow-lg hover:shadow-xl flex items-center gap-2 transform active:scale-95 duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export to PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

 {{-- DepEd Subject Details Modal --}}
<div id="depedSubjectDetailsModal" class="fixed inset-0 z-[100] overflow-y-auto bg-black bg-opacity-60 transition-opacity duration-300 ease-out hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-7xl max-h-[95vh] rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col" id="deped-modal-details-panel">
            <div class="flex justify-between items-center px-10 py-6 border-b border-gray-200 bg-white z-10 rounded-t-2xl shrink-0">
                 <div>
                    <h2 id="depedSubjectName" class="text-3xl font-bold text-gray-800">Subject Details (DepEd)</h2>
                 </div>
                <button id="closeDepedDetailsModal" class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200 p-2 rounded-full hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-8 md:p-10 bg-gray-50 overflow-y-auto flex-1">
                <!-- DepEd Section 1: Course Information -->
                <div class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Course Information
                    </h2>
                    <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                             <div><label class="block text-sm font-medium text-gray-700 mb-2">Course Title</label><div id="depedCourseTitle" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Course Code</label><div id="depedSubjectCode" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Course Type</label><div id="depedSubjectType" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Document Category</label><div id="depedMemorandumCategory" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            
                            <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-2">Title</label><div id="depedTitle" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium break-words"></div></div>

                            <div class="md:col-span-3"><label class="block text-sm font-medium text-gray-700 mb-2">Official Memorandum</label><div id="depedMemorandum" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium break-words"></div></div>

                            <div id="depedTimeAllotmentContainer"><label class="block text-sm font-medium text-gray-700 mb-2">Time Allotment</label><div id="depedTimeAllotment" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            <div id="depedScheduleContainer" class="md:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-2">Schedule</label><div id="depedSchedule" class="py-3 px-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 font-medium"></div></div>
                            
                            <div id="depedCourseDescriptionContainer" class="md:col-span-3"><label class="block text-sm font-medium text-gray-700 mb-2">Course Description</label><div id="depedCourseDescription" class="p-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 text-sm whitespace-pre-wrap leading-relaxed"></div></div>
                        </div>
                    </div>
                </div>

                <!-- Syllabus Preview Section -->
                <div id="depedSyllabusSection" class="mb-10 hidden">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Syllabus Document
                    </h2>
                    <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                        <p id="depedSyllabusFileName" class="text-sm font-medium text-gray-700 mb-4 bg-gray-50 p-2 rounded border border-gray-200 inline-block"></p>
                        <div id="depedSyllabusPreview" class="w-full h-[600px] border border-gray-200 rounded-lg overflow-hidden relative bg-gray-100 flex items-center justify-center">
                             <iframe id="depedPdfFrame" class="w-full h-full hidden" src=""></iframe>
                             <img id="depedImagePreview" class="max-w-full max-h-full object-contain hidden" src="" alt="Syllabus Preview">
                             <p id="depedNoPreview" class="text-gray-400">No preview available</p>
                        </div>
                    </div>
                </div>

                <!-- DepEd Section 2: Curriculum Guide -->
                <div id="depedCurriculumGuideSection" class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Curriculum Guide
                    </h2>
                    <div class="space-y-6">
                        <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                             <h3 class="text-lg font-semibold text-gray-700 mb-4">QUARTER 1</h3>
                             
                             <!-- Q1 Table -->
                             <div class="overflow-x-auto border rounded-md mb-6">
                                <table class="min-w-full divide-y divide-gray-200 text-xs">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider w-[30%]">Content</th>
                                            <th scope="col" class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider w-[35%]">Content Standards</th>
                                            <th scope="col" class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider w-[35%]">Learning Competencies</th>
                                        </tr>
                                    </thead>
                                    <tbody id="depedDetailsQ1Rows" class="bg-white divide-y divide-gray-200">
                                        <!-- Rows injected via JS -->
                                    </tbody>
                                </table>
                             </div>

                             <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div><label class="block text-sm font-semibold text-gray-600 mb-2">Performance Standards</label><div id="depedDetailsQ1PerfStandards" class="p-3 bg-gray-50 border rounded-md min-h-[80px] text-sm whitespace-pre-wrap"></div></div>
                                <div><label class="block text-sm font-semibold text-gray-600 mb-2">Suggested Performance Task</label><div id="depedDetailsQ1PerfTasks" class="p-3 bg-gray-50 border rounded-md min-h-[80px] text-sm whitespace-pre-wrap"></div></div>
                             </div>
                        </div>

                        <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                             <h3 class="text-lg font-semibold text-gray-700 mb-4">QUARTER 2</h3>
                             
                             <!-- Q2 Table -->
                             <div class="overflow-x-auto border rounded-md mb-6">
                                <table class="min-w-full divide-y divide-gray-200 text-xs">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider w-[30%]">Content</th>
                                            <th scope="col" class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider w-[35%]">Content Standards</th>
                                            <th scope="col" class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider w-[35%]">Learning Competencies</th>
                                        </tr>
                                    </thead>
                                    <tbody id="depedDetailsQ2Rows" class="bg-white divide-y divide-gray-200">
                                        <!-- Rows injected via JS -->
                                    </tbody>
                                </table>
                             </div>

                             <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div><label class="block text-sm font-semibold text-gray-600 mb-2">Performance Standards</label><div id="depedDetailsQ2PerfStandards" class="p-3 bg-gray-50 border rounded-md min-h-[80px] text-sm whitespace-pre-wrap"></div></div>
                                <div><label class="block text-sm font-semibold text-gray-600 mb-2">Suggested Performance Task</label><div id="depedDetailsQ2PerfTasks" class="p-3 bg-gray-50 border rounded-md min-h-[80px] text-sm whitespace-pre-wrap"></div></div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            
             <div class="flex justify-between items-center p-6 border-t border-gray-200 bg-white rounded-b-2xl shrink-0 z-10">
                <div class="text-sm text-gray-500">
                    <span class="font-semibold">Created:</span>
                    <span id="depedDetailsCreatedAt"></span>
                </div>

            </div>
        </div>
    </div>
</div>
    
{{-- Remove Subject Confirmation Modal --}}
    <div id="removeConfirmationModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 ease-out hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center transform scale-95 opacity-0 transition-all duration-500 ease-out" id="remove-modal-panel">
                <div class="w-12 h-12 rounded-full bg-red-100 p-2 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Remove Subject</h3>
                <p class="text-sm text-gray-500 mt-2">Are you sure you want to remove this subject from the semester?</p>
                <div class="mt-6 flex justify-center gap-4">
                    <button id="cancelRemoveButton" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">Cancel</button>
                    <button id="confirmRemoveButton" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-all">Yes, Remove</button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Import Confirmation Modal --}}
    <div id="importConfirmationModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 ease-out hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center transform scale-95 opacity-0 transition-all duration-500 ease-out" id="import-modal-panel">
                <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Export Subject</h3>
                <p class="text-sm text-gray-500 mt-2">Are you sure you want to download a PDF file of this subject's details and lessons?</p>
                <div class="mt-6 flex justify-center gap-4">
                    <button id="cancelImportButton" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</button>
                    <button id="confirmImportButton" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Yes, Export</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Save Mapping Confirmation Modal --}}
    <div id="saveMappingModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-blue-100 p-2 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Save Mapping</h3>
                <p class="text-sm text-gray-500 mt-2">Are you sure you want to save the mapping?</p>
                <div class="mt-6 flex justify-center gap-4">
                    <button id="cancelSaveMapping" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</button>
                    <button id="confirmSaveMapping" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Proceed to Prerequisites Confirmation Modal --}}
    <div id="proceedToPrerequisitesModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-blue-100 p-2 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Proceed to Prerequisites</h3>
                <p class="text-sm text-gray-500 mt-2">Do you want to go to Pre-requisite Configuration to set up the Pre-requisite?</p>
                <div class="mt-6 flex justify-center gap-4">
                    <button id="declineProceedToPrerequisites" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">No</button>
                    <button id="confirmProceedToPrerequisites" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Yes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Save Success Modal --}}
    <div id="saveSuccessModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Successfully Added!</h3>
                <p class="text-sm text-gray-500 mt-2">Your curriculum mapping has been saved successfully!</p>
                <div class="mt-6">
                    <button id="closeSaveSuccessModal" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">OK</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mapping Success Modal --}}
    <div id="mappingSuccessModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Success!</h3>
                <p class="text-sm text-gray-500 mt-2">You have successfully mapped the subject.</p>
                <div class="mt-6">
                    <button id="closeMappingSuccessModal" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">OK</button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Remove Success Modal --}}
    <div id="removeSuccessModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Success!</h3>
            <p class="text-sm text-gray-500 mt-2">Subject removed successfully and moved to history!</p>
            <div class="mt-6">
                <button id="closeRemoveSuccessModal" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">OK</button>
            </div>
        </div>
    </div>

    </main>

    {{-- edit --}}
    <div id="editConfirmationModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center transform scale-95 transition-all duration-500 ease-out">
                <div class="w-12 h-12 rounded-full bg-blue-100 p-2 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Enable Editing?</h3>
                <p class="text-sm text-gray-500 mt-2">Are you sure you want to edit this curriculum? This will allow you to drag, drop, and remove subjects.</p>
                <div class="mt-6 flex justify-center gap-4">
                    <button id="cancelEditBtn" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</button>
                    <button id="confirmEditBtn" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Yes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Reassign Subject Confirmation Modal --}}
    <div id="reassignConfirmationModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-yellow-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Reassign Subject</h3>
            <p class="text-sm text-gray-500 mt-2">Are you sure you want to move this subject to a different semester?</p>
            <div class="mt-6 flex justify-center gap-4">
                <button id="cancelReassignBtn" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</button>
                <button id="confirmReassignBtn" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700">Yes, Reassign</button>
            </div>
        </div>
    </div>

    {{-- Reassign Success Modal --}}
    <div id="reassignSuccessModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Success!</h3>
            <p class="text-sm text-gray-500 mt-2">Subject has been successfully reassigned.</p>
            <div class="mt-6">
                <button id="closeReassignSuccessBtn" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">OK</button>
            </div>
        </div>
    </div>

    {{-- Delete modals removed --}}

    {{-- Add Subjects Modal --}}
    <div id="addSubjectsModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-60 transition-opacity duration-300 ease-out hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white w-full max-w-3xl rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col max-h-[90vh]" id="add-subjects-modal-panel">
                
                {{-- Modal Header --}}
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800" id="addSubjectsModalTitle">Select Memorandum</h2>
                        <p class="text-sm text-gray-500 mt-1" id="addSubjectsModalSubtitle">Choose a memorandum to view associated subjects</p>
                    </div>
                    <button id="closeAddSubjectsModal" class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200" aria-label="Close modal">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                {{-- Search Bar --}}
                <div class="p-4 border-b border-gray-200">
                    <div class="relative">
                        <input type="text" id="modalSubjectSearch" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search subjects...">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                
                {{-- Subject List with Two Columns --}}
                {{-- Content Container --}}
                <div class="flex-1 overflow-y-auto p-6 relative">
                    {{-- Memorandums View --}}
                    <div id="memorandumListView" class="grid grid-cols-1 gap-4">
                        <!-- Loaded dynamically -->
                        <p class="text-center text-gray-500 py-8">Loading memorandums...</p>
                    </div>

                    {{-- Subjects View (Hidden initially) --}}
                    <div id="subjectListView" class="hidden">
                         <div class="mb-4">
                            <button id="backToMemorandumsBtn" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                Back to Memorandums
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            {{-- Minor Subjects Column --}}
                            <div>
                                <h3 class="text-lg font-semibold text-purple-700 mb-3 pb-2 border-b border-purple-200">Minor Subjects</h3>
                                <div id="modalMinorSubjectList" class="space-y-2">
                                    <p class="text-gray-500 text-center py-8 text-sm">Loading...</p>
                                </div>
                            </div>
                            
                            {{-- Major Subjects Column --}}
                            <div>
                                <h3 class="text-lg font-semibold text-blue-700 mb-3 pb-2 border-b border-blue-200">Major Subjects</h3>
                                <div id="modalMajorSubjectList" class="space-y-2">
                                    <p class="text-gray-500 text-center py-8 text-sm">Loading...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Modal Footer --}}
                <div class="flex justify-between items-center p-6 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-600">
                            <span id="selectedSubjectsCount" class="font-semibold text-blue-600">0</span> subject(s) selected
                        </p>
                        <p class="text-xs text-gray-500 mt-1" id="modalUnitLimitDisplay">
                            Units: 0 selected / 0 remaining
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button id="cancelAddSubjects" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">Cancel</button>
                        <button id="confirmAddSubjects" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">Add Selected Subjects</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Memorandum Details Modal --}}
    <div id="memorandumDetailsModal" class="fixed inset-0 z-[110] overflow-y-auto bg-black bg-opacity-60 transition-opacity duration-300 ease-out hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white w-full max-w-4xl rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col max-h-[90vh]" id="memorandum-details-panel">
                
                {{-- Modal Header --}}
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <div>
                        <h2 id="memorandumDetailsTitle" class="text-2xl font-bold text-gray-800">Memorandum Details</h2>
                        <p id="memorandumDetailsSubtitle" class="text-sm text-gray-500 mt-1">View memorandum information and associated subjects</p>
                    </div>
                    <button id="closeMemorandumDetailsModal" class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200" aria-label="Close modal">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                {{-- Memorandum Information Card --}}
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="flex-grow">
                            <h3 id="memoDetailName" class="text-xl font-bold text-gray-800 mb-2"></h3>
                            <div class="flex flex-wrap gap-3">
                                <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-lg shadow-sm">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-semibold text-gray-700">Year:</span>
                                    <span id="memoDetailYear" class="text-sm text-gray-600"></span>
                                </div>
                                <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-lg shadow-sm">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    <span class="text-sm font-semibold text-gray-700">Category:</span>
                                    <span id="memoDetailCategory" class="text-sm text-gray-600"></span>
                                </div>
                                <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-lg shadow-sm">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <span class="text-sm font-semibold text-gray-700">Subjects:</span>
                                    <span id="memoDetailCount" class="text-sm text-gray-600"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Subjects List --}}
                <div class="flex-1 overflow-y-auto p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Associated Subjects</h3>
                    <div id="memoDetailSubjectsList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Subjects will be populated here -->
                    </div>
                </div>
                
                {{-- Modal Footer --}}
                <div class="flex justify-end items-center p-6 border-t border-gray-200 bg-gray-50">
                    <button id="closeMemorandumDetailsModalBtn" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">Close</button>
                </div>
            </div>
        </div>
    </div>

</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- MODAL ELEMENTS ---
        const subjectDetailsModal = document.getElementById('subjectDetailsModal');
        const modalDetailsPanel = document.getElementById('modal-details-panel');
        const editConfirmationModal = document.getElementById('editConfirmationModal');

        // Detailed Content Elements
        const detailsCourseTitle = document.getElementById('detailsCourseTitle');
        const detailsContactHours = document.getElementById('detailsContactHours');
        const detailsPrerequisites = document.getElementById('detailsPrerequisites');
        const detailsPrereqTo = document.getElementById('detailsPrereqTo');
        const detailsCourseDescription = document.getElementById('detailsCourseDescription');
        const detailsProgramMapping = document.getElementById('detailsProgramMapping');
        const detailsCourseMapping = document.getElementById('detailsCourseMapping');
        const detailsPILO = document.getElementById('detailsPILO');
        const detailsCILO = document.getElementById('detailsCILO');
        const detailsLearningOutcomes = document.getElementById('detailsLearningOutcomes');
        const detailsLessonsContainer = document.getElementById('detailsLessonsContainer');
        const detailsBasicReadings = document.getElementById('detailsBasicReadings');
        const detailsExtendedReadings = document.getElementById('detailsExtendedReadings');
        const detailsCourseAssessment = document.getElementById('detailsCourseAssessment');
        const detailsCommitteeMembers = document.getElementById('detailsCommitteeMembers');
        const detailsConsultationSchedule = document.getElementById('detailsConsultationSchedule');
        const detailsPreparedBy = document.getElementById('detailsPreparedBy');
        const detailsReviewedBy = document.getElementById('detailsReviewedBy');
        const detailsApprovedBy = document.getElementById('detailsApprovedBy');
        const detailsCreatedAt = document.getElementById('detailsCreatedAt');

        // Add Subjects Modal Elements
        const addSubjectsModal = document.getElementById('addSubjectsModal');
        const addSubjectsModalPanel = document.getElementById('add-subjects-modal-panel');

        const closeAddSubjectsModalBtn = document.getElementById('closeAddSubjectsModal');
        const cancelAddSubjectsBtn = document.getElementById('cancelAddSubjects');
        const confirmAddSubjectsBtn = document.getElementById('confirmAddSubjects');
        const modalSubjectSearch = document.getElementById('modalSubjectSearch');
        const modalSubjectList = document.getElementById('modalSubjectList');
        const selectedSubjectsCount = document.getElementById('selectedSubjectsCount');
        let allSystemSubjects = [];
        let selectedSubjectsForAdding = new Set();

        // --- CORE ELEMENTS & STATE ---
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const availableSubjectsContainer = document.getElementById('availableSubjects');
        const curriculumSelector = document.getElementById('curriculumSelector');
        const curriculumOverview = document.getElementById('curriculumOverview');
        let draggedItem = null;
        let subjectTagToRemove = null;
        let isEditing = false;
        let subjectToImport = null;

        const removeSuccessModal = document.getElementById('removeSuccessModal');
        const closeRemoveSuccessModal = document.getElementById('closeRemoveSuccessModal');
        
        // --- STATE VARIABLES ---
        let isAddingSubjectsMode = false;
        let activeSemesterForAdding = null;
        let itemToReassign = null;
        let reassignTargetContainer = null;


        // --- SUBJECT DETAIL MODAL FUNCTIONS ---

        const hideDetailsModal = () => {
            subjectDetailsModal.classList.add('opacity-0');
            modalDetailsPanel.classList.add('opacity-0', 'scale-95');
            setTimeout(() => subjectDetailsModal.classList.add('hidden'), 300);
        };
        
        const createMappingGridHtml = (gridData, mainHeader) => {
            if (!gridData || !Array.isArray(gridData) || gridData.length === 0) {
                return '<p class="text-xs text-gray-500">No mapping grid data available.</p>';
            }

            const headers = [mainHeader, 'CTPSS', 'ECC', 'EPP', 'GLC'];
            
            let tableHtml = `<div class="overflow-x-auto border rounded-md">
                                <table class="min-w-full divide-y divide-gray-200 text-xs">
                                    <thead class="bg-gray-50">
                                        <tr>${headers.map(h => `<th scope="col" class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">${h}</th>`).join('')}</tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">`;
            
            gridData.forEach(row => {
                const mainCellData = row[mainHeader.toLowerCase()] || '';
                tableHtml += `<tr>
                                <td class="px-3 py-2 whitespace-normal">${mainCellData}</td>
                                <td class="px-3 py-2 text-center whitespace-nowrap">${row.ctpss || ''}</td>
                                <td class="px-3 py-2 text-center whitespace-nowrap">${row.ecc || ''}</td>
                                <td class="px-3 py-2 text-center whitespace-nowrap">${row.epp || ''}</td>
                                <td class="px-3 py-2 text-center whitespace-nowrap">${row.glc || ''}</td>
                              </tr>`;
            });

            tableHtml += `</tbody></table></div>`;
            return tableHtml;
        };

        // Helper to set text content with fallback
        const setText = (id, value) => {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = (value === null || value === undefined || value === '') ? 'N/A' : value;
            }
        };

        // Populate DepEd Modal
        const populateDepEdModal = (data) => {
            console.log('DepEd Modal Data:', data);
            setText('depedCourseTitle', data.subject_name);
            setText('depedSubjectCode', data.subject_code);
            setText('depedSubjectType', data.subject_type);
            setText('depedMemorandumCategory', data.memorandum_category);
            setText('depedTitle', data.memorandum);
            setText('depedMemorandum', data.memorandum);
            
            // Hide Obsolete Sections/Fields for DepEd as requested
            const hideEl = (id) => { const el = document.getElementById(id); if(el) el.classList.add('hidden'); };
            const showEl = (id) => { const el = document.getElementById(id); if(el) el.classList.remove('hidden'); };
            
            hideEl('depedTimeAllotmentContainer');
            hideEl('depedScheduleContainer');
            hideEl('depedCourseDescriptionContainer');
            hideEl('depedCurriculumGuideSection');

            // Handle Syllabus Preview - Always show section for DepEd
            const syllabusSection = document.getElementById('depedSyllabusSection');
            const pdfFrame = document.getElementById('depedPdfFrame');
            const imagePreview = document.getElementById('depedImagePreview');
            const noPreview = document.getElementById('depedNoPreview');
            const fileNameDisplay = document.getElementById('depedSyllabusFileName');
            
            if (syllabusSection) {
                 syllabusSection.classList.remove('hidden'); // Always show section
                 
                 // Reset views
                 if(pdfFrame) { pdfFrame.classList.add('hidden'); pdfFrame.src = ''; }
                 if(imagePreview) { imagePreview.classList.add('hidden'); imagePreview.src = ''; }
                 if(noPreview) noPreview.classList.add('hidden');

                 if (data.syllabus_path) {
                     let path = data.syllabus_path;
                     
                     // Clean up the path - remove /storage/ prefix if it exists
                     path = path.replace(/^\/storage\//, '').replace(/^storage\//, '');
                     
                     // Construct URLs
                     const baseUrl = window.location.origin;
                     const viewUrl = `${baseUrl}/view-syllabus/${path}`; // Use the new route
                     const downloadUrl = `${baseUrl}/storage/${path}`; // Direct download link
                     
                     const fileName = path.split('/').pop();
                     const ext = fileName.split('.').pop().toLowerCase();
                     
                     if (fileNameDisplay) {
                         fileNameDisplay.innerHTML = `
                             <span class="font-medium">${fileName}</span>
                             <a href="${downloadUrl}" target="_blank" download class="ml-2 text-blue-600 hover:text-blue-800 text-xs underline">
                                 Download
                             </a>
                         `;
                         fileNameDisplay.classList.remove('hidden');
                     }
                     
                     if (ext === 'pdf') {
                        if (pdfFrame) {
                            // Use the view-syllabus route which serves with proper headers
                            pdfFrame.src = viewUrl + '#toolbar=0&navpanes=0&scrollbar=0';
                            pdfFrame.classList.remove('hidden');
                            
                            // Add error handler for loading issues
                            pdfFrame.onerror = function() {
                                pdfFrame.classList.add('hidden');
                                if(noPreview) {
                                    noPreview.innerHTML = `
                                        <div class="text-center">
                                            <p class="text-gray-600 mb-3">Unable to preview PDF in browser.</p>
                                            <a href="${viewUrl}" target="_blank" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                                Open PDF in New Tab
                                            </a>
                                        </div>
                                    `;
                                    noPreview.classList.remove('hidden');
                                }
                            };
                        }
                     } else if (['jpg', 'jpeg', 'png'].includes(ext)) {
                         if (imagePreview) {
                             imagePreview.src = viewUrl; // Use view route for images too
                             imagePreview.classList.remove('hidden');
                         }
                     } else {
                         if(noPreview) {
                             noPreview.innerHTML = `
                                 <div class="text-center">
                                     <p class="text-gray-600 mb-3">Preview not available for this file type.</p>
                                     <a href="${downloadUrl}" target="_blank" download class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                         <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                         </svg>
                                         Download File
                                     </a>
                                 </div>
                             `;
                             noPreview.classList.remove('hidden');
                         }
                     }
                 } else {
                     // No file uploaded
                     if (fileNameDisplay) fileNameDisplay.classList.add('hidden');
                     if (noPreview) {
                         noPreview.textContent = 'No syllabus document uploaded.';
                         noPreview.classList.remove('hidden');
                     }
                 }
            }

            // Date formatting
            const createdAtDate = new Date(data.created_at);
            setText('depedDetailsCreatedAt', createdAtDate.toLocaleString('en-US', {
                year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
            }));

            // We don't populate the grids since they are hidden now, but we leave the logic in case we revert, 
            // or just comment it out to save resources. I'll leave basic populators but they are hidden.
            
            // setText('depedDetailsQ1PerfStandards', data.q_1_performance_standards);
            // ... (rest omitted/irrelevant if hidden)

            const exportBtn = document.getElementById('exportDepedPdfButton');
            if(exportBtn) exportBtn.dataset.subjectData = JSON.stringify(data);

            const modal = document.getElementById('depedSubjectDetailsModal');
            const panel = document.getElementById('deped-modal-details-panel');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'scale-95');
            }, 10);
        };

        // Populate CHED Modal
        const populateChedModal = (data) => {
            setText('chedSubjectName', `${data.subject_name} (${data.subject_code})`);
            setText('chedCourseTitle', data.subject_name);
            setText('chedSubjectCode', data.subject_code);
            setText('chedSubjectType', data.subject_type);
            setText('chedSubjectUnit', data.subject_unit);
            setText('chedContactHours', data.contact_hours);
            setText('chedMemorandumYear', data.memorandum_year);
            setText('chedPrerequisites', data.prerequisites);
            setText('chedPrereqTo', data.pre_requisite_to);
            setText('chedMemorandum', data.memorandum);
            setText('chedCourseDescription', data.course_description);
            
            // Learning Outcomes
            setText('chedPILO', data.pilo_outcomes);
            setText('chedCILO', data.cilo_outcomes);
            setText('chedLearningOutcomes', data.learning_outcomes);
            
            // Requirements & Policies
            setText('chedBasicReadings', data.basic_readings);
            setText('chedExtendedReadings', data.extended_readings);
            setText('chedCourseAssessment', data.course_assessment);
            
            // Committee & Approval
            setText('chedCommitteeMembers', data.committee_members);
            setText('chedConsultationSchedule', data.consultation_schedule);
            setText('chedPreparedBy', data.prepared_by);
            setText('chedReviewedBy', data.reviewed_by);
            setText('chedApprovedBy', data.approved_by);

            const createdAtDate = new Date(data.created_at);
            setText('chedDetailsCreatedAt', createdAtDate.toLocaleString('en-US', {
                year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
            }));

            // Mapping Grids
            const progGrid = document.getElementById('chedProgramMapping');
            const courseGrid = document.getElementById('chedCourseMapping');
            if(progGrid) progGrid.innerHTML = createMappingGridHtml(data.program_mapping_grid, 'PILO');
            if(courseGrid) courseGrid.innerHTML = createMappingGridHtml(data.course_mapping_grid, 'CILO');

            // Weekly Plan / Lessons
            const lessonsContainer = document.getElementById('chedLessonsContainer');
            if (lessonsContainer) {
                lessonsContainer.innerHTML = '';
                if (data.lessons && typeof data.lessons === 'object' && Object.keys(data.lessons).length > 0) {
                    Object.keys(data.lessons).sort((a, b) => {
                        const weekA = parseInt(a.replace(/\D/g, '')) || 0;
                        const weekB = parseInt(b.replace(/\D/g, '')) || 0;
                        return weekA - weekB;
                    }).forEach(week => {
                        const lessonString = data.lessons[week];
                        const lessonData = {};
                        // Simple parser for lesson string format "Key: Value,, Key: Value"
                        const parts = lessonString.split(',, ');
                        parts.forEach(part => {
                            if (part.startsWith('Detailed Lesson Content:')) lessonData.content = part.replace('Detailed Lesson Content:\n', '');
                            if (part.startsWith('Student Intended Learning Outcomes:')) lessonData.silo = part.replace('Student Intended Learning Outcomes:\n', '');
                            if (part.startsWith('Assessment:')) {
                                const match = part.match(/Assessment: ONSITE:\s*([\s\S]*?)OFFSITE:\s*([\s\S]*)/);
                                if (match) { 
                                    lessonData.at_onsite = match[1].trim(); 
                                    lessonData.at_offsite = match[2].trim(); 
                                } else {
                                     // Fallback if regex fails (e.g. simple string)
                                     lessonData.at_onsite = part.replace('Assessment:', '');
                                }
                            }
                            if (part.startsWith('Activities:')) {
                                 const match = part.match(/Activities: ON-SITE:\s*([\s\S]*?)OFF-SITE:\s*([\s\S]*)/);
                                 if (match) {
                                     lessonData.tla_onsite = match[1].trim();
                                     lessonData.tla_offsite = match[2].trim();
                                 } else {
                                     lessonData.tla_onsite = part.replace('Activities:', '');
                                 }
                            }
                            if (part.startsWith('Learning and Teaching Support Materials:')) lessonData.ltsm = part.replace('Learning and Teaching Support Materials:\n', '');
                            if (part.startsWith('Output Materials:')) lessonData.output = part.replace('Output Materials:\n', '');
                        });

                        const weekNum = parseInt(week.replace(/\D/g, '')) || 0;
                        const isExamWeek = [6, 12, 18].includes(weekNum);
                        let weekHTML = '';

                        if (isExamWeek) {
                            weekHTML = `
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <button type="button" class="w-full flex justify-between items-center p-4 bg-purple-50 hover:bg-purple-100 transition-colors week-toggle">
                                    <span class="font-bold text-purple-700">${week} - ${lessonData.content || 'Exam'}</span>
                                    <svg class="w-5 h-5 text-purple-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="p-5 border-t border-gray-200 bg-white hidden week-content">
                                    <div class="text-center py-4">
                                        <p class="text-xl font-bold text-gray-600">${lessonData.content || 'Exam'}</p>
                                    </div>
                                </div>
                            </div>`;
                        } else {
                            weekHTML = `
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <button type="button" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 transition-colors week-toggle">
                                    <span class="font-semibold text-gray-700">${week}</span>
                                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="p-5 border-t border-gray-200 bg-white hidden week-content space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div><label class="block text-sm font-semibold text-gray-600 mb-2">Content</label><div class="p-3 bg-gray-50 border rounded-md min-h-[60px] text-sm whitespace-pre-wrap">${lessonData.content || 'N/A'}</div></div>
                                        <div><label class="block text-sm font-semibold text-gray-600 mb-2">Student Intended Learning Outcomes</label><div class="p-3 bg-gray-50 border rounded-md min-h-[60px] text-sm whitespace-pre-wrap">${lessonData.silo || 'N/A'}</div></div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div><label class="block text-sm font-semibold text-gray-600 mb-2">Assessment Tasks (ATs)</label>
                                            <div class="space-y-2">
                                                <div class="p-2 bg-gray-50 border rounded-md text-sm"><span class="font-bold text-xs text-gray-500 block mb-1">ONSITE</span>${lessonData.at_onsite || 'N/A'}</div>
                                                <div class="p-2 bg-gray-50 border rounded-md text-sm"><span class="font-bold text-xs text-gray-500 block mb-1">OFFSITE</span>${lessonData.at_offsite || 'N/A'}</div>
                                            </div>
                                        </div>
                                        <div><label class="block text-sm font-semibold text-gray-600 mb-2">Teaching/Learning Activities (TLAs)</label>
                                            <div class="space-y-2">
                                                <div class="p-2 bg-gray-50 border rounded-md text-sm"><span class="font-bold text-xs text-gray-500 block mb-1">ONSITE</span>${lessonData.tla_onsite || 'N/A'}</div>
                                                <div class="p-2 bg-gray-50 border rounded-md text-sm"><span class="font-bold text-xs text-gray-500 block mb-1">OFFSITE</span>${lessonData.tla_offsite || 'N/A'}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div><label class="block text-sm font-semibold text-gray-600 mb-2">LTSM</label><div class="p-3 bg-gray-50 border rounded-md min-h-[60px] text-sm whitespace-pre-wrap">${lessonData.ltsm || 'N/A'}</div></div>
                                        <div><label class="block text-sm font-semibold text-gray-600 mb-2">Output Materials</label><div class="p-3 bg-gray-50 border rounded-md min-h-[60px] text-sm whitespace-pre-wrap">${lessonData.output || 'N/A'}</div></div>
                                    </div>
                                </div>
                            </div>`;
                        }
                        lessonsContainer.innerHTML += weekHTML;
                    });
                    
                    lessonsContainer.querySelectorAll('.week-toggle').forEach(button => {
                        button.addEventListener('click', () => {
                            const content = button.nextElementSibling;
                            content.classList.toggle('hidden');
                            button.querySelector('svg').classList.toggle('rotate-180');
                        });
                    });

                } else {
                    lessonsContainer.innerHTML = '<p class="text-sm text-gray-500 mt-2 italic text-center py-4">No lessons recorded for this subject.</p>';
                }
            }

            const exportBtn = document.getElementById('exportChedPdfButton');
            if(exportBtn) exportBtn.dataset.subjectData = JSON.stringify(data);

            const modal = document.getElementById('chedSubjectDetailsModal');
            const panel = document.getElementById('ched-modal-details-panel');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'scale-95');
            }, 10);
        };

        const showDetailsModal = (data, showEditButton = true) => {
            if (data.syllabus_type === 'DepEd') {
                populateDepEdModal(data);
            } else {
                populateChedModal(data);
            }
        };

        // --- CORE EVENT LISTENERS ---
        // --- CORE EVENT LISTENERS ---
        // Close buttons for new modals
        const hideChedModal = () => {
            const modal = document.getElementById('chedSubjectDetailsModal');
            const panel = document.getElementById('ched-modal-details-panel');
            panel.classList.add('opacity-0', 'scale-95');
            modal.classList.add('opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        };
        const hideDepEdModal = () => {
            const modal = document.getElementById('depedSubjectDetailsModal');
            const panel = document.getElementById('deped-modal-details-panel');
            panel.classList.add('opacity-0', 'scale-95');
            modal.classList.add('opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        };

        const closeChedBtn = document.getElementById('closeChedDetailsModal');
        if(closeChedBtn) closeChedBtn.addEventListener('click', hideChedModal);
        const chedModal = document.getElementById('chedSubjectDetailsModal');
        if(chedModal) chedModal.addEventListener('click', (e) => { if (e.target.id === 'chedSubjectDetailsModal') hideChedModal(); });

        const closeDepEdBtn = document.getElementById('closeDepedDetailsModal');
        if(closeDepEdBtn) closeDepEdBtn.addEventListener('click', hideDepEdModal);
        const depedModal = document.getElementById('depedSubjectDetailsModal');
        if(depedModal) depedModal.addEventListener('click', (e) => { if (e.target.id === 'depedSubjectDetailsModal') hideDepEdModal(); });

        
        const addDoubleClickEvents = (item) => {
            item.addEventListener('dblclick', () => {
                const subjectData = JSON.parse(item.dataset.subjectData);
                showDetailsModal(subjectData, false); // false = edit button is hidden (and actually removed now)
            });
        };

        const addDraggableEvents = (item) => {
            item.addEventListener('dragstart', (e) => {
                if (!isEditing || (item.classList.contains('subject-card') && item.classList.contains('assigned-card'))) {
                    e.preventDefault();
                    return;
                }
                
                // Check if the subject tag is in a complete semester
                if (item.classList.contains('subject-tag')) {
                    const semesterDropzone = item.closest('.semester-dropzone');
                    if (semesterDropzone && semesterDropzone.dataset.isComplete === 'true') {
                        e.preventDefault();
                        return;
                    }
                }
                
                draggedItem = item;
                e.dataTransfer.setData('text/plain', item.dataset.subjectData);
                setTimeout(() => item.classList.add('opacity-50', 'bg-gray-200'), 0);
            });
            item.addEventListener('dragend', () => {
                if (draggedItem) {
                    draggedItem.classList.remove('opacity-50', 'bg-gray-200');
                }
                draggedItem = null;
            });
        };

    const createSubjectCard = (subject, isMapped = false, status = '') => {
        const newSubjectCard = document.createElement('div');
        newSubjectCard.id = `subject-${subject.subject_code.toLowerCase()}`;
        newSubjectCard.dataset.subjectData = JSON.stringify(subject);
        newSubjectCard.dataset.status = status;

        let cardClasses = 'subject-card p-4 border border-gray-200 rounded-xl shadow-md transition-all duration-200 flex items-center gap-4 group relative overflow-hidden';
        let statusHTML = '';
        let isDraggable = true;
        
        let iconContainerClasses = 'icon-bg-default';
        let iconSvgClasses = 'text-gray-500';
        let borderClass = '';

        // Determine border color based on subject type
        const geIdentifiers = ["GE", "General Education", "Gen Ed", "General"];
        switch (true) {
            case subject.subject_type === 'Major':
                borderClass = 'border-l-4 border-l-blue-500';
                break;
            case subject.subject_type === 'Minor':
                borderClass = 'border-l-4 border-l-purple-500';
                break;
            case subject.subject_type === 'Elective':
                borderClass = 'border-l-4 border-l-red-500';
                break;
            case geIdentifiers.map(id => id.toLowerCase()).includes(subject.subject_type.toLowerCase()):
                borderClass = 'border-l-4 border-l-orange-500';
                break;
            default:
                borderClass = 'border-l-4 border-l-gray-400';
        }

        let subjectNameClass = 'text-gray-800';
        let textColorClass = 'text-gray-500';
        let unitsColorClass = 'text-gray-600';
        let dotColorClass = 'text-gray-400';
        let typeBadgeClass = 'text-gray-500 bg-gray-50 border-gray-100';

        if (isMapped) {
            let assignedClass = ''; 

            switch (true) {
                case subject.subject_type === 'Major':
                    assignedClass = 'border-blue-500';
                    iconContainerClasses = 'bg-blue-500';
                    iconSvgClasses = 'text-white';
                    subjectNameClass = 'text-blue-700';
                    textColorClass = 'text-blue-600 font-bold';
                    unitsColorClass = 'text-blue-600 font-bold';
                    dotColorClass = 'text-blue-400';
                    typeBadgeClass = 'text-white bg-blue-500 border-blue-500';
                    break;
                case subject.subject_type === 'Minor':
                    assignedClass = 'border-purple-500';
                    iconContainerClasses = 'bg-purple-500';
                    iconSvgClasses = 'text-white';
                    subjectNameClass = 'text-purple-700';
                    textColorClass = 'text-purple-600 font-bold';
                    unitsColorClass = 'text-purple-600 font-bold';
                    dotColorClass = 'text-purple-400';
                    typeBadgeClass = 'text-white bg-purple-500 border-purple-500';
                    break;
                case subject.subject_type === 'Elective':
                    assignedClass = 'border-red-500';
                    iconContainerClasses = 'bg-red-500';
                    iconSvgClasses = 'text-white';
                    subjectNameClass = 'text-red-700';
                    textColorClass = 'text-red-600 font-bold';
                    unitsColorClass = 'text-red-600 font-bold';
                    dotColorClass = 'text-red-400';
                    typeBadgeClass = 'text-white bg-red-500 border-red-500';
                    break;
                case geIdentifiers.map(id => id.toLowerCase()).includes(subject.subject_type.toLowerCase()):
                    assignedClass = 'border-orange-500';
                    iconContainerClasses = 'bg-orange-500';
                    iconSvgClasses = 'text-white';
                    subjectNameClass = 'text-orange-700';
                    textColorClass = 'text-orange-600 font-bold';
                    unitsColorClass = 'text-orange-600 font-bold';
                    dotColorClass = 'text-orange-400';
                    typeBadgeClass = 'text-white bg-orange-500 border-orange-500';
                    break;
                default:
                    assignedClass = 'border-gray-400';
                    iconContainerClasses = 'bg-gray-500';
                    iconSvgClasses = 'text-white';
            }
            // Use border-2 for assigned cards to make it more visible, and ensure bg-white
            cardClasses += ` bg-white border-2 ${assignedClass} cursor-not-allowed`;
            // Solid green badge for Assigned
            statusHTML = `<span class="status-badge text-[10px] uppercase tracking-wider font-bold px-3 py-1 rounded-full bg-green-500 text-white shadow-sm">Assigned</span>`;
            isDraggable = false;
        } else {
            cardClasses += ` bg-white ${borderClass} hover:shadow-lg hover:border-blue-400 hover:-translate-y-0.5 cursor-grab active:cursor-grabbing`;
            statusHTML = '<span class="status-badge text-[10px] uppercase tracking-wider font-bold text-gray-600 bg-gray-100 px-3 py-1 rounded-full">Available</span>';
        }
        
        newSubjectCard.className = cardClasses;
        newSubjectCard.setAttribute('draggable', isDraggable);
        
        newSubjectCard.innerHTML = `
            <div class="flex-shrink-0 w-12 h-12 ${iconContainerClasses} rounded-xl flex items-center justify-center transition-colors duration-300 shadow-sm group-hover:scale-105 transform transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ${iconSvgClasses} transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div class="flex-grow min-w-0">
                <div class="flex items-center justify-between mb-0.5">
                    <p class="subject-name font-bold ${subjectNameClass} text-base truncate pr-2">${subject.subject_name}</p>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="subject-code font-mono ${textColorClass} bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100">${subject.subject_code}</span>
                    ${subject.subject_unit && subject.subject_unit > 0 ? `<span class="separator-dot ${dotColorClass}">•</span><span class="subject-units font-medium ${unitsColorClass}">${subject.subject_unit} Units</span>` : ''}
                    ${subject.memorandum_year ? `<span class="separator-dot ${dotColorClass}">•</span><span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-200">${subject.memorandum_year}</span>` : ''}
                </div>
                ${subject.memorandum ? `<div class="text-xs text-gray-500 italic truncate mt-1" title="${subject.memorandum}">${subject.memorandum}</div>` : ''}
            </div>
            <div class="flex flex-col items-end gap-2 pl-2">
                <span class="subject-type-badge text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded border ${typeBadgeClass}">${subject.subject_type}</span>
                ${statusHTML}
            </div>
            <div class="add-subject-checkbox hidden ml-2">
                <input type="checkbox">
            </div>`;
        
        addDraggableEvents(newSubjectCard);
        addDoubleClickEvents(newSubjectCard);
        
        return newSubjectCard;
    };
        
        const createSubjectTag = (subjectData, isEditing = false) => {
            const subjectTag = document.createElement('div');
            subjectTag.setAttribute('draggable', isEditing);
            subjectTag.dataset.subjectData = JSON.stringify(subjectData);

            let baseClasses = 'subject-tag bg-white shadow-md rounded-lg p-3 flex items-center justify-between w-full transition-all hover:shadow-lg group relative overflow-hidden';
            let borderAccentClass = '';
            let iconContainerClass = '';
            let iconClass = '';
            let textClass = 'text-gray-800 font-bold';
            let codeClass = 'text-gray-500';
            let unitClass = 'bg-gray-500 text-white';
            let typeBadgeClass = 'text-gray-500 bg-gray-50 border-gray-100';
            let deleteBtnClasses = 'text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50';

            const subjectType = subjectData.subject_type;
            const geIdentifiers = ["GE", "General Education", "Gen Ed", "General"];

            if (subjectType === 'Major') {
                borderAccentClass = 'border-2 border-blue-500';
                iconContainerClass = 'bg-blue-500';
                iconClass = 'text-white';
                textClass = 'text-blue-700 font-bold';
                codeClass = 'text-blue-600';
                unitClass = 'bg-blue-500 text-white';
                typeBadgeClass = 'text-blue-600 bg-blue-50 border-blue-100';
            } else if (subjectType === 'Minor') {
                borderAccentClass = 'border-2 border-purple-500';
                iconContainerClass = 'bg-purple-500';
                iconClass = 'text-white';
                textClass = 'text-purple-700 font-bold';
                codeClass = 'text-purple-600';
                unitClass = 'bg-purple-500 text-white';
                typeBadgeClass = 'text-purple-600 bg-purple-50 border-purple-100';
            } else if (subjectType === 'Elective') {
                borderAccentClass = 'border-2 border-red-500';
                iconContainerClass = 'bg-red-500';
                iconClass = 'text-white';
                textClass = 'text-red-700 font-bold';
                codeClass = 'text-red-600';
                unitClass = 'bg-red-500 text-white';
                typeBadgeClass = 'text-red-600 bg-red-50 border-red-100';
            } else if (geIdentifiers.map(id => id.toLowerCase()).includes(subjectType.toLowerCase())) {
                borderAccentClass = 'border-2 border-orange-500';
                iconContainerClass = 'bg-orange-500';
                iconClass = 'text-white';
                textClass = 'text-orange-700 font-bold';
                codeClass = 'text-orange-600';
                unitClass = 'bg-orange-500 text-white';
                typeBadgeClass = 'text-orange-600 bg-orange-50 border-orange-100';
            } else {
                borderAccentClass = 'border-2 border-gray-400';
                iconContainerClass = 'bg-gray-500';
                iconClass = 'text-white';
            }

            subjectTag.className = `${baseClasses} ${borderAccentClass}`;

            subjectTag.innerHTML = `
                <div class="flex items-center gap-3 flex-grow min-w-0">
                    <div class="flex-shrink-0 w-10 h-10 ${iconContainerClass} rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ${iconClass}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="flex-grow min-w-0">
                        <p class="text-sm leading-tight truncate ${textClass}">${subjectData.subject_name}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <p class="text-xs font-mono ${codeClass}">${subjectData.subject_code}</p>
                            <span class="text-[10px] uppercase tracking-wider font-bold px-1.5 py-0.5 rounded border ${typeBadgeClass}">${subjectType}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 ml-2 flex-shrink-0">
                    ${subjectData.subject_unit && subjectData.subject_unit > 0 ? `<span class="text-xs font-semibold px-2 py-1 rounded-md ${unitClass}">${subjectData.subject_unit} units</span>` : ''}
                    <button class="delete-subject-tag ${isEditing ? '' : 'hidden'} ${deleteBtnClasses}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `;
            
            subjectTag.querySelector('.delete-subject-tag').onclick = (e) => {
                e.stopPropagation();
                const subjectTag = e.currentTarget.closest('.subject-tag');
                subjectTagToRemove = subjectTag;
                showRemoveConfirmationModal();
            };

            addDraggableEvents(subjectTag);
            addDoubleClickEvents(subjectTag);
            return subjectTag;
        };

 const updateUnitTotals = () => {
    let grandTotal = 0;
    const curriculumId = curriculumSelector.value;
    const grandTotalContainer = document.getElementById('grand-total-container');

    if (!curriculumId) {
        grandTotalContainer.classList.add('hidden');
        return;
    }

    document.querySelectorAll('.semester-dropzone').forEach(dropzone => {
        let semesterTotal = 0;
        dropzone.querySelectorAll('.subject-tag').forEach(tag => {
            // Count all subjects (both confirmed and pending) in unit totals
            const subjectData = JSON.parse(tag.dataset.subjectData);
            semesterTotal += parseInt(subjectData.subject_unit, 10) || 0;
        });
        
        const unitLimit = parseFloat(dropzone.dataset.unitLimit) || 0;
        const formatUnits = (units) => {
            const num = parseFloat(units);
            return num % 1 === 0 ? Math.floor(num) : num;
        };
        
        // Update unit total display
        const unitTotalElement = dropzone.querySelector('.semester-unit-total');
        if (unitLimit > 0) {
            const isOverLimit = semesterTotal > unitLimit;
            unitTotalElement.textContent = `Units: ${formatUnits(semesterTotal)}/${formatUnits(unitLimit)}`;
            unitTotalElement.className = `semester-unit-total text-sm font-bold ${isOverLimit ? 'text-red-600' : 'text-gray-700'}`;
            
            // Update progress bar
            const progressBar = dropzone.querySelector('.unit-progress');
            if (progressBar) {
                const percentage = Math.min((semesterTotal / unitLimit) * 100, 100);
                progressBar.style.width = `${percentage}%`;
                
                // Change color based on usage
                const isComplete = semesterTotal >= unitLimit;
                if (semesterTotal > unitLimit) {
                    progressBar.className = 'unit-progress bg-red-500 h-full transition-all duration-300';
                } else if (isComplete) {
                    progressBar.className = 'unit-progress bg-green-500 h-full transition-all duration-300';
                } else {
                    progressBar.className = 'unit-progress bg-blue-500 h-full transition-all duration-300';
                }
            }
            
            // Update dropzone border color and add complete status
            const isComplete = semesterTotal >= unitLimit;
            dropzone.dataset.isComplete = isComplete;
            
            if (isOverLimit) {
                dropzone.classList.add('border-red-400');
                dropzone.classList.remove('border-gray-300', 'border-green-400', 'semester-complete');
            } else if (isComplete) {
                dropzone.classList.add('border-green-400', 'semester-complete');
                dropzone.classList.remove('border-gray-300', 'border-red-400');
                dropzone.style.position = 'relative'; // Needed for the ::before pseudo-element
            } else {
                dropzone.classList.add('border-gray-300');
                dropzone.classList.remove('border-red-400', 'border-green-400', 'semester-complete');
                dropzone.style.position = '';
            }
            
            // Hide/show add subject button based on completion
            const addSubjectBtn = dropzone.querySelector('.add-subject-btn-placeholder');
            if (addSubjectBtn) {
                if (isComplete) {
                    addSubjectBtn.classList.add('hidden');
                } else if (isEditing) {
                    addSubjectBtn.classList.remove('hidden');
                }
            }
        } else {
            unitTotalElement.textContent = `Units: ${formatUnits(semesterTotal)}`;
        }
        
        grandTotal += semesterTotal;
    });
    
    const grandTotalSpan = document.getElementById('grand-total-units');
    grandTotalSpan.textContent = grandTotal;
    grandTotalContainer.classList.remove('hidden');
    updateAllTotals(); 
}; 

const updateAllTotals = () => {
    document.querySelectorAll('.semester-dropzone').forEach(dropzone => {
        const typeCounts = {
            Major: 0,
            Minor: 0,
            Elective: 0,
            General: 0,
        };
        const geIdentifiers = ["GE", "General Education", "Gen Ed", "General"];
        const subjectTags = dropzone.querySelectorAll('.subject-tag');
        const totalSubjectCount = subjectTags.length;

        subjectTags.forEach(tag => {
            const subjectData = JSON.parse(tag.dataset.subjectData);
            const subjectType = subjectData.subject_type;

            if (geIdentifiers.map(id => id.toLowerCase()).includes(subjectType.toLowerCase())) {
                typeCounts.General++;
            } else if (typeCounts.hasOwnProperty(subjectType)) {
                typeCounts[subjectType]++;
            }
        });

        const totalsContainer = dropzone.querySelector('.semester-type-totals');
        if (!totalsContainer) return;

        // Clear all previous badges
        totalsContainer.innerHTML = '';

        const typeStyles = {
            Major: 'bg-blue-100 text-blue-800',
            Minor: 'bg-purple-100 text-purple-800',
            Elective: 'bg-red-100 text-red-800',
            General: 'bg-orange-100 text-orange-800',
        };

        // Add the type-specific badges first
        ['Major', 'Minor', 'Elective', 'General'].forEach(type => {
            if (typeCounts[type] > 0) {
                const badge = document.createElement('span');
                badge.className = `px-2 py-1 rounded-full font-semibold ${typeStyles[type]}`;
                badge.textContent = `${type}: ${typeCounts[type]}`;
                totalsContainer.appendChild(badge);
            }
        });

        // Add the "Total Subjects" badge at the end
        if (totalSubjectCount > 0) {
            const totalBadge = document.createElement('span');
            totalBadge.className = 'px-2 py-1 rounded-full font-semibold bg-gray-200 text-gray-800';
            totalBadge.textContent = `Total Subjects: ${totalSubjectCount}`;
            totalsContainer.appendChild(totalBadge);
        }
    });
};

        const toggleEditMode = (enableEdit) => {
            isEditing = enableEdit;
            const dropzones = document.querySelectorAll('.semester-dropzone');
            const deleteButtons = document.querySelectorAll('.delete-subject-tag');
            const saveButton = document.getElementById('saveCurriculumButton');
            const editButton = document.getElementById('editCurriculumButton');
            const subjectTags = document.querySelectorAll('.subject-tag');
            const addSubjectButtons = document.querySelectorAll('.add-subject-btn-placeholder');
            const openMemorandumModalBtn = document.getElementById('openMemorandumModal');


            if (isEditing) {
                dropzones.forEach(dropzone => {
                    dropzone.classList.remove('locked');
                    addDragAndDropListeners(dropzone);
                });
                deleteButtons.forEach(button => button.classList.remove('hidden'));
                addSubjectButtons.forEach(button => button.classList.remove('hidden'));
                if (openMemorandumModalBtn) openMemorandumModalBtn.classList.remove('hidden');
                saveButton.removeAttribute('disabled');
                editButton.innerHTML = `<svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Cancel`;
                
                subjectTags.forEach(tag => tag.setAttribute('draggable', 'true'));

            } else {
                dropzones.forEach(dropzone => {
                    dropzone.classList.add('locked');
                    removeDragAndDropListeners(dropzone);
                });
                deleteButtons.forEach(button => button.classList.add('hidden'));
                addSubjectButtons.forEach(button => button.classList.add('hidden'));
                if (openMemorandumModalBtn) openMemorandumModalBtn.classList.add('hidden');

                saveButton.setAttribute('disabled', 'disabled');
                editButton.innerHTML = `<svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"></path></svg> Revise`;

                subjectTags.forEach(tag => tag.setAttribute('draggable', 'false'));
                
                // Ensure adding subjects mode is turned off
                if (isAddingSubjectsMode) {
                    toggleAddSubjectsMode(null);
                }
            }
        };

        const dragOverHandler = (e) => {
            e.preventDefault();
            const dropzone = e.currentTarget;
            
            // Check if semester is complete
            const isComplete = dropzone.dataset.isComplete === 'true';
            if (isComplete) {
                dropzone.classList.add('border-red-400', 'bg-red-50');
                return;
            }
            
            dropzone.classList.add('border-blue-500', 'bg-blue-50');
        };

        const dragLeaveHandler = (e) => {
            const dropzone = e.currentTarget;
            dropzone.classList.remove('border-blue-500', 'bg-blue-50', 'border-red-400', 'bg-red-50');
        };

    const dropHandler = (e) => {
        e.preventDefault();
        const dropzone = e.currentTarget;
        dropzone.classList.remove('border-blue-500', 'bg-blue-50', 'border-red-400', 'bg-red-50');
        if (!draggedItem) return;
        
        // Check if semester is complete
        const isComplete = dropzone.dataset.isComplete === 'true';
        if (isComplete) {
            const year = dropzone.dataset.year;
            const semester = dropzone.dataset.semester;
            const semesterName = semester === '1' ? 'First' : 'Second';
            
            Swal.fire({
                title: 'Semester Complete!',
                html: `
                    <div class="text-center">
                        <div class="mb-3">
                            <svg class="w-16 h-16 mx-auto text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-gray-700">Year ${year}, ${semesterName} Semester has reached its unit limit.</p>
                        <p class="text-sm text-gray-500 mt-2">You cannot add more subjects to this semester.</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'OK',
                confirmButtonColor: '#10B981'
            });
            return;
        }
        
        const droppedSubjectData = JSON.parse(e.dataTransfer.getData('text/plain'));
        const targetContainer = dropzone.querySelector('.flex-wrap');
        
        // Check unit limit validation
        const unitLimit = parseFloat(dropzone.dataset.unitLimit) || 0;
        if (unitLimit > 0) {
            let currentTotal = 0;
            targetContainer.querySelectorAll('.subject-tag').forEach(tag => {
                // Only count non-pending subjects in unit limit validation
                if (tag.dataset.isPending !== 'true') {
                    const subjectData = JSON.parse(tag.dataset.subjectData);
                    currentTotal += parseInt(subjectData.subject_unit, 10) || 0;
                }
            });
            
            const newSubjectUnits = parseInt(droppedSubjectData.subject_unit, 10) || 0;
            const wouldExceedLimit = (currentTotal + newSubjectUnits) > unitLimit;
            
            if (wouldExceedLimit) {
                const year = dropzone.dataset.year;
                const semester = dropzone.dataset.semester;
                const formatUnits = (units) => {
                    const num = parseFloat(units);
                    return num % 1 === 0 ? Math.floor(num) : num;
                };
                
                Swal.fire({
                    title: 'Unit Limit Exceeded!',
                    html: `
                        <div class="text-left">
                            <p class="mb-2">Cannot add <strong>"${droppedSubjectData.subject_name}"</strong> (${formatUnits(newSubjectUnits)} units) to Year ${year}, Semester ${semester}.</p>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                <p class="text-sm text-red-700">
                                    <strong>Current:</strong> ${formatUnits(currentTotal)} units<br>
                                    <strong>Adding:</strong> ${formatUnits(newSubjectUnits)} units<br>
                                    <strong>Total would be:</strong> ${formatUnits(currentTotal + newSubjectUnits)} units<br>
                                    <strong>Semester limit:</strong> ${formatUnits(unitLimit)} units
                                </p>
                            </div>
                        </div>
                    `,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#EF4444',
                    customClass: {
                        popup: 'text-sm'
                    }
                });
                return;
            }
        }
        
        const isDuplicateInSameSemester = Array.from(targetContainer.querySelectorAll('.subject-tag')).some(tag => JSON.parse(tag.dataset.subjectData).subject_code === droppedSubjectData.subject_code);
        
        if (!isDuplicateInSameSemester) {
            if (draggedItem.classList.contains('subject-card')) {
                const subjectTag = createSubjectTag(droppedSubjectData, isEditing);
                subjectTag.dataset.isNew = 'true'; // Mark as new
                targetContainer.appendChild(subjectTag);
                draggedItem.setAttribute('draggable', 'false');
                
                draggedItem.classList.remove('bg-white', 'hover:shadow-lg', 'hover:border-blue-400', 'cursor-grab', 'active:cursor-grabbing');
                
                const geIdentifiers = ["GE", "General Education", "Gen Ed", "General"];
                let assignedClass = 'border-gray-400';
                let iconBgClass = 'bg-gray-500';
                let iconSvgClass = 'text-white';
                let subjectNameClass = 'text-gray-800';
                let textColorClass = 'text-gray-500';
                let unitsColorClass = 'text-gray-600';
                let dotColorClass = 'text-gray-400';
                let typeBadgeClass = 'text-gray-500 bg-gray-50 border-gray-100';

                switch (true) {
                    case droppedSubjectData.subject_type === 'Major':
                        assignedClass = 'border-blue-500';
                        iconBgClass = 'bg-blue-500';
                        iconSvgClass = 'text-white';
                        subjectNameClass = 'text-blue-700';
                        textColorClass = 'text-blue-600 font-bold';
                        unitsColorClass = 'text-blue-600 font-bold';
                        dotColorClass = 'text-blue-400';
                        typeBadgeClass = 'text-white bg-blue-500 border-blue-500';
                        break;
                    case droppedSubjectData.subject_type === 'Minor':
                        assignedClass = 'border-purple-500';
                        iconBgClass = 'bg-purple-500';
                        iconSvgClass = 'text-white';
                        subjectNameClass = 'text-purple-700';
                        textColorClass = 'text-purple-600 font-bold';
                        unitsColorClass = 'text-purple-600 font-bold';
                        dotColorClass = 'text-purple-400';
                        typeBadgeClass = 'text-white bg-purple-500 border-purple-500';
                        break;
                    case droppedSubjectData.subject_type === 'Elective':
                        assignedClass = 'border-red-500';
                        iconBgClass = 'bg-red-50';
                        iconSvgClass = 'text-white';
                        subjectNameClass = 'text-red-700';
                        textColorClass = 'text-red-600 font-bold';
                        unitsColorClass = 'text-red-600 font-bold';
                        dotColorClass = 'text-red-400';
                        typeBadgeClass = 'text-white bg-red-500 border-red-500';
                        break;
                    case geIdentifiers.map(id => id.toLowerCase()).includes(droppedSubjectData.subject_type.toLowerCase()):
                        assignedClass = 'border-orange-500';
                        iconBgClass = 'bg-orange-500';
                        iconSvgClass = 'text-white';
                        subjectNameClass = 'text-orange-700';
                        textColorClass = 'text-orange-600 font-bold';
                        unitsColorClass = 'text-orange-600 font-bold';
                        dotColorClass = 'text-orange-400';
                        typeBadgeClass = 'text-white bg-orange-500 border-orange-500';
                        break;
                }
                
                draggedItem.classList.add(assignedClass, 'cursor-not-allowed', 'bg-white', 'border-2');

                const iconContainer = draggedItem.querySelector('.flex-shrink-0');
                const iconSvg = iconContainer.querySelector('svg');
                const subjectName = draggedItem.querySelector('.subject-name');
                const subjectCode = draggedItem.querySelector('.subject-code');
                const separatorDot = draggedItem.querySelector('.separator-dot');
                const subjectUnits = draggedItem.querySelector('.subject-units');
                const typeBadge = draggedItem.querySelector('.subject-type-badge');
                
                // Reset icon classes first
                iconContainer.className = `flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center transition-colors duration-300 shadow-sm group-hover:scale-105 transform transition-transform ${iconBgClass}`;
                iconSvg.className = `h-6 w-6 transition-colors duration-300 ${iconSvgClass}`;
                
                // Update text colors
                if (subjectName) {
                    subjectName.classList.remove('text-gray-800');
                    subjectName.classList.add(subjectNameClass);
                }
                if (subjectCode) {
                    subjectCode.classList.remove('text-gray-500');
                    subjectCode.className = `subject-code font-mono bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100 ${textColorClass}`;
                }
                if (separatorDot) {
                    separatorDot.classList.remove('text-gray-400');
                    separatorDot.classList.add(dotColorClass);
                }
                if (subjectUnits) {
                    subjectUnits.classList.remove('text-gray-600');
                    subjectUnits.className = `subject-units font-medium ${unitsColorClass}`;
                }
                if (typeBadge) {
                    typeBadge.className = `subject-type-badge text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded border ${typeBadgeClass}`;
                }

                const statusBadge = draggedItem.querySelector('.status-badge');
                if (statusBadge) {
                    statusBadge.textContent = 'Assigned';
                    statusBadge.className = 'status-badge text-[10px] uppercase tracking-wider font-bold px-3 py-1 rounded-full bg-green-500 text-white shadow-sm';
                }
                updateUnitTotals();
                
                // Show SweetAlert for successful subject mapping
                const year = dropzone.dataset.year;
                const semester = dropzone.dataset.semester;
                Swal.fire({
                    title: 'Subject Added Successfully!',
                    text: `"${droppedSubjectData.subject_name}" (${droppedSubjectData.subject_code}) has been added to Year ${year}, Semester ${semester}.`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#10B981',
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    showClass: {
                        popup: 'animate__animated animate__fadeInRight'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutRight'
                    }
                });
            } else if (draggedItem.classList.contains('subject-tag')) {
                itemToReassign = draggedItem;
                reassignTargetContainer = targetContainer; 
                
                document.getElementById('reassignConfirmationModal').classList.remove('hidden');
            }
        } else {
            // Show SweetAlert for duplicate subject
            const year = dropzone.dataset.year;
            const semester = dropzone.dataset.semester;
            Swal.fire({
                title: 'Duplicate Subject!',
                text: `"${droppedSubjectData.subject_name}" (${droppedSubjectData.subject_code}) is already assigned to Year ${year}, Semester ${semester}.`,
                icon: 'warning',
                confirmButtonText: 'OK',
                confirmButtonColor: '#F59E0B',
                showClass: {
                    popup: 'animate__animated animate__headShake'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        }
    };
        
        const addDragAndDropListeners = (dropzone) => {
            dropzone.addEventListener('dragover', dragOverHandler);
            dropzone.addEventListener('dragleave', dragLeaveHandler);
            dropzone.addEventListener('drop', dropHandler);
        };
        
        const removeDragAndDropListeners = (dropzone) => {
            dropzone.removeEventListener('dragover', dragOverHandler);
            dropzone.removeEventListener('dragleave', dragLeaveHandler);
            dropzone.removeEventListener('drop', dropHandler);
        };
        
        // --- THIS IS THE FIXED FUNCTION ---
        const toggleAddSubjectsMode = (semesterDropzone) => {
            // If we are turning the mode on
            if (semesterDropzone && !isAddingSubjectsMode) {
                // Check if semester is complete
                const isComplete = semesterDropzone.dataset.isComplete === 'true';
                if (isComplete) {
                    const year = semesterDropzone.dataset.year;
                    const semester = semesterDropzone.dataset.semester;
                    const semesterLabel = semesterDropzone.querySelector('h4').textContent;
                    
                    Swal.fire({
                        title: 'Unit Limit Reached!',
                        html: `
                            <div class="text-center">
                                <div class="mb-3">
                                    <svg class="w-16 h-16 mx-auto text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-700">Year ${year}, ${semesterLabel} has reached its unit limit.</p>
                                <p class="text-sm text-gray-500 mt-2">You cannot add more subjects to this term.</p>
                            </div>
                        `,
                        icon: 'info',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#10B981'
                    });
                    return;
                }
                
                isAddingSubjectsMode = true;
                activeSemesterForAdding = semesterDropzone;
                
                // Show checkboxes ONLY for available subjects
                availableSubjectsContainer.querySelectorAll('.subject-card').forEach(card => {
                    if (card.getAttribute('draggable') === 'true') {
                        const checkboxDiv = card.querySelector('.add-subject-checkbox');
                        if (checkboxDiv) {
                            checkboxDiv.classList.remove('hidden');
                        }
                    }
                });

                // Hide ALL "+ Add Subject" buttons in all semester boxes
                document.querySelectorAll('.add-subject-btn-placeholder').forEach(btn => {
                    btn.classList.add('hidden');
                });

            // If we are turning the mode off
            } else {
                isAddingSubjectsMode = false;
                
                // Hide ALL checkboxes and uncheck them
                document.querySelectorAll('.add-subject-checkbox').forEach(cb => {
                    cb.classList.add('hidden');
                    cb.querySelector('input').checked = false;
                });

                // Check if there are ANY pending subjects in Available Subjects (globally)
                const anyPendingInAvailableSubjects = document.querySelectorAll('.subject-card .status-badge').length > 0 && 
                    Array.from(document.querySelectorAll('.subject-card .status-badge')).some(badge => 
                        badge.textContent.trim().toLowerCase() === 'pending'
                    );

                // Show "+ Select Subject" buttons only in semesters with NO pending subjects
                // AND only if there are NO pending subjects anywhere in Available Subjects
                document.querySelectorAll('.semester-dropzone').forEach(semester => {
                    const hasPendingInSemester = semester.querySelectorAll('.subject-tag[data-is-pending="true"]').length > 0;
                    const addSubjectBtn = semester.querySelector('.add-subject-btn-placeholder');
                    
                    if (addSubjectBtn && isEditing && !hasPendingInSemester && !anyPendingInAvailableSubjects) {
                        addSubjectBtn.classList.remove('hidden');
                    } else if (addSubjectBtn) {
                        addSubjectBtn.classList.add('hidden');
                    }
                });
                
                activeSemesterForAdding = null;
            }
        };


        const initDragAndDrop = () => {
            document.querySelectorAll('.semester-dropzone').forEach(dropzone => {
                addDragAndDropListeners(dropzone);
            });

            document.body.addEventListener('dragover', e => e.preventDefault());
            document.body.addEventListener('drop', e => {
                e.preventDefault();
                if (isEditing && draggedItem && draggedItem.classList.contains('subject-tag') && !e.target.closest('.semester-dropzone')) {
                    const subjectData = JSON.parse(draggedItem.dataset.subjectData);
                    const originalSubjectCard = document.getElementById(`subject-${subjectData.subject_code.toLowerCase()}`);
                    if (originalSubjectCard) {
                        originalSubjectCard.setAttribute('draggable', 'true');
                        originalSubjectCard.classList.remove('assigned-card', 'cursor-not-allowed');
                        originalSubjectCard.classList.add('hover:shadow-md', 'hover:border-blue-400', 'cursor-grab', 'active:cursor-grabbing');
            
                        const statusBadge = originalSubjectCard.querySelector('.status-badge');
                        if (statusBadge) {
                            statusBadge.textContent = 'Available';
                            statusBadge.className = 'status-badge text-[10px] uppercase tracking-wider font-bold text-gray-600 bg-gray-100 px-3 py-1 rounded-full';
                        }
                    }
                    draggedItem.remove();
                    updateUnitTotals();
                }
            });
        };
        
        const showRemoveConfirmationModal = () => {
            const removeConfirmationModal = document.getElementById('removeConfirmationModal');
            const removeModalPanel = document.getElementById('remove-modal-panel');
            removeConfirmationModal.classList.remove('hidden');
            setTimeout(() => {
                removeConfirmationModal.classList.remove('opacity-0');
                removeModalPanel.classList.remove('opacity-0', 'scale-95');
            }, 10);
        };

        const hideRemoveConfirmationModal = () => {
            const removeConfirmationModal = document.getElementById('removeConfirmationModal');
            const removeModalPanel = document.getElementById('remove-modal-panel');
            removeConfirmationModal.classList.add('opacity-0');
            removeModalPanel.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                removeConfirmationModal.classList.add('hidden');
                subjectTagToRemove = null;
            }, 300);
        };


        document.getElementById('cancelRemoveButton').addEventListener('click', hideRemoveConfirmationModal);
        
        // --- REMOVE SUBJECT CONFIRMATION ---
        document.getElementById('confirmRemoveButton').addEventListener('click', async () => {
            if (!subjectTagToRemove) return;

            const subjectData = JSON.parse(subjectTagToRemove.dataset.subjectData);
            const dropzone = subjectTagToRemove.closest('.semester-dropzone');
            const year = dropzone.dataset.year;
            const semester = dropzone.dataset.semester;
            const isNewSubject = subjectTagToRemove.dataset.isNew === 'true';

            // Helper function to reset subject card appearance
            const resetSubjectCard = (originalSubjectCard) => {
                if (!originalSubjectCard) return;
                
                const subjectType = subjectData.subject_type;
                const geIdentifiers = ["GE", "General Education", "Gen Ed", "General"];
                let borderClass = '';

                // Determine border color based on subject type (matching createSubjectCard logic)
                if (subjectType === 'Major') {
                    borderClass = 'border-l-4 border-l-blue-500';
                } else if (subjectType === 'Minor') {
                    borderClass = 'border-l-4 border-l-purple-500';
                } else if (subjectType === 'Elective') {
                    borderClass = 'border-l-4 border-l-red-500';
                } else if (geIdentifiers.map(id => id.toLowerCase()).includes(subjectType.toLowerCase())) {
                    borderClass = 'border-l-4 border-l-orange-500';
                } else {
                    borderClass = 'border-l-4 border-l-gray-400';
                }
                
                // Reset subject to Available status
                originalSubjectCard.dataset.status = '';
                originalSubjectCard.setAttribute('draggable', 'true');
                
                // Reset card classes - completely reconstruct to ensure clean state
                originalSubjectCard.className = `subject-card p-4 border border-gray-200 rounded-xl shadow-md transition-all duration-200 flex items-center gap-4 group relative overflow-hidden bg-white ${borderClass} hover:shadow-lg hover:border-blue-400 hover:-translate-y-0.5 cursor-grab active:cursor-grabbing`;
                
                // Reset subject name color
                const subjectName = originalSubjectCard.querySelector('.subject-name');
                if (subjectName) {
                    subjectName.className = 'subject-name font-bold text-gray-800 text-base truncate pr-2';
                }

                // Reset subject code
                const subjectCode = originalSubjectCard.querySelector('.subject-code');
                if (subjectCode) {
                    subjectCode.className = 'subject-code font-mono text-gray-500 bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100';
                }
                
                // Reset separator dot
                const separatorDot = originalSubjectCard.querySelector('.separator-dot');
                if (separatorDot) {
                    separatorDot.className = 'separator-dot text-gray-400';
                }
                
                // Reset units
                const subjectUnits = originalSubjectCard.querySelector('.subject-units');
                if (subjectUnits) {
                    subjectUnits.className = 'subject-units font-medium text-gray-600';
                }
                
                // Reset type badge
                const typeBadge = originalSubjectCard.querySelector('.subject-type-badge');
                if (typeBadge) {
                    typeBadge.className = 'subject-type-badge text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded border text-gray-500 bg-gray-50 border-gray-100';
                }

                // Reset icon styling to default gray state
                const iconContainer = originalSubjectCard.querySelector('.flex-shrink-0');
                if (iconContainer) {
                    iconContainer.className = 'flex-shrink-0 w-12 h-12 icon-bg-default rounded-xl flex items-center justify-center transition-colors duration-300 shadow-sm group-hover:scale-105 transform transition-transform';
                    // Force SVG reset by replacing innerHTML to ensure no lingering classes
                    iconContainer.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    `;
                }
                
                // Reset status badge to Available
                const statusBadge = originalSubjectCard.querySelector('.status-badge');
                if (statusBadge) {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'status-badge text-[10px] uppercase tracking-wider font-bold text-gray-600 bg-gray-100 px-3 py-1 rounded-full';
                    newBadge.textContent = 'Available';
                    statusBadge.replaceWith(newBadge);
                }
                
                // Uncheck checkbox if it exists and is checked
                const checkbox = originalSubjectCard.querySelector('.add-subject-checkbox input');
                if (checkbox) {
                    checkbox.checked = false;
                }
            };

            // Remove subject from UI (both new and existing subjects)
            // No API call - changes will be saved when "Save the Mapping" is clicked
            const isPending = subjectTagToRemove.dataset.isPending === 'true';
            subjectTagToRemove.remove();
            
            // Update unit totals if it wasn't a pending subject
            if (!isPending) {
                updateUnitTotals();
            }
            
            // Reset the subject card to Available state
            const originalSubjectCard = document.getElementById(`subject-${subjectData.subject_code.toLowerCase()}`);
            if (originalSubjectCard) {
                resetSubjectCard(originalSubjectCard);
            }
            
            // Hide the modal
            hideRemoveConfirmationModal();
            
            // Show success message
            Swal.fire({
                title: 'Subject Removed!',
                text: `"${subjectData.subject_name}" (${subjectData.subject_code}) has been removed from Year ${year}, Semester ${semester}. Click "Save the Mapping" to save changes.`,
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#10B981',
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showClass: {
                    popup: 'animate__animated animate__fadeInRight'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutRight'
                }
            });
        });

        closeRemoveSuccessModal.addEventListener('click', () => {
            removeSuccessModal.classList.add('hidden');
        });
        
        const hideImportConfirmationModal = () => {
            const importConfirmationModal = document.getElementById('importConfirmationModal');
            const importModalPanel = document.getElementById('import-modal-panel');
            importConfirmationModal.classList.add('opacity-0');
            importModalPanel.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                importConfirmationModal.classList.add('hidden');
                subjectToImport = null;
            }, 300);
        };
        document.getElementById('cancelImportButton').addEventListener('click', hideImportConfirmationModal);
        
        document.getElementById('confirmImportButton').addEventListener('click', () => {
            if (subjectToImport) {
                // Redirect to the export route
                window.location.href = `/subjects/${subjectToImport.id}/export-pdf`;
            }
            hideImportConfirmationModal();
        });

        const handleExportClick = (dataset) => {
            if (!dataset.subjectData) return;
            subjectToImport = JSON.parse(dataset.subjectData);
            const importConfirmationModal = document.getElementById('importConfirmationModal');
            document.getElementById('import-modal-panel').classList.remove('opacity-0', 'scale-95');
            importConfirmationModal.classList.remove('hidden');
            setTimeout(() => {
                importConfirmationModal.classList.remove('opacity-0');
            }, 10);
            
            // Close either modal
            [document.getElementById('chedSubjectDetailsModal'), document.getElementById('depedSubjectDetailsModal')].forEach(modal => {
                if(modal && !modal.classList.contains('hidden')) {
                     const panelId = modal.id === 'chedSubjectDetailsModal' ? 'ched-modal-details-panel' : 'deped-modal-details-panel';
                     const panel = document.getElementById(panelId);
                     if (panel) panel.classList.add('opacity-0', 'scale-95');
                     modal.classList.add('opacity-0');
                     setTimeout(() => modal.classList.add('hidden'), 300);
                }
            });
        };

        const exportChedPdfButton = document.getElementById('exportChedPdfButton');
        if (exportChedPdfButton) {
            exportChedPdfButton.addEventListener('click', () => handleExportClick(exportChedPdfButton.dataset));
        }

        const exportDepedPdfButton = document.getElementById('exportDepedPdfButton');
        if (exportDepedPdfButton) {
            exportDepedPdfButton.addEventListener('click', () => handleExportClick(exportDepedPdfButton.dataset));
        }

        document.getElementById('saveCurriculumButton').addEventListener('click', () => {
            if (!curriculumSelector.value) {
                Swal.fire({
                    title: 'No Curriculum Selected!',
                    text: 'Please select a curriculum from the dropdown before saving.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#F59E0B'
                });
                return;
            }
            // Show traditional modal for save confirmation
            document.getElementById('saveMappingModal').classList.remove('hidden');
        });

        // Add back modal event handlers
        document.getElementById('cancelSaveMapping').addEventListener('click', () => {
            document.getElementById('saveMappingModal').classList.add('hidden');
        });

        document.getElementById('confirmSaveMapping').addEventListener('click', async () => {
            document.getElementById('saveMappingModal').classList.add('hidden');
            
            const saveResult = await saveCurriculumData();
            
            if (saveResult) {
                console.log('Save successful:', saveResult.message);
                
                // Exit edit mode after successful save
                toggleEditMode(false);
                
                // Hide Save button and show Edit button
                document.getElementById('saveCurriculumButton').classList.add('hidden');
                document.getElementById('editCurriculumButton').classList.remove('hidden');
                
                // Show traditional modal for prerequisites setup
                document.getElementById('proceedToPrerequisitesModal').classList.remove('hidden');
            } else {
                console.log('Save failed.');
            }
        });

        const saveCurriculumData = async () => {
            const curriculumId = curriculumSelector.value;
            if (!curriculumId) {
                Swal.fire({
                    title: 'No Curriculum Selected!',
                    text: 'Please select a curriculum from the dropdown first.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#F59E0B'
                });
                return null; 
            }

            const curriculumData = [];
            document.querySelectorAll('.semester-dropzone').forEach(dropzone => {
                const year = dropzone.dataset.year;
                const semester = dropzone.dataset.semester;
                const subjects = [];
                
                dropzone.querySelectorAll('.subject-tag').forEach(tag => {
                    subjects.push(JSON.parse(tag.dataset.subjectData));
                });
                
                curriculumData.push({ year, semester, subjects });
            });

            try {
                const response = await fetch('/api/curriculums/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ curriculumId, curriculumData }),
                });

                if (!response.ok) {
                    const error = await response.json();
                    throw new Error(error.message || 'Failed to save the curriculum mapping.');
                }
                
                return await response.json();

            } catch (error) {
                console.error('Error during save:', error);
                Swal.fire({
                    title: 'Save Failed!',
                    text: 'An error occurred while saving the curriculum mapping: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'Try Again',
                    confirmButtonColor: '#EF4444',
                    showClass: {
                        popup: 'animate__animated animate__shakeX'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                return null;
            }
        };


        document.getElementById('declineProceedToPrerequisites').addEventListener('click', () => {
            document.getElementById('proceedToPrerequisitesModal').classList.add('hidden');
            document.getElementById('saveSuccessModal').classList.remove('hidden');
        });

        document.getElementById('confirmProceedToPrerequisites').addEventListener('click', () => {
            const curriculumId = curriculumSelector.value;
            window.location.href = `/pre_requisite?curriculumId=${curriculumId}`;
        });

        document.getElementById('closeSaveSuccessModal').addEventListener('click', () => {
            document.getElementById('saveSuccessModal').classList.add('hidden');
        });

        document.getElementById('closeMappingSuccessModal').addEventListener('click', () => {
            document.getElementById('mappingSuccessModal').classList.add('hidden');
            toggleEditMode(false); 
        });


        // Function to render available subjects in the left panel
        function renderAvailableSubjects(availableSubjects, mappedSubjects) {
            availableSubjectsContainer.innerHTML = '';
            
            if (!availableSubjects || availableSubjects.length === 0) {
                availableSubjectsContainer.innerHTML = '<p class="text-gray-500 text-center mt-4">No subjects available for this curriculum.</p>';
                return;
            }
            
            // Create a set of mapped subject IDs for quick lookup
            const mappedSubjectIds = new Set(mappedSubjects.map(s => s.id));
            
            availableSubjects.forEach(subject => {
                const isMapped = mappedSubjectIds.has(subject.id);
                const subjectCard = createSubjectCard(subject, isMapped);
                availableSubjectsContainer.appendChild(subjectCard);
            });
        }
        
        // Function to populate mapped subjects in the curriculum overview
        function populateMappedSubjects(mappedSubjects) {
            // Clear all existing subject tags
            document.querySelectorAll('.semester-dropzone .flex-wrap').forEach(container => {
                container.innerHTML = '';
            });
            
            if (!mappedSubjects || mappedSubjects.length === 0) {
                return;
            }
            
            // Group subjects by year and semester
            mappedSubjects.forEach(subject => {
                if (subject.pivot && subject.pivot.year && subject.pivot.semester) {
                    const dropzone = document.querySelector(
                        `.semester-dropzone[data-year="${subject.pivot.year}"][data-semester="${subject.pivot.semester}"]`
                    );
                    
                    if (dropzone) {
                        const container = dropzone.querySelector('.flex-wrap');
                        const subjectTag = createSubjectTag(subject, isEditing);
                        container.appendChild(subjectTag);
                    }
                }
            });
            
            // Update unit totals after populating
            updateUnitTotals();
        }

        function filterSubjects() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedType = typeFilter.value;
            const subjectCards = availableSubjectsContainer.querySelectorAll('.subject-card');
            const geIdentifiers = ["ge", "general education", "gen ed"];

            subjectCards.forEach(card => {
                const subjectData = JSON.parse(card.dataset.subjectData);
                const subjectType = subjectData.subject_type.toLowerCase();
                
                const searchMatch = subjectData.subject_name.toLowerCase().includes(searchTerm) || subjectData.subject_code.toLowerCase().includes(searchTerm);
                
                let typeMatch = false;
                if (selectedType === 'All Types') {
                    typeMatch = true;
                } else if (selectedType === 'GE') {
                    typeMatch = geIdentifiers.some(id => subjectType.includes(id));
                } else {
                    typeMatch = (subjectType === selectedType.toLowerCase());
                }

                card.style.display = (searchMatch && typeMatch) ? 'flex' : 'none';
            });
        }
        searchInput.addEventListener('input', filterSubjects);
        typeFilter.addEventListener('change', filterSubjects);


function renderCurriculumOverview(yearLevel, semesterUnits = []) {
    let html = '';
    const isSeniorHigh = yearLevel === 'Senior High';
    const maxYear = isSeniorHigh ? 2 : 4;

    const getYearSuffix = (year) => {
        if (year === 1) return 'st';
        if (year === 2) return 'nd';
        if (year === 3) return 'rd';
        return 'th';
    };

    // Helper function to get semester unit limit
    const getSemesterLimit = (year, semester) => {
        const semesterIndex = (year - 1) * 2 + (semester - 1);
        return semesterUnits[semesterIndex] || 0;
    };

    // Helper function to format units without .0
    const formatUnits = (units) => {
        const num = parseFloat(units);
        return num % 1 === 0 ? Math.floor(num) : num;
    };

    for (let i = 1; i <= maxYear; i++) {
        const yearTitle = `${i}${getYearSuffix(i)} Year`;
        const firstSemLimit = getSemesterLimit(i, 1);
        const secondSemLimit = getSemesterLimit(i, 2);
        
        let firstSemLabel = 'First Semester';
        let secondSemLabel = 'Second Semester';

        if (isSeniorHigh) {
            if (i === 1) {
                firstSemLabel = 'First Quarter';
                secondSemLabel = 'Second Quarter';
            } else if (i === 2) {
                firstSemLabel = 'Third Quarter';
                secondSemLabel = 'Fourth Quarter';
            }
        }
        
        html += `
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-3">${yearTitle}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="semester-dropzone bg-white border-2 border-solid border-gray-300 rounded-lg p-4 transition-colors shadow-md" data-year="${i}" data-semester="1" data-unit-limit="${firstSemLimit}">
                        <div class="border-b border-gray-200 pb-2 mb-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-semibold text-gray-600">${firstSemLabel}</h4>
                                    ${firstSemLimit > 0 ? `<p class="text-xs text-blue-600 font-medium">Limit: ${formatUnits(firstSemLimit)} units</p>` : ''}
                                </div>
                                <div class="semester-unit-display">
                                    <div class="semester-unit-total text-sm font-bold text-gray-700">Units: 0</div>
                                    ${firstSemLimit > 0 ? `<div class="unit-limit-bar mt-1 bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="unit-progress bg-blue-500 h-full transition-all duration-300" style="width: 0%"></div>
                                    </div>` : ''}
                                </div>
                            </div>
                            <div class="semester-type-totals mt-2 flex gap-x-3 gap-y-1 text-xs"></div>
                        </div>
                        <div class="flex-wrap space-y-2 min-h-[80px]"></div>
                         <div class="add-subject-btn-placeholder mt-2 text-center hidden">
                            <button class="add-subject-btn text-blue-600 hover:text-blue-800 font-semibold text-sm py-2 px-4 rounded-lg hover:bg-blue-100 transition-all">+ Select Subject</button>
                        </div>
                        <div class="add-all-btn-container mt-2 text-center hidden">
                            <button class="add-all-btn bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold text-sm py-2.5 px-5 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105 flex items-center justify-center gap-2 mx-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Confirm
                            </button>
                        </div>
                    </div>
                    <div class="semester-dropzone bg-white border-2 border-solid border-gray-300 rounded-lg p-4 transition-colors shadow-md" data-year="${i}" data-semester="2" data-unit-limit="${secondSemLimit}">
                        <div class="border-b border-gray-200 pb-2 mb-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-semibold text-gray-600">${secondSemLabel}</h4>
                                    ${secondSemLimit > 0 ? `<p class="text-xs text-blue-600 font-medium">Limit: ${formatUnits(secondSemLimit)} units</p>` : ''}
                                </div>
                                <div class="semester-unit-display">
                                    <div class="semester-unit-total text-sm font-bold text-gray-700">Units: 0</div>
                                    ${secondSemLimit > 0 ? `<div class="unit-limit-bar mt-1 bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="unit-progress bg-blue-500 h-full transition-all duration-300" style="width: 0%"></div>
                                    </div>` : ''}
                                </div>
                            </div>
                            <div class="semester-type-totals mt-2 flex gap-x-3 gap-y-1 text-xs"></div>
                        </div>
                        <div class="flex-wrap space-y-2 min-h-[80px]"></div>
                         <div class="add-subject-btn-placeholder mt-2 text-center hidden">
                            <button class="add-subject-btn text-blue-600 hover:text-blue-800 font-semibold text-sm py-2 px-4 rounded-lg hover:bg-blue-100 transition-all">+ Select Subject</button>
                        </div>
                        <div class="add-all-btn-container mt-2 text-center hidden">
                            <button class="add-all-btn bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold text-sm py-2.5 px-5 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105 flex items-center justify-center gap-2 mx-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
    }
            curriculumOverview.innerHTML = html;
             // Add event listeners for add subject buttons
            curriculumOverview.querySelectorAll('.add-subject-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const semesterDropzone = e.target.closest('.semester-dropzone');
                    toggleAddSubjectsMode(semesterDropzone);
                });
            });

            // Add event listeners for Add All buttons
            curriculumOverview.querySelectorAll('.add-all-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const semesterDropzone = e.target.closest('.semester-dropzone');
                    confirmAllPendingSubjects(semesterDropzone);
                });
            });

            // Add automatic checkbox functionality
            availableSubjectsContainer.addEventListener('change', (e) => {
                if (e.target.type === 'checkbox' && e.target.closest('.add-subject-checkbox') && isAddingSubjectsMode) {
                    const checkbox = e.target;
                    const subjectCard = checkbox.closest('.subject-card');
                    const subjectData = JSON.parse(subjectCard.dataset.subjectData);
                    const targetContainer = activeSemesterForAdding.querySelector('.flex-wrap');
                    
                    if (checkbox.checked) {
                        // Adding subject - check validation
                        const unitLimit = parseFloat(activeSemesterForAdding.dataset.unitLimit) || 0;
                        const isDuplicate = Array.from(targetContainer.querySelectorAll('.subject-tag')).some(tag => JSON.parse(tag.dataset.subjectData).subject_code === subjectData.subject_code);
                        
                        if (isDuplicate) {
                            checkbox.checked = false;
                            const year = activeSemesterForAdding.dataset.year;
                            const semester = activeSemesterForAdding.dataset.semester;
                            Swal.fire({
                                title: 'Duplicate Subject!',
                                text: `"${subjectData.subject_name}" is already assigned to Year ${year}, Semester ${semester}.`,
                                icon: 'warning',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#F59E0B'
                            });
                            return;
                        }
                        
                        if (unitLimit > 0) {
                            let currentTotal = 0;
                            // Count all subjects in the semester (both confirmed and pending)
                            targetContainer.querySelectorAll('.subject-tag').forEach(tag => {
                                const existingSubjectData = JSON.parse(tag.dataset.subjectData);
                                currentTotal += parseInt(existingSubjectData.subject_unit, 10) || 0;
                            });
                            
                            const newSubjectUnits = parseInt(subjectData.subject_unit, 10) || 0;
                            const wouldExceedLimit = (currentTotal + newSubjectUnits) > unitLimit;
                            
                            if (wouldExceedLimit) {
                                checkbox.checked = false;
                                const year = activeSemesterForAdding.dataset.year;
                                const semester = activeSemesterForAdding.dataset.semester;
                                const formatUnits = (units) => {
                                    const num = parseFloat(units);
                                    return num % 1 === 0 ? Math.floor(num) : num;
                                };
                                
                                Swal.fire({
                                    title: 'Unit Limit Exceeded!',
                                    html: `
                                        <div class="text-left">
                                            <p class="mb-2">Cannot add <strong>"${subjectData.subject_name}"</strong> (${formatUnits(newSubjectUnits)} units) to Year ${year}, Semester ${semester}.</p>
                                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                                <p class="text-sm text-red-700">
                                                    <strong>Current:</strong> ${formatUnits(currentTotal)} units<br>
                                                    <strong>Adding:</strong> ${formatUnits(newSubjectUnits)} units<br>
                                                    <strong>Total would be:</strong> ${formatUnits(currentTotal + newSubjectUnits)} units<br>
                                                    <strong>Semester limit:</strong> ${formatUnits(unitLimit)} units
                                                </p>
                                            </div>
                                        </div>
                                    `,
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#EF4444'
                                });
                                return;
                            }
                        }
                        
                        // Add subject as pending (blurry) initially
                        const subjectTag = createSubjectTag(subjectData, true);
                        subjectTag.dataset.isNew = 'true';
                        subjectTag.dataset.isPending = 'true';
                        subjectTag.classList.add('opacity-50', 'pending-subject');
                        targetContainer.appendChild(subjectTag);
                        
                        // Update subject card appearance to show it's selected (pending)
                        const geIdentifiers = ["GE", "General Education", "Gen Ed", "General"];
                        let assignedClass = 'border-gray-400';
                        let iconBgClass = 'bg-gray-500';
                        let iconSvgClass = 'text-white';
                        let subjectNameClass = 'text-gray-800';
                        let textColorClass = 'text-gray-500 font-bold';
                        let unitsColorClass = 'text-gray-600 font-bold';
                        let dotColorClass = 'text-gray-400';
                        let typeBadgeClass = 'text-white bg-gray-500 border-gray-500';

                        switch (true) {
                            case subjectData.subject_type === 'Major':
                                assignedClass = 'border-blue-500';
                                iconBgClass = 'bg-blue-500';
                                iconSvgClass = 'text-white';
                                subjectNameClass = 'text-blue-700';
                                textColorClass = 'text-blue-600 font-bold';
                                unitsColorClass = 'text-blue-600 font-bold';
                                dotColorClass = 'text-blue-400';
                                typeBadgeClass = 'text-white bg-blue-500 border-blue-500';
                                break;
                            case subjectData.subject_type === 'Minor':
                                assignedClass = 'border-purple-500';
                                iconBgClass = 'bg-purple-500';
                                iconSvgClass = 'text-white';
                                subjectNameClass = 'text-purple-700';
                                textColorClass = 'text-purple-600 font-bold';
                                unitsColorClass = 'text-purple-600 font-bold';
                                dotColorClass = 'text-purple-400';
                                typeBadgeClass = 'text-white bg-purple-500 border-purple-500';
                                break;
                            case subjectData.subject_type === 'Elective':
                                assignedClass = 'border-red-500';
                                iconBgClass = 'bg-red-500';
                                iconSvgClass = 'text-white';
                                subjectNameClass = 'text-red-700';
                                textColorClass = 'text-red-600 font-bold';
                                unitsColorClass = 'text-red-600 font-bold';
                                dotColorClass = 'text-red-400';
                                typeBadgeClass = 'text-white bg-red-500 border-red-500';
                                break;
                            case geIdentifiers.map(id => id.toLowerCase()).includes(subjectData.subject_type.toLowerCase()):
                                assignedClass = 'border-orange-500';
                                iconBgClass = 'bg-orange-500';
                                iconSvgClass = 'text-white';
                                subjectNameClass = 'text-orange-700';
                                textColorClass = 'text-orange-600 font-bold';
                                unitsColorClass = 'text-orange-600 font-bold';
                                dotColorClass = 'text-orange-400';
                                typeBadgeClass = 'text-white bg-orange-500 border-orange-500';
                                break;
                        }
                        
                        // Apply pending styling to subject card
                        subjectCard.classList.remove('bg-white', 'hover:shadow-lg', 'hover:border-blue-400', 'cursor-grab', 'active:cursor-grabbing');
                        subjectCard.classList.add(assignedClass, 'opacity-70', 'cursor-not-allowed', 'bg-white', 'border-2');
                        subjectCard.setAttribute('draggable', false);
                        
                        // Update icon styling
                        const iconContainer = subjectCard.querySelector('.flex-shrink-0');
                        const iconSvg = iconContainer?.querySelector('svg');
                        const subjectName = subjectCard.querySelector('.subject-name');
                        const subjectCode = subjectCard.querySelector('.subject-code');
                        const separatorDot = subjectCard.querySelector('.separator-dot');
                        const subjectUnits = subjectCard.querySelector('.subject-units');
                        const typeBadge = subjectCard.querySelector('.subject-type-badge');

                        if (iconContainer) {
                            iconContainer.className = `flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center transition-colors duration-300 shadow-sm group-hover:scale-105 transform transition-transform ${iconBgClass}`;
                            // Force SVG update by replacing innerHTML to ensure correct color class application
                            iconContainer.innerHTML = `
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2" style="stroke: white !important; color: white !important;">
                                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            `;
                        }
                        
                        // Update text colors
                        if (subjectName) {
                            subjectName.classList.remove('text-gray-800');
                            subjectName.classList.add(subjectNameClass);
                        }
                        if (subjectCode) {
                            subjectCode.className = `subject-code font-mono bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100 ${textColorClass}`;
                        }
                        if (separatorDot) {
                            separatorDot.classList.remove('text-gray-400');
                            separatorDot.classList.add(dotColorClass);
                        }
                        if (subjectUnits) {
                            subjectUnits.className = `subject-units font-medium ${unitsColorClass}`;
                        }
                        if (typeBadge) {
                            typeBadge.className = `subject-type-badge text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded border ${typeBadgeClass}`;
                        }
                        
                        // Update status badge
                        const statusBadge = subjectCard.querySelector('.status-badge');
                        if (statusBadge) {
                            statusBadge.textContent = 'Pending';
                            statusBadge.className = 'status-badge text-[10px] uppercase tracking-wider font-bold px-3 py-1 rounded-full bg-yellow-100 text-yellow-700';
                        }
                        
                        // Show the "Confirm" button for this semester if there are pending subjects
                        showAddAllButton(activeSemesterForAdding);
                        
                        // Update ALL semester buttons globally to hide + Select Subject buttons
                        updateAllSemesterButtons();
                        
                        // Update unit totals to include pending subjects
                        updateUnitTotals();
                    } else {
                        // Removing subject - find and remove from semester
                        const subjectTagToRemove = Array.from(targetContainer.querySelectorAll('.subject-tag')).find(tag => {
                            const tagData = JSON.parse(tag.dataset.subjectData);
                            return tagData.subject_code === subjectData.subject_code;
                        });
                        
                        if (subjectTagToRemove) {
                            subjectTagToRemove.remove();
                            
                            // Reset subject card to normal appearance
                            subjectCard.classList.remove('assigned-card', 'assigned-major', 'assigned-minor', 'assigned-elective', 'assigned-general', 'cursor-not-allowed');
                            subjectCard.classList.add('bg-white', 'hover:shadow-md', 'hover:border-blue-400', 'cursor-grab');
                            subjectCard.setAttribute('draggable', true);
                            
                            // Reset icon background and color to original subject type
                            const iconContainer = subjectCard.querySelector('.flex-shrink-0');
                            const iconSvg = iconContainer?.querySelector('svg');
                            const subjectType = subjectData.subject_type.toLowerCase();
                            
                            // Restore original icon styling based on subject type
                            if (subjectType.includes('major')) {
                                if (iconContainer) iconContainer.className = 'flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center transition-colors duration-300';
                                if (iconSvg) iconSvg.className = 'h-6 w-6 text-blue-600 transition-colors duration-300';
                            } else if (subjectType.includes('minor')) {
                                if (iconContainer) iconContainer.className = 'flex-shrink-0 w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center transition-colors duration-300';
                                if (iconSvg) iconSvg.className = 'h-6 w-6 text-purple-600 transition-colors duration-300';
                            } else if (subjectType.includes('elective')) {
                                if (iconContainer) iconContainer.className = 'flex-shrink-0 w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center transition-colors duration-300';
                                if (iconSvg) iconSvg.className = 'h-6 w-6 text-red-600 transition-colors duration-300';
                            } else {
                                if (iconContainer) iconContainer.className = 'flex-shrink-0 w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center transition-colors duration-300';
                                if (iconSvg) iconSvg.className = 'h-6 w-6 text-orange-600 transition-colors duration-300';
                            }
                            
                            // Reset status badge
                            subjectCard.querySelector('.status-badge').textContent = 'Available';
                            subjectCard.querySelector('.status-badge').className = 'status-badge text-[10px] uppercase tracking-wider font-bold px-3 py-1 rounded-full bg-gray-100 text-gray-600';
                            
                            updateUnitTotals();
                            
                            // Check if we need to hide Add All button
                            if (activeSemesterForAdding) {
                                showAddAllButton(activeSemesterForAdding);
                            }
                        }
                    }
                }
            });
            
            // Function to update ALL semester buttons based on global pending status
            window.updateAllSemesterButtons = () => {
                // Check if there are ANY pending subjects in Available Subjects (globally)
                const anyPendingInAvailableSubjects = document.querySelectorAll('.subject-card .status-badge').length > 0 && 
                    Array.from(document.querySelectorAll('.subject-card .status-badge')).some(badge => 
                        badge.textContent.trim().toLowerCase() === 'pending'
                    );
                
                // Add or remove class from body to control ALL + Select Subject buttons via CSS
                if (anyPendingInAvailableSubjects || isAddingSubjectsMode) {
                    document.body.classList.add('has-pending-subjects');
                } else {
                    document.body.classList.remove('has-pending-subjects');
                }
                
                // Update all semester dropzones for both Confirm and "+ Select Subject" buttons
                document.querySelectorAll('.semester-dropzone').forEach(semester => {
                    const hasPendingInSemester = semester.querySelectorAll('.subject-tag[data-is-pending="true"]').length > 0;
                    const addAllBtn = semester.querySelector('.add-all-btn-container');
                    const addSubjectBtn = semester.querySelector('.add-subject-btn-placeholder');
                    
                    // Show/hide Confirm button
                    if (addAllBtn) {
                        if (hasPendingInSemester) {
                            addAllBtn.classList.remove('hidden');
                        } else {
                            addAllBtn.classList.add('hidden');
                        }
                    }
                    
                    // Show/hide "+ Select Subject" button
                    if (addSubjectBtn) {
                        // Show button only if:
                        // 1. We're in editing mode
                        // 2. No pending subjects in this semester
                        // 3. No pending subjects globally
                        // 4. Not currently in adding subjects mode
                        if (isEditing && !hasPendingInSemester && !anyPendingInAvailableSubjects && !isAddingSubjectsMode) {
                            addSubjectBtn.classList.remove('hidden');
                        } else {
                            addSubjectBtn.classList.add('hidden');
                        }
                    }
                });
            };
            
            // Function to show/hide Confirm button based on pending subjects
            // This now just calls updateAllSemesterButtons for consistency
            window.showAddAllButton = (semesterDropzone) => {
                updateAllSemesterButtons();
            };
            
            // Function to confirm all pending subjects in a semester
            window.confirmAllPendingSubjects = (semesterDropzone) => {
                const pendingSubjects = semesterDropzone.querySelectorAll('.subject-tag[data-is-pending="true"]');
                
                pendingSubjects.forEach(subjectTag => {
                    // Make subject solid and remove pending state
                    subjectTag.classList.remove('opacity-50', 'pending-subject');
                    subjectTag.dataset.isPending = 'false';
                    
                    // Update corresponding subject card appearance
                    const subjectData = JSON.parse(subjectTag.dataset.subjectData);
                    const subjectCard = document.getElementById(`subject-${subjectData.subject_code.toLowerCase()}`);
                    
                    if (subjectCard) {
                        // Apply proper styling based on subject type
                        const geIdentifiers = ["GE", "General Education", "Gen Ed", "General"];
                        let assignedClass = 'border-gray-400';
                        let iconBgClass = 'bg-gray-500';
                        let iconSvgClass = 'text-white';
                        let subjectNameClass = 'text-gray-800';
                        let textColorClass = 'text-gray-500';
                        let unitsColorClass = 'text-gray-600';
                        let dotColorClass = 'text-gray-400';
                        let typeBadgeClass = 'text-gray-500 bg-gray-50 border-gray-100';

                        switch (true) {
                            case subjectData.subject_type === 'Major':
                                assignedClass = 'border-blue-500';
                                iconBgClass = 'bg-blue-500';
                                iconSvgClass = 'text-white';
                                subjectNameClass = 'text-blue-700';
                                textColorClass = 'text-blue-600 font-bold';
                                unitsColorClass = 'text-blue-600 font-bold';
                                dotColorClass = 'text-blue-400';
                                typeBadgeClass = 'text-white bg-blue-500 border-blue-500';
                                break;
                            case subjectData.subject_type === 'Minor':
                                assignedClass = 'border-purple-500';
                                iconBgClass = 'bg-purple-500';
                                iconSvgClass = 'text-white';
                                subjectNameClass = 'text-purple-700';
                                textColorClass = 'text-purple-600 font-bold';
                                unitsColorClass = 'text-purple-600 font-bold';
                                dotColorClass = 'text-purple-400';
                                typeBadgeClass = 'text-white bg-purple-500 border-purple-500';
                                break;
                            case subjectData.subject_type === 'Elective':
                                assignedClass = 'border-red-500';
                                iconBgClass = 'bg-red-500';
                                iconSvgClass = 'text-white';
                                subjectNameClass = 'text-red-700';
                                textColorClass = 'text-red-600 font-bold';
                                unitsColorClass = 'text-red-600 font-bold';
                                dotColorClass = 'text-red-400';
                                typeBadgeClass = 'text-white bg-red-500 border-red-500';
                                break;
                            case geIdentifiers.map(id => id.toLowerCase()).includes(subjectData.subject_type.toLowerCase()):
                                assignedClass = 'border-orange-500';
                                iconBgClass = 'bg-orange-500';
                                iconSvgClass = 'text-white';
                                subjectNameClass = 'text-orange-700';
                                textColorClass = 'text-orange-600 font-bold';
                                unitsColorClass = 'text-orange-600 font-bold';
                                dotColorClass = 'text-orange-400';
                                typeBadgeClass = 'text-white bg-orange-500 border-orange-500';
                                break;
                        }
                        
                        subjectCard.classList.remove('opacity-70'); // Remove pending opacity
                        subjectCard.classList.add(assignedClass, 'cursor-not-allowed', 'bg-white', 'border-2');
                        subjectCard.setAttribute('draggable', false);
                        
                        // Update icon styling
                        const iconContainer = subjectCard.querySelector('.flex-shrink-0');
                        const iconSvg = iconContainer?.querySelector('svg');
                        const subjectName = subjectCard.querySelector('.subject-name');
                        const subjectCode = subjectCard.querySelector('.subject-code');
                        const separatorDot = subjectCard.querySelector('.separator-dot');
                        const subjectUnits = subjectCard.querySelector('.subject-units');
                        const typeBadge = subjectCard.querySelector('.subject-type-badge');

                        if (iconContainer && iconSvg) {
                            // Reset icon classes first
                            iconContainer.className = `flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center transition-colors duration-300 shadow-sm group-hover:scale-105 transform transition-transform ${iconBgClass}`;
                            iconSvg.className = `h-6 w-6 transition-colors duration-300 ${iconSvgClass}`;
                        }
                        
                        // Update text colors
                        if (subjectName) {
                            subjectName.classList.remove('text-gray-800');
                            subjectName.classList.add(subjectNameClass);
                        }
                        if (subjectCode) {
                            subjectCode.classList.remove('text-gray-500');
                            subjectCode.className = `subject-code font-mono bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100 ${textColorClass}`;
                        }
                        if (separatorDot) {
                            separatorDot.classList.remove('text-gray-400');
                            separatorDot.classList.add(dotColorClass);
                        }
                        if (subjectUnits) {
                            subjectUnits.classList.remove('text-gray-600');
                            subjectUnits.className = `subject-units font-medium ${unitsColorClass}`;
                        }
                        if (typeBadge) {
                            typeBadge.className = `subject-type-badge text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded border ${typeBadgeClass}`;
                        }
                        
                        subjectCard.querySelector('.status-badge').textContent = 'Assigned';
                        subjectCard.querySelector('.status-badge').className = 'status-badge text-[10px] uppercase tracking-wider font-bold px-3 py-1 rounded-full bg-green-500 text-white shadow-sm';
                        
                        // Hide and uncheck the checkbox
                        const checkboxDiv = subjectCard.querySelector('.add-subject-checkbox');
                        const checkbox = subjectCard.querySelector('.add-subject-checkbox input');
                        if (checkboxDiv && checkbox) {
                            checkboxDiv.classList.add('hidden');
                            checkbox.checked = false;
                        }
                    }
                });
                
                // Hide the Add All button
                const addAllContainer = semesterDropzone.querySelector('.add-all-btn-container');
                addAllContainer.classList.add('hidden');
                
                // Exit adding subjects mode to hide all remaining checkboxes
                toggleAddSubjectsMode(null);
                
                // Update unit totals now that subjects are confirmed
                updateUnitTotals();
                
                // Explicitly update all semester buttons to show "+ Select Subject" buttons
                // This ensures buttons reappear after confirming pending subjects
                setTimeout(() => {
                    updateAllSemesterButtons();
                }, 100);
            };
            
            initDragAndDrop();
        }

        function renderAvailableSubjects(subjects, mappedSubjects = []) {
            availableSubjectsContainer.innerHTML = '';
            const mappedSubjectCodes = new Set(
                (mappedSubjects || [])
                    .filter(s => s.pivot && s.pivot.year != null && s.pivot.semester != null)
                    .map(s => s.subject_code)
            );

            if (subjects.length === 0) {
                availableSubjectsContainer.innerHTML = '<p class="text-gray-500 text-center mt-4">No available subjects found.</p>';
            } else {
                subjects.forEach(subject => {
                    const isMapped = mappedSubjectCodes.has(subject.subject_code);
                    const newSubjectCard = createSubjectCard(subject, isMapped);
                    availableSubjectsContainer.appendChild(newSubjectCard);
                });
            }
        }

        function populateMappedSubjects(subjects) {
            if (!subjects) {
                updateUnitTotals();
                return;
            };
            document.querySelectorAll('.semester-dropzone .flex-wrap').forEach(el => el.innerHTML = '');

            subjects.forEach(subject => {
                const dropzone = document.querySelector(`#curriculumOverview .semester-dropzone[data-year="${subject.pivot.year}"][data-semester="${subject.pivot.semester}"] .flex-wrap`);
                if (dropzone) {
                    const subjectTag = createSubjectTag(subject, isEditing);
                    dropzone.appendChild(subjectTag);
                }
            });
            updateUnitTotals();
        }

        let allCurriculums = [];
        let filteredCurriculums = [];
        let currentAvailableSubjects = [];
        let currentMappedSubjects = [];

        function fetchCurriculums() {
            console.log('📡 Fetching curriculums from /api/curriculums...');
            fetch('/api/curriculums')
                .then(response => {
                    console.log('✅ API Response received:', response.status);
                    return response.json();
                })
                .then(curriculums => {
                    console.log('📊 Total curriculums from API:', curriculums.length);
                    console.log('📄 Raw curriculums:', curriculums);
                    
                    // Only filter out old versions, show both approved and non-approved
                    // Filter: Not old, AND (processing OR rejected)
                    const newCurriculums = curriculums.filter(curriculum => 
                        curriculum.version_status !== 'old' && 
                        (curriculum.approval_status === 'processing' || curriculum.approval_status === 'rejected')
                    );
                    
                    console.log('✨ Filtered curriculums (excluding old):', newCurriculums.length);
                    console.log('📋 Visible curriculums:', newCurriculums);
                    
                    allCurriculums = newCurriculums;
                    filteredCurriculums = [...newCurriculums];
                    
                    // Update hidden select for compatibility
                    curriculumSelector.innerHTML = '<option value="">Select a Curriculum</option>';
                    newCurriculums.forEach(curriculum => {
                        const academicYearText = curriculum.year_level === 'Senior High' ? '' : ` (${curriculum.academic_year})`;
                        const optionText = `${curriculum.year_level}: ${curriculum.program_code} ${curriculum.curriculum_name}${academicYearText}`;
                        const option = new Option(optionText, curriculum.id);
                        option.dataset.yearLevel = curriculum.year_level;
                        option.dataset.academicYear = curriculum.academic_year;
                        option.dataset.semesterUnits = JSON.stringify(curriculum.semester_units || []);
                        option.dataset.totalUnits = curriculum.total_units || 0;
                        curriculumSelector.appendChild(option);
                    });
                    
                    // Populate searchable dropdown
                    populateCurriculumOptions();
                    
                    const urlParams = new URLSearchParams(window.location.search);
                    const newCurriculumId = urlParams.get('curriculumId');
                    if (newCurriculumId) {
                        selectCurriculum(newCurriculumId);
                        setTimeout(() => fetchCurriculumData(newCurriculumId), 100);
                    }
                });
        }

        function populateCurriculumOptions() {
            console.log('🔧 Populating curriculum options...');
            const optionsContainer = document.getElementById('curriculumOptions');
            console.log('📦 Options container element:', optionsContainer);
            optionsContainer.innerHTML = '';
            
            if (filteredCurriculums.length === 0) {
                console.warn('⚠️ No curriculums to display!');
                optionsContainer.innerHTML = '<div class="px-3 py-2 text-gray-500 text-sm">No curriculums found</div>';
                return;
            }
            
            console.log('✅ Creating', filteredCurriculums.length, 'dropdown options');
            
            filteredCurriculums.forEach(curriculum => {
                const academicYearText = curriculum.year_level === 'Senior High' ? '' : ` (${curriculum.academic_year})`;
                const optionText = `${curriculum.year_level}: ${curriculum.program_code} ${curriculum.curriculum_name}${academicYearText}`;
                console.log('  ➕ Adding option:', optionText);
                const option = document.createElement('div');
                option.className = 'px-3 py-2 hover:bg-blue-50 cursor-pointer text-sm border-b border-gray-100 last:border-b-0';
                option.textContent = optionText;
                option.dataset.curriculumId = curriculum.id;
                option.dataset.yearLevel = curriculum.year_level;
                option.dataset.academicYear = curriculum.academic_year;
                option.dataset.semesterUnits = JSON.stringify(curriculum.semester_units || []);
                
                option.addEventListener('click', () => {
                    selectCurriculum(curriculum.id, optionText);
                    document.getElementById('curriculumDropdownMenu').classList.add('hidden');
                });
                
                optionsContainer.appendChild(option);
            });
        }

        function selectCurriculum(curriculumId, optionText = null) {
            // Update hidden select
            curriculumSelector.value = curriculumId;
            
            // Update dropdown display
            const dropdownText = document.getElementById('curriculumDropdownText');
            if (optionText) {
                dropdownText.textContent = optionText;
                dropdownText.className = 'text-gray-800';
            } else {
                // Find curriculum by ID
                const curriculum = allCurriculums.find(c => c.id == curriculumId);
                if (curriculum) {
                    const academicYearText = curriculum.year_level === 'Senior High' ? '' : ` (${curriculum.academic_year})`;
                    const text = `${curriculum.year_level}: ${curriculum.program_code} ${curriculum.curriculum_name}${academicYearText}`;
                    dropdownText.textContent = text;
                    dropdownText.className = 'text-gray-800';
                }
            }
            
            // Update URL to persist curriculum selection
            const url = new URL(window.location);
            url.searchParams.set('curriculumId', curriculumId);
            window.history.pushState({}, '', url);
            
            // Trigger change event to load curriculum data
            curriculumSelector.dispatchEvent(new Event('change'));
        }

        function filterCurriculums(searchTerm) {
            const term = searchTerm.toLowerCase();
            filteredCurriculums = allCurriculums.filter(curriculum => {
                const academicYearText = curriculum.year_level === 'Senior High' ? '' : ` ${curriculum.academic_year}`;
                const searchText = `${curriculum.year_level} ${curriculum.program_code} ${curriculum.curriculum_name}${academicYearText}`.toLowerCase();
                return searchText.includes(term);
            });
            populateCurriculumOptions();
        }

        // Load all subjects initially
        function loadAllSubjects() {
            fetch('/api/subjects')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (!data || !Array.isArray(data)) throw new Error('Invalid subjects data from server.');
                    
                    // Store locally
                    currentAvailableSubjects = data;
                    currentMappedSubjects = []; // None mapped yet
                    allSystemSubjects = data;

                    // Show all subjects as available (none are mapped yet)
                    renderAvailableSubjects(data, []);
                })
                .catch(error => {
                    console.error('Error loading subjects:', error);
                    availableSubjectsContainer.innerHTML = '<p class="text-red-500 text-center mt-4">Error loading subjects. Please refresh the page.</p>';
                });
        }

        function fetchCurriculumData(id) {
            const selectedOption = curriculumSelector.querySelector(`option[value="${id}"]`);
            if (!selectedOption || !selectedOption.dataset.yearLevel) {
                curriculumOverview.innerHTML = '<p class="text-red-500 text-center mt-4">Could not determine year level. Please reload.</p>';
                return;
            }

            const yearLevel = selectedOption.dataset.yearLevel;
            const semesterUnits = JSON.parse(selectedOption.dataset.semesterUnits || '[]');
            renderCurriculumOverview(yearLevel, semesterUnits);

            // Fetch curriculum data and available subjects in parallel
            const curriculumDataPromise = fetch(`/api/curriculums/${id}`).then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            });
            
            const availableSubjectsPromise = fetch(`/api/curriculums/${id}/subjects`).then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            }).then(subjects => {
                console.log('Available subjects for curriculum', id, ':', subjects);
                return subjects;
            });
            
            Promise.all([curriculumDataPromise, availableSubjectsPromise])
                .then(([curriculumData, availableSubjects]) => {
                    if (!curriculumData || !curriculumData.curriculum) throw new Error('Invalid curriculum data structure from server.');
                    
                    // Store current state
                    currentAvailableSubjects = availableSubjects || [];
                    currentMappedSubjects = curriculumData.curriculum.subjects || [];

                    renderAvailableSubjects(currentAvailableSubjects, currentMappedSubjects);
                    populateMappedSubjects(currentMappedSubjects);
                    
                    const hasMappedSubjects = curriculumData.curriculum.subjects.length > 0;
                    
                    if (hasMappedSubjects) {
                        toggleEditMode(false);
                        document.getElementById('editCurriculumButton').classList.remove('hidden');
                        document.getElementById('saveCurriculumButton').classList.add('hidden');
                    } else {
                        toggleEditMode(true);
                        document.getElementById('editCurriculumButton').classList.add('hidden');
                        const saveBtn = document.getElementById('saveCurriculumButton');
                        saveBtn.classList.remove('hidden');
                        saveBtn.disabled = false;
                    }
                    
                    // Show the Add Subjects button when curriculum is selected
                    openAddSubjectsModalBtn.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching curriculum data:', error);
                    Swal.fire({
                        title: 'Failed to Load Curriculum!',
                        text: 'Could not load curriculum data from the server. Please check your connection and try again.',
                        icon: 'error',
                        confirmButtonText: 'Retry',
                        confirmButtonColor: '#EF4444',
                        showClass: {
                            popup: 'animate__animated animate__shakeX'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                    availableSubjectsContainer.innerHTML = '<p class="text-red-500 text-center mt-4">Could not load subjects.</p>';
                });
        }
        
        document.getElementById('editCurriculumButton').addEventListener('click', (e) => {
            if (isEditing) {
                toggleEditMode(false);
            } else {
                editConfirmationModal.classList.remove('hidden');
            }
        });

        document.getElementById('cancelEditBtn').addEventListener('click', () => {
            editConfirmationModal.classList.add('hidden');
        });

        document.getElementById('confirmEditBtn').addEventListener('click', () => {
            editConfirmationModal.classList.add('hidden');
            toggleEditMode(true);
            
            // Hide Edit button and show Save button
            document.getElementById('editCurriculumButton').classList.add('hidden');
            const saveBtn = document.getElementById('saveCurriculumButton');
            saveBtn.classList.remove('hidden');
            saveBtn.disabled = false;
        });

        document.getElementById('saveCurriculumButton').addEventListener('click', () => {
            document.getElementById('saveMappingModal').classList.remove('hidden');
        });

        const reassignModal = document.getElementById('reassignConfirmationModal');
        const confirmReassignBtn = document.getElementById('confirmReassignBtn');
        const cancelReassignBtn = document.getElementById('cancelReassignBtn');

        confirmReassignBtn.addEventListener('click', () => {
            if (!itemToReassign || !reassignTargetContainer) return;

            const droppedSubjectData = JSON.parse(itemToReassign.dataset.subjectData);
            
            itemToReassign.parentNode.removeChild(itemToReassign);
            const subjectTag = createSubjectTag(droppedSubjectData, isEditing);
            reassignTargetContainer.appendChild(subjectTag);
            updateUnitTotals();
            
            reassignModal.classList.add('hidden');
            
            // Use SweetAlert for reassign success
            Swal.fire({
                title: 'Subject Reassigned Successfully!',
                text: `"${droppedSubjectData.subject_name}" (${droppedSubjectData.subject_code}) has been successfully moved to the new semester.`,
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#10B981',
                timer: 4000,
                timerProgressBar: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });

            itemToReassign = null;
            reassignTargetContainer = null;
        });

        cancelReassignBtn.addEventListener('click', () => {
            reassignModal.classList.add('hidden');
            itemToReassign = null;
            reassignTargetContainer = null;
        });


        document.getElementById('closeReassignSuccessBtn').addEventListener('click', () => {
            document.getElementById('reassignSuccessModal').classList.add('hidden');
        });


        // Global map to store Memorandum -> Group mapping
        let complianceLinksMap = new Map();

        const fetchComplianceLinks = async () => {
             try {
                 const response = await fetch('/api/compliance-links?agency=DepEd');
                 if (!response.ok) return;
                 const links = await response.json();
                 
                 complianceLinksMap.clear();
                 links.forEach(link => {
                     // Map the Official Title (link.title) to its Group (link.group)
                     // If link.title matches subject.memorandum, we use link.group as the Display Name
                     if (link.title && link.group) {
                         complianceLinksMap.set(link.title, link.group);
                     }
                 });
                 console.log('📋 Compliance Links Map Loaded:', complianceLinksMap.size, 'entries');
             } catch (error) {
                 console.error('Error loading compliance links:', error);
             }
        };

        // Function to show Add Subjects Modal
        const showAddSubjectsModal = () => {
            // Get max units from selected curriculum
            const selectedOption = curriculumSelector.options[curriculumSelector.selectedIndex];
            const maxTotalUnits = parseFloat(selectedOption.dataset.totalUnits) || 0;
            
            // Calculate current total units from available subjects
            let currentTotalUnits = 0;
            availableSubjectsContainer.querySelectorAll('.subject-card').forEach(card => {
                const subjectData = JSON.parse(card.dataset.subjectData);
                currentTotalUnits += parseFloat(subjectData.subject_unit) || 0;
            });
            
            // Store these in modal dataset for easy access
            addSubjectsModal.dataset.maxUnits = maxTotalUnits;
            addSubjectsModal.dataset.currentUnits = currentTotalUnits;
            
            // Update initial display
            updateSelectedCount();

            // Reset View to Memorandums
            document.getElementById('memorandumListView').classList.remove('hidden');
            document.getElementById('subjectListView').classList.add('hidden');
            document.getElementById('addSubjectsModalTitle').textContent = 'Select Memorandum';
            document.getElementById('addSubjectsModalSubtitle').textContent = 'Choose a memorandum to view associated subjects';
            
            // Show search bar and clear it
            const searchInput = document.getElementById('modalSubjectSearch');
            searchInput.classList.remove('hidden');
            searchInput.value = '';
            searchInput.placeholder = 'Search memorandums...';

            // RESET selected memorandums
            selectedMemorandums.clear();
            
            // Update button text
            const confirmBtn = document.getElementById('confirmAddSubjects');
            if (confirmBtn) {
                confirmBtn.textContent = 'Confirm';
            }

            // Determine Memorandum Category Filter based on Curriculum Format
            const yearLevel = selectedOption.dataset.yearLevel;
            const isSeniorHigh = yearLevel === 'Senior High';
            const requiredCategory = isSeniorHigh ? 'DepEd' : 'CHED';
            
            console.log(`📋 Fetching all system subjects... Filter: ${requiredCategory}`);
            
            // Fetch ALL subjects from the system to show in memorandum modal
            // AND fetch compliance links for mapping
            Promise.all([
                fetch('/api/subjects').then(r => r.json()),
                isSeniorHigh ? fetchComplianceLinks() : Promise.resolve() 
            ])
            .then(([subjects, _]) => {
                console.log('📋 All System Subjects:', subjects);
                allSystemSubjects = subjects;
                renderMemorandums(subjects, requiredCategory);
                
                // Show modal with animation
                addSubjectsModal.classList.remove('hidden');
                setTimeout(() => {
                    addSubjectsModal.classList.remove('opacity-0');
                    addSubjectsModalPanel.classList.remove('opacity-0', 'scale-95');
                }, 10);
            })
            .catch(error => {
                console.error('Error loading data:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to load subjects. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#EF4444'
                });
            });
        };

        const selectedMemorandums = new Set();
        const confirmedMemorandums = new Set(); // Track which memorandums have been confirmed

        // Function to render Memorandums
        const renderMemorandums = (subjects, requiredCategory = null, parentCategory = null) => {
            const memoContainer = document.getElementById('memorandumListView');
            
            // Force vertical column layout
            memoContainer.className = 'flex flex-col gap-3';
            memoContainer.innerHTML = '';
            
            // Check if we're in locked mode (memorandums have been confirmed)
            const isLockedMode = confirmedMemorandums.size > 0;

            // Logic for navigating levels (Category -> Title -> Subjects)
            // If parentCategory is provided, we are viewing the "Titles" (Memorandums) under that Category
            // If parentCategory is NULL, we are viewing top-level Categories (for DepEd) or Memorandums (for CHED)

            let itemsToRender = [];
            const isDepEd = requiredCategory && requiredCategory.toUpperCase() === 'DEPED';

            if (isDepEd && !parentCategory) {
                // LEVEL 1: Show Categories (e.g. Core, Academic, TechPro, Shape Paper)
                const categories = new Set();
                subjects.forEach(s => {
                    if (s.memorandum_category) {
                         const validCategories = ['Shape Paper', 'Curriculum Guides (Core)', 'Curriculum Guides (Academic)', 'Curriculum Guides (TechPro)'];
                         const cat = s.memorandum_category.trim();
                         if (validCategories.includes(cat)) {
                             categories.add(cat);
                         }
                    }
                });

                itemsToRender = Array.from(categories).map(cat => {
                     const isFolder = ['Curriculum Guides (Academic)', 'Curriculum Guides (TechPro)'].includes(cat);
                     const catSubjects = subjects.filter(s => s.memorandum_category === cat);
                     
                     return {
                          name: cat,
                          displayName: cat, 
                          type: isFolder ? 'folder' : 'memorandum',
                          count: catSubjects.length,
                          subjects: catSubjects,
                          category: cat
                     };
                });
            } else if (isDepEd && parentCategory) {
                // LEVEL 2: We are inside a Category (Academic or TechPro)
                // We need to group subjects by their "Title / Group" which we resolve via complianceLinksMap
                
                const isGroupedCategory = ['Curriculum Guides (Academic)', 'Curriculum Guides (TechPro)'].includes(parentCategory);

                if (isGroupedCategory) {
                     const memorandums = {};
                     
                     subjects.forEach(subject => {
                        if (subject.memorandum_category === parentCategory) {
                             const officialMemo = subject.memorandum || 'No Group';
                             
                             // Resolve the Group Title using the map
                             // Fallback to officialMemo if no mapping found (or regex parsing if preferred)
                             let groupTitle = complianceLinksMap.get(officialMemo);
                             
                             if (!groupTitle) {
                                 // Fallback: If not found in map, try to be smart or just use the memo
                                 // The user explicitly asked to use the "Right Title/Group"
                                 // If the mapping is missing, it might mean the subject data is old or mismatched.
                                 // We will fallback to the simple regex parser for safety, 
                                 // but prioritize the mapped value.
                                 let displayName = officialMemo;
                                 if (displayName.includes('•')) displayName = displayName.split('•').pop().trim();
                                 const parenIndex = displayName.indexOf('(');
                                 if (parenIndex > 0) displayName = displayName.substring(0, parenIndex).trim();
                                 groupTitle = displayName;
                             }

                             // We Group BY this Resolved Title
                             if (!memorandums[groupTitle]) {
                                 memorandums[groupTitle] = {
                                     name: groupTitle, // We use the GROUP TITLE as the key/name now
                                     displayName: groupTitle,
                                     type: 'memorandum', 
                                     count: 0,
                                     subjects: []
                                 };
                             }
                             memorandums[groupTitle].count++;
                             memorandums[groupTitle].subjects.push(subject);
                        }
                     });
                     itemsToRender = Object.values(memorandums);
                } else {
                     return; 
                }
            } else {
                // CHED or Default: Show Memorandums directly
                const memorandums = {};
                subjects.forEach(subject => {
                    const memoName = subject.memorandum || 'No Memorandum';
                    const memoCat = (subject.memorandum_category || '').trim();
                    const depedCategories = ['Shape Paper', 'Curriculum Guides (Core)', 'Curriculum Guides (Academic)', 'Curriculum Guides (TechPro)'];
                    
                    let include = true;
                    if (requiredCategory && requiredCategory.toUpperCase() === 'CHED') {
                        if (memoCat && memoCat !== 'N/A' && depedCategories.includes(memoCat)) {
                            include = false;
                        }
                    }

                    if (include) {
                        if (!memorandums[memoName]) {
                            memorandums[memoName] = {
                                name: memoName,
                                displayName: memoName,
                                type: 'memorandum',
                                year: subject.memorandum_year || 'N/A',
                                count: 0,
                                subjects: []
                            };
                        }
                        memorandums[memoName].count++;
                        memorandums[memoName].subjects.push(subject);
                    }
                });
                itemsToRender = Object.values(memorandums);
            }
            // -------------------------------------------------

            if (itemsToRender.length === 0) {
                 memoContainer.innerHTML = `<p class="text-gray-500 text-center py-8">No records found.</p>`;
                 return;
            }

            // Sort: Folders first, then files? Or alphabetical? Let's do alphabetical.
            itemsToRender.sort((a, b) => a.displayName.localeCompare(b.displayName));
            
            // Add "Back" button if parentCategory exists
            if (parentCategory) {
                const backDiv = document.createElement('div');
                backDiv.className = 'mb-2';
                backDiv.innerHTML = `
                    <button class="flex items-center text-blue-600 hover:text-blue-800 font-medium px-2 py-1 rounded hover:bg-blue-50 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Back to Categories
                    </button>
                `;
                backDiv.querySelector('button').addEventListener('click', () => {
                    renderMemorandums(subjects, requiredCategory, null);
                });
                memoContainer.appendChild(backDiv);
            }

            itemsToRender.forEach(item => {
                const card = document.createElement('div');
                const displayName = item.displayName || item.name; // Use Display Name only
                
                const isFolder = item.type === 'folder';
                const isSelected = !isFolder && selectedMemorandums.has(item.name); // Only checking by name might be risky if duplicated, but okay for now
                
                // Styling
                let icon = '';
                let bgColor = 'bg-blue-100';
                let iconColor = 'text-blue-500';

                if (isFolder) {
                    // Folder Icon
                    icon = `<svg class="w-6 h-6 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>`;
                    bgColor = 'bg-yellow-100';
                    iconColor = 'text-yellow-600';
                } else {
                    // Document Icon
                    icon = `<svg class="w-6 h-6 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>`;
                }

                // Check if locked
                const isLocked = !isFolder && isLockedMode && !confirmedMemorandums.has(item.name);

                let cardClasses = 'p-4 border border-gray-200 rounded-lg transition-colors flex justify-between items-center';
                if (isLocked) {
                    cardClasses += ' bg-gray-50 opacity-50 cursor-not-allowed';
                } else {
                    cardClasses += ' hover:bg-gray-50 cursor-pointer group';
                }
                card.className = cardClasses;

                card.innerHTML = `
                    <div class="flex items-center gap-4">
                        ${(!isFolder && !isLockedMode) ? `
                        <div class="flex items-center h-5" onclick="event.stopPropagation()">
                            <input type="checkbox" class="memorandum-checkbox w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" ${isSelected ? 'checked' : ''} ${isLocked ? 'disabled' : ''}>
                        </div>
                        ` : ''}
                        <div class="w-12 h-12 ${bgColor} rounded-lg flex items-center justify-center ${isLocked ? 'opacity-50' : ''}">
                           ${icon}
                        </div>
                        <div>
                            <h3 class="font-semibold ${isLocked ? 'text-gray-400' : 'text-gray-800 group-hover:text-blue-700'}">${displayName}</h3>
                            <p class="text-sm ${isLocked ? 'text-gray-400' : 'text-gray-500'}">${item.count} ${item.count === 1 ? 'Item' : 'Items'} ${item.year ? `• ${item.year}` : ''}</p>
                        </div>
                    </div>
                    ${isFolder ? `
                    <div class="text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    ` : ''}
                `;

                if (isFolder) {
                    card.addEventListener('click', () => {
                        // Drill down
                        renderMemorandums(subjects, requiredCategory, item.name);
                    });
                } else if (!isLocked && !isLockedMode) {
                    const checkbox = card.querySelector('.memorandum-checkbox');
                    
                    checkbox.addEventListener('change', (e) => {
                        if (e.target.checked) {
                            selectedMemorandums.add(item.name);
                        } else {
                            selectedMemorandums.delete(item.name);
                        }
                        updateSelectedMemoInfo();
                    });

                    card.addEventListener('click', (e) => {
                        if (e.target !== checkbox) {
                             checkbox.checked = !checkbox.checked;
                             checkbox.dispatchEvent(new Event('change'));
                        }
                    });
                    
                    // Context Menu for Details
                    card.addEventListener('contextmenu', (e) => {
                        e.preventDefault();
                        // For "Core" logic where the category is the wrapper, we construct a fake 'memo' object to show details
                        // or just show summary of first subject?
                        // Let's reuse existing modal but caution about structure
                        showMemorandumDetailsModal({
                            name: item.name,
                            subjects: item.subjects,
                            year: item.subjects[0]?.memorandum_year || 'N/A' 
                        });
                    });
                }
                
                memoContainer.appendChild(card);
            });
            
            updateSelectedMemoInfo();
        };

        const updateSelectedMemoInfo = () => {
            const count = selectedMemorandums.size;
            document.getElementById('selectedSubjectsCount').textContent = count;
            
            // Update the count label
            const label = document.querySelector('#selectedSubjectsCount').nextSibling;
            if (label) {
                label.textContent = ` memorandum(s) selected`;
            }

            // Hide the unit limit display as it is not relevant for memo selection
            document.getElementById('modalUnitLimitDisplay').classList.add('hidden');
        };

        const applyMemorandumFilter = () => {
             const selectedMemos = Array.from(selectedMemorandums);
             
             if (selectedMemos.length === 0) {
                 Swal.fire({
                    title: 'No Selection',
                    text: 'Please select at least one memorandum/title to display subjects.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#F59E0B'
                 });
                 return;
             }

            // Save selected memorandums as confirmed (locked for next time)
            confirmedMemorandums.clear();
            selectedMemorandums.forEach(memo => confirmedMemorandums.add(memo));

            // FILTER LOGIC UPDATE:
            // selectedMemorandums now contains "Group Titles" (e.g., "ARTS...") or "Category Names" (e.g., "Shape Paper") 
            // or "Raw Memorandums" (CHED).
            // We need to match subjects to these keys.

            const filteredSubjects = allSystemSubjects.filter(subject => {
                 const sMemo = subject.memorandum || 'No Memorandum';
                 const sCategory = (subject.memorandum_category || '').trim();
                 
                 // 1. Check direct match (CHED or Legacy)
                 if (selectedMemorandums.has(sMemo)) return true;

                 // 2. Check Category match (DepEd Level 1 items)
                 if (selectedMemorandums.has(sCategory)) return true;

                 // 3. Check Group Title match (DepEd Level 2 items)
                 // We need to resolve the subject's memo to its Group Title using the map
                 let groupTitle = complianceLinksMap.get(sMemo);
                 
                 // Fallback parsing if map failed (matching render logic)
                 if (!groupTitle && ['Curriculum Guides (Academic)', 'Curriculum Guides (TechPro)'].includes(sCategory)) {
                     let displayName = sMemo;
                     if (displayName.includes('•')) displayName = displayName.split('•').pop().trim();
                     const parenIndex = displayName.indexOf('(');
                     if (parenIndex > 0) displayName = displayName.substring(0, parenIndex).trim();
                     groupTitle = displayName;
                 }

                 if (groupTitle && selectedMemorandums.has(groupTitle)) return true;

                 return false;
            });

            // Update the sidebar view
            renderAvailableSubjects(filteredSubjects, currentMappedSubjects);
            
            // Close the modal
            hideAddSubjectsModal();
            
            // Show confirmation toast
            Swal.fire({
                title: 'Filtered!',
                text: `Showing ${filteredSubjects.length} subject(s) from selection.`,
                icon: 'success',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        };

        const backToMemorandums = () => {
             document.getElementById('subjectListView').classList.add('hidden');
             document.getElementById('memorandumListView').classList.remove('hidden');
             
             document.getElementById('addSubjectsModalTitle').textContent = 'Select Memorandum';
             document.getElementById('addSubjectsModalSubtitle').textContent = 'Choose a memorandum to view associated subjects';
             
             // Show search bar and clear it
             const searchInput = document.getElementById('modalSubjectSearch');
             searchInput.classList.remove('hidden');
             searchInput.value = '';
             searchInput.placeholder = 'Search memorandums...';
        };

        document.getElementById('backToMemorandumsBtn').addEventListener('click', backToMemorandums);
        
        // Function to hide Add Subjects Modal
        const hideAddSubjectsModal = () => {
            addSubjectsModal.classList.add('opacity-0');
            addSubjectsModalPanel.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                addSubjectsModal.classList.add('hidden');
                selectedSubjectsForAdding.clear();
                updateSelectedCount();
            }, 300);
        };
        
        // Function to render subject list in modal
        const renderModalSubjectList = (subjects) => {
            const modalMinorSubjectList = document.getElementById('modalMinorSubjectList');
            const modalMajorSubjectList = document.getElementById('modalMajorSubjectList');
            
            if (!subjects || subjects.length === 0) {
                modalMinorSubjectList.innerHTML = '<p class="text-gray-500 text-center py-8 text-sm">No subjects available</p>';
                modalMajorSubjectList.innerHTML = '<p class="text-gray-500 text-center py-8 text-sm">No subjects available</p>';
                return;
            }
            
            // Get currently available subjects for this curriculum
            const currentlyAvailableSubjectCodes = new Set();
            availableSubjectsContainer.querySelectorAll('.subject-card').forEach(card => {
                const subjectData = JSON.parse(card.dataset.subjectData);
                currentlyAvailableSubjectCodes.add(subjectData.subject_code);
            });
            
            // Separate subjects by type
            const minorSubjects = subjects.filter(s => s.subject_type === 'Minor');
            const majorSubjects = subjects.filter(s => s.subject_type === 'Major');
            
            // Clear both lists
            modalMinorSubjectList.innerHTML = '';
            modalMajorSubjectList.innerHTML = '';
            
            // Function to create subject item
            const createSubjectItem = (subject) => {
                const isAlreadyAvailable = currentlyAvailableSubjectCodes.has(subject.subject_code);
                
                const subjectItem = document.createElement('div');
                subjectItem.className = `p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors ${isAlreadyAvailable ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'}`;
                subjectItem.dataset.subjectCode = subject.subject_code;
                subjectItem.dataset.subjectData = JSON.stringify(subject);
                subjectItem.dataset.subjectUnit = subject.subject_unit; // Store unit for easy access
                
                // Determine subject type color for badge
                let typeColorClass = 'bg-gray-100 text-gray-700';
                if (subject.subject_type === 'Major') typeColorClass = 'bg-blue-100 text-blue-700';
                else if (subject.subject_type === 'Minor') typeColorClass = 'bg-purple-100 text-purple-700';
                else if (subject.subject_type === 'Elective') typeColorClass = 'bg-red-100 text-red-700';
                else if (subject.subject_type.toLowerCase().includes('ge') || subject.subject_type.toLowerCase().includes('general')) typeColorClass = 'bg-orange-100 text-orange-700';
                
                subjectItem.innerHTML = `
                    <div class="flex items-start gap-3">
                        <input type="checkbox" 
                               class="subject-checkbox h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 mt-0.5 flex-shrink-0 ${isAlreadyAvailable ? 'cursor-not-allowed' : 'cursor-pointer'}" 
                               ${isAlreadyAvailable ? 'disabled' : ''}
                               data-subject-code="${subject.subject_code}"
                               data-subject-unit="${subject.subject_unit}">
                        <div class="flex-grow min-w-0">
                            <p class="font-semibold text-gray-800 text-sm truncate">${subject.subject_name}</p>
                            <p class="text-xs text-gray-500 mt-0.5">${subject.subject_code} • ${subject.subject_unit} units</p>
                            ${isAlreadyAvailable ? '<p class="text-xs text-gray-400 mt-1">Already added</p>' : ''}
                        </div>
                        <span class="text-xs font-semibold px-2 py-1 rounded-full ${typeColorClass} flex-shrink-0">${subject.subject_type}</span>
                    </div>
                `;
                
                // Add click handler for the entire item (if not already available)
                if (!isAlreadyAvailable) {
                    subjectItem.addEventListener('click', (e) => {
                        if (e.target.type !== 'checkbox') {
                            const checkbox = subjectItem.querySelector('.subject-checkbox');
                            if (!checkbox.disabled) {
                                checkbox.checked = !checkbox.checked;
                                checkbox.dispatchEvent(new Event('change'));
                            }
                        }
                    });
                }
                
                return subjectItem;
            };
            
            // Populate Minor subjects
            if (minorSubjects.length === 0) {
                modalMinorSubjectList.innerHTML = '<p class="text-gray-500 text-center py-8 text-sm">No minor subjects</p>';
            } else {
                minorSubjects.forEach(subject => {
                    modalMinorSubjectList.appendChild(createSubjectItem(subject));
                });
            }
            
            // Populate Major subjects
            if (majorSubjects.length === 0) {
                modalMajorSubjectList.innerHTML = '<p class="text-gray-500 text-center py-8 text-sm">No major subjects</p>';
            } else {
                majorSubjects.forEach(subject => {
                    modalMajorSubjectList.appendChild(createSubjectItem(subject));
                });
            }
            
            // Add change event listeners to checkboxes
            document.querySelectorAll('.subject-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', (e) => {
                    const subjectCode = e.target.dataset.subjectCode;
                    const subjectUnit = parseFloat(e.target.dataset.subjectUnit) || 0;
                    
                    // Check limits before allowing check
                    if (e.target.checked) {
                        const maxUnits = parseFloat(addSubjectsModal.dataset.maxUnits) || 0;
                        const currentUnits = parseFloat(addSubjectsModal.dataset.currentUnits) || 0;
                        
                        // Calculate units of already selected subjects
                        let selectedUnits = 0;
                        selectedSubjectsForAdding.forEach(code => {
                            const subject = allSystemSubjects.find(s => s.subject_code === code);
                            if (subject) selectedUnits += parseFloat(subject.subject_unit) || 0;
                        });
                        
                        // Check if adding this subject exceeds limit
                        if (currentUnits + selectedUnits + subjectUnit > maxUnits) {
                            e.target.checked = false;
                            Swal.fire({
                                title: 'Unit Limit Reached',
                                text: `Cannot add this subject. Total units would exceed the curriculum limit of ${maxUnits}.`,
                                icon: 'warning',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#F59E0B'
                            });
                            return;
                        }
                        
                        selectedSubjectsForAdding.add(subjectCode);
                    } else {
                        selectedSubjectsForAdding.delete(subjectCode);
                    }
                    updateSelectedCount();
                });
            });
        };
        
        // Function to update selected count and unit display
        const updateSelectedCount = () => {
            selectedSubjectsCount.textContent = selectedSubjectsForAdding.size;
            
            const maxUnits = parseFloat(addSubjectsModal.dataset.maxUnits) || 0;
            const currentUnits = parseFloat(addSubjectsModal.dataset.currentUnits) || 0;
            
            let selectedUnits = 0;
            selectedSubjectsForAdding.forEach(code => {
                const subject = allSystemSubjects.find(s => s.subject_code === code);
                if (subject) selectedUnits += parseFloat(subject.subject_unit) || 0;
            });
            
            const totalUsed = currentUnits + selectedUnits;
            const remaining = Math.max(0, maxUnits - totalUsed);
            
            const unitDisplay = document.getElementById('modalUnitLimitDisplay');
            unitDisplay.textContent = `Units: ${totalUsed} used / ${remaining} remaining (Max: ${maxUnits})`;
            
            if (totalUsed >= maxUnits) {
                unitDisplay.classList.add('text-red-600');
                unitDisplay.classList.remove('text-gray-500');
            } else {
                unitDisplay.classList.remove('text-red-600');
                unitDisplay.classList.add('text-gray-500');
            }
        };
        
        // Function to filter modal subject list
        const filterModalSubjects = (searchTerm) => {
            const term = searchTerm.toLowerCase();
            
            // Check if we're in memorandum view
            const memoListView = document.getElementById('memorandumListView');
            const subjectListView = document.getElementById('subjectListView');
            
            if (memoListView && !memoListView.classList.contains('hidden')) {
                // Filter memorandums
                const memorandumCards = memoListView.querySelectorAll('.p-4.border');
                memorandumCards.forEach(card => {
                    const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
                    const subtitle = card.querySelector('.text-sm')?.textContent.toLowerCase() || '';
                    const matchesSearch = title.includes(term) || subtitle.includes(term);
                    card.style.display = matchesSearch ? 'flex' : 'none';
                });
            } else if (subjectListView && !subjectListView.classList.contains('hidden')) {
                // Filter subjects (existing logic)
                const filterList = (listId) => {
                    const list = document.getElementById(listId);
                    if (!list) return;
                    
                    Array.from(list.children).forEach(item => {
                        // Skip if it's not a subject item (e.g. "No subjects" message)
                        if (!item.dataset.subjectData) return;
                        
                        const subjectData = JSON.parse(item.dataset.subjectData);
                        const matchesSearch = subjectData.subject_name.toLowerCase().includes(term) || 
                                             subjectData.subject_code.toLowerCase().includes(term);
                        item.style.display = matchesSearch ? 'block' : 'none';
                    });
                };
                
                filterList('modalMinorSubjectList');
                filterList('modalMajorSubjectList');
            }
        };
        
        // Event listeners for Add Subjects Modal

        closeAddSubjectsModalBtn.addEventListener('click', hideAddSubjectsModal);
        cancelAddSubjectsBtn.addEventListener('click', hideAddSubjectsModal);
        
        modalSubjectSearch.addEventListener('input', (e) => {
            filterModalSubjects(e.target.value);
        });
        
        confirmAddSubjectsBtn.addEventListener('click', () => {
            // NEW: Check if we are in Memorandum View
            const memoListView = document.getElementById('memorandumListView');
            if (memoListView && !memoListView.classList.contains('hidden')) {
                applyMemorandumFilter();
                return;
            }

            if (selectedSubjectsForAdding.size === 0) {
                Swal.fire({
                    title: 'No Subjects Selected',
                    text: 'Please select at least one subject to add.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#F59E0B'
                });
                return;
            }
            
            const curriculumId = curriculumSelector.value;
            if (!curriculumId) {
                Swal.fire({
                    title: 'Error!',
                    text: 'No curriculum selected.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#EF4444'
                });
                return;
            }
            
            // Get selected subjects data
            const subjectsToAdd = allSystemSubjects.filter(subject => 
                selectedSubjectsForAdding.has(subject.subject_code)
            );
            
            // Send request to add subjects to curriculum
            fetch(`/api/curriculums/${curriculumId}/add-subjects`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    subject_ids: subjectsToAdd.map(s => s.id)
                })
            })
            .then(response => response.json())
            .then(data => {
                hideAddSubjectsModal();
                
                // Manually add the new subjects to the Available Subjects list immediately for Real-time feedback
                if (availableSubjectsContainer) {
                    // Remove "No subjects available" or "Select a curriculum" message if it exists
                    const noSubjectsMsg = availableSubjectsContainer.querySelector('p.text-center');
                    if (noSubjectsMsg) {
                        noSubjectsMsg.remove();
                    }

                    subjectsToAdd.forEach(subject => {
                        // Check if card already exists to prevent duplicates
                        const existingCard = document.getElementById(`subject-${subject.subject_code.toLowerCase()}`);
                        if (!existingCard) {
                            const newCard = createSubjectCard(subject, false); // isMapped = false
                            availableSubjectsContainer.appendChild(newCard);
                            
                            // Add animation for better UX
                            newCard.classList.add('animate__animated', 'animate__fadeIn');
                            
                            // Scroll to the new item (optional, but nice)
                            newCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }
                    });
                }

                Swal.fire({
                    title: 'Success!',
                    text: `${selectedSubjectsForAdding.size} subject(s) added to curriculum successfully!`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#10B981',
                    timer: 3000,
                    timerProgressBar: true
                });
                
                // Refresh the curriculum data to ensure consistency (background)
                fetchCurriculumData(curriculumId);
            })
            .catch(error => {
                console.error('Error adding subjects:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to add subjects. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#EF4444'
                });
            });
        });

        // --- MEMORANDUM DETAILS MODAL FUNCTIONALITY ---
        
        const memorandumDetailsModal = document.getElementById('memorandumDetailsModal');
        const memorandumDetailsPanel = document.getElementById('memorandum-details-panel');
        const closeMemorandumDetailsModal = document.getElementById('closeMemorandumDetailsModal');
        
        const showMemorandumDetailsModal = (memoData) => {
            // Populate memorandum information
            document.getElementById('memoDetailName').textContent = memoData.name;
            document.getElementById('memoDetailYear').textContent = memoData.year || 'N/A';
            document.getElementById('memoDetailCategory').textContent = memoData.category || 'N/A';
            document.getElementById('memoDetailCount').textContent = memoData.subjects.length;
            
            // Populate subjects list
            const subjectsList = document.getElementById('memoDetailSubjectsList');
            subjectsList.innerHTML = '';
            
            if (memoData.subjects.length === 0) {
                subjectsList.innerHTML = '<p class="text-gray-500 text-center py-8 col-span-2">No subjects associated with this memorandum.</p>';
            } else {
                memoData.subjects.forEach(subject => {
                    const subjectCard = document.createElement('div');
                    subjectCard.className = 'p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow bg-white';
                    
                    // Determine subject type color
                    let typeColorClass = 'bg-gray-100 text-gray-700';
                    let borderColorClass = 'border-l-gray-400';
                    if (subject.subject_type === 'Major') {
                        typeColorClass = 'bg-blue-100 text-blue-700';
                        borderColorClass = 'border-l-blue-500';
                    } else if (subject.subject_type === 'Minor') {
                        typeColorClass = 'bg-purple-100 text-purple-700';
                        borderColorClass = 'border-l-purple-500';
                    } else if (subject.subject_type === 'Elective') {
                        typeColorClass = 'bg-red-100 text-red-700';
                        borderColorClass = 'border-l-red-500';
                    } else if (subject.subject_type.toLowerCase().includes('ge') || subject.subject_type.toLowerCase().includes('general')) {
                        typeColorClass = 'bg-orange-100 text-orange-700';
                        borderColorClass = 'border-l-orange-500';
                    }
                    
                    subjectCard.classList.add('border-l-4', borderColorClass);
                    
                    subjectCard.innerHTML = `
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-grow min-w-0">
                                <h4 class="font-semibold text-gray-800 text-sm mb-1 truncate">${subject.subject_name}</h4>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-mono text-gray-600 bg-gray-50 px-2 py-0.5 rounded border border-gray-200">${subject.subject_code}</span>
                                    <span class="text-xs text-gray-500">•</span>
                                    <span class="text-xs font-medium text-gray-600">${subject.subject_unit} units</span>
                                </div>
                            </div>
                            <span class="text-xs font-semibold px-2 py-1 rounded-full ${typeColorClass} flex-shrink-0">${subject.subject_type}</span>
                        </div>
                    `;
                    
                    subjectsList.appendChild(subjectCard);
                });
            }
            
            // Show modal with animation
            memorandumDetailsModal.classList.remove('hidden');
            setTimeout(() => {
                memorandumDetailsModal.classList.remove('opacity-0');
                memorandumDetailsPanel.classList.remove('opacity-0', 'scale-95');
            }, 10);
        };
        
        const hideMemorandumDetailsModal = () => {
            memorandumDetailsModal.classList.add('opacity-0');
            memorandumDetailsPanel.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                memorandumDetailsModal.classList.add('hidden');
            }, 300);
        };
        
        closeMemorandumDetailsModal.addEventListener('click', hideMemorandumDetailsModal);
        
        // Close modal when clicking outside
        memorandumDetailsModal.addEventListener('click', (e) => {
            if (e.target === memorandumDetailsModal) {
                hideMemorandumDetailsModal();
            }
        });

        // Searchable dropdown event listeners
        document.getElementById('curriculumDropdownButton').addEventListener('click', () => {
            const menu = document.getElementById('curriculumDropdownMenu');
            menu.classList.toggle('hidden');
            if (!menu.classList.contains('hidden')) {
                document.getElementById('curriculumSearchInput').focus();
            }
        });

        document.getElementById('curriculumSearchInput').addEventListener('input', (e) => {
            filterCurriculums(e.target.value);
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('curriculumDropdown');
            if (!dropdown.contains(e.target)) {
                document.getElementById('curriculumDropdownMenu').classList.add('hidden');
            }
        });

        // Original curriculum selector change event (for compatibility)
        curriculumSelector.addEventListener('change', (e) => {
            const curriculumId = e.target.value;
            if (curriculumId) {
                fetchCurriculumData(curriculumId);
            } else {
                curriculumOverview.innerHTML = '<p class="text-gray-500 text-center mt-4">Select a curriculum from the dropdown to start mapping subjects.</p>';
                availableSubjectsContainer.innerHTML = '<p class="text-gray-500 text-center mt-4">Select a curriculum to view subjects.</p>';
                document.getElementById('grand-total-container').classList.add('hidden');
            }
        });

        // Load all subjects initially when page loads
        loadAllSubjects();
        fetchCurriculums();
    });
</script>
@endsection