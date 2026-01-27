@extends('layouts.app')

@section('content')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 sm:p-6 md:p-8">
    <div>
        {{-- Main Header --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8">
             <div class="flex items-start gap-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-grow">
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Subject Mapping History</h1>
                    <p class="text-sm text-slate-500 mt-1">Review previously mapped subject for any curriculum.</p>
                </div>
            </div>
        </div>

        {{-- Curriculums Display Section --}}
        <div class="bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-xl font-bold text-slate-700">Mapped Curriculums</h2>
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
                    {{-- Status Filter --}}
                    <div class="relative w-full sm:w-48">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        <select id="status-filter" class="w-full appearance-none pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                            <option value="all" selected>All Status</option>
                            <option value="processing">Processing</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
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

        {{-- Curriculum History Modal --}}
        <div id="subjectsModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-gray-50 border border-gray-200 w-full max-w-7xl rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col h-[90vh]" id="modal-panel-subjects">
                    <div class="p-6 border-b border-gray-200 bg-white rounded-t-2xl">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h2 id="modal-curriculum-title" class="text-2xl font-bold text-slate-800 leading-tight">Subjects</h2>
                                <p id="modal-curriculum-subtitle" class="text-sm text-slate-500 mt-1 font-medium">Curriculum Details</p>
                            </div>
                            <button id="closeSubjectsModal" class="text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-2 hover:bg-slate-100" aria-label="Close modal">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <!-- Curriculum Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 bg-slate-50 p-5 rounded-xl border border-slate-200 shadow-inner">
                            <!-- Academic Year -->
                            <div class="flex items-start gap-3">
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
                            <div class="flex items-start gap-3">
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
                                    <p id="modal-memorandum" class="font-semibold text-slate-800 text-sm mt-0.5 truncate" title="">N/A</p>
                                </div>
                            </div>

                            <!-- Status & Version -->
                            <div class="flex items-center justify-start lg:justify-end gap-2">
                                 <div id="modal-version-badge">
                                    <!-- Dynamic Version Badge -->
                                 </div>
                                 <div id="modal-status-badge">
                                    <!-- Dynamic Status Badge -->
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div id="modal-subjects-content" class="p-6 space-y-4 flex-1 overflow-y-auto"></div>
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
                        <div id="depedSyllabusSection" class="mb-10">
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

        {{-- [MODAL 3] Version History Modal --}}
        <div id="versionHistoryModal" class="fixed inset-0 z-[70] overflow-y-auto bg-black bg-opacity-60 transition-opacity duration-300 ease-out hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white w-full max-w-4xl max-h-[90vh] rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col" id="modal-panel-versions">
                    <div class="flex justify-between items-center p-6 border-b border-gray-200 sticky top-0 bg-white z-10 rounded-t-2xl">
                        <div>
                            <h2 id="versionHistoryTitle" class="text-2xl font-bold text-gray-800">Version History</h2>
                            <p id="versionHistorySubtitle" class="text-sm text-gray-500 mt-1"></p>
                        </div>
                        <button id="closeVersionHistoryModal" class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200" aria-label="Close modal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div id="version-history-content" class="p-6 flex-1 overflow-y-auto">
                        <div id="version-loading" class="flex items-center justify-center py-12">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                            <span class="ml-3 text-gray-600">Loading versions...</span>
                        </div>
                        <div id="version-list" class="space-y-4 hidden"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- [MODAL 4] Version Details Modal --}}
        <div id="versionDetailsModal" class="fixed inset-0 z-[80] overflow-y-auto bg-black bg-opacity-60 transition-opacity duration-300 ease-out hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white w-full max-w-6xl max-h-[90vh] rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col" id="modal-panel-version-details">
                    <div class="flex justify-between items-center p-6 border-b border-gray-200 sticky top-0 bg-white z-10 rounded-t-2xl">
                        <div>
                            <h2 id="versionDetailsTitle" class="text-2xl font-bold text-gray-800">Version Details</h2>
                            <p id="versionDetailsSubtitle" class="text-sm text-gray-500 mt-1"></p>
                        </div>
                        <button id="closeVersionDetailsModal" class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200" aria-label="Close modal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div id="version-details-content" class="p-6 flex-1 overflow-y-auto">
                        <div id="version-details-loading" class="flex items-center justify-center py-12">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                            <span class="ml-3 text-gray-600">Loading version details...</span>
                        </div>
                        <div id="version-details-data" class="hidden"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- External Link Confirmation Modal --}}
        <div id="externalLinkModal" class="fixed inset-0 z-[90] overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
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
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Containers
    const seniorHighList = document.getElementById('senior-high-curriculums');
    const collegeList = document.getElementById('college-curriculums');
    const searchBar = document.getElementById('search-bar');
    const versionFilter = document.getElementById('version-filter');
    const statusFilter = document.getElementById('status-filter');
    
    // Modal 1 (Curriculum Overview)
    const subjectsModal = document.getElementById('subjectsModal');
    const subjectsModalPanel = document.getElementById('modal-panel-subjects');
    const closeSubjectsModalBtn = document.getElementById('closeSubjectsModal');
    const modalCurriculumTitle = document.getElementById('modal-curriculum-title');
    const modalCurriculumSubtitle = document.getElementById('modal-curriculum-subtitle');
    const modalAcademicYear = document.getElementById('modal-academic-year');
    const modalTotalUnits = document.getElementById('modal-total-units');
    const modalCompliance = document.getElementById('modal-compliance');
    const modalMemorandum = document.getElementById('modal-memorandum');
    const modalStatusBadge = document.getElementById('modal-status-badge');
    const modalVersionBadge = document.getElementById('modal-version-badge');
    const modalSubjectsContent = document.getElementById('modal-subjects-content');

    // --- Modal 2 (Subject Details) ---
    // CHED Modal Elements
    const chedModal = document.getElementById('chedSubjectDetailsModal');
    const chedModalPanel = document.getElementById('ched-modal-details-panel');
    const closeChedModalBtn = document.getElementById('closeChedDetailsModal');
    
    // DepEd Modal Elements
    const depedModal = document.getElementById('depedSubjectDetailsModal');
    const depedModalPanel = document.getElementById('deped-modal-details-panel');
    const closeDepedModalBtn = document.getElementById('closeDepedDetailsModal');

    // External link modal elements
    const externalLinkModal = document.getElementById('externalLinkModal');
    const externalLinkPanel = document.getElementById('external-link-panel');
    const closeExternalLinkModalBtn = document.getElementById('closeExternalLinkModal');
    const cancelExternalLinkBtn = document.getElementById('cancelExternalLink');
    const confirmExternalLinkBtn = document.getElementById('confirmExternalLink');
    const externalLinkTitle = document.getElementById('external-link-title');
    
    let pendingExternalUrl = '';
    let pendingLinkTitle = '';

    // --- Modal 1 Functions ---
    const showSubjectsModal = () => {
        subjectsModal.classList.remove('hidden');
        setTimeout(() => {
            subjectsModal.classList.remove('opacity-0');
            subjectsModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };
    const hideSubjectsModal = () => {
        subjectsModal.classList.add('opacity-0');
        subjectsModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => subjectsModal.classList.add('hidden'), 300);
    };
    closeSubjectsModalBtn.addEventListener('click', hideSubjectsModal);
    subjectsModal.addEventListener('click', (e) => { if (e.target === subjectsModal) hideSubjectsModal(); });

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

    // --- Modal 2 Functions ---
    // Close Logic for CHED Modal
    const hideChedModal = () => {
        chedModal.classList.add('opacity-0');
        chedModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => chedModal.classList.add('hidden'), 300);
    };
    if (closeChedModalBtn) closeChedModalBtn.addEventListener('click', hideChedModal);
    chedModal.addEventListener('click', (e) => { if (e.target === chedModal) hideChedModal(); });

    // Close Logic for DepEd Modal
    const hideDepEdModal = () => {
        depedModal.classList.add('opacity-0');
        depedModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => depedModal.classList.add('hidden'), 300);
    };
    if (closeDepedModalBtn) closeDepedModalBtn.addEventListener('click', hideDepEdModal);
    depedModal.addEventListener('click', (e) => { if (e.target === depedModal) hideDepEdModal(); });

    const showSubjectDetailsModal = async (subject) => {
        try {
            // Fetch live data
            const response = await fetch(`/api/subjects/${subject.id}`);
            if (!response.ok) throw new Error('Failed to fetch subject data');
            const data = await response.json();
            
            const liveType = (data.syllabus_type || 'CHED').toUpperCase();
            
            if (liveType === 'DEPED') {
                 populateDepEdModal(data); 
            } else {
                 populateChedModal(data); 
            }
        } catch (error) {
            console.error('Error fetching live data:', error);
            
            // Fallback to historical data
            // Infer type from available fields if syllabus_type is missing in snapshot
            let isDepEd = false;
            if (subject.memorandum_category || (subject.syllabus_type && subject.syllabus_type.toUpperCase() === 'DEPED')) {
                isDepEd = true;
            }
            
            if (isDepEd) {
                populateDepEdModal(subject, true);
            } else {
                populateChedModal(subject, true);
            }
        }
    };

    // Export button event listener moved to the second script block where modal functions are defined

    // --- Card Creation Functions ---
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
        }
        
        card.className = `curriculum-history-card group relative bg-white p-4 rounded-xl border ${cardBorderClass} flex items-center gap-4 hover:shadow-lg transition-all duration-300 cursor-pointer`;
        card.dataset.id = curriculum.id;
        card.dataset.name = curriculum.curriculum_name.toLowerCase();
        card.dataset.code = curriculum.program_code.toLowerCase();
        card.dataset.yearLevel = curriculum.year_level;
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

        const totalUnitsDisplay = curriculum.total_units 
            ? `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                ${formatUnits(curriculum.total_units)} units
            </span>`
            : '';

        // Version status badge - Only show if approved
        let versionBadge = '';
        if (approvalStatus === 'approved') {
            versionBadge = effectiveVersion === 'old'
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
        }

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
                            <span>${curriculum.program_code} • ${curriculum.academic_year}</span>
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
                            <span class="font-medium">${curriculum.subjects_count || 0} subject${curriculum.subjects_count !== 1 ? 's' : ''}</span>
                        </p>
                    </div>
                    <div class="flex flex-col items-end sm:items-end gap-1 w-full sm:w-auto">
                        <div class="flex items-center gap-1 flex-wrap justify-end">
                            ${complianceBadge}
                            ${totalUnitsDisplay}
                            ${versionBadge}
                            ${approvalBadge}
                        </div>
                    </div>
                </div>
            </div>
            `;
            
        // Add version history button (hidden but functional if needed)
        const versionButton = document.createElement('button');
        versionButton.className = 'hidden'; // Keeping it hidden as per design, or remove if not needed
        
        card.addEventListener('click', async () => {
            // Populate Modal Header Details
            modalCurriculumTitle.textContent = curriculum.curriculum_name;
            if (modalCurriculumSubtitle) modalCurriculumSubtitle.textContent = `${curriculum.program_code} • ${curriculum.year_level}`;
            
            if (modalAcademicYear) modalAcademicYear.textContent = curriculum.academic_year || 'N/A';
            if (modalTotalUnits) modalTotalUnits.textContent = curriculum.total_units ? `${parseFloat(curriculum.total_units)} Units` : 'N/A';
            if (modalCompliance) modalCompliance.textContent = curriculum.compliance || 'N/A';
            
            
            // Memorandum Logic
            if (modalMemorandum) {
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
                    (async () => {
                        try {
                            const agency = curriculum.compliance || '';
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
                    })();
                }
            }

            // Status Badge Logic
            if (modalStatusBadge) {
                let statusHtml = '';
                if (approvalStatus === 'approved') {
                    statusHtml = `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200"><svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>Approved</span>`;
                } else if (approvalStatus === 'rejected') {
                    statusHtml = `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200"><svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" /></svg>Rejected</span>`;
                } else {
                    statusHtml = `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200"><svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" /></svg>Processing</span>`;
                }
                modalStatusBadge.innerHTML = statusHtml;
            }

            // Version Badge Logic
            if (modalVersionBadge) {
                if (approvalStatus === 'approved') {
                    const versionStatus = curriculum.version_status || 'new';
                    let versionHtml = '';
                    if (versionStatus === 'old') {
                        versionHtml = `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200"><svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" /></svg>Old</span>`;
                    } else {
                        versionHtml = `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200"><svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>New</span>`;
                    }
                    modalVersionBadge.innerHTML = versionHtml;
                } else {
                    modalVersionBadge.innerHTML = ''; // Hide version badge for non-approved curriculums
                }
            }

            modalSubjectsContent.innerHTML = '<p class="text-gray-500 text-center">Loading history...</p>';
            showSubjectsModal();
            try {
                const response = await fetch(`/api/curriculum-history/${curriculum.id}/versions`);
                const data = await response.json();
                
                console.log('Version history response:', data); // Debug log
                
                if (data.success && data.versions && data.versions.length > 0) {
                     renderVersionHistoryInModal(data.versions, curriculum.year_level);
                } else {
                    // No version history found, show current curriculum state instead
                    console.log('No version history found, fetching current curriculum state');
                    const curriculumResponse = await fetch(`/api/curriculums/${curriculum.id}`);
                    const curriculumData = await curriculumResponse.json();
                    
                    if (curriculumData.curriculum && curriculumData.curriculum.subjects) {
                        // Create a pseudo-version from current state
                        const createdDate = new Date(curriculum.created_at || new Date());
                        const formattedCreatedAt = createdDate.toLocaleDateString('en-US', { 
                            year: 'numeric', 
                            month: 'short', 
                            day: 'numeric' 
                        }) + ' at ' + createdDate.toLocaleTimeString('en-US', { 
                            hour: '2-digit', 
                            minute: '2-digit', 
                            hour12: true 
                        });
                        
                        const currentVersion = {
                            id: 'current',
                            version_number: 1,
                            change_description: 'Current curriculum state',
                            changed_by: 'System',
                            created_at: formattedCreatedAt,
                            snapshot_data: {
                                subjects: curriculumData.curriculum.subjects.map(s => ({
                                    id: s.id,
                                    subject_name: s.subject_name,
                                    subject_code: s.subject_code,
                                    subject_type: s.subject_type,
                                    subject_unit: s.subject_unit,
                                    pivot: s.pivot
                                }))
                            },
                            is_current: true
                        };
                        renderVersionHistoryInModal([currentVersion], curriculum.year_level);
                    } else {
                        modalSubjectsContent.innerHTML = '<p class="text-gray-500 text-center">No subjects mapped to this curriculum yet.</p>';
                    }
                }
            } catch (error) {
                console.error('Failed to fetch version history:', error);
                modalSubjectsContent.innerHTML = '<p class="text-red-500 text-center">Could not load version history. Error: ' + error.message + '</p>';
            }
        });
        return card;
    };
    

    
    const createSubjectTagForModal = (subject) => {
        const tag = document.createElement('div');
        const isRemoved = subject._isRemoved;
        
        // Define styles based on subject type (matching subject_mapping.blade.php)
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

        // Overrides for removed subjects
        if (isRemoved) {
            assignedClass = 'border-red-300 bg-red-50';
            iconBgClass = 'bg-red-200';
            iconSvgClass = 'text-red-500';
            subjectNameClass = 'text-red-800 line-through';
            textColorClass = 'text-red-600';
            unitsColorClass = 'text-red-600';
            dotColorClass = 'text-red-400';
            typeBadgeClass = 'text-red-600 bg-red-100 border-red-200';
        }

        tag.className = `subject-card bg-white border-2 ${assignedClass} p-3 rounded-xl shadow-sm flex items-center gap-3 mb-2 ${isRemoved ? 'opacity-75' : 'cursor-pointer hover:shadow-md transition-shadow'}`;
        
        const removedBadge = isRemoved ? `<span class="text-[10px] font-bold text-red-600 bg-red-100 px-2 py-0.5 rounded border border-red-200 ml-2">REMOVED</span>` : '';

        tag.innerHTML = `
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
                ${removedBadge}
            </div>
        `;
            
        if (!isRemoved) {
            tag.addEventListener('dblclick', () => {
                showSubjectDetailsModal(subject);
            });
        }
        return tag;
    };

    // --- Helper Functions ---
    const setText = (id, value) => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = (value === null || value === undefined || value === '') ? 'N/A' : value;
        }
    };

    const createMappingGridHtml = (gridData, mainHeader) => {
        if (!gridData || !Array.isArray(gridData) || gridData.length === 0) {
            return '<p class="text-xs text-gray-500">No mapping grid data available.</p>';
        }

        const headers = [mainHeader, 'CTPSS', 'ECC', 'EPP', 'GLC'];
        
        // Note: Tailwind classes should match
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

    // --- Populate Functions ---
    const populateDepEdModal = (data, isHistorical = false) => {
        console.log('Populating DepEd Modal', data);
        setText('depedSubjectName', `${data.subject_name} (${data.subject_code})`);
        
        // Course Info
        setText('depedCourseTitle', data.subject_name);
        setText('depedSubjectCode', data.subject_code);
        setText('depedSubjectType', data.subject_type);
        setText('depedMemorandumCategory', data.memorandum_category);
        setText('depedTitle', data.title || data.subject_name); 
        setText('depedMemorandum', data.memorandum);
        setText('depedTimeAllotment', data.time_allotment);
        setText('depedSchedule', data.schedule);
        const descEl = document.getElementById('depedCourseDescription');
        if(descEl) descEl.innerHTML = data.course_description || 'N/A';

        // Syllabus Document Logic
        const syllabusSection = document.getElementById('depedSyllabusSection');
        if (syllabusSection) {
             const fileNameEl = document.getElementById('depedSyllabusFileName');
             const pdfFrame = document.getElementById('depedPdfFrame');
             const imgPreview = document.getElementById('depedImagePreview');
             const noPreview = document.getElementById('depedNoPreview');
             
             // Reset UI
             if (fileNameEl) fileNameEl.textContent = '';
             if (pdfFrame) pdfFrame.classList.add('hidden');
             if (imgPreview) imgPreview.classList.add('hidden');
             if (noPreview) noPreview.classList.remove('hidden');

             // Handle syllabus data
             // Assuming 'syllabus' or 'syllabus_path' holds the filename/path
             const syllabusPath = data.syllabus_path || data.syllabus || ''; 
             
             if (syllabusPath) {
                 if (fileNameEl) fileNameEl.textContent = syllabusPath.split('/').pop();
                 
                 // Construct URL - path already includes /storage/ prefix from database
                 const fileUrl = syllabusPath.startsWith('http') ? syllabusPath : 
                                syllabusPath.startsWith('/storage/') ? syllabusPath : 
                                `/storage/${syllabusPath}`;
                 
                 const lowerPath = syllabusPath.toLowerCase();
                 const isPdf = lowerPath.endsWith('.pdf');
                 const isImage = lowerPath.endsWith('.jpg') || lowerPath.endsWith('.jpeg') || lowerPath.endsWith('.png') || lowerPath.endsWith('.webp');

                 if (isPdf && pdfFrame) {
                     pdfFrame.src = fileUrl;
                     pdfFrame.classList.remove('hidden');
                     if (noPreview) noPreview.classList.add('hidden');
                 } else if (isImage && imgPreview) {
                     imgPreview.src = fileUrl;
                     imgPreview.classList.remove('hidden');
                     if (noPreview) noPreview.classList.add('hidden');
                 } else {
                     // File exists but not previewable here (e.g. docx)
                     if (fileNameEl) fileNameEl.textContent += ' (Preview not available)';
                 }
             } else {
                 if (fileNameEl) fileNameEl.textContent = 'No syllabus document available.';
             }
        }
        
        // Created Date
        const createdAtDate = new Date(data.created_at || new Date());
        setText('depedDetailsCreatedAt', createdAtDate.toLocaleString('en-US', {
            year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
        }));

        // Historical Indicator Logic
        const content = document.querySelector('#deped-modal-details-panel .p-8');
        if(content) {
            const existing = content.querySelector('.historical-indicator');
            if(existing) existing.remove();

            if (isHistorical) {
                 const indicator = document.createElement('div');
                 indicator.className = 'bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6 historical-indicator';
                 indicator.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="text-sm font-medium text-yellow-800">Showing Historical Data</span>
                        <span class="text-xs text-yellow-600 ml-2">(This data may be outdated - current updates not reflected)</span>
                    </div>
                `;
                 content.insertBefore(indicator, content.firstChild);
            }
        }

        // Show Modal
        depedModal.classList.remove('hidden');
        setTimeout(() => {
            depedModal.classList.remove('opacity-0');
            depedModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };



    const populateChedModal = (data, isHistorical = false) => {
        console.log('Populating CHED Modal', data);
        
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
        const descEl = document.getElementById('chedCourseDescription');
        if(descEl) descEl.innerHTML = data.course_description || 'N/A';

        // Learning Outcomes
        const pilo = document.getElementById('chedPILO'); if(pilo) pilo.innerHTML = data.pilo_outcomes || 'N/A';
        const cilo = document.getElementById('chedCILO'); if(cilo) cilo.innerHTML = data.cilo_outcomes || 'N/A';
        const lo = document.getElementById('chedLearningOutcomes'); if(lo) lo.innerHTML = data.learning_outcomes || 'N/A';

        // Requirements
        const basic = document.getElementById('chedBasicReadings'); if(basic) basic.innerHTML = data.basic_readings || 'N/A';
        const extended = document.getElementById('chedExtendedReadings'); if(extended) extended.innerHTML = data.extended_readings || 'N/A';
        const assess = document.getElementById('chedCourseAssessment'); if(assess) assess.innerHTML = data.course_assessment || 'N/A';

        // Committee
        const comm = document.getElementById('chedCommitteeMembers'); if(comm) comm.innerHTML = data.committee_members || 'N/A';
        const consult = document.getElementById('chedConsultationSchedule'); if(consult) consult.innerHTML = data.consultation_schedule || 'N/A';
        setText('chedPreparedBy', data.prepared_by);
        setText('chedReviewedBy', data.reviewed_by);
        setText('chedApprovedBy', data.approved_by);

        // Created Date
        const createdAtDate = new Date(data.created_at || new Date());
        setText('chedDetailsCreatedAt', createdAtDate.toLocaleString('en-US', {
            year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
        }));

        // Mapping Grids
        const progGrid = document.getElementById('chedProgramMapping');
        const courseGrid = document.getElementById('chedCourseMapping');
        if(progGrid) progGrid.innerHTML = createMappingGridHtml(data.program_mapping_grid, 'PILO');
        if(courseGrid) courseGrid.innerHTML = createMappingGridHtml(data.course_mapping_grid, 'CILO');

        // Weekly Plan
        const lessonsContainer = document.getElementById('chedLessonsContainer');
        if (lessonsContainer) {
            lessonsContainer.innerHTML = '';
            if (data.lessons && typeof data.lessons === 'object' && Object.keys(data.lessons).length > 0) {
                 Object.keys(data.lessons).sort((a, b) => {
                    const wa = parseInt(a.replace(/\D/g, '')) || 0;
                    const wb = parseInt(b.replace(/\D/g, '')) || 0;
                    return wa - wb;
                }).forEach(week => {
                    const lessonString = data.lessons[week];
                    const lessonData = {};
                    const parts = (typeof lessonString === 'string') ? lessonString.split(',, ') : [];
                    parts.forEach(part => {
                            if (part.startsWith('Detailed Lesson Content:')) lessonData.content = part.replace('Detailed Lesson Content:\\n', '').replace('Detailed Lesson Content:', '');
                            if (part.startsWith('Student Intended Learning Outcomes:')) lessonData.silo = part.replace('Student Intended Learning Outcomes:\\n', '').replace('Student Intended Learning Outcomes:', '');
                            if (part.startsWith('Assessment:')) { const match = part.match(/ONSITE: (.*) OFFSITE: (.*)/s); if(match){ lessonData.at_onsite = match[1]; lessonData.at_offsite = match[2]; } else { lessonData.at_onsite = part.replace('Assessment:', ''); } }
                            if (part.startsWith('Activities:')) { const match = part.match(/ON-SITE: (.*) OFF-SITE: (.*)/s); if(match){ lessonData.tla_onsite = match[1]; lessonData.tla_offsite = match[2]; } else { lessonData.tla_onsite = part.replace('Activities:', ''); } }
                            if (part.startsWith('Learning and Teaching Support Materials:')) lessonData.ltsm = part.replace('Learning and Teaching Support Materials:\\n', '').replace('Learning and Teaching Support Materials:', '');
                            if (part.startsWith('Output Materials:')) lessonData.output = part.replace('Output Materials:\\n', '').replace('Output Materials:', '');
                    });
                     
                    const weekHTML = `<div class="border border-gray-200 rounded-lg overflow-hidden mb-2">
                        <button type="button" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 transition-colors week-toggle">
                            <span class="font-semibold text-gray-700">${week}</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="p-5 border-t border-gray-200 bg-white hidden week-content space-y-4">
                             <div class="grid grid-cols-1 gap-4">
                                <div><label class="font-bold text-xs text-gray-500">Content</label><div class="text-sm p-2 bg-gray-50 rounded">${lessonData.lesson_content || lessonData.content || 'N/A'}</div></div>
                                <div><label class="font-bold text-xs text-gray-500">SILO</label><div class="text-sm p-2 bg-gray-50 rounded">${lessonData.silo || 'N/A'}</div></div>
                             </div>
                        </div>
                    </div>`; 
                    lessonsContainer.innerHTML += weekHTML;
                });
                 lessonsContainer.querySelectorAll('.week-toggle').forEach(btn => {
                     btn.addEventListener('click', () => {
                         btn.nextElementSibling.classList.toggle('hidden');
                         btn.querySelector('svg').classList.toggle('rotate-180');
                     });
                 });
            } else {
                 lessonsContainer.innerHTML = '<p class="text-gray-500 italic p-4">No weekly plan data.</p>';
            }
        }

        // Historical Indicator Logic
        const content = document.querySelector('#ched-modal-details-panel .p-8');
        if(content) {
            const existing = content.querySelector('.historical-indicator');
            if(existing) existing.remove();

            if (isHistorical) {
                 const indicator = document.createElement('div');
                 indicator.className = 'bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6 historical-indicator';
                 indicator.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="text-sm font-medium text-yellow-800">Showing Historical Data</span>
                        <span class="text-xs text-yellow-600 ml-2">(This data may be outdated - current updates not reflected)</span>
                    </div>
                `;
                 content.insertBefore(indicator, content.firstChild);
            }
        }

        const exportBtn = document.getElementById('exportChedPdfButton');
        if (exportBtn) exportBtn.dataset.subjectData = JSON.stringify(data);

        // Show Modal
        chedModal.classList.remove('hidden');
         setTimeout(() => {
            chedModal.classList.remove('opacity-0');
            chedModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const renderVersionHistoryInModal = (versions, yearLevel) => {
        modalSubjectsContent.innerHTML = '';

        versions.forEach((version, index) => {
            const historyEntry = document.createElement('div');
            historyEntry.className = 'border border-gray-200 rounded-lg overflow-hidden';

            // Use the already formatted date from the API, or format the raw date if available
            const formattedDate = version.created_at || 'Unknown date';

            const isCurrent = index === 0;
            const statusText = isCurrent ? 'In Use' : 'Previous';
            const statusBgColor = isCurrent ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';

            const button = document.createElement('button');
            button.className = 'w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 transition-colors';
            
            // Show change description if available
            const changeDescription = version.change_description || '';
            const isRemovalVersion = changeDescription.includes('removed from curriculum');
            const isRetrievalVersion = changeDescription.includes('retrieved from history');
            const isAdditionVersion = changeDescription.includes('added to curriculum') && !isRetrievalVersion;
            
            let changeIcon = '';
            if (isRemovalVersion) {
                changeIcon = `
                    <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                `;
            } else if (isRetrievalVersion) {
                changeIcon = `
                    <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                `;
            } else if (isAdditionVersion) {
                changeIcon = `
                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                `;
            }

            button.innerHTML = `
                <div class="flex flex-col items-start">
                    <span class="font-semibold text-gray-800">Version from: ${formattedDate}</span>
                    ${changeDescription ? `<span class="text-xs text-gray-600 mt-1 flex items-center">${changeIcon}${changeDescription}</span>` : ''}
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs font-bold px-2 py-1 rounded-full ${statusBgColor}">${statusText}</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            `;

            const content = document.createElement('div');
            content.className = 'accordion-content p-4 border-t border-gray-200 bg-white space-y-4';
            if (!isCurrent) {
                content.classList.add('hidden');
            } else {
                 button.querySelector('svg').classList.add('rotate-180');
            }

            // Get the snapshot data (already parsed as object)
            const snapshotData = version.snapshot_data;
            const subjects = snapshotData.subjects || [];
            const removedSubject = snapshotData.removed_subject;
            
            // If there's a removed subject, add it to the subjects list with a special flag
            if (removedSubject) {
                subjects.push({
                    ...removedSubject,
                    _isRemoved: true // Special flag to mark as removed
                });
            }
            
            const maxYear = yearLevel === 'Senior High' ? 2 : 4;
            for (let i = 1; i <= maxYear; i++) {
                const yearSuffix = (i === 1) ? 'st' : (i === 2 ? 'nd' : (i === 3 ? 'rd' : 'th'));
                const yearSection = document.createElement('div');
                yearSection.innerHTML = `<h4 class="text-md font-semibold text-gray-600 my-2">${i}${yearSuffix} Year</h4><div class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>`;
                const semesterGrid = yearSection.querySelector('.grid');

                for (let j = 1; j <= 2; j++) {
                    // Handle both pivot structure and direct year/semester properties
                    const semesterSubjects = subjects.filter(s => {
                        const year = s.pivot ? s.pivot.year : s.year;
                        const semester = s.pivot ? s.pivot.semester : s.semester;
                        return year == i && semester == j;
                    });
                    const semesterBox = document.createElement('div');
                    semesterBox.className = 'bg-gray-50 border-2 border-solid border-gray-200 rounded-lg p-4 shadow-md';
                    
                    let semesterTitle = j === 1 ? 'First Semester' : 'Second Semester';
                    if (yearLevel === 'Senior High') {
                         if (i === 1) {
                            semesterTitle = j === 1 ? 'First Quarter' : 'Second Quarter';
                        } else if (i === 2) {
                            semesterTitle = j === 1 ? 'Third Quarter' : 'Fourth Quarter';
                        }
                    }

                    let totalUnits = 0;
                    semesterSubjects.forEach(s => {
                        // Don't count removed subjects in the total units
                        if (!s._isRemoved) {
                            totalUnits += parseInt(s.subject_unit || s.units || 0, 10);
                        }
                    });
                    
                    semesterBox.innerHTML = `<div class="border-b border-gray-300 pb-2 mb-3 flex justify-between items-center"><h5 class="font-semibold text-gray-700">${semesterTitle}</h5><div class="text-sm font-bold text-gray-700">Units: ${totalUnits}</div></div><div class="space-y-2 min-h-[50px]"></div>`;

                    const subjectContainer = semesterBox.querySelector('.space-y-2');
                    if (semesterSubjects.length > 0) {
                        semesterSubjects.forEach(subject => {
                            subjectContainer.appendChild(createSubjectTagForModal(subject));
                        });
                    } else {
                        subjectContainer.innerHTML = '<p class="text-xs text-center text-gray-400 pt-4">No subjects mapped.</p>';
                    }
                    semesterGrid.appendChild(semesterBox);
                }
                content.appendChild(yearSection);
            }

            button.addEventListener('click', () => {
                content.classList.toggle('hidden');
                button.querySelector('svg').classList.toggle('rotate-180');
            });

            historyEntry.appendChild(button);
            historyEntry.appendChild(content);
            modalSubjectsContent.appendChild(historyEntry);
        });
    };

    const fetchAndDisplayCurriculums = async () => {
        try {
            const response = await fetch('/api/curriculums');
            const curriculums = await response.json();
            let seniorHighCount = 0;
            let collegeCount = 0;
            seniorHighList.innerHTML = '';
            collegeList.innerHTML = '';
            curriculums.forEach(c => {
                const card = createCurriculumCard(c);
                if (c.year_level === 'Senior High') {
                    seniorHighList.appendChild(card);
                    seniorHighCount++;
                } else if (c.year_level === 'College') {
                    collegeList.appendChild(card);
                    collegeCount++;
                }
            });
            if (seniorHighCount === 0) seniorHighList.innerHTML = '<p class="text-slate-500 text-sm py-4">No Senior High curriculums found.</p>';
            if (collegeCount === 0) collegeList.innerHTML = '<p class="text-slate-500 text-sm py-4">No College curriculums found.</p>';
            
            // Apply initial filter
            filterCurriculums();
        } catch (error) {
            console.error('Failed to fetch curriculums:', error);
            seniorHighList.innerHTML = '<p class="text-red-500">Failed to load curriculums.</p>';
            collegeList.innerHTML = '<p class="text-red-500">Failed to load curriculums.</p>';
        }
    };
    
    fetchAndDisplayCurriculums();

    // Filter Logic
    function filterCurriculums() {
        const searchTerm = searchBar.value.toLowerCase();
        const versionStatus = versionFilter.value;
        const statusValue = statusFilter.value;
        
        document.querySelectorAll('.curriculum-history-card').forEach(card => {
            const name = card.dataset.name;
            const code = card.dataset.code;
            const version = card.dataset.version;
            const approvalStatus = card.dataset.approvalStatus;
            
            const matchesSearch = name.includes(searchTerm) || code.includes(searchTerm);
            const matchesVersion = version === versionStatus;
            const matchesStatus = statusValue === 'all' || approvalStatus === statusValue;
            
            card.style.display = (matchesSearch && matchesVersion && matchesStatus) ? 'flex' : 'none';
        });
    }

    searchBar.addEventListener('input', filterCurriculums);
    versionFilter.addEventListener('change', () => {
        const isOld = versionFilter.value === 'old';
        
        if (isOld) {
            statusFilter.value = 'approved';
        }
        
        Array.from(statusFilter.options).forEach(option => {
            if (isOld) {
                // Hide everything except 'approved'
                if (option.value !== 'approved') {
                    option.hidden = true;
                    option.style.display = 'none'; // Fallback for some browsers
                } else {
                    option.hidden = false;
                    option.style.display = '';
                }
            } else {
                // Show all
                option.hidden = false;
                option.style.display = '';
            }
        });

        filterCurriculums();
    });
    statusFilter.addEventListener('change', filterCurriculums);
});
</script>

{{-- Export Confirmation Modal --}}
<div id="exportConfirmationModal" class="fixed inset-0 z-[60] overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out" id="export-modal-panel">
            <button id="closeExportModalButton" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100" aria-label="Close modal">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="text-center mb-8">
                <img src="{{ asset('/images/SMSIII LOGO.png') }}" alt="SMS3 Logo" class="mx-auto h-16 w-auto mb-4">
                <h2 class="text-2xl font-bold text-slate-800">Export Subject to PDF</h2>
                <p class="text-sm text-slate-500 mt-1">Generate a comprehensive PDF document with subject details.</p>
            </div>

            <div class="bg-slate-50 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-slate-700 mb-2">Export Details:</h3>
                <div id="export-subject-summary" class="text-sm text-slate-600">
                    <!-- Summary will be populated by JavaScript -->
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" id="cancelExportButton" class="flex-1 px-6 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-all">Cancel</button>
                <button type="button" id="confirmExportButton" class="flex-1 px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span>Export PDF</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Success Modal --}}
<div id="successModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
    <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center transform scale-95 opacity-0 transition-all duration-300 ease-out" id="success-modal-panel">
        <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 id="success-modal-title" class="text-lg font-semibold text-slate-800"></h3>
        <p id="success-modal-message" class="text-sm text-slate-500 mt-2"></p>
        <div class="mt-6">
            <button id="closeSuccessModalButton" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-all">OK</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Modal elements
    const exportButton = document.getElementById('exportSubjectDetailsButton');
    const exportModal = document.getElementById('exportConfirmationModal');
    const exportModalPanel = document.getElementById('export-modal-panel');
    const closeExportModalButton = document.getElementById('closeExportModalButton');
    const cancelExportButton = document.getElementById('cancelExportButton');
    const confirmExportButton = document.getElementById('confirmExportButton');
    const exportSubjectSummary = document.getElementById('export-subject-summary');
    
    // Success modal elements
    const successModal = document.getElementById('successModal');
    const successModalPanel = document.getElementById('success-modal-panel');
    const successModalTitle = document.getElementById('success-modal-title');
    const successModalMessage = document.getElementById('success-modal-message');
    const closeSuccessModalButton = document.getElementById('closeSuccessModalButton');

    let currentSubjectData = null;

    // Modal helper functions
    const showExportModal = (subjectData) => {
        currentSubjectData = subjectData;
        
        // Populate summary
        exportSubjectSummary.innerHTML = `
            <p><strong>Subject:</strong> ${subjectData?.subject_name || 'Selected Subject'}</p>
            <p><strong>Code:</strong> ${subjectData?.subject_code || 'N/A'}</p>
            <p><strong>Format:</strong> PDF Document</p>
            <p><strong>Content:</strong> Complete subject details and lesson plans</p>
        `;
        
        exportModal.classList.remove('hidden');
        setTimeout(() => {
            exportModal.classList.remove('opacity-0');
            exportModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const hideExportModal = () => {
        exportModal.classList.add('opacity-0');
        exportModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => exportModal.classList.add('hidden'), 300);
    };

    const showSuccessModal = (title, message) => {
        successModalTitle.textContent = title;
        successModalMessage.textContent = message;
        successModal.classList.remove('hidden');
        setTimeout(() => {
            successModal.classList.remove('opacity-0');
            successModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const hideSuccessModal = () => {
        successModal.classList.add('opacity-0');
        successModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => successModal.classList.add('hidden'), 300);
    };

    // Event listeners
    if (exportButton) {
        exportButton.addEventListener('click', function() {
            const subjectData = JSON.parse(this.dataset.subjectData || '{}');
            showExportModal(subjectData);
        });
    }
    
    // Also handle the export button from the subject details modal
    const exportSubjectDetailsButton = document.getElementById('exportSubjectDetailsButton');
    if (exportSubjectDetailsButton) {
        exportSubjectDetailsButton.addEventListener('click', function() {
            const subjectDataString = this.dataset.subjectData;
            if (subjectDataString) {
                const subject = JSON.parse(subjectDataString);
                showExportModal(subject);
            }
        });
    }

    // Modal close event listeners
    closeExportModalButton.addEventListener('click', hideExportModal);
    cancelExportButton.addEventListener('click', hideExportModal);
    closeSuccessModalButton.addEventListener('click', hideSuccessModal);

    // Confirm export
    confirmExportButton.addEventListener('click', async function() {
        try {
            if (currentSubjectData) {
                // Trigger the actual PDF export
                window.open(`/subjects/${currentSubjectData.id}/export-pdf`, '_blank');
                hideExportModal();
                showSuccessModal('Export Started!', 'Your PDF export is being generated and will download shortly.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while exporting the subject.');
        }
    });

    // Close modals when clicking outside
    exportModal.addEventListener('click', function(e) {
        if (e.target === this) hideExportModal();
    });

    successModal.addEventListener('click', function(e) {
        if (e.target === this) hideSuccessModal();
    });

    // --- Version History Modal Functions ---
    const versionHistoryModal = document.getElementById('versionHistoryModal');
    const versionHistoryModalPanel = document.getElementById('modal-panel-versions');
    const closeVersionHistoryModalBtn = document.getElementById('closeVersionHistoryModal');
    const versionHistoryTitle = document.getElementById('versionHistoryTitle');
    const versionHistorySubtitle = document.getElementById('versionHistorySubtitle');
    const versionHistoryContent = document.getElementById('version-history-content');
    const versionLoading = document.getElementById('version-loading');
    const versionList = document.getElementById('version-list');

    const versionDetailsModal = document.getElementById('versionDetailsModal');
    const versionDetailsModalPanel = document.getElementById('modal-panel-version-details');
    const closeVersionDetailsModalBtn = document.getElementById('closeVersionDetailsModal');
    const versionDetailsTitle = document.getElementById('versionDetailsTitle');
    const versionDetailsSubtitle = document.getElementById('versionDetailsSubtitle');
    const versionDetailsContent = document.getElementById('version-details-content');
    const versionDetailsLoading = document.getElementById('version-details-loading');
    const versionDetailsData = document.getElementById('version-details-data');

    const showVersionHistory = async (curriculumId, curriculumName) => {
        versionHistoryTitle.textContent = 'Version History';
        versionHistorySubtitle.textContent = curriculumName;
        versionLoading.classList.remove('hidden');
        versionList.classList.add('hidden');
        versionList.innerHTML = '';
        
        versionHistoryModal.classList.remove('hidden');
        setTimeout(() => {
            versionHistoryModal.classList.remove('opacity-0');
            versionHistoryModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);

        try {
            const response = await fetch(`/api/curriculum-history/${curriculumId}/versions`);
            const data = await response.json();
            
            if (data.success && data.versions.length > 0) {
                renderVersionList(data.versions, curriculumId);
            } else {
                versionList.innerHTML = `
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No version history</h3>
                        <p class="mt-1 text-sm text-gray-500">This curriculum doesn't have any saved versions yet.</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Failed to load version history:', error);
            versionList.innerHTML = `
                <div class="text-center py-12">
                    <div class="text-red-500">
                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Error loading versions</h3>
                        <p class="mt-1 text-sm text-gray-500">Could not load version history. Please try again.</p>
                    </div>
                </div>
            `;
        } finally {
            versionLoading.classList.add('hidden');
            versionList.classList.remove('hidden');
        }
    };

    const renderVersionList = (versions, curriculumId) => {
        versionList.innerHTML = versions.map((version, index) => `
            <div class="version-item bg-white border border-gray-200 rounded-lg transition-all duration-200 ${version.is_current ? 'ring-2 ring-green-200 bg-green-50' : ''}" 
                 data-version-id="${version.id}" data-curriculum-id="${curriculumId}">
                
                <!-- Version Header -->
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-blue-600">v${version.version_number}</span>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Version from: ${version.created_at}</h3>
                                <p class="text-xs text-gray-500">${version.change_description}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            ${version.is_current ? '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">In Use</span>' : '<span class="text-xs text-gray-500 cursor-pointer hover:text-blue-600">Previous</span>'}
                            <button class="text-blue-600 hover:text-blue-800 text-sm" onclick="toggleVersionDetails(${version.id})">
                                <svg class="w-4 h-4 transform transition-transform version-chevron-${version.id}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Curriculum Layout (Initially Hidden) -->
                <div id="version-details-${version.id}" class="version-details hidden">
                    <div class="p-4">
                        <div class="curriculum-layout space-y-6">
                            ${renderCurriculumLayout(version.snapshot_data)}
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    };

    const renderCurriculumLayout = (snapshotData) => {
        if (!snapshotData || !snapshotData.subjects) {
            return '<p class="text-gray-500 text-sm">No subjects data available</p>';
        }

        const subjects = snapshotData.subjects;
        const yearGroups = {};

        // Group subjects by year
        subjects.forEach(subject => {
            const year = subject.year || 1;
            if (!yearGroups[year]) {
                yearGroups[year] = { 1: [], 2: [] };
            }
            const semester = subject.semester || 1;
            yearGroups[year][semester].push(subject);
        });

        let layoutHTML = '';
        
        // Render each year
        Object.keys(yearGroups).sort().forEach(year => {
            const yearData = yearGroups[year];
            const sem1Subjects = yearData[1] || [];
            const sem2Subjects = yearData[2] || [];
            const sem1Units = sem1Subjects.reduce((sum, s) => sum + (s.subject_unit || 0), 0);
            const sem2Units = sem2Subjects.reduce((sum, s) => sum + (s.subject_unit || 0), 0);

            layoutHTML += `
                <div class="year-section">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">${getOrdinal(year)} Year</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- First Semester -->
                        <div class="semester-section">
                            <div class="flex justify-between items-center mb-2">
                                <h5 class="text-xs font-medium text-gray-600">First Semester</h5>
                                <span class="text-xs text-gray-500">Units: ${sem1Units}</span>
                            </div>
                            <div class="semester-subjects space-y-2 min-h-[60px] bg-blue-50 p-3 rounded-lg border border-blue-200">
                                ${sem1Subjects.map(subject => renderSubjectCard(subject)).join('')}
                                ${sem1Subjects.length === 0 ? '<p class="text-xs text-gray-400 italic">No subjects</p>' : ''}
                            </div>
                        </div>
                        
                        <!-- Second Semester -->
                        <div class="semester-section">
                            <div class="flex justify-between items-center mb-2">
                                <h5 class="text-xs font-medium text-gray-600">Second Semester</h5>
                                <span class="text-xs text-gray-500">Units: ${sem2Units}</span>
                            </div>
                            <div class="semester-subjects space-y-2 min-h-[60px] bg-purple-50 p-3 rounded-lg border border-purple-200">
                                ${sem2Subjects.map(subject => renderSubjectCard(subject)).join('')}
                                ${sem2Subjects.length === 0 ? '<p class="text-xs text-gray-400 italic">No subjects</p>' : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        return layoutHTML;
    };

    const renderSubjectCard = (subject) => {
        // Define styles based on subject type (matching subject_mapping.blade.php)
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

        return `
            <div class="subject-card bg-white border-2 ${assignedClass} p-3 rounded-xl shadow-sm flex items-center gap-3 mb-2">
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
            </div>
        `;
    };

    const getOrdinal = (num) => {
        const ordinals = ['', '1st', '2nd', '3rd', '4th', '5th'];
        return ordinals[num] || `${num}th`;
    };

    const toggleVersionDetails = (versionId) => {
        const details = document.getElementById(`version-details-${versionId}`);
        const chevron = document.querySelector(`.version-chevron-${versionId}`);
        
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        } else {
            details.classList.add('hidden');
            chevron.classList.remove('rotate-180');
        }
    };

    const showVersionDetails = async (curriculumId, versionId) => {
        versionDetailsLoading.classList.remove('hidden');
        versionDetailsData.classList.add('hidden');
        
        versionDetailsModal.classList.remove('hidden');
        setTimeout(() => {
            versionDetailsModal.classList.remove('opacity-0');
            versionDetailsModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);

        try {
            const response = await fetch(`/api/curriculum-history/${curriculumId}/versions/${versionId}`);
            const data = await response.json();
            
            if (data.success) {
                renderVersionDetails(data.version);
            } else {
                versionDetailsData.innerHTML = '<div class="text-red-500 text-center py-8">Failed to load version details</div>';
            }
        } catch (error) {
            console.error('Failed to load version details:', error);
            versionDetailsData.innerHTML = '<div class="text-red-500 text-center py-8">Error loading version details</div>';
        } finally {
            versionDetailsLoading.classList.add('hidden');
            versionDetailsData.classList.remove('hidden');
        }
    };

    const renderVersionDetails = (version) => {
        versionDetailsTitle.textContent = `Version ${version.version_number} Details`;
        versionDetailsSubtitle.textContent = `${version.created_at} by ${version.changed_by}`;

        let subjectsHtml = '';
        if (version.subjects && Object.keys(version.subjects).length > 0) {
            for (const [year, semesters] of Object.entries(version.subjects)) {
                const yearOrdinal = year == 1 ? '1st' : year == 2 ? '2nd' : year == 3 ? '3rd' : `${year}th`;
                
                for (const [semester, subjects] of Object.entries(semesters)) {
                    const semesterText = semester == 1 ? 'First Semester' : 'Second Semester';
                    const totalUnits = subjects.reduce((sum, subject) => sum + (parseInt(subject.subject_unit) || 0), 0);
                    
                    subjectsHtml += `
                        <div class="mb-6">
                            <div class="bg-gray-50 px-4 py-3 rounded-lg mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">${yearOrdinal} Year - ${semesterText}</h3>
                                <p class="text-sm text-gray-600">Units: ${totalUnits}</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                ${subjects.map(subject => `
                                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900 text-sm">${subject.subject_name}</h4>
                                                <p class="text-xs text-gray-500 mt-1">${subject.subject_code}</p>
                                                <div class="flex items-center mt-2 space-x-2">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        ${subject.subject_unit} units
                                                    </span>
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${getSubjectTypeColor(subject.subject_type)}">
                                                        ${subject.subject_type}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }
            }
        } else {
            subjectsHtml = '<div class="text-center py-8 text-gray-500">No subjects found in this version</div>';
        }

        versionDetailsData.innerHTML = `
            <div class="space-y-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Version Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-blue-700">Version:</span>
                            <span class="ml-2 text-blue-600">${version.version_number}</span>
                        </div>
                        <div>
                            <span class="font-medium text-blue-700">Total Subjects:</span>
                            <span class="ml-2 text-blue-600">${version.total_subjects}</span>
                        </div>
                        <div class="md:col-span-2">
                            <span class="font-medium text-blue-700">Description:</span>
                            <span class="ml-2 text-blue-600">${version.change_description}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Subjects in this Version</h3>
                    ${subjectsHtml}
                </div>
            </div>
        `;
    };

    const getSubjectTypeColor = (type) => {
        switch (type) {
            case 'Major': return 'bg-blue-100 text-blue-800';
            case 'Minor': return 'bg-purple-100 text-purple-800';
            case 'Elective': return 'bg-red-100 text-red-800';
            default: return 'bg-orange-100 text-orange-800';
        }
    };

    const hideVersionHistory = () => {
        versionHistoryModal.classList.add('opacity-0');
        versionHistoryModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => versionHistoryModal.classList.add('hidden'), 300);
    };

    const hideVersionDetails = () => {
        versionDetailsModal.classList.add('opacity-0');
        versionDetailsModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => versionDetailsModal.classList.add('hidden'), 300);
    };


    // Event listeners for version history modals
    closeVersionHistoryModalBtn.addEventListener('click', hideVersionHistory);
    versionHistoryModal.addEventListener('click', (e) => { if (e.target === versionHistoryModal) hideVersionHistory(); });
    
    closeVersionDetailsModalBtn.addEventListener('click', hideVersionDetails);
    versionDetailsModal.addEventListener('click', (e) => { if (e.target === versionDetailsModal) hideVersionDetails(); });

    // SweetAlert for success messages
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    const messageParam = urlParams.get('message');
    
    // Check for success parameter in URL
    if (successParam === 'added' || successParam === 'true') {
        let message = 'Subject has been successfully added to the curriculum!';
        if (messageParam) {
            message = decodeURIComponent(messageParam);
        }
        
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#10b981',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: true,
            allowOutsideClick: true
        });
        
        // Clean up URL parameters
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
    
    // Check for session flash messages
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#10b981',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: true,
            allowOutsideClick: true
        });
    @endif
    
    @if(session('subject_added'))
        Swal.fire({
            icon: 'success',
            title: 'Subject Added Successfully!',
            text: '{{ session('subject_added') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#10b981',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: true,
            allowOutsideClick: true
        });
    @endif
});
</script>

@endsection