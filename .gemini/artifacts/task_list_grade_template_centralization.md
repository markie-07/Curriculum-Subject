# Task List - Grading Template Centralization

- [x] Create centralized configuration file `config/grading_templates.php`.
- [x] Migrate all grading template definitions (with F2F/Online split) from `GradeController` to `config/grading_templates.php`.
- [x] Refactor `GradeController::getGradingTemplates` API to return data from `config('grading_templates')`.
- [x] Refactor `GradeController::setup` to pass `grading_templates` to the `grade_setup` view.
- [x] Refactor `resources/views/grade_setup.blade.php` to use the passed `grading_templates` variable instead of hardcoded JavaScript.
- [x] Verify no hardcoded templates remain in the frontend code.
