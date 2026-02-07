<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Program;
use Illuminate\Http\Request;

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
        // Fetch curriculums with their subjects and pivot data (year, semester)
        // We might want to filter by approval_status if applicable, but user didn't specify.
        // Assuming we want all or maybe only approved. Let's start with all.
        $curriculums = Curriculum::with(['subjects' => function($query) {
            $query->select('subjects.id', 'subjects.subject_code', 'subjects.subject_name', 'subjects.course_description');
        }])->get();

        // Pre-fetch programs to avoid N+1 query
        $programs = Program::all()->keyBy('code');

        $data = [];

        foreach ($curriculums as $curriculum) {
            // Determine Category
            $category = 'College'; // Default
            if (isset($programs[$curriculum->program_code])) {
                $category = $programs[$curriculum->program_code]->department;
            } elseif ($curriculum->year_level === 'Senior High') {
                $category = 'Senior High';
            }

            foreach ($curriculum->subjects as $subject) {
                // Determine Year Level from Pivot
                $year = $subject->pivot->year;
                $formattedYearLevel = $this->formatYearLevel($year);

                $data[] = [
                    'Category' => $category,
                    'Course' => $curriculum->curriculum,
                    'Academic Year' => $curriculum->academic_year,
                    'Year Level' => $formattedYearLevel,
                    'Description' => $subject->course_description ?? '',
                    'Subjects' => $subject->subject_name, // Using subject_name as requested
                ];
            }
        }

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
