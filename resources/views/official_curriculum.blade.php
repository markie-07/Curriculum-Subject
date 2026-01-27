@extends('layouts.app')

@section('content')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 sm:p-6 md:p-8">
    <div>
        {{-- Main Header --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8">
            <div class="flex items-start gap-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-grow">
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Official Curriculum</h1>
                    <p class="text-sm text-slate-500 mt-1">View and manage approved curriculums and their subject mappings.</p>
                </div>
            </div>
        </div>

        {{-- Curriculums Display Section --}}
        <div class="bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-xl font-bold text-slate-700">Approved Curriculums</h2>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    {{-- Version Filter --}}
                    <div class="relative w-full sm:w-48">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                        </svg>
                        <select id="version-filter" class="w-full appearance-none pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                            <option value="new" selected>New</option>
                            <option value="old">Old</option>
                        </select>
                        <svg class="w-5 h-5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                    </div>
                    {{-- Search Bar --}}
                    <div class="relative w-full sm:w-72">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                        <input type="text" id="search-bar" placeholder="Search..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-10">
                <div>
                    <h3 class="flex items-center gap-3 text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-200">
                        <span>Senior High</span>
                    </h3>
                    <div id="senior-high-curriculums" class="space-y-4 pt-2">
                        <p class="text-slate-500 text-sm py-4">No Senior High curriculums found.</p>
                    </div>
                </div>
                <div>
                    <h3 class="flex items-center gap-3 text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-200">
                        <span>College</span>
                    </h3>
                    <div id="college-curriculums" class="space-y-4 pt-2">
                        <p class="text-slate-500 text-sm py-4">No College curriculums found.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Curriculum Subjects Modal --}}
        <div id="curriculumModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-gray-50 border border-gray-200 w-full max-w-7xl rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col h-[90vh]" id="modal-panel">
                    <div class="p-6 border-b border-gray-200 bg-white rounded-t-2xl">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h2 id="modal-curriculum-title" class="text-2xl font-bold text-slate-800 leading-tight">Subjects</h2>
                                <p id="modal-curriculum-subtitle" class="text-sm text-slate-500 mt-1 font-medium">Curriculum Details</p>
                            </div>
                            <button id="closeCurriculumModal" class="text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-2 hover:bg-slate-100" aria-label="Close modal">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <!-- Curriculum Details Grid -->
                        <div class="relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 bg-slate-50 p-5 rounded-xl border border-slate-200 shadow-inner">
                            <!-- Status Badges (Absolute Positioned for Senior High look) -->
                            <div class="absolute bottom-4 right-4 flex items-center gap-2">
                                <div id="modal-version-badge"></div>
                                <div id="modal-status-badge">
                                    <!-- Dynamic Badge -->
                                </div>
                            </div>
                            <!-- Academic Year -->
                            <div class="flex items-start gap-3" id="modal-academic-year-container">
                                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Academic Year</p>
                                    <p id="modal-academic-year" class="font-semibold text-slate-800 text-sm mt-0.5">N/A</p>
                                </div>
                            </div>
                            
                            <!-- Total Units -->
                            <div class="flex items-start gap-3" id="modal-units-container">
                                <div class="p-2 bg-orange-100 text-orange-600 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Total Units</p>
                                    <p id="modal-total-units" class="font-semibold text-slate-800 text-sm mt-0.5">N/A</p>
                                </div>
                            </div>

                            <!-- Compliance -->
                             <div class="flex items-start gap-3">
                                <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Compliance</p>
                                    <p id="modal-compliance" class="font-semibold text-slate-800 text-sm mt-0.5">N/A</p>
                                </div>
                            </div>

                            <!-- Memorandum -->
                            <div class="flex items-start gap-3 md:col-span-2 lg:col-span-2">
                                <div class="p-2 bg-slate-100 text-slate-600 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Official Memorandum</p>
                                    <p id="modal-memorandum" class="font-semibold text-slate-800 text-sm mt-0.5 truncate" title=""></p>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div id="modal-curriculum-content" class="p-6 space-y-4 flex-1 overflow-y-auto"></div>
                </div>
            </div>
        </div>

        {{-- External Link Confirmation Modal --}}
        <div id="externalLinkModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out" id="external-link-panel">
                    <div class="p-6">
                        {{-- Close Button --}}
                        <button id="closeExternalLinkModal" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        {{-- Icon --}}
                        <div class="flex justify-center mb-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Title --}}
                        <h3 class="text-xl font-bold text-slate-800 text-center mb-2">Open External Link?</h3>

                        {{-- Description --}}
                        <p class="text-sm text-slate-500 text-center mb-1">You are about to open:</p>
                        <p id="external-link-title" class="text-sm font-medium text-slate-700 text-center mb-6 px-4"></p>

                        {{-- Buttons --}}
                        <div class="flex gap-3">
                            <button id="cancelExternalLink" class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-700 font-medium rounded-lg hover:bg-slate-200 transition-colors">
                                Cancel
                            </button>
                            <button id="confirmExternalLink" class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Open Link
                            </button>
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
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Containers
    const seniorHighList = document.getElementById('senior-high-curriculums');
    const collegeList = document.getElementById('college-curriculums');
    const searchBar = document.getElementById('search-bar');
    const versionFilter = document.getElementById('version-filter');
    
    // Modal elements
    const curriculumModal = document.getElementById('curriculumModal');
    const curriculumModalPanel = document.getElementById('modal-panel');
    const closeCurriculumModalBtn = document.getElementById('closeCurriculumModal');
    const modalCurriculumTitle = document.getElementById('modal-curriculum-title');
    const modalCurriculumSubtitle = document.getElementById('modal-curriculum-subtitle');
    const modalAcademicYearContainer = document.getElementById('modal-academic-year-container');
    const modalAcademicYear = document.getElementById('modal-academic-year');
    const modalUnitsContainer = document.getElementById('modal-units-container');
    const modalTotalUnits = document.getElementById('modal-total-units');
    const modalCompliance = document.getElementById('modal-compliance');
    const modalMemorandum = document.getElementById('modal-memorandum');
    const modalStatusBadge = document.getElementById('modal-status-badge');
    const modalVersionBadge = document.getElementById('modal-version-badge');
    const modalCurriculumContent = document.getElementById('modal-curriculum-content');

    // External link modal elements
    const externalLinkModal = document.getElementById('externalLinkModal');
    const externalLinkPanel = document.getElementById('external-link-panel');
    const closeExternalLinkModalBtn = document.getElementById('closeExternalLinkModal');
    const cancelExternalLinkBtn = document.getElementById('cancelExternalLink');
    const confirmExternalLinkBtn = document.getElementById('confirmExternalLink');
    const externalLinkTitle = document.getElementById('external-link-title');
    
    let pendingExternalUrl = '';
    let pendingLinkTitle = '';

    // Modal functions
    const showCurriculumModal = () => {
        curriculumModal.classList.remove('hidden');
        setTimeout(() => {
            curriculumModal.classList.remove('opacity-0');
            curriculumModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };
    
    const hideCurriculumModal = () => {
        curriculumModal.classList.add('opacity-0');
        curriculumModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => curriculumModal.classList.add('hidden'), 300);
    };
    
    // External link modal functions
    const showExternalLinkModal = (url, title) => {
        pendingExternalUrl = url;
        pendingLinkTitle = title;
        externalLinkTitle.textContent = title;
        externalLinkModal.classList.remove('hidden');
        setTimeout(() => {
            externalLinkModal.classList.remove('opacity-0');
            externalLinkPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };
    
    const hideExternalLinkModal = () => {
        externalLinkModal.classList.add('opacity-0');
        externalLinkPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            externalLinkModal.classList.add('hidden');
            pendingExternalUrl = '';
            pendingLinkTitle = '';
        }, 300);
    };
    
    // External link modal event listeners
    closeExternalLinkModalBtn.addEventListener('click', hideExternalLinkModal);
    cancelExternalLinkBtn.addEventListener('click', hideExternalLinkModal);
    confirmExternalLinkBtn.addEventListener('click', () => {
        if (pendingExternalUrl) {
            window.open(pendingExternalUrl, '_blank');
            hideExternalLinkModal();
        }
    });
    externalLinkModal.addEventListener('click', (e) => { 
        if (e.target === externalLinkModal) hideExternalLinkModal(); 
    });

    // Curriculum modal event listeners
    closeCurriculumModalBtn.addEventListener('click', hideCurriculumModal);
    curriculumModal.addEventListener('click', (e) => { if (e.target === curriculumModal) hideCurriculumModal(); });

    // Open curriculum modal and display subjects
    const openCurriculumModal = async (curriculum) => {
        // Populate Header
        modalCurriculumTitle.textContent = curriculum.curriculum_name;
        modalCurriculumSubtitle.textContent = `${curriculum.program_code} • ${curriculum.year_level}`;
        
        if (curriculum.year_level === 'Senior High') {
            modalAcademicYearContainer.classList.add('hidden');
            modalUnitsContainer.classList.add('hidden');
        } else {
            modalAcademicYearContainer.classList.remove('hidden');
            modalUnitsContainer.classList.remove('hidden');
            modalAcademicYear.textContent = curriculum.academic_year || 'N/A';
            modalTotalUnits.textContent = curriculum.total_units ? `${parseFloat(curriculum.total_units)} Units` : 'N/A';
        }
        modalCompliance.textContent = curriculum.compliance || 'N/A';
        
        // Memorandum Logic
        const memoYear = curriculum.memorandum_year || '';
        const memoCat = curriculum.memorandum_category || '';
        const memoText = curriculum.memorandum || 'No memorandum selected';
        let fullMemo = memoText;
        if (memoCat) fullMemo = `${memoCat} • ${fullMemo}`;
        modalMemorandum.textContent = fullMemo;
        modalMemorandum.title = fullMemo;

        // Reset memorandum styling and click handler
        modalMemorandum.style.cursor = 'default';
        modalMemorandum.classList.remove('text-blue-600', 'hover:text-blue-700', 'hover:underline');
        modalMemorandum.classList.add('text-slate-800');
        modalMemorandum.onclick = null;

        // Try to find the memorandum link and make text clickable
        if (memoText && memoText !== 'No memorandum selected') {
            const agency = curriculum.compliance || '';
            const yearLevel = curriculum.year_level || '';

            // Check if DepEd and Senior High - use hardcoded link
            if (agency === 'DepEd' && yearLevel === 'Senior High') {
                const targetUrl = 'https://www.deped.gov.ph/strengthened-shs-program/?fbclid=IwY2xjawPhXw5leHRuA2FlbQIxMABicmlkETFHd005bEc2WlFJcmxCUkVPc3J0YwZhcHBfaWQQMjIyMDM5MTc4ODIwMDg5MgABHhPBJeQ9dNzzNKzEAvIBsBisdygkFJpgn8fD39MUNOUCBovsp8fErU2UWclH_aem_LEMh6cQ-GyZcw22XknCH7w';
                
                modalMemorandum.classList.remove('text-slate-800');
                modalMemorandum.classList.add('text-blue-600', 'hover:text-blue-700', 'hover:underline');
                modalMemorandum.style.cursor = 'pointer';
                modalMemorandum.onclick = () => {
                    showExternalLinkModal(targetUrl, 'The Strengthened Senior High School Program');
                };
                console.log('✅ DepEd Senior High memorandum set to hardcoded URL');
            } else {
                // Existing logic for other types
                try {
                    console.log('Searching for memorandum link:', { agency, memoText, memoCat });
                    
                    // Fetch all links for the agency
                    const response = await fetch(`/api/compliance-links?agency=${agency}&is_category=false`);
                    const links = await response.json();
                    
                    console.log('Available links:', links);
                    
                    // Helper function to normalize text for comparison
                    const normalizeText = (text) => {
                        return text
                            .toLowerCase()
                            .replace(/[()•\-_,]/g, ' ')  // Remove special characters
                            .replace(/\s+/g, ' ')         // Normalize spaces
                            .trim();
                    };
                    
                    // Helper function to extract significant words (3+ characters)
                    const getSignificantWords = (text) => {
                        const normalized = normalizeText(text);
                        return normalized.split(' ').filter(w => w.length >= 3);
                    };
                    
                    // Extract the subject name from memorandum
                    let subjectName = memoText;
                    if (memoText.includes('•')) {
                        subjectName = memoText.split('•').pop().trim();
                    }
                    
                    console.log('Subject name extracted:', subjectName);
                    
                    // Get significant words from the subject name
                    const subjectWords = getSignificantWords(subjectName);
                    console.log('Search terms:', subjectWords);
                    
                    // Find the best matching link
                    let bestMatch = null;
                    let bestScore = 0;
                    
                    links.forEach(link => {
                        if (!link.title && !link.url) return;
                        
                        const linkTitle = link.title || '';
                        const linkUrl = link.url || '';
                        
                        // Get words from link title and URL
                        const titleWords = getSignificantWords(linkTitle);
                        const urlWords = getSignificantWords(linkUrl);
                        const allLinkWords = [...titleWords, ...urlWords];
                        
                        // Calculate match score (how many subject words appear in link)
                        const matchCount = subjectWords.filter(word => 
                            allLinkWords.some(linkWord => 
                                linkWord.includes(word) || word.includes(linkWord)
                            )
                        ).length;
                        
                        const score = matchCount / subjectWords.length;
                        
                        console.log(`Link "${linkTitle}" score: ${score} (${matchCount}/${subjectWords.length} words matched)`);
                        
                        // Keep track of best match (need at least 50% match)
                        if (score > bestScore && score >= 0.5) {
                            bestScore = score;
                            bestMatch = link;
                        }
                    });
                    
                    console.log('Best matching link:', bestMatch, 'Score:', bestScore);
                    
                    if (bestMatch && bestMatch.url) {
                        // Make the memorandum text clickable and blue
                        modalMemorandum.classList.remove('text-slate-800');
                        modalMemorandum.classList.add('text-blue-600', 'hover:text-blue-700', 'hover:underline');
                        modalMemorandum.style.cursor = 'pointer';
                        modalMemorandum.onclick = () => {
                            showExternalLinkModal(bestMatch.url, bestMatch.title || subjectName);
                        };
                        console.log('✅ Memorandum text is now clickable for URL:', bestMatch.url);
                    } else {
                        console.log('❌ No matching link found (best score:', bestScore, ')');
                    }
                } catch (error) {
                    console.error('Error fetching memorandum link:', error);
                }
            }
        }

        // Expiration Date Logic (replaces Status Badge)
        let statusHtml = '';
        if (curriculum.expiration_date) {
            statusHtml = `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                <svg class="w-3 h-3 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                End Date: ${new Date(curriculum.expiration_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
            </span>`;
        }
        modalStatusBadge.innerHTML = statusHtml;

        // Version Badge Logic
        if (modalVersionBadge) {
            const versionStatus = curriculum.version_status || 'new';
            // Check if expired
            const isExpired = curriculum.expiration_date && new Date(curriculum.expiration_date).setHours(0,0,0,0) <= new Date().setHours(0,0,0,0);
            
            let versionHtml = '';
            if (versionStatus === 'old') {
                versionHtml = `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border-amber-200 border">
                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                    </svg>
                    Old
                </span>`;
            } else {
                versionHtml = `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    New
                </span>`;
            }
            modalVersionBadge.innerHTML = versionHtml;
        }

        modalCurriculumContent.innerHTML = '<p class="text-gray-500 text-center">Loading subjects...</p>';
        showCurriculumModal();
        
        try {
            const response = await fetch(`/api/curriculums/${curriculum.id}`);
            const data = await response.json();
            
            if (data.curriculum && data.curriculum.subjects) {
                renderCurriculumSubjects(data.curriculum);
            } else {
                modalCurriculumContent.innerHTML = '<p class="text-gray-500 text-center">No subjects found for this curriculum.</p>';
            }
        } catch (error) {
            console.error('Failed to fetch curriculum subjects:', error);
            modalCurriculumContent.innerHTML = '<p class="text-red-500 text-center">Could not load curriculum subjects.</p>';
        }
    };

    // Render curriculum subjects in modal
    const renderCurriculumSubjects = (curriculum) => {
        const yearLevel = curriculum.year_level;
        const maxYear = yearLevel === 'Senior High' ? 2 : 4;
        let html = '';

        for (let year = 1; year <= maxYear; year++) {
            const yearSuffix = (year === 1) ? 'st' : (year === 2 ? 'nd' : (year === 3 ? 'rd' : 'th'));
            html += `<div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">${year}${yearSuffix} Year</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">`;

            for (let semester = 1; semester <= 2; semester++) {
                const subjects = curriculum.subjects.filter(s => s.pivot.year == year && s.pivot.semester == semester);
                
                let semesterTitle = semester === 1 ? 'First Semester' : 'Second Semester';
                if (yearLevel === 'Senior High') {
                    if (year === 1) {
                        semesterTitle = semester === 1 ? 'First Quarter' : 'Second Quarter';
                    } else if (year === 2) {
                        semesterTitle = semester === 1 ? 'Third Quarter' : 'Fourth Quarter';
                    }
                }

                let totalUnits = 0;
                subjects.forEach(s => totalUnits += parseFloat(s.subject_unit || 0));

                html += `<div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4 shadow-md">
                    <div class="border-b border-gray-300 pb-2 mb-3 flex justify-between items-center">
                        <h4 class="font-semibold text-gray-700">${semesterTitle}</h4>
                        ${yearLevel === 'Senior High' ? '' : `<div class="text-sm font-bold text-gray-700">Units: ${totalUnits}</div>`}
                    </div>
                    <div class="space-y-2 min-h-[50px]">`;

                if (subjects.length > 0) {
                    subjects.forEach(subject => {
                        // Define styles based on subject type
                        let assignedClass = 'border-gray-400';
                        let iconBgClass = 'bg-gray-500';
                        let iconSvgClass = 'text-white';
                        let subjectNameClass = 'text-gray-800';
                        let textColorClass = 'text-gray-500';
                        let unitsColorClass = 'text-gray-600';
                        let dotColorClass = 'text-gray-400';
                        let typeBadgeClass = 'text-gray-500 bg-gray-50 border-gray-100';

                        const subjectType = subject.subject_type || 'General';

                        if (subjectType === 'Major') {
                            assignedClass = 'border-blue-500';
                            iconBgClass = 'bg-blue-500';
                            iconSvgClass = 'text-white';
                            subjectNameClass = 'text-blue-700';
                            textColorClass = 'text-blue-600 font-bold';
                            unitsColorClass = 'text-blue-600 font-bold';
                            dotColorClass = 'text-blue-400';
                            typeBadgeClass = 'text-white bg-blue-500 border-blue-500';
                        } else if (subjectType === 'Minor') {
                            assignedClass = 'border-purple-500';
                            iconBgClass = 'bg-purple-500';
                            iconSvgClass = 'text-white';
                            subjectNameClass = 'text-purple-700';
                            textColorClass = 'text-purple-600 font-bold';
                            unitsColorClass = 'text-purple-600 font-bold';
                            dotColorClass = 'text-purple-400';
                            typeBadgeClass = 'text-white bg-purple-500 border-purple-500';
                        } else if (subjectType === 'Elective') {
                            assignedClass = 'border-red-500';
                            iconBgClass = 'bg-red-500';
                            iconSvgClass = 'text-white';
                            subjectNameClass = 'text-red-700';
                            textColorClass = 'text-red-600 font-bold';
                            unitsColorClass = 'text-red-600 font-bold';
                            dotColorClass = 'text-red-400';
                            typeBadgeClass = 'text-white bg-red-500 border-red-500';
                        } else {
                            // General Education / Default
                            assignedClass = 'border-orange-500';
                            iconBgClass = 'bg-orange-500';
                            iconSvgClass = 'text-white';
                            subjectNameClass = 'text-orange-700';
                            textColorClass = 'text-orange-600 font-bold';
                            unitsColorClass = 'text-orange-600 font-bold';
                            dotColorClass = 'text-orange-400';
                            typeBadgeClass = 'text-white bg-orange-500 border-orange-500';
                        }

                        html += `<div class="subject-card bg-white border-2 ${assignedClass} p-3 rounded-xl shadow-sm flex items-center gap-3 mb-2 cursor-pointer hover:shadow-lg transition-all" data-subject-id="${subject.id}">
                            <div class="flex-shrink-0 w-12 h-12 ${iconBgClass} rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 ${iconSvgClass}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="flex-grow min-w-0">
                                <div class="flex items-center justify-between mb-0.5">
                                    <p class="subject-name font-bold ${subjectNameClass} text-base truncate pr-2">${subject.subject_name}</p>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="subject-code font-mono ${textColorClass} bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100">${subject.subject_code}</span>
                                    <span class="separator-dot ${dotColorClass}">•</span>
                                    <span class="subject-units font-medium ${unitsColorClass}">${subject.subject_unit} Units</span>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 pl-2">
                                <span class="subject-type-badge text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded border ${typeBadgeClass}">${subjectType}</span>
                            </div>
                        </div>`;
                    });
                } else {
                    html += '<p class="text-xs text-center text-gray-400 pt-4">No subjects mapped.</p>';
                }

                html += `</div></div>`;
            }

            html += `</div></div>`;
        }

        modalCurriculumContent.innerHTML = html;
        
        // Add click event listeners to subject cards
        const subjectCards = modalCurriculumContent.querySelectorAll('.subject-card');
        subjectCards.forEach(card => {
            card.addEventListener('click', async () => {
                const subjectId = card.dataset.subjectId;
                if (!subjectId) return;
                
                try {
                    const response = await fetch(`/api/subjects/${subjectId}`);
                    const subjectData = await response.json();
                    showDetailsModal(subjectData);
                } catch (error) {
                    console.error('Error fetching subject details:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to load subject details.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#EF4444'
                    });
                }
            });
        });
    };

    // Card creation function
            const createCurriculumCard = (curriculum) => {
                const card = document.createElement('div');
                
                // Determine card border, icon, and title colors based on approval status
                const approvalStatus = curriculum.approval_status || 'processing';
                
                // Check if expired (compare dates ignoring time)
                const isExpired = curriculum.expiration_date && new Date(curriculum.expiration_date).setHours(0,0,0,0) <= new Date().setHours(0,0,0,0);
                
                // Determine effective version (explicitly set to old, OR expired)
                const effectiveVersion = (curriculum.version_status === 'old' || isExpired) ? 'old' : 'new';

                let cardBorderClass = 'border-slate-200 hover:border-blue-500';
                let iconBgClass = 'bg-slate-100 group-hover:bg-blue-100';
                let iconColorClass = 'text-slate-500 group-hover:text-blue-600';
                let titleColorClass = 'text-slate-800 group-hover:text-blue-600';
                
                if (approvalStatus === 'approved') {
                    cardBorderClass = 'border-green-400 hover:border-green-500';
                    iconBgClass = 'bg-green-100 group-hover:bg-green-200';
                    iconColorClass = 'text-green-600 group-hover:text-green-700';
                    titleColorClass = 'text-green-700 group-hover:text-green-800';
                } else if (approvalStatus === 'rejected') {
                    cardBorderClass = 'border-red-400 hover:border-red-500';
                    iconBgClass = 'bg-red-100 group-hover:bg-red-200';
                    iconColorClass = 'text-red-600 group-hover:text-red-700';
                    titleColorClass = 'text-red-700 group-hover:text-red-800';
                } else {
                     // Processing or other status
                }
                
                // Add cursor-pointer since it opens a modal
                card.className = `curriculum-card group relative bg-white p-4 rounded-xl border ${cardBorderClass} flex items-center gap-4 hover:shadow-lg transition-all duration-300 cursor-pointer`;
                card.dataset.name = curriculum.curriculum_name.toLowerCase();
                card.dataset.code = curriculum.program_code.toLowerCase();
                card.dataset.id = curriculum.id;
                card.dataset.version = effectiveVersion;
                card.dataset.approvalStatus = approvalStatus;

                const date = new Date(curriculum.created_at);
                const formattedDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                const formattedTime = date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

                // Helper function to truncate long memorandum text
                const truncateText = (text, maxLength = 60) => {
                    if (!text) return 'Not specified';
                    return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                };

                // Format compliance badge
                const complianceBadge = curriculum.compliance 
                    ? `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${curriculum.compliance === 'CHED' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'}">
                        ${curriculum.compliance}
                    </span>`
                    : '';

                // Format total units display (remove .0 from whole numbers)
                const formatUnits = (units) => {
                    if (!units) return '';
                    const num = parseFloat(units);
                    return num % 1 === 0 ? Math.floor(num) : num;
                };

                // Only show total units badge for College curriculums
                const totalUnitsDisplay = (curriculum.total_units && curriculum.year_level === 'College')
                    ? `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                        ${formatUnits(curriculum.total_units)} units
                    </span>`
                    : '';

                // Version status badge (Used effectiveVersion)
                const versionBadge = effectiveVersion === 'old'
                    ? `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                        </svg>
                        Old
                    </span>`
                    : `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        New
                    </span>`;

                // Approval status badge
                let approvalBadge = '';
                if (approvalStatus === 'approved') {
                    approvalBadge = `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        Approved
                    </span>`;
                } else if (approvalStatus === 'rejected') {
                    approvalBadge = `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                        Rejected
                    </span>`;
                } else {
                    approvalBadge = `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                        </svg>
                        Processing
                    </span>`;
                }

                // Format memorandum year/category display
                const memorandumYearCategory = curriculum.memorandum_year 
                    ? curriculum.memorandum_year
                    : curriculum.memorandum_category 
                        ? curriculum.memorandum_category 
                        : '';

                card.innerHTML = `
                    <div class="flex-shrink-0 w-10 h-10 ${iconBgClass} rounded-lg flex items-center justify-center transition-colors duration-300">
                        <svg class="w-5 h-5 ${iconColorClass} transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="flex-grow min-w-0">
                        <div class="flex flex-col-reverse sm:flex-row items-start justify-between gap-2">
                            <div class="flex-grow min-w-0 w-full sm:pr-2">
                                <h3 class="font-bold ${titleColorClass} transition-colors duration-300 truncate mb-1">${curriculum.curriculum_name}</h3>
                                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                                    <span>${curriculum.program_code}${curriculum.year_level === 'Senior High' ? '' : ` • ${curriculum.academic_year}`}</span>
                                    ${curriculum.expiration_date ? `
                                        <span class="flex items-center gap-1 text-xs text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            End Date: ${new Date(curriculum.expiration_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                                        </span>
                                    ` : ''}
                                </div>
                                ${curriculum.memorandum ? `
                                <p class="text-xs text-slate-400 truncate" title="${curriculum.memorandum}">
                                    ${memorandumYearCategory ? `${memorandumYearCategory} ` : ''}• ${truncateText(curriculum.memorandum, 45)}
                                </p>
                                ` : memorandumYearCategory ? `
                                <p class="text-xs text-slate-400">
                                    ${memorandumYearCategory} • No memorandum selected
                                </p>
                                ` : ''}
                                <p class="text-xs text-slate-400 mt-1">
                                    Created: ${formattedDate} at ${formattedTime} • 
                                    <span class="font-medium">${curriculum.subjects_count} subject${curriculum.subjects_count !== 1 ? 's' : ''}</span>
                                </p>
                            </div>
                            <div class="flex flex-col items-end sm:items-end gap-1 w-full sm:w-auto flex-shrink-0">
                                <div class="flex items-center gap-1 flex-nowrap justify-end">
                                    ${complianceBadge}
                                    ${totalUnitsDisplay}
                                    ${versionBadge}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Add click event listener to open modal
                card.addEventListener('click', () => openCurriculumModal(curriculum));
                
                return card;
            };

    // Fetch and display curriculums
    const fetchAndDisplayCurriculums = async () => {
        try {
            const response = await fetch('/api/curriculums');
            const curriculums = await response.json();
            
            // Filter only approved curriculums
            const approvedCurriculums = curriculums.filter(c => c.approval_status === 'approved');
            
            let seniorHighCount = 0;
            let collegeCount = 0;
            seniorHighList.innerHTML = '';
            collegeList.innerHTML = '';
            
            approvedCurriculums.forEach(c => {
                const card = createCurriculumCard(c);
                if (c.year_level === 'Senior High') {
                    seniorHighList.appendChild(card);
                    seniorHighCount++;
                } else if (c.year_level === 'College') {
                    collegeList.appendChild(card);
                    collegeCount++;
                }
            });
            
            if (seniorHighCount === 0) seniorHighList.innerHTML = '<p class="text-slate-500 text-sm py-4">No approved Senior High curriculums found.</p>';
            if (collegeCount === 0) collegeList.innerHTML = '<p class="text-slate-500 text-sm py-4">No approved College curriculums found.</p>';
            
            // Apply initial filter
            filterCurriculums();
        } catch (error) {
            console.error('Failed to fetch curriculums:', error);
            seniorHighList.innerHTML = '<p class="text-red-500">Failed to load curriculums.</p>';
            collegeList.innerHTML = '<p class="text-red-500">Failed to load curriculums.</p>';
        }
    };

    // Filter curriculums
    const filterCurriculums = () => {
        const searchTerm = searchBar.value.toLowerCase();
        const versionValue = versionFilter.value;
        const cards = document.querySelectorAll('.curriculum-card');
        
        cards.forEach(card => {
            const name = card.dataset.name;
            const code = card.dataset.code;
            const version = card.dataset.version;
            
            const matchesSearch = name.includes(searchTerm) || code.includes(searchTerm);
            const matchesVersion = version === versionValue;
            
            if (matchesSearch && matchesVersion) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    };

    // Event listeners
    searchBar.addEventListener('input', filterCurriculums);
    versionFilter.addEventListener('change', filterCurriculums);

    // --- SUBJECT DETAIL MODAL FUNCTIONS ---
    
    // Helper to set text content with fallback
    const setText = (id, value) => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = (value === null || value === undefined || value === '') ? 'N/A' : value;
        }
    };

    // Create mapping grid HTML
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

    // Populate DepEd Modal
    const populateDepEdModal = (data) => {
        console.log('DepEd Modal Data:', data);
        setText('depedCourseTitle', data.subject_name);
        setText('depedSubjectCode', data.subject_code);
        setText('depedSubjectType', data.subject_type);
        setText('depedMemorandumCategory', data.memorandum_category);
        setText('depedTitle', data.memorandum);
        setText('depedMemorandum', data.memorandum);
        
        // Handle Syllabus Preview
        const syllabusSection = document.getElementById('depedSyllabusSection');
        const pdfFrame = document.getElementById('depedPdfFrame');
        const imagePreview = document.getElementById('depedImagePreview');
        const noPreview = document.getElementById('depedNoPreview');
        const fileNameDisplay = document.getElementById('depedSyllabusFileName');
        
        if (syllabusSection) {
             syllabusSection.classList.remove('hidden');
             
             // Reset views
             if(pdfFrame) { pdfFrame.classList.add('hidden'); pdfFrame.src = ''; }
             if(imagePreview) { imagePreview.classList.add('hidden'); imagePreview.src = ''; }
             if(noPreview) noPreview.classList.add('hidden');

             if (data.syllabus_path) {
                 let path = data.syllabus_path;
                 
                 // Clean up the path
                 path = path.replace(/^\/storage\//, '').replace(/^storage\//, '');
                 
                 // Construct URLs
                 const baseUrl = window.location.origin;
                 const viewUrl = `${baseUrl}/view-syllabus/${path}`;
                 const downloadUrl = `${baseUrl}/storage/${path}`;
                 
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
                        pdfFrame.src = viewUrl + '#toolbar=0&navpanes=0&scrollbar=0';
                        pdfFrame.classList.remove('hidden');
                    }
                 } else if (['jpg', 'jpeg', 'png'].includes(ext)) {
                     if (imagePreview) {
                         imagePreview.src = viewUrl;
                         imagePreview.classList.remove('hidden');
                     }
                 } else {
                     if(noPreview) {
                         noPreview.textContent = 'Preview not available for this file type.';
                         noPreview.classList.remove('hidden');
                     }
                 }
             } else {
                 if (fileNameDisplay) fileNameDisplay.classList.add('hidden');
                 if (noPreview) {
                     noPreview.textContent = 'No syllabus document uploaded.';
                     noPreview.classList.remove('hidden');
                 }
             }
        }

        const createdAtDate = new Date(data.created_at);
        setText('depedDetailsCreatedAt', createdAtDate.toLocaleString('en-US', {
            year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
        }));

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

        const modal = document.getElementById('chedSubjectDetailsModal');
        const panel = document.getElementById('ched-modal-details-panel');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            panel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const showDetailsModal = (data) => {
        if (data.syllabus_type === 'DepEd') {
            populateDepEdModal(data);
        } else {
            populateChedModal(data);
        }
    };

    // Modal close functions
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

    // Modal event listeners
    const closeChedBtn = document.getElementById('closeChedDetailsModal');
    if(closeChedBtn) closeChedBtn.addEventListener('click', hideChedModal);
    const chedModal = document.getElementById('chedSubjectDetailsModal');
    if(chedModal) chedModal.addEventListener('click', (e) => { if (e.target.id === 'chedSubjectDetailsModal') hideChedModal(); });

    const closeDepEdBtn = document.getElementById('closeDepedDetailsModal');
    if(closeDepEdBtn) closeDepEdBtn.addEventListener('click', hideDepEdModal);
    const depedModal = document.getElementById('depedSubjectDetailsModal');
    if(depedModal) depedModal.addEventListener('click', (e) => { if (e.target.id === 'depedSubjectDetailsModal') hideDepEdModal(); });

    // Initial load
    fetchAndDisplayCurriculums();
});
</script>
@endsection
