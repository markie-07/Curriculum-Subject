# Walkthrough: Syllabus Generation Checklist Preview

The previous behavior for syllabus generation was a single "Generate Full Syllabus" action that blocked the UI until all weeks were processed. We have enhanced this to be a step-by-step process with a checklist preview of which weeks are currently being generated.

## 1. Visual Checklist
When you click **"Generate Full Syllabus"**, the modal now shows a "Generation Progress" section with a list of weeks to be generated (Weeks 1-17, excluding exams and week 0).

-   **Initial State**: All weeks start with a "Pending" status (Grey Circle).
-   **Loading State**: The system processes weeks sequentially. The current week shows a **Blue Spinner**.
-   **Done State**: Upon successful generation, the week shows a **Green Checkmark**.

## 2. Updated Logic
The generation logic now iterates through each week one by one:
-   **Status Update**: We update the UI to "Loading" before calling the API for a specific week.
-   **API Call**: We call `/ajax/generate-syllabus-weeks` for that single week.
-   **Completion**: After receiving the data, we populate the fields for that week and update the status to "Done".

This provides immediate feedback and handles large generation tasks more gracefully by breaking them down.

## 3. How to Test
1.  Open `Course Builder`.
2.  Fill in the required course details (Title, Code, Description).
3.  Scroll down to the "Weekly Plan" section.
4.  Click **"Generate Full Syllabus (Weeks 1-17)"**.
5.  Watch the modal:
    -   Verify the list appears.
    -   Verify the spinner moves down the list week by week.
    -   Verify the fields are populated as each week finishes.
