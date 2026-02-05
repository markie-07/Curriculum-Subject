<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $subject->subject_name ?? 'Subject Details' }}</title>
    <style>
        @page {
            margin: 12mm 12mm 12mm 12mm;
        }

        body {
            font-family: 'Calibri', 'Arial', 'Helvetica', sans-serif;
            font-size: 8pt;
            line-height: 1.5;
            color: #111;
            margin: 0;
            padding: 0;
            text-align: justify;
            word-spacing: 2pt;
            letter-spacing: 0.2pt;
        }

        /* Utilities */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .page-break { page-break-after: always; }
        
        /* Header */
        .header-container {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        .header-logo {
            width: 60px;
            height: auto;
            margin-bottom: 6px;
        }
        .school-name {
            font-size: 10pt;
            font-weight: bold;
            margin: 0;
            color: #000;
            letter-spacing: 0.5pt;
            line-height: 1.3;
        }
        .school-address {
            font-size: 8pt;
            color: #444;
            margin-top: 4px;
            line-height: 1.4;
        }

        /* Section Headers */
        .section-title {
            background-color: #f3f4f6;
            color: #000;
            font-size: 9pt;
            font-weight: bold;
            padding: 6px 10px;
            margin-top: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #333;
            text-transform: uppercase;
            letter-spacing: 0.3pt;
        }

        /* Tables & Grids */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        
        th, td {
            padding: 6px 8px;
            vertical-align: top;
            font-size: 8pt;
            border: 1px solid #ccc;
            line-height: 1.5;
        }

        th {
            background-color: #f9fafb;
            font-weight: bold;
            text-align: left;
            color: #000;
        }

        /* Layout Tables (Invisible Borders) */
        table.layout-table { margin-bottom: 0; }
        table.layout-table th, table.layout-table td { border: none; padding: 5px; }

        /* Info Lists */
        .info-item { margin-bottom: 5px; }
        .info-label { font-weight: bold; color: #333; font-size: 8pt; display: block; margin-bottom: 2px; }
        .info-value { color: #000; }

        /* Weekly Plan Specifics */
        .week-header {
            background-color: #333;
            color: #fff;
            text-align: center;
            font-weight: bold;
            padding: 8px;
            border: 1px solid #333;
        }
        
        .exam-row td {
            background-color: #fef2f2;
            text-align: center;
            font-weight: bold;
            padding: 15px;
            color: #991b1b;
        }

        /* Legend & Descriptions */
        .description-box { text-align: justify; }
        
        .legend-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 8px;
            margin-top: 8px;
            font-size: 8pt;
            line-height: 1.5;
        }
        .legend-title { font-weight: bold; margin-bottom: 5px; display: block; }
        .legend-list { margin: 0; padding-left: 20px; }
        
        /* Approvals */
        .approval-table { margin-top: 40px; width: 100%; border: none; }
        .approval-table td { border: none; text-align: center; vertical-align: bottom; height: 60px; }
        .signature-line { border-top: 1px solid #000; width: 80%; margin: 5px auto; }
        .approver-name { font-weight: bold; font-size: 10pt; }
        .approver-title { font-size: 8.5pt; color: #555; font-style: italic; }

    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header-container">
        @php
            $imagePath = public_path('/images/BCPLOGO.png');
            $src = '';
            if (file_exists($imagePath)) {
                $imageData = base64_encode(file_get_contents($imagePath));
                $src = 'data:image/png;base64,' . $imageData;
            }
        @endphp
        
        @if($src)
            <img src="{{ $src }}" alt="Logo" class="header-logo">
        @endif
        <h1 class="school-name">BESTLINK COLLEGE OF THE PHILIPPINES</h1>
        <p class="school-address">#1071 Brgy. Kaligayahan, Quirino Hi-way, Novaliches, Quezon City</p>
    </div>

    <!-- COURSE INFORMATION -->
    <div class="section-title">Course Information</div>
    
    @php
        // DEBUG: Check prerequisite data
        if (isset($prerequisiteData)) {
            echo "<!-- DEBUG: prerequisiteData exists -->";
            if (isset($prerequisiteData['subjectToParentsMap'])) {
                $parents = $prerequisiteData['subjectToParentsMap'][$subject->subject_code] ?? [];
                echo "<!-- DEBUG: Parents for {$subject->subject_code}: " . json_encode($parents) . " -->";
            }
            if (isset($prerequisiteData['subjectToChildrenMap'])) {
                $children = $prerequisiteData['subjectToChildrenMap'][$subject->subject_code] ?? [];
                echo "<!-- DEBUG: Children for {$subject->subject_code}: " . json_encode($children) . " -->";
            }
        } else {
            echo "<!-- DEBUG: prerequisiteData NOT SET -->";
        }
    @endphp
    
    <table class="layout-table">
        <tr>
            <td width="50%">
                <div class="info-item">
                    <span class="info-label">Course Code:</span>
                    <span class="info-value">{{ $subject->subject_code }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Course Title:</span>
                    <span class="info-value">{{ $subject->subject_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Course Type:</span>
                    <span class="info-value">{{ $subject->subject_type }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Credit Prerequisites:</span>
                    <span class="info-value">
                        @if(!empty($prerequisiteData) && isset($prerequisiteData['subjectToParentsMap']))
                            @php
                                $creditPrereqs = $prerequisiteData['subjectToParentsMap'][$subject->subject_code] ?? [];
                                sort($creditPrereqs);
                                echo !empty($creditPrereqs) ? implode(', ', $creditPrereqs) : 'None';
                            @endphp
                        @else
                            None
                        @endif
                    </span>
                </div>
            </td>
            <td width="50%">
                <div class="info-item">
                    <span class="info-label">Credit Units:</span>
                    <span class="info-value">{{ $subject->subject_unit }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Contact Hours:</span>
                    <span class="info-value">{{ $subject->contact_hours ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Pre-requisite to:</span>
                    <span class="info-value">
                        @if(!empty($prerequisiteData) && isset($prerequisiteData['subjectToChildrenMap']))
                            @php
                                $prereqTo = $prerequisiteData['subjectToChildrenMap'][$subject->subject_code] ?? [];
                                sort($prereqTo);
                                echo !empty($prereqTo) ? implode(', ', $prereqTo) : 'None';
                            @endphp
                        @else
                            None
                        @endif
                    </span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="info-item">
                    <span class="info-label">Course Description:</span>
                    <div class="info-value description-box">{!! nl2br(e($subject->course_description ?? 'N/A')) !!}</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- INSTITUTIONAL INFORMATION -->
    <div class="section-title">Institutional Information</div>
    
    <table>
        <thead>
            <tr>
                <th colspan="2" class="text-center">VISION</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="50%">
                    <div class="text-bold text-center">SCHOOL</div>
                    <div class="description-box" style="margin-top: 5px;">BCP is committed to provide and promote quality education with a unique, modern and research-based curriculum with delivery systems geared towards excellence.</div>
                </td>
                <td width="50%">
                    <div class="text-bold text-center">DEPARTMENT</div>
                    <div class="description-box" style="margin-top: 5px;">To improve the quality of student's input and by promoting IT enabled, market driven and internationally comparable programs through quality assurance systems, upgrading faculty qualifications and establishing international linkages.</div>
                </td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan="2" class="text-center">MISSION</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="50%">
                    <div class="text-bold text-center">SCHOOL</div>
                    <div class="description-box" style="margin-top: 5px;">To produce self-motivated and self-directed individual who aims for academic excellence, God-fearing, peaceful, healthy and productive successful citizens.</div>
                </td>
                <td width="50%">
                    <div class="text-bold text-center">DEPARTMENT</div>
                    <div class="description-box" style="margin-top: 5px;">The College of Computer Studies is committed to provide quality information and communication technology education through the use of modern and transformation learning teaching process.</div>
                </td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan="2" class="text-center">PHILOSOPHY</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="50%">
                    <div class="text-bold text-center">SCHOOL</div>
                    <div class="description-box" style="margin-top: 5px;">BCP advocates threefold core values: "Fides", "Faith; "Ratio", Reason; Pax. Peace. "Fides" represents BCPs, endeavors for expansion, development, and growth amidst the challenges of the new millennium.</div>
                </td>
                <td width="50%">
                    <div class="text-bold text-center">DEPARTMENT</div>
                    <div class="description-box" style="margin-top: 5px;">General Education advocates threefold core values "Devotion", "Serenity', "Determination" representing commitment to provide quality education.</div>
                </td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="text-center">CORE VALUES</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="text-bold" style="margin-bottom: 5px;">FAITH, KNOWLEDGE, CHARITY AND HUMILITY</div>
                    <ul style="margin: 0; padding-left: 20px;">
                        <li><span class="text-bold">FAITH (Fides)</span> represents BCP's endeavor for expansion, development and for growth amidst the global challenges of the new millennium.</li>
                        <li><span class="text-bold">KNOWLEDGE (Cognito)</span> connotes the institution's efforts to impart excellent lifelong education that can be used as human tool so that one can liberate himself/herself from ignorance and poverty.</li>
                        <li><span class="text-bold">CHARITY (Caritas)</span> is the institution's commitment towards its clienteles.</li>
                        <li><span class="text-bold">HUMILITY (Humiliates)</span> refers to the institution's recognition of the human frailty, its imperfection.</li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- MAPPING GRIDS -->
    <div class="section-title">Mapping Grids</div>
    
    <div class="text-bold" style="margin-bottom: 8px; font-size:10pt;">PROGRAM MAPPING GRID</div>
    @if(!empty($subject->program_mapping_grid))
        <table>
            <thead>
                <tr>
                    <th>PILO</th>
                    <th class="text-center">CTPSS</th>
                    <th class="text-center">ECC</th>
                    <th class="text-center">EPP</th>
                    <th class="text-center">GLC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subject->program_mapping_grid as $row)
                <tr>
                    <td>{{ $row['pilo'] ?? '' }}</td>
                    <td class="text-center">{{ $row['ctpss'] ?? '' }}</td>
                    <td class="text-center">{{ $row['ecc'] ?? '' }}</td>
                    <td class="text-center">{{ $row['epp'] ?? '' }}</td>
                    <td class="text-center">{{ $row['glc'] ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="font-style: italic; color: #666;">No program mapping data available.</p>
    @endif

    <div class="text-bold" style="margin: 20px 0 8px 0; font-size:10pt;">COURSE MAPPING GRID</div>
    @if(!empty($subject->course_mapping_grid))
        <table>
            <thead>
                <tr>
                    <th>CILO</th>
                    <th class="text-center">CTPSS</th>
                    <th class="text-center">ECC</th>
                    <th class="text-center">EPP</th>
                    <th class="text-center">GLC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subject->course_mapping_grid as $row)
                <tr>
                    <td>{{ $row['cilo'] ?? '' }}</td>
                    <td class="text-center">{{ $row['ctpss'] ?? '' }}</td>
                    <td class="text-center">{{ $row['ecc'] ?? '' }}</td>
                    <td class="text-center">{{ $row['epp'] ?? '' }}</td>
                    <td class="text-center">{{ $row['glc'] ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="font-style: italic; color: #666;">No course mapping data available.</p>
    @endif

    <div class="legend-box">
        <span class="legend-title">Legend:</span>
        <ul class="legend-list">
            <li><span class="text-bold">L</span> – Facilitate Learning of the competencies</li>
            <li><span class="text-bold">P</span> – Allow student to practice competencies (No input but competency is evaluated)</li>
            <li><span class="text-bold">O</span> – Provide opportunity for development (No input or evaluation, but there is opportunity to practice the competencies)</li>
            <li><span class="text-bold">CTPSS</span> - critical thinking and problem-solving skills;</li>
            <li><span class="text-bold">ECC</span> - effective communication and collaboration;</li>
            <li><span class="text-bold">EPP</span> - ethical and professional practice; and,</li>
            <li><span class="text-bold">GLC</span> - global and lifelong learning commitment.</li>
        </ul>
    </div>

    <!-- LEARNING OUTCOMES -->
    <div class="section-title">Learning Outcomes</div>
    
    <table>
        <tbody>
            <tr>
                <td>
                    <div class="text-bold" style="margin-bottom: 5px;">PROGRAM INTENDED LEARNING OUTCOMES (PILO):</div>
                    <div class="description-box">{!! nl2br(e($subject->pilo_outcomes ?? 'N/A')) !!}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="text-bold" style="margin-bottom: 5px;">COURSE INTENDED LEARNING OUTCOMES (CILO):</div>
                    <div class="description-box">{!! nl2br(e($subject->cilo_outcomes ?? 'N/A')) !!}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="text-bold" style="margin-bottom: 5px;">EXPECTED BCP GRADUATE ELEMENTS:</div>
                    <div class="description-box">
                        The BCP ideal graduate demonstrates/internalizes this attribute:
                        <ul style="margin: 5px 0; padding-left: 20px;">
                            <li>critical thinking and problem-solving skills;</li>
                            <li>effective communication and collaboration;</li>
                            <li>ethical and professional practice; and,</li>
                            <li>global and lifelong learning commitment.</li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="text-bold" style="margin-bottom: 5px;">LEARNING OUTCOMES:</div>
                    <div class="description-box">{!! nl2br(e($subject->learning_outcomes ?? 'N/A')) !!}</div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- WEEKLY PLAN -->
    <div class="section-title">Weekly Plan</div>
    
    @if(!empty($subject->lessons) && is_array($subject->lessons))
        @foreach(collect($subject->lessons)->sortBy(fn($val, $key) => (int) filter_var($key, FILTER_SANITIZE_NUMBER_INT)) as $week => $details)
            @php
                $lessonData = [
                    'content' => '', 'silo' => '', 'at_onsite' => '', 'at_offsite' => '',
                    'tla_onsite' => '', 'tla_offsite' => '', 'ltsm' => '', 'output' => ''
                ];
                if(is_string($details)) {
                    $parts = explode(',, ', $details);
                    foreach ($parts as $part) {
                        if (str_starts_with($part, 'Detailed Lesson Content:')) $lessonData['content'] = trim(str_replace('Detailed Lesson Content:', '', $part));
                        if (str_starts_with($part, 'Student Intended Learning Outcomes:')) $lessonData['silo'] = trim(str_replace('Student Intended Learning Outcomes:', '', $part));
                        if (str_starts_with($part, 'Assessment:')) { preg_match('/ONSITE: (.*) OFFSITE: (.*)/s', $part, $match); $lessonData['at_onsite'] = trim($match[1] ?? ''); $lessonData['at_offsite'] = trim($match[2] ?? ''); }
                        if (str_starts_with($part, 'Activities:')) { preg_match('/ON-SITE: (.*) OFF-SITE: (.*)/s', $part, $match); $lessonData['tla_onsite'] = trim($match[1] ?? ''); $lessonData['tla_offsite'] = trim($match[2] ?? ''); }
                        if (str_starts_with($part, 'Learning and Teaching Support Materials:')) $lessonData['ltsm'] = trim(str_replace('Learning and Teaching Support Materials:', '', $part));
                        if (str_starts_with($part, 'Output Materials:')) $lessonData['output'] = trim(str_replace('Output Materials:', '', $part));
                    }
                }
                $weekNum = (int) filter_var($week, FILTER_SANITIZE_NUMBER_INT);
            @endphp
            
            <table style="margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th colspan="2" class="week-header">{{ $week }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if(in_array($weekNum, [6, 12, 18]))
                        <tr class="exam-row">
                            <td colspan="2">
                                {{ $lessonData['content'] ?: ($weekNum == 6 ? 'Prelim Exam' : ($weekNum == 12 ? 'Midterm Exam' : 'Final Exam')) }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td width="50%">
                                <span class="info-label">Content:</span>
                                {{ $lessonData['content'] ?: 'N/A' }}
                            </td>
                            <td width="50%">
                                <span class="info-label">Student Intended Learning Outcomes:</span>
                                {{ $lessonData['silo'] ?: 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color: #f9fafb; font-weight: bold;">Assessment Tasks (ATs):</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="info-label">ONSITE:</span>
                                {{ $lessonData['at_onsite'] ?: 'N/A' }}
                            </td>
                            <td>
                                <span class="info-label">OFFSITE:</span>
                                {{ $lessonData['at_offsite'] ?: 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color: #f9fafb; font-weight: bold;">Suggested Teaching/Learning Activities (TLAs):</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="info-label">Face to Face (On-Site):</span>
                                {{ $lessonData['tla_onsite'] ?: 'N/A' }}
                            </td>
                            <td>
                                <span class="info-label">Online (Off-Site):</span>
                                {{ $lessonData['tla_offsite'] ?: 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="info-label">Learning and Teaching Support Materials (LTSM):</span>
                                {{ $lessonData['ltsm'] ?: 'N/A' }}
                            </td>
                            <td>
                                <span class="info-label">Output Materials:</span>
                                {{ $lessonData['output'] ?: 'N/A' }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endforeach
    @else
        <p>No weekly plan data available.</p>
    @endif
    
    <div class="page-break"></div>

    <!-- COURSE REQUIREMENTS -->
    <div class="section-title">Course Requirements and Policies</div>
    
    <table>
        <tbody>
            <tr>
                <td width="30%" class="text-bold" style="background-color: #f9fafb;">Basic Readings / Textbooks:</td>
                <td>{!! nl2br(e($subject->basic_readings ?? 'N/A')) !!}</td>
            </tr>
            <tr>
                <td class="text-bold" style="background-color: #f9fafb;">Extended Readings / References:</td>
                <td>{!! nl2br(e($subject->extended_readings ?? 'N/A')) !!}</td>
            </tr>
            <tr>
                <td class="text-bold" style="background-color: #f9fafb;">Course Assessment:</td>
                <td>{!! nl2br(e($subject->course_assessment ?? 'N/A')) !!}</td>
            </tr>
            <tr>
                <td class="text-bold" style="background-color: #f9fafb;">Committee Members:</td>
                <td>{!! nl2br(e($subject->committee_members ?? 'N/A')) !!}</td>
            </tr>
            <tr>
                <td class="text-bold" style="background-color: #f9fafb;">Consultation Schedule:</td>
                <td>{!! nl2br(e($subject->consultation_schedule ?? 'N/A')) !!}</td>
            </tr>
        </tbody>
    </table>

    <!-- GRADING SYSTEM -->
    @if($subject->grades && $subject->grades->isNotEmpty())
        @php
            $gradeRecord = $subject->grades->first();
            $components = $gradeRecord->components ?? [];
        @endphp
        
        @if(!empty($components))
            <div class="section-title" style="margin-top: 30px;">Grading System</div>
            
            <table>
                <thead>
                    <tr>
                        <th>Grade Component</th>
                        <th class="text-center" width="20%">Percentage (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($components as $periodName => $periodData)
                        @if(isset($periodData['weight']))
                            {{-- Period Header (e.g., Prelim, Midterm, Finals) --}}
                            <tr style="background-color: #e5e7eb;">
                                <td class="text-bold">{{ $periodName }}</td>
                                <td class="text-center text-bold">{{ $periodData['weight'] }}%</td>
                            </tr>
                            
                            {{-- Main Components within the period --}}
                            @if(isset($periodData['components']) && is_array($periodData['components']))
                                @foreach($periodData['components'] as $component)
                                    <tr>
                                        <td style="padding-left: 20px;">{{ $component['name'] ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $component['weight'] ?? 0 }}%</td>
                                    </tr>
                                    
                                    {{-- Sub-components if they exist --}}
                                    @if(isset($component['sub_components']) && is_array($component['sub_components']) && count($component['sub_components']) > 0)
                                        @foreach($component['sub_components'] as $subComponent)
                                            <tr style="background-color: #f9fafb;">
                                                <td style="padding-left: 40px; font-size: 8pt; color: #666;">{{ $subComponent['name'] ?? 'N/A' }}</td>
                                                <td class="text-center" style="font-size: 8pt; color: #666;">{{ $subComponent['weight'] ?? 0 }}%</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

    <!-- APPROVAL SECTION -->
    <table class="approval-table">
        <tr>
            <td width="33%">
                <div class="signature-line"></div>
                <div class="approver-title">Prepared:</div>
                <div class="approver-name">{{ $subject->prepared_by ?? '' }}</div>
                <div class="approver-title">Cluster Leader</div>
            </td>
            <td width="33%">
                <div class="signature-line"></div>
                <div class="approver-title">Reviewed:</div>
                <div class="approver-name">{{ $subject->reviewed_by ?? '' }}</div>
                <div class="approver-title">General Education Program Head</div>
            </td>
            <td width="33%">
                <div class="signature-line"></div>
                <div class="approver-title">Approved:</div>
                <div class="approver-name">{{ $subject->approved_by ?? '' }}</div>
                <div class="approver-title">Vice President for Academic Affairs</div>
            </td>
        </tr>
    </table>

</body>
</html>