# Task List

- [x] Read `resources/views/course_builder.blade.php` to understand existing syllabus generation logic.
- [x] Modify the "AI Analysis Loading Modal" HTML to include a hidden container for the generation checklist.
- [x] Rewrite `window.generateSyllabusRange` function in JavaScript to:
    -   Initialize the checklist in the modal with "Pending" status.
    -   Iterate through weeks sequentially instead of a batch request.
    -   Update the UI (Checklist and Loading Text) for each week as it processes.
    -   Skip weeks 0, 6, 12, and 18 as requested.
- [x] Improve the UI aesthetics of the "AI Analysis Loading Modal".
    -   Widen the modal (`max-w-3xl`).
    -   Change the checklist to a 2-column grid.
    -   Use card-like styling for each week item with dynamic states (Pending, Generating, Completed).
    -   Add progress bar and smooth transitions.
- [x] Expand Weekly Plan Layout.
    -   Make "Content" and "Student Intended Learning Outcomes" textareas full width (`w-full`) and increase height (`rows="6"`).
    -   Make "Assessment Tasks" and "Teaching/Learning Activities" sections stack vertically for better readability.
    -   Increase heights of internal textareas (`rows="4"`).
    -   Make "Learning and Teaching Support Materials" and "Output Materials" full width and taller (`rows="5"`).
