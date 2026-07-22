# Step 3: Desktop Power Calendar Timeline & Drag-and-Reschedule Grid

## Objective
Upgrade the desktop FullCalendar view into a multi-doctor resource timeline grid with drag-and-drop rescheduling, cubicle color coding, hover appointment previews, and instant hotkey scheduling.

## User Value
- **Front-Desk Admins & Head Doctors**: Manage multi-therapist schedules simultaneously in a side-by-side vertical column timeline view.
- **Efficiency**: Drag any appointment card to a new time slot or cubicle column to reschedule instantly.

## Files or Modules Likely Affected
- **JS**: `js/sections/calendar.js` (FullCalendar timeline view configuration, drag-and-drop event handlers).
- **CSS**: `css/style.css` (Timeline column styles, cubicle status badges, event hover cards).
- **Controllers**: `app/controllers/Dashboard.php` (AJAX endpoint `rescheduleAppointment`).

## Implementation Plan
1. **FullCalendar Timeline Grid Configuration**:
   - Enable `resourceTimeGridDay` view on desktop showing doctors and cubicles as vertical columns side-by-side.
   - Color-code appointment events by treatment cubicle (`Cubículo 1`, `Camilla Electroterapia`, `Consultorio 2`).
2. **Drag-and-Drop Reschedule Handler**:
   - On event drop/resize, trigger background AJAX request to `/dashboard/rescheduleAppointment`:
     - Parameters: `appointment_id`, `new_start`, `new_end`, `resource_id`.
     - Validates cubicle double-booking before saving.

## UX Expectations
- Hovering over any appointment on the desktop timeline displays a clean popover preview card showing patient contact, treatment type, EVA pain score, and confirmation status.

## Security Considerations
- Rescheduling verifies CSRF token and user role permission (`admin` or assigned `medico`).

## Failure Cases
- **Cubicle Conflict On Drag**: If a user drags an appointment into an occupied cubicle slot, the grid rejects the move with a red alert and snaps the event back to its original slot.

## Test Plan
- Write `test_calendar_drag.js` verifying AJAX endpoint `/dashboard/rescheduleAppointment` parameters and validation responses.

## Verification Evidence
- Terminal AJAX test response log confirming appointment update upon drag event.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("AUDIT LOG: Appointment ID [id] rescheduled to [new_start] via Desktop Timeline Drag")`.

## Definition of Done
- Resource timeline grid functional on desktop.
- Drag-and-drop rescheduling active with cubicle conflict validation.

## Next Logical Step
Proceed to **Step 4: Mobile Express Patient Check-In & 1-Tap WhatsApp Dispatch**.
