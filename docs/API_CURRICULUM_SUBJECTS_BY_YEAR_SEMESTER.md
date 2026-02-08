# Curriculum Subjects by Year/Semester API Endpoint

## 📍 Endpoints

### Internal API (Session-based Authentication)
```
GET /api/curriculums/{id}/subjects-by-year-semester
```

### Integration API (API Key Authentication)
```
GET /api/integration/curriculums/{id}/subjects-by-year-semester
```

## 📝 Description
Returns subjects for a specific curriculum organized by year level and semester in a structured, easy-to-consume format.

## 🔐 Authentication

### Internal API
Requires session-based authentication (logged-in user)

### Integration API
Requires API Key authentication via header:
```
X-API-Key: csm3_api
```


## 📊 Response Structure

### For College Programs (4 years)

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
        "subjects": [
          {
            "id": 1,
            "subject_name": "Introduction to Computing",
            "subject_code": "CS101",
            "subject_type": "Major",
            "course_classification": "Professional Subject Non Laboratory",
            "subject_unit": "3",
            "contact_hours": "3",
            "course_description": "..."
          }
        ]
      },
      "semester_2": {
        "semester": 2,
        "semester_label": "2nd Semester",
        "total_units": 21,
        "subjects": [...]
      }
    },
    {
      "year": 2,
      "year_label": "2nd Year",
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
    },
    {
      "year": 3,
      "year_label": "3rd Year",
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
    },
    {
      "year": 4,
      "year_label": "4th Year",
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
  ]
}
```

### For Senior High Programs (2 years)

```json
{
  "curriculum_id": 5,
  "curriculum_name": "STEM",
  "year_level": "Senior High",
  "academic_year": "2024-2025",
  "total_units": 80,
  "structure": [
    {
      "year": 1,
      "year_label": "1st Year",
      "semester_1": {
        "semester": 1,
        "semester_label": "1st Quarter",
        "total_units": 20,
        "subjects": [...]
      },
      "semester_2": {
        "semester": 2,
        "semester_label": "2nd Quarter",
        "total_units": 20,
        "subjects": [...]
      }
    },
    {
      "year": 2,
      "year_label": "2nd Year",
      "semester_1": {
        "semester": 1,
        "semester_label": "3rd Quarter",
        "total_units": 20,
        "subjects": [...]
      },
      "semester_2": {
        "semester": 2,
        "semester_label": "4th Quarter",
        "total_units": 20,
        "subjects": [...]
      }
    }
  ]
}
```

## 📋 Usage Examples

### JavaScript (Fetch API)
```javascript
async function getCurriculumStructure(curriculumId) {
  const response = await fetch(`/api/curriculums/${curriculumId}/subjects-by-year-semester`);
  const data = await response.json();
  
  // Access 1st Year, 1st Semester subjects
  const firstYearFirstSem = data.structure[0].semester_1.subjects;
  console.log('1st Year, 1st Semester:', firstYearFirstSem);
  
  // Access 2nd Year, 2nd Semester subjects
  const secondYearSecondSem = data.structure[1].semester_2.subjects;
  console.log('2nd Year, 2nd Semester:', secondYearSecondSem);
  
  return data;
}
```

### PHP (cURL)
```php
$curriculumId = 1;
$url = "http://localhost/api/curriculums/{$curriculumId}/subjects-by-year-semester";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
]);

$response = curl_exec($ch);
$data = json_decode($response, true);

// Access 3rd Year, 1st Semester subjects
$thirdYearFirstSem = $data['structure'][2]['semester_1']['subjects'];
print_r($thirdYearFirstSem);
```

### Integration API - JavaScript (with API Key)
```javascript
async function getCurriculumStructureExternal(curriculumId) {
  const response = await fetch(
    `http://your-domain.com/api/integration/curriculums/${curriculumId}/subjects-by-year-semester`,
    {
      headers: {
        'X-API-Key': 'csm3_api',
        'Accept': 'application/json'
      }
    }
  );
  
  const data = await response.json();
  
  // Access 1st Year, 1st Semester subjects
  const firstYearFirstSem = data.structure[0].semester_1.subjects;
  console.log('1st Year, 1st Semester:', firstYearFirstSem);
  
  return data;
}
```

### Integration API - PHP (cURL with API Key)
```php
$curriculumId = 1;
$url = "http://your-domain.com/api/integration/curriculums/{$curriculumId}/subjects-by-year-semester";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-API-Key: csm3_api',
    'Accept: application/json',
]);

$response = curl_exec($ch);
$data = json_decode($response, true);

// Access all years and semesters
foreach ($data['structure'] as $yearData) {
    echo "Year: {$yearData['year_label']}\n";
    
    // Semester 1
    echo "  {$yearData['semester_1']['semester_label']}: ";
    echo count($yearData['semester_1']['subjects']) . " subjects, ";
    echo "{$yearData['semester_1']['total_units']} units\n";
    
    // Semester 2
    echo "  {$yearData['semester_2']['semester_label']}: ";
    echo count($yearData['semester_2']['subjects']) . " subjects, ";
    echo "{$yearData['semester_2']['total_units']} units\n";
}

curl_close($ch);
```

### Integration API - Python (requests)
```python
import requests

curriculum_id = 1
url = f"http://your-domain.com/api/integration/curriculums/{curriculum_id}/subjects-by-year-semester"

headers = {
    'X-API-Key': 'csm3_api',
    'Accept': 'application/json'
}

response = requests.get(url, headers=headers)
data = response.json()

# Access 1st Year, 1st Semester subjects
first_year_first_sem = data['structure'][0]['semester_1']['subjects']
print(f"1st Year, 1st Semester: {len(first_year_first_sem)} subjects")

# Print all subjects in 2nd Year, 2nd Semester
for subject in data['structure'][1]['semester_2']['subjects']:
    print(f"{subject['subject_code']} - {subject['subject_name']} ({subject['subject_unit']} units)")
```

### Integration API - C# (.NET)
```csharp
using System;
using System.Net.Http;
using System.Threading.Tasks;
using Newtonsoft.Json;

public class CurriculumService
{
    private readonly HttpClient _httpClient;
    
    public CurriculumService()
    {
        _httpClient = new HttpClient();
        _httpClient.DefaultRequestHeaders.Add("X-API-Key", "csm3_api");
        _httpClient.DefaultRequestHeaders.Add("Accept", "application/json");
    }
    
    public async Task<dynamic> GetCurriculumStructure(int curriculumId)
    {
        var url = $"http://your-domain.com/api/integration/curriculums/{curriculumId}/subjects-by-year-semester";
        var response = await _httpClient.GetStringAsync(url);
        var data = JsonConvert.DeserializeObject<dynamic>(response);
        
        // Access 1st Year, 1st Semester subjects
        var firstYearFirstSem = data.structure[0].semester_1.subjects;
        Console.WriteLine($"1st Year, 1st Semester: {firstYearFirstSem.Count} subjects");
        
        return data;
    }
}
```


## 🎯 Key Features

1. **Pre-structured Data**: No need to manually group subjects by year/semester
2. **Automatic Labels**: Year and semester labels are automatically generated
3. **Unit Totals**: Each semester includes total units calculation
4. **Curriculum Total**: Overall total units for the entire curriculum
5. **Empty Semesters**: Returns empty arrays for semesters with no subjects
6. **Flexible**: Works for both College (4 years) and Senior High (2 years) programs

## 🔍 Data Access Patterns

### Access by Year and Semester
```javascript
// 1st Year, 1st Semester
data.structure[0].semester_1.subjects

// 1st Year, 2nd Semester
data.structure[0].semester_2.subjects

// 2nd Year, 1st Semester
data.structure[1].semester_1.subjects

// 2nd Year, 2nd Semester
data.structure[1].semester_2.subjects

// 3rd Year, 1st Semester
data.structure[2].semester_1.subjects

// 3rd Year, 2nd Semester
data.structure[2].semester_2.subjects

// 4th Year, 1st Semester
data.structure[3].semester_1.subjects

// 4th Year, 2nd Semester
data.structure[3].semester_2.subjects
```

## ⚠️ Error Responses

### Curriculum Not Found (404)
```json
{
  "message": "No query results for model [App\\Models\\Curriculum] {id}"
}
```

### Server Error (500)
```json
{
  "message": "An error occurred while fetching curriculum structure.",
  "error": "Error details..."
}
```

## 📌 Notes

- Only returns subjects that have been assigned to a year and semester
- Subjects without year/semester assignment are excluded
- Subjects are ordered alphabetically by name within each semester
- Total units are calculated as floating-point numbers
- Semester labels adapt based on year_level (Quarters for Senior High, Semesters for College)
