# Implementation Plan - Grading Template Centralization

This plan details the centralization of grading templates into a single configuration file to ensure consistency between the Frontend UI and the API.

## Problem
The grading templates were previously hardcoded in two separate locations:
1.  Frontend: `resources/views/grade_setup.blade.php` (JavaScript object)
2.  Backend API: `app/Http/Controllers/GradeController.php` (PHP Array)

This duplication posed a risk where changes in one place might not be reflected in the other, leading to inconsistencies for integration partners.

## Solution
We have centralized the template definitions into a new Laravel configuration file: `config/grading_templates.php`.

## Architectural Changes

### 1. New Configuration File
-   **File**: `config/grading_templates.php`
-   **Content**: Contains the master definition of all grading templates (Gen Ed, Prof Lab, NSTP, etc.) with the new Face-to-Face (F2F) and Online sub-component breakdowns.

### 2. Backend API (`GradeController.php`)
-   **Method**: `getGradingTemplates()`
-   **Change**: Instead of defining the array manually, it now returns `config('grading_templates')`.
-   **Benefit**: Any change to the config file is immediately reflected in the API response.

### 3. Frontend Controller (`GradeController.php`)
-   **Method**: `setup()`
-   **Change**: The method now retrieves the templates via `config('grading_templates')` and passes them to the `grade_setup` view.

### 4. Frontend View (`grade_setup.blade.php`)
-   **Change**: Removed the hardcoded `const templates = { ... };` JavaScript object.
-   **New Implementation**: `const templates = @json($grading_templates ?? []);`
-   **Benefit**: The frontend now uses the exact same data structure as the API, guaranteeing 100% consistency.

## Verification
-   **Frontend**: Loading the Grade Setup page will render templates exactly as defined in the config file.
-   **API**: Calling `/api/integration/grades/templates` will return the exact same JSON structure.
