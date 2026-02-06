@extends('layouts.app')

@section('content')
<style>
    .progress-ring__circle { transition: stroke-dashoffset 0.35s; transform: rotate(-90deg); transform-origin: 50% 50%; }
    .accordion-content { max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; }
    .component-row input { background-color: transparent; }
    .grade-history-card { cursor: pointer; }
    #grade-modal.opacity-0 { opacity: 0; }
    #grade-modal-panel.opacity-0 { opacity: 0; }
    #grade-modal-panel.scale-95 { transform: scale(0.95); }
</style>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 sm:p-6 md:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        {{-- Grade Scheme Setup Form --}}
        <div id="grade-setup-card" class="lg:col-span-2 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-2xl shadow-lg border border-gray-200/80">
            <form id="grade-setup-form" onsubmit="return false;">
                @csrf
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Curriculum Grade Scheme Setup</h1>
                    <p class="text-sm text-gray-600 mt-1">Design and manage grading schemes for entire curriculums with automatic minor course grading.</p>
                </div>

                {{-- Curriculum Level Selection --}}
                <div id="curriculum-level-section" class="border border-gray-200 bg-gray-50/50 p-6 rounded-xl">
                    <div class="flex items-center gap-3 pb-3 mb-4">
                        <div class="w-10 h-10 flex-shrink-0 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.168 18.477 18.582 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-700">Curriculum Level</h2>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button id="senior-high-btn" type="button" class="p-4 border-2 border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors text-left group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.168 18.477 18.582 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Senior High</h3>
                                    <p class="text-sm text-gray-600">DepEd Grading System</p>
                                </div>
                            </div>
                        </button>
                        <button id="college-btn" type="button" class="p-4 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors text-left group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">College</h3>
                                    <p class="text-sm text-gray-600">CHED Grading System</p>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

                {{-- Subject Category Selection (Unlocks for College) --}}
                <div id="memorandum-section" class="mt-8 border border-gray-200 bg-gray-50/50 p-6 rounded-xl hidden">
                    <div class="flex items-center gap-3 pb-3 mb-4">
                        <div class="w-10 h-10 flex-shrink-0 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-700">Subject Category</h2>
                    </div>
                    <div>
                        <button id="select-memorandum-btn" type="button" class="w-full flex items-center justify-between gap-2 bg-white hover:bg-blue-50 text-gray-700 font-semibold py-3 px-4 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 border border-blue-300">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                                <span id="memorandum-btn-text">Select Subject Category</span>
                            </div>
                            <span id="memorandum-arrow" class="text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                            </span>
                        </button>
                    </div>
                </div>

                {{-- Selected Subjects Section --}}
                <div id="selected-subjects-section" class="mt-8 border border-gray-200 bg-gray-50/50 p-6 rounded-xl hidden">
                    <div class="flex items-center gap-3 pb-3 mb-4">
                        <div class="w-10 h-10 flex-shrink-0 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-700">Selected Subjects</h2>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div id="selected-subjects-list" class="divide-y divide-gray-100">
                            {{-- Selected subjects will be listed here --}}
                        </div>
                    </div>
                </div>

                {{-- Effectivity Period --}}
                <div id="effectivity-period-section" class="mt-8 border border-gray-200 bg-gray-50/50 p-6 rounded-xl hidden">
                    <div class="flex items-center gap-3 pb-3 mb-4">
                        <div class="w-10 h-10 flex-shrink-0 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-700">Effectivity Period</h2>
                            <p class="text-sm text-gray-600 mt-1">Set the validity range for this grade scheme. Updates are restricted while active.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="date" id="effectivity-start-date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" id="effectivity-end-date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        </div>
                    </div>
                </div>

                {{-- Grade Components --}}
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-3 pb-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 flex-shrink-0 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M12 21a9 9 0 110-18 9 9 0 010 18z" /></svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-700">Semestral Grade Components</h2>
                                <p class="text-sm text-amber-600 font-medium mt-1 curriculum-reminder-text">⚠️ Please select a subject category first to set up grades</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            {{-- Template Dropdown --}}
                            <div class="relative">
                                <button id="template-dropdown-btn" type="button" style="display: none;" class="flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors py-2 px-3 rounded-lg hover:bg-gray-100 border border-transparent hover:border-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                    Apply Template
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div id="template-dropdown-menu" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-100 hidden z-20">
                                    <button type="button" onclick="applyTemplate('gen_ed')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors first:rounded-t-lg">
                                        General Education
                                    </button>
                                    <button type="button" onclick="applyTemplate('prof_lab')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                        Professional (Laboratory)
                                    </button>
                                    <button type="button" onclick="applyTemplate('prof_non_lab')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                        Professional (Non-Laboratory)
                                    </button>
                                    <button type="button" onclick="applyTemplate('prof_board')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                        Professional (Board Courses)
                                    </button>
                                    <button type="button" onclick="applyTemplate('prof_oc')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                        Professional (OC)
                                    </button>
                                    <button type="button" onclick="applyTemplate('nstp1')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                        NSTP 1
                                    </button>
                                    <button type="button" onclick="applyTemplate('nstp2')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                        NSTP 2
                                    </button>
                                    <button type="button" onclick="applyTemplate('research')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                        Research
                                    </button>
                                    <button type="button" onclick="applyTemplate('ojt')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors last:rounded-b-lg">
                                        OJT / Practicum
                                    </button>
                                </div>
                            </div>


                            <button id="add-grade-component-btn" type="button" style="display: none;" class="flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors py-2 px-3 rounded-lg hover:bg-indigo-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                Add Grade Component
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4" id="semestral-grade-accordion">
                        {{-- Grade components will be dynamically inserted here --}}
                    </div>

                    <div class="mt-8 flex justify-center items-center p-4 bg-gray-100 rounded-lg border border-gray-200">
                        <div class="relative w-24 h-24">
                            <svg class="w-full h-full" viewBox="0 0 100 100">
                                <circle class="text-gray-200" stroke-width="10" stroke="currentColor" fill="transparent" r="45" cx="50" cy="50" />
                                <circle id="progress-circle" class="progress-ring__circle text-indigo-500" stroke-width="10" stroke-linecap="round" stroke="currentColor" fill="transparent" r="45" cx="50" cy="50" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span id="total-weight" class="text-xl font-bold text-gray-700">0%</span>
                            </div>
                        </div>
                        <p class="ml-4 font-semibold text-gray-600">Total Weight</p>
                    </div>


                </div>



                <div class="mt-8 flex justify-center items-center p-4 bg-gray-100 rounded-lg border border-gray-200">
                    <button id="setGradeSchemeButton" type="button" disabled class="w-full flex items-center justify-center gap-2 bg-white hover:bg-gray-100 text-black font-bold py-3 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 disabled:opacity-50 disabled:cursor-not-allowed border border-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6a1 1 0 10-2 0v5.586L7.707 10.293zM10 18a8 8 0 100-16 8 8 0 000 16z" /></svg>
                        Set Grade Scheme
                    </button>
                    <button id="update-grade-setup-btn" class="w-full flex items-center justify-center gap-2 bg-white hover:bg-gray-100 text-black font-bold py-3 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 disabled:opacity-50 disabled:cursor-not-allowed hidden border border-gray-300">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                        Update Grade Scheme
                    </button>
                </div>
            </form>
        </div>

        {{-- Grade History --}}

        <div id="grade-history-card-main" class="lg:col-span-1 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-2xl shadow-lg border border-gray-200/80 flex flex-col">
            <h2 id="grade-history-title" class="text-xl font-bold text-gray-700 mb-4 pb-3 border-b">Curriculum Grade History</h2>
            
            {{-- View Mode Toggle --}}
            <div class="mb-4 flex gap-1 bg-gray-100 p-1 rounded-lg">
                <button 
                    id="view-curriculum-btn" 
                    class="view-mode-btn flex-1 px-2 py-2 text-xs font-semibold rounded-md transition-colors bg-white text-indigo-600 shadow-sm"
                    data-view="curriculum"
                >
                    Curriculums
                </button>

                <button 
                    id="view-subject-btn" 
                    class="view-mode-btn flex-1 px-2 py-2 text-xs font-semibold rounded-md transition-colors text-gray-600 hover:text-gray-800"
                    data-view="subject"
                >
                    Subjects
                </button>
            </div>
            
            {{-- Search Bar --}}
            <div class="mb-4">
                <div class="relative">
                    <input 
                        type="text" 
                        id="curriculum-search" 
                        placeholder="Search..." 
                        class="w-full px-4 py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    />
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            
            {{-- Type Filter Buttons (for curriculum view) --}}
            <div id="curriculum-type-filters" class="mb-4 flex gap-2">
                <button 
                    id="filter-all-btn" 
                    class="curriculum-filter-btn flex-1 px-3 py-2 text-xs font-medium rounded-lg transition-colors bg-indigo-600 text-white"
                    data-filter="all"
                >
                    All
                </button>
                <button 
                    id="filter-college-btn" 
                    class="curriculum-filter-btn flex-1 px-3 py-2 text-xs font-medium rounded-lg transition-colors bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="college"
                >
                    College
                </button>
                <button 
                    id="filter-seniorhigh-btn" 
                    class="curriculum-filter-btn flex-1 px-3 py-2 text-xs font-medium rounded-lg transition-colors bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="seniorhigh"
                >
                    Senior High
                </button>
            </div>
            
            {{-- Subject Type Filter Buttons (Replaced with Level and Category Dropdowns) --}}
            <div id="subject-type-filters" class="mb-4 hidden flex flex-col gap-2">
                <select id="grade-history-level-filter" class="w-full text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 py-2 px-3">
                    <option value="college">CHED (College)</option>
                    <option value="senior_high">DepEd (Senior High)</option>
                </select>
                <select id="grade-history-category-filter" class="w-full text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 py-2 px-3">
                    <option value="all">All Categories</option>
                </select>
            </div>
            
            <div id="grade-history-container" class="space-y-4 flex-1 overflow-y-auto min-h-0">
                <p id="no-history-message" class="text-gray-500">No curriculums with grade schemes yet.</p>
            </div>
        </div>
    </div>
</main>

{{-- Save Grade Scheme Confirmation Modal --}}
<div id="saveGradeSchemeModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-blue-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Confirm Grade Scheme</h3>
            <p class="text-sm text-gray-500 mt-2">Are you sure you want to save this grade scheme for the selected subject?</p>
            <div class="mt-6 flex justify-center gap-4">
                <button id="cancelSaveGradeScheme" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">No</button>
                <button id="confirmSaveGradeScheme" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Yes</button>
            </div>
        </div>
    </div>
</div>

{{-- Grade Scheme Success Modal --}}
<div id="gradeSchemeSuccessModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Successfully Added!</h3>
            <p class="text-sm text-gray-500 mt-2">Your grade scheme has been saved successfully!</p>
            <div class="mt-6">
                <button id="closeGradeSchemeSuccess" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">OK</button>
            </div>
        </div>
    </div>
</div>

{{-- Update Grade Scheme Confirmation Modal --}}
<div id="updateGradeSchemeModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-orange-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Confirm Grade Update</h3>
            <p class="text-sm text-gray-500 mt-2">Are you sure you want to update the grade of this subject?</p>
            <div class="mt-6 flex justify-center gap-4">
                <button id="cancelUpdateGradeScheme" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">No</button>
                <button id="confirmUpdateGradeScheme" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-orange-600 rounded-lg hover:bg-orange-700">Yes</button>
            </div>
        </div>
    </div>
</div>

{{-- Grade Scheme Update Success Modal --}}
<div id="gradeSchemeUpdateSuccessModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Successfully Updated!</h3>
            <p class="text-sm text-gray-500 mt-2">You successfully updated the grade of this subject!</p>
            <div class="mt-6">
                <button id="closeGradeSchemeUpdateSuccess" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">OK</button>
            </div>
        </div>
    </div>
</div>



{{-- Update Grade Scheme Confirmation Modal --}}
<div id="editGradeSchemeModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-yellow-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Create New Grade Subject</h3>
            <p class="text-sm text-gray-500 mt-2">Are you sure you want to update this grade subject?</p>
            <div class="mt-6 flex justify-center gap-4">
                <button id="cancelEditGradeScheme" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">No</button>
                <button id="confirmEditGradeScheme" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700">Yes</button>
            </div>
        </div>
    </div>
</div>

{{-- Grade Details Modal --}}
<div id="grade-modal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl" id="grade-modal-panel">
        {{-- Modal Header --}}
        <div class="flex justify-between items-center p-5 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex-shrink-0 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M12 21a9 9 0 110-18 9 9 0 010 18z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Grade Component Details</h3>
            </div>
            <button id="close-modal-btn" class="text-gray-400 hover:text-gray-700 transition-colors rounded-full p-1 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Modal Content --}}
        <div id="modal-content" class="p-6 max-h-[70vh] overflow-y-auto bg-gray-50">
            {{-- Grade version dropdowns will be loaded here --}}
        </div>

        {{-- Modal Footer --}}
        <div class="flex justify-end gap-3 p-5 bg-white border-t border-gray-200 rounded-b-2xl">
            <button id="hide-grade-modal-btn" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Hide
            </button>
            <button id="edit-grade-setup-btn" class="text-white bg-blue-600 hover:bg-blue-700 font-semibold py-2 px-5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Create new
            </button>
        </div>
        </div>
    </div>
</div>

{{-- Curriculum Grade Details Modal --}}
<div id="curriculum-grade-modal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-6xl rounded-2xl shadow-2xl" id="curriculum-grade-modal-panel">
            {{-- Modal Header --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 flex-shrink-0 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800" id="curriculum-modal-title">Curriculum Grade Schemes</h3>
                            <p class="text-sm text-gray-600" id="curriculum-modal-subtitle">View all subjects and their grade configurations</p>
                        </div>
                    </div>
                    <button id="close-curriculum-modal-btn" class="text-gray-400 hover:text-gray-700 transition-colors rounded-full p-1 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                {{-- Search Bar --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="subject-search-input" placeholder="Search subjects by name or code..." class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Minor Subjects --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-3 border-b border-gray-200">
                            <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800">Minor Subjects</h4>
                            <span class="text-sm text-gray-500">(Auto-assigned grades)</span>
                        </div>
                        <div id="minor-subjects-container" class="space-y-3">
                            <p class="text-gray-500 text-sm">No minor subjects found.</p>
                        </div>
                    </div>

                    {{-- Major Subjects --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-3 border-b border-gray-200">
                            <div class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.168 18.477 18.582 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800">Major Subjects</h4>
                            <span class="text-sm text-gray-500">(Custom grades)</span>
                        </div>
                        <div id="major-subjects-container" class="space-y-3">
                            <p class="text-gray-500 text-sm">No major subjects found.</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            
            {{-- Modal Footer --}}
            <div class="flex justify-end p-6 bg-gray-50 border-t border-gray-200 rounded-b-2xl">
                <button id="hide-curriculum-grade-modal-btn" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Hide
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Select Curriculum Modal --}}
<div id="select-memorandum-modal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl">
            {{-- Modal Header --}}
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 flex-shrink-0 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Select Subject Category</h3>
                        <p class="text-sm text-gray-600">Choose a category to view its associated subjects</p>
                    </div>
                </div>
                <button id="close-select-memorandum-modal-btn" class="text-gray-400 hover:text-gray-700 transition-colors rounded-full p-1 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 max-h-[60vh] overflow-y-auto">
                <div class="mb-4">
                    <div class="relative mb-3">
                        <input type="text" id="memorandum-search" placeholder="Search curriculums..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <div id="memorandum-list" class="space-y-2">
                    {{-- Curriculums will be populated here --}}
                    <p class="text-gray-500 text-center py-8">Loading curriculums...</p>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex justify-end p-6 bg-gray-50 border-t border-gray-200 rounded-b-2xl">
                <button id="hide-select-memorandum-modal-btn" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Hide
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Select Subjects Modal --}}
<div id="select-subjects-modal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl">
            {{-- Modal Header --}}
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 flex-shrink-0 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Subject</h3>
                        <p class="text-sm text-gray-600" id="subject-modal-subtitle">Review the subjects of the selected category</p>
                    </div>
                </div>
                {{-- Removed X Button --}}
            </div>

            {{-- Modal Body --}}
            <div class="p-6 max-h-[60vh] overflow-y-auto">
                <div class="mb-4">
                    <div class="flex items-center justify-end mb-3 hidden">
                        <span id="selected-subjects-count" class="text-sm text-gray-600">0 selected</span>
                    </div>
                    <div class="relative mb-3">
                        <input type="text" id="subject-search" placeholder="Search subjects..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                        <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <div id="subjects-checklist" class="space-y-2">
                    {{-- Subjects will be populated here --}}
                    <p class="text-gray-500 text-center py-8">Loading subjects...</p>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex justify-end gap-3 p-6 bg-gray-50 border-t border-gray-200 rounded-b-2xl">
                <button id="close-select-subjects-modal-btn" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                   Hide
                </button>
                <button id="confirm-select-subjects-btn" class="px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Top Level State
    let selectedLevel = null; // 'Senior High' or 'College'
    let selectedMemorandum = null;
    let selectedSubjects = [];

    // Layout Elements
    const accordionContainer = document.getElementById('semestral-grade-accordion');
    const totalWeightSpan = document.getElementById('total-weight');
    const progressCircle = document.getElementById('progress-circle');
    const addGradeBtn = document.getElementById('setGradeSchemeButton'); // "Set Grade Scheme"
    const updateGradeSetupBtn = document.getElementById('update-grade-setup-btn');
    const addGradeComponentBtn = document.getElementById('add-grade-component-btn');
    const gradeHistoryContainer = document.getElementById('grade-history-container');

    // Section Elements
    const curriculumLevelSection = document.getElementById('curriculum-level-section');
    const seniorHighBtn = document.getElementById('senior-high-btn');
    const collegeBtn = document.getElementById('college-btn');
    
    const memorandumSection = document.getElementById('memorandum-section');
    const selectMemorandumBtn = document.getElementById('select-memorandum-btn');
    const memorandumBtnText = document.getElementById('memorandum-btn-text');
    
    const selectedSubjectsSection = document.getElementById('selected-subjects-section');
    const selectedSubjectsList = document.getElementById('selected-subjects-list');

    // Modals
    const selectMemorandumModal = document.getElementById('select-memorandum-modal');
    const selectSubjectsModal = document.getElementById('select-subjects-modal');
    const gradeModal = document.getElementById('grade-modal');
    
    // Modal Close Buttons
    const closeSelectMemorandumModalBtn = document.getElementById('close-select-memorandum-modal-btn');
    const closeSelectSubjectsModalBtn = document.getElementById('close-select-subjects-modal-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');
    
    // Template Toggle
    const templateDropdownBtn = document.getElementById('template-dropdown-btn');
    const templateDropdownMenu = document.getElementById('template-dropdown-menu'); // Added ID in HTML

    // Fix for dropdown visibility toggle
    if (templateDropdownBtn && templateDropdownMenu) {
        templateDropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            templateDropdownMenu.classList.toggle('hidden');
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!templateDropdownBtn.contains(e.target) && !templateDropdownMenu.contains(e.target)) {
                templateDropdownMenu.classList.add('hidden');
            }
        });
    }

    // Hide Buttons Logic (Added for user request)
    const hideButtons = [
        { id: 'close-select-subjects-modal-btn', modal: 'select-subjects-modal' },
        { id: 'hide-select-memorandum-modal-btn', modal: 'select-memorandum-modal' },
        { id: 'hide-grade-modal-btn', modal: 'grade-modal' },
        { id: 'hide-curriculum-grade-modal-btn', modal: 'curriculum-grade-modal' }
    ];

    hideButtons.forEach(btnConfig => {
        const btn = document.getElementById(btnConfig.id);
        if (btn) {
            btn.addEventListener('click', () => {
                hideModal(btnConfig.modal);
            });
        }
    });

    // Templates Configuration
    const templates = {
        'gen_ed': {
            periods: {
                'Prelim': 30,
                'Midterm': 30,
                'Finals': 40
            },
            components: [
                {
                    name: "Class Standing",
                    weight: 40,
                    sub_components: [
                        { name: "Attendance", weight: 10 },
                        { name: "Written Works", weight: 50 },
                        { name: "Performance Task", weight: 40 }
                    ]
                },
                {
                    name: "Project",
                    weight: 25,
                    sub_components: []
                },
                {
                    name: "Major Examination",
                    weight: 35,
                    sub_components: []
                }
            ]
        },
        'prof_lab': {
            periods: {
                'Prelim': 30,
                'Midterm': 30,
                'Finals': 40
            },
            components: [
                {
                    name: "Class Standing",
                    weight: 35,
                    sub_components: [
                        { name: "Attendance", weight: 10 },
                        { name: "Written Works", weight: 40 },
                        { name: "Performance Task", weight: 50 }
                    ]
                },
                {
                    name: "Project",
                    weight: 40,
                    sub_components: []
                },
                {
                    name: "Major Examination",
                    weight: 25,
                    sub_components: []
                }
            ]
        },
        'prof_non_lab': {
            periods: {
                'Prelim': 30,
                'Midterm': 30,
                'Finals': 40
            },
            components: [
                {
                    name: "Class Standing",
                    weight: 35,
                    sub_components: [
                        { name: "Attendance", weight: 10 },
                        { name: "Written Works", weight: 40 },
                        { name: "Performance Task", weight: 50 }
                    ]
                },
                {
                    name: "Project",
                    weight: 40,
                    sub_components: []
                },
                {
                    name: "Major Examination",
                    weight: 25,
                    sub_components: []
                }
            ]
        },
        'prof_board': {
            periods: {
                'Prelim': 30,
                'Midterm': 30,
                'Finals': 40
            },
            components: [
                {
                    name: "Class Standing",
                    weight: 40,
                    sub_components: [
                        { name: "Attendance", weight: 10 },
                        { name: "Written Works", weight: 40 },
                        { name: "Performance Task", weight: 50 }
                    ]
                },
                {
                    name: "Project",
                    weight: 30,
                    sub_components: []
                },
                {
                    name: "Major Examination",
                    weight: 30,
                    sub_components: []
                }
            ]
        },
        'prof_oc': {
            periods: { 'Prelim': 30, 'Midterm': 30, 'Finals': 40 },
            components: [
                {
                    name: "Class Standing",
                    weight: 40,
                    sub_components: [
                        { name: "Attendance", weight: 10 },
                        { name: "Written Works", weight: 40 },
                        { name: "Performance Task", weight: 50 }
                    ]
                },
                {
                    name: "Project",
                    weight: 35,
                    sub_components: [
                        { name: "CBO", weight: 40 },
                        { name: "OCR", weight: 60 }
                    ]
                },
                {
                    name: "Examination",
                    weight: 25,
                    sub_components: []
                }
            ]
        },
        'nstp1': {
            periods: { 'Prelim': 30, 'Midterm': 30, 'Finals': 40 },
            components: [
                {
                    name: "Class Standing",
                    weight: 40,
                    sub_components: [
                        { name: "Attendance", weight: 10 },
                        { name: "Written Works", weight: 50 },
                        { name: "Performance Task", weight: 40 }
                    ]
                },
                {
                    name: "Project",
                    weight: 30,
                    sub_components: []
                },
                {
                    name: "Examination",
                    weight: 30,
                    sub_components: []
                }
            ]
        },
        'nstp2': {
            periods: { 'Prelim': 30, 'Midterm': 30, 'Finals': 40 },
            components: [
                {
                    name: "Class Standing",
                    weight: 30,
                    sub_components: [
                        { name: "Attendance", weight: 10 },
                        { name: "Written Works", weight: 35 },
                        { name: "Performance Task", weight: 55 }
                    ]
                },
                {
                    name: "Project",
                    weight: 40,
                    sub_components: [] // OCR 100% implicitly
                },
                {
                    name: "Examination",
                    weight: 30,
                    sub_components: []
                }
            ]
        },
        'research': {
            periods: { 'Prelim': 30, 'Midterm': 30, 'Finals': 40 },
            components: [
                {
                    name: "Class Standing",
                    weight: 25,
                    sub_components: [
                        { name: "Attendance", weight: 10 },
                        { name: "Written Works", weight: 45 },
                        { name: "Performance Task", weight: 45 }
                    ]
                },
                {
                    name: "Project",
                    weight: 40,
                    sub_components: []
                },
                {
                    name: "Examination",
                    weight: 35,
                    sub_components: [
                         { name: "Written Exam", weight: 20 },
                         { name: "Oral Exam", weight: 80 }
                    ]
                }
            ]
        },
        'ojt': {
            periods: { 'Prelim': 30, 'Midterm': 30, 'Finals': 40 },
            components: [
                {
                    name: "Class Standing",
                    weight: 50,
                    sub_components: [
                        { name: "Attendance", weight: 30 },
                        { name: "Written Works", weight: 40 },
                        { name: "Performance Task", weight: 30 }
                    ]
                },
                {
                    name: "Project",
                    weight: 35,
                    sub_components: []
                },
                {
                    name: "Examination",
                    weight: 15,
                    sub_components: []
                }
            ]
        }
    };

    window.applyTemplate = (templateKey) => {
        const template = templates[templateKey];
        if (!template) return;
        
        // Hide dropdown after selection
        if (templateDropdownMenu) templateDropdownMenu.classList.add('hidden');

        // Check if subjects are selected
        if (!selectedSubjects || selectedSubjects.length === 0) {
            Swal.fire({
                title: 'Select Subjects First',
                text: 'Please select subjects before applying a template.',
                icon: 'warning',
                confirmButtonText: 'OK',
                confirmButtonColor: '#4f46e5'
            });
            return;
        }

        Swal.fire({
            title: 'Apply Grade Template?',
            text: "This will overwrite any existing grade components you've added.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, apply it!'
        }).then((result) => {
            if (result.isConfirmed) {
                accordionContainer.innerHTML = ''; // Clear existing
                
                // Construct data object for loadGradeDataToDOM
                const dataToLoad = {};
                
                // According to Period Breakdown
                Object.keys(template.periods).forEach(periodName => {
                    dataToLoad[periodName] = {
                        weight: template.periods[periodName],
                        components: JSON.parse(JSON.stringify(template.components)) // Deep copy
                    };
                });
                
                loadGradeDataToDOM(dataToLoad);
                
                Swal.fire(
                    'Applied!',
                    'The grade template has been applied.',
                    'success'
                );
            }
        });
    };

    // Other Elements
    const memorandumSearchInput = document.getElementById('memorandum-search');
    const memorandumList = document.getElementById('memorandum-list');
    
    const subjectSearchInput = document.getElementById('subject-search');
    const subjectsChecklist = document.getElementById('subjects-checklist');
    const selectAllSubjectsCheckbox = document.getElementById('select-all-subjects');
    const selectedSubjectsCountSpan = document.getElementById('selected-subjects-count');
    const cancelSelectSubjectsBtn = document.getElementById('cancel-select-subjects-btn');
    const confirmSelectSubjectsBtn = document.getElementById('confirm-select-subjects-btn');

    // Confirm Subject Selection Logic
    // Confirm Subject Selection Logic
    const finalizeSubjectSelection = async () => {
         console.log('Finalizing Selection');
         console.log('Current selectedSubjects:', selectedSubjects);

         const activeSubject = selectedSubjects.find(s => {
             if (s.effectivity_end_date) {
                 // 1. Get Today as YYYY-MM-DD (Local Time)
                 const today = new Date();
                 const todayStr = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                 
                 // 2. Get End Date as YYYY-MM-DD (Raw String from DB)
                 // Safety check: ensure it's a string
                 const rawEndDate = String(s.effectivity_end_date);
                 const endDateStr = rawEndDate.substring(0, 10);
                 
                 console.log(`Checking ${s.subject_code}: Today(${todayStr}) vs End(${endDateStr})`);
                 
                 // 3. Compare Strict Strings
                 // Allowed if Today >= EndDate
                 // Blocked if Today < EndDate (Strictly Before)
                 if (todayStr < endDateStr) {
                     return true; // Found a blocking subject
                 }
             }
             return false;
         });

         if (activeSubject) {
             const endDateStr = String(activeSubject.effectivity_end_date).substring(0, 10);
             const categoryName = activeSubject.subject_category || selectedMemorandum?.name || 'this category';
             
             Swal.fire({
                icon: 'warning',
                title: 'Action Restricted',
                html: `
                    <div class="mb-4">
                        <p class="text-gray-600 mb-2">
                            You cannot update the grade scheme for <b>${categoryName}</b> at this time.
                        </p>
                        <p class="text-gray-500 text-sm">
                            The current grade configuration is still active and valid.
                        </p>
                    </div>
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 text-sm text-orange-800 font-medium">
                        Updates allowed starting: <span class="font-bold">${endDateStr}</span>
                    </div>
                `,
                confirmButtonText: 'I Understand',
                confirmButtonColor: '#f97316' // Orange-500
            });
            return; // Stop execution
         }

         // Proceed if no active restrictions
         updateSelectedSubjectsList();
         hideModal('select-subjects-modal');
         hideModal('select-memorandum-modal'); // Ensure this is also closed if skipping

         // Reveal Effectivity Period Section for grading
         const effectivitySection = document.getElementById('effectivity-period-section');
         if (effectivitySection) {
             effectivitySection.classList.remove('hidden');
         }

         // Load existing grades from template (first graded subject found)
         const templateSubject = selectedSubjects.find(s => s.has_grades || s.is_graded);
         
         if (templateSubject) {
             Swal.fire({
                 title: `Loading grades from ${templateSubject.subject_code}...`,
                 allowOutsideClick: false,
                 showConfirmButton: false,
                 didOpen: () => {
                     Swal.showLoading();
                 }
             });
             
             // Reveal Effectivity Period Section
             const effectivitySection = document.getElementById('effectivity-period-section');
             if (effectivitySection) {
                 effectivitySection.classList.remove('hidden');
             }
             try {
                 const versionData = await fetchAPI(`grades/${templateSubject.id}/version-history`);
                 Swal.close();
                 
                 // Check for Date Restriction on existing grade
                 // Assuming 'current_version' contains the latest effective dates
                 if (versionData && versionData.current_version) {
                     const { effectivity_start_date, effectivity_end_date } = versionData.current_version;
                     let isActive = false;
                     
                     if (effectivity_start_date && effectivity_end_date) {
                         const now = new Date();
                         // Zero out time for date comparison
                         now.setHours(0,0,0,0);
                         
                         const start = new Date(effectivity_start_date);
                         start.setHours(0,0,0,0);
                         
                         const end = new Date(effectivity_end_date);
                         end.setHours(0,0,0,0);
                         
                         // Check if current date is within range [start, end]
                         if (!isNaN(start.getTime()) && !isNaN(end.getTime())) {
                             isActive = (now >= start && now <= end);
                             console.log(`Checking Date Restriction: Now=${now.toDateString()}, End=${end.toDateString()}, IsActive=${isActive}`);
                         }
                     }
                     
                     if (isActive) {
                         const endDate = new Date(effectivity_end_date);
                         const updateDate = new Date(endDate);
                         updateDate.setDate(endDate.getDate() + 1); // Updates allowed the day after

                         // Show restriction notification with specific user text
                         Swal.fire({
                             icon: 'warning',
                             title: 'Action Restricted',
                             html: `
                                 <p class="mb-3">You are not allowed to update or change the grade of this subject because this grade is still active.</p>
                                 <p class="font-semibold text-indigo-600">You can update this grade starting from: ${updateDate.toLocaleDateString()}</p>
                             `,
                             footer: `<span class="text-xs text-slate-500">Current Effectivity: ${new Date(effectivity_start_date).toLocaleDateString()} - ${endDate.toLocaleDateString()}</span>`,
                             confirmButtonColor: '#3B82F6',
                             confirmButtonText: 'I Understand'
                         });

                         // Load data but lock the interface (Read-Only)
                         if (versionData && versionData.current_version && versionData.current_version.components) {
                              loadGradeDataToDOM(versionData.current_version.components);
                              
                              // Populate Date Inputs
                              const startInput = document.getElementById('effectivity-start-date');
                              const endInput = document.getElementById('effectivity-end-date');
                              if(startInput) startInput.value = versionData.current_version.effectivity_start_date || '';
                              if(endInput) endInput.value = versionData.current_version.effectivity_end_date || '';
                         }
                         
                         // Disable Editing
                         toggleGradeComponents(true);
                         const setBtn = document.getElementById('setGradeSchemeButton');
                         if(setBtn) {
                             setBtn.disabled = true;
                             setBtn.classList.add('opacity-50', 'cursor-not-allowed');
                         }
                         
                         return;
                     }
                 }
                 
                 if (versionData && versionData.current_version && versionData.current_version.components) {
                      console.log('Loading components from template:', templateSubject.subject_code);
                      loadGradeDataToDOM(versionData.current_version.components);
                      
                      // Populate Date Inputs
                      const startInput = document.getElementById('effectivity-start-date');
                      const endInput = document.getElementById('effectivity-end-date');
                      if(startInput && versionData.current_version.effectivity_start_date) 
                          startInput.value = versionData.current_version.effectivity_start_date;
                      if(endInput && versionData.current_version.effectivity_end_date) 
                          endInput.value = versionData.current_version.effectivity_end_date;
                      
                      Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon: 'success',
                          title: 'Grades Loaded',
                          text: `Loaded grading scheme from ${templateSubject.subject_code}.`,
                          showConfirmButton: false,
                          timer: 3000
                      });
                 } else {
                      loadGradeDataToDOM({});
                 }
             } catch (error) {
                 console.error('Error loading grades:', error);
                 Swal.close();
                 loadGradeDataToDOM({});
             }
         } else {
             loadGradeDataToDOM({});
             // Clean date inputs on new
             const startInput = document.getElementById('effectivity-start-date');
             const endInput = document.getElementById('effectivity-end-date');
             if(startInput) startInput.value = '';
             if(endInput) endInput.value = '';
         }
    };

    if (confirmSelectSubjectsBtn) {
        confirmSelectSubjectsBtn.addEventListener('click', async () => {
             await finalizeSubjectSelection();
        });
    }

    let isEditMode = false;
    let componentCounter = 0;

    const createGradeComponent = (period = `component${++componentCounter}`, weight = 0, components = []) => {
        const componentContainer = document.createElement('div');
        componentContainer.className = 'period-container border border-gray-200/80 bg-white rounded-xl shadow-sm overflow-hidden';
        componentContainer.dataset.period = period;
        
        componentContainer.innerHTML = `
            <div class="accordion-toggle w-full flex justify-between items-center p-4 bg-white hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                <div class="flex items-center gap-4">
                    <input type="text" value="${period.startsWith('component') ? '' : period}" placeholder="Subject Area / Component Name (e.g., Midterm)" class="component-name-input font-semibold text-lg text-gray-700 capitalize border-gray-300 rounded-md shadow-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <div class="flex items-center">
                        <input type="number" value="${weight}" class="semestral-input w-20 text-center font-bold border-gray-300 rounded-md shadow-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span class="ml-2 text-lg text-gray-600">%</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">Sub-total: <span class="sub-total font-bold text-gray-700">100%</span></span>
                     <button type="button" class="remove-component-btn flex items-center justify-center w-8 h-8 text-gray-400 hover:text-red-600 hover:bg-red-100 rounded-full transition-colors" title="Remove Component">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>
                    </button>
                    <svg class="w-6 h-6 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            <div class="accordion-content bg-gray-50/50 border-t border-gray-200/80">
                <div class="p-4">
                    <table class="w-full text-sm">
                        <thead class="border-b border-gray-200">
                            <tr>
                                <th class="p-2 text-left font-semibold text-gray-600">Sub-Component / Modality</th>
                                <th class="p-2 text-center font-semibold text-gray-600 w-28">Weight (%)</th>
                                <th class="p-2 text-center font-semibold text-gray-600 w-28">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="component-tbody"></tbody>
                    </table>
                    <div class="mt-4 flex justify-end">
                        <button type="button" class="add-component-btn inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors py-2 px-3 rounded-lg hover:bg-indigo-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                            Add Main Component
                        </button>
                    </div>
                </div>
            </div>`;
            
        const tbody = componentContainer.querySelector('.component-tbody');
        if (components.length === 0) {
            // Add default row if no components provided
            tbody.appendChild(createRow(false, period));
             // Add default sub-component row as requested
            tbody.appendChild(createRow(true, period));
        } else {
            components.forEach(comp => {
                const mainRow = createRow(false, period, comp);
                tbody.appendChild(mainRow);
                (comp.sub_components || []).forEach(sub => {
                    const subRow = createRow(true, period, sub);
                    tbody.appendChild(subRow);
                });
            });
        }
        
        return componentContainer;
    };




    addGradeComponentBtn.addEventListener('click', () => {
        // Check if subjects are selected
        if (!selectedSubjects || selectedSubjects.length === 0) {
            Swal.fire({
                title: 'Select Subjects First',
                text: 'Please select subjects before adding grade components.',
                icon: 'warning',
                confirmButtonText: 'OK',
                confirmButtonColor: '#4f46e5'
            });
            return;
        }
        
        // Add the grade component
        const newComponent = createGradeComponent();
        accordionContainer.appendChild(newComponent);

        // Auto-open the accordion
        const content = newComponent.querySelector('.accordion-content');
        const icon = newComponent.querySelector('.accordion-toggle svg:last-child');
        
        requestAnimationFrame(() => {
            content.style.maxHeight = content.scrollHeight + "px";
            icon.classList.add('rotate-180');
            
            // Focus on the first input of the new row for better UX
            const firstInput = content.querySelector('input');
            if (firstInput) firstInput.focus();
        });
        
        calculateAndUpdateTotals();
    });

    const createRow = (isSub, period, component = { name: '', weight: 0 }) => {
        const tr = document.createElement('tr');
        tr.className = `component-row ${isSub ? 'sub-component-row border-l-4 border-gray-200' : 'main-component-row'} hover:bg-gray-50`;
        const namePlaceholder = isSub ? "Sub-component Name" : "Main Component Name";
        const inputClass = isSub ? 'sub-input' : 'main-input';
        
        const componentNameBg = !isSub ? 'bg-blue-50 focus:bg-white transition-colors border border-blue-200 focus:border-indigo-500' : 'bg-transparent border-0 focus:ring-0';
        
        tr.innerHTML = `
            <td class="p-2 ${isSub ? 'pl-6' : 'pl-4'} align-middle">
                <input type="text" placeholder="${namePlaceholder}" value="${component.name}" class="component-name-input w-full p-2 rounded appearance-none ${componentNameBg}">
            </td>
            <td class="p-2 w-28 align-middle">
                <input type="number" value="${component.weight}" class="${inputClass} w-full text-center font-semibold border-gray-300 rounded-lg p-2 shadow-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
            </td>
            <td class="p-2 w-28 text-center align-middle">
                <div class="flex items-center justify-center gap-1">
                    ${!isSub ? `<button type="button" class="add-sub-btn flex items-center justify-center w-8 h-8 text-gray-400 hover:text-blue-600 hover:bg-blue-100 rounded-full transition-colors" title="Add Sub-component"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg></button>` : '<span class="w-8 h-8"></span>'}
                    <button type="button" class="remove-row-btn flex items-center justify-center w-8 h-8 text-gray-400 hover:text-red-600 hover:bg-red-100 rounded-full transition-colors" title="Remove Row"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg></button>
                </div>
            </td>
        `;
        return tr;
    };

    const resizeOpenAccordion = (element) => {
        const content = element.closest('.accordion-content');
        if (content && content.style.maxHeight && content.style.maxHeight !== '0px') {
            content.style.maxHeight = content.scrollHeight + "px";
        }
    };

    const handleDynamicEvents = (e) => {
        const target = e.target;
        if (target.closest('.add-component-btn')) {
            const tbody = target.closest('.accordion-content').querySelector('.component-tbody');
            tbody.appendChild(createRow(false, tbody.closest('.period-container').dataset.period));
            resizeOpenAccordion(tbody);
        } else if (target.closest('.add-sub-btn')) {
            const parentRow = target.closest('tr');
            const newSubRow = createRow(true, parentRow.closest('.period-container').dataset.period);
            parentRow.insertAdjacentElement('afterend', newSubRow);
            resizeOpenAccordion(parentRow);
        } else if (target.closest('.remove-row-btn')) {
            const rowToRemove = target.closest('tr');
            const accordionContent = rowToRemove.closest('.accordion-content');
            if (rowToRemove.classList.contains('main-component-row')) {
                let nextRow = rowToRemove.nextElementSibling;
                while (nextRow && nextRow.classList.contains('sub-component-row')) {
                    const toRemove = nextRow;
                    nextRow = nextRow.nextElementSibling;
                    toRemove.remove();
                }
            }
            rowToRemove.remove();
            if (accordionContent && accordionContent.style.maxHeight && accordionContent.style.maxHeight !== '0px') {
                accordionContent.style.maxHeight = accordionContent.scrollHeight + "px";
            }
        } else if (target.closest('.remove-component-btn')) {
            target.closest('.period-container').remove();
        }
        calculateAndUpdateTotals();
    };
    
    let calculationDebounceTimer;
    const CALCULATION_DEBOUNCE = 150; // ms - shorter delay for immediate feedback
    
    const calculateAndUpdateTotals = () => {
        clearTimeout(calculationDebounceTimer);
        calculationDebounceTimer = setTimeout(() => {
            // Assume any calculation trigger is a result of user input or modification
            // Only set if subjects are actually selected to avoid triggering on initial load/reset
            if (selectedSubjects && selectedSubjects.length > 0) {
                 hasUnsavedChanges = true;
            }
            performCalculation();
        }, CALCULATION_DEBOUNCE);
    };
    
    const performCalculation = () => {
        // Cache DOM queries for better performance
        const semestralInputs = document.querySelectorAll('.semestral-input');
        let semestralTotal = 0;
        semestralInputs.forEach(input => semestralTotal += Number(input.value) || 0);
        
        totalWeightSpan.textContent = `${semestralTotal}%`;
        const radius = progressCircle.r.baseVal.value;
        const circumference = 2 * Math.PI * radius;
        progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
        const offset = circumference - (Math.min(semestralTotal, 100) / 100) * circumference;
        progressCircle.style.strokeDashoffset = offset;
        progressCircle.classList.toggle('text-red-500', semestralTotal !== 100);
        progressCircle.classList.toggle('text-indigo-500', semestralTotal === 100);

        let allSubTotalsCorrect = true;
        const periodContainers = document.querySelectorAll('.period-container');
        periodContainers.forEach(container => {
            let periodSubTotal = 0;
            const mainInputs = container.querySelectorAll('.main-input');
            mainInputs.forEach(input => periodSubTotal += Number(input.value) || 0);

            const subTotalSpan = container.querySelector('.sub-total');
            subTotalSpan.textContent = `${periodSubTotal}%`;
            subTotalSpan.classList.toggle('text-red-500', periodSubTotal !== 100);
            subTotalSpan.classList.toggle('text-gray-700', periodSubTotal === 100);
            if (periodSubTotal !== 100) allSubTotalsCorrect = false;

            const mainComponentRows = container.querySelectorAll('.main-component-row');
            mainComponentRows.forEach(mainRow => {
                let subComponentTotal = 0;
                let nextRow = mainRow.nextElementSibling;
                let hasSubComponents = false;
                while (nextRow && nextRow.classList.contains('sub-component-row')) {
                    hasSubComponents = true;
                    subComponentTotal += Number(nextRow.querySelector('.sub-input').value) || 0;
                    nextRow = nextRow.nextElementSibling;
                }
                
                if (hasSubComponents && subComponentTotal !== 100) {
                    // mainRow.classList.add('bg-red-100'); // Removed red highlight
                    allSubTotalsCorrect = false;
                } else {
                    mainRow.classList.remove('bg-red-100');
                }
            });
        });
        
        // Safe access to legacy variables
        const safeCourseType = typeof currentCourseType !== 'undefined' ? currentCourseType : null;
        const safeSubjectId = typeof currentSubjectId !== 'undefined' ? currentSubjectId : null;
        const safeMinorGradesUnlocked = typeof minorGradesUnlocked !== 'undefined' ? minorGradesUnlocked : false;

        // Check curriculum-based validation
        const hasLegacyValidSelection = safeCourseType && 
            (safeCourseType === 'minor' || (safeCourseType === 'major' && safeSubjectId));
            
        const hasValidSelection = (selectedSubjects && selectedSubjects.length > 0) || hasLegacyValidSelection;
        
        // For minor courses, also check if grades are unlocked
        const minorGradesReady = !safeCourseType || safeCourseType !== 'minor' || safeMinorGradesUnlocked;
        
        // Enable Set Grade Scheme button when totals are correct, valid selection exists, and minor grades are ready
        const saveButtonIsDisabled = semestralTotal !== 100 || !allSubTotalsCorrect || !hasValidSelection || !minorGradesReady;
        
        addGradeBtn.disabled = saveButtonIsDisabled;
        updateGradeSetupBtn.disabled = saveButtonIsDisabled;
        
        // Add detailed feedback on why it's disabled
        if (saveButtonIsDisabled) {
             let reason = 'Cannot save: ';
             if (semestralTotal !== 100) reason += `Total weight is ${semestralTotal}% (must be 100%). `;
             if (!allSubTotalsCorrect) reason += 'Some grade components do not sum to 100%. ';
             if (!hasValidSelection) reason += 'No subjects selected. ';
             
             addGradeBtn.title = reason;
             updateGradeSetupBtn.title = reason;
             
             // Update reminder text for visibility
             const reminder = document.querySelector('.curriculum-reminder-text');
             if(reminder) {
                 // Only overwrite if it's an error state we want to highlight
                 if (!hasValidSelection) reminder.textContent = '⚠️ Please select subjects to proceed';
                 else if (semestralTotal !== 100 || !allSubTotalsCorrect) reminder.textContent = `⚠️ Invalid Grade Scheme: ${reason}`;
             }
        } else {
             addGradeBtn.title = 'Save Grade Scheme';
             updateGradeSetupBtn.title = 'Update Grade Scheme';
             const reminder = document.querySelector('.curriculum-reminder-text');
             if(reminder && reminder.textContent.includes('⚠️')) {
                 reminder.textContent = `✅ Ready to set grades for ${selectedSubjects.length} selected subject(s).`;
                 reminder.className = 'text-sm font-medium mt-1 curriculum-reminder-text text-green-600';
             }
        }
    };

    const getGradeDataFromDOM = () => {
        const data = {};
        document.querySelectorAll('.period-container').forEach(container => {
            const periodName = container.querySelector('.component-name-input').value.trim() || container.dataset.period;
            data[periodName] = {
                weight: Number(container.querySelector('.semestral-input').value) || 0,
                components: []
            };
            container.querySelectorAll('.main-component-row').forEach(mainRow => {
                const mainComponent = {
                    name: mainRow.querySelector('.component-name-input').value,
                    weight: Number(mainRow.querySelector('.main-input').value) || 0,
                    sub_components: []
                };
                let nextRow = mainRow.nextElementSibling;
                while (nextRow && nextRow.classList.contains('sub-component-row')) {
                    mainComponent.sub_components.push({
                        name: nextRow.querySelector('.component-name-input').value,
                        weight: Number(nextRow.querySelector('.sub-input').value) || 0,
                    });
                    nextRow = nextRow.nextElementSibling;
                }
                data[periodName].components.push(mainComponent);
            });
        });
        return data;
    };

    const loadGradeDataToDOM = (componentsData) => {
        accordionContainer.innerHTML = ''; // Clear existing components
        const dataToLoad = componentsData && Object.keys(componentsData).length > 0 ? componentsData : {};
        
        Object.keys(dataToLoad).forEach(period => {
            const periodData = dataToLoad[period];
            const newComponent = createGradeComponent(period, periodData.weight, periodData.components);
            accordionContainer.appendChild(newComponent);
        });
        calculateAndUpdateTotals();
    };

    const toggleGradeComponents = (disabled) => {
        // Disable input fields and action buttons
        document.querySelectorAll('.semestral-input, .main-input, .sub-input, .component-name-input, .add-sub-btn, .remove-row-btn, .add-component-btn, .remove-component-btn, #add-grade-component-btn').forEach(el => {
            el.disabled = disabled;
            
            // Add visual styling for disabled state
            if (disabled) {
                el.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-100');
                el.style.pointerEvents = 'none';
            } else {
                el.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-100');
                el.style.pointerEvents = '';
            }
        });
        
        // Handle accordion container - keep accordion toggles functional but disable editing
        const accordionContainer = document.getElementById('semestral-grade-accordion');
        if (accordionContainer) {
            if (disabled) {
                // Add visual indication that it's locked but keep accordion functionality
                accordionContainer.classList.add('opacity-80');
                accordionContainer.style.userSelect = 'none';
                
                // Keep accordion toggle buttons functional
                document.querySelectorAll('.accordion-toggle').forEach(toggle => {
                    toggle.style.pointerEvents = 'auto';
                    toggle.style.cursor = 'pointer';
                });
            } else {
                accordionContainer.classList.remove('opacity-80');
                accordionContainer.style.userSelect = '';
                
                // Reset accordion toggle styling
                document.querySelectorAll('.accordion-toggle').forEach(toggle => {
                    toggle.style.pointerEvents = '';
                    toggle.style.cursor = '';
                });
            }
        }
    };
    
    const showModal = (modalId) => {
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden');
    };

    const hideModal = (modalId) => {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
    };

    // API Response Cache
    const apiCache = new Map();
    const API_CACHE_TTL = 5 * 60 * 1000; // 5 minutes
    
    const clearApiCache = (pattern = null) => {
        if (pattern) {
            // Clear specific cache entries matching pattern
            for (const key of apiCache.keys()) {
                if (key.includes(pattern)) {
                    apiCache.delete(key);
                }
            }
        } else {
            // Clear all cache
            apiCache.clear();
        }
        console.log('API cache cleared:', pattern || 'all');
    };
    
    const fetchAPI = async (url, options = {}) => {
        try {
            const apiUrl = `/api/${url}`;
            
            // Generate cache key from URL and method
            const method = options.method || 'GET';
            const cacheKey = `${method}:${url}`;
            
            // Only cache GET requests
            if (method === 'GET') {
                const cached = apiCache.get(cacheKey);
                if (cached && (Date.now() - cached.timestamp) < API_CACHE_TTL) {
                    console.log(`Cache HIT for: ${apiUrl}`);
                    return cached.data;
                }
            }
            
            console.log(`Making API request to: ${apiUrl}`);
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                            document.querySelector('input[name="_token"]')?.value;
            
            options.headers = { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json', 
                ...options.headers 
            };
            
            const response = await fetch(apiUrl, options);
            console.log(`API Response status: ${response.status} ${response.statusText}`);
            
            if (!response.ok) {
                let errorMessage = `HTTP ${response.status}: ${response.statusText}`;
                try {
                    const errorData = await response.json();
                    errorMessage = errorData.message || errorMessage;
                } catch (e) {
                    // If response is not JSON, use status text
                }
                throw new Error(errorMessage);
            }
            
            const data = await response.json();
            console.log('API Response data:', data);
            
            // Cache GET requests
            if (method === 'GET') {
                apiCache.set(cacheKey, {
                    data: data,
                    timestamp: Date.now()
                });
                console.log(`Cached response for: ${apiUrl}`);
            }
            
            // Clear related cache on POST/PUT/DELETE operations
            if (['POST', 'PUT', 'DELETE', 'PATCH'].includes(method)) {
                // Clear cache for related endpoints
                if (url.includes('grades')) {
                    clearApiCache('grades');
                } else if (url.includes('subjects')) {
                    clearApiCache('subjects');
                } else if (url.includes('curriculums')) {
                    clearApiCache('curriculums');
                }
            }
            
            return data;
        } catch (error) {
            console.error('API Error:', error);
            // Don't show Swal here, let the calling function handle it
            throw error;
        }
    };
    
    // --- New Workflow Functions ---

    const handleLevelSelection = async (level) => {
        selectedLevel = level;
        
        // Update UI state
        if (level === 'Senior High') {
            seniorHighBtn.classList.add('border-purple-500', 'bg-purple-50');
            seniorHighBtn.classList.remove('border-gray-300');
            collegeBtn.classList.remove('border-blue-500', 'bg-blue-50');
            collegeBtn.classList.add('border-gray-300');
            if(templateDropdownBtn) templateDropdownBtn.style.display = 'none'; // Templates only for College for now unless requested
        } else {
            collegeBtn.classList.add('border-blue-500', 'bg-blue-50');
            collegeBtn.classList.remove('border-gray-300');
            seniorHighBtn.classList.remove('border-purple-500', 'bg-purple-50');
            seniorHighBtn.classList.add('border-gray-300');
            if(templateDropdownBtn) templateDropdownBtn.style.display = 'inline-flex';
        }

        // Reset subsequent steps
        selectedMemorandum = null;
        selectedSubjects = [];
        memorandumBtnText.textContent = 'Select Subject Category';
        selectedSubjectsSection.classList.add('hidden');
        selectedSubjectsList.innerHTML = '';
        
        // Unlock Memorandum Section
        memorandumSection.classList.remove('hidden');
        
        // Fetch Curriculums immediately to check
        // We will fetch when modal opens, but good to know if we can pre-load
    };

    const fetchCurriculums = async () => {
        // No longer fetching specific curriculums as per new requirements
        return [];
    };
    
    const subjectCategories = {
        'College': [
            'General Education',
            'NSTP 1',
            'NSTP 2',
            'Professional Subject Non Laboratory',
            'Professional Subject Laboratory',
            'Professional Subject Board Courses',
            'Professional Subject Non Board Courses',
            'Professional Subject OC',
            'Research',
            'OJT/Practicum'
        ],
        'Senior High': [
            'Core Subjects',
            'Applied Track Subjects',
            'Specialized Subjects',
            'Work Immersion'
        ]
    };
    
    const populateSubjectCategories = async () => {
        memorandumList.innerHTML = '<p class="text-gray-500 text-center py-4">Loading active categories...</p>';
        const allCategories = subjectCategories[selectedLevel] || [];
        
        let allSubjects = [];
        try {
            const response = await fetchAPI('subjects');
            allSubjects = response.subjects || response.data || [];
        } catch (e) {
            console.error(e);
            memorandumList.innerHTML = '<p class="text-red-500 text-center py-4">Error loading data.</p>';
            return;
        }

        const hasSubjects = (category) => {
             return allSubjects.some(s => {
                 // 1. Level Check (Simplified logic for filtering)
                 const sLevel = (s.year_level || '').toString().trim();
                 const sSyllabus = (s.syllabus_type || '').toLowerCase();
                 const isSHS = /^(Senior High|SHS|Grade 11|Grade 12)/i.test(sLevel) || sSyllabus === 'deped' || (s.curriculum_name && s.curriculum_name.includes('Senior High'));
                 
                 if (selectedLevel === 'Senior High' && !isSHS) return false;
                 if (selectedLevel !== 'Senior High' && isSHS) return false;

                 // 2. Category Match
                 const sType = (s.subject_type || '').toLowerCase();
                 const sClass = (s.course_classification || '').trim();
                 const sClassLower = sClass.toLowerCase();

                 if (selectedLevel === 'College') {
                    if (category === 'General Education') {
                        if (sClassLower.includes('nstp') || sType.includes('nstp')) return false;
                        if (sType === 'minor') return true;
                        return sClassLower.includes('general education') || sType.includes('general education');
                    }
                    if (category === 'NSTP 1') {
                        return sClassLower.includes('nstp 1') || sType.includes('nstp 1') || (s.subject_code && s.subject_code.toLowerCase().includes('nstp 1'));
                    }
                    if (category === 'NSTP 2') {
                        return sClassLower.includes('nstp 2') || sType.includes('nstp 2') || (s.subject_code && s.subject_code.toLowerCase().includes('nstp 2'));
                    }
                    if (category === 'Research') return sClassLower === 'research' || sType === 'research';
                    if (category === 'OJT/Practicum') return sClassLower.includes('ojt') || sClassLower.includes('practicum') || sType.includes('ojt') || sType.includes('practicum');
                    return sClass === category;
                 } else {
                    if (category === 'Core Subjects') return sClass.includes('Core');
                    if (category === 'Applied Track Subjects') return sClass.includes('Applied');
                    if (category === 'Specialized Subjects') return sClass.includes('Specialized');
                    if (category === 'Work Immersion') return sClass.includes('Work Immersion') || sClass.includes('Immersion');
                    return sClass === category;
                 }
             });
        };

        const activeCategories = allCategories.filter(cat => hasSubjects(cat));

        memorandumList.innerHTML = '';
        
        // Header
        const header = document.createElement('h4');
        header.className = 'text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 pl-2';
        header.textContent = 'Subject Categories';
        memorandumList.appendChild(header);

        if (activeCategories.length === 0) {
             const msg = document.createElement('p');
             msg.className = 'text-gray-500 text-center py-4';
             msg.textContent = 'No active categories found for this level.';
             memorandumList.appendChild(msg);
             return;
        }

        activeCategories.forEach(category => {
            const div = document.createElement('div');
            // Use blue styling for all categories for consistency
            div.className = 'p-3 hover:bg-blue-50 rounded-lg cursor-pointer border border-transparent hover:border-blue-200 transition-colors duration-150 mb-1';
            div.innerHTML = `<p class="font-medium text-gray-800">${category}</p>`;
             div.addEventListener('click', async () => {
                  await handleCategorySelection(category);
                  hideModal('select-memorandum-modal');
             });
            memorandumList.appendChild(div);
        });
        
        // Store for search
        memorandumList.dataset.activeCategories = JSON.stringify(activeCategories);
    };

    const handleCategorySelection = async (category) => {
        // Includes curriculum_name for compatibility with existing display logic
        selectedMemorandum = { id: 'CAT_' + category.replace(/\s+/g, '_'), name: category, curriculum_name: category, is_category: true };
        
        memorandumBtnText.textContent = category;
        memorandumBtnText.classList.add('text-gray-900', 'font-bold');
        
        // Open the subjects modal to let user see and select subjects
        await openSubjectsModal(null, category);
    };

    // Global to store full list for the current modal session
    let currentCategorySubjects = [];

    const openSubjectsModal = async (curriculum, category = null) => {
        showModal('select-subjects-modal');
        subjectsChecklist.innerHTML = '<p class="text-gray-500 text-center py-8">Loading subjects...</p>';
        confirmSelectSubjectsBtn.disabled = false; // Always enabled per request
        
        // Update subtitle dynamically
        const subtitle = document.getElementById('subject-modal-subtitle');
        if (subtitle && category) {
            subtitle.textContent = `Review the subject of the ${category}`;
        }

        let subjects = [];
        if (category) {
             subjects = await fetchSubjectsByCategory(category);
        } else if (curriculum) {
             // Fallback/Legacy
             subjects = await fetchSubjectsByCurriculum(curriculum.id);
        }
        
        // Store full list
        currentCategorySubjects = subjects;
        
        populateSubjectsChecklist(subjects);
    };

    const fetchSubjectsByCategory = async (category) => {
        try {
            const response = await fetchAPI('subjects');
            const allSubjects = response.subjects || response.data || [];
            return allSubjects.filter(s => {
                 // 1. Level Check
                 const sLevel = (s.year_level || '').toString().trim();
                 const sSyllabus = (s.syllabus_type || '').toLowerCase();
                 // Heuristic for Senior High vs College
                 const isSHS = /^(Senior High|SHS|Grade 11|Grade 12)/i.test(sLevel) || sSyllabus === 'deped' || (s.curriculum_name && s.curriculum_name.includes('Senior High'));
                 
                 if (selectedLevel === 'Senior High' && !isSHS) return false;
                 if (selectedLevel !== 'Senior High' && isSHS) return false;

                 // 2. Category Match
                 const sType = (s.subject_type || '').toLowerCase();
                 const sClass = (s.course_classification || '').trim();
                 const sClassLower = sClass.toLowerCase();

                 if (selectedLevel === 'College') {
                    if (category === 'General Education') {
                        if (sClassLower.includes('nstp') || sType.includes('nstp')) return false;
                        if (sType === 'minor') return true;
                        return sClassLower.includes('general education') || sType.includes('general education');
                    }
                    if (category === 'NSTP 1') {
                        return sClassLower.includes('nstp 1') || sType.includes('nstp 1') || (s.subject_code && s.subject_code.toLowerCase().includes('nstp 1'));
                    }
                    if (category === 'NSTP 2') {
                        return sClassLower.includes('nstp 2') || sType.includes('nstp 2') || (s.subject_code && s.subject_code.toLowerCase().includes('nstp 2'));
                    }
                    if (category === 'Research') return sClassLower === 'research' || sType === 'research';
                    if (category === 'OJT/Practicum') return sClassLower.includes('ojt') || sClassLower.includes('practicum') || sType.includes('ojt') || sType.includes('practicum');
                    
                    // Specific Professional Matches - check if sClass matches the category
                    return sClass === category;
                 } else {
                     // Senior High Logic
                    if (category === 'Core Subjects') return sClass.includes('Core');
                    if (category === 'Applied Track Subjects') return sClass.includes('Applied');
                    if (category === 'Specialized Subjects') return sClass.includes('Specialized');
                    if (category === 'Work Immersion') return sClass.includes('Work Immersion') || sClass.includes('Immersion');
                    
                    return sClass === category;
                 }
            });
        } catch (error) {
            console.error('Error fetching subjects by category:', error);
            return [];
        }
    };
    
    // Legacy/Unused helpers (restored for compatibility)
    const fetchSubjectsByCurriculum = async (curriculumId) => {
         try {
            const subjects = await fetchAPI(`curriculums/${curriculumId}/subjects`);
            return (subjects || []).filter(s => (s.subject_type || '').toLowerCase() === 'major');
        } catch (error) {
            console.error('Error fetching subjects:', error);
            return [];
        }
    };
    
    const populateSubjectsChecklist = (subjects) => {
        subjectsChecklist.innerHTML = '';
        if (subjects.length === 0) {
            subjectsChecklist.innerHTML = '<p class="text-gray-500 text-center py-4">No subjects found for this memorandum.</p>';
            return;
        }
        
        // Sorting: Group by Year Level, then Name
        subjects.sort((a, b) => {
            if (a.year_level !== b.year_level) return (a.year_level || '').localeCompare(b.year_level || '');
            return a.subject_name.localeCompare(b.subject_name);
        });
        
        // Default: No subjects selected initially
        selectedSubjects = [];
        
        subjects.forEach(subject => {
            // Check grading status
            const gradedInfo = historyStats.subjects.find(s => s.id === subject.id);
            const isGraded = !!gradedInfo;
            subject.is_graded = isGraded;
            
            if (gradedInfo) {
                subject.effectivity_start_date = gradedInfo.effectivity_start_date;
                subject.effectivity_end_date = gradedInfo.effectivity_end_date;
            }
            
            // Try to find curriculum details for this subject from history stats if available
            if (!subject.curriculum_status && historyStats && historyStats.curriculums) {
                const parentCurriculum = historyStats.curriculums.find(c => c.id === subject.curriculum_id);
                if (parentCurriculum) {
                    const isExpired = parentCurriculum.expiration_date && new Date(parentCurriculum.expiration_date).setHours(0,0,0,0) <= new Date().setHours(0,0,0,0);
                    const isOld = (parentCurriculum.version_status === 'old' || isExpired);
                    subject.curriculum_status = isOld ? 'Old' : (parentCurriculum.status || 'Active');
                    subject.curriculum_name = subject.curriculum_name || parentCurriculum.curriculum_name || parentCurriculum.program_code;
                }
            }
            
            // Render items
            const div = document.createElement('div');
            div.className = `subject-item p-3 rounded-lg border cursor-pointer hover:bg-gray-50 transition-colors border-gray-200 bg-white`;
            div.dataset.subject = JSON.stringify(subject);
            
            div.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-1">
                        <div class="flex justify-between">
                            <p class="text-sm font-semibold text-gray-900">${subject.subject_code}</p>
                            <span class="text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded border ${
                                (subject.subject_type || '').toLowerCase() === 'major' ? 'bg-blue-50 text-blue-600 border-blue-100' :
                                (subject.subject_type || '').toLowerCase() === 'minor' ? 'bg-purple-50 text-purple-600 border-purple-100' :
                                ['ge', 'general education'].some(t => (subject.subject_type || '').toLowerCase().includes(t)) ? 'bg-orange-50 text-orange-600 border-orange-100' :
                                'bg-gray-100 text-gray-600 border-gray-200'
                            }">${subject.course_classification || subject.subject_type}</span>
                        </div>
                        <p class="text-sm text-gray-600">${subject.subject_name}</p>
                        <div class="flex gap-2 mt-1 items-center">
                            ${selectedLevel !== 'Senior High' ? `
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                ${subject.subject_unit || 0} Units
                            </span>` : ''}
                            ${isGraded ? `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800 border border-green-200">✅ Graded</span>` : ''}
                            
                            ${isGraded && subject.effectivity_start_date && subject.effectivity_end_date ? `
                                <div class="mt-1 flex items-center gap-1 text-[10px] text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 w-fit">
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>${new Date(subject.effectivity_start_date).toLocaleDateString()} - ${new Date(subject.effectivity_end_date).toLocaleDateString()}</span>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
            
            div.addEventListener('click', () => {
                const itemDiv = div;
                const wasSelected = selectedSubjects.some(s => s.id === subject.id);
                
                if (!wasSelected) {
                    itemDiv.classList.add('border-green-500', 'bg-green-50');
                    itemDiv.classList.remove('border-gray-200');
                    selectedSubjects.push(subject);
                } else {
                    itemDiv.classList.remove('border-green-500', 'bg-green-50');
                    itemDiv.classList.add('border-gray-200');
                    selectedSubjects = selectedSubjects.filter(s => s.id !== subject.id);
                }
                updateSelectedSubjectsCount();
            });
            
            subjectsChecklist.appendChild(div);
        });
        
        updateSelectedSubjectsCount();
    };
    
    const updateSelectedSubjectsCount = () => {
        if (selectedSubjectsCountSpan) {
            selectedSubjectsCountSpan.textContent = `${selectedSubjects.length} selected`;
        }
        // Always enabled
        if (confirmSelectSubjectsBtn) {
            confirmSelectSubjectsBtn.disabled = false;
        }
    };
    
    const updateSelectedSubjectsList = () => {
        selectedSubjectsList.innerHTML = '';
        selectedSubjectsSection.classList.remove('hidden');
        
        if (selectedSubjects.length === 0) {
            selectedSubjectsSection.classList.add('hidden');
            return;
        }
        
        selectedSubjects.forEach(subject => {
            const div = document.createElement('div');
            div.className = 'p-4 flex justify-between items-center hover:bg-gray-50';
            div.innerHTML = `
                <div>
                    <p class="font-medium text-gray-900">${subject.subject_code} - ${subject.subject_name}</p>
                    <p class="text-sm text-gray-500">${subject.curriculum_name || selectedMemorandum?.curriculum_name || 'Curriculum'}</p>
                </div>
                <button class="text-red-500 hover:text-red-700 text-sm font-medium remove-subject-btn" data-id="${subject.id}">Remove</button>
            `;
            
            div.querySelector('.remove-subject-btn').addEventListener('click', () => {
                selectedSubjects = selectedSubjects.filter(s => s.id != subject.id);
                updateSelectedSubjectsList();
                // Also update eligibility for grading
                checkGradingEligibility();
            });
            
            selectedSubjectsList.appendChild(div);
        });
        
        checkGradingEligibility();
    };
    
    const checkGradingEligibility = () => {
        if (selectedSubjects.length > 0) {
            addGradeComponentBtn.disabled = false;
            toggleGradeComponents(false); // Enable grading form
            addGradeComponentBtn.style.display = '';
            document.querySelector('.curriculum-reminder-text').textContent = `✅ Ready to set grades for ${selectedSubjects.length} selected subject(s).`;
            document.querySelector('.curriculum-reminder-text').classList.remove('text-amber-600');
            document.querySelector('.curriculum-reminder-text').classList.add('text-green-600');
            
            // Auto-create first component if empty to save user a click
            if (accordionContainer.children.length === 0) {
                // Use setTimeout to ensure UI updates first and transition works
                setTimeout(() => {
                    // Check if strictly one major subject is selected (or at least one)
                    // The user requested: "i select the major subject... apply"
                    // Check if strictly one major subject is selected (or at least one)
                    // The user requested: "i select the major subject... apply"
                    // Removed applyTemplate logic, always open default component
                    addGradeComponentBtn.click();
                }, 100);
            }
        } else {
            addGradeComponentBtn.disabled = true;
            toggleGradeComponents(true); // Disable grading form
            document.querySelector('.curriculum-reminder-text').textContent = '⚠️ Select subjects to proceed';
            document.querySelector('.curriculum-reminder-text').classList.add('text-amber-600');
            document.querySelector('.curriculum-reminder-text').classList.remove('text-green-600');
        }
        calculateAndUpdateTotals();
    };

    const resetForm = () => {
        // Reset State
        selectedLevel = null;
        selectedMemorandum = null;
        selectedSubjects = [];
        
        // Reset UI Elements
        if (seniorHighBtn) {
            seniorHighBtn.classList.remove('border-purple-500', 'bg-purple-50');
            seniorHighBtn.classList.add('border-gray-300');
        }
        if (collegeBtn) {
            collegeBtn.classList.remove('border-blue-500', 'bg-blue-50');
            collegeBtn.classList.add('border-gray-300');
        }
        
        memorandumSection.classList.add('hidden');
        memorandumBtnText.textContent = 'Select Subject Category';
        memorandumBtnText.classList.remove('text-gray-900', 'font-bold');
        
        selectedSubjectsSection.classList.add('hidden');
        selectedSubjectsList.innerHTML = '';
        
        // Reset Grade Form
        accordionContainer.innerHTML = '';
        toggleGradeComponents(true);
        addGradeBtn.disabled = true;
        addGradeComponentBtn.disabled = true;
        addGradeComponentBtn.style.display = 'none'; // Hide initially
        
        document.querySelector('.curriculum-reminder-text').textContent = '⚠️ Please select a curriculum level first';
        document.querySelector('.curriculum-reminder-text').classList.add('text-amber-600');
        document.querySelector('.curriculum-reminder-text').classList.remove('text-green-600');
        
        hasUnsavedChanges = false;
        
        // Reset Date Fields
        const startInput = document.getElementById('effectivity-start-date');
        const endInput = document.getElementById('effectivity-end-date');
        if(startInput) startInput.value = '';
        if(endInput) endInput.value = '';

        calculateAndUpdateTotals();
    };

    // Global Filter State
    let historyStats = { curriculums: [], memorandums: [], subjects: [] };
    let currentHistoryView = 'curriculum'; // curriculum, memorandum, subject
    let currentHistoryFilter = 'all'; // all, college/ched, seniorhigh/deped, major, minor

    const refreshHistory = async () => {
        const container = document.getElementById('grade-history-container');
        if (container) container.innerHTML = '<p class="text-gray-500 text-center py-4">Loading history...</p>';
        
        try {
            // 1. Fetch Inputs
            const [allSubjectsItems, allCurriculumsItems] = await Promise.all([
                fetchAPI('subjects').catch(() => []),
                fetchAPI('curriculums').catch(() => [])
            ]);
            
            // Cleanup wrapped responses
            let allSubjects = Array.isArray(allSubjectsItems) ? allSubjectsItems : (allSubjectsItems.subjects || allSubjectsItems.data || []);
            let allCurriculums = Array.isArray(allCurriculumsItems) ? allCurriculumsItems : (allCurriculumsItems.data || []);
            
            // 2. Discover Curriculums IDs
            const curriculumIds = new Set();
            allCurriculums.forEach(c => curriculumIds.add(c.id));
            allSubjects.forEach(s => { if(s.curriculum_id) curriculumIds.add(s.curriculum_id); });
            
            // 3. Scan for Graded Status
            const results = await Promise.all(Array.from(curriculumIds).map(async currId => {
                try {
                     const data = await fetchAPI(`curriculum-grades/${currId}`);
                     return { curriculum: data.curriculum, subjects: data.subjects || [] };
                } catch (e) { return null; }
            }));
            
            // Check direct grades endpoint if available
            let directGrades = [];
            try { directGrades = await fetchAPI('grades'); } catch (e) {}

            const validResults = results.filter(r => r !== null);
            
            // 4. Process Data
            let pooledSubjects = [];
            let seenSubIds = new Set();
            let processedCurriculums = [];
            
            // Create a map of the latest curriculum data for reliable status checking
            const curriculumMap = new Map();
            allCurriculums.forEach(c => curriculumMap.set(c.id, c));
            
            validResults.forEach(res => {
                const subjects = res.subjects;
                const total = subjects.length;
                const gradedCount = subjects.filter(s => s.has_grades).length;
                
                // Classify Curriculum
                let c = res.curriculum;
                if (c) {
                    // Update 'c' with the latest data from allCurriculums to ensure version_status is correct
                    const latestData = curriculumMap.get(c.id);
                    if (latestData) {
                        c = { ...c, ...latestData };
                        // Ensure the relationship object also has the updated curriculum
                        res.curriculum = c;
                    }

                    // Heuristic for type
                    const isSHS = c.program_code && /SHS|STEM|ABM|HUMSS|GAS|TVL|Arts|Sports/i.test(c.program_code);
                    const type = c.curriculum_type === 'seniorhigh' || isSHS ? 'seniorhigh' : 'college';
                    
                    processedCurriculums.push({
                        ...c,
                        total_subjects: total,
                        graded_subjects: gradedCount,
                        percentage: total > 0 ? Math.round((gradedCount / total) * 100) : 0,
                        type: type
                    });
                }
                
                // Add to pool
                subjects.forEach(s => {
                    if (!seenSubIds.has(s.id)) {
                        // Merge with allSubjects to ensure 'memorandum' field exists
                        let finalSubject = s;
                        if (Array.isArray(allSubjects)) {
                             const full = allSubjects.find(sub => sub.id == s.id);
                             if (full) {
                                 // Preserve has_grades from 's', take memo from 'full'
                                 finalSubject = { ...full, ...s, memorandum: full.memorandum || s.memorandum };
                             }
                        }
                        
                        seenSubIds.add(s.id);
                        pooledSubjects.push(finalSubject);
                    }
                });
            });
            
            // Overlay direct grades
            if (Array.isArray(directGrades)) {
                directGrades.forEach(g => {
                    const subId = g.subject_id;
                    const existing = pooledSubjects.find(s => s.id == subId);
                    if (existing) {
                        existing.has_grades = true;
                        existing.effectivity_start_date = g.effectivity_start_date;
                        existing.effectivity_end_date = g.effectivity_end_date;
                        existing.subject_category = g.subject_category;
                    }
                    else {
                        const info = allSubjects.find(s => s.id == subId);
                        if (info) {
                            pooledSubjects.push({ 
                                ...info, 
                                has_grades: true,
                                effectivity_start_date: g.effectivity_start_date,
                                effectivity_end_date: g.effectivity_end_date,
                                subject_category: g.subject_category
                            });
                            seenSubIds.add(subId);
                        }
                    }
                });
            }
            
            // 5. Finalize Stats
            historyStats.subjects = pooledSubjects.filter(s => s.has_grades);
            historyStats.curriculums = processedCurriculums.filter(c => c.graded_subjects > 0);
            historyStats.raw_relationships = validResults; // Expose full subject-curriculum map for validation
            
            // Memorandums Logic
            const memoMap = {};
            const depEdPatterns = [
                /^Arts\s+\d/i, /^Business\s+\d/i, /^Economics\s+\d/i, /^Management\s+\d/i, 
                /^Engineering\s+\d/i, /^Health Science\s+\d/i, /^Social Science\s+\d/i, 
                /^Humanities\s+\d/i, /NC\s+(I|II|III|IV)/i, /DepEd/i, /K\s?to\s?12/i, /Curriculum Guide/i
            ];
            
            pooledSubjects.forEach(s => {
                const mName = s.memorandum;
                if (mName && mName !== 'N/A') {
                    if (!memoMap[mName]) {
                        // Classify Memorandum
                        const isDepEd = depEdPatterns.some(p => p.test(mName));
                        memoMap[mName] = { 
                            name: mName, total: 0, graded: 0, 
                            type: isDepEd ? 'seniorhigh' : 'college' 
                        };
                    }
                    memoMap[mName].total++;
                    if (s.has_grades) memoMap[mName].graded++;
                }
            });
            
            historyStats.memorandums = Object.values(memoMap)
                .filter(m => m.graded > 0)
                .map(m => ({
                    ...m,
                    percentage: m.total > 0 ? Math.round((m.graded / m.total) * 100) : 0
                }));
            
            renderHistory();
            
        } catch (e) {
            console.error('History Error', e);
            if (container) container.innerHTML = '<p class="text-red-500 text-center py-4">Error loading history.</p>';
        }
    };

    const renderHistory = () => {
        const container = document.getElementById('grade-history-container');
        if (!container) return;
        container.innerHTML = '';
        
        // Select Data Source
        let allItems = [];
        if (currentHistoryView === 'memorandum') allItems = historyStats.memorandums;
        else if (currentHistoryView === 'subject') allItems = historyStats.subjects;
        else allItems = historyStats.curriculums;

        // Custom Subject View Rendering with Grouping
        if (currentHistoryView === 'subject') {
            const levelFilterEl = document.getElementById('grade-history-level-filter');
            const categoryFilterEl = document.getElementById('grade-history-category-filter');
            
            const levelFilter = levelFilterEl ? levelFilterEl.value : 'college';
            
            // Filter by Level (CHED vs DepEd)
            const levelFilteredItems = allItems.filter(s => {
                 const sLevel = (s.year_level || '').toString().trim();
                 const sSyllabus = (s.syllabus_type || '').toLowerCase();
                 const isSHS = /^(Senior High|SHS|Grade 11|Grade 12)/i.test(sLevel) || sSyllabus === 'deped' || (s.curriculum_name && s.curriculum_name.includes('Senior High'));
                 
                 return levelFilter === 'senior_high' ? isSHS : !isSHS;
            });

            // Populate Category Options dynamically based on visible subjects
            if (categoryFilterEl) {
                // Check if we need to update options (detect level change or init)
                if (categoryFilterEl.dataset.currentLevel !== levelFilter) {
                    const uniqueCategories = [...new Set(levelFilteredItems.map(i => i.course_classification || i.subject_type || 'Others'))].sort();
                    
                    categoryFilterEl.innerHTML = '<option value="all">All Categories</option>';
                    uniqueCategories.forEach(cat => {
                        const opt = document.createElement('option');
                        opt.value = cat;
                        opt.textContent = cat;
                        categoryFilterEl.appendChild(opt);
                    });
                    
                    categoryFilterEl.dataset.currentLevel = levelFilter;
                    categoryFilterEl.value = 'all'; 
                }
            }

            // Filter by selected Category
            let finalItems = levelFilteredItems;
            if (categoryFilterEl && categoryFilterEl.value !== 'all') {
                finalItems = levelFilteredItems.filter(s => (s.course_classification || s.subject_type || 'Others') === categoryFilterEl.value);
            }

            if (finalItems.length === 0) {
                 container.innerHTML = `<p class="text-gray-500 text-sm text-center py-4">No graded subjects found matching criteria.</p>`;
                 return;
            }

            // Group by Category (course_classification)
            const groups = {};
            finalItems.forEach(item => {
                const cat = item.course_classification || item.subject_type || 'Others';
                if (!groups[cat]) groups[cat] = [];
                groups[cat].push(item);
            });

            // Render Groups
            Object.keys(groups).sort().forEach(category => {
                  const header = document.createElement('h5');
                  header.className = 'text-xs font-bold text-gray-500 uppercase tracking-widest mt-4 mb-2 pl-1 border-b border-gray-100 pb-1 sticky top-0 bg-white z-10';
                  header.textContent = category;
                  container.appendChild(header);

                  groups[category].forEach(item => {
                       const div = document.createElement('div');
                       div.className = 'p-3 border rounded-lg hover:bg-gray-50 mb-2 transition-colors cursor-pointer group bg-white shadow-sm';
                       
                       div.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-800 text-sm flex items-center gap-2">${item.subject_code}</p>
                                <p class="text-xs text-gray-600 truncate mt-0.5">${item.subject_name}</p>
                            </div>
                            <span class="text-[10px] font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded border border-green-100">Graded</span>
                        </div>
                       `;
                       div.addEventListener('dblclick', (e) => {
                           e.stopPropagation();
                           showGradeComponentDetails(item.id, item.subject_name, item.subject_code);
                       });
                       container.appendChild(div);
                  });
            });
            return; // Stop processing 'items.forEach' loop logic for other views
        }
        
        // --- Standard Logic for Curriculums / Memorandums ---
        let items = allItems;
        if (currentHistoryFilter !== 'all') {
            // Filter College/Senior High (mapped to 'college' / 'seniorhigh')
            items = items.filter(i => i.type === currentHistoryFilter); 
        }
        
        if (items.length === 0) {
            container.innerHTML = `<p class="text-gray-500 text-sm text-center py-4">No items found matching filter.</p>`;
            return;
        }
        
        items.forEach(item => {
            const div = document.createElement('div');
            div.className = 'p-3 border rounded-lg hover:bg-gray-50 mb-2 transition-colors cursor-pointer group';
            
            // Curriculum or Memorandum View (Already checked subject view above)
            const name = currentHistoryView === 'curriculum' ? (item.curriculum_name || item.program_code) : item.name;
            const percent = item.percentage;
            const countText = `${item.graded_subjects || item.graded} / ${item.total_subjects || item.total} Subjects`;
            const tagColor = item.type === 'seniorhigh' ? 'bg-orange-50 text-orange-600 border-orange-100' : 'bg-blue-50 text-blue-600 border-blue-100';
            const tagText = currentHistoryView === 'memorandum' 
                ? (item.type === 'seniorhigh' ? 'DepEd' : 'CHED') 
                : (item.type === 'seniorhigh' ? 'Senior High' : 'College');
            
            div.innerHTML = `
               <div class="flex flex-col h-full justify-between">
                    <div class="flex justify-between items-start gap-2 mb-2">
                         <h4 class="font-semibold text-gray-800 text-sm leading-tight line-clamp-2" title="${name}">${name}</h4>
                         <span class="text-[10px] font-bold px-2 py-0.5 rounded ${tagColor} border whitespace-nowrap">${tagText}</span>
                    </div>
                    
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-xs text-slate-500 font-medium">${countText}</span>
                        
                        <!-- Liquid Badge -->
                        <div class="relative overflow-hidden inline-flex items-center justify-center px-2.5 py-0.5 rounded-full border border-indigo-100 bg-white min-w-[65px] h-6 shadow-sm">
                            <div class="absolute bottom-0 left-0 w-full bg-indigo-100/80 transition-all duration-700 ease-out border-t border-indigo-200" 
                                 style="height: ${percent}%"></div>
                            <span class="relative z-10 text-[10px] font-bold ${percent >= 75 ? 'text-indigo-700' : 'text-slate-600'}">
                                ${percent}%
                            </span>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(div);
        });
    };

    // Add listener for new dropdowns
    const levelSelector = document.getElementById('grade-history-level-filter');
    const categorySelector = document.getElementById('grade-history-category-filter');
    
    if(levelSelector) {
        levelSelector.addEventListener('change', () => renderHistory());
    }
    if(categorySelector) {
        categorySelector.addEventListener('change', () => renderHistory());
    }
    
    // --- Unsaved Changes Protection ---
    let hasUnsavedChanges = false;

    const checkUnsavedChanges = async (callback) => {
        if (hasUnsavedChanges) {
             const result = await Swal.fire({
                title: 'Unsaved Changes',
                text: "You have unsaved changes. Are you sure you want to leave? Your progress will be lost.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, leave',
                cancelButtonText: 'Stay'
            });
            if (result.isConfirmed) {
                hasUnsavedChanges = false; // Prevent double warning
                callback();
            }
        } else {
            callback();
        }
    };

    // Native browser prompt for reload/close
    window.addEventListener('beforeunload', (e) => {
        if (hasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = ''; // Chrome requires returnValue to be set
        }
    });

    // Intercept all link clicks
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a');
        if (link && !link.target && !e.defaultPrevented) {
             // If it's a navigational link (has href, not just #)
             const href = link.getAttribute('href');
             if (href && href !== '#' && !href.startsWith('javascript:')) {
                 e.preventDefault();
                 checkUnsavedChanges(() => {
                     window.location.href = href;
                 });
             }
        }
    });

    // Overwrite existing event listeners with protection
    if (seniorHighBtn) seniorHighBtn.addEventListener('click', () => {
        checkUnsavedChanges(() => handleLevelSelection('Senior High'));
    });
    
    if (collegeBtn) collegeBtn.addEventListener('click', () => {
        checkUnsavedChanges(() => handleLevelSelection('College'));
    });

    // ------------------------------------

    // Initial Load
    setTimeout(refreshHistory, 500);

    // Filtering Logic
    const filterButtons = {
        all: document.getElementById('filter-all-btn'),
        college: document.getElementById('filter-college-btn'),
        seniorhigh: document.getElementById('filter-seniorhigh-btn'),
        sub_all: document.getElementById('subject-filter-all-btn'),
        sub_major: document.getElementById('subject-filter-major-btn'),
        sub_minor: document.getElementById('subject-filter-minor-btn')
    };
    
    const setFilter = (filter) => {
        currentHistoryFilter = filter;
        
        // Update Button Styles
        Object.values(filterButtons).forEach(btn => {
            if(!btn) return;
            btn.classList.remove('bg-indigo-600', 'text-white');
            btn.classList.add('bg-gray-200', 'text-gray-700');
        });
        
        let activeBtn = null;
        if (filter === 'all' && (currentHistoryView !== 'subject')) activeBtn = filterButtons.all;
        if (filter === 'college') activeBtn = filterButtons.college;
        if (filter === 'seniorhigh') activeBtn = filterButtons.seniorhigh;
        if (filter === 'all' && currentHistoryView === 'subject') activeBtn = filterButtons.sub_all;
        if (filter === 'major') activeBtn = filterButtons.sub_major;
        if (filter === 'minor') activeBtn = filterButtons.sub_minor;
        
        if (activeBtn) {
            activeBtn.classList.remove('bg-gray-200', 'text-gray-700');
            activeBtn.classList.add('bg-indigo-600', 'text-white');
        }
        
        renderHistory();
    };
    
    // Attach Filter Listeners
    if (filterButtons.all) filterButtons.all.onclick = () => setFilter('all');
    if (filterButtons.college) filterButtons.college.onclick = () => setFilter('college');
    if (filterButtons.seniorhigh) filterButtons.seniorhigh.onclick = () => setFilter('seniorhigh');
    if (filterButtons.sub_all) filterButtons.sub_all.onclick = () => setFilter('all');
    if (filterButtons.sub_major) filterButtons.sub_major.onclick = () => setFilter('major');
    if (filterButtons.sub_minor) filterButtons.sub_minor.onclick = () => setFilter('minor');

    const viewCurriculumBtn = document.getElementById('view-curriculum-btn');
    const viewMemorandumBtn = document.getElementById('view-memorandum-btn');
    const viewSubjectBtn = document.getElementById('view-subject-btn');
    
    const updateHistoryTabs = (view) => {
        currentHistoryView = view;
        currentHistoryFilter = 'all'; // Reset filter on view switch
        
        // Toggle Tab Styles
        [viewCurriculumBtn, viewMemorandumBtn, viewSubjectBtn].forEach(btn => {
            if (!btn) return;
            if (btn.dataset.view === view) {
                 btn.classList.add('bg-white', 'text-indigo-600', 'shadow-sm');
                 btn.classList.remove('text-gray-600', 'hover:text-gray-800');
            } else {
                 btn.classList.remove('bg-white', 'text-indigo-600', 'shadow-sm');
                 btn.classList.add('text-gray-600', 'hover:text-gray-800');
            }
        });
        
        // Toggle Filter Sections via CSS classes
        const currFilters = document.getElementById('curriculum-type-filters');
        const subFilters = document.getElementById('subject-type-filters');
        
        if (view === 'subject') {
            if(currFilters) currFilters.classList.add('hidden');
            if(subFilters) subFilters.classList.remove('hidden');
        } else {
            // Curriculum or Memorandum
            if(currFilters) {
                currFilters.classList.remove('hidden');
                
                const colBtn = document.getElementById('filter-college-btn');
                const shBtn = document.getElementById('filter-seniorhigh-btn');
                
                if (view === 'memorandum') {
                    if(colBtn) colBtn.textContent = 'CHED';
                    if(shBtn) shBtn.textContent = 'DepEd';
                } else {
                    if(colBtn) colBtn.textContent = 'College';
                    if(shBtn) shBtn.textContent = 'Senior High';
                }
            }
            if(subFilters) subFilters.classList.add('hidden');
        }
        
        setFilter('all'); 
    };
    
    if (viewCurriculumBtn) viewCurriculumBtn.onclick = () => updateHistoryTabs('curriculum');
    if (viewMemorandumBtn) viewMemorandumBtn.onclick = () => updateHistoryTabs('memorandum');
    if (viewSubjectBtn) viewSubjectBtn.onclick = () => updateHistoryTabs('subject');
    
    // Event Listeners
    selectMemorandumBtn.addEventListener('click', async () => {
        showModal('select-memorandum-modal');
        memorandumList.innerHTML = '<p class="text-gray-500 text-center py-8">Loading categories...</p>';
        memorandumSearchInput.value = '';
        memorandumSearchInput.focus();
        
        // populateSubjectCategories instead of fetchCurriculums
        populateSubjectCategories();
         
        // Search filtering using active categories
        memorandumSearchInput.oninput = (e) => {
            const term = e.target.value.toLowerCase();
            // Retrieve active categories from dataset if available, else fallback
            let categories = [];
            try {
                categories = JSON.parse(memorandumList.dataset.activeCategories || '[]');
            } catch(e) {
                categories = subjectCategories[selectedLevel] || [];
            }
            
            const filtered = categories.filter(c => c.toLowerCase().includes(term));
            
            memorandumList.innerHTML = '';
             // Header
            const header = document.createElement('h4');
            header.className = 'text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 pl-2';
            header.textContent = 'Subject Categories';
            memorandumList.appendChild(header);
            
            if (filtered.length === 0) {
                 const msg = document.createElement('p');
                 msg.className = 'text-gray-500 text-center py-4';
                 msg.textContent = 'No matching categories found.';
                 memorandumList.appendChild(msg);
                 return;
            }

            filtered.forEach(category => {
                const div = document.createElement('div');
                div.className = 'p-3 hover:bg-blue-50 rounded-lg cursor-pointer border border-transparent hover:border-blue-200 transition-colors duration-150 mb-1';
                div.innerHTML = `<p class="font-medium text-gray-800">${category}</p>`;
                div.addEventListener('click', () => {
                     handleCategorySelection(category);
                     hideModal('select-memorandum-modal');
                });
                memorandumList.appendChild(div);
            });
        };
    });
    if (closeSelectMemorandumModalBtn) closeSelectMemorandumModalBtn.addEventListener('click', () => hideModal('select-memorandum-modal'));
    if (closeSelectSubjectsModalBtn) closeSelectSubjectsModalBtn.addEventListener('click', () => hideModal('select-subjects-modal'));
    if (cancelSelectSubjectsBtn) cancelSelectSubjectsBtn.addEventListener('click', () => {
        hideModal('select-subjects-modal');
        
        // Reset Memorandum Selection since user cancelled
        memorandumBtnText.textContent = 'Select Subject Category';
        memorandumBtnText.classList.remove('text-gray-900', 'font-bold');
        
        // Reset Selected Subjects
        selectedSubjects = [];
        updateSelectedSubjectsList();
    });
    
    if (confirmSelectSubjectsBtn) confirmSelectSubjectsBtn.addEventListener('click', () => {
        // Use the FULL list of subjects for the category, regardless of what is currently filtered/visible in the UI.
        // This ensures "General Education" selects ALL General Education subjects, not just search results.
        selectedSubjects = [...currentCategorySubjects];
        
        console.log('Confirmed Selection (Full Category):', selectedSubjects.length);

        // Finalize (Check Dates, Load Template, Enable Grading Form)
        finalizeSubjectSelection();
    });

    const fetchGradeSetupForSubject = (subjectId) => {
        if (!subjectId) {
            loadGradeDataToDOM({});
            toggleGradeComponents(true);
            return;
        }
        currentSubjectId = subjectId;
        isEditMode = false; 
        updateGradeSetupBtn.classList.add('hidden'); 
        addGradeBtn.classList.remove('hidden');

        fetchAPI(`grades/${subjectId}`).then(data => {
            if (data && data.components && Object.keys(data.components).length > 0) {
                 loadGradeDataToDOM(data.components);
                 toggleGradeComponents(true); // Disable form if grade exists
                 addGradeBtn.disabled = true;
            } else {
                 loadGradeDataToDOM({});
                 toggleGradeComponents(false); // Enable form if no grade exists
                 addGradeBtn.disabled = false;
            }
            calculateAndUpdateTotals();
        }).catch(() => {
            loadGradeDataToDOM({});
            toggleGradeComponents(false);
            addGradeBtn.disabled = false;
            calculateAndUpdateTotals();
        });
    };
    
    const addSubjectToHistory = (subject) => {
            const noHistoryMessage = document.getElementById('no-history-message');
            if (noHistoryMessage) noHistoryMessage.remove();
            if (document.querySelector(`.grade-history-card[data-subject-id="${subject.id}"]`)) return;
            const card = document.createElement('div');
            card.className = 'grade-history-card p-4 border rounded-lg hover:bg-gray-50 transition-colors duration-200';
            card.dataset.subjectId = subject.id;
            card.innerHTML = `<p class="font-semibold text-gray-800">${subject.subject_name}</p><p class="text-sm text-gray-500">${subject.subject_code}</p>`;
            gradeHistoryContainer.appendChild(card);
        };
        
        accordionContainer.addEventListener('click', (e) => {
            // Check for remove button first to prevent accordion toggle
            if (e.target.closest('.remove-component-btn')) {
                handleDynamicEvents(e);
                return;
            }
            
            const toggleButton = e.target.closest('.accordion-toggle');
            if (toggleButton) {
                const content = toggleButton.nextElementSibling;
                const icon = toggleButton.querySelector('svg:last-child');
                const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';
                
                // This allows only one accordion to be open at a time.
                // If you want multiple, remove this block.
                document.querySelectorAll('.accordion-content').forEach(c => { 
                    if (c !== content) c.style.maxHeight = null;
                });
                document.querySelectorAll('.accordion-toggle svg:last-child').forEach(i => {
                    if (i !== icon) i.classList.remove('rotate-180');
                });

                if (!isOpen) {
                    content.style.maxHeight = content.scrollHeight + "px";
                    icon.classList.add('rotate-180');
                } else {
                    content.style.maxHeight = null;
                    icon.classList.remove('rotate-180');
                }
            } else {
                handleDynamicEvents(e);
            }
        });

        accordionContainer.addEventListener('input', calculateAndUpdateTotals);
        // Old subject selection event listener removed - now using curriculum-based workflow
        
        const updateSubjectSelectionUI = (subjectId) => {
            const reminderText = document.querySelector('.subject-reminder-text');
            const addButton = document.getElementById('add-grade-component-btn');
            
            if (subjectId) {
                // Subject is selected
                if (reminderText) {
                    reminderText.textContent = '✓ Subject selected. You can now add grade components.';
                    reminderText.className = 'text-sm text-green-600 font-medium mt-1 subject-reminder-text';
                }
                addButton.classList.remove('opacity-50', 'cursor-not-allowed');
                addButton.classList.add('hover:bg-indigo-50');
            } else {
                // No subject selected
                if (reminderText) {
                    reminderText.textContent = '⚠️ Please select a subject first before adding grade components';
                    reminderText.className = 'text-sm text-amber-600 font-medium mt-1 subject-reminder-text';
                }
                addButton.classList.add('opacity-50', 'cursor-not-allowed');
                addButton.classList.remove('hover:bg-indigo-50');
            }
        };
        
        addGradeBtn.addEventListener('click', () => {
            // Show confirmation modal
            document.getElementById('saveGradeSchemeModal').classList.remove('hidden');
        });

        // Handle the actual save logic when user confirms
        const handleGradeSchemeSave = async () => {
            if (!selectedSubjects || selectedSubjects.length === 0) {
                 Swal.fire('Error!', 'No subjects selected.', 'error');
                 return;
            }

            try {
                const components = getGradeDataFromDOM();
                let savedCount = 0;
                
                // Show loading state
                Swal.fire({
                    title: 'Saving Grade Schemes...',
                    text: `Please wait while we save the grade scheme for ${selectedSubjects.length} selected subjects.`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                for (const subject of selectedSubjects) {
                    try {
                        const payload = {
                            subject_id: subject.id,
                            curriculum_id: subject.curriculum_id || null, // Include curriculum_id if available
                            components,
                            effectivity_start_date: document.getElementById('effectivity-start-date')?.value || null,
                            effectivity_end_date: document.getElementById('effectivity-end-date')?.value || null,
                            subject_category: (selectedMemorandum && selectedMemorandum.name) ? selectedMemorandum.name : 'General' 
                        };
                        console.log('Saving payload:', payload);
                        await fetchAPI('grades', { method: 'POST', body: JSON.stringify(payload) });
                        savedCount++;
                    } catch (err) {
                        console.error(`Failed to save subject ${subject.id}`, err);
                    }
                }
                
                console.log(`Saved grade scheme for ${savedCount} subjects`);
                
                // Refresh History Panel stats
                await refreshHistory();
                
                // Show success message
                const successHtml = `
                    <div class="text-center px-4 pt-2 pb-4">
                        <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Grade Schemes Saved!</h3>
                        <p class="text-sm text-gray-500">Successfully applied grade scheme to ${savedCount} subject(s).</p>
                    </div>
                `;

                Swal.fire({
                    html: successHtml,
                    width: '380px',
                    timer: 3000,
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#10B981',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'rounded-2xl p-0 overflow-hidden',
                        actions: 'gap-3 mb-6',
                        confirmButton: 'w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none transition-colors shadow-sm mx-6'
                    }
                });
                
                // Reset UI
                hasUnsavedChanges = false;
                resetForm();
                
            } catch (e) {
                console.error('Failed to save grade schemes:', e);
                Swal.fire('Error!', 'Failed to save grade schemes: ' + e.message, 'error');
            }
        };

        // Modal event handlers
        document.getElementById('cancelSaveGradeScheme').addEventListener('click', () => {
            document.getElementById('saveGradeSchemeModal').classList.add('hidden');
        });
        
        document.getElementById('confirmSaveGradeScheme').addEventListener('click', () => {
            document.getElementById('saveGradeSchemeModal').classList.add('hidden');
            handleGradeSchemeSave();
        });
        
        document.getElementById('closeGradeSchemeSuccess').addEventListener('click', () => {
            document.getElementById('gradeSchemeSuccessModal').classList.add('hidden');
        });
        
        // Update modal event handlers
        document.getElementById('cancelUpdateGradeScheme').addEventListener('click', () => {
            document.getElementById('updateGradeSchemeModal').classList.add('hidden');
        });
        
        document.getElementById('confirmUpdateGradeScheme').addEventListener('click', () => {
            document.getElementById('updateGradeSchemeModal').classList.add('hidden');
            handleGradeSchemeUpdate();
        });
        

        
        document.getElementById('closeGradeSchemeUpdateSuccess').addEventListener('click', () => {
            document.getElementById('gradeSchemeUpdateSuccessModal').classList.add('hidden');
        });
        
        // Edit modal event handlers
        document.getElementById('cancelEditGradeScheme').addEventListener('click', () => {
            document.getElementById('editGradeSchemeModal').classList.add('hidden');
        });
        
        document.getElementById('confirmEditGradeScheme').addEventListener('click', () => {
            document.getElementById('editGradeSchemeModal').classList.add('hidden');
            handleGradeSchemeEdit();
        });

        editGradeSetupBtn.addEventListener('click', () => {
            // Close the grade details modal immediately
            hideModal('grade-modal');
            
            // Then show edit confirmation modal
            document.getElementById('editGradeSchemeModal').classList.remove('hidden');
        });

        // Function to load grade data for editing
        const loadGradeDataForUpdate = async (subjectId, components) => {
            try {
                console.log('Loading grade data for update:', { subjectId, components });
                
                // Fetch subject details to get subject name and code
                const subjectData = await fetchAPI(`subjects/${subjectId}`);
                console.log('Subject data received:', subjectData);
                
                // Switch to major courses mode
                currentCourseType = 'major';
                updateCourseTypeButtons('major');
                
                // Show major subject section
                majorSubjectSection.classList.remove('hidden');
                
                // Populate major subjects dropdown
                await populateMajorSubjects();
                
                // Select the subject
                majorSubjectSelect.value = subjectId;
                currentSubjectId = subjectId;
                
                // Update dropdown button text
                const selectedText = document.getElementById('major-subject-selected-text');
                if (selectedText) {
                    selectedText.textContent = `${subjectData.subject_name} (${subjectData.subject_code})`;
                    selectedText.classList.remove('text-gray-500');
                    selectedText.classList.add('text-gray-900');
                }
                
                // Close dropdown
                document.getElementById('major-subject-dropdown-menu').classList.add('hidden');
                
                // Load the grade components into the form
                loadGradeDataToDOM(components);
                
                // Enable grade components for editing
                toggleGradeComponents(false);
                addGradeComponentBtn.style.display = '';
                addGradeComponentBtn.disabled = false;
                
                // Update UI text
                document.querySelector('.curriculum-reminder-text').textContent = `✏️ Editing grades for ${subjectData.subject_name} - Make changes and click "Set Grade Scheme" to save`;
                
                // Calculate totals to enable/disable save button
                calculateAndUpdateTotals();
                
                console.log('Grade data loaded successfully for editing');
                
            } catch (error) {
                console.error('Error loading grade data for update:', error);
                throw error;
            }
        };

        // Handle the actual edit logic when user confirms
        const handleGradeSchemeEdit = async () => {
            if (!currentSubjectData) {
                console.error('No subject data available for editing');
                return;
            }
            
            try {
                console.log('Starting form population with data:', currentSubjectData);
                
                // Load the grade data for editing
                await loadGradeDataForUpdate(
                    currentSubjectData.subjectId,
                    currentSubjectData.components
                );
                
                console.log('Form successfully populated and ready for editing');
                
            } catch (error) {
                console.error('Error populating form:', error);
                Swal.fire('Error!', 'Failed to load subject data: ' + error.message, 'error');
            }
        };

    updateGradeSetupBtn.addEventListener('click', () => {
        // Show update confirmation modal
        document.getElementById('updateGradeSchemeModal').classList.remove('hidden');
    });

    // Handle the actual update logic when user confirms
    const handleGradeSchemeUpdate = async () => {
        const payload = { 
            subject_id: currentSubjectId, 
            components: getGradeDataFromDOM(),
            curriculum_id: currentCurriculumId,
            subject_category: (selectedMemorandum && selectedMemorandum.name) ? selectedMemorandum.name : (currentCourseType === 'minor' ? 'Minor' : 'General'), // Fallback if editing legacy
            effectivity_start_date: document.getElementById('effectivity-start-date')?.value || null,
            effectivity_end_date: document.getElementById('effectivity-end-date')?.value || null
        };
        try {
            const data = await fetchAPI('grades', { method: 'POST', body: JSON.stringify(payload) });
            
            // Show update success modal instead of SweetAlert
            document.getElementById('gradeSchemeUpdateSuccessModal').classList.remove('hidden');
            
            isEditMode = false;
            toggleGradeComponents(true);
            addGradeBtn.classList.remove('hidden');
            updateGradeSetupBtn.classList.add('hidden');
            addGradeBtn.disabled = true;
            
            // Re-enable form elements after successful update
            /* 
            if (curriculumSelect) {
                curriculumSelect.disabled = false;
                curriculumSelect.classList.remove('bg-gray-100', 'cursor-not-allowed', 'opacity-60');
            }
            */
            if (seniorHighBtn) {
                 seniorHighBtn.disabled = false;
                 seniorHighBtn.classList.remove('cursor-not-allowed', 'opacity-60');
            }
            if (collegeBtn) {
                 collegeBtn.disabled = false;
                 collegeBtn.classList.remove('cursor-not-allowed', 'opacity-60');
            }
        } catch (e) { 
            Swal.fire('Error!', 'Failed to update grade scheme: ' + e.message, 'error');
        }
    };

    gradeHistoryContainer.addEventListener('click', async (e) => {
        const card = e.target.closest('.grade-history-card');
        if (card) {
            const subjectId = card.dataset.subjectId;
            const curriculumId = card.dataset.curriculumId;
            
            // Only handle subject cards here, not curriculum cards
            // Curriculum cards have their own click handler
            if (!subjectId || curriculumId) {
                return; // This is a curriculum card, not a subject card
            }
            
            // This is a subject card - show grade component details
            try {
                const gradeData = await fetchAPI(`grades/${subjectId}`);
                
                // Check if gradeData and components exist
                if (!gradeData || !gradeData.components || Object.keys(gradeData.components).length === 0) {
                    modalContent.innerHTML = `
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 font-medium">No grade components found</p>
                            <p class="text-sm text-gray-500 mt-2">This subject doesn't have any grade scheme set up yet.</p>
                        </div>
                    `;
                    showModal('grade-modal');
                    return;
                }
                
                let contentHtml = '<div class="space-y-6">';
                for (const [period, data] of Object.entries(gradeData.components)) {
                    contentHtml += `
                        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                            <h4 class="font-bold text-lg capitalize text-gray-800 flex items-center gap-3 border-b pb-3 mb-3">
                                ${period} <span class="text-sm font-bold text-gray-500 ml-auto">${data.weight}%</span>
                            </h4>
                            <div class="flow-root">
                                <div class="-my-2 divide-y divide-gray-100">`;

                    if (!data.components || data.components.length === 0) {
                        contentHtml += '<p class="text-sm text-gray-500 py-3">No components for this period.</p>';
                    } else {
                        (data.components || []).forEach(comp => {
                            contentHtml += `
                                <div class="py-3">
                                    <div class="flex items-center justify-between gap-4">
                                        <p class="font-medium text-gray-700">${comp.name}</p>
                                        <p class="font-mono text-base text-gray-900">${comp.weight}%</p>
                                    </div>`;
                            if (comp.sub_components && comp.sub_components.length > 0) {
                                contentHtml += '<div class="mt-2 pl-6 border-l-2 border-gray-200 space-y-2">';
                                comp.sub_components.forEach(sub => {
                                    contentHtml += `
                                        <div class="flex items-center justify-between text-sm">
                                            <p class="text-gray-600">${sub.name}</p>
                                            <p class="font-mono text-gray-600">${sub.weight}%</p>
                                        </div>`;
                                });
                                contentHtml += '</div>';
                            }
                            contentHtml += '</div>';
                        });
                    }
                    contentHtml += `</div></div></div>`;
                }
                contentHtml += '</div>';

                modalContent.innerHTML = contentHtml;
                showModal('grade-modal');

            } catch (error) { 
                console.error('Error fetching grade details:', error);
                // Show user-friendly error message in modal
                modalContent.innerHTML = `
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-800 font-medium">Error Loading Grade Details</p>
                        <p class="text-sm text-gray-500 mt-2">Could not fetch grade details for this subject.</p>
                        <p class="text-xs text-gray-400 mt-1">${error.message || 'Unknown error'}</p>
                    </div>
                `;
                showModal('grade-modal');
            }
        }
    });
    
    closeModalBtn.addEventListener('click', () => hideModal('grade-modal'));
    gradeModal.addEventListener('click', (e) => { if (e.target.id === 'grade-modal') hideModal('grade-modal'); });

    // Fetch all subjects globally (not per curriculum)
    const fetchAllSubjects = async () => {
        try {
            console.log('Fetching all subjects from API...');
            const allSubjects = await fetchAPI('subjects');
            console.log('All subjects received:', allSubjects);
            
            // Store subjects globally
            currentCurriculumSubjects = allSubjects;
            
            // Update reminder text
            document.querySelector('.curriculum-reminder-text').textContent = '⚠️ Please select a course type to set up grades';
            
        } catch (error) {
            console.error('Error fetching subjects:', error);
            Swal.fire('Error!', 'Failed to fetch subjects', 'error');
        }
    };

    // Obsolete functions removed (handleCourseTypeSelection, populateMajorSubjects, etc.)

    const closeAllAccordions = () => {
        // Close all accordion sections
        document.querySelectorAll('.accordion-content').forEach(content => {
            content.style.maxHeight = null;
        });
        
        // Reset all chevron icons to closed state
        document.querySelectorAll('.accordion-toggle svg:last-child').forEach(icon => {
            icon.classList.remove('rotate-180');
        });
        
        console.log('All accordion sections closed');
    };


    

    
    // Function to show grade component details for graded subjects
    // Function to show grade component details for graded subjects
    async function showGradeComponentDetails(subjectId, subjectName, subjectCode) {
        try {
            const gradeData = await fetchAPI(`grades/${subjectId}/version-history`);
            
            if (!gradeData || !gradeData.current_version) {
                Swal.fire({ icon: 'error', title: 'No Data', text: 'No grade scheme found.', confirmButtonColor: '#4F46E5' });
                return;
            }

            const formatDate = (dateString) => new Date(dateString).toLocaleDateString('en-US', { 
                year: 'numeric', month: 'short', day: 'numeric'
            });

            // Render Helper
            const renderComponents = (components) => {
                if (!components || Object.keys(components).length === 0) {
                    return '<p class="text-gray-400 text-sm py-4 text-center">No grading components defined.</p>';
                }
                
                let html = '<div class="space-y-4">';
                Object.keys(components).forEach(period => {
                    const pData = components[period];
                    html += `
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <div class="bg-gray-50 px-5 py-3 border-b border-gray-200 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <h4 class="font-bold text-gray-700 text-sm">${period}</h4>
                                </div>
                                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">${pData.weight}%</span>
                            </div>
                            <div class="divide-y divide-gray-100 bg-white">`;
                    
                    (pData.components || []).forEach((comp) => {
                        html += `
                            <div class="px-5 py-3 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-center mb-1.5">
                                    <span class="text-sm font-medium text-gray-700">${comp.name}</span>
                                    <span class="text-sm font-bold text-gray-900">${comp.weight}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: ${comp.weight}%"></div>
                                </div>`;
                        
                        if (comp.sub_components && comp.sub_components.length > 0) {
                            html += '<div class="mt-3 pl-3 border-l-2 border-gray-100 space-y-2">';
                            comp.sub_components.forEach(sub => {
                                html += `
                                    <div class="flex flex-col gap-1">
                                        <div class="flex justify-between items-center">
                                            <span class="text-xs text-gray-500">↳ ${sub.name}</span>
                                            <span class="text-xs text-gray-500 font-mono">${sub.weight}%</span>
                                        </div>
                                    </div>`;
                            });
                            html += '</div>';
                        }
                        html += '</div>';
                    });
                    
                    html += `
                            </div>
                        </div>`;
                });
                html += '</div>';
                return html;
            };
            
            // Main Modal HTML
            let html = `
                <div class="text-left bg-white h-full">
                    <!-- Clean Header (Matches Page Theme) -->
                    <div class="px-6 py-5 border-b border-gray-100 flex items-start gap-4">
                        <div class="w-12 h-12 flex-shrink-0 bg-teal-100 text-teal-600 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800">${subjectCode}</h3>
                            <p class="text-sm text-gray-500">${subjectName}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                </span>
                                <span class="text-xs text-gray-400">• Updated ${formatDate(gradeData.current_version.updated_at)}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-6 py-6 max-h-[65vh] overflow-y-auto custom-scrollbar">
                        <!-- Current Version -->
                        <div class="mb-8">
                            <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                                Current Configuration
                            </h4>
                            ${renderComponents(gradeData.current_version.components)}
                        </div>
                        
                        <!-- Previous Versions (Simple Accordion) -->
                        ${gradeData.previous_versions && gradeData.previous_versions.length > 0 ? `
                            <div class="border-t border-gray-100 pt-6">
                                <details class="group">
                                    <summary class="list-none flex items-center justify-between cursor-pointer text-sm font-semibold text-gray-500 hover:text-indigo-600">
                                        <span>View Previous Versions (${gradeData.previous_versions.length})</span>
                                        <svg class="w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </summary>
                                    
                                    <div class="mt-4 space-y-4">
                                        ${gradeData.previous_versions.map((ver, idx) => `
                                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                                <div class="flex items-center justify-between mb-3 text-xs text-gray-500">
                                                    <span class="font-bold">Version ${gradeData.previous_versions.length - idx}</span>
                                                    <span>Ended: ${formatDate(ver.updated_at)}</span>
                                                </div>
                                                <div class="opacity-75">
                                                     ${renderComponents(ver.components)}
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>
                                </details>
                            </div>
                        ` : ''}
                    </div>
                </div>`;

            Swal.fire({
                html: html,
                width: '600px',
                showConfirmButton: false,
                showCloseButton: true,
                customClass: {
                    container: 'font-sans',
                    popup: 'rounded-2xl overflow-hidden',
                    closeButton: '!text-gray-400 hover:!text-gray-600 focus:!shadow-none'
                },
                padding: 0,
                background: '#ffffff'
            });

        } catch (error) {
            console.error('Details Error:', error);
            Swal.fire('Error', 'Failed to load details.', 'error');
        }
    };



    // Obsolete UI functions removed (updateCourseTypeButtons, resetCourseTypeButtons, updateCurriculumSelectionUI)

    const addCurriculumToHistory = (curriculum) => {
        const noHistoryMessage = document.getElementById('no-history-message');
        if (noHistoryMessage) noHistoryMessage.remove();
        
        // Check if curriculum already exists in history
        if (document.querySelector(`.grade-history-card[data-curriculum-id="${curriculum.id}"]`)) return;
        
        // Determine curriculum type based on multiple fields
        const programCode = (curriculum.program_code || '').toLowerCase();
        const curriculumName = (curriculum.curriculum_name || '').toLowerCase();
        
        // Check if it's Senior High based on various indicators
        const isSeniorHigh = programCode.includes('shs') || 
                            programCode.includes('senior') ||
                            programCode.includes('sh-') ||
                            programCode.includes('_sh') ||
                            curriculumName.includes('senior high') ||
                            curriculumName.includes('senior-high') ||
                            curriculumName.includes('shs') ||
                            // Common Senior High program codes
                            programCode.includes('humss') ||
                            programCode.includes('stem') ||
                            programCode.includes('abm') ||
                            programCode.includes('gas') ||
                            programCode.includes('tvl') ||
                            programCode.includes('ict-cp') ||
                            programCode.includes('he') ||
                            programCode.includes('ia');
        
        const curriculumType = curriculum.curriculum_type || (isSeniorHigh ? 'seniorhigh' : 'college');
        
        const typeBadge = curriculumType === 'seniorhigh' 
            ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-orange-700 bg-orange-100 rounded-full">Senior High</span>'
            : '<span class="inline-block px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">College</span>';
        
        const card = document.createElement('div');
        card.className = 'grade-history-card p-4 border rounded-lg hover:bg-gray-50 cursor-pointer';
        card.dataset.curriculumId = curriculum.id;
        card.dataset.curriculumType = curriculumType;
        card.dataset.curriculumName = curriculum.curriculum_name.toLowerCase();
        card.dataset.programCode = (curriculum.program_code || '').toLowerCase();
        card.innerHTML = `
            <div class="flex items-start justify-between gap-2 mb-2">
                <p class="font-semibold text-gray-800 flex-1">${curriculum.curriculum_name}</p>
                ${typeBadge}
            </div>
            <p class="text-sm text-gray-500">${curriculum.program_code} - ${curriculum.academic_year}</p>
        `;
        
        // Add click event to show curriculum grade modal
        card.addEventListener('click', () => showCurriculumGradeModal(curriculum.id));
        
        gradeHistoryContainer.appendChild(card);
    };



    const showCurriculumGradeModal = async (curriculumId) => {
        try {
            // Fetch curriculum details and subjects with grades
            console.log('Fetching curriculum grade details for:', curriculumId);
            let data = await fetchAPI(`curriculum-grades/${curriculumId}`);
            console.log('Curriculum grade details received:', data);
            
            // No auto-assignment - manual grade setup required through Update Minor Grades
            
            // Update modal title
            document.getElementById('curriculum-modal-title').textContent = data.curriculum.curriculum_name;
            document.getElementById('curriculum-modal-subtitle').textContent = `${data.curriculum.program_code} - Grade Schemes Overview`;
            
            // Populate minor subjects
            const minorContainer = document.getElementById('minor-subjects-container');
            const minorSubjects = data.subjects.filter(subject => (subject.subject_type || 'Minor') === 'Minor');
            
            if (minorSubjects.length > 0) {
                minorContainer.innerHTML = minorSubjects.map(subject => {
                    // All minor subjects should have grades now (auto-assigned)
                    const hasGrades = subject.has_grades;
                    const cardClass = 'subject-card p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors';
                    const statusText = 'Default grades applied';
                    const statusColor = 'text-blue-600';
                    
                    return `
                        <div class="${cardClass}" data-subject-id="${subject.id}" data-has-grades="true" data-subject-name="${subject.subject_name.toLowerCase()}" data-subject-code="${subject.subject_code.toLowerCase()}">
                            <p class="font-medium text-gray-800">${subject.subject_name}</p>
                            <p class="text-sm text-gray-500">${subject.subject_code}</p>
                            <p class="text-xs ${statusColor} mt-1">${statusText}</p>
                        </div>
                    `;
                }).join('');
            } else {
                minorContainer.innerHTML = '<p class="text-gray-500 text-sm" id="no-minor-subjects">No minor subjects found.</p>';
            }
            
            // Populate major subjects (Everything that is NOT Minor)
            const majorContainer = document.getElementById('major-subjects-container');
            // Treat NSTP, Research, OJT as "Major" in this view so they can be customized
            const majorSubjects = data.subjects.filter(subject => (subject.subject_type || 'Minor') !== 'Minor');
            
            if (majorSubjects.length > 0) {
                // Check grades for each major subject individually
                const majorSubjectCards = await Promise.all(majorSubjects.map(async (subject) => {
                    let hasGrades = false;
                    
                    try {
                        // Check if subject has grades by trying to fetch them
                        const gradeData = await fetchAPI(`grades/${subject.id}`);
                        hasGrades = gradeData && gradeData.components && Object.keys(gradeData.components).length > 0;
                        console.log(`Subject ${subject.subject_name} (ID: ${subject.id}) has grades:`, hasGrades);
                    } catch (error) {
                        // If fetch fails, subject doesn't have grades
                        hasGrades = false;
                        console.log(`Subject ${subject.subject_name} (ID: ${subject.id}) has no grades (fetch failed)`);
                    }
                    
                    const cardClass = hasGrades ? 'subject-card p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors' : 'subject-card p-3 border rounded-lg cursor-not-allowed transition-colors bg-gray-200 opacity-60';
                    const statusText = hasGrades ? 'Custom grades set' : 'No grades set';
                    const statusColor = hasGrades ? 'text-green-600' : 'text-gray-400';
                    
                    return `
                        <div class="${cardClass}" data-subject-id="${subject.id}" data-has-grades="${hasGrades}" data-subject-name="${subject.subject_name.toLowerCase()}" data-subject-code="${subject.subject_code.toLowerCase()}">
                            <p class="font-medium text-gray-800">${subject.subject_name}</p>
                            <p class="text-sm text-gray-500">${subject.subject_code}</p>
                            <p class="text-xs ${statusColor} mt-1">${statusText}</p>
                        </div>
                    `;
                }));
                
                majorContainer.innerHTML = majorSubjectCards.join('');
            } else {
                majorContainer.innerHTML = '<p class="text-gray-500 text-sm" id="no-major-subjects">No major subjects found.</p>';
            }
            
            // Add click events to subject cards (only for subjects with grades)
            document.querySelectorAll('.subject-card').forEach(card => {
                card.addEventListener('click', () => {
                    const hasGrades = card.dataset.hasGrades === 'true';
                    if (hasGrades) {
                        const subjectId = card.dataset.subjectId;
                        showSubjectGradeDetails(subjectId);
                    }
                });
            });
            
            // Add search functionality with debouncing for better performance
            const searchInput = document.getElementById('subject-search-input');
            searchInput.value = ''; // Clear search input when modal opens
            
            let subjectSearchDebounceTimer;
            const SUBJECT_SEARCH_DEBOUNCE = 300; // ms
            
            const performSubjectSearch = (searchTerm) => {
                const allSubjectCards = document.querySelectorAll('.subject-card');
                
                let minorVisible = 0;
                let majorVisible = 0;
                
                allSubjectCards.forEach(card => {
                    const subjectName = card.dataset.subjectName || '';
                    const subjectCode = card.dataset.subjectCode || '';
                    const isMinor = card.closest('#minor-subjects-container') !== null;
                    
                    // Check if search term matches name or code
                    const matches = subjectName.includes(searchTerm) || subjectCode.includes(searchTerm);
                    
                    if (matches || searchTerm === '') {
                        card.style.display = '';
                        if (isMinor) minorVisible++;
                        else majorVisible++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Show/hide "no results" messages
                const noMinorMsg = document.getElementById('no-minor-subjects');
                const noMajorMsg = document.getElementById('no-major-subjects');
                
                if (minorVisible === 0 && !noMinorMsg) {
                    minorContainer.innerHTML = '<p class="text-gray-500 text-sm" id="no-minor-results">No matching minor subjects found.</p>';
                } else if (minorVisible > 0) {
                    const noResultsMsg = document.getElementById('no-minor-results');
                    if (noResultsMsg) noResultsMsg.remove();
                }
                
                if (majorVisible === 0 && !noMajorMsg) {
                    majorContainer.innerHTML = '<p class="text-gray-500 text-sm" id="no-major-results">No matching major subjects found.</p>';
                } else if (majorVisible > 0) {
                    const noResultsMsg = document.getElementById('no-major-results');
                    if (noResultsMsg) noResultsMsg.remove();
                }
            };
            
            searchInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase().trim();
                
                // Clear previous timer and set new one (debouncing)
                clearTimeout(subjectSearchDebounceTimer);
                subjectSearchDebounceTimer = setTimeout(() => {
                    performSubjectSearch(searchTerm);
                }, SUBJECT_SEARCH_DEBOUNCE);
            });
            
            // Show modal
            showModal('curriculum-grade-modal');
            
        } catch (error) {
            console.error('Error fetching curriculum grade details:', error);
            // Remove the SweetAlert error and just log it
            console.log('Could not fetch curriculum grade details. This might be because the API endpoint needs to be implemented.');
        }
    };

    // Store current subject data for editing
    let currentSubjectData = null;
    
    const showSubjectGradeDetails = async (subjectId) => {
        try {
            console.log('Fetching subject grade version history for:', subjectId);
            const versionData = await fetchAPI(`grades/${subjectId}/version-history`);
            console.log('Subject grade version history received:', versionData);
            
            // Fetch subject details to get subject_type
            const subjectData = await fetchAPI(`subjects/${subjectId}`);
            
            // Store the subject data for later use when editing
            currentSubjectData = {
                subjectId: subjectId,
                curriculumId: versionData.current_version.curriculum_id,
                courseType: versionData.current_version.course_type, // 'minor' or 'major'
                subjectType: subjectData.subject_type, // 'Minor' or 'Major'
                components: versionData.current_version.components
            };
            
            // Build the grade details HTML with dropdown/accordion style
            let contentHtml = '<div class="space-y-3">';
            
            // Current Version Dropdown
            if (versionData.current_version && versionData.current_version.components) {
                const updatedDate = versionData.current_version.updated_at ? new Date(versionData.current_version.updated_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }) : '';
                
                contentHtml += `
                    <div class="border border-gray-200 rounded-lg bg-white shadow-sm overflow-hidden">
                        <button type="button" class="grade-version-toggle w-full px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors" data-target="current-version-content">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded">In Use</span>
                                <div class="text-left">
                                    <p class="text-sm font-semibold text-gray-800">Current Version</p>
                                    ${updatedDate ? `<p class="text-xs text-gray-500">Updated: ${updatedDate}</p>` : ''}
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-200 chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transform: rotate(180deg);">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="current-version-content" class="version-content border-t border-gray-200 bg-gray-50">
                            <div class="p-4 space-y-3">`;
                
                const components = versionData.current_version.components;
                for (const [period, periodData] of Object.entries(components)) {
                    contentHtml += `
                        <div class="bg-white border border-gray-200 rounded-lg p-3">
                            <h4 class="font-bold text-sm capitalize text-gray-800 flex items-center justify-between border-b pb-2 mb-2">
                                <span>${period}</span>
                                <span class="text-green-600">${periodData.weight}%</span>
                            </h4>`;

                    if (!periodData.components || periodData.components.length === 0) {
                        contentHtml += '<p class="text-xs text-gray-500 py-2">No components for this period.</p>';
                    } else {
                        periodData.components.forEach(comp => {
                            contentHtml += `
                                <div class="py-2 border-b border-gray-100 last:border-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-medium text-xs text-gray-700">${comp.name}</p>
                                        <p class="font-mono text-xs text-gray-900">${comp.weight}%</p>
                                    </div>`;
                            
                            if (comp.sub_components && comp.sub_components.length > 0) {
                                contentHtml += '<div class="mt-2 pl-3 border-l-2 border-gray-200 space-y-1">';
                                comp.sub_components.forEach(sub => {
                                    contentHtml += `
                                        <div class="flex items-center justify-between text-xs">
                                            <p class="text-gray-600">${sub.name}</p>
                                            <p class="font-mono text-gray-600">${sub.weight}%</p>
                                        </div>`;
                                });
                                contentHtml += '</div>';
                            }
                            contentHtml += '</div>';
                        });
                    }
                    contentHtml += `</div>`;
                }
                
                contentHtml += `
                            </div>
                        </div>
                    </div>`;
            }
            
            // Previous Versions (show all)
            const versions = Array.isArray(versionData.versions) ? versionData.versions : (versionData.previous_version ? [versionData.previous_version] : []);
            if (versions.length > 0) {
                versions.forEach(ver => {
                    const createdDate = ver.created_at ? new Date(ver.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }) : '';
                    const targetId = `previous-version-content-${ver.version_number}`;
                    contentHtml += `
                        <div class="border border-gray-200 rounded-lg bg-white shadow-sm overflow-hidden">
                            <button type="button" class="grade-version-toggle w-full px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors" data-target="${targetId}">
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded">Previous</span>
                                    <div class="text-left">
                                        <p class="text-sm font-semibold text-gray-800">Version ${ver.version_number}</p>
                                        ${createdDate ? `<p class="text-xs text-gray-500">${createdDate}</p>` : ''}
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200 chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="${targetId}" class="version-content hidden border-t border-gray-200 bg-gray-50">
                                <div class="p-4 space-y-3">`;
                    
                    if (ver.change_reason || ver.changed_by) {
                        contentHtml += `<div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-3">`;
                        if (ver.change_reason) {
                            contentHtml += `<p class="text-xs text-amber-800"><strong>Change Reason:</strong> ${ver.change_reason}</p>`;
                        }
                        if (ver.changed_by) {
                            contentHtml += `<p class="text-xs text-amber-700 mt-1"><strong>Changed By:</strong> ${ver.changed_by}</p>`;
                        }
                        contentHtml += `</div>`;
                    }
                    
                    const prevComponents = ver.components || {};
                    for (const [period, periodData] of Object.entries(prevComponents)) {
                        contentHtml += `
                            <div class="bg-white border border-gray-200 rounded-lg p-3">
                                <h4 class="font-bold text-sm capitalize text-gray-800 flex items-center justify-between border-b pb-2 mb-2">
                                    <span>${period}</span>
                                    <span class="text-amber-600">${periodData.weight}%</span>
                                </h4>`;
                        
                        if (!periodData.components || periodData.components.length === 0) {
                            contentHtml += '<p class="text-xs text-gray-500 py-2">No components for this period.</p>';
                        } else {
                            periodData.components.forEach(comp => {
                                contentHtml += `
                                    <div class="py-2 border-b border-gray-100 last:border-0">
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="font-medium text-xs text-gray-700">${comp.name}</p>
                                            <p class="font-mono text-xs text-gray-900">${comp.weight}%</p>
                                        </div>`;
                                
                                if (comp.sub_components && comp.sub_components.length > 0) {
                                    contentHtml += '<div class="mt-2 pl-3 border-l-2 border-gray-200 space-y-1">';
                                    comp.sub_components.forEach(sub => {
                                        contentHtml += `
                                            <div class="flex items-center justify-between text-xs">
                                                <p class="text-gray-600">${sub.name}</p>
                                                <p class="font-mono text-gray-600">${sub.weight}%</p>
                                            </div>`;
                                    });
                                    contentHtml += '</div>';
                                }
                                contentHtml += '</div>';
                            });
                        }
                        contentHtml += `</div>`;
                    }
                    
                    contentHtml += `
                                </div>
                            </div>
                        </div>`;
                });
            } else {
                contentHtml += `
                    <div class="border border-gray-200 rounded-lg bg-white shadow-sm overflow-hidden">
                        <div class="px-4 py-3 flex items-center gap-3 bg-gray-50">
                            <span class="px-2 py-1 bg-gray-200 text-gray-600 text-xs font-semibold rounded">Previous</span>
                            <p class="text-sm text-gray-600">No previous version available - This is the original version</p>
                        </div>
                    </div>`;
            }
            
            contentHtml += '</div>';
            
            // Populate the modal content
            modalContent.innerHTML = contentHtml;
            
            // Add click event listeners to toggle dropdowns
            document.querySelectorAll('.grade-version-toggle').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetContent = document.getElementById(targetId);
                    const chevron = this.querySelector('.chevron-icon');
                    
                    if (targetContent.classList.contains('hidden')) {
                        targetContent.classList.remove('hidden');
                        chevron.style.transform = 'rotate(180deg)';
                    } else {
                        targetContent.classList.add('hidden');
                        chevron.style.transform = 'rotate(0deg)';
                    }
                });
            });
            
            // Close curriculum modal first
            hideModal('curriculum-grade-modal');
            
            // Show the grade details modal
            showModal('grade-modal');
            
            // Hide Update button for minor subjects (since their grades are locked)
            const updateButton = document.getElementById('edit-grade-setup-btn');
            if (updateButton) {
                if (subjectData.subject_type === 'Minor') {
                    updateButton.style.display = 'none';
                    console.log('Update button hidden for minor subject');
                } else {
                    updateButton.style.display = '';
                    console.log('Update button shown for major subject');
                }
            }
            
        } catch (error) {
            console.error('Error fetching subject grade version history:', error);
            // Show user-friendly message when subject has no grades
            Swal.fire({
                title: 'No Grades Set',
                text: 'This subject does not have any grade scheme configured yet. Please set up grades for this subject first.',
                icon: 'info',
                confirmButtonText: 'OK',
                confirmButtonColor: '#4f46e5'
            });
        }
    };

    // Function to fetch and display all curriculums in history (OPTIMIZED)
    const fetchAndPopulateGradeHistory = async () => {
        try {
            console.log('Fetching all curriculums for history...');
            
            // Clear the container first
            gradeHistoryContainer.innerHTML = '';
            
            const allCurriculums = await fetchAPI('curriculums');
            console.log('All curriculums received:', allCurriculums);
            
            if (allCurriculums && allCurriculums.length > 0) {
                console.log('Found', allCurriculums.length, 'curriculums');
                
                // OPTIMIZED: Directly add curriculums without fetching subjects
                // Subjects are only fetched when user clicks on a curriculum
                allCurriculums.forEach(curriculum => {
                    addCurriculumToHistory({
                        id: curriculum.id,
                        curriculum_name: curriculum.curriculum || curriculum.curriculum_name || 'Unknown Curriculum',
                        program_code: curriculum.program_code || 'N/A',
                        academic_year: curriculum.academic_year || curriculum.year || 'N/A',
                        curriculum_type: curriculum.curriculum_type || curriculum.type || null
                    });
                });
            } else {
                console.log('No curriculums found');
                const noHistoryMessage = document.getElementById('no-history-message');
                if (!noHistoryMessage) {
                    const message = document.createElement('p');
                    message.id = 'no-history-message';
                    message.className = 'text-gray-500';
                    message.textContent = 'No curriculums available.';
                    gradeHistoryContainer.appendChild(message);
                }
            }
        } catch (error) {
            console.error('Error fetching curriculums for history:', error);
            console.error('Error details:', error.message);
            const noHistoryMessage = document.getElementById('no-history-message');
            if (!noHistoryMessage) {
                const message = document.createElement('p');
                message.id = 'no-history-message';
                message.className = 'text-gray-500';
                message.textContent = 'Error loading curriculums.';
                gradeHistoryContainer.appendChild(message);
            }
        }
    };

    // View mode and filter functionality
    const curriculumSearchInput = document.getElementById('curriculum-search');
    const viewModeButtons = document.querySelectorAll('.view-mode-btn');
    const curriculumTypeFilters = document.getElementById('curriculum-type-filters');
    const subjectTypeFilters = document.getElementById('subject-type-filters');
    const curriculumFilterButtons = document.querySelectorAll('.curriculum-filter-btn');
    const subjectFilterButtons = document.querySelectorAll('.subject-filter-btn');
    let currentViewMode = 'curriculum';
    let currentFilter = 'all';
    
    const filterAndSearchCurriculums = () => {
        const searchTerm = curriculumSearchInput.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.grade-history-card');
        let visibleCount = 0;
        
        cards.forEach(card => {
            const curriculumName = card.dataset.curriculumName || '';
            const programCode = card.dataset.programCode || '';
            const curriculumType = card.dataset.curriculumType || '';
            
            // Check filter match
            const filterMatch = currentFilter === 'all' || curriculumType === currentFilter;
            
            // Check search match
            const searchMatch = searchTerm === '' || 
                               curriculumName.includes(searchTerm) || 
                               programCode.includes(searchTerm);
            
            if (filterMatch && searchMatch) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        const noHistoryMessage = document.getElementById('no-history-message');
        if (visibleCount === 0 && cards.length > 0) {
            if (!noHistoryMessage) {
                const message = document.createElement('p');
                message.id = 'no-history-message';
                message.className = 'text-gray-500';
                message.textContent = 'No curriculums match your search or filter.';
                gradeHistoryContainer.appendChild(message);
            }
        } else if (noHistoryMessage && visibleCount > 0) {
            noHistoryMessage.remove();
        }
    };
    
    // Function to display all subjects (OPTIMIZED)
    const displayAllSubjects = async () => {
        try {
            gradeHistoryContainer.innerHTML = '';
            const response = await fetchAPI('subjects');
            const allSubjects = response.subjects || response.data || [];
            
            if (allSubjects && allSubjects.length > 0) {
                // OPTIMIZED: Display all subjects immediately without checking grades
                // Grade status will be checked only when user clicks on a subject
                allSubjects.forEach(subject => {
                    const card = document.createElement('div');
                    
                    // Default styling - we'll check grades on click
                    card.className = 'subject-history-card p-4 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors';
                    
                    card.dataset.subjectId = subject.id;
                    card.dataset.subjectType = subject.subject_type.toLowerCase();
                    card.dataset.subjectName = subject.subject_name.toLowerCase();
                    card.dataset.subjectCode = (subject.subject_code || '').toLowerCase();
                    
                    const typeBadge = subject.subject_type === 'Major'
                        ? '<span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Major</span>'
                        : '<span class="inline-block px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">Minor</span>';
                    
                    card.innerHTML = `
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <p class="font-semibold text-gray-800 flex-1">${subject.subject_name}</p>
                            <div class="flex gap-1">
                                ${typeBadge}
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">${subject.subject_code} - ${subject.subject_unit} units</p>
                    `;
                    
                    // Add double-click event to show subject grade details
                    card.addEventListener('dblclick', () => showSubjectGradeDetails(subject.id));
                    
                    gradeHistoryContainer.appendChild(card);
                });
            } else {
                gradeHistoryContainer.innerHTML = '<p class="text-gray-500">No subjects found.</p>';
            }
        } catch (error) {
            console.error('Error fetching subjects:', error);
            gradeHistoryContainer.innerHTML = '<p class="text-gray-500">Error loading subjects.</p>';
        }
    };
    
    // Function to filter subjects
    const filterAndSearchSubjects = () => {
        const searchTerm = curriculumSearchInput.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.subject-history-card');
        let visibleCount = 0;
        
        cards.forEach(card => {
            const subjectName = card.dataset.subjectName || '';
            const subjectCode = card.dataset.subjectCode || '';
            const subjectType = card.dataset.subjectType || '';
            
            // Check filter match
            const filterMatch = currentFilter === 'all' || subjectType === currentFilter;
            
            // Check search match
            const searchMatch = searchTerm === '' || 
                               subjectName.includes(searchTerm) || 
                               subjectCode.includes(searchTerm);
            
            if (filterMatch && searchMatch) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0 && cards.length > 0) {
            if (!document.getElementById('no-results-message')) {
                const message = document.createElement('p');
                message.id = 'no-results-message';
                message.className = 'text-gray-500';
                message.textContent = 'No subjects match your search or filter.';
                gradeHistoryContainer.appendChild(message);
            }
        } else {
            const noResultsMsg = document.getElementById('no-results-message');
            if (noResultsMsg) noResultsMsg.remove();
        }
    };
    
    // View mode switching
    viewModeButtons.forEach(button => {
        button.addEventListener('click', async () => {
            // Clear container immediately to prevent transition/overlap issues
            gradeHistoryContainer.innerHTML = '';
            
            // Update active button styling
            viewModeButtons.forEach(btn => {
                btn.classList.remove('bg-white', 'text-indigo-600', 'shadow-sm');
                btn.classList.add('text-gray-600', 'hover:text-gray-800');
            });
            button.classList.remove('text-gray-600', 'hover:text-gray-800');
            button.classList.add('bg-white', 'text-indigo-600', 'shadow-sm');
            
            // Update current view mode
            currentViewMode = button.dataset.view;
            currentFilter = 'all'; // Reset filter
            curriculumSearchInput.value = ''; // Clear search
            
            if (currentViewMode === 'curriculum') {
                // Show curriculum filters, hide subject filters
                curriculumTypeFilters.classList.remove('hidden');
                subjectTypeFilters.classList.add('hidden');
                
                // Update Title
                document.getElementById('grade-history-title').textContent = 'Curriculum Grade History';
                
                // Reset curriculum filter buttons
                curriculumFilterButtons.forEach(btn => {
                    btn.classList.remove('bg-indigo-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                });
                document.getElementById('filter-all-btn').classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                document.getElementById('filter-all-btn').classList.add('bg-indigo-600', 'text-white');
                
                // Display curriculums
                await fetchAndPopulateGradeHistory();
            } else {
                // Show subject filters, hide curriculum filters
                curriculumTypeFilters.classList.add('hidden');
                subjectTypeFilters.classList.remove('hidden');
                
                // Update Title
                document.getElementById('grade-history-title').textContent = 'Subject Grade History';
                
                // Reset subject filter buttons
                subjectFilterButtons.forEach(btn => {
                    btn.classList.remove('bg-indigo-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                });
                document.getElementById('subject-filter-all-btn').classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                document.getElementById('subject-filter-all-btn').classList.add('bg-indigo-600', 'text-white');
                
                // Display all subjects
                await displayAllSubjects();
            }
        });
    });
    
    // Search input event listener with debouncing
    let curriculumSearchDebounceTimer;
    const CURRICULUM_SEARCH_DEBOUNCE = 300; // ms
    
    curriculumSearchInput.addEventListener('input', () => {
        clearTimeout(curriculumSearchDebounceTimer);
        curriculumSearchDebounceTimer = setTimeout(() => {
            if (currentViewMode === 'curriculum') {
                filterAndSearchCurriculums();
            } else {
                filterAndSearchSubjects();
            }
        }, CURRICULUM_SEARCH_DEBOUNCE);
    });
    
    // Curriculum filter button event listeners
    curriculumFilterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Update active button styling
            curriculumFilterButtons.forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            });
            button.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            button.classList.add('bg-indigo-600', 'text-white');
            
            // Update current filter
            currentFilter = button.dataset.filter;
            
            // Apply filter
            filterAndSearchCurriculums();
        });
    });
    
    // Subject filter button event listeners
    subjectFilterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Update active button styling
            subjectFilterButtons.forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            });
            button.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            button.classList.add('bg-indigo-600', 'text-white');
            
            // Update current filter
            currentFilter = button.dataset.filter;
            
            // Apply filter
            filterAndSearchSubjects();
        });
    });


    
    // Select Minor Courses Modal Functionality

    const cancelSelectMinorBtn = document.getElementById('cancel-select-minor-btn');
    const confirmSelectMinorBtn = document.getElementById('confirm-select-minor-btn');
    const minorCoursesChecklist = document.getElementById('minor-courses-checklist');
    const selectAllCheckbox = document.getElementById('select-all-minor-courses');
    const selectedCountSpan = document.getElementById('selected-count');
    const minorCourseSearch = document.getElementById('minor-course-search');
    

    
    // Update Minor Grades Button - Show Select Minor Courses Modal
    selectMinorSubjectBtn.addEventListener('click', () => {
        // Populate the checklist with minor courses
        const minorSubjects = currentCurriculumSubjects.filter(subject => subject.subject_type === 'Minor');
        
        if (minorSubjects.length === 0) {
            minorCoursesChecklist.innerHTML = '<p class="text-gray-500 text-center py-8">No minor courses found.</p>';
        } else {
            minorCoursesChecklist.innerHTML = minorSubjects.map(subject => `
                <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors minor-course-item" data-subject-id="${subject.id}" data-subject-name="${subject.subject_name.toLowerCase()}" data-subject-code="${subject.subject_code.toLowerCase()}">
                    <input type="checkbox" class="minor-course-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" value="${subject.id}">
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">${subject.subject_name}</p>
                        <p class="text-sm text-gray-500">${subject.subject_code}</p>
                    </div>
                </label>
            `).join('');
        }
        
        selectedMinorCourses = [];
        updateSelectedCount();
        selectAllCheckbox.checked = false;
        confirmSelectMinorBtn.disabled = true;
        
        selectMinorCoursesModal.classList.remove('hidden');
    });
    

    
    // Modify Set Grade Scheme button behavior for minor courses
    // Now when Set Grade Scheme is clicked for minor courses, save to the previously selected courses
    const originalSetGradeHandler = addGradeBtn.onclick;
    addGradeBtn.addEventListener('click', (e) => {
        // If we're in minor course mode and grades are unlocked, save to selected courses
        if (currentCourseType === 'minor' && minorGradesUnlocked) {
            e.preventDefault();
            e.stopPropagation();
            
            // Show confirmation modal
            document.getElementById('saveGradeSchemeModal').classList.remove('hidden');
            return false;
        }
        // For major courses, let the normal flow continue
    });
    
    // Close modal handlers
    closeSelectMinorModalBtn.addEventListener('click', () => {
        selectMinorCoursesModal.classList.add('hidden');
    });
    
    cancelSelectMinorBtn.addEventListener('click', () => {
        selectMinorCoursesModal.classList.add('hidden');
    });
    
    selectMinorCoursesModal.addEventListener('click', (e) => {
        if (e.target.id === 'select-minor-courses-modal') {
            selectMinorCoursesModal.classList.add('hidden');
        }
    });
    
    // Handle checkbox changes
    minorCoursesChecklist.addEventListener('change', (e) => {
        if (e.target.classList.contains('minor-course-checkbox')) {
            updateSelectedCourses();
        }
    });
    
    // Select all functionality
    selectAllCheckbox.addEventListener('change', (e) => {
        const checkboxes = minorCoursesChecklist.querySelectorAll('.minor-course-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
        updateSelectedCourses();
    });
    
    // Search functionality
    minorCourseSearch.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const items = minorCoursesChecklist.querySelectorAll('.minor-course-item');
        
        items.forEach(item => {
            const name = item.dataset.subjectName;
            const code = item.dataset.subjectCode;
            const matches = name.includes(searchTerm) || code.includes(searchTerm);
            item.style.display = matches ? 'flex' : 'none';
        });
    });
    
    function updateSelectedCourses() {
        const checkboxes = minorCoursesChecklist.querySelectorAll('.minor-course-checkbox:checked');
        selectedMinorCourses = Array.from(checkboxes).map(cb => cb.value);
        updateSelectedCount();
        confirmSelectMinorBtn.disabled = selectedMinorCourses.length === 0;
        
        // Update select all checkbox state
        const allCheckboxes = minorCoursesChecklist.querySelectorAll('.minor-course-checkbox');
        selectAllCheckbox.checked = allCheckboxes.length > 0 && selectedMinorCourses.length === allCheckboxes.length;
    }
    
    function updateSelectedCount() {
        selectedCountSpan.textContent = `${selectedMinorCourses.length} selected`;
    }
    
    // Confirm selection - now unlocks grade components instead of applying grades
    confirmSelectMinorBtn.addEventListener('click', async () => {
        if (selectedMinorCourses.length === 0) return;
        
        selectMinorCoursesModal.classList.add('hidden');
        
        // Store selected courses for later use when saving
        window.selectedMinorCoursesForGrading = selectedMinorCourses;
        
        // Unlock grade components for editing
        minorGradesUnlocked = true;
        toggleGradeComponents(false);
        addGradeComponentBtn.style.display = ''; // Show add component button
        
        // Update button UI
        minorSubjectBtnText.textContent = `${selectedMinorCourses.length} selected`;
        minorSubjectCountBadge.textContent = `${selectedMinorCourses.length} selected`;
        minorSubjectCountBadge.classList.remove('hidden');
        
        // Ensure section remains visible (logic in handleCourseTypeSelection covers this, but good to ensure)
        
        // Show success notification
        Swal.fire({
            icon: 'success',
            title: 'Subjects Selected!',
            text: `${selectedMinorCourses.length} minor course(s) selected. You can now set up grade components.`,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
        
        // Update reminder text
        document.querySelector('.curriculum-reminder-text').textContent = `✏️ ${selectedMinorCourses.length} minor subject(s) selected - Set up grade components and click "Set Grade Scheme" to save`;
        
        // Calculate totals to determine if Set Grade Scheme button should be enabled
        calculateAndUpdateTotals();
    });

    
    // Initialize global subject-based workflow
    fetchAllSubjects(); // Fetch all subjects globally
    fetchAndPopulateGradeHistory(); // Keep curriculum history on the right side
    loadGradeDataToDOM({});
    toggleGradeComponents(true);
    
    // Event Listeners for course type selection
    minorCoursesBtn.addEventListener('click', () => handleCourseTypeSelection('minor'));
    majorCoursesBtn.addEventListener('click', () => handleCourseTypeSelection('major'));
    selectMajorSubjectBtn.addEventListener('click', () => {
        selectMajorSubjectsModal.classList.remove('hidden');
        populateMajorSubjectsChecklist();
    });
    
    closeCurriculumModalBtn.addEventListener('click', () => hideModal('curriculum-grade-modal'));
    curriculumGradeModal.addEventListener('click', (e) => { 
        if (e.target.id === 'curriculum-grade-modal') hideModal('curriculum-grade-modal'); 
    });
    
    // Major Subject Modal Event Listeners
    closeSelectMajorModalBtn.addEventListener('click', () => selectMajorSubjectsModal.classList.add('hidden'));
    cancelSelectMajorBtn.addEventListener('click', () => selectMajorSubjectsModal.classList.add('hidden'));
    selectMajorSubjectsModal.addEventListener('click', (e) => {
        if (e.target.id === 'select-major-subjects-modal') selectMajorSubjectsModal.classList.add('hidden');
    });

    majorSubjectSearchInput.addEventListener('input', (e) => populateMajorSubjectsChecklist(e.target.value));
    
    selectAllMajorSubjectsCheckbox.addEventListener('change', (e) => {
        const checkboxes = document.querySelectorAll('.major-subject-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = e.target.checked;
        });
        updateSelectedMajorCount();
        confirmSelectMajorBtn.disabled = document.querySelectorAll('.major-subject-checkbox:checked').length === 0;
    });
    
    confirmSelectMajorBtn.addEventListener('click', () => {
        const checkboxes = document.querySelectorAll('.major-subject-checkbox:checked');
        selectedMajorSubjects = [];
        
        checkboxes.forEach(cb => {
            selectedMajorSubjects.push({
                subject_id: cb.value,
                subject_code: cb.dataset.code,
                subject_description: cb.dataset.description
            });
        });
        
        if (selectedMajorSubjects.length === 0) return;
        
        selectMajorSubjectsModal.classList.add('hidden');
        
        // Update UI
        majorSubjectBtnText.textContent = `${selectedMajorSubjects.length} Major Subject(s) Selected`;
        majorSubjectCountBadge.textContent = `${selectedMajorSubjects.length} selected`;
        majorSubjectCountBadge.classList.remove('hidden');
        
        // Store selected courses (aliasing to minor variable for consistency if needed, or keeping separate)
        // window.selectedMajorCoursesForGrading = selectedMajorSubjects; 
        
        // Unlock grade components
        minorGradesUnlocked = true; // Reusing this flag or create a new one 'gradingUnlocked'
        toggleGradeComponents(false);
        
        // Add default components if empty
        if (accordionContainer.children.length === 0) {
            accordionContainer.innerHTML = '';
            // Add typical major course components (Midterm/Final or Prelim/Mid/Pre-Fi/Fi)
            accordionContainer.appendChild(createGradeComponent('Midterm Grade', 50));
            accordionContainer.appendChild(createGradeComponent('Final Grade', 50));
        }
        
        calculateAndUpdateTotals();
        
        Swal.fire({
            icon: 'success',
            title: 'Subjects Selected!',
            text: `${selectedSubjects.length} subject(s) selected.`,
            toast: true,
            position: 'top-end',
            timer: 3000,
            showConfirmButton: false
        });
    });

    // Sync History Card Height with Setup Card
    const setupCard = document.getElementById('grade-setup-card');
    const historyCard = document.getElementById('grade-history-card-main');

    if (setupCard && historyCard) {
        const resizeObserver = new ResizeObserver(entries => {
            for (let entry of entries) {
                // Use offsetHeight to include padding and borders
                historyCard.style.height = `${entry.target.offsetHeight}px`;
            }
        });
        resizeObserver.observe(setupCard);
    }
});
</script>


@endsection