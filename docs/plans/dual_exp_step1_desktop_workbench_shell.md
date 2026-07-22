# Step 1: Desktop Workbench High-Density Layout & Multi-Panel Shell

## Objective
Transform the desktop interface (`min-width: 1024px`) into a high-density clinical workbench shell featuring collapsible sidebars, multi-panel split view (Agenda + Expediente + Notes), and keyboard navigation shortcuts (`Ctrl+K`, `N` for new appointment, `P` for patient search).

## User Value
- **Specialists at Desk**: View patient clinical history, past EVA pain curves, and live consultation notes side-by-side on large displays without tab jumping.
- **Speed**: Keyboard shortcuts allow rapid navigation without mouse dependency.

## Files or Modules Likely Affected
- **CSS**: `css/style.css` (Add `.workbench-shell`, `@media (min-width: 1024px)` density styles, multi-panel grid system).
- **Views**: `app/views/dashboard/index.php`, `app/views/inc/command_palette.php`.
- **JS**: `js/sections/workbench.js` (Keyboard hotkeys listener: `Ctrl+K`, `Alt+N`, `Alt+P`).

## Implementation Plan
1. **Desktop Workbench Grid**:
   - Define a 3-column workbench grid layout:
     - Column 1 (Navigation Sidebar): Collapsible 210px / 64px compact icon view.
     - Column 2 (Primary Workspace): Agenda calendar or Patient list (55% width).
     - Column 3 (Split Inspector): Quick patient expediente drawer & live SOAP notes (45% width).
2. **Keyboard Hotkeys Engine**:
   - `Ctrl + K`: Open Command Palette search.
   - `Alt + N`: Open New Appointment modal.
   - `Alt + P`: Focus Patient Quick Search.
   - `Esc`: Close open modal / collapse split inspector.

## UX Expectations
- On screens 1024px and wider, clicking any patient in the calendar opens the Split Inspector on the right without navigating away from the calendar grid.
- High-density typography (`Inter`, font-size 13px/14px, crisp borders) maximizes visible clinical data per square inch.

## Security Considerations
- Split view respects session RBAC role permissions (`medico` vs `cliente`).

## Failure Cases
- **Small Screens**: Automatically falls back to single-column view when viewport width drops below 1024px.

## Test Plan
- Write `test_workbench_hotkeys.js` or CLI check verifying CSS breakpoints and JS hotkey event delegation.

## Verification Evidence
- Verification evidence screenshot/DOM inspection confirming 3-panel split view activation on desktop resolution.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("AUDIT LOG: Workbench Split Inspector opened for Patient ID [id]")`.

## Definition of Done
- Desktop 3-panel workbench layout fully operational.
- Keyboard hotkeys active and tested.

## Next Logical Step
Proceed to **Step 2: Mobile Couch Remote Shell & Thumb-Zone Action Sheets**.
