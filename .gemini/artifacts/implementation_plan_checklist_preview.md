# Implementation Plan - Syllabus Generation Checklist Preview

The goal is to provide a real-time progress preview (checklist) when generating the syllabus for Weeks 1-17, showing which weeks are done (Check Symbol) and which are currently being generated (Loading Symbol).

## 1. Modify `aiAnalysisLoadingModal` HTML
- **Location**: `resources/views/course_builder.blade.php` (Inside the `aiAnalysisLoadingModal` div).
- **Change**: Added a hidden container (`#generationChecklist`) with a header and a list container (`#generationChecklistItems`) for displaying week statuses.

## 2. Update `window.generateSyllabusRange` Javascript Function
- **Location**: `resources/views/course_builder.blade.php` (Script section).
- **Change**: Refactored the function from a single batch request to a sequential loop.
- **Why**: To enable per-week UI updates.
- **Process**:
    1.  Calculates the target weeks (skipping 0, 6, 12, 18).
    2.  Initializes the checklist UI with "Pending" (Grey Circle) status for all target weeks.
    3.  Iterates through each week sequentially:
        -   Updates the status icon to "Loading" (Blue Spinner).
        -   Scrolls the checklist to keep the active item in view.
        -   Calls the API (`/ajax/generate-syllabus-weeks`) for that single week.
        -   Populates the week's fields with the returned data.
        -   Updates the status icon to "Done" (Green Checkmark).
        -   Updates the progress bar for that week.
    4.  Handles errors per week (showing Red X) and stops execution to prevent cascading failures.
    5.  Hides the modal and checklist upon completion.

## 3. UI/UX Consderations
-   **Visual Feedback**: Uses clear icons (Spinners for loading, Checkmarks for done) to indicate progress.
-   **Sequential Processing**: Ensures that the user sees steady progress, even if overall time is longer than a batch request (due to multiple round-trips), providing a better perceived performance.
-   **Auto-Scroll**: Keeps the currently processing item visible in the checklist.

## 4. Testing
-   Click "Generate Full Syllabus (Weeks 1-17)".
-   Verify the modal appears with the checklist.
-   Verify weeks 0, 6, 12, 18 are skipped.
-   Verify the spinner appears for the current week and changes to a checkmark upon completion.
-   Verify fields are populated correctly.
