<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SyllabusGeneratorController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
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

        $result = $this->geminiService->generateSyllabusContent($courseTitle, $courseCode, $courseDescription, $weeks, $cmoYear, $cmoTitle);

        if (!$result) {
            return response()->json(['error' => 'Failed to generate syllabus content. Please try again.'], 500);
        }

        return response()->json($result);
    }
}
