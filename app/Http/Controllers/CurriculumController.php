<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Notification;
use App\Services\CurriculumVersionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CurriculumController extends Controller
{
    /**
     * Retrieves all curriculums formatted for a dropdown selector.
     */
    public function index()
    {
        // Automatically manage curriculum lifecycle based on expiration dates
        $today = Carbon::today();

        // 1. Delete expired processing/rejected curriculums (User Request: "should not display on the database")
        Curriculum::whereIn('approval_status', ['processing', 'rejected'])
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', $today)
            ->delete();

        // 2. Mark approved expired curriculums as 'old' (User Request: "it will become old curriculum")
        Curriculum::where('approval_status', 'approved')
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', $today)
            ->where('version_status', '!=', 'old')
            ->update(['version_status' => 'old']);

        $curriculums = Curriculum::withCount(['subjects', 'subjects as mapped_subjects_count' => function ($query) {
                $query->whereNotNull('curriculum_subject.year')
                      ->whereNotNull('curriculum_subject.semester');
            }])
            ->withSum(['subjects as mapped_units_sum' => function ($query) {
                $query->whereNotNull('curriculum_subject.year')
                      ->whereNotNull('curriculum_subject.semester');
            }], 'subject_unit')
            ->orderBy('year_level')
            ->orderBy('curriculum')
            ->orderByDesc('academic_year')
            ->get()
            ->map(function ($curriculum) {
                return [
                    'id' => $curriculum->id,
                    'curriculum_name' => $curriculum->curriculum,
                    'program_code' => $curriculum->program_code,
                    'academic_year' => $curriculum->academic_year,
                    'expiration_date' => $curriculum->expiration_date,
                    'year_level' => $curriculum->year_level,
                    'compliance' => $curriculum->compliance,
                    'memorandum_year' => $curriculum->memorandum_year,
                    'memorandum_category' => $curriculum->memorandum_category,
                    'memorandum' => $curriculum->memorandum,
                    'semester_units' => $curriculum->semester_units,
                    'total_units' => $curriculum->total_units,
                    'version_status' => $curriculum->version_status,
                    'approval_status' => $curriculum->approval_status,
                    'created_at' => $curriculum->created_at,
                    'subjects_count' => $curriculum->subjects_count,
                    'mapped_units' => $curriculum->mapped_units_sum,
                    'mapped_subjects_count' => $curriculum->mapped_subjects_count,
                ];
            });
        return response()->json($curriculums);
    }

    /**
     * Retrieves only APPROVED curriculums.
     */
    public function getApproved()
    {
        // Automatically manage curriculum lifecycle based on expiration dates
        $today = Carbon::today();

        // Mark approved expired curriculums as 'old'
        Curriculum::where('approval_status', 'approved')
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', $today)
            ->where('version_status', '!=', 'old')
            ->update(['version_status' => 'old']);

        $curriculums = Curriculum::withCount(['subjects', 'subjects as mapped_subjects_count' => function ($query) {
                $query->whereNotNull('curriculum_subject.year')
                      ->whereNotNull('curriculum_subject.semester');
            }])
            ->withSum(['subjects as mapped_units_sum' => function ($query) {
                $query->whereNotNull('curriculum_subject.year')
                      ->whereNotNull('curriculum_subject.semester');
            }], 'subject_unit')
            ->where('approval_status', 'approved') // Only get approved curriculums
            ->orderBy('year_level')
            ->orderBy('curriculum')
            ->orderByDesc('academic_year')
            ->get()
            ->map(function ($curriculum) {
                return [
                    'id' => $curriculum->id,
                    'curriculum_name' => $curriculum->curriculum,
                    'program_code' => $curriculum->program_code,
                    'academic_year' => $curriculum->academic_year,
                    'expiration_date' => $curriculum->expiration_date,
                    'year_level' => $curriculum->year_level,
                    'compliance' => $curriculum->compliance,
                    'memorandum_year' => $curriculum->memorandum_year,
                    'memorandum_category' => $curriculum->memorandum_category,
                    'memorandum' => $curriculum->memorandum,
                    'semester_units' => $curriculum->semester_units,
                    'total_units' => $curriculum->total_units,
                    'version_status' => $curriculum->version_status,
                    'approval_status' => $curriculum->approval_status,
                    'created_at' => $curriculum->created_at,
                    'subjects_count' => $curriculum->subjects_count,
                    'mapped_units' => $curriculum->mapped_units_sum,
                    'mapped_subjects_count' => $curriculum->mapped_subjects_count,
                ];
            });
        return response()->json($curriculums);
    }

    /**
 * Stores a new curriculum.
 */
public function store(Request $request)
{
    $validated = $request->validate([
        'curriculum' => 'required|string|max:255',
        'programCode' => 'required|string|max:255',
        'academicYear' => 'required|string|max:255',
        'expirationDate' => 'nullable|date|after_or_equal:today',
        'yearLevel' => 'required|in:Senior High,College',
        'compliance' => 'nullable|string|in:CHED,DepEd',
        'memorandumYear' => 'nullable|string|max:4',
        'memorandumCategory' => 'nullable|string|max:255',
        'memorandum' => 'nullable|string',
        'semesterUnits' => 'nullable|array',
        'semesterUnits.*' => 'nullable|numeric|min:0',
        'totalUnits' => 'nullable|numeric|min:0',
    ]);

    // Check for existing curricula with the same name, academic year, and year level
    // This ensures each curriculum with a unique name+year combination is independent
    /* 
    DISABLED: User requested that only expiration date should trigger 'old' status.
    $existingCurricula = Curriculum::where('curriculum', $validated['curriculum'])
        ->where('academic_year', $validated['academicYear'])
        ->where('year_level', $validated['yearLevel'])
        ->get();

    // Mark existing curricula with the same name AND academic year as old version
    if ($existingCurricula->isNotEmpty()) {
        foreach ($existingCurricula as $existing) {
            $existing->update(['version_status' => 'old']);
        }
    }
    */

    $curriculum = Curriculum::create([
        'curriculum' => $validated['curriculum'],
        'program_code' => $validated['programCode'],
        'academic_year' => $validated['academicYear'],
        'expiration_date' => $validated['expirationDate'] ?? null,
        'year_level' => $validated['yearLevel'],
        'compliance' => $validated['compliance'] ?? null,
        'memorandum_year' => $validated['memorandumYear'] ?? null,
        'memorandum_category' => $validated['memorandumCategory'] ?? null,
        'memorandum' => $validated['memorandum'] ?? null,
        'semester_units' => $validated['semesterUnits'] ?? null,
        'total_units' => $validated['totalUnits'] ?? null,
        'version_status' => 'new', // New curricula are marked as 'new'
    ]);

    // Auto-copy subject mappings from the most recent approved curriculum with the same name
    $sourceCurriculum = Curriculum::where('curriculum', $validated['curriculum'])
        ->where('approval_status', 'approved')
        ->where('id', '!=', $curriculum->id) // Exclude the newly created curriculum
        ->orderBy('created_at', 'desc')
        ->first();

    if ($sourceCurriculum) {
        // Get all subject mappings from the source curriculum
        $subjectMappings = DB::table('curriculum_subject')
            ->where('curriculum_id', $sourceCurriculum->id)
            ->get();

        if ($subjectMappings->isNotEmpty()) {
            // Prepare data for bulk insert
            $mappingsToInsert = [];
            foreach ($subjectMappings as $mapping) {
                $mappingsToInsert[] = [
                    'curriculum_id' => $curriculum->id,
                    'subject_id' => $mapping->subject_id,
                    'year' => $mapping->year,
                    'semester' => $mapping->semester,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Bulk insert the mappings
            DB::table('curriculum_subject')->insert($mappingsToInsert);

            Log::info("Auto-copied {$subjectMappings->count()} subject mappings from curriculum ID {$sourceCurriculum->id} to new curriculum ID {$curriculum->id}");
        }
    }

    // Create database notification for admins
    if (Auth::check()) {
        $notificationMessage = 'Curriculum "' . $curriculum->curriculum . '" has been created by ' . Auth::user()->name;
        if ($sourceCurriculum && isset($subjectMappings) && $subjectMappings->isNotEmpty()) {
            $notificationMessage .= ' with ' . $subjectMappings->count() . ' subjects auto-copied from ' . $sourceCurriculum->academic_year;
        }

        Notification::createForAdmins(
            'success',
            'New Curriculum Created',
            $notificationMessage,
            ['curriculum_id' => $curriculum->id, 'action' => 'created']
        );

        // Log activity
        \App\Services\ActivityLogService::log(
            'create_curriculum',
            'Created curriculum "' . $curriculum->curriculum . '"',
            ['curriculum_id' => $curriculum->id, 'program_code' => $curriculum->program_code]
        );
        Auth::user()->updateLastActivity();
    }

    session()->flash('success', 'Curriculum "' . $curriculum->curriculum . '" has been created successfully!');
    
    // Also trigger notification for AJAX requests
    if (request()->wantsJson()) {
        $responseMessage = 'Curriculum created successfully!';
        $notificationMessage = 'Curriculum "' . $curriculum->curriculum . '" has been created successfully!';
        
        if ($sourceCurriculum && isset($subjectMappings) && $subjectMappings->isNotEmpty()) {
            $responseMessage .= ' ' . $subjectMappings->count() . ' subjects were automatically copied from ' . $sourceCurriculum->academic_year . '.';
            $notificationMessage .= ' ' . $subjectMappings->count() . ' subjects were automatically copied from the previous approved curriculum.';
        }

        return response()->json([
            'message' => $responseMessage, 
            'curriculum' => $curriculum,
            'subjects_copied' => isset($subjectMappings) ? $subjectMappings->count() : 0,
            'notification' => [
                'type' => 'success',
                'title' => 'Curriculum Added!',
                'message' => $notificationMessage
            ]
        ], 201);
    }
    
    return response()->json(['message' => 'Curriculum created successfully!', 'curriculum' => $curriculum], 201);
}

    /**
     * Updates an existing curriculum.
     */
    public function update(Request $request, $id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $validated = $request->validate([
            'curriculum' => 'required|string|max:255',
            'programCode' => 'required|string|max:255',
            'academicYear' => 'required|string|max:255',
            'expirationDate' => 'nullable|date|after_or_equal:today',
            'yearLevel' => 'required|in:Senior High,College',
            'compliance' => 'nullable|string|in:CHED,DepEd',
            'memorandumYear' => 'nullable|string|max:4',
            'memorandumCategory' => 'nullable|string|max:255',
            'memorandum' => 'nullable|string',
            'semesterUnits' => 'nullable|array',
            'semesterUnits.*' => 'nullable|numeric|min:0',
            'totalUnits' => 'nullable|numeric|min:0',
        ]);
        
        $curriculum->update([
            'curriculum' => $validated['curriculum'],
            'program_code' => $validated['programCode'],
            'academic_year' => $validated['academicYear'],
            'expiration_date' => $validated['expirationDate'] ?? null,
            'year_level' => $validated['yearLevel'],
            'compliance' => $validated['compliance'] ?? null,
            'memorandum_year' => $validated['memorandumYear'] ?? null,
            'memorandum_category' => $validated['memorandumCategory'] ?? null,
            'memorandum' => $validated['memorandum'] ?? null,
            'semester_units' => $validated['semesterUnits'] ?? null,
            'total_units' => $validated['totalUnits'] ?? null,
        ]);

        // Create database notification for admins
        if (Auth::check()) {
            Notification::createForAdmins(
                'info',
                'Curriculum Updated',
                'Curriculum "' . $curriculum->curriculum . '" has been updated by ' . Auth::user()->name,
                ['curriculum_id' => $curriculum->id, 'action' => 'updated']
            );

            // Log activity
            \App\Services\ActivityLogService::log(
                'revise_curriculum',
                'Revised curriculum "' . $curriculum->curriculum . '"',
                ['curriculum_id' => $curriculum->id, 'changes' => array_keys($validated)]
            );
            Auth::user()->updateLastActivity();
        }

        session()->flash('success', 'Curriculum "' . $curriculum->curriculum . '" has been updated successfully!');
        
        // Also trigger notification for AJAX requests
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Curriculum updated successfully!', 
                'curriculum' => $curriculum,
                'notification' => [
                    'type' => 'success',
                    'title' => 'Curriculum Updated!',
                    'message' => 'Curriculum "' . $curriculum->curriculum . '" has been updated successfully!'
                ]
            ]);
        }
        
        return response()->json(['message' => 'Curriculum updated successfully!', 'curriculum' => $curriculum]);
    }

    /**
     * Deletes a curriculum.
     */
    public function destroy($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $curriculumName = $curriculum->curriculum;
        $curriculum->delete();
        session()->flash('success', 'Curriculum "' . $curriculumName . '" has been deleted successfully!');
        
        // Also trigger notification for AJAX requests
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Curriculum deleted successfully!',
                'notification' => [
                    'type' => 'success',
                    'title' => 'Curriculum Deleted!',
                    'message' => 'Curriculum "' . $curriculumName . '" has been deleted successfully!'
                ]
            ]);
        }
        
        return response()->json(['message' => 'Curriculum deleted successfully!']);
    }

    /**
     * Retrieves data for a specific curriculum, including all available subjects for mapping.
     */
    public function getCurriculumData($id)
    {
        try {
            $curriculum = Curriculum::with('subjects')->findOrFail($id);
            
            // Optimize: Only select necessary columns for subject mapping
            $allSubjects = Subject::select([
                'id',
                'subject_name',
                'subject_code',
                'subject_type',
                'course_classification',
                'subject_unit',
                'contact_hours',
                'course_description',
                'memorandum',
                'pilo_outcomes',
                'cilo_outcomes',
                'learning_outcomes',
                'basic_readings',
                'extended_readings',
                'course_assessment',
                'committee_members',
                'consultation_schedule',
                'prepared_by',
                'reviewed_by',
                'approved_by',
                'program_mapping_grid',
                'course_mapping_grid',
                'lessons',
                'prerequisites',
                'pre_requisite_to',
                'memorandum_year',
                'memorandum_category',
                'syllabus_type',
                'syllabus_path'
            ])
            ->orderBy('subject_name')
            ->get();

            return response()->json([
                'curriculum' => $curriculum,
                'allSubjects' => $allSubjects,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching curriculum data: ' . $e->getMessage());
            return response()->json([
                'message' => 'A database error occurred while fetching curriculum data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Saves the subject mapping for a curriculum.
     */
public function saveSubjects(Request $request)
{
    $validated = $request->validate([
        'curriculumId' => 'required|exists:curriculums,id',
        'curriculumData' => 'required|array',
    ]);

    $curriculum = Curriculum::findOrFail($validated['curriculumId']);

    // If curriculum was rejected, revert to processing on modification
    if ($curriculum->approval_status === 'rejected') {
        $curriculum->update(['approval_status' => 'processing']);
    }
    
    // Get existing subjects before clearing to track changes
    $existingSubjects = $curriculum->subjects()->get()->keyBy('id');
    
    // Arrays to track all changes for a single version snapshot
    $changeDescriptions = [];
    
    // Use a transaction to ensure data integrity
    DB::transaction(function () use ($curriculum, $validated, $existingSubjects, &$changeDescriptions) {
        $newSubjectMappings = [];
        foreach ($validated['curriculumData'] as $data) {
            if (empty($data['subjects'])) {
                continue;
            }
            
            foreach ($data['subjects'] as $subjectData) {
                $subject = Subject::where('subject_code', $subjectData['subject_code'])->first();

                if ($subject) {
                    $newSubjectMappings[$subject->id] = [
                        'year' => $data['year'],
                        'semester' => $data['semester'],
                    ];
                }
            }
        }
        
        // Prepare sync data: Includes new mappings + existing unmapped subjects (set to null)
        $syncData = $newSubjectMappings;
        
        $mappedSubjectIds = array_keys($newSubjectMappings);
        $existingSubjectIds = $existingSubjects->keys()->toArray();
        $unmappedSubjectIds = array_diff($existingSubjectIds, $mappedSubjectIds);

        // Keep unmapped subjects associated but with null year/semester
        foreach ($unmappedSubjectIds as $id) {
            $syncData[$id] = ['year' => null, 'semester' => null];
        }

        // Sync subjects (update existing, insert new, detach only if not in syncData - which shouldn't happen here)
        $curriculum->subjects()->sync($syncData);

        $newSubjectIds = collect($mappedSubjectIds);

        // Identify added subjects (New IDs not in existing)
        $addedSubjects = $newSubjectIds->diff($existingSubjects->keys());
        if ($addedSubjects->isNotEmpty()) {
            $addedNames = [];
            foreach ($addedSubjects as $subjectId) {
                $subject = Subject::find($subjectId);
                $addedNames[] = $subject->subject_name;
            }
            if (count($addedNames) > 0) {
                $changeDescriptions[] = count($addedNames) . " subject(s) added: " . implode(', ', $addedNames);
            }
        }

        // Identify Unmapped subjects (Existing IDs not in New Mappings) - Moved to "Available"
        if (!empty($unmappedSubjectIds)) {
            $unmappedNames = [];
            foreach ($unmappedSubjectIds as $subjectId) {
                $subject = $existingSubjects[$subjectId];
                // Only log if it was previously mapped (had year/sem)
                if ($subject->pivot->year !== null || $subject->pivot->semester !== null) {
                    $unmappedNames[] = $subject->subject_name;
                }
            }
            if (count($unmappedNames) > 0) {
                $changeDescriptions[] = count($unmappedNames) . " subject(s) moved to available subjects: " . implode(', ', $unmappedNames);
            }
        }

        // Identify moved subjects
        $movedSubjects = [];
        foreach ($existingSubjects as $subject) {
            if (isset($newSubjectMappings[$subject->id])) {
                $oldMapping = $subject->pivot;
                $newMapping = (object)$newSubjectMappings[$subject->id];
                
                if ($oldMapping->year != $newMapping->year || $oldMapping->semester != $newMapping->semester) {
                    $movedSubjects[] = "{$subject->subject_name} (Year {$oldMapping->year}, Sem {$oldMapping->semester} → Year {$newMapping->year}, Sem {$newMapping->semester})";
                }
            }
        }
        if (count($movedSubjects) > 0) {
            $changeDescriptions[] = count($movedSubjects) . " subject(s) moved: " . implode('; ', $movedSubjects);
        }
    });

    // Create a SINGLE version snapshot if there were any changes
    if (!empty($changeDescriptions)) {
        $fullDescription = "Curriculum mapping updated - " . implode('; ', $changeDescriptions);
        CurriculumVersionService::createSnapshotOnUpdate(
            $curriculum->id,
            $fullDescription
        );
        
        // Log activity
        \App\Services\ActivityLogService::log(
            'subject_mapping',
            'Updated subject mapping for curriculum "' . $curriculum->curriculum . '"',
            [
                'curriculum_id' => $curriculum->id, 
                'changes' => $changeDescriptions
            ]
        );
    }

    session()->flash('success', 'Curriculum subjects have been saved successfully!');
    
    // Also trigger notification for AJAX requests
    if (request()->wantsJson()) {
        return response()->json([
            'message' => 'Curriculum saved successfully!', 
            'curriculumId' => $curriculum->id,
            'notification' => [
                'type' => 'success',
                'title' => 'Subjects Saved!',
                'message' => 'Curriculum subjects have been saved successfully!'
            ]
        ]);
    }
    
    return response()->json(['message' => 'Curriculum saved successfully!', 'curriculumId' => $curriculum->id]);
}

    /**
     * REMOVE a subject from a curriculum and log it to history.
     */
    public function removeSubject(Request $request)
    {
        $validated = $request->validate([
            'curriculumId' => 'required|exists:curriculums,id',
            'subjectId' => 'required|exists:subjects,id',
            'year' => 'required|integer',
            'semester' => 'required|integer',
        ]);

        try {
            $subjectName = null; // Initialize variable to store subject name
            
            DB::transaction(function () use ($validated, &$subjectName) {
                $curriculum = Curriculum::findOrFail($validated['curriculumId']);
                
                // If curriculum was rejected, revert to processing on modification
                if ($curriculum->approval_status === 'rejected') {
                    $curriculum->update(['approval_status' => 'processing']);
                }

                $subject = Subject::findOrFail($validated['subjectId']);
                
                // Store subject name for use outside transaction
                $subjectName = $subject->subject_name;

                // Detach the subject from the pivot table.
                $detached = $curriculum->subjects()
                           ->wherePivot('year', $validated['year'])
                           ->wherePivot('semester', $validated['semester'])
                           ->detach($validated['subjectId']);

                if ($detached == 0) {
                     throw new \Exception('Subject could not be found in the specified curriculum to remove.');
                }


                // Create version snapshot after removing subject
                CurriculumVersionService::createSnapshotOnSubjectRemove(
                    $validated['curriculumId'], 
                    $subject->subject_name
                );
            });

            // Log activity
            \App\Services\ActivityLogService::log(
                'subject_mapping',
                'Removed subject "' . $subjectName . '" from curriculum',
                ['curriculum_id' => $validated['curriculumId'], 'subject_id' => $validated['subjectId']]
            );

            session()->flash('success', 'Subject "' . $subjectName . '" has been removed from curriculum successfully!');
            
            // Also trigger notification for AJAX requests
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Subject removed and recorded in history.',
                    'notification' => [
                        'type' => 'success',
                        'title' => 'Subject Removed!',
                        'message' => 'Subject "' . $subjectName . '" has been removed from curriculum successfully!'
                    ]
                ]);
            }
            
            return response()->json(['message' => 'Subject removed and recorded in history.']);

        } catch (\Exception $e) {
            Log::error('Error removing subject from curriculum: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while removing the subject.'], 500);
        }
    }

    public function getCurriculumDetailsForExport($id)
    {
        try {
            $curriculum = Curriculum::with('subjects.prerequisites')->findOrFail($id);
            return response()->json($curriculum);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'A database error occurred while fetching curriculum details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get subjects available for a specific curriculum (subjects linked to this curriculum)
     */
    public function getCurriculumSubjects($id)
    {
        try {
            $curriculum = Curriculum::findOrFail($id);
            
            // Retrieve subjects linked to this curriculum AND subjects shared across the same Program
            $subjects = Subject::whereHas('curriculums', function($query) use ($curriculum) {
                $query->where('curriculum_id', $curriculum->id)
                      ->orWhere(function($subQuery) use ($curriculum) {
                          $subQuery->where('program_code', $curriculum->program_code)
                                   ->where('year_level', $curriculum->year_level);
                      });
            })->get()->map(function ($subject) {
                return [
                    'id' => $subject->id,
                    'subject_name' => $subject->subject_name,
                    'subject_code' => $subject->subject_code,
                    'subject_type' => $subject->subject_type,
                    'course_classification' => $subject->course_classification,
                    'subject_unit' => $subject->subject_unit,
                    'contact_hours' => $subject->contact_hours,
                    'course_description' => $subject->course_description,
                    'pilo_outcomes' => $subject->pilo_outcomes,
                    'cilo_outcomes' => $subject->cilo_outcomes,
                    'learning_outcomes' => $subject->learning_outcomes,
                    'basic_readings' => $subject->basic_readings,
                    'extended_readings' => $subject->extended_readings,
                    'course_assessment' => $subject->course_assessment,
                    'committee_members' => $subject->committee_members,
                    'consultation_schedule' => $subject->consultation_schedule,
                    'prepared_by' => $subject->prepared_by,
                    'reviewed_by' => $subject->reviewed_by,
                    'approved_by' => $subject->approved_by,
                    'program_mapping_grid' => $subject->program_mapping_grid,
                    'course_mapping_grid' => $subject->course_mapping_grid,
                    'lessons' => $subject->lessons,
                    'prerequisites' => $subject->prerequisites,
                    'pre_requisite_to' => $subject->pre_requisite_to,
                    'memorandum' => $subject->memorandum,
                    'memorandum_year' => $subject->memorandum_year,
                    'memorandum_category' => $subject->memorandum_category,
                    'syllabus_type' => $subject->syllabus_type,
                    'syllabus_path' => $subject->syllabus_path,
                    'created_at' => $subject->created_at,
                ];
            });

            // Debug logging
            \Log::info("Curriculum ID: $id");
            \Log::info("Found subjects count: " . $subjects->count());
            \Log::info("Subjects: " . $subjects->toJson());

            return response()->json($subjects);
        } catch (\Exception $e) {
            \Log::error("Error in getCurriculumSubjects: " . $e->getMessage());
            return response()->json([
                'message' => 'A database error occurred while fetching curriculum subjects.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Stores a new program (Curriculum Name option).
     */
    public function storeProgram(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programs,code',
            'department' => 'required|in:Senior High,College',
        ]);

        try {
            $program = Program::create([
                'description' => $validated['description'],
                'code' => $validated['code'],
                'department' => $validated['department'],
            ]);

            return response()->json([
                'message' => 'Program created successfully!',
                'program' => $program
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Error creating program: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error creating program.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add subjects to a curriculum's available subjects pool
     */
    public function addSubjectsToCurriculum(Request $request, $id)
    {
        $validated = $request->validate([
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        try {
            $curriculum = Curriculum::findOrFail($id);
            
            // If curriculum was rejected, revert to processing on modification
            if ($curriculum->approval_status === 'rejected') {
                $curriculum->update(['approval_status' => 'processing']);
            }
            
            // Get existing subject IDs for this curriculum
            $existingSubjectIds = $curriculum->subjects()->pluck('subjects.id')->toArray();
            
            // Filter out subjects that are already linked to this curriculum
            $newSubjectIds = array_diff($validated['subject_ids'], $existingSubjectIds);
            
            if (empty($newSubjectIds)) {
                return response()->json([
                    'message' => 'All selected subjects are already available for this curriculum.',
                    'added_count' => 0
                ]);
            }
            
            // Attach new subjects to curriculum without year/semester (making them available for mapping)
            foreach ($newSubjectIds as $subjectId) {
                $curriculum->subjects()->attach($subjectId, [
                    'year' => null,
                    'semester' => null,
                ]);
            }
            
            $addedCount = count($newSubjectIds);
            
            // Create database notification for admins
            if (Auth::check()) {
                Notification::createForAdmins(
                    'success',
                    'Subjects Added to Curriculum',
                    $addedCount . ' subject(s) added to curriculum "' . $curriculum->curriculum . '" by ' . Auth::user()->name,
                    ['curriculum_id' => $curriculum->id, 'action' => 'subjects_added', 'count' => $addedCount]
                );
            }
            
            return response()->json([
                'message' => $addedCount . ' subject(s) added to curriculum successfully!',
                'added_count' => $addedCount,
                'notification' => [
                    'type' => 'success',
                    'title' => 'Subjects Added!',
                    'message' => $addedCount . ' subject(s) have been added to the curriculum successfully!'
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error in addSubjectsToCurriculum: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while adding subjects to curriculum.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve a curriculum
     */
    public function approve($id)
    {
        try {
            $curriculum = Curriculum::findOrFail($id);
            $curriculum->update(['approval_status' => 'approved']);

            // Create database notification for admins
            if (Auth::check()) {
                Notification::createForAdmins(
                    'success',
                    'Curriculum Approved',
                    'Curriculum "' . $curriculum->curriculum . '" has been approved by ' . Auth::user()->name,
                    ['curriculum_id' => $curriculum->id, 'action' => 'approved']
                );

                // Log activity
                \App\Services\ActivityLogService::log(
                    'approve_curriculum',
                    'Approved curriculum "' . $curriculum->curriculum . '"',
                    ['curriculum_id' => $curriculum->id]
                );
            }

            return response()->json([
                'message' => 'Curriculum approved successfully!',
                'curriculum' => $curriculum,
                'notification' => [
                    'type' => 'success',
                    'title' => 'Curriculum Approved!',
                    'message' => 'Curriculum "' . $curriculum->curriculum . '" has been approved successfully!'
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error("Error approving curriculum: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while approving the curriculum.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject a curriculum
     */
    public function reject($id)
    {
        try {
            $curriculum = Curriculum::findOrFail($id);
            $curriculum->update(['approval_status' => 'rejected']);

            // If rejecting a 'new' curriculum, restore the previous approved 'old' version
            if ($curriculum->version_status === 'new') {
                $oldApprovedCurriculum = Curriculum::where('curriculum', $curriculum->curriculum)
                    ->where('academic_year', $curriculum->academic_year)
                    ->where('year_level', $curriculum->year_level)
                    ->where('version_status', 'old')
                    ->where('approval_status', 'approved')
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($oldApprovedCurriculum) {
                    $oldApprovedCurriculum->update(['version_status' => 'new']);
                }
            }

            // Create database notification for admins
            if (Auth::check()) {
                Notification::createForAdmins(
                    'warning',
                    'Curriculum Rejected',
                    'Curriculum "' . $curriculum->curriculum . '" has been rejected by ' . Auth::user()->name,
                    ['curriculum_id' => $curriculum->id, 'action' => 'rejected']
                );

                // Log activity
                \App\Services\ActivityLogService::log(
                    'reject_curriculum',
                    'Rejected curriculum "' . $curriculum->curriculum . '"',
                    ['curriculum_id' => $curriculum->id]
                );
            }

            return response()->json([
                'message' => 'Curriculum rejected successfully!',
                'curriculum' => $curriculum,
                'notification' => [
                    'type' => 'warning',
                    'title' => 'Curriculum Rejected!',
                    'message' => 'Curriculum "' . $curriculum->curriculum . '" has been rejected.'
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error("Error rejecting curriculum: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while rejecting the curriculum.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore a rejected curriculum back to processing status
     */
    public function restore($id)
    {
        try {
            $curriculum = Curriculum::findOrFail($id);
            
            // Only allow restoring rejected curriculums
            if ($curriculum->approval_status !== 'rejected') {
                return response()->json([
                    'message' => 'Only rejected curriculums can be restored.',
                ], 400);
            }
            
            $curriculum->update(['approval_status' => 'processing']);

            // If restoring a 'new' curriculum back to processing, mark old approved versions as 'old' again
            if ($curriculum->version_status === 'new') {
                Curriculum::where('curriculum', $curriculum->curriculum)
                    ->where('academic_year', $curriculum->academic_year)
                    ->where('year_level', $curriculum->year_level)
                    ->where('id', '!=', $curriculum->id)
                    ->where('approval_status', 'approved')
                    ->update(['version_status' => 'old']);
            }

            // Create database notification for admins
            if (Auth::check()) {
                Notification::createForAdmins(
                    'info',
                    'Curriculum Restored',
                    'Curriculum "' . $curriculum->curriculum . '" has been restored to processing by ' . Auth::user()->name,
                    ['curriculum_id' => $curriculum->id, 'action' => 'restored']
                );

                // Log activity
                \App\Services\ActivityLogService::log(
                    'restore_curriculum',
                    'Restored/Revised curriculum "' . $curriculum->curriculum . '"',
                    ['curriculum_id' => $curriculum->id]
                );
            }

            return response()->json([
                'message' => 'Curriculum restored to processing status successfully!',
                'curriculum' => $curriculum,
                'notification' => [
                    'type' => 'success',
                    'title' => 'Curriculum Restored!',
                    'message' => 'Curriculum "' . $curriculum->curriculum . '" has been restored to processing status.'
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error("Error restoring curriculum: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while restoring the curriculum.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get curriculum subjects grouped by year and semester
     * Returns a structured format with subjects organized by year level and semester
     */
    public function getCurriculumSubjectsByYearSemester($id)
    {
        try {
            $curriculum = Curriculum::findOrFail($id);
            
            // Get all subjects with their pivot data (year, semester)
            $subjects = $curriculum->subjects()
                ->wherePivot('year', '!=', null)
                ->wherePivot('semester', '!=', null)
                ->orderBy('subject_name')
                ->get();

            // Determine max year based on year_level
            $maxYear = $curriculum->year_level === 'Senior High' ? 2 : 4;

            // Initialize structure for all years and semesters
            $structure = [];
            for ($year = 1; $year <= $maxYear; $year++) {
                $structure["year_{$year}"] = [
                    'year' => $year,
                    'year_label' => $this->getYearLabel($year),
                    'semester_1' => [
                        'semester' => 1,
                        'semester_label' => $this->getSemesterLabel($curriculum->year_level, $year, 1),
                        'subjects' => [],
                        'total_units' => 0
                    ],
                    'semester_2' => [
                        'semester' => 2,
                        'semester_label' => $this->getSemesterLabel($curriculum->year_level, $year, 2),
                        'subjects' => [],
                        'total_units' => 0
                    ]
                ];
            }

            // Group subjects by year and semester
            foreach ($subjects as $subject) {
                $year = $subject->pivot->year;
                $semester = $subject->pivot->semester;
                
                if ($year >= 1 && $year <= $maxYear && ($semester == 1 || $semester == 2)) {
                    $subjectData = [
                        'id' => $subject->id,
                        'subject_name' => $subject->subject_name,
                        'subject_code' => $subject->subject_code,
                        'subject_type' => $subject->subject_type,
                        'course_classification' => $subject->course_classification,
                        'subject_unit' => $subject->subject_unit,
                        'contact_hours' => $subject->contact_hours,
                        'course_description' => $subject->course_description,
                    ];
                    
                    $structure["year_{$year}"]["semester_{$semester}"]['subjects'][] = $subjectData;
                    $structure["year_{$year}"]["semester_{$semester}"]['total_units'] += floatval($subject->subject_unit ?? 0);
                }
            }

            // Calculate total units for the entire curriculum
            $totalUnits = 0;
            foreach ($structure as $yearData) {
                $totalUnits += $yearData['semester_1']['total_units'];
                $totalUnits += $yearData['semester_2']['total_units'];
            }

            return response()->json([
                'curriculum_id' => $curriculum->id,
                'curriculum_name' => $curriculum->curriculum,
                'year_level' => $curriculum->year_level,
                'academic_year' => $curriculum->academic_year,
                'total_units' => $totalUnits,
                'structure' => array_values($structure) // Convert to indexed array
            ]);

        } catch (\Exception $e) {
            \Log::error("Error in getCurriculumSubjectsByYearSemester: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while fetching curriculum structure.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper function to get year label with suffix
     */
    private function getYearLabel($year)
    {
        $suffix = 'th';
        if ($year == 1) $suffix = 'st';
        elseif ($year == 2) $suffix = 'nd';
        elseif ($year == 3) $suffix = 'rd';
        
        return "{$year}{$suffix} Year";
    }

    /**
     * Helper function to get semester label
     */
    private function getSemesterLabel($yearLevel, $year, $semester)
    {
        if ($yearLevel === 'Senior High') {
            // For Senior High: Year 1 = Q1/Q2, Year 2 = Q3/Q4
            $quarterMap = [
                1 => ['1st Quarter', '2nd Quarter'],
                2 => ['3rd Quarter', '4th Quarter']
            ];
            return $quarterMap[$year][$semester - 1] ?? "{$semester} Semester";
        }
        
        // For College: Regular semesters
        return $semester == 1 ? '1st Semester' : '2nd Semester';
    }

    /**
     * Get curriculum subjects as a flat list with explicit integer identifiers for year and semester
     * Ideal for integration syncing to avoid hierarchy confusion
     */
    public function getCurriculumSubjectsFlat($id)
    {
        try {
            $curriculum = Curriculum::findOrFail($id);
            
            // Get all subjects with their pivot data (year, semester)
            $subjects = $curriculum->subjects()
                ->wherePivot('year', '!=', null)
                ->wherePivot('semester', '!=', null)
                ->get();

            // Sort in PHP: Year ASC, Semester ASC, Subject Name ASC
            $subjects = $subjects->sortBy([
                [function ($subject) { return $subject->pivot->year; }, 'asc'],
                [function ($subject) { return $subject->pivot->semester; }, 'asc'],
                ['subject_name', 'asc'],
            ]);

            $formattedSubjects = $subjects->map(function ($subject) {
                return [
                    'id' => $subject->id, // Internal ID
                    'code' => $subject->subject_code,
                    'name' => $subject->subject_name,
                    'year_level' => (int) $subject->pivot->year,      // Integer: 1 = 1st Year
                    'semester' => (int) $subject->pivot->semester,    // Integer: 1 = 1st Semester/Quarter
                    'units' => is_numeric($subject->subject_unit) ? (float) $subject->subject_unit : 0,
                    // Extra fields useful for verification
                    'subject_type' => $subject->subject_type,
                ];
            })->values(); // Reset keys to ensure JSON array

            return response()->json([
                'data' => [
                    'curriculum_id' => $curriculum->id,
                    'course_name' => $curriculum->curriculum,
                    'program_code' => $curriculum->program_code,
                    'academic_year' => $curriculum->academic_year, // e.g. "2024-2025"
                    'year_level_type' => $curriculum->year_level,  // "College" or "Senior High"
                    'total_subjects' => $formattedSubjects->count(),
                    'subjects' => $formattedSubjects
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error("Error in getCurriculumSubjectsFlat: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while fetching curriculum subjects flat list.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}