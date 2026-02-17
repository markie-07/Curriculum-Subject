# Task List - Grading Template Management UI

- [x] Create `GradingTemplate` model, migration, seeder.
- [x] Migrate `config/grading_templates.php` to database.
- [x] Update `GradeController` and `GradingTemplate` model to serve templates with IDs.
- [x] Add CRUD methods (`storeTemplate`, `updateTemplate`, `deleteTemplate`) to `GradeController`.
- [x] Register routes for grading template management in `web.php`.
- [x] Add "Manage Templates" button to `grade_setup.blade.php`.
- [x] Implement "Manage Templates" Modal in `grade_setup.blade.php`.
- [x] Add JavaScript logic for Listing, Creating, Editing, and Deleting templates.
- [x] Ensure deleted/updated templates refresh the UI (via page reload).
