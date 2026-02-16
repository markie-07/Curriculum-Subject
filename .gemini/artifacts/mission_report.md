# Mission Report: Course Builder Enhancements

## Task List
- [x] Read `resources/views/course_builder.blade.php` to understand existing syllabus generation logic.
- [x] Modify `aiAnalysisLoadingModal` to include a hidden container for the generation checklist.
- [x] Rewrite `window.generateSyllabusRange` function in JavaScript to:
    -   Initialize the checklist in the modal with "Pending" status.
    -   Iterate through weeks sequentially instead of a batch request.
    -   Update the UI (Checklist and Loading Text) for each week as it processes.
    -   Skip weeks 0, 6, 12, and 18 as requested.
- [x] Improve the UI aesthetics of the "AI Analysis Loading Modal".
    -   Widen the modal (`max-w-4xl`).
    -   Change the checklist to a 2/3-column grid (`lg:grid-cols-3`).
    -   Use card-like styling for each week item with dynamic states (Pending, Generating, Completed).
    -   Add progress bar and smooth transitions.

## Implementation Plan

The goal is to provide a real-time progress preview (checklist) when generating the syllabus for Weeks 1-17, showing which weeks are done (Check Symbol) and which are currently being generated (Loading Symbol).

### 1. Modify `aiAnalysisLoadingModal` HTML
- **Location**: `resources/views/course_builder.blade.php` (Inside the `aiAnalysisLoadingModal` div).
- **Change**: Added a larger container (`max-w-4xl`) with a decorative header and a grid container (`#generationChecklistItems`) for displaying week statuses.

### 2. Update `window.generateSyllabusRange` Javascript Function
- **Location**: `resources/views/course_builder.blade.php` (Script section).
- **Change**: Refactored the function from a single batch request to a sequential loop.
- **Why**: To enable per-week UI updates.
- **Process**:
    1.  Calculates the target weeks (skipping 0, 6, 12, 18).
    2.  Initializes the checklist UI with "Pending" (Grey Icon) cards for all target weeks in a 2/3-column grid.
    3.  Iterates through each week sequentially:
        -   Updates the card style to "Loading" (Blue Border, Spinner, Active Animation).
        -   Scrolls the checklist to keep the active item in view.
        -   Calls the API (`/ajax/generate-syllabus-weeks`) for that single week.
        -   Populates the week's fields with the returned data.
        -   Updates the card style to "Done" (Green Border, Checkmark, Progress Bar Full).
        -   Updates the progress bar for that week.
    4.  Handles errors per week (showing Red Card) and stops execution to prevent cascading failures.
    5.  Hides the modal and checklist upon completion.

## Walkthrough

The behavior for syllabus generation now includes an enhanced "Generation Progress" modal. This replaces the previous single loading spinner with a detailed checklist of weeks being generated.

### 1. Visual Checklist
When you click **"Generate Full Syllabus"**, the modal now opens a wide window (`max-w-4xl`) with a 2-to-3 column grid (responsive) of "Week Cards".

-   **Initial State**: All weeks start with a "Pending" status (Grey Card).
-   **Loading State**: The system processes weeks sequentially. The current week card highlights in **Blue**, shows a **loading spinner**, and displays a "Generating..." badge.
-   **Done State**: Upon successful generation, the week card turns **Green**, shows a **checkmark**, and displays a "Completed" badge.
-   **Structure**: Weeks 0, 6, 12, and 18 are excluded from the generation list.

### 2. How to Test
1.  Open `Course Builder`.
2.  Fill in the required course details (Title, Code, Description).
3.  Scroll down to the "Weekly Plan" section.
4.  Click **"Generate Full Syllabus (Weeks 1-17)"**.
5.  Watch the modal:
    -   Verify the list appears in a 3-column grid (on large screens).
    -   Verify the active card turns blue with a spinner.
    -   Verify the completed cards turn green with a checkmark.
    -   Verify the smooth scroll keeps the active card in view.
