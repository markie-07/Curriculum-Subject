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
            ->orderBy('curriculum')
            ->get();

        return view('pre_requisite', compact('curriculums'));
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
            
            \Illuminate\Support\Facades\Log::info('fetchGeneralData called', ['type' => $type]);
            
            // Determine Syllabus and Subject Types based on the requested global context
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
                // Default to College Gen Ed
                $syllabusType = 'CHED';
                $subjectTypes = ['Minor', 'General', 'Elective'];
            }
    
            $subjects = Subject::whereIn('subject_type', $subjectTypes)
                ->where('syllabus_type', $syllabusType)
                ->orderBy('subject_name')
                ->get();
    
            $subjectCodes = $subjects->pluck('subject_code');
            
            // Fetch prerequisites where the child subject is in our list
            // Added distinct() to prevent duplicate rows in the global view
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

        // Handle General Education Bulk Update
        if (in_array($validated['curriculum_id'], ['gen-ed-college', 'gen-ed-shs'])) {
            $level = ($validated['curriculum_id'] === 'gen-ed-college') ? 'College' : 'Senior High';
            
            $updatedCount = 0;

            // FETCH ONLY THE LATEST CURRICULUM to serve as the 'host' for these global rules.
            // Since fetchData now checks globally by subject_code, we don't need to duplicate rows.
            $targetCurriculum = Curriculum::where('year_level', $level)->latest()->first();
            
            if ($targetCurriculum) {
                if (!empty($validated['prerequisite_codes'])) {
                    $previousSubject = $validated['subject_code'];
                    foreach ($validated['prerequisite_codes'] as $prereqCode) {
                         // Delete existing GLOBAL prerequisites for this dependent subject
                         Prerequisite::whereIn('curriculum_id', Curriculum::where('year_level', $level)->pluck('id'))
                            ->where('subject_code', $prereqCode)
                            ->delete();
                         
                         // Add new prerequisite: $prereqCode depends on $previousSubject
                        Prerequisite::create([
                            'curriculum_id' => $targetCurriculum->id,
                            'subject_code' => $prereqCode,
                            'prerequisite_subject_code' => $previousSubject,
                        ]);
                        $previousSubject = $prereqCode;
                    }
                }
                $updatedCount++;
            }
                    
                    // Mark curriculum as processing if it was rejected
                    if ($targetCurriculum && $targetCurriculum->approval_status === 'rejected') {
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