# Walkthrough - Verifying Grading Template Updates

This walkthrough guides you through testing the updated grading templates in the Grade Setup module.

## Prerequisites
- Log in to the application as a user with grade management permissions (e.g., Administrator or Academic Head).
- Navigate to the **Grade Setup** page where `grade_setup.blade.php` is used.

## Steps

### Step 1: Select a "General Education" Subject Template
1.  On the Grade Setup page, click the **Set Grade Scheme** button (or access the template selection dropdown).
2.  Select **General Education** from the list of templates.
3.  Observe the populated components under **Class Standing**.
    -   **Expected Result**:
        -   **Attendance (F2F)**: 7%
        -   **Attendance (Online)**: 3%
        -   **Written Works (F2F)**: 33%
        -   **Written Works (Online)**: 17%
        -   **Performance Task (F2F)**: 27%
        -   **Performance Task (Online)**: 13%
    -   **Total**: Ensure the sub-total for "Class Standing" is **100%**.

### Step 2: Select a "Professional Subject (Laboratory)" Template
1.  Click **Create new** or **Hide** to clear the current setup.
2.  Click **Set Grade Scheme** again.
3.  Select **Professional Subject Laboratory** (or equivalent, e.g., 'prof_lab').
4.  Observe the components under **Class Standing**.
    -   **Expected Result**:
        -   **Attendance (F2F)**: 7%
        -   **Attendance (Online)**: 3%
        -   **Written Works (F2F)**: 27% (Lower than Gen Ed)
        -   **Written Works (Online)**: 13%
        -   **Performance Task (F2F)**: 33% (Higher than Gen Ed)
        -   **Performance Task (Online)**: 17%
    -   **Total**: Ensure the sub-total for "Class Standing" is **100%**.

### Step 3: Save Configuration (Optional)
1.  If creating a new grade scheme, try clicking **Set Grade Scheme** to save.
2.  The validation logic should pass successfully since the total weight is 100%.

## Troubleshooting
-   If you see "NaN" or calculation errors, ensure that no duplicate component names exist and that the input fields are numeric.
-   If the dropdown does not show the updated templates immediately, try hard-refreshing the page (Ctrl+F5) to clear browser cache for the JavaScript changes.
