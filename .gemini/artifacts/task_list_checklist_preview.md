# Task List

- [x] Read `resources/views/course_builder.blade.php` to understand existing syllabus generation logic.
- [x] Modify the "AI Analysis Loading Modal" HTML to include a hidden container for the generation checklist.
- [x] Rewrite `window.generateSyllabusRange` function in JavaScript to:
    -   Initialize the checklist in the modal with "Pending" status.
    -   Iterate through weeks sequentially instead of a batch request.
    -   Update the UI (Checklist and Loading Text) for each week as it processes.
    -   Skip weeks 0, 6, 12, and 18 as requested.
