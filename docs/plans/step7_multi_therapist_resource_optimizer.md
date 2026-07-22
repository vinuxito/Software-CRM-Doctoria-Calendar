# Step 7: Multi-Therapist Resource & Treatment Cubicle Optimizer

> **Goal**: Scale Doctoria CRM from single-practitioner to multi-therapist clinic operations by adding treatment cubicle/equipment allocation (e.g. Cubículo 1, Electroterapia, Camilla 2) and therapist commission/session revenue split tracking.

---

## Proposed Changes

### 1. Database Schema
#### Schema Update in `setup.sql` & Migration Script
```sql
CREATE TABLE IF NOT EXISTS clinic_resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL, -- e.g. 'Cubículo 1 (Electroterapia)', 'Gimnasio de Rehabilitación'
    type VARCHAR(50) DEFAULT 'cubiculo', -- 'cubiculo', 'equipo', 'camilla'
    status VARCHAR(20) DEFAULT 'available', -- 'available', 'maintenance'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE appointments 
ADD COLUMN IF NOT EXISTS resource_id INT DEFAULT NULL,
ADD COLUMN IF NOT EXISTS doctor_commission_rate DECIMAL(5,2) DEFAULT 50.00; -- Percentage split for treating doctor

ALTER TABLE users
ADD COLUMN IF NOT EXISTS default_commission_rate DECIMAL(5,2) DEFAULT 50.00;
```

---

### 2. View & Model Layer
#### [NEW] [resources.php](file:///lamp/www/naxielly/app/views/dashboard/sections/resources.php)
- Resource & Cubicle management view allowing clinic admins to add, edit, and toggle status of treatment rooms and equipment.

#### [MODIFY] [calendar.php](file:///lamp/www/naxielly/app/views/dashboard/sections/calendar.php)
- Add "Recurso / Cubículo" dropdown selector in appointment creation/edit modal to prevent room double-booking.
- Add resource conflict warning check if Cubículo 1 is selected for overlapping times.

#### [MODIFY] [Dashboard.php](file:///lamp/www/naxielly/app/controllers/Dashboard.php)
- Add `resources()` method for room management.
- Add therapist commission summary report calculation in Dashboard showing gross clinic revenue vs. doctor payouts.

---

## Verification Plan
1. Go to "Recursos y Consultorios" section: add "Cubículo 1 (Electroterapia)".
2. Schedule appointment at 10:00 AM selecting "Cubículo 1".
3. Try to schedule a second appointment at 10:15 AM in "Cubículo 1": verify system alerts "Recurso ocupado" room double-booking warning.
4. Verify doctor commission calculations correctly reflect 50% split on completed appointments.
