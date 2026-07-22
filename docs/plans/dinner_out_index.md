# Operation: DINNER OUT — 7 High-Impact Upgrades for Doctoria CRM

> **Architecture & Upgrade Strategy**: Sequential, incremental modular upgrades to elevate Doctoria CRM from a basic clinic tool into a market-leading, high-value Clinical & Fiscal Practice Management Platform for Physiotherapy & Medical Clinics.

---

## Operating Philosophy Applied
- **Presence before performance**: Grounded in concrete codebase inspection of current PHP MVC, FullCalendar 5.11, and 5-Step Expediente Wizard.
- **Clarity before action**: Eliminating UI ambiguity (icon-only sidebar, hidden buttons) and detailing exact database/view/controller changes for each step.
- **Evidence before claims**: Verified against current DB schema (`setup.sql` & `expedientes`), existing model structure (`Expediente.php`, `User.php`, `PatientFile.php`), and JS wizard modules.

---

## 7 Sequential Upgrades Index

| Step | Plan File | Module | Primary Impact |
|------|-----------|--------|----------------|
| **Step 1** | [step1_visual_navigation_search.md](file:///lamp/www/naxielly/docs/plans/step1_visual_navigation_search.md) | Navigation & Command Palette | Resolves UI ambiguity with labeled high-contrast sidebar + `Cmd/Ctrl+K` instant search. |
| **Step 2** | [step2_interactive_body_map.md](file:///lamp/www/naxielly/docs/plans/step2_interactive_body_map.md) | Clinical Expediente (Step 3) | Adds 2D interactive anatomical body pain mapper (front/back) to Step 3 of the intake wizard. |
| **Step 3** | [step3_whatsapp_reminders_noshow.md](file:///lamp/www/naxielly/docs/plans/step3_whatsapp_reminders_noshow.md) | Calendar & Communication | Automated WhatsApp/SMS appointment confirmations, 1-click links & no-show recovery engine. |
| **Step 4** | [step4_cfdi_sat_invoicing.md](file:///lamp/www/naxielly/docs/plans/step4_cfdi_sat_invoicing.md) | Invoicing & Fiscal (SAT) | Mexican CFDI 4.0 medical invoice generator with RFC profile management & PDF/XML downloads. |
| **Step 5** | [step5_patient_progress_analytics.md](file:///lamp/www/naxielly/docs/plans/step5_patient_progress_analytics.md) | Dashboard & Clinical Analytics | Visual rehab progress charts tracking EVA pain scale, gait score improvements, & session counts. |
| **Step 6** | [step6_expediente_pdf_export.md](file:///lamp/www/naxielly/docs/plans/step6_expediente_pdf_export.md) | Expediente Module | 1-Click professional PDF report generator for clinical histories, insurance claims & referrals. |
| **Step 7** | [step7_multi_therapist_resource_optimizer.md](file:///lamp/www/naxielly/docs/plans/step7_multi_therapist_resource_optimizer.md) | Calendar & Operations | Treatment cubicle/equipment allocation & multi-therapist revenue split calculations. |

---

## Execution Loop Guidelines
- **Sequential Building**: Each step builds upon the previous step without breaking existing functionality.
- **Backwards Compatibility**: All existing database tables (`users`, `appointments`, `expedientes`, `patient_files`) remain intact with migrations added via clean `ALTER` statements.
- **Zero Dummy Stubs**: Every feature includes full backend logic, controller actions, database persistence, and verified frontend interactions.
