# Grading Templates Update - Summary

## Overview
Updated the grading templates system to include detailed modality splits (F2F and Online) and AWG (Average Weighted Grade) columns across all nine predefined templates.

## Changes Made

### 1. Frontend Template Configuration (`grade_setup.blade.php`)
Updated all JavaScript templates to match the exact specifications from the provided images:

#### Template Structures:

**General Education (gen_ed)**
- Class Standing: 40%
  - Attendance: 10% (F2F: 7%, Online: 3%)
  - Written Works: 50% (F2F: 33%, Online: 17%)
  - Performance Task: 40% (F2F: 27%, Online: 13%)
- Project (CBO): 25%
- AWG: 25%
- Examination (WE): 35%
- AWG: 35%

**Professional Laboratory (prof_lab)**
- Class Standing: 35%
  - Attendance: 10% (F2F: 7%, Online: 3%)
  - Written Works: 40% (F2F: 27%, Online: 13%)
  - Performance Task: 50% (F2F: 33%, Online: 17%)
- Project (CBO): 40%
- AWG: 40%
- Examination (WE): 25%
- AWG: 25%

**Professional Non-Laboratory (prof_non_lab)**
- Class Standing: 40%
  - Attendance: 10% (F2F: 7%, Online: 3%)
  - Written Works: 40% (F2F: 27%, Online: 13%)
  - Performance Task: 50% (F2F: 33%, Online: 17%)
- Project (CBO): 35%
- AWG: 35%
- Examination (WE): 25%
- AWG: 25%

**Professional Board Courses (prof_board)**
- Class Standing: 40%
  - Attendance: 10% (F2F: 7%, Online: 3%)
  - Written Works: 40% (F2F: 27%, Online: 13%)
  - Performance Task: 50% (F2F: 33%, Online: 17%)
- Project (CBO): 30%
- AWG: 30%
- Examination (WE): 30%
- AWG: 30%

**Professional OC (*OC) (prof_oc)**
- Class Standing: 40%
  - Attendance: 10% (F2F: 7%, Online: 3%)
  - Written Works: 40% (F2F: 27%, Online: 13%)
  - Performance Task: 50% (F2F: 33%, Online: 17%)
- Project: 35%
  - CBO: 40%
  - OCR: 60%
- AWG: 35%
- Examination (WE): 25%
- AWG: 25%

**NSTP 1 (nstp1)**
- Class Standing: 40%
  - Attendance: 10% (F2F: 7%, Online: 3%)
  - Written Works: 50% (F2F: 33%, Online: 17%)
  - Performance Task: 40% (F2F: 27%, Online: 13%)
- Project (CBO): 30%
- AWG: 30%
- Examination (WE): 30%
- AWG: 30%

**NSTP 2 (nstp2)**
- Class Standing: 30%
  - Attendance: 10% (F2F: 7%, Online: 3%)
  - Written Works: 35% (F2F: 23%, Online: 12%)
  - Performance Task: 55% (F2F: 37%, Online: 18%)
- Project (OCR): 40%
- AWG: 40%
- Examination (WE): 30%
- AWG: 30%

**Research (research)**
- Class Standing: 25%
  - Attendance: 10% (F2F: 7%, Online: 3%)
  - Written Works: 45% (F2F: 30%, Online: 15%)
  - Performance Task: 45% (F2F: 30%, Online: 15%)
- Project (CBO): 40%
- AWG: 40%
- Examination: 35%
  - WE (Written Exam): 20%
  - OE (Oral Exam): 80%
- AWG: 35%

**OJT / Practicum (ojt)**
- Class Standing: 50%
  - Attendance: 30% (F2F: 20%, Online: 10%)
  - Written Works: 40% (F2F: 27%, Online: 13%)
  - Performance Task: 30% (F2F: 20%, Online: 10%)
- Project (CBO): 35%
- AWG: 35%
- Examination (WE): 15%
- AWG: 15%

### 2. API Endpoint Update (`GradeController.php`)
Updated the `getGradingTemplates()` method to return the complete template structure including:
- All modality splits (F2F and Online percentages)
- AWG column indicators (`has_awg` and `is_awg` flags)
- Detailed sub-components (CBO, OCR, WE, OE)
- Comprehensive metadata about the templates

### 3. API Endpoint Access
**Route:** `GET /api/integration/grades/templates`
**Controller:** `GradeController@getGradingTemplates`

**Response Structure:**
```json
{
  "success": true,
  "templates": {
    "gen_ed": { ... },
    "prof_lab": { ... },
    ...
  },
  "metadata": {
    "total_templates": 9,
    "template_keys": [...],
    "note": "All weights are in percentages. Modalities represent F2F and Online distribution within each component.",
    "awg_info": "AWG (Average Weighted Grade) columns are included after major component sections."
  }
}
```

## Key Features Added

1. **Modality Splits**: Each attendance, written works, and performance task component now includes F2F and Online percentages
2. **AWG Columns**: Average Weighted Grade columns added after Class Standing, Project, and Examination sections
3. **Component Breakdown**: Specific sub-components like CBO, OCR, WE, and OE with their respective weights
4. **Consistent Structure**: All nine templates follow the same structural pattern for easy consumption

## Files Modified

1. `c:\xampp\htdocs\curriculumsubject\resources\views\grade_setup.blade.php`
   - Lines 650-1288: JavaScript templates configuration

2. `c:\xampp\htdocs\curriculumsubject\app\Http\Controllers\GradeController.php`
   - Lines 424-718: API endpoint method

## Testing Recommendations

1. **Frontend Testing**:
   - Load the grade setup page
   - Select each template type
   - Verify that all modality splits display correctly
   - Confirm AWG columns appear in the correct positions

2. **API Testing**:
   - Test the endpoint: `GET /api/integration/grades/templates`
   - Verify all templates are returned with complete structure
   - Validate modality percentages sum correctly
   - Confirm metadata is accurate

3. **Integration Testing**:
   - Save a grade scheme using one of the templates
   - Retrieve the saved scheme via API
   - Verify data persistence matches the template structure

## Notes

- All percentage weights are designed to sum to 100% at each level
- The templates are predefined and should serve as defaults
- Institutions can customize individual subject grades based on these templates
- F2F (Face-to-Face) and Online modalities represent the distribution of each component
