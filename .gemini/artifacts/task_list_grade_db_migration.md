# Task List - Grading Template Database Migration

- [x] Create `GradingTemplate` model and migration (`2026_02_17_151204_create_grading_templates_table.php`).
- [x] Define schema in migration: `template_key`, `name`, `periods` (json), `components` (json).
- [x] Run database migration.
- [x] Create seeder `GradingTemplateSeeder.php` to populate DB from `config/grading_templates.php`.
- [x] Run seeder.
- [x] Update `GradeController.php` (both `setup` and `getGradingTemplates` methods) to fetch from DB via `GradingTemplate` model.
- [ ] Create basic admin management UI (optional/if requested further).
