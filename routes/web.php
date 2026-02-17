<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrerequisiteController;
use App\Http\Controllers\EquivalencyToolController;
use App\Http\Controllers\CurriculumExportToolController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubjectExportController;
use App\Http\Controllers\CurriculumVersionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CurriculumHistoryController;
use App\Http\Controllers\ExtractSyllabusController;
use App\Http\Controllers\SystemSettingController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/otp-verify', [AuthController::class, 'showOtpForm'])->name('otp.verify');
    Route::post('/otp-verify', [AuthController::class, 'verifyOtp'])->name('otp.verify.submit');
    
    // Helper route to get CSRF token for Postman
    Route::get('/csrf-token', function () {
        return response()->json(['csrf_token' => csrf_token()]);
    });
    Route::post('/otp-resend', [AuthController::class, 'resendOtp'])->name('otp.resend');
    
    // CSRF token refresh route
    Route::get('/csrf-token', function () {
        return response()->json(['csrf_token' => csrf_token()]);
    });
});
// Debug routes (temporary)
Route::get('/debug', function () {
    return response()->json([
        'status' => 'Laravel is working',
        'user' => auth()->user() ? auth()->user()->toArray() : 'Not authenticated',
    ]);
});

Route::get('/debug-redirect', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json([
            'authenticated' => true,
            'user_role' => $user->role,
            'user_email' => $user->email,
            'is_employee' => $user->isEmployee(),
            'dashboard_route' => route('dashboard'),
            'curriculum_export_route' => route('curriculum_export_tool'),
            'intended_url' => session()->get('url.intended', 'none')
        ]);
    }
    return response()->json(['authenticated' => false]);
})->middleware('auth');

Route::get('/test-view', function () {
    return view('dashboard', [
        'user' => (object)['name' => 'Test User', 'role' => 'admin'],
        'dashboardData' => [
            'role' => 'admin',
            'welcome_message' => 'Test message',
            'stats' => [
                'curriculum_senior_high' => 0,
                'curriculum_college' => 0,
                'total_curriculums' => 0,
                'total_subjects' => 0,
                'total_prerequisites' => 0,
                'total_mapping_history' => 0,
                'removed_subjects' => 0,
                'total_equivalencies' => 0,
                'curriculum_exports' => 0,
                'employees_active' => 0,
                'employees_inactive' => 0,
            ],
            'recent_activities' => collect([])
        ]
    ]);
});

// Protected Routes
Route::middleware(['auth', 'prevent.back'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard/module-usage', [DashboardController::class, 'getModuleUsageData'])->name('dashboard.module-usage');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/validate-email', [ProfileController::class, 'validateEmail'])->name('profile.validate-email');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    
    // Test Notification Route
    Route::get('/test-notifications', function () {
        return view('test_notifications');
    })->name('test.notifications');
    
    // Debug notifications route
    Route::get('/debug-notifications', function () {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not authenticated']);
        }
        
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->limit(10)->get();
        $unreadCount = $user->notifications()->unread()->count();
        
        return response()->json([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'notifications_count' => $user->notifications()->count(),
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
            'all_notifications_count' => \App\Models\Notification::count()
        ]);
    })->name('debug.notifications');

    // Curriculum Export Tool - Accessible to all authenticated users (employees, admin, super admin)
    Route::get('/curriculum_export_tool', [CurriculumExportToolController::class, 'index'])->name('curriculum_export_tool');
    Route::post('/curriculum_export_tool', [CurriculumExportToolController::class, 'store'])->name('curriculum_export_tool.store');

    // --- Module Protected Routes ---

    Route::get('/curriculum_builder', function () {

        $programs = \App\Models\Program::all();
        return view('curriculum_builder', compact('programs'));
    })->middleware('module:curriculum_builder')->name('curriculum_builder');

    Route::get('/official_curriculum', function () {

        return view('official_curriculum');
    })->middleware('module:official_curriculum')->name('official_curriculum');

    Route::get('/subject_mapping', function () {

        return view('subject_mapping');
    })->middleware('module:subject_mapping')->name('subject_mapping');

    Route::get('/pre_requisite', [PrerequisiteController::class, 'index'])
        ->middleware('module:pre_requisite')
        ->name('pre_requisite');

    Route::get('/grade-setup', [GradeController::class, 'setup'])
        ->middleware('module:grade_setup')
        ->name('grade_setup');

    Route::get('/equivalency_tool', function () {

        $subjects = \App\Models\Subject::all();
        $equivalencies = \App\Models\Equivalency::with('equivalentSubject')->get();
        return view('equivalency_tool', compact('subjects', 'equivalencies'));
    })->middleware('module:equivalency_tool')->name('equivalency_tool');

    // CHED Compliance Validator
    Route::get('/compliance-validator', function () {

        return view('compliance_validator');
    })->middleware('module:compliance_validator')->name('compliance.validator');

    Route::get('/subject_mapping_history', function () {

        return view('subject_mapping_history');
    })->middleware('module:mapping_history')->name('subject_mapping_history');

    Route::get('/course-builder', function () {

        return view('course_builder');
    })->middleware('module:course_builder')->name('course_builder');
    
    // --- AJAX Routes ---
    Route::post('/ajax/generate-syllabus-weeks', [\App\Http\Controllers\Api\SyllabusGeneratorController::class, 'generateWeeks'])->name('ajax.generate-syllabus-weeks');

    // --- Admin Only Routes ---
    Route::middleware('admin')->group(function () {
        // Employee Management Routes (Admin and Super Admin only)
        Route::resource('employees', EmployeeController::class)->except(['show']);
        
        // Employee Activity Logs and Status Management
        Route::get('/employees/{id}/activity-logs', [EmployeeController::class, 'activityLogs'])->name('employees.activity-logs');
        Route::patch('/employees/{id}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');
        Route::get('/employee-activities', [EmployeeController::class, 'allActivities'])->name('employees.all-activities');
        Route::get('/employee-activities/export', [EmployeeController::class, 'exportActivities'])->name('employees.export-activities');
    });

    // Serve syllabus files with proper headers to avoid 403 errors
    Route::get('/view-syllabus/{path}', function ($path) {
        $filePath = storage_path('app/public/' . $path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
        
        $mimeType = mime_content_type($filePath);
        
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
        ]);
    })->where('path', '.*')->name('view.syllabus');

    // API Routes - Accessible to all authenticated users with session support
    // Protected by CSRF, session management, and rate limiting
    Route::prefix('api')->middleware('throttle:120,1')->group(function () {
        // --- Curriculum Routes ---
        Route::get('/curriculums', [CurriculumController::class, 'index']);
        Route::get('/curriculums/approved', [CurriculumController::class, 'getApproved']); // New endpoint for approved only
        Route::post('/curriculums', [CurriculumController::class, 'store']);
        Route::get('/curriculums/{id}', [CurriculumController::class, 'getCurriculumData']);
        Route::put('/curriculums/{id}', [CurriculumController::class, 'update']);
        Route::delete('/curriculums/{id}', [CurriculumController::class, 'destroy']);
        Route::post('/curriculums/save', [CurriculumController::class, 'saveSubjects']);
        Route::post('/curriculum/remove-subject', [CurriculumController::class, 'removeSubject']);
        Route::get('/curriculum/{id}/details', [CurriculumController::class, 'getCurriculumDetailsForExport']);
        Route::get('/curriculums/{id}/subjects', [CurriculumController::class, 'getCurriculumSubjects']);
        Route::get('/curriculums/{id}/subjects-by-year-semester', [CurriculumController::class, 'getCurriculumSubjectsByYearSemester']);
        Route::post('/curriculums/{id}/add-subjects', [CurriculumController::class, 'addSubjectsToCurriculum']);
        Route::post('/curriculums/{id}/approve', [CurriculumController::class, 'approve']);
        Route::post('/curriculums/{id}/reject', [CurriculumController::class, 'reject']);

        Route::get('/curriculum/{id}/subjects', [CurriculumExportToolController::class, 'getCurriculumSubjects']);
        Route::get('/curriculum/{id}/export-pdf', [CurriculumExportToolController::class, 'exportPdf']);

        // --- Program Routes ---
        Route::post('/programs', [CurriculumController::class, 'storeProgram']);

        // --- Subject Routes ---
        Route::get('/subjects/ids', [SubjectController::class, 'getIds']);
        Route::get('/subjects', [SubjectController::class, 'index']);
        Route::post('/subjects', [SubjectController::class, 'store']);
        Route::get('/subjects/{id}', [SubjectController::class, 'show']);
        Route::get('/subjects/{id}/versions', [SubjectController::class, 'getVersionHistory']);
        Route::put('/subjects/{id}', [SubjectController::class, 'update']);
        Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy']);
        Route::get('/subjects/{subjectId}/export-pdf', [SubjectExportController::class, 'exportPdf']);

        // --- Prerequisite Routes ---
        Route::get('/gen-ed-prerequisites/{type}', [PrerequisiteController::class, 'fetchGeneralData']);
        Route::get('/prerequisites/{curriculum}', [PrerequisiteController::class, 'fetchData']);
        Route::post('/prerequisites', [PrerequisiteController::class, 'store']);

        // --- Grade Routes ---
        Route::get('/grades', [GradeController::class, 'index']); // Added missing index route
        Route::post('/grades', [GradeController::class, 'store']);
        Route::get('/grades/{subjectId}', [GradeController::class, 'show']);
        Route::get('/grades/{subjectId}/version-history', [GradeController::class, 'getGradeVersionHistory']);

        // --- Grading Template Routes ---
        Route::post('/grading-templates', [GradeController::class, 'storeTemplate']);
        Route::put('/grading-templates/{id}', [GradeController::class, 'updateTemplate']);
        Route::delete('/grading-templates/{id}', [GradeController::class, 'deleteTemplate']);

        // --- Curriculum Grade Routes ---
        Route::get('/curriculum-grades', [GradeController::class, 'getAllCurriculumGrades']);
        Route::post('/curriculum-grades', [GradeController::class, 'storeCurriculumGrades']);
        Route::get('/curriculum-grades/{curriculumId}', [GradeController::class, 'getCurriculumGrades']);

        // --- Equivalency Tool Routes ---
        Route::get('/equivalencies', [EquivalencyToolController::class, 'getEquivalencies']);
        Route::post('/equivalencies', [EquivalencyToolController::class, 'store']);
        Route::patch('/equivalencies/{equivalency}', [EquivalencyToolController::class, 'update']);
        Route::delete('/equivalencies/{equivalency}', [EquivalencyToolController::class, 'destroy']);

        // --- Global Search Routes ---
        Route::post('/global-search', [\App\Http\Controllers\Api\GlobalSearchController::class, 'search']);
        Route::get('/quick-search/{type}', [\App\Http\Controllers\Api\GlobalSearchController::class, 'quickSearch']);

        // --- Compliance Links Routes ---
        Route::get('/compliance-links', [\App\Http\Controllers\ComplianceLinkController::class, 'index']);
        Route::get('/compliance-links/categories', [\App\Http\Controllers\ComplianceLinkController::class, 'getCategories']);
        Route::post('/compliance-links', [\App\Http\Controllers\ComplianceLinkController::class, 'store']);
        Route::put('/compliance-links/{id}', [\App\Http\Controllers\ComplianceLinkController::class, 'update']);
        Route::delete('/compliance-links/{id}', [\App\Http\Controllers\ComplianceLinkController::class, 'destroy']);

        // --- Dashboard Routes ---
        Route::get('/dashboard/export-data', [DashboardController::class, 'getExportData']);
        Route::get('/dashboard/recent-activities', [DashboardController::class, 'getRecentActivitiesFiltered']);
        Route::get('/dashboard/module-usage', [DashboardController::class, 'getModuleUsageData']);

        // --- Curriculum History Routes ---
        Route::prefix('curriculum-history')->group(function () {
            Route::get('/{curriculumId}/versions', [CurriculumHistoryController::class, 'getVersions']);
            Route::get('/{curriculumId}/versions/{versionId}', [CurriculumHistoryController::class, 'getVersionDetails']);
            Route::post('/{curriculumId}/snapshot', [CurriculumHistoryController::class, 'createSnapshot']);
            Route::get('/{curriculumId}/compare/{version1Id}/{version2Id}', [CurriculumHistoryController::class, 'compareVersions']);
        });

        // --- Syllabus Extraction Routes ---
        Route::post('/extract-syllabus', [ExtractSyllabusController::class, 'extract']);
        Route::post('/extract-ched-syllabus', [\App\Http\Controllers\ExtractChedSyllabusController::class, 'extract']);
        // Route::post('/generate-syllabus-weeks', [\App\Http\Controllers\Api\SyllabusGeneratorController::class, 'generateWeeks']);

        // --- Description Similarity Check ---
        Route::post('/check-description-similarity', [\App\Http\Controllers\Api\DescriptionSimilarityController::class, 'check']);



        // --- System Settings Routes ---
        Route::get('/system-settings', [SystemSettingController::class, 'index']);
        Route::get('/system-settings/{category}', [SystemSettingController::class, 'getByCategory']);
    });

}); // End of auth middleware group
