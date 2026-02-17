<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\GradeVersion;
use App\Models\Subject;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    /**
     * Display the grade setup page.
     * This method loads the main view and is called by your web.php route.
     */
    public function setup()
    {
        // Log page view activity

        
        // Get subjects that already have a grade setup to display in the Grade History
        $subjectsWithGrades = Grade::with('subject')->get()->pluck('subject')->filter();

        return view('grade_setup', ['subjects' => $subjectsWithGrades]);
    }

    /**
     * Get the grade setup for a specific subject ID.
     * This is used by the frontend JavaScript to fetch data.
     */
    public function show($id)
    {
        // We now fetch the grade setup using the subject_id
        $grade = Grade::with('subject')->where('subject_id', $id)->first();

        // If no setup exists for a subject, return null so the frontend can use a default
        if (!$grade) {
            return response()->json(['components' => null]);
        }
        return response()->json($grade);
    }

    /**
     * Get all grades.
     */
    public function index()
    {
        return response()->json(Grade::all());
    }

    /**
     * Store or update a grade setup.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'components' => 'required|array', // Ensure 'components' is a valid array/object
            'curriculum_id' => 'nullable|exists:curriculums,id',
            'subject_category' => 'nullable|string',
            'effectivity_start_date' => 'nullable|date',
            'effectivity_end_date' => 'nullable|date|after_or_equal:effectivity_start_date',
        ]);

        \Illuminate\Support\Facades\Log::info('Grade Store Request:', $request->all());

        DB::beginTransaction();
        try {
            // Find existing grade to check if this is an update
            $existingGrade = Grade::where('subject_id', $validated['subject_id'])->first();
            
            // If grade exists, save current version before updating
            if ($existingGrade) {
                GradeVersion::createFromGrade(
                    $existingGrade,
                    'Grade scheme updated',
                    auth()->user()->name ?? 'System'
                );
            }

            // Prepare data for update/create
            $gradeData = ['components' => $validated['components']];
            
            // Add curriculum_id and course_type if provided
            if (isset($validated['curriculum_id'])) {
                $gradeData['curriculum_id'] = $validated['curriculum_id'];
            }
            if (isset($validated['subject_category'])) {
                $gradeData['subject_category'] = $validated['subject_category'];
            } else {
                // Fallback: Try to get from Subject or default to 'General'
                $subject = Subject::find($validated['subject_id']);
                $gradeData['subject_category'] = $subject ? $subject->subject_type : 'General';
            }
            if (isset($validated['effectivity_start_date'])) {
                $gradeData['effectivity_start_date'] = $validated['effectivity_start_date'];
            }
            if (isset($validated['effectivity_end_date'])) {
                $gradeData['effectivity_end_date'] = $validated['effectivity_end_date'];
            }

            // Find or create the grade setup for the given subject
            $grade = Grade::updateOrCreate(
                ['subject_id' => $validated['subject_id']],
                $gradeData
            );
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save grade scheme: ' . $e->getMessage()
            ], 500);
        }
        
        // Return the subject details so the JavaScript can add it to the "Grade History" list.
        $subject = Subject::find($validated['subject_id']);

        // Log activity
        if (auth()->user()) {
            \App\Services\ActivityLogService::log(
                'grade_setup',
                'Set grade scheme for subject "' . $subject->subject_name . '"',
                [
                    'subject_id' => $subject->id, 
                    'subject_code' => $subject->subject_code,
                    'curriculum_id' => $validated['curriculum_id'] ?? null
                ]
            );
            auth()->user()->updateLastActivity();
        }

        // Flash success message for session-based requests
        session()->flash('success', 'Grade scheme for "' . $subject->subject_name . '" has been saved successfully!');
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Grade scheme saved successfully!',
                'subject' => $subject,
                'notification' => [
                    'type' => 'success',
                    'title' => 'Grade Scheme Saved!',
                    'message' => 'Grade scheme for "' . $subject->subject_name . '" has been saved successfully!'
                ]
            ], 201);
        }

        return response()->json([
            'success' => true,
            'message' => 'Grade scheme saved successfully!',
            'subject' => $subject // Send back the subject data
        ], 201);
    }

    /**
     * Get grade version history for a specific subject
     */
    public function getGradeVersionHistory($subjectId)
    {
        try {
            // Get current grade with subject relationship
            $currentGrade = Grade::with('subject.curriculums')->where('subject_id', $subjectId)->first();
            
            if (!$currentGrade) {
                return response()->json([
                    'current_version' => null,
                    'previous_version' => null,
                    'has_previous_version' => false,
                    'message' => 'No grade scheme found for this subject'
                ]);
            }

            // Get curriculum_id and subject_category from grade, or infer from subject's first curriculum
            $curriculumId = $currentGrade->curriculum_id;
            $subjectCategory = $currentGrade->subject_category;
            
            // If curriculum_id or subject_category is NULL, try to get from subject's curriculum relationship
            if (!$curriculumId || !$subjectCategory) {
                $subject = $currentGrade->subject;
                $firstCurriculum = $subject->curriculums()->first();
                
                if ($firstCurriculum) {
                    $curriculumId = $curriculumId ?? $firstCurriculum->id;
                }
                
                // Infer subject_category from subject_type if not set (Legacy Support)
                if (!$subjectCategory && $subject) {
                     $subjectCategory = $subject->subject_type;
                }
            }

            // Get all previous versions, newest first
            $versions = GradeVersion::where('subject_id', $subjectId)
                ->orderBy('version_number', 'desc')
                ->get();

            $versionsArray = $versions->map(function ($v) use ($curriculumId, $subjectCategory) {
                return [
                    'version_number' => $v->version_number,
                    'components' => $v->components,
                    'curriculum_id' => $v->curriculum_id ?? $curriculumId,
                    'subject_category' => $v->subject_category ?? $subjectCategory,
                    'change_reason' => $v->change_reason,
                    'changed_by' => $v->changed_by,
                    'updated_at' => $v->created_at,
                    'created_at' => $v->created_at,
                ];
            })->values();

            return response()->json([
                'current_version' => [
                    'components' => $currentGrade->components,
                    'curriculum_id' => $curriculumId,
                    'subject_category' => $subjectCategory,
                    'effectivity_start_date' => $currentGrade->effectivity_start_date,
                    'effectivity_end_date' => $currentGrade->effectivity_end_date,
                    'updated_at' => $currentGrade->updated_at,
                ],
                'previous_versions' => $versionsArray->toArray(),
                'has_previous_version' => $versions->isNotEmpty(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch grade version history: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store curriculum-based grade schemes
     */
    public function storeCurriculumGrades(Request $request)
    {
        $validated = $request->validate([
            'curriculum_id' => 'required|exists:curriculums,id',
            'subject_category' => 'required|string',
            'subjects' => 'required|array',
            'subjects.*.subject_id' => 'required|exists:subjects,id',
            'subjects.*.components' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $curriculum = Curriculum::findOrFail($validated['curriculum_id']);
            $savedSubjects = [];

            foreach ($validated['subjects'] as $subjectData) {
                // Find existing grade to check if this is an update
                $existingGrade = Grade::where('subject_id', $subjectData['subject_id'])->first();
                
                // If grade exists, save current version before updating
                if ($existingGrade) {
                    GradeVersion::createFromGrade(
                        $existingGrade,
                        'Curriculum grade scheme updated',
                        auth()->user()->name ?? 'System'
                    );
                }
                
                $grade = Grade::updateOrCreate(
                    ['subject_id' => $subjectData['subject_id']],
                    [
                        'components' => $subjectData['components'],
                        'curriculum_id' => $validated['curriculum_id'],
                        'subject_category' => $validated['subject_category']
                    ]
                );

                $subject = Subject::find($subjectData['subject_id']);
                $savedSubjects[] = $subject;
            }

            DB::commit();

            // Log activity
            if (auth()->user()) {
                $categoryText = $validated['subject_category'];
                \App\Services\ActivityLogService::log(
                    'grade_setup',
                    "Set grade schemes for {$categoryText} in curriculum \"{$curriculum->curriculum}\"",
                    [
                        'curriculum_id' => $curriculum->id,
                        'subject_category' => $validated['subject_category'],
                        'subject_count' => count($savedSubjects)
                    ]
                );
                auth()->user()->updateLastActivity();
            }

            // Flash success message
            $categoryText = $validated['subject_category'];
            session()->flash('success', "Grade schemes for {$categoryText} in curriculum \"{$curriculum->curriculum}\" have been saved successfully!");
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Curriculum grade schemes saved successfully!',
                    'curriculum' => [
                        'id' => $curriculum->id,
                        'curriculum_name' => $curriculum->curriculum,
                        'program_code' => $curriculum->program_code,
                        'academic_year' => $curriculum->academic_year
                    ],
                    'subjects' => $savedSubjects,
                    'notification' => [
                        'type' => 'success',
                        'title' => 'Grade Schemes Saved!',
                        'message' => "Grade schemes for {$categoryText} have been saved successfully!"
                    ]
                ], 201);
            }

            return response()->json([
                'success' => true,
                'message' => 'Curriculum grade schemes saved successfully!',
                'curriculum' => $curriculum
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save curriculum grade schemes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all curriculums that have grade schemes set up
     */
    public function getAllCurriculumGrades()
    {
        try {
            // Get all curriculums that have at least one subject with grades for that curriculum
            $curriculumsWithGrades = Curriculum::whereHas('subjects.grade', function ($query) {
                    $query->whereColumn('grades.curriculum_id', 'curriculums.id')
                        ->orWhereNull('grades.curriculum_id');
                })
                ->with(['subjects' => function ($query) {
                    $query->whereHas('grade');
                }])
                ->get()
                ->map(function ($curriculum) {
                    // Count only subjects that have grades for this specific curriculum
                    $subjectsWithGradesCount = $curriculum->subjects->filter(function ($subject) use ($curriculum) {
                        return $subject->grade && 
                            ($subject->grade->curriculum_id == $curriculum->id || $subject->grade->curriculum_id === null);
                    })->count();
                    
                    return [
                        'id' => $curriculum->id,
                        'curriculum_name' => $curriculum->curriculum,
                        'program_code' => $curriculum->program_code,
                        'academic_year' => $curriculum->academic_year,
                        'subjects_with_grades_count' => $subjectsWithGradesCount
                    ];
                })
                ->filter(function ($curriculum) {
                    // Only include curriculums that actually have subjects with grades
                    return $curriculum['subjects_with_grades_count'] > 0;
                })
                ->values();

            return response()->json($curriculumsWithGrades);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch curriculum grades: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get curriculum grade schemes with subjects
     */
    public function getCurriculumGrades($curriculumId)
    {
        try {
            $curriculum = Curriculum::with(['subjects' => function ($query) {
                $query->with('grade');
            }])->findOrFail($curriculumId);

            $subjects = $curriculum->subjects->map(function ($subject) use ($curriculumId) {
                // Check if the subject has a grade AND if that grade belongs to this curriculum
                $hasGradesForThisCurriculum = $subject->grade && 
                    ($subject->grade->curriculum_id == $curriculumId || $subject->grade->curriculum_id === null);
                
                return [
                    'id' => $subject->id,
                    'subject_name' => $subject->subject_name,
                    'subject_code' => $subject->subject_code,
                    'subject_type' => $subject->subject_type,
                    'subject_unit' => $subject->subject_unit,
                    'has_grades' => $hasGradesForThisCurriculum,
                    'grade_components' => $hasGradesForThisCurriculum ? $subject->grade->components : null,
                    'effectivity_start_date' => $hasGradesForThisCurriculum ? $subject->grade->effectivity_start_date : null,
                    'effectivity_end_date' => $hasGradesForThisCurriculum ? $subject->grade->effectivity_end_date : null,
                ];
            });

            return response()->json([
                'curriculum' => [
                    'id' => $curriculum->id,
                    'curriculum_name' => $curriculum->curriculum,
                    'program_code' => $curriculum->program_code,
                    'academic_year' => $curriculum->academic_year
                ],
                'subjects' => $subjects
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch curriculum grade details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all available grading templates for API integration
     * Returns the predefined grading templates used in the system
     */
    public function getGradingTemplates()
    {
        try {
            $templatesFromDb = \App\Models\GradingTemplate::where('is_active', true)->get();
            
            $formattedTemplates = [];
            foreach ($templatesFromDb as $template) {
                $formattedTemplates[] = [ // Changed from keyed array to indexed array
                    'id' => $template->id,
                    'code' => $template->code, // Ensure code is included in the object
                    'name' => $template->name,
                    'description' => $template->description,
                    'periods' => $template->periods,
                    'components' => $template->components,
                    'is_active' => $template->is_active,
                ];
            }

            return response()->json([
                'success' => true,
                'templates' => $formattedTemplates,
                'metadata' => [
                    'total_templates' => count($formattedTemplates),
                    'timestamp' => now()->toIso8601String(),
                    'note' => 'All weights are in percentages and must sum to 100%. Fetched from database.'
                ]
            ])->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch grading templates: ' . $e->getMessage()
            ], 500);
        }
    }
}