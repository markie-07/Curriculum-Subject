<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DescriptionSimilarityController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Check if a course description is semantically similar to existing courses
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request)
    {
        try {
            $validated = $request->validate([
                'description' => 'required|string',
                'current_subject_id' => 'nullable|integer|exists:subjects,id'
            ]);

            $description = $validated['description'];
            $currentSubjectId = $validated['current_subject_id'] ?? null;

            // Get all existing courses except the current one (if updating)
            $query = Subject::select('id', 'subject_name', 'subject_code', 'course_description')
                ->whereNotNull('course_description')
                ->where('course_description', '!=', '');

            if ($currentSubjectId) {
                $query->where('id', '!=', $currentSubjectId);
            }

            $existingCourses = $query->get()->toArray();

            // If no existing courses, no similarity check needed
            if (empty($existingCourses)) {
                return response()->json([
                    'has_similar' => false,
                    'similar_courses' => []
                ]);
            }

            // Use Gemini AI to check for semantic similarity
            $similarCourses = $this->geminiService->compareDescriptionSimilarity(
                $description,
                $existingCourses
            );

            return response()->json([
                'has_similar' => count($similarCourses) > 0,
                'similar_courses' => $similarCourses
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Description similarity check error: ' . $e->getMessage());
            
            // Return no similar courses on error to allow saving
            return response()->json([
                'has_similar' => false,
                'similar_courses' => [],
                'error' => 'Similarity check unavailable'
            ]);
        }
    }
}
