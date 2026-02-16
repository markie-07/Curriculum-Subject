# Walkthrough: Grading Templates API Endpoint

## What Was Created

I've successfully created a new API endpoint that exposes the grading templates from the `grade_setup.blade.php` file. This allows external systems to retrieve the predefined grading schemes used in your curriculum subject management system.

## The API Endpoint

**URL:** `GET /api/integration/grades/templates`

**Authentication:** Requires `X-API-Key: csm3_api` header

**What It Returns:** All 9 predefined grading templates with their complete structure including:
- Template name and description
- Period distribution (Prelim, Midterm, Finals)
- Grade components with weights
- Sub-components with weights

## Available Templates

The endpoint provides these 9 grading templates:

1. **General Education** (`gen_ed`) - Standard grading for general education courses
2. **Professional (Laboratory)** (`prof_lab`) - For courses with lab components
3. **Professional (Non-Laboratory)** (`prof_non_lab`) - For courses without lab
4. **Professional (Board Courses)** (`prof_board`) - For board exam preparation courses
5. **Professional (OC)** (`prof_oc`) - For courses with OC components
6. **NSTP 1** (`nstp1`) - For NSTP 1 courses
7. **NSTP 2** (`nstp2`) - For NSTP 2 courses
8. **Research** (`research`) - For research courses
9. **OJT / Practicum** (`ojt`) - For OJT and practicum courses

## How to Use It

### Example 1: PowerShell
```powershell
$response = Invoke-WebRequest -Uri "http://localhost/curriculumsubject/public/api/integration/grades/templates" `
  -Headers @{"X-API-Key"="csm3_api"; "Accept"="application/json"} `
  -Method GET

$data = $response.Content | ConvertFrom-Json
Write-Host "Total Templates: $($data.metadata.total_templates)"
```

### Example 2: JavaScript/Node.js
```javascript
const axios = require('axios');

async function getTemplates() {
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
  console.log('Total:', response.data.metadata.total_templates);
}
```

### Example 3: PHP
```php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/curriculumsubject/public/api/integration/grades/templates');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-API-Key: csm3_api',
    'Accept: application/json'
]);

$response = curl_exec($ch);
$data = json_decode($response, true);

echo "Total Templates: " . $data['metadata']['total_templates'];
curl_close($ch);
```

## Response Example

```json
{
  "success": true,
  "templates": {
    "gen_ed": {
      "name": "General Education",
      "description": "Standard grading template for general education courses",
      "periods": {
        "Prelim": 30,
        "Midterm": 30,
        "Finals": 40
      },
      "components": [
        {
          "name": "Class Standing",
          "weight": 40,
          "sub_components": [
            {"name": "Attendance", "weight": 10},
            {"name": "Written Works", "weight": 50},
            {"name": "Performance Task", "weight": 40}
          ]
        },
        {
          "name": "Project",
          "weight": 25,
          "sub_components": []
        },
        {
          "name": "Major Examination",
          "weight": 35,
          "sub_components": []
        }
      ]
    }
    // ... other templates
  },
  "metadata": {
    "total_templates": 9,
    "template_keys": ["gen_ed", "prof_lab", "prof_non_lab", ...],
    "note": "All weights are in percentages and must sum to 100%"
  }
}
```

## What Was Modified

### 1. GradeController.php
**Location:** `app/Http/Controllers/GradeController.php`

Added a new method `getGradingTemplates()` that returns all predefined grading templates. The templates are hardcoded in the controller to match exactly what's defined in the frontend JavaScript.

### 2. api.php
**Location:** `routes/api.php`

Added a new route:
```php
Route::get('/integration/grades/templates', [\App\Http\Controllers\GradeController::class, 'getGradingTemplates']);
```

This route is protected by the `integration.key` middleware, requiring the API key for access.

## How to Test

### Verify Route Registration
```bash
php artisan route:list --path=integration
```

You should see:
```
GET|HEAD  api/integration/grades/templates GradeController@getGradingTemplates
```

### Test the Endpoint
```powershell
Invoke-WebRequest -Uri "http://localhost/curriculumsubject/public/api/integration/grades/templates" `
  -Headers @{"X-API-Key"="csm3_api"} | Select-Object -ExpandProperty Content
```

## Documentation Created

I've created three documentation files in `.gemini/artifacts/`:

1. **grading_templates_api_documentation.md** - Comprehensive API documentation
2. **grading_templates_implementation_summary.md** - Implementation details and changes
3. **grading_templates_quick_reference.md** - Quick reference guide

## Key Points

✅ **Standardized:** All templates match the frontend JavaScript templates exactly
✅ **Secure:** Protected by API key authentication
✅ **Complete:** Includes all 9 templates with full component structure
✅ **Well-documented:** Comprehensive documentation provided
✅ **Easy to integrate:** Simple REST API with JSON responses

## Important Notes

1. **Weight Percentages:** All component weights must sum to 100%
2. **Period Distribution:** Prelim (30%), Midterm (30%), Finals (40%)
3. **Template Consistency:** Templates are defined in two places:
   - Backend: `GradeController.php` (for API)
   - Frontend: `grade_setup.blade.php` (for UI)
4. **Future Updates:** If templates change, update both locations

## Next Steps

1. ✅ Test the endpoint with actual API calls
2. ⏭️ Update your Postman collection (if applicable)
3. ⏭️ Notify integration partners about the new endpoint
4. ⏭️ Monitor endpoint usage and performance

## Related Endpoints

This new endpoint complements your existing integration endpoints:

- `GET /api/integration/subjects` - Get all subjects
- `GET /api/integration/curriculums/approved` - Get approved curriculums
- `GET /api/integration/curriculums/{id}/subjects-flat` - Get curriculum subjects

Now you have a complete API for managing curriculum subjects AND their grading templates! 🎉
