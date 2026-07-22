# Step 5: Patient Rehabilitation Care Pathways & Drip Sequences

## Objective
Build automated post-treatment care pathways, WhatsApp/SMS drip follow-up sequences, home exercise video prescription plans, and automated CSAT/NPS patient satisfaction surveys to boost patient retention and therapy compliance.

## User Value
- **Patients**: Receive clear day-by-day WhatsApp guidance after treatment (e.g. *"Día 2 post-terapia: Realiza 3 series de 10 estiramientos lumbares"*), increasing recovery speeds.
- **Clinic Managers**: Track patient adherence to treatment plans and automatically measure clinic Net Promoter Score (NPS).

## Files or Modules Likely Affected
- **Database Schema**: Create `care_pathways`, `patient_prescriptions`, and `patient_surveys` tables.
- **Models**: `app/models/CarePathway.php` (new model).
- **Controllers**: `app/controllers/Dashboard.php` (Add `pathways()`, `assignPathway()`, `processDripCron()`).
- **Views**: `app/views/dashboard/sections/pathways.php` (Pathways builder view).

## Implementation Plan
1. **Database Schema Setup**:
   ```sql
   CREATE TABLE IF NOT EXISTS care_pathways (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       condition_type VARCHAR(50) NOT NULL,
       duration_days INT DEFAULT 14,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   CREATE TABLE IF NOT EXISTS patient_prescriptions (
       id INT AUTO_INCREMENT PRIMARY KEY,
       patient_id INT NOT NULL,
       pathway_id INT NOT NULL,
       start_date DATE NOT NULL,
       status VARCHAR(20) DEFAULT 'active'
   );
   ```
2. **Drip Sequence Cron Processor**:
   - Create `processDripCron()` endpoint scheduled via system cron (`*/15 * * * *`) that checks active prescriptions and dispatches scheduled WhatsApp care messages.
3. **Automated NPS Survey Dispatch**:
   - Automatically dispatches a 1-click 1-to-10 rating link 24 hours after a patient completes their final session.

## UX Expectations
- Therapists can select a preset care pathway (e.g. *"Protocolo Lumbalgia Mecánica - 14 Días"*) with 1 click during intake wizard step 4.
- Patient portal view displays their assigned home exercises with video links.

## Security Considerations
- **Unsubscribe Link**: Every WhatsApp care drip contains an explicit unsubscribe token allowing patients to stop automated sequences (`"Envia STOP para cancelar"`).
- **HIPAA Data Privacy**: Messages omit sensitive diagnostic detail in plain text and use secure link tokens.

## Failure Cases
- **Bounced SMS / WhatsApp Failure**: System logs failure status and flags patient record for front-desk phone verification.

## Test Plan
- Write `test_prod_step5_pathways.php`:
  1. Assign a 7-day knee rehab pathway to a test patient.
  2. Simulate cron execution for Day 1 and Day 3.
  3. Verify scheduled WhatsApp messages format correctly.

## Verification Evidence
- Terminal cron output log confirming pathway assignment and message payload generation.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("AUDIT LOG: Assigned Care Pathway [id] to Patient [patient_id]")`.

## Definition of Done
- Care pathway builder created.
- Drip sequence cron logic verified via CLI test.
- Patient survey tracking functional.

## Next Logical Step
Proceed to **Step 6: Production Hardening, Rate Limiting & Zero-Downtime Operations**.
