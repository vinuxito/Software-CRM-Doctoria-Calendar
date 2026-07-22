# Step 1: Multi-Clinic Organization & Data Isolation Engine

## Objective
Implement multi-clinic tenant isolation across Doctoria CRM, allowing clinic networks and multi-branch healthcare organizations to manage multiple locations under one system while maintaining strict data isolation per branch.

## User Value
- **Clinic Owners**: Seamlessly switch between multiple branches (e.g. Branch CDMX North, Branch Guadalajara) from a single admin account.
- **Therapists / Doctors**: Only see patients, calendar slots, and treatment cubicles assigned to their specific active branch.
- **Security / Compliance**: Guarantees patient medical records (`expedientes`) are row-level scoped to authorized clinic locations.

## Files or Modules Likely Affected
- **Database Schema**: `setup.sql` (Add `clinics` table, add `clinic_id` column to `users`, `appointments`, `expedientes`, `clinic_resources`).
- **Core Controller**: `app/controllers/Dashboard.php` (Add `active_clinic_id` session handling & branch switcher endpoint `switchClinic`).
- **Models**: `app/models/User.php`, `app/models/Appointment.php`, `app/models/Expediente.php`, `app/models/Resource.php`.
- **Views**: `app/views/inc/header.php` (Add clinic branch dropdown selector), `app/views/dashboard/index.php`.

## Implementation Plan
1. **Schema Migration**:
   ```sql
   CREATE TABLE IF NOT EXISTS clinics (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(120) NOT NULL,
       code VARCHAR(30) UNIQUE NOT NULL,
       address VARCHAR(255) DEFAULT NULL,
       phone VARCHAR(50) DEFAULT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   ```
   Add `clinic_id INT DEFAULT 1` to `users`, `appointments`, `expedientes`, `clinic_resources`. Insert Default Clinic record (`id = 1`) to preserve 100% backwards compatibility.
2. **Session Context Scoping**:
   - In `Dashboard::__construct()`, initialize `$_SESSION['active_clinic_id']` defaulting to `1`.
   - Update model queries (`getAppointments()`, `getResources()`, `getPatients()`) to filter by `clinic_id = :clinic_id` when `clinic_id` constraint is set.
3. **Branch Switcher Endpoint**:
   - Add `Dashboard::switchClinic()` route verifying user permission before changing active session `clinic_id`.

## UX Expectations
- Top navigation bar header displays a clean clinic selector dropdown (e.g. `📍 Clínica Central (CDMX)`).
- Switching clinics reloads the active section with instant animated transition without forcing user logout.

## Security Considerations
- **Row-Level Tenant Isolation**: Users cannot tamper with `clinic_id` POST parameters to view or manipulate data belonging to another clinic tenant.
- **Role Scoping**: Only `admin` role can create new clinic branches or switch across all branches.

## Failure Cases
- **Unassigned Clinic User**: User with `clinic_id = NULL` automatically defaults to Default Clinic `id = 1`.
- **Invalid Clinic Switch Attempt**: Attempting to switch to a non-existent or unauthorized `clinic_id` rejects with HTTP 403 and logs security warning.

## Test Plan
- Write `test_prod_step1_multi_clinic.php`:
  1. Create 2 distinct clinic branches in DB.
  2. Insert appointments under Clinic 1 and Clinic 2.
  3. Verify `getAppointmentsForUser` returns ONLY Clinic 1 appointments when `clinic_id = 1`.
  4. Verify branch switching correctly filters resources and patients.

## Verification Evidence
- Terminal output log from `test_prod_step1_multi_clinic.php` demonstrating isolated record counts per tenant.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("AUDIT LOG: User [email] switched active clinic to [clinic_id]")`.

## Definition of Done
- Multi-clinic schema applied in DB with default fallback.
- Navigation branch switcher functional.
- All 7 existing test suites remain 100% green.

## Next Logical Step
Proceed to **Step 2: Telemedicine Video Hub & Patient Consultation Portal**.
