# Step 2: Mobile Couch Remote Shell & Thumb-Zone Action Sheets

## Objective
Design and implement a mobile-first "Couch Remote" shell (`max-width: 1023px`) featuring a fixed bottom navigation bar, 44px+ touch targets, 1-handed thumb-zone ergonomics, and slide-up action sheets.

## User Value
- **Specialists on Mobile**: Operate the entire CRM using one hand while moving between treatment rooms or relaxing at home.
- **Simplicity**: Eliminates complex sub-menus in favor of obvious 1-tap action sheets (*Agendar Cita*, *Enviar WhatsApp*, *Marcar Asistencia*, *Registrar Dolor*).

## Files or Modules Likely Affected
- **CSS**: `css/style.css` (Add `.mobile-bottom-nav`, `.action-sheet-overlay`, thumb-zone touch targets).
- **Views**: `app/views/inc/mobile_nav.php` (new partial), `app/views/dashboard/index.php`.
- **JS**: `js/sections/mobile_remote.js` (Slide-up action sheet gestures & touch handling).

## Implementation Plan
1. **Sticky Bottom Navigation Bar**:
   - Fixed at viewport bottom (`position: fixed; bottom: 0; left: 0; right: 0; height: 64px; z-index: 1000`).
   - 4 Core Touch Destinations:
     - 📅 **Agenda**
     - 👥 **Pacientes**
     - ⚡ **Acciones Rápidas (Center FAB button)**
     - 💬 **Mensajes**
2. **Slide-Up Action Sheet Component**:
   - Tapping the central ⚡ **Acciones Rápidas** button triggers a native-feeling slide-up action sheet from the bottom edge containing 4 primary 1-tap targets:
     - 💬 *Enviar Recordatorio WhatsApp*
     - ➕ *Agendar Nueva Cita*
     - 🧍 *Registrar Dolor Anatómico*
     - 🎙️ *Dictar Nota de Consulta*

## UX Expectations
- No double-tapping required; all primary actions are within comfortable reach of the right or left thumb.
- Smooth CSS cubic-bezier slide-up animation (`transform: translateY(0)`) when opening action sheets.

## Security Considerations
- Mobile action sheets enforce strict CSRF token validation on all POST actions.

## Failure Cases
- **Mobile Browser URL Bar Hiding**: Uses `env(safe-area-inset-bottom)` to ensure bottom navigation does not overlap with iOS Home Indicator bar or browser navigation controls.

## Test Plan
- Verify viewport width `< 1024px` displays sticky bottom nav and hides desktop sidebar.
- Verify Action Sheet slide-up and tap execution.

## Verification Evidence
- DOM inspection verifying mobile bottom nav rendering and 44px minimum touch target compliance.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("AUDIT LOG: Mobile Action Sheet triggered: [action_name]")`.

## Definition of Done
- Sticky bottom navigation active on mobile.
- Slide-up action sheet working cleanly.

## Next Logical Step
Proceed to **Step 3: Desktop Power Calendar Timeline & Drag-and-Reschedule Grid**.
