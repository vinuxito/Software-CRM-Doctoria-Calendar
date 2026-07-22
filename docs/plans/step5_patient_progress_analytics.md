# Step 5: Rehabilitation Progress & Clinical Analytics Dashboard

> **Goal**: Provide therapists and clinic owners with visual rehabilitation progress analytics tracking EVA pain reduction curves over time, Tinetti gait score improvements, total completed sessions vs. planned treatment sessions, and clinic revenue metrics.

---

## Proposed Changes

### 1. View & Asset Layer
#### [NEW] [analytics.php](file:///lamp/www/naxielly/app/views/dashboard/sections/analytics.php)
- Dedicated "Analítica Clínica & Rehabilitación" section in Dashboard.
- **Pain Reduction Curve**: Interactive Chart.js / SVG line chart plotting EVA pain scale (1-10) across evaluation sessions for selected patient.
- **Tinetti Mobility Score Chart**: Bar chart comparing baseline Tinetti gait/balance scores vs current post-treatment scores.
- **Treatment Plan Compliance Gauge**: Progress bar showing completed sessions vs planned sessions (e.g. 8 of 12 sessions completed, 66%).
- **Financial Analytics**: Monthly clinic revenue from appointments and CFDI medical invoices.

---

### 2. Model & Controller Layer
#### [MODIFY] [Expediente.php](file:///lamp/www/naxielly/app/models/Expediente.php)
- Add `getPatientProgressHistory($patientId)` querying longitudinal EVA scores, Tinetti scores, and session completion metrics across all historic expedientes and sessions.

#### [MODIFY] [Dashboard.php](file:///lamp/www/naxielly/app/controllers/Dashboard.php)
- Add `analytics()` action method serving aggregated clinical progress data and monthly clinic financial analytics.

---

### 3. JavaScript Layer
#### [NEW] [analytics.js](file:///lamp/www/naxielly/js/sections/analytics.js)
- Chart initialization scripts (using Chart.js or SVG rendering) for EVA pain trend lines and session completion indicators.

---

## Verification Plan
1. Open "Analítica Clínica" section in sidebar.
2. Select a patient with multiple sessions: verify EVA pain line chart renders downward trajectory (e.g., Session 1: 8/10 -> Session 4: 3/10).
3. Verify session compliance progress bar accurately calculates completed vs total planned sessions.
