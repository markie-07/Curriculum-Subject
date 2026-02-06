<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_code',
        'subject_name',
        'syllabus_type',
        'subject_type',
        'course_classification',
        'subject_unit',
        'memorandum',
        'memorandum_year',
        'memorandum_category',
        'lessons',
        'contact_hours',
        'prerequisites',
        'pre_requisite_to',
        'course_description',
        'program_mapping_grid',
        'course_mapping_grid',
        'pilo_outcomes',
        'cilo_outcomes',
        'learning_outcomes',
        'basic_readings',
        'extended_readings',
        'course_assessment',
        'course_policies',
        'committee_members',
        'consultation_schedule',
        'prepared_by',
        'reviewed_by',
        'approved_by',
        'deped_data',
        'syllabus_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'lessons' => 'array',
        'program_mapping_grid' => 'array',
        'course_mapping_grid' => 'array',
        'deped_data' => 'array',
    ];

    /**
     * The curriculums that belong to the subject.
     */
    public function curriculums(): BelongsToMany
    {
        return $this->belongsToMany(Curriculum::class, 'curriculum_subject')
            ->withPivot('year', 'semester')
            ->withTimestamps();
    }

    /**
     * Get the prerequisites for the subject.
     */
    public function prerequisites(): HasMany
    {
        return $this->hasMany(Prerequisite::class, 'subject_code', 'subject_code');
    }

    /**
     * Get the grade for the subject.
     */
    public function grade(): HasOne
    {
        return $this->hasOne(Grade::class, 'subject_id', 'id');
    }

    /**
     * Get the grades for the subject.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Get the versions for the subject.
     */
    public function versions(): HasMany
    {
        return $this->hasMany(SubjectVersion::class);
    }

    /**
     * Accessor for Lessons to inject defaults if missing.
     */
    public function getLessonsAttribute($value)
    {
        // Decode if it's a string (though casting should handle this, sometimes raw access needs it)
        $lessons = is_string($value) ? json_decode($value, true) : ($value ?? []);
        
        // Define Defaults
        $defaults = [
            'Week 0' => [
                'content' => "Detailed Lesson Content:\nBCP Vision, Mission, Goals, Objectives, Philosophy and School Organizational Structure School Policies Orientation in Online and Modular Learning System",
                'silo' => "Student Intended Learning Outcomes:\nInternalize the Vision, Mission, Goals, and Objectives of the institution.",
                'at_onsite' => "Assessment: ONSITE: Recitation", 
                'at_offsite' => "OFFSITE: Reflection Paper", // Note: Frontend often combines these into stored strings differently
                // Actually, looking at collected data in frontend, it stores as a SINGLE string per week usually?
                // Wait, collectWeeklyPlan in Blade:
                // lessons[`Week ${i}`] = [ `Detailed Lesson Content:\n${content}`, ... ].join(',, ');
                // So it stores a STRING per week key.
            ],
            // Exams
            'Week 6' => "Detailed Lesson Content:\nPrelim Exam",
            'Week 12' => "Detailed Lesson Content:\nMidterm Exam",
            'Week 18' => "Detailed Lesson Content:\nFinal Exam",
        ];

        // Format for Week 0 matches the frontend join format
        $week0String = implode(',, ', [
            "Detailed Lesson Content:\nBCP Vision, Mission, Goals, Objectives, Philosophy and School Organizational Structure School Policies Orientation in Online and Modular Learning System",
            "Student Intended Learning Outcomes:\nInternalize the Vision, Mission, Goals, and Objectives of the institution.",
            "Assessment: ONSITE: Recitation OFFSITE: Reflection Paper",
            "Activities: ON-SITE: Discussion\nLecture OFF-SITE: Student Handbook\nCourse Syllabus",
            "Learning and Teaching Support Materials:\nLCD Projector\nWhiteboard and Marker",
            "Output Materials:\nReflection Paper"
        ]);

        if (empty($lessons)) {
            $lessons = [];
        }

        // Inject Week 0 if missing
        if (!isset($lessons['Week 0'])) {
            $lessons['Week 0'] = $week0String;
        }

        // Inject Exams if missing (using simple format)
        foreach ([6 => 'Prelim Exam', 12 => 'Midterm Exam', 18 => 'Final Exam'] as $week => $exam) {
            $key = "Week $week";
            if (!isset($lessons[$key])) {
                $lessons[$key] = "Detailed Lesson Content:\n$exam";
            }
        }

        return $lessons;
    }

    public function getProgramMappingGridAttribute($value)
    {
         return is_string($value) ? json_decode($value, true) : ($value ?? []);
    }

    public function getCourseMappingGridAttribute($value)
    {
         return is_string($value) ? json_decode($value, true) : ($value ?? []);
    }
}

