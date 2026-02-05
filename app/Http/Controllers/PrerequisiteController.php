<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\Prerequisite;
use App\Models\Subject;

class PrerequisiteController extends Controller
{
    /**
     * Display the prerequisite management page.
     */
    public function index()
    {
        if (auth()->user()) {
            \App\Services\ActivityLogService::logPageView('Pre-requisite');
            auth()->user()->updateLastActivity();
        }

        // Filter out Senior High curriculums explicitly
        $shsCodes = [
            'ABM', 'GAS', 'HUMSS', 'STEM', 'STEM – PBM',
            'HECF', 'HEHRS', 'HEHO', 'HETEM',
            'ICT-HW', 'ICT-CP', 'ICT Animation', 'ICT CCS', 'ICT Visual Graphics'
        ];

        $curriculums = Curriculum::whereNotIn('program_code', $shsCodes)
            ->where('program_code', '!=', 'SYS-GLOBAL') // Hide system buffer
            ->orderBy('curriculum')
            ->get();

        // Check for active subject categories (those that have prerequisites set)
        $activeCategories = [];
        $categoryMap = [
            'gen-ed-college' => 'General Education (NSTP 1, NSTP 2)',
            'prof-non-lab' => 'Professional Subject Non Laboratory',
            'prof-lab' => 'Professional Subject Laboratory',
            'prof-board' => 'Professional Subject Board Courses',
            'prof-non-board' => 'Professional Subject Non Board Courses',
            'prof-oc' => 'Professional Subject OC',
            'research' => 'Research',
            'ojt' => 'OJT/Practicum',
        ];

        foreach ($categoryMap as $key => $displayName) {
            // Special handling for gen-ed-college
            if ($key === 'gen-ed-college') {
                // Check for NSTP 1, NSTP 2, or General Education subjects
                $subjectCodes = Subject::whereIn('course_classification', ['NSTP 1', 'NSTP 2', 'General Education'])
                    ->pluck('subject_code');
            } else {
                // Find subjects of this classification
                $subjectCodes = Subject::where('course_classification', $displayName)->pluck('subject_code');
            }
            
            // Check if any prerequisites exist for these subjects
            if (Prerequisite::whereIn('subject_code', $subjectCodes)->exists()) {
                $activeCategories[] = [
                    'id' => $key,
                    'name' => $displayName
                ];
            }
        }

        return view('pre_requisite', compact('curriculums', 'activeCategories', 'categoryMap'));
    }

    /**
     * Fetch subjects and existing prerequisites for a given curriculum.
     * This will be called by our JavaScript.
     */
    public function fetchData(Curriculum $curriculum)
    {
        // Load subjects and explicitly ORDER THEM by their year and semester
        // from the curriculum mapping (the pivot table). This is the key to correct sorting.
        $curriculum->load(['subjects' => function ($query) {
            $query->orderBy('pivot_year', 'asc')->orderBy('pivot_semester', 'asc');
        }]);

        // The subjects collection is now correctly sorted according to your mapping.
        $subjects = $curriculum->subjects;

        // Group by the subject that HAS prerequisites (Child -> Parents)
        // Returns objects like { "ChildCode": [ { subject_code: "ChildCode", prerequisite_subject_code: "ParentCode", ... } ] }
        
        // Fix: Fetch distinct prerequisites to avoid duplicates and ensure all relevant rules are found
        // mimic "Minor Subject" logic by checking subject codes too
        $subjectCodes = $subjects->pluck('subject_code')->unique()->values();
        
        $prerequisites = Prerequisite::where(function($q) use ($curriculum, $subjectCodes) {
                $q->where('curriculum_id', $curriculum->id)
                  ->orWhereIn('subject_code', $subjectCodes);
            })
            ->select('subject_code', 'prerequisite_subject_code')
            ->distinct()
            ->get()
            ->groupBy('subject_code');

        return response()->json([
            'subjects' => $subjects,
            'prerequisites' => $prerequisites,
        ]);
    }

    /**
     * Fetch general education subjects based on type.
     */
    public function fetchGeneralData($type)
    {
        try {
            \Illuminate\Support\Facades\Log::info('fetchGeneralData called', ['type' => $type]);
            
            // Map virtual IDs to Course Classifications
            $categoryMap = [
                'gen-ed-college' => ['NSTP 1', 'NSTP 2', 'General Education'], // Special: array of classifications
                'prof-non-lab' => 'Professional Subject Non Laboratory',
                'prof-lab' => 'Professional Subject Laboratory',
                'prof-board' => 'Professional Subject Board Courses',
                'prof-non-board' => 'Professional Subject Non Board Courses',
                'prof-oc' => 'Professional Subject OC',
                'research' => 'Research',
                'ojt' => 'OJT/Practicum',
            ];

            if (array_key_exists($type, $categoryMap)) {
                // Handling Category-based Virtual IDs
                $classification = $categoryMap[$type];
                
                // Special handling for gen-ed-college (array of classifications)
                if (is_array($classification)) {
                    $subjects = Subject::whereIn('course_classification', $classification)
                        ->orderBy('subject_name')
                        ->get();
                } else {
                    $subjects = Subject::where('course_classification', $classification)
                        ->orderBy('subject_name')
                        ->get();
                }

            } else {
                // Determine Syllabus and Subject Types based on the requested global context (Gen Ed)
                if ($type === 'major-college') {
                    $syllabusType = 'CHED';
                    $subjectTypes = ['Major'];
                } elseif ($type === 'major-shs') {
                    $syllabusType = 'DepEd';
                    $subjectTypes = ['Major', 'Core', 'Applied', 'Specialized'];
                } elseif ($type === 'gen-ed-shs') {
                    $syllabusType = 'DepEd';
                    $subjectTypes = ['Minor', 'General', 'Elective'];
                } else {
                    // Default fallback
                    $syllabusType = 'CHED';
                    $subjectTypes = ['Minor', 'General', 'Elective'];
                }
        
                $subjects = Subject::whereIn('subject_type', $subjectTypes)
                    ->where('syllabus_type', $syllabusType)
                    ->orderBy('subject_name')
                    ->get();
            }
    
            $subjectCodes = $subjects->pluck('subject_code');
            
            // Fetch prerequisites where the child subject is in our list
            $prerequisites = Prerequisite::whereIn('subject_code', $subjectCodes)
                ->select('subject_code', 'prerequisite_subject_code')
                ->distinct()
                ->get()
                ->groupBy('subject_code');
            
            return response()->json([
                'subjects' => $subjects,
                'prerequisites' => $prerequisites,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in fetchGeneralData: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store the prerequisite relationships for a subject.
     */
    public function store(Request $request)
    {
        // Adjusted validation to manually handle special curriculum IDs
        $rules = [
            'curriculum_id' => 'required', // Removed strict exists check here
            'subject_code' => 'required|string',
            'prerequisite_codes' => 'nullable|array',
            'prerequisite_codes.*' => 'string',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        // Handle General Education and Category/Virtual ID Bulk Updates
        $virtualIds = [
            'gen-ed-college', 'gen-ed-shs',
            'prof-non-lab', 'prof-lab', 'prof-board', 'prof-non-board', 'prof-oc',
            'research', 'ojt'
        ];

        if (in_array($validated['curriculum_id'], $virtualIds)) {
            // Determine level. SHS is unique, everything else defaults to College
            $level = ($validated['curriculum_id'] === 'gen-ed-shs') ? 'Senior High' : 'College';
            
            $updatedCount = 0;

            // FETCH ONLY THE LATEST CURRICULUM to serve as the 'host' for these global rules.
            // Try to find by year_level first, then fallback to any curriculum
            $targetCurriculum = Curriculum::where('year_level', $level)->latest()->first();
            
            // Fallback: If no curriculum found with year_level, try to find any curriculum
            // For College: exclude SHS/Senior High patterns
            // For SHS: look for SHS/Senior High patterns
            if (!$targetCurriculum) {
                if ($level === 'College') {
                    $targetCurriculum = Curriculum::where('curriculum', 'NOT LIKE', '%Senior High%')
                        ->where('curriculum', 'NOT LIKE', '%SHS%')
                        ->latest()
                        ->first();
                } else {
                    $targetCurriculum = Curriculum::where(function($query) {
                        $query->where('curriculum', 'LIKE', '%Senior High%')
                              ->orWhere('curriculum', 'LIKE', '%SHS%');
                    })->latest()->first();
                }
                
                // Final Fallback: If still no curriculum found (e.g., unexpected naming), just pick the latest one.
                if (!$targetCurriculum) {
                    $targetCurriculum = Curriculum::latest()->first();
                }

                // ABSOLUTE FINAL FALLBACK: Create a placeholder curriculum if the database is empty.
                // This handles the case where the user has 0 curriculums but tries to set prerequisites.
                if (!$targetCurriculum) {
                    try {
                        $targetCurriculum = Curriculum::create([
                            'curriculum' => 'Global Prerequisite Storage (System)',
                            'program_code' => 'SYS-GLOBAL',
                            'year_level' => 'College',
                            'academic_year' => date('Y') . '-' . (date('Y') + 1),
                            'semester_units' => [],
                            'total_units' => 0,
                            'version_status' => 'approved',
                            'approval_status' => 'approved'
                        ]);
                    } catch (\Exception $e) {
                        // Fallback in case of strict validation/database errors on create
                        return response()->json([
                            'error' => "No curriculum found and failed to auto-create storage: " . $e->getMessage(),
                        ], 500);
                    }
                }
            }
            
            if ($targetCurriculum) {
                // Delete existing prerequisites for this subject in the target curriculum
                Prerequisite::where('curriculum_id', $targetCurriculum->id)
                    ->where('subject_code', $validated['subject_code'])
                    ->delete();
                
                if (!empty($validated['prerequisite_codes'])) {
                    // Create prerequisites in the correct order
                    // The main subject depends on all the prerequisite codes
                    foreach ($validated['prerequisite_codes'] as $prereqCode) {
                        Prerequisite::create([
                            'curriculum_id' => $targetCurriculum->id,
                            'subject_code' => $validated['subject_code'], // The subject that HAS prerequisites
                            'prerequisite_subject_code' => $prereqCode,    // The subject it DEPENDS ON
                        ]);
                    }
                }
                $updatedCount++;

                // Log activity for Virtual/Category updates
                if (auth()->user()) {
                    $categoryName = ucwords(str_replace(['-', '_'], ' ', $validated['curriculum_id']));
                    \App\Services\ActivityLogService::log(
                        'prerequisite',
                        'Updated prerequisites for ' . $validated['subject_code'] . ' (Category: ' . $categoryName . ')',
                        [
                            'category' => $validated['curriculum_id'],
                            'subject_code' => $validated['subject_code'],
                            'prerequisites' => $validated['prerequisite_codes'] ?? [],
                            'synced_count' => $updatedCount
                        ]
                    );
                    auth()->user()->updateLastActivity();
                }
                
                // Mark curriculum as processing if it was rejected
                if ($targetCurriculum->approval_status === 'rejected') {
                    $targetCurriculum->update(['approval_status' => 'processing']);
                }
                
                return response()->json([
                    'message' => "Prerequisites updated for $updatedCount $level curriculums containing this subject!",
                    'notification' => [
                         'type' => 'success',
                         'title' => 'Bulk Update Successful',
                         'message' => "Prerequisites updated for $updatedCount $level curriculums!"
                    ]
                ]);
            } else {
                // No curriculum found for this level
                return response()->json([
                    'error' => "No $level curriculum found. Please create a curriculum first.",
                    'notification' => [
                        'type' => 'error',
                        'title' => 'No Curriculum Found',
                        'message' => "No $level curriculum found. Please create a curriculum first."
                    ]
                ], 404);
            }

        } else {
            // Normal Curriculum Flow
            // Manually validate that curriculum_id exists since we removed it from rules
            $primaryCurriculum = Curriculum::find($validated['curriculum_id']);
            if (!$primaryCurriculum) {
                 return response()->json(['errors' => ['curriculum_id' => ['The selected curriculum is invalid.']]], 422);
            }

            // Disable auto-sync to unrelated versions to prevent "duplicate data" per user request
            // Only update the specific curriculum selected
            $targets = collect([$primaryCurriculum]);
            
            $updatedCount = 0;

            foreach ($targets as $target) {
                    // If curriculum was rejected, revert to processing on modification
                    if ($target->approval_status === 'rejected') {
                        $target->update(['approval_status' => 'processing']);
                    }

                    // Now, add the new prerequisites from the form submission
                    if (!empty($validated['prerequisite_codes'])) {
                        $previousSubject = $validated['subject_code']; 
                        
                        foreach ($validated['prerequisite_codes'] as $prereqCode) {
                             // First, delete all existing prerequisites for this dependent subject to avoid duplicates
                            Prerequisite::where('curriculum_id', $target->id)
                                ->where('subject_code', $prereqCode)
                                ->delete();

                            Prerequisite::create([
                                'curriculum_id' => $target->id,
                                'subject_code' => $prereqCode, // Dependent
                                'prerequisite_subject_code' => $previousSubject, // Prerequisite
                            ]);
                            
                            $previousSubject = $prereqCode;
                        }
                    }
                    $updatedCount++;
            }

            // Log activity
            if (auth()->user()) {
                \App\Services\ActivityLogService::log(
                    'prerequisite',
                    'Updated prerequisites for ' . $validated['subject_code'] . ' in ' . $primaryCurriculum->curriculum . " (Synced to $updatedCount versions)",
                    [
                        'curriculum_id' => $validated['curriculum_id'],
                        'subject_code' => $validated['subject_code'],
                        'prerequisites' => $validated['prerequisite_codes'],
                        'synced_count' => $updatedCount
                    ]
                );
                auth()->user()->updateLastActivity();
            }

            // Flash success message for session-based requests
            session()->flash('success', 'Prerequisites for "' . $validated['subject_code'] . '" have been saved successfully!');
            
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Prerequisites saved successfully!',
                    'notification' => [
                        'type' => 'success',
                        'title' => 'Prerequisites Saved!',
                        'message' => "Prerequisites for '" . $validated['subject_code'] . "' updated across $updatedCount curriculums!"
                    ]
                ]);
            }
            
            return response()->json(['message' => 'Prerequisites saved successfully!']);
        }
    }
}