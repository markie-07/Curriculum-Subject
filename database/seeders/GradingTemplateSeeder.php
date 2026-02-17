<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GradingTemplate;

class GradingTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'code' => 'gen_ed',
                'name' => 'General Education',
                'description' => 'Standard grading template for general education courses',
                'periods' => [
                    'Prelim' => 30,
                    'Midterm' => 30,
                    'Finals' => 40
                ],
                'components' => [
                    [
                        'name' => 'Class Standing',
                        'weight' => 40,
                        'sub_components' => [
                            ['name' => 'Attendance (F2F)', 'weight' => 7],
                            ['name' => 'Attendance (Online)', 'weight' => 3],
                            ['name' => 'Written Works (F2F)', 'weight' => 33],
                            ['name' => 'Written Works (Online)', 'weight' => 17],
                            ['name' => 'Performance Task (F2F)', 'weight' => 27],
                            ['name' => 'Performance Task (Online)', 'weight' => 13]
                        ]
                    ],
                    [
                        'name' => 'Project',
                        'weight' => 25,
                        'sub_components' => []
                    ],
                    [
                        'name' => 'Major Examination',
                        'weight' => 35,
                        'sub_components' => []
                    ]
                ]
            ],
            [
                'code' => 'prof_lab',
                'name' => 'Professional (Laboratory)',
                'description' => 'Grading template for professional courses with laboratory component',
                'periods' => [
                    'Prelim' => 30,
                    'Midterm' => 30,
                    'Finals' => 40
                ],
                'components' => [
                    [
                        'name' => 'Class Standing',
                        'weight' => 35,
                        'sub_components' => [
                            ['name' => 'Attendance (F2F)', 'weight' => 7],
                            ['name' => 'Attendance (Online)', 'weight' => 3],
                            ['name' => 'Written Works (F2F)', 'weight' => 27],
                            ['name' => 'Written Works (Online)', 'weight' => 13],
                            ['name' => 'Performance Task (F2F)', 'weight' => 33],
                            ['name' => 'Performance Task (Online)', 'weight' => 17]
                        ]
                    ],
                    [
                        'name' => 'Project',
                        'weight' => 40,
                        'sub_components' => []
                    ],
                    [
                        'name' => 'Major Examination',
                        'weight' => 25,
                        'sub_components' => []
                    ]
                ]
            ],
            [
                'code' => 'prof_non_lab',
                'name' => 'Professional (Non-Laboratory)',
                'description' => 'Grading template for professional courses without laboratory component',
                'periods' => [
                    'Prelim' => 30,
                    'Midterm' => 30,
                    'Finals' => 40
                ],
                'components' => [
                    [
                        'name' => 'Class Standing',
                        'weight' => 35,
                        'sub_components' => [
                            ['name' => 'Attendance (F2F)', 'weight' => 7],
                            ['name' => 'Attendance (Online)', 'weight' => 3],
                            ['name' => 'Written Works (F2F)', 'weight' => 27],
                            ['name' => 'Written Works (Online)', 'weight' => 13],
                            ['name' => 'Performance Task (F2F)', 'weight' => 33],
                            ['name' => 'Performance Task (Online)', 'weight' => 17]
                        ]
                    ],
                    [
                        'name' => 'Project',
                        'weight' => 40,
                        'sub_components' => []
                    ],
                    [
                        'name' => 'Major Examination',
                        'weight' => 25,
                        'sub_components' => []
                    ]
                ]
            ],
            [
                'code' => 'prof_board',
                'name' => 'Professional (Board Courses)',
                'description' => 'Grading template for board examination courses',
                'periods' => [
                    'Prelim' => 30,
                    'Midterm' => 30,
                    'Finals' => 40
                ],
                'components' => [
                    [
                        'name' => 'Class Standing',
                        'weight' => 40,
                        'sub_components' => [
                            ['name' => 'Attendance (F2F)', 'weight' => 7],
                            ['name' => 'Attendance (Online)', 'weight' => 3],
                            ['name' => 'Written Works (F2F)', 'weight' => 27],
                            ['name' => 'Written Works (Online)', 'weight' => 13],
                            ['name' => 'Performance Task (F2F)', 'weight' => 33],
                            ['name' => 'Performance Task (Online)', 'weight' => 17]
                        ]
                    ],
                    [
                        'name' => 'Project',
                        'weight' => 30,
                        'sub_components' => []
                    ],
                    [
                        'name' => 'Major Examination',
                        'weight' => 30,
                        'sub_components' => []
                    ]
                ]
            ],
            [
                'code' => 'prof_oc',
                'name' => 'Professional (OC)',
                'description' => 'Grading template for professional courses with OC component',
                'periods' => [
                    'Prelim' => 30,
                    'Midterm' => 30,
                    'Finals' => 40
                ],
                'components' => [
                    [
                        'name' => 'Class Standing',
                        'weight' => 40,
                        'sub_components' => [
                            ['name' => 'Attendance (F2F)', 'weight' => 7],
                            ['name' => 'Attendance (Online)', 'weight' => 3],
                            ['name' => 'Written Works (F2F)', 'weight' => 27],
                            ['name' => 'Written Works (Online)', 'weight' => 13],
                            ['name' => 'Performance Task (F2F)', 'weight' => 33],
                            ['name' => 'Performance Task (Online)', 'weight' => 17]
                        ]
                    ],
                    [
                        'name' => 'Project',
                        'weight' => 35,
                        'sub_components' => [
                            ['name' => 'CBO', 'weight' => 40],
                            ['name' => 'OCR', 'weight' => 60]
                        ]
                    ],
                    [
                        'name' => 'Examination',
                        'weight' => 25,
                        'sub_components' => []
                    ]
                ]
            ],
            [
                'code' => 'nstp1',
                'name' => 'NSTP 1',
                'description' => 'Grading template for NSTP 1 courses',
                'periods' => [
                    'Prelim' => 30,
                    'Midterm' => 30,
                    'Finals' => 40
                ],
                'components' => [
                    [
                        'name' => 'Class Standing',
                        'weight' => 40,
                        'sub_components' => [
                            ['name' => 'Attendance (F2F)', 'weight' => 7],
                            ['name' => 'Attendance (Online)', 'weight' => 3],
                            ['name' => 'Written Works (F2F)', 'weight' => 33],
                            ['name' => 'Written Works (Online)', 'weight' => 17],
                            ['name' => 'Performance Task (F2F)', 'weight' => 27],
                            ['name' => 'Performance Task (Online)', 'weight' => 13]
                        ]
                    ],
                    [
                        'name' => 'Project',
                        'weight' => 30,
                        'sub_components' => []
                    ],
                    [
                        'name' => 'Examination',
                        'weight' => 30,
                        'sub_components' => []
                    ]
                ]
            ],
            [
                'code' => 'nstp2',
                'name' => 'NSTP 2',
                'description' => 'Grading template for NSTP 2 courses',
                'periods' => [
                    'Prelim' => 30,
                    'Midterm' => 30,
                    'Finals' => 40
                ],
                'components' => [
                    [
                        'name' => 'Class Standing',
                        'weight' => 30,
                        'sub_components' => [
                            ['name' => 'Attendance (F2F)', 'weight' => 7],
                            ['name' => 'Attendance (Online)', 'weight' => 3],
                            ['name' => 'Written Works (F2F)', 'weight' => 23],
                            ['name' => 'Written Works (Online)', 'weight' => 12],
                            ['name' => 'Performance Task (F2F)', 'weight' => 37],
                            ['name' => 'Performance Task (Online)', 'weight' => 18]
                        ]
                    ],
                    [
                        'name' => 'Project',
                        'weight' => 40,
                        'sub_components' => []
                    ],
                    [
                        'name' => 'Examination',
                        'weight' => 30,
                        'sub_components' => []
                    ]
                ]
            ],
            [
                'code' => 'research',
                'name' => 'Research',
                'description' => 'Grading template for research courses',
                'periods' => [
                    'Prelim' => 30,
                    'Midterm' => 30,
                    'Finals' => 40
                ],
                'components' => [
                    [
                        'name' => 'Class Standing',
                        'weight' => 25,
                        'sub_components' => [
                            ['name' => 'Attendance (F2F)', 'weight' => 7],
                            ['name' => 'Attendance (Online)', 'weight' => 3],
                            ['name' => 'Written Works (F2F)', 'weight' => 30],
                            ['name' => 'Written Works (Online)', 'weight' => 15],
                            ['name' => 'Performance Task (F2F)', 'weight' => 30],
                            ['name' => 'Performance Task (Online)', 'weight' => 15]
                        ]
                    ],
                    [
                        'name' => 'Project',
                        'weight' => 40,
                        'sub_components' => []
                    ],
                    [
                        'name' => 'Examination',
                        'weight' => 35,
                        'sub_components' => [
                            ['name' => 'Written Exam', 'weight' => 20],
                            ['name' => 'Oral Exam', 'weight' => 80]
                        ]
                    ]
                ]
            ],
            [
                'code' => 'ojt',
                'name' => 'OJT / Practicum',
                'description' => 'Grading template for OJT and practicum courses',
                'periods' => [
                    'Prelim' => 30,
                    'Midterm' => 30,
                    'Finals' => 40
                ],
                'components' => [
                    [
                        'name' => 'Class Standing',
                        'weight' => 50,
                        'sub_components' => [
                            ['name' => 'Attendance (F2F)', 'weight' => 20],
                            ['name' => 'Attendance (Online)', 'weight' => 10],
                            ['name' => 'Written Works (F2F)', 'weight' => 27],
                            ['name' => 'Written Works (Online)', 'weight' => 13],
                            ['name' => 'Performance Task (F2F)', 'weight' => 20],
                            ['name' => 'Performance Task (Online)', 'weight' => 10]
                        ]
                    ],
                    [
                        'name' => 'Project',
                        'weight' => 35,
                        'sub_components' => []
                    ],
                    [
                        'name' => 'Examination',
                        'weight' => 15,
                        'sub_components' => []
                    ]
                ]
            ]
        ];

        foreach ($templates as $template) {
            GradingTemplate::updateOrCreate(
                ['code' => $template['code']],
                $template
            );
        }
    }
}
