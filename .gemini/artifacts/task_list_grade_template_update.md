# Task List

- [x] Analyze `resources/views/grade_setup.blade.php` to locate the grading templates configuration.
- [x] Identify the specific templates that need updating based on the provided screenshots (`gen_ed`, `prof_lab`, `prof_non_lab`, `prof_board`, `prof_oc`).
- [x] Update the `templates` object in the JavaScript code to split "Class Standing" components:
    - [x] Split "Attendance" into "Attendance (F2F)" and "Attendance (Online)" with weights 7% and 3%.
    - [x] Split "Written Works" into "Written Works (F2F)" and "Written Works (Online)" with weights matching the specific template (e.g., 33%/17% for Gen Ed, 27%/13% for Prof Subjects).
    - [x] Split "Performance Task" into "Performance Task (F2F)" and "Performance Task (Online)" with weights matching the specific template (e.g., 27%/13% for Gen Ed, 33%/17% for Prof Subjects).
- [x] Verify that the sum of weights remains 100% for the "Class Standing" component to ensure validation passes.
