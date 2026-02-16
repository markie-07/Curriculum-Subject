# Quick Reference: Grading Templates API

## Endpoint
```
GET /api/integration/grades/templates
```

## Authentication
```
X-API-Key: csm3_api
```

## Template Keys

| Key | Name | Description |
|-----|------|-------------|
| `gen_ed` | General Education | Standard grading for general education courses |
| `prof_lab` | Professional (Laboratory) | Professional courses with lab component |
| `prof_non_lab` | Professional (Non-Laboratory) | Professional courses without lab |
| `prof_board` | Professional (Board Courses) | Board examination courses |
| `prof_oc` | Professional (OC) | Professional courses with OC component |
| `nstp1` | NSTP 1 | NSTP 1 courses |
| `nstp2` | NSTP 2 | NSTP 2 courses |
| `research` | Research | Research courses |
| `ojt` | OJT / Practicum | OJT and practicum courses |

## Quick Test (PowerShell)
```powershell
Invoke-WebRequest -Uri "http://localhost/curriculumsubject/public/api/integration/grades/templates" -Headers @{"X-API-Key"="csm3_api"} | Select-Object -ExpandProperty Content | ConvertFrom-Json
```

## Response Format
```json
{
  "success": true,
  "templates": { ... },
  "metadata": {
    "total_templates": 9,
    "template_keys": [...],
    "note": "All weights are in percentages and must sum to 100%"
  }
}
```

## Component Structure
- **Periods:** Prelim (30%), Midterm (30%), Finals (40%)
- **Components:** Main grading categories (e.g., Class Standing, Project, Examination)
- **Sub-components:** Breakdown of components (e.g., Attendance, Written Works, Performance Task)

## Weight Rules
- All component weights must sum to 100%
- All sub-component weights must sum to 100%
- Weights are in percentages

## Files Modified
1. `app/Http/Controllers/GradeController.php` - Added `getGradingTemplates()` method
2. `routes/api.php` - Added route for grading templates

## Location in Codebase
- **Controller:** `app/Http/Controllers/GradeController.php` (line ~424)
- **Route:** `routes/api.php` (line ~44)
- **Source Template:** `resources/views/grade_setup.blade.php` (line ~651-890)
