# Implementation Plan - Syllabus Generation Checklist Preview & Layout Expansion

The goal is to provide a real-time progress preview (checklist) when generating the syllabus for Weeks 1-17, and significantly improve the readability of the weekly plan fields by expanding their layout.

## 1. Modify `aiAnalysisLoadingModal` HTML
- **Location**: `resources/views/course_builder.blade.php` (Inside the `aiAnalysisLoadingModal` div).
- **Change**: Added a larger container (`max-w-3xl`) with a decorative header and a grid container (`#generationChecklistItems`) for displaying week statuses.

## 2. Update `window.generateSyllabusRange` Javascript Function
- **Location**: `resources/views/course_builder.blade.php` (Script section).
- **Change**: Refactored the function from a single batch request to a sequential loop.
- **Why**: To enable per-week UI updates.
- **Process**:
    1.  Calculates the target weeks (skipping 0, 6, 12, 18).
    2.  Initializes the checklist UI with "Pending" (Grey Icon) cards for all target weeks in a 2-column grid.
    3.  Iterates through each week sequentially:
        -   Updates the card style to "Loading" (Blue Border, Spinner, Active Animation).
        -   Scrolls the checklist to keep the active item in view.
        -   Calls the API (`/ajax/generate-syllabus-weeks`) for that single week.
        -   Populates the week's fields with the returned data.
        -   Updates the card style to "Done" (Green Border, Checkmark, Progress Bar Full).
        -   Updates the progress bar for that week.
    4.  Handles errors per week (showing Red Card) and stops execution to prevent cascading failures.
    5.  Hides the modal and checklist upon completion.

## 3. Weekly Plan Layout Expansion
- **Location**: `resources/views/course_builder.blade.php` (Inside the weekly loop).
- **Goal**: Address user feedback that text fields are too small/cramped.
- **Changes**:
    -   **Content & SILO**: Changed from `md:grid-cols-2` (half-width) to stacked single columns. Increased `rows` to 6.
    -   **Assessment Tasks (ATs)**: Changed to a single vertical stack. Increased internal textarea `rows` to 4.
    -   **Teaching/Learning Activities (TLAs)**: Changed to a single vertical stack. Increased internal textarea `rows` to 4.
    -   **LTSM & Output**: Changed from `md:grid-cols-2` to stacked single columns. Increased `rows` to 5.
    -   **Styling**: Added bold labels and focus states (`focus:ring-blue-500`) to improve usability.

## 4. Testing
-   Click "Generate Full Syllabus (Weeks 1-17)".
-   Verify the modal appears with the wider layout.
-   Verify the spinner appears for the current week and changes to a checkmark upon completion.
-   Verify the weekly plan accordion now displays full-width textareas for all main fields, making the content much easier to read.
