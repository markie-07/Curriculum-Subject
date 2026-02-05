<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SyllabusGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SyllabusGeneratorController extends Controller
{
    protected $syllabusService;

    public function __construct(SyllabusGeneratorService $syllabusService)
    {
        $this->syllabusService = $syllabusService;
    }

    /**
     * Generate syllabus content for specific weeks
     */
    public function generateWeeks(Request $request)
    {
        $request->validate([
            'course_title' => 'required|string',
            'course_code' => 'required|string',
            'course_description' => 'required|string',
            'weeks' => 'required|array',
            'weeks.*' => 'integer|min:0|max:18'
        ]);

        $courseTitle = $request->input('course_title');
        $courseCode = $request->input('course_code');
        $courseDescription = $request->input('course_description');
        $weeks = $request->input('weeks');
        $cmoYear = $request->input('cmo_year');
        $cmoTitle = $request->input('cmo_title');

        try {
            $result = $this->syllabusService->generateSyllabusContent($courseTitle, $courseCode, $courseDescription, $weeks, $cmoYear, $cmoTitle);

            if (!$result) {
                return response()->json(['error' => 'Failed to generate syllabus content. Please try again.'], 500);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            $status = $e->getCode() ?: 500;
            // Ensure status is valid HTTP status
            if ($status < 100 || $status > 599) $status = 500;
            
            return response()->json(['error' => $e->getMessage()], $status);
        }
    }
}
