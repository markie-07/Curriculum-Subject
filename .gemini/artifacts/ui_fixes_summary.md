# UI Interactivity Fixes

## Problem
The "College" and "Senior High" selection buttons were unresponsive. Additionally, the "Select Subject Category" button was not working.

## Root Cause
The JavaScript event listeners for these buttons were missing from `grade_setup.blade.php`. The logic function `handleLevelSelection` was also undefined in the active code.

## Solution
Restored the interactivity by implementing:
1. `handleLevelSelection(level)` function to handle the UI state switching and workflow reset.
2. Event listeners for `college-btn` and `senior-high-btn`.
3. Event listener for `select-memorandum-btn` to open the category selection modal.

## Files Modified
- `resources/views/grade_setup.blade.php`

## Verification
- Click "College" -> Button highlights blue, Memorandum section appears.
- Click "Senior High" -> Button highlights purple, Memorandum section appears.
- Click "Select Subject Category" -> Modal opens with categories.
