# Implementation Plan: Database-Driven Grading Templates

## 1. Goal
Transition grading templates from a hardcoded array in the controller/view to a database-driven implementation (`grading_templates` table) with a frontend management interface.

## 2. Technical Stack
- **Backend**: Laravel (PHP)
  - **Migration**: `grading_templates` table (id, code, name, description, periods (JSON), components (JSON), is_active).
  - **Model**: `GradingTemplate`
  - **Seeder**: `GradingTemplateSeeder`
  - **Controller**: `GradingTemplateController` (CRUD) & Updated `GradeController` (API).
- **Frontend**: Blade + JavaScript (Vanilla/Fetch API)
  - **Management View**: `resources/views/grading_templates/index.blade.php` - A table listing all templates with an edit modal.
  - **Grade Setup View**: `resources/views/grade_setup.blade.php` - Updated to fetch templates dynamically and link to the management page.

## 3. Database Schema
```sql
CREATE TABLE grading_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    periods JSON NOT NULL, -- Stores { "Prelim": 30, "Midterm": 30, "Finals": 40 }
    components JSON NOT NULL, -- Stores array of component objects with sub-components
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## 4. API Endpoints
- **GET /grading-templates/list**
  - Returns: JSON array of all active templates.
  - Used by: `grade_setup.blade.php` frontend.
- **GET /grading-templates**
  - Returns: HTML view (`grading_templates.index`).
- **GET /grading-templates/{id}**
  - Returns: JSON object of a single template.
  - Used by: Edit modal in management view.
- **PUT /grading-templates/{id}**
  - Payload: `{ name, description, periods, components }`
  - Logic: Updates the template configuration.

## 5. View Logic
- **resources/views/grading_templates/index.blade.php**:
  - Displays cards for each template.
  - "Edit Configuration" button opens a modal.
  - Modal loads template data via AJAX.
  - Inputs for Periods (weights) and Components (weights/names).
  - Save button sends PUT request.
- **resources/views/grade_setup.blade.php**:
  - Replaced `const templates = { ... }` with `loadGradingTemplates()` function.
  - Fetches from `/grading-templates/list`.
  - Added "Manage Templates" button near the template dropdown to navigate to the new management page.

## 6. Migration & Seeding
- Created `2026_02_17_151204_create_grading_templates_table` migration.
- Created `GradingTemplateSeeder` populated with the existing F2F/Online split templates.
- Executed migration and seeder to initialize the database.
