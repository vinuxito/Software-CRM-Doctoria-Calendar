# Step 6: 1-Click Clinical PDF Report & Expediente Exporter

> **Goal**: Enable therapists to generate professional, print-ready PDF reports of the complete 5-step Expediente Clínico (including clinic header, anatomical body pain map, diagnosis, Tinetti mobility score, and therapist signature block) for insurance claims, medical referrals, or patient records.

---

## Proposed Changes

### 1. Controller & View Layer
#### [MODIFY] [Dashboard.php](file:///lamp/www/naxielly/app/controllers/Dashboard.php)
- Add `exportExpedientePdf($patientId)` endpoint.
- Renders clean printable HTML layout with `@media print` CSS rules and dompdf / window.print triggering.

#### [NEW] [expediente_pdf.php](file:///lamp/www/naxielly/app/views/dashboard/expediente_pdf.php)
- Clean, professional medical layout:
  - Header: Clinic logo, Doctoria CRM branding, RFC, License Number (Cédula Profesional).
  - Section 1: Patient Demographic Data & Contact Info.
  - Section 2: Medical Antecedents (Patológicos & Heredofamiliares).
  - Section 3: Exploración Física, Pain Map Diagram & EVA score.
  - Section 4: Treatment Plan & Completed Sessions summary.
  - Section 5: Gait Analysis & Tinetti Subscale Risk Badge.
  - Footer: Treating Specialist Signature line & Cédula Profesional input block.

---

### 2. View & JS Layer
#### [MODIFY] [patients.php](file:///lamp/www/naxielly/app/views/dashboard/sections/patients.php) & [patients.js](file:///lamp/www/naxielly/js/sections/patients.js)
- Add "Imprimir / Exportar PDF" button in the Expediente Digital modal header.
- Triggers pop-up print window formatted perfectly for A4/Letter PDF generation.

---

## Verification Plan
1. Open Patient Expediente Wizard -> Click "Imprimir / Exportar PDF".
2. Verify clean print template opens with complete patient history, body map data, Tinetti scores, and official signature block.
3. Click Print/Save to PDF: verify formatting scales to 1-2 pages without overflow or cutoffs.
