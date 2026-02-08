# 🎯 Quick Reference: Curriculum Subjects by Year/Semester API

## 📍 API Endpoints

### For Integration (External Systems)
```
GET /api/integration/curriculums/{id}/subjects-by-year-semester  (Hierarchical)
GET /api/integration/curriculums/{id}/subjects-flat              (Flat List)
```
**Authentication:** API Key Header
```
X-API-Key: csm3_api
```

### For Internal Use
```
GET /api/curriculums/{id}/subjects-by-year-semester
```
**Authentication:** Session-based (logged-in user)

---

## 🚀 Quick Start

### Example Request (cURL)
```bash
curl -X GET "http://your-domain.com/api/integration/curriculums/1/subjects-by-year-semester" \
  -H "X-API-Key: csm3_api" \
  -H "Accept: application/json"
```

### Example Request (JavaScript)
```javascript
fetch('http://your-domain.com/api/integration/curriculums/1/subjects-by-year-semester', {
  headers: {
    'X-API-Key': 'csm3_api',
    'Accept': 'application/json'
  }
})
.then(response => response.json())
.then(data => console.log(data));
```

---

## 📊 Response Structure

```json
{
  "curriculum_id": 1,
  "curriculum_name": "BSCS",
  "year_level": "College",
  "academic_year": "2024-2025",
  "total_units": 168,
  "structure": [
    {
      "year": 1,
      "year_label": "1st Year",
      "semester_1": {
        "semester": 1,
        "semester_label": "1st Semester",
        "total_units": 21,
        "subjects": [...]
      },
      "semester_2": {
        "semester": 2,
        "semester_label": "2nd Semester",
        "total_units": 21,
        "subjects": [...]
      }
    }
    // ... continues for years 2, 3, 4
  ]
}
```

---

## 🔍 Accessing Specific Year/Semester

| Year/Semester | Access Path |
|--------------|-------------|
| **1st Year, 1st Semester** | `data.structure[0].semester_1.subjects` |
| **1st Year, 2nd Semester** | `data.structure[0].semester_2.subjects` |
| **2nd Year, 1st Semester** | `data.structure[1].semester_1.subjects` |
| **2nd Year, 2nd Semester** | `data.structure[1].semester_2.subjects` |
| **3rd Year, 1st Semester** | `data.structure[2].semester_1.subjects` |
| **3rd Year, 2nd Semester** | `data.structure[2].semester_2.subjects` |
| **4th Year, 1st Semester** | `data.structure[3].semester_1.subjects` |
| **4th Year, 2nd Semester** | `data.structure[3].semester_2.subjects` |

---

## 📦 Subject Object Fields

Each subject contains:
- `id` - Subject ID
- `subject_name` - Full subject name
- `subject_code` - Subject code
- `subject_type` - Type (Major, Minor, etc.)
- `course_classification` - Classification
- `subject_unit` - Credit units
- `contact_hours` - Contact hours
- `course_description` - Description

---

## 💡 Common Use Cases

### Get all subjects for 1st Year
```javascript
const firstYear = data.structure[0];
const allFirstYearSubjects = [
  ...firstYear.semester_1.subjects,
  ...firstYear.semester_2.subjects
];
```

### Calculate total units for a specific year
```javascript
const secondYear = data.structure[1];
const totalUnits = secondYear.semester_1.total_units + 
                   secondYear.semester_2.total_units;
```

### Loop through all years and semesters
```javascript
data.structure.forEach(year => {
  console.log(`${year.year_label}:`);
  console.log(`  ${year.semester_1.semester_label}: ${year.semester_1.subjects.length} subjects`);
  console.log(`  ${year.semester_2.semester_label}: ${year.semester_2.subjects.length} subjects`);
});
```

---

## ⚠️ Important Notes

✅ Only returns subjects assigned to a year/semester  
✅ Empty semesters return empty arrays  
✅ Works for both College (4 years) and Senior High (2 years)  
✅ Semester labels auto-adjust (Semesters vs Quarters)  
✅ All units are calculated automatically  

---

## 📚 Full Documentation

For complete documentation with all examples, see:
`docs/API_CURRICULUM_SUBJECTS_BY_YEAR_SEMESTER.md`
