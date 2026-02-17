# Modality Display UI Update Plan

## Objective
Update the grade setup UI to display F2F and Online modality breakdowns for Attendance, Written Works, and Performance Task components.

## Current State
- Templates are correctly defined with modality data
- UI does not render modality sub-fields

## Desired UI Display

### For components WITH modalities:
```
Attendance (label only, no percentage)
  └ F2F: 7%
  └ Online: 3%

Written Works (label only)
  └ F2F: 33

%
  └ Online: 17%

Performance Task (label only)
  └ F2F: 27%
  └ Online: 13%
```

### For components WITHOUT modalities:
```
CBO: 100%
WE: 100%
OCR: 100%
```

## Implementation Requirements

### 1. Template Data Structure (✅ COMPLETE)
All templates now have correct modality data in `sub_components`:
- Attendance, Written Works, Performance Task have `modalities` array
- CBO, OCR, WE, OE do not have modalities

### 2. UI Rendering Logic (❌ NEEDS UPDATE)
The grade_setup.blade.php file needs JavaScript updates to:

1. **Detect modalities in sub-components**
   - Check if `sub_component.modalities` exists
   
2. **Render parent without percentage**
   - If modalities exist, display component name only
   - Example: "Attendance" instead of "Attendance (10%)"

3. **Render modality sub-rows**
   - Create nested input fields for each modality
   - Display: "F2F" with input showing "7"
   - Display: "Online" with input showing "3"

4. **Calculate AWG correctly**
   - AWG should sum the modality percentages directly
   - F2F (7%) + Online (3%) contributes 10% to Class Standing

## Affected Functions

Need to locate and update:
- `loadGradeDataToDOM()` function
- `createGradeComponent()` or similar rendering function
- Template application logic
- AWG calculation logic

## Template Summary by Category

### 1. General Education & NSTP 1
- Attendance: F2F 7% | Online 3%
- Written Works: F2F 33% | Online 17%
- Performance Task: F2F 27% | Online 13%

### 2. Professional (Lab/Non-Lab/Board/OC)
- Attendance: F2F 7% | Online 3%
- Written Works: F2F 27% | Online 13%
- Performance Task: F2F 33% | Online 17%

### 3. NSTP 2
- Attendance: F2F 7% | Online 3%
- Written Works: F2F 23% | Online 12%
- Performance Task: F2F 37% | Online 18%

### 4. Research
- Attendance: F2F 7% | Online 3%
- Written Works: F2F 30% | Online 15%
- Performance Task: F2F 30% | Online 15%

### 5. OJT/Practicum
- Attendance: F2F 20% | Online 10%
- Written Works: F2F 27% | Online 13%
- Performance Task: F2F 20% | Online 10%

## Next Steps
1. Locate the exact rendering functions in grade_setup.blade.php
2. Update rendering logic to check for modality data
3. Create nested UI elements for modality inputs
4. Test with all 9 templates
5. Verify AWG calculations include modality percentages
