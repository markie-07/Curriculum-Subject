# Implementation Plan - Grading Template Update

This plan details the changes made to the grading template configuration to support the granularity shown in the provided screenshots (F2F/Online split).

## User Requirement
- Update the grading templates to include separate components for Face-to-Face (F2F) and Online classes within "Attendance" and "Performance Task".
- Reference a legend showing similar splits for "Written Works".

## Architectural Changes

### Frontend Configuration (`resources/views/grade_setup.blade.php`)
- **File**: `resources/views/grade_setup.blade.php`
- **Location**: The `templates` JavaScript object (lines ~650 onwards).
- **Change**: Updated the `sub_components` array for the "Class Standing" main component in the following templates:
    - `gen_ed` (General Education)
    - `prof_lab` (Professional Subject Laboratory)
    - `prof_non_lab` (Professional Subject Non-Laboratory)
    - `prof_board` (Professional Subject Board Courses)
    - `prof_oc` (Professional Subject OC)

### Component Breakdown Strategy
Instead of implementing a complex 3-level hierarchy (Main -> Sub -> Sub-Sub), which would require extensive rewrites of the rendering and calculation logic, the components were flattened into distinct sub-components under "Class Standing".

**Example (General Education):**
- **Old Structure**:
  - Attendance (10%)
  - Written Works (50%)
  - Performance Task (40%)
  
- **New Structure**:
  - Attendance (F2F) (7%)
  - Attendance (Online) (3%)
  - Written Works (F2F) (33%)
  - Written Works (Online) (17%)
  - Performance Task (F2F) (27%)
  - Performance Task (Online) (13%)

*Total Weight: 100% (unchanged)*

## Validation
- The `calculateAndUpdateTotals` function in the existing JavaScript validates that the sum of sub-components equals 100%.
- The new breakdown aligns perfectly with this validation rule (7+3+33+17+27+13 = 100).
