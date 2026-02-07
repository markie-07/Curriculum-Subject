<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntegrationController extends Controller
{
    /**
     * Get integrated curriculum data.
     * 
     * Returns a flat list of subjects within curriculums with the following fields:
     * - Category (Senior High or College)
     * - Course (Curriculum Name)
     * - Academic Year
     * - Year Level (1st Year, 2nd Year, etc.)
     * - Description (Subject Course Description)
     * - Subject (Subject Name)
     */
    public function getCurriculumSubjects()
    {
        // Use a direct DB query for performance to avoid hydrating thousands of Eloquent models.
        // This is significantly faster for large datasets.
        
        $results = DB::table('curriculums as c')
            ->join('curriculum_subject as cs', 'c.id', '=', 'cs.curriculum_id')
            ->join('subjects as s', 'cs.subject_id', '=', 's.id')
            ->leftJoin('programs as p', 'c.program_code', '=', 'p.code')
            ->select(
                'c.curriculum as course',
                'c.academic_year',
                'c.year_level as curriculum_year_level',
                'p.department as program_department',
                'cs.year as pivot_year',
                's.course_description as description',
                's.subject_name as subject'
            )
            ->get();

        // Transform the results efficiently
        $data = $results->map(function($row) {
            // Determine Category
            $category = $row->program_department ?? 
                        ($row->curriculum_year_level === 'Senior High' ? 'Senior High' : 'College');
            
            // Format Year Level
            $formattedYear = $this->formatYearLevel($row->pivot_year);

            return [
                'Category' => $category,
                'Course' => $row->course,
                'Academic Year' => $row->academic_year,
                'Year Level' => $formattedYear,
                'Description' => $row->description,
                'Subjects' => $row->subject,
            ];
        });

        return response()->json($data);
    }

    private function formatYearLevel($year)
    {
        if (empty($year)) return '';
        
        // If it's already a string like "1st Year", return it
        if (!is_numeric($year)) {
            return $year;
        }

        // Convert numeric year to ordinal string
        $suffix = 'th';
        if ($year == 1) $suffix = 'st';
        elseif ($year == 2) $suffix = 'nd';
        elseif ($year == 3) $suffix = 'rd';
        
        return "{$year}{$suffix} Year";
    }
}
