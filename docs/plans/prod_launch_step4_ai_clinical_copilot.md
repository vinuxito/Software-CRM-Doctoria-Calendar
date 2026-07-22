# Step 4: AI Clinical Assistant & Speech Auto-SOAP Copilot

## Objective
Equip physiotherapists and specialists with an AI voice-to-text dictation copilot that transcribes clinical observations, structures notes into standard SOAP format (*Subjective, Objective, Assessment, Plan*), and alerts specialists to physical therapy contraindications and ICD-10 medical code suggestions.

## User Value
- **Frictional Dictation**: Fisioterapeutas simply speak their observations after a session, saving up to 15 minutes of manual typing per patient.
- **Structured Compliance**: Automatically parses spoken notes into Subjetivo, Objetivo, Análisis, y Plan (SOAP), ensuring high clinical record standards.
- **Safety Alerts**: Real-time warnings if proposed physical agents (e.g. electroterapia, ultrasonido) conflict with patient medical history (e.g. marcapasos, embarazo).

## Files or Modules Likely Affected
- **Database Schema**: Add `soap_subjetivo`, `soap_objetivo`, `soap_analisis`, `soap_plan`, `icd10_tags` to `expedientes` table.
- **Controllers**: `app/controllers/Dashboard.php` (Add `generateSoapNotes()`).
- **Views**: `app/views/dashboard/sections/patients.php` (Add microphone dictation button & SOAP tab inside clinical wizard).
- **Helpers**: `app/helpers/AiClinicalCopilot.php` (Text structuring engine & contraindication rule checker).

## Implementation Plan
1. **Database Schema Enhancements**:
   - Add columns: `soap_subjetivo TEXT`, `soap_objetivo TEXT`, `soap_analisis TEXT`, `soap_plan TEXT`, `icd10_tags VARCHAR(255)`.
2. **Web Speech API Integration**:
   - Add microphone dictation button in clinical intake wizard (`js/sections/patients.js` using browser SpeechRecognition API in Spanish `es-MX`).
3. **SOAP Structuring Engine**:
   - Build `AiClinicalCopilot::parseClinicalText($dictatedText)` extracting key clinical sections and matching against contraindication rules.
4. **Contraindication Alert Engine**:
   - Scans patient background for conditions like "marcapasos", "implante metálico", or "embarazo" and flags physical agent modalities.

## UX Expectations
- A glowing microphone icon in the intake wizard modal (`🎙️ Dictar Consulta`).
- Real-time pulse animation during dictation and 1-second auto-structuring into 4 SOAP textareas.

## Security Considerations
- **HIPAA / PII Protection**: Dictated audio data is processed client-side or sent over HTTPS encrypted channels; raw audio streams are never stored on server disks.

## Failure Cases
- **Browser Speech Unavailability**: Falls back cleanly to standard manual keyboard typing without throwing console errors.
- **Noisy Speech Input**: Raw dictated text is placed in a scratch buffer for specialist review before auto-filling SOAP fields.

## Test Plan
- Write `test_prod_step4_ai_copilot.php`:
  1. Input sample raw dictation string.
  2. Verify SOAP parser categorizes text into Subjetivo, Objetivo, Análisis, Plan.
  3. Input patient history with "marcapasos" and verify electrotherapy warning triggers.

## Verification Evidence
- CLI test script execution confirming SOAP parsing accuracy and contraindication detection.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("AUDIT LOG: SOAP notes generated via AI Copilot for Patient ID [patient_id]")`.

## Definition of Done
- SOAP fields integrated in clinical wizard.
- Speech dictation active and tested.
- Contraindication engine 100% operational.

## Next Logical Step
Proceed to **Step 5: Patient Rehabilitation Care Pathways & Drip Sequences**.
