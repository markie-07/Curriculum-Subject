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

    {{-- Third Row Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
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
            <div class="relative h-64">
                <canvas id="exportChart"></canvas>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="text-center p-3 bg-orange-50 rounded-lg">
                    <p class="text-sm text-slate-600">Curriculum Exports</p>
                    <p class="text-2xl font-bold text-orange-600" id="export-curriculum-count">{{ $curriculumExports ?? 0 }}</p>
                </div>
                <div class="text-center p-3 bg-amber-50 rounded-lg">
                    <p class="text-sm text-slate-600">Subject Exports</p>
                    <p class="text-2xl font-bold text-amber-600" id="export-subject-count">{{ $subjectExports ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- Employee Module Usage Chart --}}
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-800">Module Usage Frequency</h2>
                <div class="flex bg-slate-100 p-1 rounded-lg">
                     <button id="module-week-btn" class="px-3 py-1 text-xs font-medium rounded-md text-slate-600 hover:bg-white hover:shadow-sm transition-all">Week</button>
                     <button id="module-month-btn" class="px-3 py-1 text-xs font-medium rounded-md text-slate-600 hover:bg-white hover:shadow-sm transition-all">Month</button>
                     <button id="module-year-btn" class="px-3 py-1 text-xs font-medium rounded-md bg-white shadow-sm text-slate-800 transition-all">Year</button>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="moduleUsageChart"></canvas>
            </div>
            <div class="mt-4">
            <div class="mt-4">
                <p class="text-sm text-slate-600 text-center">Total interactions: <span id="total-usage-display" class="font-bold text-slate-800">{{ $totalModuleUsage ?? 0 }}</span></p>
            </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity Section --}}
    {{-- Recent Activity Section --}}
    <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="bg-blue-50 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-800">Recent Activity</h2>
            </div>

            {{-- Inline Date Filter --}}
            <div class="flex items-center gap-2">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input type="date" 
                           id="activity-date" 
                           class="pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 text-slate-600 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all cursor-pointer shadow-sm hover:border-blue-300"
                           placeholder="Filter by date">
                </div>
                <button id="clear-filter-btn" 
                        class="hidden p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all border border-transparent hover:border-red-100" 
                        title="Clear filter">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div id="activities-container" class="space-y-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
            @forelse($recentActivities ?? [] as $activity)
                <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-800">{{ $activity->action ?? 'Activity' }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $activity->description ?? '' }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ $activity->created_at ? $activity->created_at->diffForHumans() : '' }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="mt-4 text-sm text-slate-500">No recent activity to display</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Chart.js Library --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

    // Module Usage Chart - Bar Chart
    const moduleUsageCtx = document.getElementById('moduleUsageChart').getContext('2d');
    
    // Data sets
    const moduleNames = {!! json_encode($moduleNames ?? []) !!};
    const usageWeek = {!! json_encode($moduleUsageWeek ?? []) !!};
    const usageMonth = {!! json_encode($moduleUsageMonth ?? []) !!};
    const usageYear = {!! json_encode($moduleUsageYear ?? []) !!};
    
    let moduleUsageChart = new Chart(moduleUsageCtx, {
        type: 'bar',
        data: {
            labels: moduleNames,
            datasets: [{
                label: 'Usage Count',
                data: usageYear,
                backgroundColor: '#f43f5e',
                borderRadius: 8,
                barThickness: 40,
                hoverBackgroundColor: '#e11d48'
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
                            return 'Usage: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 10 },
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            }
        }
    });

    // Toggle Logic for Module Usage
    const weekBtn = document.getElementById('module-week-btn');
    const monthBtn = document.getElementById('module-month-btn');
    const yearBtn = document.getElementById('module-year-btn');
    const totalDisplay = document.getElementById('total-usage-display');
    
    function updateModuleActiveBtn(activeBtn) {
        [weekBtn, monthBtn, yearBtn].forEach(btn => {
            if (btn === activeBtn) {
                btn.classList.add('bg-white', 'shadow-sm', 'text-slate-800');
                btn.classList.remove('text-slate-600', 'hover:bg-white', 'hover:shadow-sm');
            } else {
                btn.classList.remove('bg-white', 'shadow-sm', 'text-slate-800');
                btn.classList.add('text-slate-600', 'hover:bg-white', 'hover:shadow-sm');
            }
        });
    }

    weekBtn.addEventListener('click', () => {
        updateModuleActiveBtn(weekBtn);
        moduleUsageChart.data.datasets[0].data = usageWeek;
        moduleUsageChart.update();
        if(totalDisplay) totalDisplay.textContent = usageWeek.reduce((a, b) => a + b, 0);
    });

    monthBtn.addEventListener('click', () => {
        updateModuleActiveBtn(monthBtn);
        moduleUsageChart.data.datasets[0].data = usageMonth;
        moduleUsageChart.update();
        if(totalDisplay) totalDisplay.textContent = usageMonth.reduce((a, b) => a + b, 0);
    });

    yearBtn.addEventListener('click', () => {
        updateModuleActiveBtn(yearBtn);
        moduleUsageChart.data.datasets[0].data = usageYear;
        moduleUsageChart.update();
        if(totalDisplay) totalDisplay.textContent = usageYear.reduce((a, b) => a + b, 0);
    });

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

    clearFilterBtn.addEventListener('click', () => {
        dateInput.value = '';
        loadActivities();
    });
});
</script>
@endsection
