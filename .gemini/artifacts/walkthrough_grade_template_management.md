# Walkthrough - Managing Grading Templates

## Overview
A new "Manage Templates" interface has been added to the Grade Setup page, allowing administrators to create, edit, and delete grading templates directly within the application.

## How to Access
1.  Navigate to the **Grade Setup** page for any subject.
2.  Click the **"Apply Template"** button.
3.  In the dropdown menu, select **"Manage Templates"**.

## Features

### 1. View Templates
-   The left sidebar lists all available grading templates.
-   Clicking a template loads its details into the editor on the right.

### 2. Create New Template
-   Click the **"New"** button at the top of the template list.
-   Enter a unique **Template Key** (e.g., `nursing_v3`) and a **Template Name**.
-   Define the **Period Weights** (Prelim, Midterm, Finals).
-   Add **Grade Components** (e.g., Quiz, Exam) and their sub-components (F2F/Online separation).
-   Click **"Save Template"**.

### 3. Edit Existing Template
-   Select a template from the list.
-   Modify the Name, Description, Weights, or Components.
-   **Note**: The Template Key cannot be changed once created.
-   Click **"Save Template"**. The page will refresh to apply changes.

### 4. Delete Template
-   Select a template from the list.
-   Click the **"Delete Template"** button at the bottom left.
-   Confirm the deletion in the popup.

## Technical Notes
-   **Data Source**: All templates are now stored in the database (`grading_templates` table), replacing the static configuration file.
-   **API Consistency**: Any changes made here are instantly reflected in the unexpected API endpoint used by external integrations.
