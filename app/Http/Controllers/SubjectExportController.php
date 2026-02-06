<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Mpdf\Mpdf;
use Illuminate\Http\Request;
use App\Models\ExportHistory;
use App\Services\ActivityLogService;
use STS\ZipStream\Facades\Zip;

class SubjectExportController extends Controller
{
    /**
     * Export subject details, including its grading system, to a PDF file.
     *
     * @param int $subjectId The ID of the subject to export.
     * @return \Illuminate\Http\Response
     */
    public function exportPdf($subjectId)
    {
        // Use findOrFail to automatically handle cases where the subject is not found.
        // Eager load the 'grades' relationship to avoid extra database queries.
        $subject = Subject::with('grades')->findOrFail($subjectId);
        
        // Find the curriculum this subject belongs to (get the first one if multiple)
        $curriculum = $subject->curriculums()->first();
        
        // Fallback: If no curriculum attached to subject, try to find one from prerequisites table
        if (!$curriculum) {
            $relatedPrereq = \App\Models\Prerequisite::where('subject_code', $subject->subject_code)
                ->orWhere('prerequisite_subject_code', $subject->subject_code)
                ->first();
            
            if ($relatedPrereq) {
                $curriculum = \App\Models\Curriculum::find($relatedPrereq->curriculum_id);
            }
        }
        
        // If we have a curriculum, get prerequisite data
        $prerequisiteData = [];
        if ($curriculum) {
            // Fetch all prerequisite relationships for the current curriculum.
            $allPrerequisites = \App\Models\Prerequisite::where('curriculum_id', $curriculum->id)->get();

            // MAP 1: PARENTS (for Credit Prerequisites/Ancestors) - What subjects are required before this one
            // In DB: subject_code (Child) depends on prerequisite_subject_code (Parent)
            $directParentsMap = $allPrerequisites->groupBy('subject_code')->map(function ($item) {
                return $item->pluck('prerequisite_subject_code')->all();
            })->all();
            
            // Create a complete prerequisites map that includes ALL dependencies (recursive)
            $subjectToParentsMap = []; // Ancestors
            foreach ($directParentsMap as $sCode => $directPrereqs) {
                 $subjectToParentsMap[$sCode] = $this->getAllPrerequisites($sCode, $directParentsMap, []);
            }
            // Ensure current subject is in the map even if it has no parents (for consistency)
            if (!isset($subjectToParentsMap[$subject->subject_code])) {
                 $subjectToParentsMap[$subject->subject_code] = [];
            }


            // MAP 2: CHILDREN (for Pre-requisite to/Descendants) - What subjects require this one
            // We need to traverse DOWN.
            // Direct Children Map: Parent -> [Children]
            $directChildrenMap = $allPrerequisites->groupBy('prerequisite_subject_code')->map(function ($item) {
                return $item->pluck('subject_code')->all();
            })->all();
            
            $subjectToChildrenMap = []; // Descendants
            foreach ($directChildrenMap as $pCode => $directChildren) {
                $subjectToChildrenMap[$pCode] = $this->getAllPrerequisites($pCode, $directChildrenMap, []);
            }
            // Ensure current subject is in map
            if (!isset($subjectToChildrenMap[$subject->subject_code])) {
                $subjectToChildrenMap[$subject->subject_code] = [];
            }
            
            $prerequisiteData = [
                'subjectToParentsMap' => $subjectToParentsMap,
                'subjectToChildrenMap' => $subjectToChildrenMap
            ];
        }

        // Generate HTML from the view
        $html = view('subject_pdf', [
            'subject' => $subject,
            'curriculum' => $curriculum,
            'prerequisiteData' => $prerequisiteData
        ])->render();
        
        // Create mPDF instance
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
        ]);
        
        // Write HTML to PDF
        $mpdf->WriteHTML($html);
        
        // Generate a filename based on the subject code and return the PDF for download.
        $fileName = preg_replace('/[^A-Za-z0-9\-]/', '_', $subject->subject_code);
        
        // Record Export History
        $user = auth()->user();
        if ($user) {
            // Only create export history if we have a valid curriculum, otherwise just log to activity log
            // This prevents "Column 'curriculum_id' cannot be null" error for unmapped subjects
            $historyId = null;
            
            if ($curriculum) {
                try {
                    $history = ExportHistory::create([
                        'curriculum_id' => $curriculum->id,
                        'user_id' => $user->id,
                        'file_name' => $fileName . '_details.pdf',
                        'format' => 'pdf',
                        'export_type' => 'subject',
                        'exported_by_name' => $user->name ?? $user->username,
                        'exported_by_email' => $user->email,
                    ]);
                    $historyId = $history->id;
                } catch (\Exception $e) {
                    // If history creation fails (e.g. strict SQL mode), just continue to allow download
                    \Illuminate\Support\Facades\Log::warning('Failed to create export history: ' . $e->getMessage());
                }
            }

            // Log Activity for all authenticated users
            ActivityLogService::logExport(
                'subject_export',
                $fileName . '_details.pdf',
                [
                    'subject_id' => $subject->id,
                    'subject_code' => $subject->subject_code,
                    'subject_name' => $subject->subject_name ?? 'Unknown',
                    'curriculum_id' => $curriculum ? $curriculum->id : null,
                    'format' => 'pdf',
                    'export_type' => 'subject',
                    'export_history_id' => $historyId
                ]
            );
            // Also update last activity
            if (method_exists($user, 'updateLastActivity')) {
                $user->updateLastActivity();
            }
        }
        
        // Output PDF for download
        return response($mpdf->Output($fileName . '_details.pdf', 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '_details.pdf"');
    }

    /**
     * Recursively get all prerequisites for a subject (including prerequisites of prerequisites)
     * 
     * @param string $subjectCode The subject to get prerequisites for
     * @param array $directParentsMap Map of direct prerequisite relationships
     * @param array $visited Array to track visited subjects (prevent infinite loops)
     * @return array All prerequisite subject codes
     */
    private function getAllPrerequisites($subjectCode, $directParentsMap, $visited = [])
    {
        // Prevent infinite loops
        if (in_array($subjectCode, $visited)) {
            return [];
        }
        
        $visited[] = $subjectCode;
        $allPrereqs = [];
        
        // Get direct prerequisites for this subject
        $directPrereqs = $directParentsMap[$subjectCode] ?? [];
        
        foreach ($directPrereqs as $prereq) {
            // Add the direct prerequisite
            $allPrereqs[] = $prereq;
            
            // Recursively get prerequisites of this prerequisite
            $nestedPrereqs = $this->getAllPrerequisites($prereq, $directParentsMap, $visited);
            $allPrereqs = array_merge($allPrereqs, $nestedPrereqs);
        }
        
        // Remove duplicates and return
        return array_unique($allPrereqs);
    }

    /**
     * Export ALL subjects as a ZIP of PDFs.
     * Use a generator to stream content and avoid memory exhaustion.
     */
    public function exportAllPdf()
    {
        // Increase limits for bulk processing
        ini_set('max_execution_time', 600); // 10 minutes
        ini_set('memory_limit', '1024M');   // 1GB

        // Check if we have subjects
        if (Subject::count() === 0) {
            return response()->json(['error' => 'No subjects found to export.'], 404);
        }

        return Zip::create('all_subjects.zip', $this->yieldZipEntries());
    }

    /**
     * Generator function to yield ZIP entries one by one.
     * This keeps memory usage low as it processes one PDF at a time.
     */
    private function yieldZipEntries()
    {
        // Use cursor() to stream records from database instead of loading all at once
        foreach (Subject::with('grades')->cursor() as $subject) {
            $fileName = preg_replace('/[^A-Za-z0-9\-]/', '_', $subject->subject_code) . '.pdf';
            
            // Generate PDF content
            // We verify content matches mPDF requirements (it returns string)
            $content = $this->generatePdfContent($subject);
            
            // Yield key => value pair where key is filename and value is content
            yield $fileName => $content;
        }
    }

    /**
     * Helper to generate PDF content string for a subject
     */
    private function generatePdfContent($subject)
    {
        try {
            // Simplified curriculum/prereq logic for bulk export to avoid N+1 and memory limit
            // We will just try to find the first curriculum attached
            $curriculum = $subject->curriculums()->first();
            
            // Use basic view
            $html = view('subject_pdf', [
                'subject' => $subject,
                'curriculum' => $curriculum,
                'prerequisiteData' => [] // Skipping complex prereq map for bulk export to save memory
            ])->render();

            // Create new mPDF instance for this iteration
            // We strictly disable auto-font discovery to save performance if possible, 
            // or just keep default.
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'tempDir' => storage_path('app/private/pdf_temp') // Ensure temp dir is writable and used
            ]);
            
            $mpdf->WriteHTML($html);
            return $mpdf->Output('', 'S');
        } catch (\Exception $e) {
            // Return error text as file content instead of crashing entire zip
            return "Error generating PDF for {$subject->subject_code}: " . $e->getMessage();
        }
    }
}
