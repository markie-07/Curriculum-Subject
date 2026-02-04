<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Curriculum;
use App\Models\Subject;
use App\Models\ExportHistory;
use App\Models\EmployeeActivityLog;
use App\Models\Equivalency;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Update user activity when visiting dashboard
            if ($user) {
                $user->last_activity = now();
                $user->save();
            }
            
            // Redirect employees directly to curriculum export tool
            if ($user->role === 'employee') {
                return redirect()->route('curriculum_export_tool');
            }
            
            // Get all dashboard statistics
            $data = $this->getAllDashboardData();
            
            // Log the data for debugging
            \Log::info('Dashboard Data:', $data);
            
            return view('dashboard', $data);
            
        } catch (\Exception $e) {
            \Log::error('Dashboard error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return default data instead of error page
            return view('dashboard', $this->getDefaultDashboardData());
        }
    }

    /**
     * Get all dashboard data
     */
    private function getAllDashboardData()
    {
        try {
            // NEW Curriculum Statistics (Breakdown by Level)
            $newHighSchoolCount = Curriculum::where('version_status', 'new')
                ->where(function($query) {
                    $query->where('year_level', 'Senior High')
                          ->orWhere('year_level', 'LIKE', '%High School%');
                })->count();

            $newCollegeCount = Curriculum::where('version_status', 'new')
                ->where(function($query) {
                    $query->where('year_level', 'College')
                          ->orWhere('year_level', 'LIKE', '%College%');
                })->count();

            // OLD Curriculum Statistics (Breakdown by Level)
            $oldHighSchoolCount = Curriculum::where('version_status', 'old')
                ->where(function($query) {
                    $query->where('year_level', 'Senior High')
                          ->orWhere('year_level', 'LIKE', '%High School%');
                })->count();

            $oldCollegeCount = Curriculum::where('version_status', 'old')
                ->where(function($query) {
                    $query->where('year_level', 'College')
                          ->orWhere('year_level', 'LIKE', '%College%');
                })->count();
            
            // Total Counts (keeping these for the top stats cards)
            $totalCurriculums = Curriculum::count();
            $newCurriculumCount = Curriculum::where('version_status', 'new')->count();
            $oldCurriculumCount = Curriculum::where('version_status', 'old')->count();

            // Course Builder Status Statistics (case-insensitive)
            $approvedCount = Curriculum::whereRaw('LOWER(approval_status) = ?', ['approved'])->count();
            $rejectedCount = Curriculum::whereRaw('LOWER(approval_status) = ?', ['rejected'])->count();
            $processingCount = Curriculum::where(function($query) {
                $query->whereRaw('LOWER(approval_status) = ?', ['processing'])
                      ->orWhereNull('approval_status');
            })->count();

            // Subject Classification Statistics
            $subjectCategories = [
                'General Education',
                'Professional Subject Non Laboratory',
                'Professional Subject Laboratory', 
                'Professional Subject Board Courses',
                'Professional Subject Non Board Courses',
                'Professional Subject OC',
                'NSTP 1',
                'NSTP 2',
                'Research',
                'OJT/Practicum'
            ];

            $subjectCounts = [];
            $gradeCounts = [];

            foreach ($subjectCategories as $category) {
                // Count subjects in this category
                $subjectCounts[$category] = Subject::where(function($query) use ($category) {
                    $query->where('subject_type', $category)
                          ->orWhere('subject_type', 'LIKE', '%' . $category . '%');
                })->count();

                // Count subjects with grades in this category
                try {
                    $gradeCounts[$category] = DB::table('grades')
                        ->join('subjects', 'grades.subject_id', '=', 'subjects.id')
                        ->where(function($query) use ($category) {
                            $query->where('subjects.subject_type', $category)
                                  ->orWhere('subjects.subject_type', 'LIKE', '%' . $category . '%');
                        })
                        ->distinct('grades.subject_id')
                        ->count('grades.subject_id');
                } catch (\Exception $e) {
                    $gradeCounts[$category] = 0;
                }
            }
            
            $totalSubjects = Subject::count();

            // Grades Setup Statistics - Global Counts
            try {
                $curriculumsWithGrades = DB::table('grades')
                    ->distinct()
                    ->count('curriculum_id');
                
                $subjectsWithGrades = DB::table('grades')
                    ->distinct()
                    ->count('subject_id');
            } catch (\Exception $e) {
                \Log::warning('Grades table not found: ' . $e->getMessage());
                $curriculumsWithGrades = 0;
                $subjectsWithGrades = 0;
            }

            // Equivalency Statistics (correct table name)
            try {
                $totalEquivalencies = DB::table('equivalencies')->count();
            } catch (\Exception $e) {
                try {
                    $totalEquivalencies = DB::table('subject_equivalencies')->count();
                } catch (\Exception $e2) {
                    \Log::warning('Equivalencies table not found');
                    $totalEquivalencies = 0;
                }
            }

            // Export Statistics (Last 7 Days by default)
            $exportData = $this->getExportStatistics('week');
            
            // Module Usage Statistics
            $moduleUsageWeek = $this->getModuleUsageStatistics('week');
            $moduleUsageMonth = $this->getModuleUsageStatistics('month');
            $moduleUsageYear = $this->getModuleUsageStatistics('year');

            // Recent Activities
            $recentActivities = $this->getRecentActivities();

            return [
                // Basic counts
                'totalCurriculums' => $totalCurriculums,
                'totalSubjects' => $totalSubjects,
                'totalEquivalencies' => $totalEquivalencies,
                'totalExports' => $exportData['total'],
                
                // Detailed Curriculum Counts
                'newHighSchoolCount' => $newHighSchoolCount,
                'newCollegeCount' => $newCollegeCount,
                'oldHighSchoolCount' => $oldHighSchoolCount,
                'oldCollegeCount' => $oldCollegeCount,
                
                // Official Curriculum (Totals)
                'newCurriculumCount' => $newCurriculumCount,
                'oldCurriculumCount' => $oldCurriculumCount,
                
                // Course Builder Status
                'approvedCount' => $approvedCount,
                'rejectedCount' => $rejectedCount,
                'processingCount' => $processingCount,
                
                // Detailed Subject Counts
                'subjectCategories' => $subjectCategories,
                'subjectCounts' => $subjectCounts,
                'gradeCounts' => $gradeCounts,
                
                // Grades Setup
                'curriculumsWithGrades' => $curriculumsWithGrades,
                'subjectsWithGrades' => $subjectsWithGrades,
                
                // Export Activity
                'curriculumExports' => $exportData['curriculum'],
                'subjectExports' => $exportData['subject'],
                'exportDates' => $exportData['dates'],
                'exportCounts' => $exportData['counts'],
                
                // Module Usage
                'moduleNames' => $moduleUsageWeek['names'],
                'moduleUsageWeek' => $moduleUsageWeek['counts'],
                'moduleUsageMonth' => $moduleUsageMonth['counts'],
                'moduleUsageYear' => $moduleUsageYear['counts'],
                'totalModuleUsage' => $moduleUsageYear['total'],
                
                // Recent Activities
                'recentActivities' => $recentActivities,
            ];
            
        } catch (\Exception $e) {
            \Log::error('Error fetching dashboard data: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return $this->getDefaultDashboardData();
        }
    }

    /**
     * API endpoint to get export data for different periods
     */
    public function getExportData(Request $request)
    {
        $period = $request->input('period', 'week');
        $exportData = $this->getExportStatistics($period);
        
        return response()->json([
            'labels' => $exportData['dates'],
            'counts' => $exportData['counts'],
            'curriculumExports' => $exportData['curriculum'],
            'subjectExports' => $exportData['subject'],
            'total' => $exportData['total']
        ]);
    }


    /**
     * Get export statistics for different time periods
     */
    private function getExportStatistics($period = 'week')
    {
        try {
            $dates = [];
            $counts = [];
            $curriculumExports = 0;
            $subjectExports = 0;
            
            // Determine the date range and labels based on period
            if ($period === 'week') {
                // Last 7 days (including today)
                for ($i = 6; $i >= 0; $i--) {
                    $date = now()->copy()->subDays($i);
                    $dates[] = $date->format('D'); // Mon, Tue, Wed, etc.
                    
                    $dayCount = DB::table('export_histories')
                        ->whereDate('created_at', $date->format('Y-m-d'))
                        ->count();
                    
                    $counts[] = $dayCount;
                }
                
                // Count curriculum vs subject exports for the week
                $weekStart = now()->subDays(6)->startOfDay();
                $curriculumExports = DB::table('export_histories')
                    ->where('created_at', '>=', $weekStart)
                    ->where(function($query) {
                        $query->where('export_type', 'curriculum')
                              ->orWhere('export_type', 'LIKE', '%curriculum%');
                    })
                    ->count();
                
                $subjectExports = DB::table('export_histories')
                    ->where('created_at', '>=', $weekStart)
                    ->where(function($query) {
                        $query->where('export_type', 'subject')
                              ->orWhere('export_type', 'LIKE', '%subject%');
                    })
                    ->count();
                    
            } elseif ($period === 'month') {
                // Last 30 days, grouped by week
                for ($i = 4; $i >= 0; $i--) {
                    $weekStart = now()->subWeeks($i)->startOfWeek();
                    $weekEnd = now()->subWeeks($i)->endOfWeek();
                    
                    $dates[] = 'Week ' . (5 - $i);
                    
                    $weekCount = DB::table('export_histories')
                        ->whereBetween('created_at', [$weekStart, $weekEnd])
                        ->count();
                    
                    $counts[] = $weekCount;
                }
                
                // Count curriculum vs subject exports for the month
                $monthStart = now()->subWeeks(4)->startOfWeek();
                $curriculumExports = DB::table('export_histories')
                    ->where('created_at', '>=', $monthStart)
                    ->where(function($query) {
                        $query->where('export_type', 'curriculum')
                              ->orWhere('export_type', 'LIKE', '%curriculum%');
                    })
                    ->count();
                
                $subjectExports = DB::table('export_histories')
                    ->where('created_at', '>=', $monthStart)
                    ->where(function($query) {
                        $query->where('export_type', 'subject')
                              ->orWhere('export_type', 'LIKE', '%subject%');
                    })
                    ->count();
                    
            } elseif ($period === 'year') {
                // Last 12 months
                for ($i = 11; $i >= 0; $i--) {
                    $monthDate = now()->subMonths($i);
                    $dates[] = $monthDate->format('M'); // Jan, Feb, Mar, etc.
                    
                    $monthCount = DB::table('export_histories')
                        ->whereYear('created_at', $monthDate->year)
                        ->whereMonth('created_at', $monthDate->month)
                        ->count();
                    
                    $counts[] = $monthCount;
                }
                
                // Count curriculum vs subject exports for the year
                $yearStart = now()->subMonths(11)->startOfMonth();
                $curriculumExports = DB::table('export_histories')
                    ->where('created_at', '>=', $yearStart)
                    ->where(function($query) {
                        $query->where('export_type', 'curriculum')
                              ->orWhere('export_type', 'LIKE', '%curriculum%');
                    })
                    ->count();
                
                $subjectExports = DB::table('export_histories')
                    ->where('created_at', '>=', $yearStart)
                    ->where(function($query) {
                        $query->where('export_type', 'subject')
                              ->orWhere('export_type', 'LIKE', '%subject%');
                    })
                    ->count();
            }
            
            $total = $curriculumExports + $subjectExports;
            
            return [
                'dates' => $dates,
                'counts' => $counts,
                'curriculum' => $curriculumExports,
                'subject' => $subjectExports,
                'total' => $total,
            ];
            
        } catch (\Exception $e) {
            \Log::error('Error fetching export statistics: ' . $e->getMessage());
            
            // Return default data based on period
            if ($period === 'month') {
                return [
                    'dates' => ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
                    'counts' => [0, 0, 0, 0, 0],
                    'curriculum' => 0,
                    'subject' => 0,
                    'total' => 0,
                ];
            } elseif ($period === 'year') {
                return [
                    'dates' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    'counts' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    'curriculum' => 0,
                    'subject' => 0,
                    'total' => 0,
                ];
            } else {
                return [
                    'dates' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'counts' => [0, 0, 0, 0, 0, 0, 0],
                    'curriculum' => 0,
                    'subject' => 0,
                    'total' => 0,
                ];
            }
        }
    }

    /**
     * Get module usage statistics from employee activity logs
     */
    private function getModuleUsageStatistics($period = 'year')
    {
        try {
            // User-defined module list
            $modules = [
                'Curriculum Builder' => ['create_curriculum', 'edit_curriculum', 'revise_curriculum', 'approve_curriculum', 'reject_curriculum', 'restore_curriculum'],
                'Course Builder' => ['course_builder_create', 'course_builder_update', 'course_builder_delete'],
                'Subject Mapping' => ['subject_mapping'],
                'Pre-requisite' => ['prerequisite'],
                'Compliance Validator' => ['compliance_link_create', 'compliance_link_update', 'compliance_link_delete'],
                'Grade Weighting Setup' => ['grade_setup'],
                'Subject Equivalency Tool' => ['equivalency_create', 'equivalency_update', 'equivalency_delete'],
                'Curriculum Export Tool' => ['curriculum_export'],
                'Employee Management' => ['employee_create', 'employee_update', 'employee_delete', 'status_change', 'employee_activity_report'],
            ];
            
            $names = [];
            $counts = [];
            $total = 0;
            
            foreach ($modules as $moduleName => $keywords) {
                $query = DB::table('employee_activity_logs');
                
                // Keyword filtering
                $query->where(function($q) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $q->orWhere('activity_type', 'LIKE', "%{$keyword}%")
                          ->orWhere('description', 'LIKE', "%{$keyword}%");
                    }
                });
                
                // Date filtering
                if ($period === 'week') {
                    $query->where('created_at', '>=', now()->subWeek());
                } elseif ($period === 'month') {
                    $query->where('created_at', '>=', now()->subMonth());
                } elseif ($period === 'year') {
                    $query->where('created_at', '>=', now()->subYear());
                }
                
                $count = $query->count();
                
                $names[] = $moduleName;
                $counts[] = $count;
                $total += $count;
            }
            
            return [
                'names' => $names,
                'counts' => $counts,
                'total' => $total,
            ];
            
        } catch (\Exception $e) {
            \Log::error('Error fetching module usage statistics: ' . $e->getMessage());
            return [
                'names' => array_keys($modules ?? []),
                'counts' => [],
                'total' => 0,
            ];
        }
    }

    /**
     * Get recent activities for dashboard
     */
    private function getRecentActivities()
    {
        try {
            return DB::table('employee_activity_logs')
                ->join('users', 'employee_activity_logs.user_id', '=', 'users.id')
                ->select(
                    'employee_activity_logs.id',
                    'employee_activity_logs.activity_type as action',
                    'employee_activity_logs.description',
                    'employee_activity_logs.created_at',
                    'users.name as user_name',
                    'users.email as user_email'
                )
                ->where('employee_activity_logs.activity_type', '!=', 'view')
                ->orderBy('employee_activity_logs.created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function($activity) {
                    $activity->created_at = \Carbon\Carbon::parse($activity->created_at);
                    return $activity;
                });
                
        } catch (\Exception $e) {
            \Log::error('Error fetching recent activities: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * API endpoint to get filtered recent activities
     */
    public function getRecentActivitiesFiltered(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            
            $query = DB::table('employee_activity_logs')
                ->join('users', 'employee_activity_logs.user_id', '=', 'users.id')
                ->select(
                    'employee_activity_logs.id',
                    'employee_activity_logs.activity_type as action',
                    'employee_activity_logs.description',
                    'employee_activity_logs.created_at',
                    'users.name as user_name',
                    'users.email as user_email'
                )
                ->where('employee_activity_logs.activity_type', '!=', 'view');
            
            // Apply date filters if provided
            if ($startDate && $endDate && $startDate == $endDate) {
                // Single day filter - use start and end of that day
                // Carbon will use app timezone (e.g. Asia/Manila) and convert to UTC for query
                $query->whereBetween('employee_activity_logs.created_at', [
                    \Carbon\Carbon::parse($startDate)->startOfDay(),
                    \Carbon\Carbon::parse($endDate)->endOfDay()
                ]);
            } else {
                // Range filter
                if ($startDate) {
                    $query->where('employee_activity_logs.created_at', '>=', \Carbon\Carbon::parse($startDate)->startOfDay());
                }
                if ($endDate) {
                    $query->where('employee_activity_logs.created_at', '<=', \Carbon\Carbon::parse($endDate)->endOfDay());
                }
            }
            
            $activities = $query->orderBy('employee_activity_logs.created_at', 'desc')
                ->limit(50)
                ->get()
                ->map(function($activity) {
                    $activity->created_at = \Carbon\Carbon::parse($activity->created_at);
                    $activity->formatted_date = $activity->created_at->format('M d, Y h:i A');
                    $activity->relative_time = $activity->created_at->diffForHumans();
                    return $activity;
                });
            
            return response()->json([
                'success' => true,
                'activities' => $activities,
                'count' => $activities->count()
            ]);
                
        } catch (\Exception $e) {
            \Log::error('Error fetching filtered activities: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching activities',
                'activities' => []
            ], 500);
        }
    }

    /**
     * Get default dashboard data in case of errors
     */
    private function getDefaultDashboardData()
    {
        return [
            'totalCurriculums' => 0,
            'totalSubjects' => 0,
            'totalEquivalencies' => 0,
            'totalExports' => 0,
            'highSchoolCount' => 0,
            'collegeCount' => 0,
            'newCurriculumCount' => 0,
            'oldCurriculumCount' => 0,
            'approvedCount' => 0,
            'rejectedCount' => 0,
            'processingCount' => 0,
            'subjectCategories' => [],
            'subjectCounts' => [],
            'gradeCounts' => [],
            'curriculumsWithGrades' => 0,
            'subjectsWithGrades' => 0,
            'curriculumExports' => 0,
            'subjectExports' => 0,
            'exportDates' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'exportCounts' => [0, 0, 0, 0, 0, 0, 0],
            'moduleNames' => ['Curriculum Builder', 'Course Builder', 'Subject Mapping', 'Pre-requisite', 'Compliance Validator', 'Grade Weighting Setup', 'Subject Equivalency Tool', 'Curriculum Export Tool', 'Employee Management'],
            'moduleUsageWeek' => [0, 0, 0, 0, 0, 0, 0, 0],
            'moduleUsageMonth' => [0, 0, 0, 0, 0, 0, 0, 0],
            'moduleUsageYear' => [0, 0, 0, 0, 0, 0, 0, 0],
            'totalModuleUsage' => 0,
            'recentActivities' => collect([]),
        ];
    }
    /**
     * API endpoint to get detailed module usage data
     */
    public function getModuleUsageData(Request $request)
    {
        $period = $request->input('period', 'day');
        $data = $this->getModuleUsageDetailed($period);
        return response()->json($data);
    }

    /**
     * Get detailed module usage statistics for matrix/bubble chart
     */
    private function getModuleUsageDetailed($period = 'day')
    {
        try {
            // User-defined module list (X-Axis)
            $modules = [
                'Curriculum Builder' => ['create_curriculum', 'edit_curriculum', 'revise_curriculum', 'approve_curriculum', 'reject_curriculum', 'restore_curriculum'],
                'Course Builder' => ['course_builder_create', 'course_builder_update', 'course_builder_delete'],
                'Subject Mapping' => ['subject_mapping'],
                'Pre-requisite' => ['prerequisite'],
                'Compliance Validator' => ['compliance_link_create', 'compliance_link_update', 'compliance_link_delete'],
                'Grade Weighting Setup' => ['grade_setup'],
                'Subject Equivalency Tool' => ['equivalency_create', 'equivalency_update', 'equivalency_delete'],
                'Curriculum Export Tool' => ['curriculum_export'],
                'Employee Management' => ['employee_create', 'employee_update', 'employee_delete', 'status_change', 'employee_activity_report'],
            ];

            $moduleNames = array_keys($modules);
            $timeLabels = [];
            $dataPoints = [];
            $totalInteractions = 0;

            // Define Time Labels (Y-Axis) and Query Range
            $query = DB::table('employee_activity_logs');
            
            if ($period === 'day') {
                // Day: 2-hour intervals
                $timeLabels = [
                    '12 AM - 2 AM', '2 AM - 4 AM', '4 AM - 6 AM', '6 AM - 8 AM', 
                    '8 AM - 10 AM', '10 AM - 12 PM', '12 PM - 2 PM', '2 PM - 4 PM', 
                    '4 PM - 6 PM', '6 PM - 8 PM', '8 PM - 10 PM', '10 PM - 12 AM'
                ];
                // Filter for today
                $query->whereDate('created_at', now());
            } elseif ($period === 'week') {
                // Week: Mon-Sun
                $timeLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                $query->where('created_at', '>=', now()->startOfWeek());
            } elseif ($period === 'month') {
                // Month: Weeks
                $timeLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'];
                $query->whereYear('created_at', now()->year)
                      ->whereMonth('created_at', now()->month);
            } elseif ($period === 'year') {
                // Year: Jan-Dec
                $timeLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $query->whereYear('created_at', now()->year);
            }

            // Fetch raw logs to process in PHP (easier than complex SQL grouping for keyword matching)
            // Optimize: Select only needed fields
            $logs = $query->select('activity_type', 'description', 'created_at')->get();

            // Initialize Grid with 0
            // Map: [ModuleIndex][TimeIndex] => Count
            $grid = [];

            foreach ($logs as $log) {
                $createdAt = \Carbon\Carbon::parse($log->created_at);
                $timeIndex = -1;
                $moduleIndex = -1;

                // Determine Time Index
                if ($period === 'day') {
                    $hour = $createdAt->hour;
                    $timeIndex = floor($hour / 2); // 0-11
                } elseif ($period === 'week') {
                    $timeIndex = $createdAt->dayOfWeekIso - 1; // 0 (Mon) - 6 (Sun). Carbon dayOfWeekIso is 1-7
                } elseif ($period === 'month') {
                    $timeIndex = floor(($createdAt->day - 1) / 7); // 0-4
                    if ($timeIndex > 4) $timeIndex = 4;
                } elseif ($period === 'year') {
                    $timeIndex = $createdAt->month - 1; // 0-11
                }

                if ($timeIndex < 0 || $timeIndex >= count($timeLabels)) continue;

                // Determine Module Index
                $activityType = $log->activity_type ?? '';
                $description = $log->description ?? '';
                
                foreach ($moduleNames as $idx => $name) {
                    $keywords = $modules[$name];
                    foreach ($keywords as $keyword) {
                        if (stripos($activityType, $keyword) !== false || stripos($description, $keyword) !== false) {
                            $moduleIndex = $idx;
                            break 2;
                        }
                    }
                }

                if ($moduleIndex >= 0) {
                    if (!isset($grid[$moduleIndex][$timeIndex])) {
                        $grid[$moduleIndex][$timeIndex] = 0;
                    }
                    $grid[$moduleIndex][$timeIndex]++;
                    $totalInteractions++;
                }
            }

            // Convert Grid to Bubble Data Points
            foreach ($grid as $mIdx => $timeData) {
                foreach ($timeData as $tIdx => $count) {
                    if ($count > 0) {
                        $dataPoints[] = [
                            'x' => $moduleNames[$mIdx], // Category String for X
                            'y' => $timeLabels[$tIdx],  // Category String for Y
                            'r' => $count // Raw count, will scale in JS
                        ];
                    }
                }
            }

            return [
                'modules' => $moduleNames,
                'time_labels' => $timeLabels, // Reversed or not? Usually bottom-to-top. JS handles order.
                'data' => $dataPoints,
                'total' => $totalInteractions
            ];

        } catch (\Exception $e) {
            \Log::error('Error fetching module usage details: ' . $e->getMessage());
            return [
                'modules' => [],
                'time_labels' => [],
                'data' => [],
                'total' => 0
            ];
        }
    }
}
