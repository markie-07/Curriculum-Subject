# Grading Templates API Endpoint

## Overview
This document describes the new API endpoint for retrieving grading templates used in the curriculum subject management system.

## Endpoint Details

### Get All Grading Templates
**Endpoint:** `GET /api/integration/grades/templates`

**Authentication:** Requires API Key (`X-API-Key: csm3_api`)

**Description:** Returns all predefined grading templates used in the system. These templates define the grading structure for different types of courses.

### Request Example
```bash
curl -X GET "http://localhost/curriculumsubject/public/api/integration/grades/templates" \
  -H "X-API-Key: csm3_api" \
  -H "Accept: application/json"
```

### Response Structure
```json
{
  "success": true,
  "templates": {
    "gen_ed": { ... },
    "prof_lab": { ... },
    "prof_non_lab": { ... },
    "prof_board": { ... },
    "prof_oc": { ... },
    "nstp1": { ... },
    "nstp2": { ... },
    "research": { ... },
    "ojt": { ... }
  },
  "metadata": {
    "total_templates": 9,
    "template_keys": ["gen_ed", "prof_lab", "prof_non_lab", "prof_board", "prof_oc", "nstp1", "nstp2", "research", "ojt"],
    "note": "All weights are in percentages and must sum to 100%"
  }
}
```

## Available Templates

### 1. General Education (`gen_ed`)
- **Name:** General Education
- **Description:** Standard grading template for general education courses
- **Periods:** Prelim (30%), Midterm (30%), Finals (40%)
- **Components:**
  - Class Standing (40%)
    - Attendance (10%)
    - Written Works (50%)
    - Performance Task (40%)
  - Project (25%)
  - Major Examination (35%)

### 2. Professional (Laboratory) (`prof_lab`)
- **Name:** Professional (Laboratory)
- **Description:** Grading template for professional courses with laboratory component
- **Periods:** Prelim (30%), Midterm (30%), Finals (40%)
- **Components:**
  - Class Standing (35%)
    - Attendance (10%)
    - Written Works (40%)
    - Performance Task (50%)
  - Project (40%)
  - Major Examination (25%)

### 3. Professional (Non-Laboratory) (`prof_non_lab`)
- **Name:** Professional (Non-Laboratory)
- **Description:** Grading template for professional courses without laboratory component
- **Periods:** Prelim (30%), Midterm (30%), Finals (40%)
- **Components:**
  - Class Standing (35%)
    - Attendance (10%)
    - Written Works (40%)
    - Performance Task (50%)
  - Project (40%)
  - Major Examination (25%)

### 4. Professional (Board Courses) (`prof_board`)
- **Name:** Professional (Board Courses)
- **Description:** Grading template for board examination courses
- **Periods:** Prelim (30%), Midterm (30%), Finals (40%)
- **Components:**
  - Class Standing (40%)
    - Attendance (10%)
    - Written Works (40%)
    - Performance Task (50%)
  - Project (30%)
  - Major Examination (30%)

### 5. Professional (OC) (`prof_oc`)
- **Name:** Professional (OC)
- **Description:** Grading template for professional courses with OC component
- **Periods:** Prelim (30%), Midterm (30%), Finals (40%)
- **Components:**
  - Class Standing (40%)
    - Attendance (10%)
    - Written Works (40%)
    - Performance Task (50%)
  - Project (35%)
    - CBO (40%)
    - OCR (60%)
  - Examination (25%)

### 6. NSTP 1 (`nstp1`)
- **Name:** NSTP 1
- **Description:** Grading template for NSTP 1 courses
- **Periods:** Prelim (30%), Midterm (30%), Finals (40%)
- **Components:**
  - Class Standing (40%)
    - Attendance (10%)
    - Written Works (50%)
    - Performance Task (40%)
  - Project (30%)
  - Examination (30%)

### 7. NSTP 2 (`nstp2`)
- **Name:** NSTP 2
- **Description:** Grading template for NSTP 2 courses
- **Periods:** Prelim (30%), Midterm (30%), Finals (40%)
- **Components:**
  - Class Standing (30%)
    - Attendance (10%)
    - Written Works (35%)
    - Performance Task (55%)
  - Project (40%)
  - Examination (30%)

### 8. Research (`research`)
- **Name:** Research
- **Description:** Grading template for research courses
- **Periods:** Prelim (30%), Midterm (30%), Finals (40%)
- **Components:**
  - Class Standing (25%)
    - Attendance (10%)
    - Written Works (45%)
    - Performance Task (45%)
  - Project (40%)
  - Examination (35%)
    - Written Exam (20%)
    - Oral Exam (80%)

### 9. OJT / Practicum (`ojt`)
- **Name:** OJT / Practicum
- **Description:** Grading template for OJT and practicum courses
- **Periods:** Prelim (30%), Midterm (30%), Finals (40%)
- **Components:**
  - Class Standing (50%)
    - Attendance (30%)
    - Written Works (40%)
    - Performance Task (30%)
  - Project (35%)
  - Examination (15%)

## Template Structure

Each template object contains:

```json
{
  "name": "Template Display Name",
  "description": "Template description",
  "periods": {
    "Prelim": 30,
    "Midterm": 30,
    "Finals": 40
  },
  "components": [
    {
      "name": "Component Name",
      "weight": 40,
      "sub_components": [
        {
          "name": "Sub-component Name",
          "weight": 10
        }
      ]
    }
  ]
}
```

## Important Notes

1. **Weight Percentages:** All weights are in percentages and must sum to 100%
2. **Periods:** The periods (Prelim, Midterm, Finals) represent the distribution of the semestral grade
3. **Components:** Main grading components (e.g., Class Standing, Project, Examination)
4. **Sub-components:** Breakdown of main components (e.g., Attendance, Written Works)
5. **API Key:** All requests must include the `X-API-Key: csm3_api` header

## Integration Example

```javascript
// JavaScript/Node.js example
const axios = require('axios');

async function getGradingTemplates() {
  try {
    const response = await axios.get(
      'http://localhost/curriculumsubject/public/api/integration/grades/templates',
      {
        headers: {
          'X-API-Key': 'csm3_api',
          'Accept': 'application/json'
        }
      }
    );
    
    console.log('Templates:', response.data.templates);
    console.log('Metadata:', response.data.metadata);
    
    return response.data;
  } catch (error) {
    console.error('Error fetching templates:', error.message);
  }
}

getGradingTemplates();
```

## Related Endpoints

- `GET /api/integration/subjects` - Get all subjects
- `GET /api/integration/curriculums/approved` - Get approved curriculums
- `GET /api/integration/curriculums/{id}/subjects-flat` - Get curriculum subjects
- `GET /api/integration/grades/{subjectId}` - Get grade setup for a specific subject (web route)

## Version History

- **v1.0** (2026-02-12): Initial release of grading templates API endpoint
