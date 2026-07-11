# Advanced Clinical Record (Expediente Clínico Digital) Upgrade Plan

This plan outlines the implementation sequence to build the 5-Step Clinical Intake Wizard for Doctoria CRM, aligning directly with the design specifications of [Expediente_Clinico_WebForm.pdf](file:///lamp/www/naxielly/docs/Expediente_Clinico_WebForm.pdf) and the brand identity of T.F. Naxielly Z. Franco Ascencio.

---

## 🗺️ Index of Steps

### 1. 🗄️ [Step 1: Schema + Shell + Step 1](file:///lamp/www/naxielly/docs/plans/step1_schema_shell_step1.md)
* **Goal**: Establish the MySQL database tables for all Section 3 entities, set up the PHP JSON controllers, design the wizard UI shell with a progress bar, and implement Step 1 (Datos del Paciente) with automated age calculation.

### 2. 🎛️ [Step 2: ToggleWithSpec Component & Step 2](file:///lamp/www/naxielly/docs/plans/step2_toggle_with_spec_step2.md)
* **Goal**: Build the reusable three-state segmented toggle control (`ToggleWithSpec`) for pathological and non-pathological history items, and implement the persistent clinical warning badges for Marcapasos / Embarazo.

### 3. 🩺 [Step 3: Step 3 Full (Exploración, Dolor, Cicatriz & Problemas)](file:///lamp/www/naxielly/docs/plans/step3_step3_full.md)
* **Goal**: Implement physical examination fields (with heart rate / blood pressure masks), functional assessments, surgical scar toggles, the interactive EVA pain slider with morphing faces, and the severity matrix of identified problems.

### 4. 📅 [Step 4: Step 4 Treatment Plan Rows](file:///lamp/www/naxielly/docs/plans/step4_step4_plan_rows.md)
* **Goal**: Build the dynamic `RepeatableRow` component for treatment session history, adding session addition, removal, and sorting.

### 5. 🚶‍♂️ [Step 5: Step 5 Gait & Scoring (Tinetti)](file:///lamp/www/naxielly/docs/plans/step5_step5_gait_scoring.md)
* **Goal**: Integrate gait observation checkboxes, the 10 categories of the Tinetti gait subscale, manual balance subscale input, and auto-calculators for risk indicators.

### 6. 💾 [Step 6: Autosave & Offline Resilience](file:///lamp/www/naxielly/docs/plans/step6_autosave_resilience.md)
* **Goal**: Incorporate instant client-side draft caching in `localStorage`, background AJAX auto-saves on blur/step change, and connection status alerts.

### 7. 🧪 [Step 7: QA Dual Verdict & Closing](file:///lamp/www/naxielly/docs/plans/step7_qa_dual_verdict.md)
* **Goal**: Run strict validation sweeps (byte-exact data retention checks) and mobile touch-target gappings on portrait screens.

---

## 🚫 Out of Scope (v1)
* Multi-therapist authentication and roles.
* External patient portal.
* PDF export of the completed expediente (natural v2).
* Tinetti balance section UI details (outside of manual input score).
