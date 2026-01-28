@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-4 sm:p-6 lg:p-8">
    {{-- Dashboard Header --}}
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-full -mr-32 -mt-32"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 mb-2">Dashboard Overview</h1>
                    <p class="text-slate-600">Welcome back! Here's what's happening with your curriculum management system.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-500">{{ now()->format('l, F j, Y') }}</p>
                    <p class="text-2xl font-bold text-blue-600" id="current-time">{{ now()->format('h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total Curriculums --}}
        <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Total Curriculums</p>
                    <p class="text-3xl font-bold text-slate-800">{{ $totalCurriculums ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Subjects --}}
        <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Total Subjects</p>
                    <p class="text-3xl font-bold text-slate-800">{{ $totalSubjects ?? 0 }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Equivalencies --}}
        <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Total Equivalencies</p>
                    <p class="text-3xl font-bold text-slate-800">{{ $totalEquivalencies ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Exports --}}
        <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Total Exports</p>
                    <p class="text-3xl font-bold text-slate-800">{{ $totalExports ?? 0 }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Official Curriculum Chart --}}
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-slate-800">Official Curriculum Distribution</h2>
                <div class="bg-blue-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            
            {{-- Toggle Switch --}}
            <div class="flex items-center justify-center gap-3 mb-4">
                <span class="text-sm font-medium text-slate-600" id="curriculum-new-label">New Curriculum</span>
                <button id="curriculum-view-toggle" class="relative inline-flex h-6 w-11 items-center rounded-full bg-emerald-500 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-1"></span>
                </button>
                <span class="text-sm font-medium text-slate-400" id="curriculum-old-label">Old Curriculum</span>
            </div>
            
            <div class="relative h-64">
                <canvas id="curriculumChart"></canvas>
            </div>
            
            {{-- Stats Cards - New Curriculum View --}}
            <div id="curriculum-new-stats" class="mt-4 grid grid-cols-2 gap-3">
                <div class="text-center p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-slate-600">High School</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $newHighSchoolCount ?? 0 }}</p>
                </div>
                <div class="text-center p-3 bg-indigo-50 rounded-lg">
                    <p class="text-xs text-slate-600">College</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $newCollegeCount ?? 0 }}</p>
                </div>
            </div>
            
            {{-- Stats Cards - Old Curriculum View --}}
            <div id="curriculum-old-stats" class="mt-4 grid grid-cols-2 gap-3 hidden">
                <div class="text-center p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-slate-600">High School</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $oldHighSchoolCount ?? 0 }}</p>
                </div>
                <div class="text-center p-3 bg-indigo-50 rounded-lg">
                    <p class="text-xs text-slate-600">College</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $oldCollegeCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- Course Builder Status Chart --}}
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-800">Course Builder Status</h2>
                <div class="bg-green-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="courseBuilderChart"></canvas>
            </div>
            <div class="mt-4 grid grid-cols-3 gap-2">
                <div class="text-center p-3 bg-green-50 rounded-lg">
                    <p class="text-xs text-slate-600">Approved</p>
                    <p class="text-xl font-bold text-green-600">{{ $approvedCount ?? 0 }}</p>
                </div>
                <div class="text-center p-3 bg-red-50 rounded-lg">
                    <p class="text-xs text-slate-600">Rejected</p>
                    <p class="text-xl font-bold text-red-600">{{ $rejectedCount ?? 0 }}</p>
                </div>
                <div class="text-center p-3 bg-yellow-50 rounded-lg">
                    <p class="text-xs text-slate-600">Processing</p>
                    <p class="text-xl font-bold text-yellow-600">{{ $processingCount ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Second Row Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Subject Mapping Chart --}}
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-800">Subject Classification</h2>
                <div class="bg-purple-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="subjectMappingChart"></canvas>
            </div>
            @php
                 $totalMapped = ($majorSubjects ?? 0) + ($minorSubjects ?? 0);
                 $majorMapPercent = $totalMapped > 0 ? round(($majorSubjects / $totalMapped) * 100) : 0;
                 $minorMapPercent = $totalMapped > 0 ? round(($minorSubjects / $totalMapped) * 100) : 0;
            @endphp

            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="text-center p-3 bg-purple-50 rounded-lg">
                    <p class="text-sm text-slate-600">Major Subjects</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $majorSubjects ?? 0 }}</p>
                    <p class="text-xs font-semibold text-purple-500 mt-1">{{ $majorMapPercent }}%</p>
                </div>
                <div class="text-center p-3 bg-pink-50 rounded-lg">
                    <p class="text-sm text-slate-600">Minor Subjects</p>
                    <p class="text-2xl font-bold text-pink-600">{{ $minorSubjects ?? 0 }}</p>
                    <p class="text-xs font-semibold text-pink-500 mt-1">{{ $minorMapPercent }}%</p>
                </div>
            </div>
        </div>

        {{-- Grades Setup Chart --}}
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-800">Grades Setup Overview</h2>
                <div class="bg-teal-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="gradesChart"></canvas>
            </div>
            @php
                $majorPercent = $majorSubjects > 0 ? round(($majorSubjectsWithGrades / $majorSubjects) * 100) : 0;
                $minorPercent = $minorSubjects > 0 ? round(($minorSubjectsWithGrades / $minorSubjects) * 100) : 0;
            @endphp
            
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="text-center p-3 bg-teal-50 rounded-lg">
                    <p class="text-xs text-slate-600">Major Subjects</p>
                    <p class="text-xl font-bold text-teal-600">{{ $majorSubjectsWithGrades ?? 0 }} <span class="text-sm font-normal text-slate-500">of {{ $majorSubjects ?? 0 }}</span></p>
                    <p class="text-xs font-semibold text-teal-500 mt-1">{{ $majorPercent }}% Graded</p>
                </div>
                <div class="text-center p-3 bg-cyan-50 rounded-lg">
                    <p class="text-xs text-slate-600">Minor Subjects</p>
                    <p class="text-xl font-bold text-cyan-600">{{ $minorSubjectsWithGrades ?? 0 }} <span class="text-sm font-normal text-slate-500">of {{ $minorSubjects ?? 0 }}</span></p>
                    <p class="text-xs font-semibold text-cyan-500 mt-1">{{ $minorPercent }}% Graded</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Reorganized Bottom Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Module Usage Frequency (Takes 2 Columns) --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg border border-slate-200 p-6 flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-800">Module Usage Frequency</h2>
                <div class="flex bg-slate-100 p-1 rounded-lg">
                     <button id="module-day-btn" class="px-3 py-1 text-xs font-medium rounded-md text-slate-600 hover:bg-white hover:shadow-sm transition-all">Day</button>
                     <button id="module-week-btn" class="px-3 py-1 text-xs font-medium rounded-md text-slate-600 hover:bg-white hover:shadow-sm transition-all">Week</button>
                     <button id="module-month-btn" class="px-3 py-1 text-xs font-medium rounded-md text-slate-600 hover:bg-white hover:shadow-sm transition-all">Month</button>
                     <button id="module-year-btn" class="px-3 py-1 text-xs font-medium rounded-md bg-white shadow-sm text-slate-800 transition-all">Year</button>
                </div>
            </div>
            {{-- Increased height for better visibility --}}
            <div class="relative flex-1 min-h-[500px]">
                <canvas id="moduleUsageChart"></canvas>
            </div>
            <div class="mt-4">
                <p class="text-sm text-slate-600 text-center">Total interactions: <span id="total-usage-display" class="font-bold text-slate-800">{{ $totalModuleUsage ?? 0 }}</span></p>
            </div>
        </div>

        {{-- Side Column: Export & Recent Activity (Takes 1 Column) --}}
        <div class="flex flex-col gap-6">
            {{-- Export Activity Chart --}}
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-slate-800">Export Activity</h2>
                    <div class="flex bg-slate-100 p-1 rounded-lg">
                         <button id="export-week-btn" class="px-3 py-1 text-xs font-medium rounded-md bg-white shadow-sm text-slate-800 transition-all">Week</button>
                         <button id="export-month-btn" class="px-3 py-1 text-xs font-medium rounded-md text-slate-600 hover:bg-white hover:shadow-sm transition-all">Month</button>
                         <button id="export-year-btn" class="px-3 py-1 text-xs font-medium rounded-md text-slate-600 hover:bg-white hover:shadow-sm transition-all">Year</button>
                    </div>
                </div>
                <div class="relative h-48">
                    <canvas id="exportChart"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="text-center p-3 bg-orange-50 rounded-lg">
                        <p class="text-sm text-slate-600">Curriculum</p>
                        <p class="text-2xl font-bold text-orange-600" id="export-curriculum-count">{{ $curriculumExports ?? 0 }}</p>
                    </div>
                    <div class="text-center p-3 bg-amber-50 rounded-lg">
                        <p class="text-sm text-slate-600">Subjects</p>
                        <p class="text-2xl font-bold text-amber-600" id="export-subject-count">{{ $subjectExports ?? 0 }}</p>
                    </div>
                </div>
            </div>

            {{-- Recent Activity Section --}}
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6 flex-1 flex flex-col">
                <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-4">
                    <div class="flex items-center gap-2">
                        <div class="bg-blue-50 p-1.5 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">Recent Activity</h2>
                    </div>

                    {{-- Inline Date Filter --}}
                    <div class="flex items-center gap-2">
                        <div class="relative group w-full xl:w-auto">
                            <!-- Display Input -->
                            <div class="relative group">
                                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none z-10 transition-colors group-focus-within:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M12 12.75h.008v.008H12v-.008z" /></svg>
                                <input type="text" id="dash-activityDateDisplay" readonly placeholder="Filter Date" value="{{ now()->format('M j, Y') }}" class="cursor-pointer w-full xl:w-48 pl-10 pr-10 py-1.5 bg-slate-50 border border-slate-200 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-300 text-slate-600 text-xs font-medium">
                                <input type="hidden" id="activity-date" value="{{ now()->format('Y-m-d') }}">
                            </div>

                            <!-- Custom Calendar Picker -->
                            <div id="dash-customCalendar" class="hidden absolute top-full right-0 mt-2 bg-white rounded-xl shadow-2xl border border-slate-200 p-4 w-72 z-50">
                                <!-- Calendar Header -->
                                <div class="flex items-center justify-between mb-4">
                                    <button type="button" id="dash-prevMonth" class="p-1.5 hover:bg-slate-100 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button type="button" id="dash-monthYearToggle" class="flex items-center gap-1 px-3 py-1.5 hover:bg-slate-100 rounded-lg transition-colors">
                                        <span class="font-semibold text-slate-800" id="dash-currentMonthYear"></span>
                                        <svg class="w-4 h-4 text-slate-500 transition-transform" id="dash-toggleArrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <button type="button" id="dash-nextMonth" class="p-1.5 hover:bg-slate-100 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Month View -->
                                <div id="dash-monthView">
                                    <div class="grid grid-cols-7 gap-1 mb-2">
                                        <div class="text-center text-xs font-medium text-slate-500 py-2">Su</div>
                                        <div class="text-center text-xs font-medium text-slate-500 py-2">Mo</div>
                                        <div class="text-center text-xs font-medium text-slate-500 py-2">Tu</div>
                                        <div class="text-center text-xs font-medium text-slate-500 py-2">We</div>
                                        <div class="text-center text-xs font-medium text-slate-500 py-2">Th</div>
                                        <div class="text-center text-xs font-medium text-slate-500 py-2">Fr</div>
                                        <div class="text-center text-xs font-medium text-slate-500 py-2">Sa</div>
                                    </div>
                                    <div id="dash-calendarDays" class="grid grid-cols-7 gap-1 mb-3"></div>
                                </div>
                                
                                <!-- Year Picker View -->
                                <div id="dash-yearView" class="hidden">
                                    <div class="grid grid-cols-4 gap-2 mb-3" id="dash-yearGrid"></div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex items-center justify-between pt-3 border-t border-slate-200">
                                    <button type="button" id="dash-clearDateBtn" class="text-xs text-slate-500 hover:text-red-600 font-medium transition-colors">Clear</button>
                                    <button type="button" id="dash-todayBtn" class="text-xs text-blue-600 hover:text-blue-700 font-medium transition-colors">Today</button>
                                </div>
                            </div>
                        </div>
                        <button id="clear-filter-btn" 
                                class="hidden p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all border border-transparent hover:border-red-100" 
                                title="Clear filter">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div id="activities-container" class="space-y-3 overflow-y-auto custom-scrollbar flex-1 min-h-[200px] max-h-[400px]">
                    @forelse($recentActivities ?? [] as $activity)
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-slate-800">{{ $activity->action ?? 'Activity' }}</p>
                                <p class="text-[10px] text-slate-500 mt-0.5 line-clamp-2">{{ $activity->description ?? '' }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $activity->created_at ? $activity->created_at->diffForHumans() : '' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="mx-auto h-10 w-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="mt-2 text-xs text-slate-500">No recent activity</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Calendar Picker Styling */
    #dash-activityDateDisplay {
        color: #475569;
        font-size: 0.875rem;
    }
    
    #dash-activityDateDisplay:not(:placeholder-shown) {
        background-color: #eff6ff;
        border-color: #3b82f6;
        font-weight: 500;
        color: #1e40af;
    }
    
    /* Calendar day buttons */
    .calendar-day {
        width: 100%;
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        font-size: 0.75rem; /* Slightly smaller for dashboard usage */
        font-weight: 500;
        transition: all 0.15s ease;
        cursor: pointer;
        color: #1e293b;
    }
    
    .calendar-day:hover:not(.other-month):not(.selected) {
        background-color: #f1f5f9;
    }
    
    .calendar-day.other-month {
        color: #cbd5e1;
        cursor: default;
    }
    
    .calendar-day.today {
        border: 2px solid #3b82f6;
        font-weight: 600;
    }
    
    .calendar-day.selected {
        background-color: #3b82f6;
        color: white;
        font-weight: 600;
    }
    
    .calendar-day.selected:hover {
        background-color: #2563eb;
    }
    
    /* Calendar animation */
    @keyframes calendarSlideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    #dash-customCalendar:not(.hidden) {
        animation: calendarSlideIn 0.2s ease;
    }
    
    /* Year picker buttons */
    .year-button {
        padding: 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.15s ease;
        cursor: pointer;
        color: #1e293b;
        text-align: center;
    }
    
    .year-button:hover:not(.current-year) {
        background-color: #f1f5f9;
    }
    
    .year-button.current-year {
        background-color: #dbeafe;
        color: #1e40af;
        font-weight: 600;
    }
    
    .year-button.selected-year {
        background-color: #3b82f6;
        color: white;
        font-weight: 600;
    }
    
    .year-button.selected-year:hover {
        background-color: #2563eb;
    }
    
    /* Toggle arrow rotation */
    #dash-toggleArrow.rotated {
        transform: rotate(180deg);
    }
</style>

{{-- Chart.js Library --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Custom Calendar Logic ---
    const activityDateDisplay = document.getElementById('dash-activityDateDisplay');
    const activityDateInput = document.getElementById('activity-date');
    const customCalendar = document.getElementById('dash-customCalendar');
    const calendarDays = document.getElementById('dash-calendarDays');
    const currentMonthYear = document.getElementById('dash-currentMonthYear');
    const prevMonthBtn = document.getElementById('dash-prevMonth');
    const nextMonthBtn = document.getElementById('dash-nextMonth');
    const todayBtn = document.getElementById('dash-todayBtn');
    const clearDateBtn = document.getElementById('dash-clearDateBtn');
    const monthYearToggle = document.getElementById('dash-monthYearToggle');
    const toggleArrow = document.getElementById('dash-toggleArrow');
    const monthView = document.getElementById('dash-monthView');
    const yearView = document.getElementById('dash-yearView');
    const yearGrid = document.getElementById('dash-yearGrid');

    let currentDate = new Date();
    let selectedDate = new Date(activityDateInput.value); // Initialize with default value
    let isYearView = false;
    let yearRangeStart = new Date().getFullYear() - 8;

    const formatDateDisplay = (date) => {
        const options = { month: 'short', day: 'numeric', year: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    };

    const formatDateValue = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    const toggleView = () => {
        isYearView = !isYearView;
        if (isYearView) {
            monthView.classList.add('hidden');
            yearView.classList.remove('hidden');
            toggleArrow.classList.add('rotated');
            generateYearPicker();
        } else {
            yearView.classList.add('hidden');
            monthView.classList.remove('hidden');
            toggleArrow.classList.remove('rotated');
            generateCalendar();
        }
    };

    const generateYearPicker = () => {
        yearGrid.innerHTML = '';
        const currentYear = new Date().getFullYear();
        const selectedYear = selectedDate ? selectedDate.getFullYear() : null;

        for (let i = 0; i < 16; i++) {
            const year = yearRangeStart + i;
            const yearBtn = document.createElement('button');
            yearBtn.type = 'button';
            yearBtn.className = 'year-button';
            yearBtn.textContent = year;
            
            if (year === currentYear) yearBtn.classList.add('current-year');
            if (year === selectedYear) yearBtn.classList.add('selected-year');
            
            yearBtn.addEventListener('click', () => {
                currentDate.setFullYear(year);
                isYearView = false;
                monthView.classList.remove('hidden');
                yearView.classList.add('hidden');
                toggleArrow.classList.remove('rotated');
                generateCalendar();
            });
            yearGrid.appendChild(yearBtn);
        }
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        currentMonthYear.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
    };

    const generateCalendar = () => {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        currentMonthYear.textContent = `${monthNames[month]} ${year}`;
        
        calendarDays.innerHTML = '';
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        for (let i = firstDay - 1; i >= 0; i--) {
            const day = daysInPrevMonth - i;
            const dayBtn = document.createElement('button');
            dayBtn.type = 'button';
            dayBtn.className = 'calendar-day other-month';
            dayBtn.textContent = day;
            calendarDays.appendChild(dayBtn);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayBtn = document.createElement('button');
            dayBtn.type = 'button';
            dayBtn.className = 'calendar-day';
            dayBtn.textContent = day;
            const currentDayDate = new Date(year, month, day);
            currentDayDate.setHours(0, 0, 0, 0);

            if (currentDayDate.getTime() === today.getTime()) dayBtn.classList.add('today');
            if (selectedDate) {
                const selected = new Date(selectedDate);
                selected.setHours(0, 0, 0, 0);
                if (currentDayDate.getTime() === selected.getTime()) dayBtn.classList.add('selected');
            }

            dayBtn.addEventListener('click', () => selectDate(new Date(year, month, day)));
            calendarDays.appendChild(dayBtn);
        }

        const totalCells = calendarDays.children.length;
        const remainingCells = 42 - totalCells;
        for (let day = 1; day <= remainingCells; day++) {
            const dayBtn = document.createElement('button');
            dayBtn.type = 'button';
            dayBtn.className = 'calendar-day other-month';
            dayBtn.textContent = day;
            calendarDays.appendChild(dayBtn);
        }
    };

    const selectDate = (date) => {
        selectedDate = date;
        activityDateDisplay.value = formatDateDisplay(date);
        activityDateInput.value = formatDateValue(date);
        customCalendar.classList.add('hidden');
        activityDateInput.dispatchEvent(new Event('change')); // Trigger change event logic
        generateCalendar();
    };

    activityDateDisplay.addEventListener('click', () => {
        customCalendar.classList.toggle('hidden');
        if (!customCalendar.classList.contains('hidden')) generateCalendar();
    });

    monthYearToggle.addEventListener('click', toggleView);

    prevMonthBtn.addEventListener('click', () => {
        if (isYearView) {
            yearRangeStart -= 16;
            generateYearPicker();
        } else {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar();
        }
    });

    nextMonthBtn.addEventListener('click', () => {
        if (isYearView) {
            yearRangeStart += 16;
            generateYearPicker();
        } else {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar();
        }
    });

    todayBtn.addEventListener('click', () => selectDate(new Date()));

    clearDateBtn.addEventListener('click', () => {
        selectedDate = null;
        activityDateDisplay.value = '';
        activityDateInput.value = '';
        customCalendar.classList.add('hidden');
        activityDateInput.dispatchEvent(new Event('change'));
    });

    document.addEventListener('click', (e) => {
        if (!customCalendar.contains(e.target) && !activityDateDisplay.contains(e.target)) {
            customCalendar.classList.add('hidden');
        }
    });

    // Update time every second
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        document.getElementById('current-time').textContent = timeString;
    }
    setInterval(updateTime, 1000);

    // Chart.js default configuration
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';

    // Official Curriculum Chart with Toggle Support
    const curriculumCtx = document.getElementById('curriculumChart').getContext('2d');
    let curriculumChart;
    let showingNew = true; // true = New Curriculum, false = Old Curriculum
    
    // Data for both views (High School vs College)
    const newData = {
        labels: ['New High School', 'New College'],
        data: [{{ $newHighSchoolCount ?? 0 }}, {{ $newCollegeCount ?? 0 }}],
        colors: ['#3b82f6', '#6366f1']
    };
    
    const oldData = {
        labels: ['Old High School', 'Old College'],
        data: [{{ $oldHighSchoolCount ?? 0 }}, {{ $oldCollegeCount ?? 0 }}],
        colors: ['#3b82f6', '#6366f1'] // Same colors as they represent same entities
    };
    
    // Initialize chart
    function createCurriculumChart(viewData) {
        if (curriculumChart) {
            curriculumChart.destroy();
        }
        
        curriculumChart = new Chart(curriculumCtx, {
            type: 'doughnut',
            data: {
                labels: viewData.labels,
                datasets: [{
                    data: viewData.data,
                    backgroundColor: viewData.colors,
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 12, weight: '600' }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            }
        });
    }
    
    // Initialize with New Curriculum view
    createCurriculumChart(newData);
    
    // Toggle button functionality
    const toggleButton = document.getElementById('curriculum-view-toggle');
    const newLabel = document.getElementById('curriculum-new-label');
    const oldLabel = document.getElementById('curriculum-old-label');
    const newStats = document.getElementById('curriculum-new-stats');
    const oldStats = document.getElementById('curriculum-old-stats');
    const toggleCircle = toggleButton.querySelector('span');
    
    toggleButton.addEventListener('click', function() {
        showingNew = !showingNew;
        
        if (showingNew) {
            // Switch to New Curriculum view
            toggleButton.classList.remove('bg-gray-400');
            toggleButton.classList.add('bg-emerald-500');
            toggleCircle.classList.remove('translate-x-6');
            toggleCircle.classList.add('translate-x-1');
            
            newLabel.classList.remove('text-slate-400');
            newLabel.classList.add('text-slate-600');
            oldLabel.classList.remove('text-slate-600');
            oldLabel.classList.add('text-slate-400');
            
            newStats.classList.remove('hidden');
            oldStats.classList.add('hidden');
            createCurriculumChart(newData);
        } else {
            // Switch to Old Curriculum view
            toggleButton.classList.remove('bg-emerald-500');
            toggleButton.classList.add('bg-gray-400');
            toggleCircle.classList.remove('translate-x-1');
            toggleCircle.classList.add('translate-x-6');
            
            newLabel.classList.remove('text-slate-600');
            newLabel.classList.add('text-slate-400');
            oldLabel.classList.remove('text-slate-400');
            oldLabel.classList.add('text-slate-600');
            
            newStats.classList.add('hidden');
            oldStats.classList.remove('hidden');
            createCurriculumChart(oldData);
        }
    });

    // Course Builder Status Chart (approval status only)
    const courseBuilderCtx = document.getElementById('courseBuilderChart').getContext('2d');
    new Chart(courseBuilderCtx, {
        type: 'pie',
        data: {
            labels: ['Approved', 'Rejected', 'Processing'],
            datasets: [{
                data: [
                    {{ $approvedCount ?? 0 }}, 
                    {{ $rejectedCount ?? 0 }}, 
                    {{ $processingCount ?? 0 }}
                ],
                backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 12, weight: '600' }
                    }
                }
            }
        }
    });

    // Subject Mapping Chart
    const subjectMappingCtx = document.getElementById('subjectMappingChart').getContext('2d');
    new Chart(subjectMappingCtx, {
        type: 'bar',
        data: {
            labels: ['Major', 'Minor'],
            datasets: [{
                label: 'Number of Subjects',
                data: [{{ $majorSubjects ?? 0 }}, {{ $minorSubjects ?? 0 }}],
                backgroundColor: ['#a855f7', '#ec4899'],
                borderRadius: 8,
                barThickness: 60
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Grades Chart - Percentages
    const gradesCtx = document.getElementById('gradesChart').getContext('2d');
    
    // Calculate percentages in JS to ensure valid numbers even if blade vars are missing
    const majorSubjectCount = {{ $majorSubjects ?? 0 }};
    const majorGradedCount = {{ $majorSubjectsWithGrades ?? 0 }};
    const majorPercent = majorSubjectCount > 0 ? Math.round((majorGradedCount / majorSubjectCount) * 100) : 0;
    
    const minorSubjectCount = {{ $minorSubjects ?? 0 }};
    const minorGradedCount = {{ $minorSubjectsWithGrades ?? 0 }};
    const minorPercent = minorSubjectCount > 0 ? Math.round((minorGradedCount / minorSubjectCount) * 100) : 0;

    new Chart(gradesCtx, {
        type: 'bar',
        data: {
            labels: ['Major Subjects', 'Minor Subjects'],
            datasets: [{
                label: 'Graded Percentage',
                data: [majorPercent, minorPercent],
                backgroundColor: ['#14b8a6', '#06b6d4'],
                borderRadius: 8,
                barThickness: 60
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + '% Graded';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: { 
                        stepSize: 20,
                        callback: function(value) { return value + '%' }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Export Activity Chart with Week/Month/Year Toggle
    const exportCtx = document.getElementById('exportChart').getContext('2d');
    
    // Store export data from backend (currently only week data is available)
    const exportDataWeek = {
        labels: {!! json_encode($exportDates ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!},
        counts: {!! json_encode($exportCounts ?? [0, 0, 0, 0, 0, 0, 0]) !!}
    };
    
    let exportChart = new Chart(exportCtx, {
        type: 'line',
        data: {
            labels: exportDataWeek.labels,
            datasets: [{
                label: 'Exports',
                data: exportDataWeek.counts,
                borderColor: '#f97316',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#f97316',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
    
    // Export Activity Toggle Logic
    const exportWeekBtn = document.getElementById('export-week-btn');
    const exportMonthBtn = document.getElementById('export-month-btn');
    const exportYearBtn = document.getElementById('export-year-btn');
    
    function updateExportActiveBtn(activeBtn) {
        [exportWeekBtn, exportMonthBtn, exportYearBtn].forEach(btn => {
            if (btn === activeBtn) {
                btn.classList.add('bg-white', 'shadow-sm', 'text-slate-800');
                btn.classList.remove('text-slate-600', 'hover:bg-white', 'hover:shadow-sm');
            } else {
                btn.classList.remove('bg-white', 'shadow-sm', 'text-slate-800');
                btn.classList.add('text-slate-600', 'hover:bg-white', 'hover:shadow-sm');
            }
        });
    }
    
    // Fetch export data for different periods
    async function fetchExportData(period) {
        try {
            const response = await fetch(`/api/dashboard/export-data?period=${period}`);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error fetching export data:', error);
            return null;
        }
    }
    
    exportWeekBtn.addEventListener('click', async () => {
        updateExportActiveBtn(exportWeekBtn);
        const data = await fetchExportData('week');
        if (data) {
            exportChart.data.labels = data.labels;
            exportChart.data.datasets[0].data = data.counts;
            exportChart.update();
            document.getElementById('export-curriculum-count').textContent = data.curriculumExports;
            document.getElementById('export-subject-count').textContent = data.subjectExports;
        }
    });
    
    exportMonthBtn.addEventListener('click', async () => {
        updateExportActiveBtn(exportMonthBtn);
        const data = await fetchExportData('month');
        if (data) {
            exportChart.data.labels = data.labels;
            exportChart.data.datasets[0].data = data.counts;
            exportChart.update();
            document.getElementById('export-curriculum-count').textContent = data.curriculumExports;
            document.getElementById('export-subject-count').textContent = data.subjectExports;
        }
    });
    
    exportYearBtn.addEventListener('click', async () => {
        updateExportActiveBtn(exportYearBtn);
        const data = await fetchExportData('year');
        if (data) {
            exportChart.data.labels = data.labels;
            exportChart.data.datasets[0].data = data.counts;
            exportChart.update();
            document.getElementById('export-curriculum-count').textContent = data.curriculumExports;
            document.getElementById('export-subject-count').textContent = data.subjectExports;
        }
    });

    // Helper to get theme colors
    function getThemeColor(type) {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        if (type === 'text') return isDark ? '#e2e8f0' : '#64748b'; // slate-200 vs slate-500
        if (type === 'grid') return isDark ? '#334155' : '#f1f5f9'; // slate-700 vs slate-100
        return '#000000';
    }

    // Module Usage Chart - Bubble Chart for Frequency Heatmap
    const moduleUsageCtx = document.getElementById('moduleUsageChart').getContext('2d');
    
    let moduleUsageChart = new Chart(moduleUsageCtx, {
        type: 'bubble',
        data: {
            datasets: [{
                label: 'Usage Frequency',
                data: [],
                backgroundColor: 'rgba(244, 63, 94, 0.6)', 
                borderColor: '#f43f5e',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const point = context.raw;
                            return `${point.x} (${point.y}): ${point.r / 3} interactions`; 
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'category',
                    labels: [], 
                    grid: { color: getThemeColor('grid') },
                    ticks: { color: getThemeColor('text') },
                    offset: true
                },
                x: {
                    type: 'category', 
                    labels: {!! json_encode($moduleNames ?? []) !!},
                    grid: { display: false },
                    ticks: {
                        color: getThemeColor('text'),
                        font: { size: 10 },
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 0
                    },
                    offset: true
                }
            }
        }
    });

    // Update all charts when theme changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === "attributes" && mutation.attributeName === "data-theme") {
                const textColor = getThemeColor('text');
                const gridColor = getThemeColor('grid');
                
                // Update defaults
                Chart.defaults.color = textColor;
                
                // Update specific charts
                [curriculumChart, exportChart, moduleUsageChart].forEach(chart => {
                    if (chart) {
                        // Update scales if they exist
                        if (chart.options.scales) {
                            Object.values(chart.options.scales).forEach(scale => {
                                if (scale.ticks) scale.ticks.color = textColor;
                                if (scale.grid) scale.grid.color = gridColor;
                            });
                        }
                        // Update legend
                        if (chart.options.plugins && chart.options.plugins.legend && chart.options.plugins.legend.labels) {
                            chart.options.plugins.legend.labels.color = textColor;
                        }
                        chart.update();
                    }
                });

                // Re-create other charts that might be tougher to update in-place or if needed
                // For now, simpler update loop covers most cases. 
                // Note: The simple bar/pie charts created without variable assignment (new Chart(...)) won't be updated here.
                // We should ideally assign them to variables too.
            }
        });
    });

    observer.observe(document.documentElement, {
        attributes: true, //configure it to listen to attribute changes
    });


    // Toggle Logic for Module Usage
    const dayBtn = document.getElementById('module-day-btn'); // New button
    const weekBtn = document.getElementById('module-week-btn');
    const monthBtn = document.getElementById('module-month-btn');
    const yearBtn = document.getElementById('module-year-btn');
    const totalDisplay = document.getElementById('total-usage-display');
    
    function updateModuleActiveBtn(activeBtn) {
        [dayBtn, weekBtn, monthBtn, yearBtn].forEach(btn => {
            if (btn === activeBtn) {
                btn.classList.add('bg-white', 'shadow-sm', 'text-slate-800');
                btn.classList.remove('text-slate-600', 'hover:bg-white', 'hover:shadow-sm');
            } else {
                btn.classList.remove('bg-white', 'shadow-sm', 'text-slate-800');
                btn.classList.add('text-slate-600', 'hover:bg-white', 'hover:shadow-sm');
            }
        });
    }

    async function fetchModuleUsageData(period) {
        try {
            const response = await fetch(`/api/dashboard/module-usage?period=${period}`);
            const data = await response.json();
            
            if (data) {
                // Update Y-Axis Labels (Time)
                moduleUsageChart.options.scales.y.labels = data.time_labels;
                
                // Update X-Axis Labels (Modules) - just in case they change or order differs
                moduleUsageChart.options.scales.x.labels = data.modules;

                // Update Bubble Data
                // Scale radius 'r' for better visibility. 
                // e.g., count 1 => r=5, count 10 => r=15
                const scaledData = data.data.map(p => ({
                    ...p,
                    r: p.r * 3 // Scale factor
                }));

                moduleUsageChart.data.datasets[0].data = scaledData;
                moduleUsageChart.update();
                
                if (totalDisplay) totalDisplay.textContent = data.total;
            }
        } catch (error) {
            console.error('Error loading module data:', error);
        }
    }

    // Event Listeners
    if(dayBtn) {
        dayBtn.addEventListener('click', () => {
            updateModuleActiveBtn(dayBtn);
            fetchModuleUsageData('day');
        });
    }

    weekBtn.addEventListener('click', () => {
        updateModuleActiveBtn(weekBtn);
        fetchModuleUsageData('week');
    });

    monthBtn.addEventListener('click', () => {
        updateModuleActiveBtn(monthBtn);
        fetchModuleUsageData('month');
    });

    yearBtn.addEventListener('click', () => {
        updateModuleActiveBtn(yearBtn);
        fetchModuleUsageData('year');
    });

    // Initial Load (Default to Year as before, or Week?)
    // Let's load 'year' to match previous state
    updateModuleActiveBtn(yearBtn);
    fetchModuleUsageData('year');

    // Recent Activity Filter
    const clearFilterBtn = document.getElementById('clear-filter-btn');
    const dateInput = document.getElementById('activity-date');
    const activitiesContainer = document.getElementById('activities-container');

    async function loadActivities(date = null) {
        try {
            let url = '/api/dashboard/recent-activities?';
            if (date) {
                // If a date is provided, filter by that specific day
                url += `start_date=${date}&end_date=${date}`;
                clearFilterBtn.classList.remove('hidden');
            } else {
                clearFilterBtn.classList.add('hidden');
            }
            
            // Show loading state (opional but good for UX)
            activitiesContainer.style.opacity = '0.5';
            
            const response = await fetch(url);
            const data = await response.json();
            
            activitiesContainer.style.opacity = '1';
            
            if (data.success && data.activities) {
                renderActivities(data.activities);
            } else {
                showNoActivities();
            }
        } catch (error) {
            console.error('Error loading activities:', error);
            activitiesContainer.style.opacity = '1';
            showNoActivities('Error loading activities. Please try again.');
        }
    }

    function renderActivities(activities) {
        if (activities.length === 0) {
            showNoActivities();
            return;
        }

        activitiesContainer.innerHTML = activities.map(activity => `
            <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors animate-fade-in">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-800">${activity.action || 'Activity'}</p>
                    <p class="text-xs text-slate-500 mt-1">${activity.description || ''}</p>
                    <p class="text-xs text-slate-400 mt-1">${activity.relative_time || ''}</p>
                </div>
            </div>
        `).join('');
    }

    function showNoActivities(message = 'No activities found for the selected date') {
        activitiesContainer.innerHTML = `
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="mt-4 text-sm text-slate-500">${message}</p>
            </div>
        `;
    }

    // Auto-filter on date selection
    dateInput.addEventListener('change', () => {
        const date = dateInput.value;
        if (date) {
            loadActivities(date);
        } else {
            loadActivities();
        }
    });

    // Clear Filter Button (external)
    if(clearFilterBtn) {
        clearFilterBtn.addEventListener('click', () => {
            selectedDate = null;
            activityDateDisplay.value = '';
            activityDateInput.value = ''; // Update the hidden input
            activityDateInput.dispatchEvent(new Event('change')); // Trigger change logic
            customCalendar.classList.add('hidden');
        });
    }

    // Initial load will happen because we call loadActivities(dateInput.value) below and we initialized value correctly


    // Initial load with filter if date is set
    if (dateInput.value) {
        loadActivities(dateInput.value);
    }
});
</script>
@endsection
