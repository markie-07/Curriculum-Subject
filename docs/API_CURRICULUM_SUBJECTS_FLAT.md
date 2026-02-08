# Curriculum Subjects Flat List API Endpoint

## 📍 Endpoint
```
GET /api/integration/curriculums/{id}/subjects-flat
```

## 📝 Description
Returns subjects for a specific curriculum as a flat list with explicit integer identifiers for year level and semester. This format is designed for easy integration and synchronization, eliminating ambiguity in hierarchical parsing.

## 🔐 Authentication
**Integration API (API Key Authentication)**
Requires API Key authentication via header:
```
X-API-Key: csm3_api
```

## 📊 Response Structure

```json
{
    "data": {
        "curriculum_id": 1,
        "course_name": "Bachelor of Science in Computer Science",
        "program_code": "BSCS",
        "academic_year": "2024-2025",
        "year_level_type": "College",
        "total_subjects": 45,
        "subjects": [
            {
                "id": 101,
                "code": "CS 101",
                "name": "Introduction to Computing",
                "year_level": 1,      // Integer: 1 = 1st Year
                "semester": 1,        // Integer: 1 = 1st Semester/Quarter
                "units": 3,
                "subject_type": "Major"
            },
            {
                "id": 102,
                "code": "MATH 1",
                "name": "Calculus I",
                "year_level": 1,
                "semester": 2,        // Integer: 2 = 2nd Semester/Quarter
                "units": 5,
                "subject_type": "Minor"
            },
            // ... all other subjects mixed in a single flat array
        ]
    }
}
```

## 📋 Usage Examples

### cURL
```bash
curl -X GET "https://csm3.jampzdev.com/api/integration/curriculums/1/subjects-flat" \
  -H "X-API-Key: csm3_api" \
  -H "Accept: application/json"
```

### JavaScript (Fetch API)
```javascript
async function getCurriculumSubjectsFlat(curriculumId) {
  const response = await fetch(
    `https://csm3.jampzdev.com/api/integration/curriculums/${curriculumId}/subjects-flat`,
    {
      headers: {
        'X-API-Key': 'csm3_api',
        'Accept': 'application/json'
      }
    }
  );
  
  const result = await response.json();
  const subjects = result.data.subjects;
  
  // Example: Filter for Year 1, Semester 2
  const y1s2Subjects = subjects.filter(
      s => s.year_level === 1 && s.semester === 2
  );
  
  console.log('Year 1 Sem 2 Subjects:', y1s2Subjects);
  return result;
}
```

### PHP (cURL)
```php
$curriculumId = 1;
$url = "https://csm3.jampzdev.com/api/integration/curriculums/{$curriculumId}/subjects-flat";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-API-Key: csm3_api',
    'Accept: application/json',
]);

$response = curl_exec($ch);
$result = json_decode($response, true);
$subjects = $result['data']['subjects'];

// Iterate through flat list
foreach ($subjects as $subject) {
    echo "{$subject['code']} - {$subject['name']} (Year {$subject['year_level']}, Sem {$subject['semester']})\n";
}

curl_close($ch);
```

## 🎯 Key Benefits

1. **Explicit Identifiers**: `year_level` and `semester` are integers attached to every subject. No ambiguity.
2. **Simplified Parsing**: A single loop processes all subjects. No nested loops required.
3. **Data Parity**: Ensures the integrating system maps subjects exactly as defined in the source.
