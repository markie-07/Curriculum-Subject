# Task List: Database-Driven Grading Templates

## 1. Database Setup
- [x] Create migration for `grading_templates` table.
- [x] Create `GradingTemplate` model.
- [x] Create `GradingTemplateSeeder` with initial F2F/Online template data.
- [x] Run migration and seeder to populate the database.

## 2. Backend Implementation
- [x] Update `GradeController::getGradingTemplates` to fetch data from the `grading_templates` table instead of hardcoded array.
- [x] Create `GradingTemplateController` to handle CRUD operations for templates.
  - [x] `index()`: Return the management view.
  - [x] `list()`: Return all templates as JSON for internal frontend use.
  - [x] `update()`: Update template configuration.
  - [x] `show()`: return single template JSON.

## 3. Frontend Implementation
- [x] Create `resources/views/grading_templates/index.blade.php` as the management interface.
  - [x] List all templates.
  - [x] Modal for editing template periods and components.
  - [x] JavaScript logic to save changes to the backend.
- [x] Update `resources/views/grade_setup.blade.php`.
  - [x] Remove hardcoded `templates` object.
  - [x] Implement `loadGradingTemplates()` function to fetch templates from the new internal API endpoint.
  - [x] Add "Manage Templates" button to link to the management page.

## 4. Route Configuration
- [x] Register routes for `GradingTemplateController` in `routes/web.php`.
  - [x] `GET /grading-templates/list`
  - [x] `GET /grading-templates`
  - [x] `PUT /grading-templates/{id}`
