# Step 3: Automated WhatsApp & SMS Appointment Reminders

> **Goal**: Eliminate patient no-shows by building an automated WhatsApp & SMS reminder engine with 1-click confirmation/cancellation links integrated directly into the Calendar & Dashboard modules.

---

## Proposed Changes

### 1. Database Schema
#### Schema Update in `setup.sql` & Migration Script
```sql
ALTER TABLE appointments 
ADD COLUMN IF NOT EXISTS reminder_sent TINYINT(1) DEFAULT 0,
ADD COLUMN IF NOT EXISTS confirmation_status VARCHAR(20) DEFAULT 'unconfirmed', -- 'unconfirmed', 'confirmed', 'cancelled'
ADD COLUMN IF NOT EXISTS confirmation_token VARCHAR(64) DEFAULT NULL;
```

---

### 2. Service & Helper Layer
#### [NEW] [WhatsAppService.php](file:///lamp/www/naxielly/app/helpers/WhatsAppService.php)
- Helper class formatting WhatsApp wa.me / API webhook links and dispatching automated reminder templates:
  - *Template*: `"Hola {patient_name}, te recordamos tu cita de fisioterapia el {date} a las {time} con el {doctor_name}. Confirma tu asistencia aquí: {confirm_link}"`

---

### 3. Controller & View Layer
#### [MODIFY] [Dashboard.php](file:///lamp/www/naxielly/app/controllers/Dashboard.php)
- Add `sendAppointmentReminder($appointmentId)` endpoint.
- Add public endpoint `confirmAppointment($token)` allowing patients to confirm or reschedule via 1-click token without needing a password.

#### [MODIFY] [calendar.php](file:///lamp/www/naxielly/app/views/dashboard/sections/calendar.php) & [panel.php](file:///lamp/www/naxielly/app/views/dashboard/sections/panel.php)
- Display confirmation status chips (`Confirmado` green, `Pendiente` orange, `Cancelado` red) on calendar event popups and panel appointment tables.
- Add direct "Enviar Recordatorio WhatsApp" button on every appointment card.

---

## Verification Plan
1. Schedule a test appointment in the Calendar.
2. Click "Enviar Recordatorio WhatsApp": verify pre-filled WhatsApp web link generates with correct patient phone, date, time, and confirmation link.
3. Open confirmation URL in browser: verify appointment status updates instantly to `confirmed` in DB and calendar badge turns green.
