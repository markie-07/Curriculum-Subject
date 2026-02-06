<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectExportController;

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

// Integration Routes (Protected by API Key) - LIMITED ACCESS
Route::middleware('integration.key')->group(function () {
    
    // --- ONLY Subject Export PDF is allowed ---
    Route::get('/integration/subjects/{subjectId}/export-pdf', [SubjectExportController::class, 'exportPdf']);
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
