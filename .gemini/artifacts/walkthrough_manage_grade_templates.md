# Walkthrough: Manage and Verify Grading Templates

## Overview
This walkthrough shows how to manage the newly centralized grading templates and verify that the changes are reflected in the Grade Setup module.

## 1. Access the Template Manager
1. Go to the **Grade Setup** page (`/grade-setup`).
2. Look for the new **"Manage Templates"** button next to the "Template" selection dropdown.
3. Click it to navigate to the **Grading Templates Manager** (`/grading-templates`).

## 2. Edit a Template (e.g., General Education)
1. In the Template Manager, locate the **"General Education"** card.
2. Click the **"Edit Configuration"** button.
3. A modal will appear showing the template's details.
   - **Periods**: You can adjust the weights for Prelim, Midterm, and Finals.
   - **Components**: You can adjust the weights for Class Standing, Project, Exam, and their sub-components (e.g., Attendance (F2F)).
4. Change the weight of **Attendance (F2F)** from **7%** to **8%** (example).
   - *Note*: Ensure the total weights sum correctly (though current validation is basic).
5. Click **"Save Changes"**.
6. You should see a success message.

## 3. Verify Changes in Grade Setup
1. Go back to the **Grade Setup** page (`/grade-setup`).
2. Open the browser console (F12 > Console) to see the `Grading templates loaded:` log and verify the fetched data.
3. Select **"College"** -> **"General Education"** subject category (simulated).
4. Click the **"Template"** dropdown and select **"General Education"**.
5. Click **"Yes, apply it!"** in the confirmation modal.
6. Observe the loaded grade components.
   - Expand "Class Standing".
   - Verify that **Attendance (F2F)** now shows **8%** (or whatever you changed it to).
   - This confirms that the frontend is pulling the latest configuration from the database.

## 4. API Verification
1. Access `/api/integration/grades/templates` (if you have the API key setup) or check `/grading-templates/list` directly in the browser.
2. Verify that the JSON response contains your updated weight.

## Troubleshooting
- **Templates not loading?** Check the browser console for errors. Ensure the backend is running and the database migration/seeder was successful.
- **Changes not saved?** Check the Network tab in developer tools for the PUT request to `/grading-templates/{id}`. Ensure CSRF token is present.
