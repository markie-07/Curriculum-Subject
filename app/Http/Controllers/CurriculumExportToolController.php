<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\ExportHistory;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class CurriculumExportToolController extends Controller
{
    /**
     * Display the export tool page with existing curriculums and history.
     */
    public function index()
    {
        $curriculums = Curriculum::orderBy('curriculum')->get();
        $exportHistories = ExportHistory::with(['curriculum', 'user'])->latest()->get();

        // Log page view activity for all authenticated users
        if (auth()->user()) {
            ActivityLogService::logPageView('Curriculum Export Tool');
            auth()->user()->updateLastActivity();
        }

        return view('curriculum_export_tool', compact('curriculums', 'exportHistories'));
    }

    /**
     * Store a new export history record in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'curriculum_id' => 'required|exists:curriculums,id',
            'file_name' => 'required|string|max:255',
            'format' => 'required|string|max:255',
        ]);

        // Add user information and export type to the export history
        $user = auth()->user();
        if ($user) {
            $validated['user_id'] = $user->id;
            $validated['exported_by_name'] = $user->name ?? $user->username;
            $validated['exported_by_email'] = $user->email;
        }
        $validated['export_type'] = 'curriculum';

        $exportHistory = ExportHistory::create($validated);

        // Log export activity for all authenticated users
        if (auth()->user()) {
            $curriculum = Curriculum::find($validated['curriculum_id']);
            ActivityLogService::logExport(
                'curriculum_export',
                $validated['file_name'],
                [
                    'curriculum_id' => $validated['curriculum_id'],
                    'curriculum_name' => $curriculum->curriculum ?? 'Unknown',
                    'format' => $validated['format'],
                    'export_type' => 'curriculum',
                    'export_history_id' => $exportHistory->id,
                ]
            );
            auth()->user()->updateLastActivity();
        }

        // Flash success message for session-based requests
        session()->flash('success', 'Curriculum exported successfully!');
        
        // Return the new history item with its related curriculum info
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $exportHistory->load(['curriculum', 'user']),
                'notification' => [
                    'type' => 'success',
                    'title' => 'Export Successful!',
                    'message' => 'Curriculum has been exported successfully!'
                ]
            ]);
        }
        
        return response()->json($exportHistory->load(['curriculum', 'user']));
    }

    /**
     * Get curriculum subjects for preview (API endpoint).
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurriculumSubjects($id)
    {
        try {
            $curriculum = Curriculum::with([
                'subjects' => function ($query) {
                    $query->orderBy('pivot_year', 'asc')->orderBy('pivot_semester', 'asc');
                }
            ])->findOrFail($id);

            return response()->json([
                'id' => $curriculum->id,
                'curriculum_name' => $curriculum->curriculum,
                'program_code' => $curriculum->program_code,
                'year_level' => $curriculum->year_level,
                'subjects' => $curriculum->subjects->map(function ($subject) {
                    return [
                        'id' => $subject->id,
                        'subject_name' => $subject->subject_name,
                        'subject_code' => $subject->subject_code,
                        'subject_type' => $subject->subject_type,
                        'course_classification' => $subject->course_classification,
                        'subject_unit' => $subject->subject_unit,
                        'year' => $subject->pivot->year ?? 'N/A',
                        'semester' => $subject->pivot->semester ?? 'N/A'
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Curriculum not found'], 404);
        }
    }

    /**
     * Export the curriculum data as a PDF.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportPdf($id, Request $request)
    {
        // Get course type filters from request
        $courseTypes = $request->get('course_types', []);
        
        $curriculum = Curriculum::with([
            'subjects' => function ($query) use ($courseTypes) {
                // Order subjects by year and then by semester for a structured layout
                $query->orderBy('pivot_year', 'asc')->orderBy('pivot_semester', 'asc');
                
                // Apply course type filtering if specified
                if (!empty($courseTypes)) {
                    $query->where(function ($subQuery) use ($courseTypes) {
                        // Match subject_type
                        $subQuery->whereIn('subject_type', $courseTypes);
                        
                        // Match course_classification
                        $subQuery->orWhereIn('course_classification', $courseTypes);
                        
                        // Handle General Education with flexible matching
                        if (in_array('General Education', $courseTypes)) {
                            $geIdentifiers = ['GE', 'General Education', 'Gen Ed', 'General'];
                            foreach ($geIdentifiers as $geId) {
                                $subQuery->orWhere('subject_type', 'LIKE', '%' . $geId . '%');
                            }
                        }
                    });
                }
            }, 
            'subjects.prerequisites', 
            'subjects.grades' // Eager load grades for each subject
        ])->findOrFail($id);
    
        // Safeguard against null relationships.
        $curriculum->subjects->each(function ($subject) {
            if (is_null($subject->prerequisites)) {
                $subject->setRelation('prerequisites', collect());
            }
        });

        // Generate HTML from the view
        $html = view('curriculum_pdf', compact('curriculum', 'courseTypes'))->render();
        
        // Create mPDF instance
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
        ]);
        
        // Write HTML to PDF
        $mpdf->WriteHTML($html);
        
        // Sanitize the curriculum name to create a valid filename
        $fileName = preg_replace('/[^A-Za-z0-9\-]/', '_', $curriculum->program_code);
        
        // Record Export History
        $user = auth()->user();
        if ($user) {
            $history = ExportHistory::create([
                'curriculum_id' => $curriculum->id,
                'user_id' => $user->id,
                'file_name' => $fileName . '_curriculum.pdf',
                'format' => 'pdf',
                'export_type' => 'curriculum',
                'exported_by_name' => $user->name ?? $user->username,
                'exported_by_email' => $user->email,
            ]);

            // Log Activity for all authenticated users
            ActivityLogService::logExport(
                'curriculum_export',
                $fileName . '_curriculum.pdf',
                [
                    'curriculum_id' => $curriculum->id,
                    'curriculum_name' => $curriculum->curriculum ?? 'Unknown',
                    'format' => 'pdf',
                    'export_type' => 'curriculum',
                    'export_history_id' => $history->id
                ]
            );
            // Also update last activity
            if (method_exists($user, 'updateLastActivity')) {
                $user->updateLastActivity();
            }
        }
        
        // Output PDF for download
        return response($mpdf->Output($fileName . '_curriculum.pdf', 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '_curriculum.pdf"');
    }
}

