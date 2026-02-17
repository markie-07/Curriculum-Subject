# Implementation Plan - Grading Template Database Migration

This plan details the migration of grading templates from a static configuration file to a dynamic database-driven system.

## Objective
To allow users (administrators) to edit grading templates directly within the application, ensuring that changes are immediately reflected in both the frontend UI and the external API integration without modifying code.

## Architectural Changes

### 1. Database Schema
-   **Table**: `grading_templates`
-   **Columns**:
    -   `id` (PK)
    -   `template_key` (string, unique) - e.g., 'gen_ed'
    -   `name` (string) - e.g., 'General Education'
    -   `description` (text, nullable)
    -   `periods` (json) - Stores Prelim/Midterm/Finals weights
    -   `components` (json) - Stores the full component structure with F2F/Online breakdown
    -   `is_active` (boolean) - To soft-disable templates if needed

### 2. Eloquent Model (`GradingTemplate`)
-   Includes `$fillable` for mass assignment.
-   Includes `$casts` to automatically convert `periods` and `components` JSON columns to PHP arrays.
-   Includes a helper method `getActiveTemplates()` to format data for the frontend/API (matching the old config structure).

### 3. Data Migration (Seeding)
-   Created `GradingTemplateSeeder` to read the existing `config/grading_templates.php` and insert/update records in the database.
-   This ensures a seamless transition with no data loss.

### 4. Controller Logic (`GradeController`)
-   **`setup()`**: Now calls `GradingTemplate::getActiveTemplates()` to pass data to the view.
-   **`getGradingTemplates()`**: Now calls `GradingTemplate::getActiveTemplates()` to return the JSON API response.
-   **Fallback**: Included a safety check to fall back to the config file if the database returns empty results (e.g., if migration failed or wasn't run).

## Benefits
-   **Dynamic Updates**: Templates can be edited via SQL or a future Admin UI.
-   **Zero Code Changes**: Changing a weight or name no longer requires a deployment or code push.
-   **Consistency**: The single source of truth is now the Database.
