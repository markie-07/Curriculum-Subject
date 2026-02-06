<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index()
    {
        // Optimize: Only select necessary columns instead of loading everything
        // This significantly reduces database load and memory usage
        $subjects = Subject::select([
            'id',
            'syllabus_type', // Toggle (Top)
            
            // Course Information
            'subject_name', // Course Title
            'subject_code', // Course Code
            'subject_type', // Course Type
            'course_classification', // Subject Category
            'subject_unit', // Credit Units
            'contact_hours', // Contact Hours
            'syllabus_path', // DepEd Syllabus File

            'course_description', // Course Description

            // DepEd Curriculum Guide
            'deped_data', 

            // Mapping Grids
            'program_mapping_grid',
            'course_mapping_grid',

            // Learning Outcomes
            'pilo_outcomes',
            'cilo_outcomes',
            'learning_outcomes',

            // Weekly Plan
            'lessons',

            // Course Requirements and Policies
            'basic_readings',
            'extended_readings',
            'course_assessment',
            'committee_members',
            'consultation_schedule',

            // Approval
            'prepared_by',
            'reviewed_by',
            'approved_by',

            'created_at'
        ])
        ->orderBy('subject_name')
        ->get();

        // Fetch all system settings
        $settings = \App\Models\SystemSetting::all();
        
        // Group by category -> key -> value
        $systemSettings = $settings->groupBy('category')->map(function ($items) {
            return $items->mapWithKeys(function ($item) {
                return [$item->key => $item->value];
            });
        });
        
        return response()->json([
            'static_data' => $this->getCourseBuilderDefaults(),
            'subjects' => $subjects,
            'system_settings' => $systemSettings
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_title' => 'required|string|max:255|unique:subjects,subject_name',
            'subject_code' => 'required|string|max:255|unique:subjects,subject_code',
            'subject_unit' => 'nullable|integer',
            'subject_type' => 'required|string|in:Major,Minor,Elective,General,NSTP 1,NSTP 2,Research,OJT/Practicum',
            'course_classification' => 'nullable|string',
            'syllabus_type' => 'nullable|string|in:CHED,DepEd',
            'lessons' => 'nullable|array',
            'contact_hours' => 'nullable|integer',
            'course_description' => 'nullable|string',
            'program_mapping_grid' => 'nullable|array',
            'course_mapping_grid' => 'nullable|array',
            'pilo_outcomes' => 'nullable|string',
            'cilo_outcomes' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'basic_readings' => 'nullable|string',
            'extended_readings' => 'nullable|string',
            'course_assessment' => 'nullable|string',
            'committee_members' => 'nullable|string',
            'consultation_schedule' => 'nullable|string',
            'prepared_by' => 'nullable|string',
            'reviewed_by' => 'nullable|string',
            'approved_by' => 'nullable|string',
            'curriculum_ids' => 'nullable|array',
            'curriculum_ids.*' => 'integer|exists:curriculums,id',

            'syllabus_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $syllabusPath = null;
        if ($request->hasFile('syllabus_path')) {
            $file = $request->file('syllabus_path');
            // Store in 'public/syllabi' folder. Ensure 'php artisan storage:link' is run.
            $path = $file->store('syllabi', 'public'); 
            $syllabusPath = '/storage/' . $path;
        }

        $subject = Subject::create([
            'subject_name' => $validated['course_title'],
            'subject_code' => $validated['subject_code'],
            'subject_type' => $validated['subject_type'],
            'course_classification' => $validated['course_classification'] ?? null,
            'syllabus_type' => $validated['syllabus_type'] ?? 'CHED',
            'subject_unit' => $validated['subject_unit'] ?? 0,
            'lessons' => $validated['lessons'] ?? null,
            'contact_hours' => $validated['contact_hours'] ?? null,
            'course_description' => $validated['course_description'] ?? null,
            'program_mapping_grid' => $validated['program_mapping_grid'] ?? null,
            'course_mapping_grid' => $validated['course_mapping_grid'] ?? null,
            'pilo_outcomes' => $validated['pilo_outcomes'] ?? null,
            'cilo_outcomes' => $validated['cilo_outcomes'] ?? null,
            'learning_outcomes' => $validated['learning_outcomes'] ?? null,
            'basic_readings' => $validated['basic_readings'] ?? null,
            'extended_readings' => $validated['extended_readings'] ?? null,
            'course_assessment' => $validated['course_assessment'] ?? null,
            'committee_members' => $validated['committee_members'] ?? null,
            'consultation_schedule' => $validated['consultation_schedule'] ?? null,
            'prepared_by' => $validated['prepared_by'] ?? null,
            'reviewed_by' => $validated['reviewed_by'] ?? null,
            'approved_by' => $validated['approved_by'] ?? null,

            'syllabus_path' => $syllabusPath,
        ]);

        // Attach subject to selected curriculums if provided
        if (!empty($validated['curriculum_ids'])) {
            $attachData = [];
            foreach ($validated['curriculum_ids'] as $curriculumId) {
                $attachData[$curriculumId] = [
                    'year' => null,     // Will be set during subject mapping
                    'semester' => null  // Will be set during subject mapping
                ];
            }
            $subject->curriculums()->attach($attachData);
        }

        // Log activity
        if (auth()->user()) {
            \App\Services\ActivityLogService::log(
                'course_builder_create',
                'Created new course/subject "' . $subject->subject_name . '"',
                [
                    'subject_id' => $subject->id, 
                    'subject_code' => $subject->subject_code,
                    'subject_type' => $subject->subject_type,
                    'syllabus_type' => $subject->syllabus_type
                ]
            );
            auth()->user()->updateLastActivity();
        }

        // Flash success message for session-based requests
        session()->flash('success', 'Subject "' . $subject->subject_name . '" has been created successfully!');
        
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Subject created successfully! Ready for mapping.',
                'subject' => $subject,
                'notification' => [
                    'type' => 'success',
                    'title' => 'Subject Created!',
                    'message' => 'Subject "' . $subject->subject_name . '" has been created successfully!'
                ]
            ], 201);
        }
        
        return response()->json([
            'message' => 'Subject created successfully! Ready for mapping.',
            'subject' => $subject,
        ], 201);
    }

    public function show($id)
    {
        $subject = Subject::with('curriculums')->findOrFail($id);

        // Fetch all system settings
        $settings = \App\Models\SystemSetting::all();
        
        // Group by category -> key -> value
        $systemSettings = $settings->groupBy('category')->map(function ($items) {
            return $items->mapWithKeys(function ($item) {
                return [$item->key => $item->value];
            });
        });

        $response = $subject->toArray();
        $response['system_settings'] = $systemSettings;
        $response['static_data'] = $this->getCourseBuilderDefaults();

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $validated = $request->validate([
            'course_title' => 'required|string|max:255|unique:subjects,subject_name,' . $subject->id,
            'subject_code' => 'required|string|max:255|unique:subjects,subject_code,' . $subject->id,
            'subject_unit' => 'nullable|integer',
            'subject_type' => 'required|string|in:Major,Minor,Elective,General,NSTP 1,NSTP 2,Research,OJT/Practicum',
            'course_classification' => 'nullable|string',
            'syllabus_type' => 'nullable|string|in:CHED,DepEd',
            'lessons' => 'nullable|array',
            'contact_hours' => 'nullable|integer',
            'course_description' => 'nullable|string',
            'program_mapping_grid' => 'nullable|array',
            'course_mapping_grid' => 'nullable|array',
            'pilo_outcomes' => 'nullable|string',
            'cilo_outcomes' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'basic_readings' => 'nullable|string',
            'extended_readings' => 'nullable|string',
            'course_assessment' => 'nullable|string',
            'committee_members' => 'nullable|string',
            'consultation_schedule' => 'nullable|string',
            'prepared_by' => 'nullable|string',
            'reviewed_by' => 'nullable|string',
            'approved_by' => 'nullable|string',
            'curriculum_ids' => 'nullable|array',
            'curriculum_ids.*' => 'integer|exists:curriculums,id',

            'syllabus_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $updateData = [
            'subject_name' => $validated['course_title'],
            'subject_code' => $validated['subject_code'],
            'subject_type' => $validated['subject_type'],
            'course_classification' => $validated['course_classification'] ?? null,
            'syllabus_type' => $validated['syllabus_type'] ?? 'CHED',
            'subject_unit' => $validated['subject_unit'] ?? 0,
            'lessons' => $validated['lessons'] ?? null,
            'contact_hours' => $validated['contact_hours'] ?? null,
            'course_description' => $validated['course_description'] ?? null,
            'program_mapping_grid' => $validated['program_mapping_grid'] ?? null,
            'course_mapping_grid' => $validated['course_mapping_grid'] ?? null,
            'pilo_outcomes' => $validated['pilo_outcomes'] ?? null,
            'cilo_outcomes' => $validated['cilo_outcomes'] ?? null,
            'learning_outcomes' => $validated['learning_outcomes'] ?? null,
            'basic_readings' => $validated['basic_readings'] ?? null,
            'extended_readings' => $validated['extended_readings'] ?? null,
            'course_assessment' => $validated['course_assessment'] ?? null,
            'committee_members' => $validated['committee_members'] ?? null,
            'consultation_schedule' => $validated['consultation_schedule'] ?? null,
            'prepared_by' => $validated['prepared_by'] ?? null,
            'reviewed_by' => $validated['reviewed_by'] ?? null,
            'approved_by' => $validated['approved_by'] ?? null,

        ];

        if ($request->hasFile('syllabus_path')) {
            $file = $request->file('syllabus_path');
             // Store in 'public/syllabi' folder. Ensure 'php artisan storage:link' is run.
            $path = $file->store('syllabi', 'public');
            $updateData['syllabus_path'] = '/storage/' . $path;
        }

        // Use database transaction to ensure data consistency
        DB::transaction(function () use ($subject, $updateData, $request, $validated) {
            // Get the next version number
            $nextVersionNumber = SubjectVersion::where('subject_id', $subject->id)->max('version_number') + 1;
            
            // Save the current state as a version before updating
            SubjectVersion::createFromSubject(
                $subject, 
                $nextVersionNumber,
                $request->input('change_reason', 'Subject updated'),
                $request->input('changed_by', 'System')
            );
            
            // Update the subject with new data
            $subject->update($updateData);
            
            // Update curriculum relationships
            if (isset($validated['curriculum_ids'])) {
                $currentCurriculums = $subject->curriculums()->get();
                $syncData = [];
                foreach ($validated['curriculum_ids'] as $curriculumId) {
                    // Check if already attached to preserve mapping
                    $existing = $currentCurriculums->find($curriculumId);
                    if ($existing) {
                        $syncData[$curriculumId] = [
                            'year' => $existing->pivot->year,
                            'semester' => $existing->pivot->semester
                        ];
                    } else {
                        $syncData[$curriculumId] = [
                            'year' => null,
                            'semester' => null
                        ];
                    }
                }
                $subject->curriculums()->sync($syncData);
            }
        });

        // Flash success message for session-based requests
        session()->flash('success', 'Subject "' . $subject->subject_name . '" has been updated successfully!');
        
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Subject updated successfully!',
                'subject' => $subject,
                'notification' => [
                    'type' => 'success',
                    'title' => 'Subject Updated!',
                    'message' => 'Subject "' . $subject->subject_name . '" has been updated successfully!'
                ]
            ], 200);
        }
        
        return response()->json([
            'message' => 'Subject updated successfully!',
            'subject' => $subject,
        ], 200);
    }
    
    /**
     * Remove the specified subject from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        try {
            // Store subject name before deletion
            $subjectName = $subject->subject_name;
            
            // The subject is already loaded thanks to route model binding.
            $subject->delete();
            
            // Flash success message for session-based requests
            session()->flash('success', 'Subject "' . $subjectName . '" has been deleted successfully!');
            
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Subject deleted successfully.',
                    'notification' => [
                        'type' => 'success',
                        'title' => 'Subject Deleted!',
                        'message' => 'Subject "' . $subjectName . '" has been deleted successfully!'
                    ]
                ], 200);
            }
            
            return response()->json(['message' => 'Subject deleted successfully.'], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error deleting subject: '.$e->getMessage());

            // Return a generic error response
            return response()->json(['message' => 'An error occurred while deleting the subject.'], 500);
        }
    }

    /**
     * Get version history for a subject (current and previous version)
     */
    public function getVersionHistory($id)
    {
        try {
            $currentSubject = Subject::findOrFail($id);
            
            // Get all versions from subject_versions table, ordered by version number descending
            $allVersions = SubjectVersion::where('subject_id', $id)
                ->orderBy('version_number', 'desc')
                ->get();
            
            $previousVersions = [];
            
            if ($allVersions->count() > 0) {
                // Convert all versions to subject-like format for consistency
                foreach ($allVersions as $version) {
                    $previousVersions[] = [
                        'id' => $version->id,
                        'subject_name' => $version->subject_name,
                        'subject_code' => $version->subject_code,
                        'subject_type' => $version->subject_type,
                        'course_classification' => $version->course_classification,
                        'subject_unit' => $version->subject_unit,
                        'units' => $version->subject_unit, // For compatibility with frontend
                        'contact_hours' => $version->contact_hours,
                        'prerequisites' => $version->prerequisites,
                        'pre_requisite_to' => $version->pre_requisite_to,
                        'course_description' => $version->course_description,
                        'program_mapping_grid' => $version->program_mapping_grid,
                        'course_mapping_grid' => $version->course_mapping_grid,
                        'pilo_outcomes' => $version->pilo_outcomes,
                        'cilo_outcomes' => $version->cilo_outcomes,
                        'learning_outcomes' => $version->learning_outcomes,
                        'lessons' => $version->lessons,
                        'basic_readings' => $version->basic_readings,
                        'extended_readings' => $version->extended_readings,
                        'course_assessment' => $version->course_assessment,
                        'committee_members' => $version->committee_members,
                        'consultation_schedule' => $version->consultation_schedule,
                        'prepared_by' => $version->prepared_by,
                        'reviewed_by' => $version->reviewed_by,
                        'approved_by' => $version->approved_by,
                        'created_at' => $version->created_at,
                        'updated_at' => $version->updated_at,
                        'version_number' => $version->version_number,
                        'change_reason' => $version->change_reason,
                        'changed_by' => $version->changed_by,
                    ];
                }
                
                return response()->json([
                    'hasOldVersion' => true,
                    'currentVersion' => $currentSubject,
                    'previousVersions' => $previousVersions,
                    'totalVersions' => $allVersions->count()
                ]);
            } else {
                return response()->json([
                    'hasOldVersion' => false,
                    'currentVersion' => $currentSubject,
                    'previousVersions' => [],
                    'totalVersions' => 0
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Error fetching subject version history: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching version history.'], 500);
        }
    }

    /**
     * Get the hardcoded default values and text from the Course Builder UI.
     * This allows the API to provide the full context of the form.
     */
    private function getCourseBuilderDefaults()
    {
        return [
            'dropdown_options' => [
                'ched_course_classifications' => [
                    "General Education",
                    "Professional Subject Non Laboratory",
                    "Professional Subject Laboratory",
                    "Professional Subject Board Courses",
                    "Professional Subject Non Board Courses",
                    "Professional Subject OC",
                    "NSTP 1",
                    "NSTP 2",
                    "Research",
                    "OJT/Practicum"
                ],
                'deped_course_classifications' => [
                    "Core Subjects",
                    "Applied Track Subjects",
                    "Specialized Subjects"
                ]
            ],
            'institutional_information' => [
                'school_vision' => "BCP is committed to provide and promote quality education with a unique, modern and research-based curriculum with delivery systems geared towards excellence.",
                'school_mission' => "To produce self-motivated and self-directed individual who aims for academic excellence, God-fearing, peaceful, healthy and productive successful citizens.",
                'school_philosophy' => "BCP advocates threefold core values: \"Fides\", Faith; \"Ratio\", Reason; Pax. Peace. \"Fides\" represents BCPs, endeavors for expansion, development, and growth amidst the challenges of the new millennium. \"Ratio\" symbolizes BCP's efforts to provide an education which can be man's tool to be liberated from all forms of ignorance and poverty. \"Pax\". BCP is a forerunner in the promotion of a harmonious relationship between the different sectors of its academic community.",
                'school_core_values' => "FAITH, KNOWLEDGE, CHARITY AND HUMILITY\n\nFAITH (Fides) represents BCP’s endeavor for expansion, development and for growth amidst the global challenges of the new millennium.\n\nKNOWLEDGE (Cognito) connotes the institution’s efforts to impart excellent lifelong education that can be used as human tool so that one can liberate himself/herself from ignorance and poverty\n\nCHARITY (Caritas) is the institution’s commitment towards its clienteles.\n\nHUMILITY (Humiliates) refers to the institution’s recognition of the human frailty, its imperfection."
            ],
            'department_information' => [
                 'default_vision' => "To improve the quality of student’s input and by promoting IT enabled, market driven and internationally comparable programs through quality assurance systems, upgrading faculty qualifications and establishing international linkages.",
                 'default_mission' => "The College of Computer Studies is committed to provide quality information and communication technology education through the use of modern and transformation learning teaching process.",
                 'general_education_vision' => "BCP General Education Department innovates, investigates and discovers greatness and prosperity through oneness.",
                 'general_education_mission' => "To awaken the curiosity and ignite passion of individuals to excel independency in academic endeavors towards their development into ethically and morally strong people."
            ],
            'course_policies' => "This course is committed in providing equal access and participation for all students including those with disabilities. If you have a disability that may require accommodations, please contact the OFFICE OF THE STUDENTS’ AFFAIRS and SERVICES to register in the LIST OF LEARNERS with Disabilities. Please be aware that it is your responsibility to communicate your needs and works with the instructor to ensure that appropriate accommodations can be arranged promptly. The faculty reserves the right to change or amend this syllabus as needed. Any changes to the syllabus will be communicated promptly to the VPAA through the Department Heads / Deans, if any, adjustments will be made to ensure that all students can continue to meet the course objectives. Your feedback and input are valued, and we encourage open communication to facilitate a positive and productive learning experience for all."
        ];
    }
}