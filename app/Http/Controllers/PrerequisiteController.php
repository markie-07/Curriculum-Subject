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
        $prerequisites = Prerequisite::where('curriculum_id', $curriculum->id)
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
            
            $syllabusType = ($type === 'gen-ed-college') ? 'CHED' : 'DepEd';
            $subjectTypes = ['Minor', 'General', 'Elective'];
    
            $subjects = Subject::whereIn('subject_type', $subjectTypes)
                ->where('syllabus_type', $syllabusType)
                ->orderBy('subject_name')
                ->get();
    
            $subjectCodes = $subjects->pluck('subject_code');
            
            // Fetch prerequisites where the child subject is in our list
            $prerequisites = Prerequisite::whereIn('subject_code', $subjectCodes)
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
            
            // Find all curriculums of this level
            $curriculums = Curriculum::where('year_level', $level)->get();
            $updatedCount = 0;

            foreach ($curriculums as $curriculum) {
                 // Update only if curriculum contains this subject OR if we decide Gen Ed applies everywhere independently (usually subject must exist in curriculum)
                 // Checking if subject exists in curriculum first is safer.
                 $hasSubject = $curriculum->subjects()->where('subject_code', $validated['subject_code'])->exists();
                 
                 if ($hasSubject) {
                     // Delete existing prerequisites for this subject in this curriculum
                     Prerequisite::where('curriculum_id', $curriculum->id)
                        ->where('subject_code', $validated['subject_code'])
                        ->delete();
                     
                     // Add new prerequisites
                     if (!empty($validated['prerequisite_codes'])) {
                        $previousSubject = $validated['subject_code'];
                        foreach ($validated['prerequisite_codes'] as $prereqCode) {
                            Prerequisite::create([
                                'curriculum_id' => $curriculum->id,
                                'subject_code' => $prereqCode,
                                'prerequisite_subject_code' => $previousSubject,
                            ]);
                            $previousSubject = $prereqCode;
                        }
                    }
                    $updatedCount++;
                    
                    // Mark curriculum as processing if it was rejected
                    if ($curriculum->approval_status === 'rejected') {
                        $curriculum->update(['approval_status' => 'processing']);
                    }
                 }
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

            // Find related curriculums to sync prerequisites using Program Code (preferred) or Name
            $query = Curriculum::where('year_level', $primaryCurriculum->year_level)
                ->where('version_status', '!=', 'old');
            
            if (!empty($primaryCurriculum->program_code)) {
                $query->where('program_code', $primaryCurriculum->program_code);
            } else {
                $query->where('curriculum', $primaryCurriculum->curriculum);
            }
            
            $targets = $query->get();
            
            $updatedCount = 0;

            foreach ($targets as $target) {
                // Ensure the subject exists in the target curriculum before adding prerequisites
                // This prevents adding orphaned prerequisites to a curriculum that doesn't have the subject
                $hasSubject = $target->subjects()->where('subject_code', $validated['subject_code'])->exists();
                
                if ($hasSubject) {
                    // If curriculum was rejected, revert to processing on modification
                    if ($target->approval_status === 'rejected') {
                        $target->update(['approval_status' => 'processing']);
                    }

                    // First, delete all existing prerequisites for this subject to avoid duplicates
                    Prerequisite::where('curriculum_id', $target->id)
                        ->where('subject_code', $validated['subject_code'])
                        ->delete();

                    // Now, add the new prerequisites from the form submission
                    if (!empty($validated['prerequisite_codes'])) {
                        $previousSubject = $validated['subject_code']; 
                        
                        foreach ($validated['prerequisite_codes'] as $prereqCode) {
                            Prerequisite::create([
                                'curriculum_id' => $target->id,
                                'subject_code' => $prereqCode, 
                                'prerequisite_subject_code' => $previousSubject, 
                            ]);
                            
                            $previousSubject = $prereqCode;
                        }
                    }
                    $updatedCount++;
                }
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