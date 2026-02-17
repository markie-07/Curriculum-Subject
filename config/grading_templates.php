<?php

return [
    'gen_ed' => [
        'name' => 'General Education',
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
    'prof_lab' => [
        'name' => 'Professional (Laboratory)',
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
    'prof_non_lab' => [
        'name' => 'Professional (Non-Laboratory)',
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
    'prof_board' => [
        'name' => 'Professional (Board Courses)',
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
    'prof_oc' => [
        'name' => 'Professional (OC)',
        'periods' => [ 'Prelim' => 30, 'Midterm' => 30, 'Finals' => 40 ],
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
    'nstp1' => [
        'name' => 'NSTP 1',
        'periods' => [ 'Prelim' => 30, 'Midterm' => 30, 'Finals' => 40 ],
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
    'nstp2' => [
        'name' => 'NSTP 2',
        'periods' => [ 'Prelim' => 30, 'Midterm' => 30, 'Finals' => 40 ],
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
                'sub_components' => [] // OCR 100% implicitly
            ],
            [
                'name' => 'Examination',
                'weight' => 30,
                'sub_components' => []
            ]
        ]
    ],
    'research' => [
        'name' => 'Research',
        'periods' => [ 'Prelim' => 30, 'Midterm' => 30, 'Finals' => 40 ],
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
    'ojt' => [
        'name' => 'OJT / Practicum',
        'periods' => [ 'Prelim' => 30, 'Midterm' => 30, 'Finals' => 40 ],
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
