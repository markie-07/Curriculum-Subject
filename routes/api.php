<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\PrerequisiteController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\EquivalencyToolController;
use App\Http\Controllers\CurriculumExportToolController;
use App\Http\Controllers\SubjectExportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExtractSyllabusController;
use App\Http\Controllers\CurriculumHistoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes for data operations - requires authentication
// Using 'auth' middleware to support both web sessions and API tokens
Route::middleware(['auth'])->group(function () {
    // --- Curriculum Routes ---
    Route::get('/curriculums', [CurriculumController::class, 'index']);
    Route::post('/curriculums', [CurriculumController::class, 'store']);
    Route::get('/curriculums/{id}', [CurriculumController::class, 'getCurriculumData']);
    Route::put('/curriculums/{id}', [CurriculumController::class, 'update']);
    Route::delete('/curriculums/{id}', [CurriculumController::class, 'destroy']);
    Route::post('/curriculums/save', [CurriculumController::class, 'saveSubjects']);
    Route::post('/curriculum/remove-subject', [CurriculumController::class, 'removeSubject']);
    Route::get('/curriculum/{id}/details', [CurriculumController::class, 'getCurriculumDetailsForExport']);
    Route::get('/curriculums/{id}/subjects', [CurriculumController::class, 'getCurriculumSubjects']);
    Route::post('/curriculums/{id}/add-subjects', [CurriculumController::class, 'addSubjectsToCurriculum']);
    Route::post('/curriculums/{id}/approve', [CurriculumController::class, 'approve']);
    Route::post('/curriculums/{id}/reject', [CurriculumController::class, 'reject']);
    Route::post('/curriculums/{id}/restore', [CurriculumController::class, 'restore']);
    Route::get('/curriculum/{id}/subjects', [CurriculumExportToolController::class, 'getCurriculumSubjects']);
    Route::get('/curriculum/{id}/export-pdf', [CurriculumExportToolController::class, 'exportPdf']);

    // --- Subject Routes ---
    Route::get('/subjects', [SubjectController::class, 'index']);
    Route::post('/subjects', [SubjectController::class, 'store']);
    Route::get('/subjects/{id}', [SubjectController::class, 'show']);
    Route::get('/subjects/{id}/versions', [SubjectController::class, 'getVersionHistory']);
    Route::put('/subjects/{id}', [SubjectController::class, 'update']);
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy']);
    Route::get('/subjects/{subjectId}/export-pdf', [SubjectExportController::class, 'exportPdf']);

    // --- Prerequisite Routes ---

    Route::get('/prerequisites/{curriculum}', [PrerequisiteController::class, 'fetchData']);
    Route::get('/gen-ed-prerequisites/{type}', [PrerequisiteController::class, 'fetchGeneralData']);
    Route::post('/prerequisites', [PrerequisiteController::class, 'store']);

    // --- Grade Routes ---
    Route::post('/grades', [GradeController::class, 'store']);
    Route::get('/grades/{subjectId}', [GradeController::class, 'show']);
    Route::get('/grades/{subjectId}/version-history', [GradeController::class, 'getGradeVersionHistory']);

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

    // --- Description Similarity Check ---
    Route::post('/check-description-similarity', [\App\Http\Controllers\Api\DescriptionSimilarityController::class, 'check']);
});