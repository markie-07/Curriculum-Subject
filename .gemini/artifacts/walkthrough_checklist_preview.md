# Walkthrough: Syllabus Generation Checklist Preview & Expanded Weekly Layout

The behavior for syllabus generation now includes an enhanced "Generation Progress" modal, and the weekly plan layout has been significantly expanded to improve text visibility.

## 1. Visual Checklist
When you click **"Generate Full Syllabus"**, the modal now opens a wide window (`max-w-3xl`) with a 2-column grid of "Week Cards".

-   **Initial State**: All weeks start with a "Pending" status (Grey Card).
-   **Loading State**: The system processes weeks sequentially. The current week card highlights in **Blue**, shows a **loading spinner**, and displays a "Generating..." badge.
-   **Done State**: Upon successful generation, the week card turns **Green**, shows a **checkmark**, and displays a "Completed" badge.
-   **Structure**: Weeks 0, 6, 12, and 18 are excluded from the generation list.

## 2. Updated Logic
The generation logic now iterates through each week one by one:
-   **Status Update**: We update the UI to "Loading" before calling the API for a specific week.
-   **API Call**: We call `/ajax/generate-syllabus-weeks` for that single week.
-   **Completion**: After receiving the data, we populate the fields for that week and update the status to "Done".

This provides immediate feedback and handles large generation tasks more gracefully by breaking them down.

## 3. Expanded Weekly Plan Layout
The user requested better visibility for the text fields. We have expanded the weekly plan layout:
-    **Content**: Now uses the full width of the container. Rows increased to 6.
-   **Student Intended Learning Outcomes (SILO)**: Now uses the full width of the container. Rows increased to 6.
-   **Assessment Tasks (ATs)**: ONSITE and OFFSITE are stacked vertically, providing ample space for text. Rows increased to 4.
-   **Teaching/Learning Activities (TLAs)**: ONSITE and OFFSITE are stacked vertically, providing ample space for text. Rows increased to 4.
-   **Resource Materials (LTSM)**: Now uses the full width of the container. Rows increased to 5.
-   **Output Materials**: Now uses the full width of the container. Rows increased to 5.

## 4. How to Test
1.  Open `Course Builder`.
2.  Fill in the required course details (Title, Code, Description).
3.  Scroll down to the "Weekly Plan" section.
4.  Click **"Generate Full Syllabus (Weeks 1-17)"**.
5.  Watch the modal:
    -   Verify the list appears in a 2-column grid.
    -   Verify the active card turns blue with a spinner.
    -   Verify the completed cards turn green with a checkmark.
    -   Verify the smooth scroll keeps the active card in view.
6.  Once generation is complete, click on a Week accordion (e.g., Week 1).
    -   Verify that all text areas (`Content`, `SILO`, `LTSM`) now span the full width of the card and are taller, making the content much easier to read.
