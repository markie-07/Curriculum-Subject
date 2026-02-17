# Implementation Plan: Fix Grade Setup Interactions

## Problem
The user reported that clicking the Curriculum Level buttons (Senior High/College) did nothing.
- Investigation revealed multiple `const` declarations for `handleLevelSelection`, `calculateAndUpdateTotals`, and `loadGradeDataToDOM` were causing a script initialization error (SyntaxError: Identifier '...' has already been declared).
- This prevented any event listeners from attaching, including the one for the Level Selection buttons.
- Additionally, duplicate `loadGradeDataToDOM` functions existed: one supported "modality" inputs (required by the templates), but the newer one did not.

## Solution
1. **Remove Duplicate Declarations**:
   - Deleted the older `handleLevelSelection` (Line ~634) in favor of the newer one (Line ~2104) which correctly handles the new workflow.
   - Deleted the newer `loadGradeDataToDOM` (Line ~1945) in favor of the older one (Line ~1235) which supports modality inputs required by the template data structure.
   - Deleted the older `calculateAndUpdateTotals` (Line ~1336) in favor of the newer one (Line ~1809) which includes validation logic.

2. **Merge Modality Calc Logic**:
   - Updated the surviving `calculateAndUpdateTotals` function to iterate through `modality-input` elements when calculating totals, ensuring that templates with modalities (like Attendance: F2F/Online) calculate their weights correctly. This logic was missing from the newer version of the function.

## Verification
- Clicking "Senior High" or "College" should now trigger `handleLevelSelection`, which unhides the `#memorandum-section`.
- Selecting a category should trigger `populateSubjectCategories` and show the list of subjects.
- Applying a template with modalities (e.g., General Education) should correctly calculate the total weight (100%) by summing up the modalities, instead of failing or showing incorrect totals.
