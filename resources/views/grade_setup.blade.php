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

                {{-- Curriculum Selection (Unlocks for College) --}}
                <div id="memorandum-section" class="mt-8 border border-gray-200 bg-gray-50/50 p-6 rounded-xl hidden">
                    <div class="flex items-center gap-3 pb-3 mb-4">
                        <div class="w-10 h-10 flex-shrink-0 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-700">Curriculum</h2>
                    </div>
                    <div>
                        <button id="select-memorandum-btn" type="button" class="w-full flex items-center justify-between gap-2 bg-white hover:bg-blue-50 text-gray-700 font-semibold py-3 px-4 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 border border-blue-300">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                                <span id="memorandum-btn-text">Select Curriculum</span>
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




                {{-- Grade Components --}}
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-3 pb-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 flex-shrink-0 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M12 21a9 9 0 110-18 9 9 0 010 18z" /></svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-700">Semestral Grade Components</h2>
                                <p class="text-sm text-amber-600 font-medium mt-1 curriculum-reminder-text">⚠️ Please select a curriculum first to set up grades</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">

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

                    {{-- Template Selection --}}
                    <div class="mt-6 border-t border-gray-200 pt-6">
                         <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-700">Select Subject Area (Standard Template)</h3>
                            <div class="relative inline-block text-left">
                                <button type="button" id="template-dropdown-btn" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Select Template
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div id="template-dropdown-menu" class="origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10 transition-all duration-200 opacity-0 transform scale-95">
                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="template-dropdown-btn">
                                        <button type="button" class="template-option block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-template="gen_ed">
                                            <span class="font-bold block">General Education</span>
                                            <span class="text-xs text-gray-500">CS 40% | Proj 25% | Exam 35%</span>
                                        </button>
                                        <button type="button" class="template-option block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-template="prof_lab">
                                            <span class="font-bold block">Professional - Laboratory</span>
                                            <span class="text-xs text-gray-500">CS 35% | Proj 40% | Exam 25%</span>
                                        </button>
                                         <button type="button" class="template-option block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-template="prof_non_lab">
                                            <span class="font-bold block">Professional - Non-Laboratory</span>
                                            <span class="text-xs text-gray-500">CS 40% | Proj 35% | Exam 25%</span>
                                        </button>
                                        <button type="button" class="template-option block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-template="prof_board">
                                            <span class="font-bold block">Professional - Board Courses</span>
                                            <span class="text-xs text-gray-500">CS 40% | Proj 30% | Exam 30%</span>
                                        </button>
                                        <button type="button" class="template-option block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" data-template="prof_non_board">
                                            <span class="font-bold block">Professional - Non-Board</span>
                                            <span class="text-xs text-gray-500">CS 35% | Proj 40% | Exam 25%</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                         </div>
                         <p class="text-xs text-gray-500 mb-4">Note: Applying a template will overwrite any existing grade components.</p>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-gray-200">
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
            
            {{-- Subject Type Filter Buttons (for subject view) --}}
            <div id="subject-type-filters" class="mb-4 flex gap-2 hidden">
                <button 
                    id="subject-filter-all-btn" 
                    class="subject-filter-btn flex-1 px-3 py-2 text-xs font-medium rounded-lg transition-colors bg-indigo-600 text-white"
                    data-filter="all"
                >
                    All
                </button>
                <button 
                    id="subject-filter-major-btn" 
                    class="subject-filter-btn flex-1 px-3 py-2 text-xs font-medium rounded-lg transition-colors bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="major"
                >
                    Major
                </button>
                <button 
                    id="subject-filter-minor-btn" 
                    class="subject-filter-btn flex-1 px-3 py-2 text-xs font-medium rounded-lg transition-colors bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="minor"
                >
                    Minor
                </button>
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
        <div class="flex justify-end p-5 bg-white border-t border-gray-200 rounded-b-2xl">
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
                        <h3 class="text-xl font-bold text-gray-800">Select Curriculum</h3>
                        <p class="text-sm text-gray-600">Choose a curriculum to view its associated subjects</p>
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
                        <h3 class="text-xl font-bold text-gray-800">Select Subjects</h3>
                        <p class="text-sm text-gray-600">Select the subjects you want to set up grades for</p>
                    </div>
                </div>
                <button id="close-select-subjects-modal-btn" class="text-gray-400 hover:text-gray-700 transition-colors rounded-full p-1 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 max-h-[60vh] overflow-y-auto">
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="select-all-subjects" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <span class="text-sm font-semibold text-gray-700">Select All</span>
                        </label>
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
                <button id="cancel-select-subjects-btn" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button id="confirm-select-subjects-btn" class="px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Confirm Selection
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
    if (confirmSelectSubjectsBtn) {
        confirmSelectSubjectsBtn.addEventListener('click', () => {
             console.log('Confirm button clicked');
             console.log('Current selectedSubjects:', selectedSubjects);

             // Re-evaluate graded status just to be safe
             const gradedSubjects = selectedSubjects.filter(s => {
                 const isGraded = s.is_graded || historyStats.subjects.some(h => h.id === s.id);
                 return isGraded;
             });
             
             console.log('Graded subjects found:', gradedSubjects);
             
             if (gradedSubjects.length > 0) {
                 // Alert: Cannot update graded subjects if active
                 Swal.fire({
                     icon: 'error',
                     title: 'Action Restricted',
                     text: 'The curriculum is still in use or active. You cannot update the subject grade unless the curriculum has reached the end date.',
                     confirmButtonText: 'OK',
                     confirmButtonColor: '#EF4444',
                     customClass: {
                         popup: 'rounded-2xl',
                         confirmButton: 'px-6 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none transition-colors shadow-sm'
                     }
                 }).then(() => {
                     // Reset everything to enforce lock
                     hideModal('select-subjects-modal');
                     
                     selectedMemorandum = null;
                     if (typeof memorandumBtnText !== 'undefined') {
                        memorandumBtnText.textContent = 'Select Memorandum';
                        memorandumBtnText.classList.remove('text-gray-900', 'font-bold');
                     }
                     
                     selectedSubjects = [];
                     updateSelectedSubjectsList();
                     
                     if (typeof accordionContainer !== 'undefined') accordionContainer.innerHTML = '';
                     checkGradingEligibility();
                 });
             } else {
                 console.log('No graded subjects, proceeding directly.');
                 updateSelectedSubjectsList();
                 hideModal('select-subjects-modal');
             }
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

    // Template Definitions
    const templates = {
        gen_ed: {
            periods: [
                 { name: 'Prelim', weight: 30 },
                 { name: 'Midterm', weight: 30 },
                 { name: 'Finals', weight: 40 }
            ],
            components: [
                {
                    name: 'Class Standing',
                    weight: 40,
                    sub_components: [
                        { name: 'Attendance (Att.) - F2F', weight: 7 },
                        { name: 'Attendance (Att.) - Online', weight: 3 },
                        { name: 'Written Works (WW) - F2F', weight: 33 },
                        { name: 'Written Works (WW) - Online', weight: 17 },
                        { name: 'Performance Tasks (PT) - F2F', weight: 27 },
                        { name: 'Performance Tasks (PT) - Online', weight: 13 }
                    ]
                },
                {
                    name: 'Project',
                    weight: 25,
                    sub_components: [
                        { name: 'Course-based Output (CBO)', weight: 100 }
                    ]
                },
                {
                    name: 'Examination',
                    weight: 35,
                    sub_components: [
                        { name: 'Written Examination (WE)', weight: 100 }
                    ]
                }
            ]
        },
        prof_lab: {
             periods: [
                 { name: 'Prelim', weight: 30 },
                 { name: 'Midterm', weight: 30 },
                 { name: 'Finals', weight: 40 }
            ],
            components: [
                {
                     name: 'Class Standing',
                     weight: 35,
                     sub_components: [
                        { name: 'Attendance (Att.) - F2F', weight: 7 },
                        { name: 'Attendance (Att.) - Online', weight: 3 },
                        { name: 'Written Works (WW) - F2F', weight: 27 },
                        { name: 'Written Works (WW) - Online', weight: 13 },
                        { name: 'Performance Tasks (PT) - F2F', weight: 33 },
                        { name: 'Performance Tasks (PT) - Online', weight: 17 }
                     ]
                },
                {
                    name: 'Project',
                    weight: 40,
                    sub_components: [ {name: 'Course-based Output (CBO)', weight: 100} ]
                },
                {
                    name: 'Examination',
                    weight: 25,
                    sub_components: [ {name: 'Written Examination (WE)', weight: 100} ]
                }
            ]
        },
        permanent: {
            periods: [
                 { name: 'Prelim', weight: 30 },
                 { name: 'Midterm', weight: 30 },
                 { name: 'Finals', weight: 40 }
            ],
            components: [
                {
                     name: 'Class Standing',
                     weight: 40,
                     sub_components: [
                        { name: 'Attendance (Att.) - F2F', weight: 7 },
                        { name: 'Attendance (Att.) - Online', weight: 3 },
                        { name: 'Written Works (WW) - F2F', weight: 27 },
                        { name: 'Written Works (WW) - Online', weight: 13 },
                        { name: 'Performance Tasks (PT) - F2F', weight: 33 },
                        { name: 'Performance Tasks (PT) - Online', weight: 17 }
                     ]
                },
                {
                    name: 'Project',
                    weight: 30,
                    sub_components: [ {name: 'Course-based Output (CBO)', weight: 100} ]
                },
                 {
                    name: 'Examination',
                    weight: 30,
                    sub_components: [ {name: 'Written Examination (WE)', weight: 100} ]
                }
            ]
        },
        prof_non_lab: {
            periods: [
                 { name: 'Prelim', weight: 30 },
                 { name: 'Midterm', weight: 30 },
                 { name: 'Finals', weight: 40 }
            ],
            components: [
                {
                     name: 'Class Standing',
                     weight: 40,
                     sub_components: [
                        { name: 'Attendance (Att.) - F2F', weight: 7 },
                        { name: 'Attendance (Att.) - Online', weight: 3 },
                        { name: 'Written Works (WW) - F2F', weight: 27 },
                        { name: 'Written Works (WW) - Online', weight: 13 },
                        { name: 'Performance Tasks (PT) - F2F', weight: 33 },
                        { name: 'Performance Tasks (PT) - Online', weight: 17 }
                     ]
                },
                {
                    name: 'Project',
                    weight: 35,
                    sub_components: [ {name: 'Course-based Output (CBO)', weight: 100} ]
                },
                {
                    name: 'Examination',
                    weight: 25,
                    sub_components: [ {name: 'Written Examination (WE)', weight: 100} ]
                }
            ]
        },
        permanent: {
            periods: [
                 { name: 'Prelim', weight: 30 },
                 { name: 'Midterm', weight: 30 },
                 { name: 'Finals', weight: 40 }
            ],
            components: [
                {
                     name: 'Class Standing',
                     weight: 40,
                     sub_components: [
                        { name: 'Attendance (Att.) - F2F', weight: 7 },
                        { name: 'Attendance (Att.) - Online', weight: 3 },
                        { name: 'Written Works (WW) - F2F', weight: 27 },
                        { name: 'Written Works (WW) - Online', weight: 13 },
                        { name: 'Performance Tasks (PT) - F2F', weight: 33 },
                        { name: 'Performance Tasks (PT) - Online', weight: 17 }
                     ]
                },
                {
                    name: 'Project',
                    weight: 30,
                    sub_components: [ {name: 'Course-based Output (CBO)', weight: 100} ]
                },
                 {
                    name: 'Examination',
                    weight: 30,
                    sub_components: [ {name: 'Written Examination (WE)', weight: 100} ]
                }
            ]
        },
        prof_board: {
            periods: [
                 { name: 'Prelim', weight: 30 },
                 { name: 'Midterm', weight: 30 },
                 { name: 'Finals', weight: 40 }
            ],
            components: [
                {
                     name: 'Class Standing',
                     weight: 40,
                     sub_components: [
                         { name: 'Attendance (Att.) - F2F', weight: 7 },
                         { name: 'Attendance (Att.) - Online', weight: 3 },
                         { name: 'Written Works (WW) - F2F', weight: 40 },
                         { name: 'Written Works (WW) - Online', weight: 0 },
                         { name: 'Performance Tasks (PT) - F2F', weight: 50 },
                         { name: 'Performance Tasks (PT) - Online', weight: 0 }
                     ]
                },
                {
                    name: 'Project',
                    weight: 30,
                    sub_components: [ {name: 'Course-based Output (CBO)', weight: 100} ]
                },
                 {
                    name: 'Examination',
                    weight: 30,
                    sub_components: [ {name: 'Written Examination (WE)', weight: 100} ]
                }
            ]
        },
        prof_non_board: {
            periods: [
                 { name: 'Prelim', weight: 30 },
                 { name: 'Midterm', weight: 30 },
                 { name: 'Finals', weight: 40 }
            ],
            components: [
                {
                     name: 'Class Standing',
                     weight: 35,
                     sub_components: [
                        { name: 'Attendance (Att.) - F2F', weight: 7 },
                        { name: 'Attendance (Att.) - Online', weight: 3 },
                        { name: 'Written Works (WW) - F2F', weight: 27 },
                        { name: 'Written Works (WW) - Online', weight: 13 },
                        { name: 'Performance Tasks (PT) - F2F', weight: 33 },
                        { name: 'Performance Tasks (PT) - Online', weight: 17 }
                     ]
                },
                {
                    name: 'Project',
                    weight: 40,
                    sub_components: [ {name: 'Course-based Output (CBO)', weight: 100} ]
                },
                {
                    name: 'Examination',
                    weight: 25,
                    sub_components: [ {name: 'Written Examination (WE)', weight: 100} ]
                }
            ]
        },
        permanent: {
            periods: [
                 { name: 'Prelim', weight: 30 },
                 { name: 'Midterm', weight: 30 },
                 { name: 'Finals', weight: 40 }
            ],
            components: [
                {
                     name: 'Class Standing',
                     weight: 0,
                     sub_components: [
                        { name: 'Attendance (Att.) - F2F', weight: 0 },
                        { name: 'Attendance (Att.) - Online', weight: 0 },
                        { name: 'Written Works (WW) - F2F', weight: 0 },
                        { name: 'Written Works (WW) - Online', weight: 0 },
                        { name: 'Performance Tasks (PT) - F2F', weight: 0 },
                        { name: 'Performance Tasks (PT) - Online', weight: 0 }
                     ]
                },
                {
                    name: 'Project',
                    weight: 0,
                    sub_components: [ {name: 'Course-based Output (CBO)', weight: 0} ]
                },
                 {
                    name: 'Examination',
                    weight: 0,
                    sub_components: [ {name: 'Written Examination (WE)', weight: 0} ]
                }
            ]
        }
    };

    const applyTemplate = (templateKey) => {
        const template = templates[templateKey];
        if (!template) return;

        accordionContainer.innerHTML = ''; // Clear existing

        template.periods.forEach(period => {
             const newComponent = createGradeComponent(period.name, period.weight, template.components);
             accordionContainer.appendChild(newComponent);
        });

        calculateAndUpdateTotals();
    };

    // Template Dropdown Logic
    const templateBtn = document.getElementById('template-dropdown-btn');
    const templateMenu = document.getElementById('template-dropdown-menu');

    if (templateBtn && templateMenu) {
        templateBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = templateMenu.classList.contains('hidden');
            if (isHidden) {
                templateMenu.classList.remove('hidden');
                setTimeout(() => {
                    templateMenu.classList.remove('opacity-0', 'scale-95');
                    templateMenu.classList.add('opacity-100', 'scale-100');
                }, 10);
            } else {
                templateMenu.classList.remove('opacity-100', 'scale-100');
                templateMenu.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    templateMenu.classList.add('hidden');
                }, 200);
            }
        });

        document.addEventListener('click', (e) => {
            if (!templateMenu.contains(e.target) && !templateBtn.contains(e.target)) {
                 templateMenu.classList.remove('opacity-100', 'scale-100');
                 templateMenu.classList.add('opacity-0', 'scale-95');
                 setTimeout(() => {
                    templateMenu.classList.add('hidden');
                }, 200);
            }
        });

        document.querySelectorAll('.template-option').forEach(btn => {
            btn.addEventListener('click', () => {
                const templateKey = btn.dataset.template;
                
                // Confirm Overwrite
                if (accordionContainer.children.length > 0) {
                     Swal.fire({
                        title: 'Apply Template?',
                        text: "This will overwrite your current grade components. Continue?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4f46e5',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, apply it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                             applyTemplate(templateKey);
                             templateMenu.classList.add('hidden'); // Close menu
                        }
                    });
                } else {
                    applyTemplate(templateKey);
                    templateMenu.classList.add('hidden');
                }
            });
        });
    }

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
        // Use short-circuiting carefully but variables in the second clause must be defined
        const hasLegacyValidSelection = safeCourseType && 
            (safeCourseType === 'minor' || (safeCourseType === 'major' && safeSubjectId));
            
        const hasValidSelection = (selectedSubjects && selectedSubjects.length > 0) || hasLegacyValidSelection;
        
        // For minor courses, also check if grades are unlocked
        const minorGradesReady = !safeCourseType || safeCourseType !== 'minor' || safeMinorGradesUnlocked;
        
        // Enable Set Grade Scheme button when totals are correct, valid selection exists, and minor grades are ready
        const saveButtonIsDisabled = semestralTotal !== 100 || !allSubTotalsCorrect || !hasValidSelection || !minorGradesReady;
        addGradeBtn.disabled = saveButtonIsDisabled;
        updateGradeSetupBtn.disabled = saveButtonIsDisabled;
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
        } else {
            collegeBtn.classList.add('border-blue-500', 'bg-blue-50');
            collegeBtn.classList.remove('border-gray-300');
            seniorHighBtn.classList.remove('border-purple-500', 'bg-purple-50');
            seniorHighBtn.classList.add('border-gray-300');
        }

        // Reset subsequent steps
        selectedMemorandum = null;
        selectedSubjects = [];
        memorandumBtnText.textContent = 'Select Curriculum';
        selectedSubjectsSection.classList.add('hidden');
        selectedSubjectsList.innerHTML = '';
        
        // Unlock Memorandum Section
        memorandumSection.classList.remove('hidden');
        
        // Fetch Curriculums immediately to check
        // We will fetch when modal opens, but good to know if we can pre-load
    };

    const fetchCurriculums = async () => {
        try {
            const curriculums = await fetchAPI('curriculums');
            
            console.log('Filtering Curriculums for Level:', selectedLevel);
            
            const filtered = curriculums.filter(c => {
                // Robustly get year level
                const rawLevel = c.year_level || c.yearLevel || '';
                const level = String(rawLevel).trim();
                
                const isSeniorHigh = /^Senior High|^SHS/i.test(level);
                
                // 1. Level Check
                if (selectedLevel === 'Senior High') {
                    if (!isSeniorHigh) return false;
                } else {
                    // College = Not Senior High
                    if (isSeniorHigh) return false;
                }
                
                // 2. Status Check: ONLY Processing
                // "only the processing curriculum will display"
                // "approve curriculum and old curriculum will not display"
                const status = (c.approval_status || '').toLowerCase();
                const version = (c.version_status || '').toLowerCase();
                
                // Strict check for 'processing'
                if (status !== 'processing') return false;
                
                // Redundant safety check for 'old' (though processing usually isn't old)
                if (version === 'old') return false;

                // 3. Expiration Check
                // "meet their end data" -> Must NOT be expired
                if (c.expiration_date) {
                    const expDate = new Date(c.expiration_date);
                    const now = new Date();
                    // Reset time part to ensure we only look at the date for fairness (optional, but safer)
                    // If expiration is end of day? Usually backend stores date or datetime.
                    // Assuming simpler check: if NOW > expDate, it's expired.
                    if (now > expDate) return false; 
                }
                
                // 4. Date Check: Remove invalid dates where Start > End
                // (Sanity check for bad data like 2027-2026)
                if (c.academic_year) {
                     const parts = c.academic_year.split('-');
                     if (parts.length === 2) {
                         const start = parseInt(parts[0]);
                         const end = parseInt(parts[1]);
                         if (!isNaN(start) && !isNaN(end)) {
                             // If Start Year is greater than End Year, it's invalid
                             if (start > end) return false;
                         }
                     }
                }
                
                return true;
            });
            
            return filtered.sort((a, b) => (a.curriculum_name || '').localeCompare(b.curriculum_name || ''));
        } catch (error) {
            console.error('Error fetching curriculums:', error);
            Swal.fire('Error', 'Failed to fetch curriculums', 'error');
            return [];
        }
    };
    
    const populateCurriculumList = (curriculums) => {
        memorandumList.innerHTML = '';

        // Minor Subjects Header
        const minorHeader = document.createElement('h4');
        minorHeader.className = 'text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 pl-2';
        minorHeader.textContent = 'Minor Subjects';
        memorandumList.appendChild(minorHeader);

        // Add General Education Option
        const genEdDiv = document.createElement('div');
        genEdDiv.className = 'p-3 hover:bg-green-50 rounded-lg cursor-pointer border border-transparent hover:border-green-200 transition-colors duration-150 mb-3 border-b border-gray-100 pb-3';
        
        const genEdTitle = selectedLevel === 'Senior High' ? 'General Education - Senior High' : 'General Education - College';
        
        genEdDiv.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.168 18.477 18.582 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <p class="font-bold text-gray-800">${genEdTitle}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Manage all minor/general education subjects for ${selectedLevel}</p>
                </div>
            </div>
        `;
        
        genEdDiv.addEventListener('click', () => {
             handleGenEdSelection(selectedLevel);
             hideModal('select-memorandum-modal');
        });
        
        memorandumList.appendChild(genEdDiv);

        if (curriculums.length === 0) {
            const msg = document.createElement('p');
            msg.className = 'text-gray-500 text-center py-4';
            msg.textContent = 'No specific curriculums found for this level.';
            memorandumList.appendChild(msg);
            return;
        }

        // Major Subjects Header
        const majorHeader = document.createElement('h4');
        majorHeader.className = 'text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4 pl-2';
        majorHeader.textContent = 'Major Subjects';
        memorandumList.appendChild(majorHeader);
        
        curriculums.forEach(curriculum => {
            const div = document.createElement('div');
            // Blue styling for curriculum items
            div.className = 'p-3 hover:bg-blue-50 rounded-lg cursor-pointer border border-transparent hover:border-blue-200 transition-colors duration-150';
            
            // Format display text
            let displayText = curriculum.curriculum_name;
            if (curriculum.program_code) displayText += ` (${curriculum.program_code})`;
            
            // Only show academic year if not Senior High (as per previous patterns, though user said "all listed there")
            if (curriculum.year_level !== 'Senior High' && curriculum.academic_year) {
                displayText += ` - ${curriculum.academic_year}`;
            }
            // If user wants to see statuses like "Approved" etc, we can add a badge? 
            // User requested "all curriculum will listed there".
            // Let's just show the name clearly.
            
            div.innerHTML = `<p class="font-medium text-gray-800">${displayText}</p>`;
            
            div.addEventListener('click', () => {
                handleCurriculumSelection(curriculum);
                hideModal('select-memorandum-modal');
            });
            memorandumList.appendChild(div);
        });
    };

    const handleGenEdSelection = async (level) => {
        const title = `General Education - ${level}`;
        selectedMemorandum = { id: 'GEN_ED_' + level, curriculum_name: title, is_gen_ed: true };
        
        memorandumBtnText.textContent = title;
        memorandumBtnText.classList.add('text-gray-900', 'font-bold');
        
        // Immediately trigger subject selection modal with flag
        await openSubjectsModal(null, true); 
    };
    
    const handleCurriculumSelection = async (curriculum) => {
        selectedMemorandum = curriculum; // We keep the variable name 'selectedMemorandum' internally to avoid massive diffs, or we can update it. Let's update usage.
        
        let displayText = curriculum.curriculum_name;
        if (curriculum.program_code) displayText += ` (${curriculum.program_code})`;
        if (curriculum.year_level !== 'Senior High' && curriculum.academic_year) displayText += ` - ${curriculum.academic_year}`;

        memorandumBtnText.textContent = displayText;
        memorandumBtnText.classList.add('text-gray-900', 'font-bold');
        
        // Immediately trigger subject selection modal
        await openSubjectsModal(curriculum, false);
    };
    
    const openSubjectsModal = async (curriculum, isGenEd = false) => {
        showModal('select-subjects-modal');
        subjectsChecklist.innerHTML = '<p class="text-gray-500 text-center py-8">Loading subjects...</p>';
        confirmSelectSubjectsBtn.disabled = true;
        
        let subjects = [];
        if (isGenEd) {
             subjects = await fetchGenEdSubjects(selectedLevel);
        } else {
             subjects = await fetchSubjectsByCurriculum(curriculum.id);
        }
        populateSubjectsChecklist(subjects);
    };
    
    const fetchGenEdSubjects = async (level) => {
        try {
            // Fetch all subjects
            // Note: If this list is huge, we should optimize backend. But for now we use the existing endpoint.
            const allSubjects = await fetchAPI('subjects');
            
            return allSubjects.filter(s => {
                 // Check if Minor
                 const isMinor = (s.subject_type || '').toLowerCase() === 'minor';
                 if (!isMinor) return false;
                 
                 // Check Level
                 // Use Regex for robust match, OR check if syllabus_type is 'DepEd'
                 const sLevel = (s.year_level || '').toString().trim();
                 const sSyllabus = (s.syllabus_type || '').toLowerCase();
                 const isSHS = /^(Senior High|SHS|Grade 11|Grade 12)/i.test(sLevel) || sSyllabus === 'deped';
                 
                 if (level === 'Senior High') return isSHS;
                 return !isSHS; // College
            });
        } catch (error) {
            console.error('Error fetching Gen Ed subjects:', error);
            return [];
        }
    };
    
    const fetchSubjectsByCurriculum = async (curriculumId) => {
         try {
            // New Endpoint: /api/curriculums/{id}/subjects
            // Logic: This endpoint (CurriculumController@getCurriculumSubjects) returns subjects linked to the curriculum.
            // Note: If the curriculum has NO subjects mapped yet, this returns empty. 
            // This is correct behavior for "Grade Setup" - you can only grade what is in the curriculum.
            
            const subjects = await fetchAPI(`curriculums/${curriculumId}/subjects`);
            const loadedSubjects = subjects || [];
            
            // Filter: Only Major subjects should display for specific curriculums
            // "on the curriculus only major subjects will display"
            return loadedSubjects.filter(s => (s.subject_type || '').toLowerCase() === 'major');
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
        
        subjects.forEach(subject => {
            const isSelected = selectedSubjects.some(s => s.id === subject.id);
            // Check if subject is already graded
            // We can check against historyStats.subjects which contains graded subjects
            const isGraded = historyStats.subjects.some(s => s.id === subject.id);
            
            const div = document.createElement('div');
            div.className = `subject-item p-3 rounded-lg border cursor-pointer hover:bg-gray-50 transition-colors ${isSelected ? 'border-green-500 bg-green-50' : 'border-gray-200'}`;
            // Store full subject data including graded status
            subject.is_graded = isGraded; 
            div.dataset.subject = JSON.stringify(subject);
            
            div.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <input type="checkbox" class="subject-checkbox w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500" ${isSelected ? 'checked' : ''}>
                    </div>
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
                            ${isGraded ? '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800 border border-green-200">✅ Graded</span>' : ''}
                        </div>
                    </div>
                </div>
            `;
            
            div.addEventListener('click', (e) => {
                if (e.target.type !== 'checkbox') {
                    const checkbox = div.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
            
            div.querySelector('input[type="checkbox"]').addEventListener('change', (e) => {
                const itemDiv = e.target.closest('.subject-item');
                const isChecked = e.target.checked;
                
                if (isChecked) {
                    itemDiv.classList.add('border-green-500', 'bg-green-50');
                    itemDiv.classList.remove('border-gray-200');
                    // Add to selectedSubjects if not present
                    if (!selectedSubjects.some(s => s.id === subject.id)) {
                        selectedSubjects.push(subject);
                    }
                } else {
                    itemDiv.classList.remove('border-green-500', 'bg-green-50');
                    itemDiv.classList.add('border-gray-200');
                    // Remove from selectedSubjects
                    selectedSubjects = selectedSubjects.filter(s => s.id !== subject.id);
                }
                updateSelectedSubjectsCount();
            });
            
            subjectsChecklist.appendChild(div);
        });
        
        // Handle Select All
        if (selectAllSubjectsCheckbox) {
            selectAllSubjectsCheckbox.onclick = () => {
                const isChecked = selectAllSubjectsCheckbox.checked;
                const checkboxes = document.querySelectorAll('.subject-checkbox');
                
                checkboxes.forEach(cb => {
                    const itemDiv = cb.closest('.subject-item');
                    // Get subject data safely (parse back from dataset or find in subjects array if needed, 
                    // but here we can just rebuild selectedSubjects for bulk op)
                    
                    cb.checked = isChecked;
                    if (isChecked) {
                        itemDiv.classList.add('border-green-500', 'bg-green-50');
                        itemDiv.classList.remove('border-gray-200');
                    } else {
                        itemDiv.classList.remove('border-green-500', 'bg-green-50');
                        itemDiv.classList.add('border-gray-200');
                    }
                });
                
                // Update selectedSubjects Array
                if (isChecked) {
                    // Add all visible subjects (that are not already selected? no, just replacement or union)
                    // Simplest is to union:
                    subjects.forEach(s => {
                        if (!selectedSubjects.some(sel => sel.id === s.id)) {
                            // Ensure is_graded is correctly set on these objects before adding
                            s.is_graded = historyStats.subjects.some(h => h.id === s.id); 
                            selectedSubjects.push(s);
                        }
                    });
                } else {
                    // Remove all visible subjects from selection
                    const currentIds = new Set(subjects.map(s => s.id));
                    selectedSubjects = selectedSubjects.filter(s => !currentIds.has(s.id));
                }
                
                updateSelectedSubjectsCount();
            };
        }
        
        updateSelectedSubjectsCount();
    };
    
    const updateSelectedSubjectsCount = () => {
        const checkboxes = document.querySelectorAll('.subject-checkbox');
        const checked = document.querySelectorAll('.subject-checkbox:checked');
        
        selectedSubjectsCountSpan.textContent = `${checked.length} selected`;
        confirmSelectSubjectsBtn.disabled = checked.length === 0;
        
        if (selectAllSubjectsCheckbox && checkboxes.length > 0) {
            selectAllSubjectsCheckbox.checked = checkboxes.length === checked.length;
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
                    const hasMajorSubject = selectedSubjects.some(s => (s.subject_type || '').toLowerCase() === 'major');
                    
                    if (hasMajorSubject) {
                        applyTemplate('permanent');
                    } else {
                        addGradeComponentBtn.click();
                    }
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
        memorandumBtnText.textContent = 'Select Memorandum';
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
            let allSubjects = Array.isArray(allSubjectsItems) ? allSubjectsItems : (allSubjectsItems.data || []);
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
            
            validResults.forEach(res => {
                const subjects = res.subjects;
                const total = subjects.length;
                const gradedCount = subjects.filter(s => s.has_grades).length;
                
                // Classify Curriculum
                const c = res.curriculum;
                if (c) {
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
                    if (existing) existing.has_grades = true;
                    else {
                        const info = allSubjects.find(s => s.id == subId);
                        if (info) {
                            pooledSubjects.push({ ...info, has_grades: true });
                            seenSubIds.add(subId);
                        }
                    }
                });
            }
            
            // 5. Finalize Stats
            historyStats.subjects = pooledSubjects.filter(s => s.has_grades);
            historyStats.curriculums = processedCurriculums.filter(c => c.graded_subjects > 0);
            
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
        
        // Apply Filter
        let items = allItems;
        if (currentHistoryFilter !== 'all') {
            if (currentHistoryView === 'subject') {
                // Filter Major/Minor
                items = items.filter(i => (i.subject_type || 'major').toLowerCase() === currentHistoryFilter);
            } else {
                // Filter College/Senior High (mapped to 'college' / 'seniorhigh')
                items = items.filter(i => i.type === currentHistoryFilter); 
            }
        }
        
        if (items.length === 0) {
            container.innerHTML = `<p class="text-gray-500 text-sm text-center py-4">No items found matching filter.</p>`;
            return;
        }
        
        items.forEach(item => {
            const div = document.createElement('div');
            div.className = 'p-3 border rounded-lg hover:bg-gray-50 mb-2 transition-colors cursor-pointer group';
            
            if (currentHistoryView === 'subject') {
                const typeBadge = (item.subject_type || 'Major').toLowerCase() === 'minor' 
                    ? '<span class="text-xs bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded">Minor</span>' 
                    : '<span class="text-xs bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded">Major</span>';
                    
                div.innerHTML = `
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-800 text-sm flex items-center gap-2">${item.subject_code} ${typeBadge}</p>
                            <p class="text-xs text-gray-600 truncate mt-0.5">${item.subject_name}</p>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded border border-green-100">Graded</span>
                    </div>
                `;
                
                // Add Double Click listener to view details
                div.addEventListener('dblclick', (e) => {
                    e.stopPropagation();
                    showGradeComponentDetails(item.id, item.subject_name, item.subject_code);
                });
                
            } else {
                // Curriculum or Memorandum
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
            }
            container.appendChild(div);
        });
    };
    
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
        memorandumList.innerHTML = '<p class="text-gray-500 text-center py-8">Loading curriculums...</p>';
        memorandumSearchInput.value = '';
        memorandumSearchInput.focus();
        
        const curriculums = await fetchCurriculums();
        populateCurriculumList(curriculums);
        
        // Simple client-side search
        memorandumSearchInput.oninput = (e) => {
            const term = e.target.value.toLowerCase();
            const filtered = curriculums.filter(c => 
                (c.curriculum_name || '').toLowerCase().includes(term) || 
                (c.program_code || '').toLowerCase().includes(term)
            );
            populateCurriculumList(filtered);
        };
    });
    if (closeSelectMemorandumModalBtn) closeSelectMemorandumModalBtn.addEventListener('click', () => hideModal('select-memorandum-modal'));
    if (closeSelectSubjectsModalBtn) closeSelectSubjectsModalBtn.addEventListener('click', () => hideModal('select-subjects-modal'));
    if (cancelSelectSubjectsBtn) cancelSelectSubjectsBtn.addEventListener('click', () => {
        hideModal('select-subjects-modal');
        
        // Reset Memorandum Selection since user cancelled
        memorandumBtnText.textContent = 'Select Memorandum';
        memorandumBtnText.classList.remove('text-gray-900', 'font-bold');
        
        // Reset Selected Subjects
        selectedSubjects = [];
        updateSelectedSubjectsList();
    });
    
    if (confirmSelectSubjectsBtn) confirmSelectSubjectsBtn.addEventListener('click', () => {
        // Gather selected subjects from the modal
        const checkboxes = document.querySelectorAll('.subject-checkbox:checked');
        selectedSubjects = Array.from(checkboxes).map(cb => JSON.parse(cb.closest('.subject-item').dataset.subject));
        
        updateSelectedSubjectsList();
        hideModal('select-subjects-modal');
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
                            course_type: 'major'
                        };
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
            course_type: currentCourseType
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

            const renderComponents = (components) => {
                if (!components || Object.keys(components).length === 0) return '<p class="text-gray-400 italic text-sm">No components.</p>';
                let html = '<div class="space-y-3">';
                Object.keys(components).forEach(period => {
                    const pData = components[period];
                    html += `
                        <div class="bg-gray-50/50 rounded-lg border border-gray-100 overflow-hidden">
                            <div class="flex justify-between items-center px-4 py-2 bg-gray-100/50">
                                <span class="font-semibold text-gray-700 text-sm capitalize">${period}</span>
                                <span class="text-xs font-bold bg-white border border-gray-200 text-gray-600 px-2 py-0.5 rounded shadow-sm">${pData.weight}%</span>
                            </div>
                            <div class="px-4 py-3 space-y-2">`;
                    
                    (pData.components || []).forEach(comp => {
                        html += `
                            <div class="text-sm">
                                <div class="flex justify-between items-baseline">
                                    <span class="text-gray-800 font-medium">${comp.name}</span>
                                    <span class="text-gray-500 font-mono text-xs">${comp.weight}%</span>
                                </div>`;
                        if (comp.sub_components && comp.sub_components.length > 0) {
                            html += `<div class="mt-1 pl-3 border-l-2 border-gray-200 ml-1 space-y-1">`;
                            comp.sub_components.forEach(sub => {
                                html += `<div class="flex justify-between items-baseline text-xs text-gray-500"><span>${sub.name}</span><span>${sub.weight}%</span></div>`;
                            });
                            html += `</div>`;
                        }
                        html += `</div>`;
                    });
                    html += `</div></div>`;
                });
                html += '</div>';
                return html;
            };
            
            let html = `
                <div class="text-left font-sans bg-white pb-6">
                    <!-- Header -->
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-start bg-gradient-to-r from-gray-50 to-white">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 leading-tight">${subjectName}</h3>
                            <p class="text-sm text-gray-500 font-mono mt-1">${subjectCode}</p>
                        </div>
                        <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wide border border-green-200">Active</span>
                    </div>
                    
                    <div class="px-6 pt-6 space-y-4 max-h-[70vh] overflow-y-auto custom-scrollbar">
                        <!-- Current Version -->
                        <details class="group border border-indigo-100 rounded-xl bg-white shadow-sm overflow-hidden [&_summary::-webkit-details-marker]:hidden" open>
                            <summary class="flex cursor-pointer items-center justify-between p-4 bg-indigo-50/40 hover:bg-indigo-50/70 transition-colors group-open:border-b group-open:border-indigo-100">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-2.5 w-2.5 rounded-full bg-indigo-500 ring-2 ring-indigo-100"></span>
                                    <span class="font-semibold text-gray-800 text-sm">Current Grade Scheme</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] text-gray-500 font-medium bg-white px-2 py-0.5 rounded border border-gray-200 shadow-sm">
                                        ${formatDate(gradeData.current_version.updated_at)}
                                    </span>
                                    <svg class="h-4 w-4 text-gray-400 transition-transform duration-200 group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </summary>
                            <div class="p-4 text-sm bg-white">
                                ${renderComponents(gradeData.current_version.components)}
                            </div>
                        </details>

                        <!-- Previous Versions -->
                        ${gradeData.previous_versions && gradeData.previous_versions.length > 0 ? `
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1 mt-6">Version History</h4>
                                <div class="space-y-3">
                                    ${gradeData.previous_versions.map((ver, idx) => `
                                        <details class="group border border-gray-200 rounded-lg bg-white [&_summary::-webkit-details-marker]:hidden">
                                            <summary class="flex cursor-pointer items-center justify-between px-4 py-3 hover:bg-gray-50 transition-colors group-open:border-b group-open:border-gray-100 rounded-lg group-open:rounded-b-none">
                                                <div class="flex items-center gap-3">
                                                    <span class="flex h-1.5 w-1.5 rounded-full bg-gray-300"></span>
                                                    <span class="font-medium text-gray-600 text-xs">Version ${gradeData.previous_versions.length - idx}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[10px] text-gray-400 font-medium">${formatDate(ver.updated_at)}</span>
                                                    <svg class="h-3 w-3 text-gray-300 transition-transform duration-200 group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                </div>
                                            </summary>
                                            <div class="p-4 bg-gray-50/50 text-sm">
                                                ${renderComponents(ver.components)}
                                            </div>
                                        </details>
                                    `).join('')}
                                </div>
                            </div>
                        ` : ''}
                    </div>
                </div>`;

            Swal.fire({
                html: html,
                width: '600px',
                showConfirmButton: false,
                showCloseButton: true,
                padding: '0',
                customClass: { popup: 'rounded-2xl overflow-hidden' }
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
            const allSubjects = await fetchAPI('subjects');
            
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
            text: `${selectedMajorSubjects.length} major subject(s) selected.`,
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