# Step 4: Mobile Express Patient Check-In & 1-Tap WhatsApp Dispatch

## Objective
Build a mobile-tailored express check-in workflow allowing receptionists and specialists to record patient arrivals with 1 tap, dispatch instant WhatsApp appointment confirmation links, and dictate quick voice consultation notes on mobile devices.

## User Value
- **Front-Desk Staff on Mobile Tablet/Phone**: Check in arriving patients instantly as they walk through the clinic door.
- **Therapists**: Send pre-formatted WhatsApp reminders directly from their phone with a single tap.

## Files or Modules Likely Affected
- **Views**: `app/views/dashboard/sections/mobile_checkin.php` (new mobile section).
- **Controllers**: `app/controllers/Dashboard.php` (Endpoint `checkinPatient($appointmentId)`).
- **JS**: `js/sections/mobile_checkin.js` (1-tap status toggles & Web Speech mobile microphone handler).

## Implementation Plan
1. **Express Arrival List View**:
   - Renders today's scheduled appointments in high-contrast card list format optimized for mobile screens.
   - Large 48px action buttons: `[✓ MARCAR LLEGADA]`, `[💬 SEND WHATSAPP]`.
2. **1-Tap WhatsApp Dispatch**:
   - Tapping `[💬 SEND WHATSAPP]` opens native WhatsApp mobile app pre-filled with patient reminder text and tokenized 1-click confirmation link.
3. **Mobile Voice SOAP Dictation**:
   - Includes microphone button using mobile browser speech recognition for dictating quick notes directly into patient file.

## UX Expectations
- Tapping `[✓ MARCAR LLEGADA]` instantly updates appointment badge from `Pendiente` (Yellow) to `En Espera` (Green) with haptic visual feedback.

## Security Considerations
- Express check-in requires active session authentication; public endpoints are strictly tokenized.

## Failure Cases
- **WhatsApp App Not Installed**: Falls back to copying pre-formatted text to clipboard with alert *"Mensaje copiado al portapapeles"*.

## Test Plan
- Write `test_mobile_checkin.php`:
  1. Trigger `checkinPatient` endpoint for appointment ID.
  2. Verify status updates to `arrived`.
  3. Verify WhatsApp deep link URL generation.

## Verification Evidence
- CLI test log verifying appointment arrival state transition.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("AUDIT LOG: Patient marked ARRIVED for Appointment ID [id] via Mobile Check-In")`.

## Definition of Done
- Mobile check-in view active.
- 1-tap WhatsApp dispatch functional.

## Next Logical Step
Proceed to **Step 5: Adaptive Anatomical Body Map (Desktop Silhouette vs Mobile Touch Zones)**.
