# 🚀 Doctoria CRM — Master Production Launch Doctrine

> **Core Law**: *"We are not planning features. We are preparing this app to go live."*

This index connects 6 detailed, sequential, production-grade upgrade blueprints designed to transition **Doctoria CRM & Calendar** from a standalone practice app into a bulletproof, enterprise-ready, multi-clinic SaaS platform.

---

## 🧭 Backwards Compatibility Guarantee

Every step in this doctrine is designed to preserve 100% backwards compatibility with existing endpoints, MVC routes, database tables, and active sessions. No existing API contracts or frontend workflows will be broken.

---

## 📌 Production Step Index

| Step | Blueprint Title | Core Impact | Target File |
|------|-----------------|-------------|-------------|
| **Step 1** | **Multi-Clinic Organization & Data Isolation Engine** | Multi-branch scoping, row-level tenant security, organization switching without breaking legacy single-clinic mode | [prod_launch_step1_multi_clinic_isolation.md](file:///lamp/www/naxielly/docs/plans/prod_launch_step1_multi_clinic_isolation.md) |
| **Step 2** | **Telemedicine Video Hub & Patient Consultation Portal** | WebRTC video room link generation, virtual waiting room, live consultation notes sync | [prod_launch_step2_telemed_video_hub.md](file:///lamp/www/naxielly/docs/plans/prod_launch_step2_telemed_video_hub.md) |
| **Step 3** | **Stripe/MercadoPago Payments & Financial Ledger** | Online deposit links, automated payment allocation, therapist commission splits & revenue tracking | [prod_launch_step3_payments_ledger_engine.md](file:///lamp/www/naxielly/docs/plans/prod_launch_step3_payments_ledger_engine.md) |
| **Step 4** | **AI Clinical Assistant & Speech Auto-SOAP Copilot** | Clinical voice dictation, automated SOAP note structuring, contraindication detection & ICD-10 tagging | [prod_launch_step4_ai_clinical_copilot.md](file:///lamp/www/naxielly/docs/plans/prod_launch_step4_ai_clinical_copilot.md) |
| **Step 5** | **Patient Rehabilitation Care Pathways & Drip Sequences** | Drip WhatsApp/SMS treatment follow-ups, exercise video assignments, CSAT/NPS patient surveys | [prod_launch_step5_patient_care_pathways.md](file:///lamp/www/naxielly/docs/plans/prod_launch_step5_patient_care_pathways.md) |
| **Step 6** | **Production Hardening, Rate Limiting & Zero-Downtime Operations** | Route rate limiting, CSRF/session fixation hardening, DB backup cron automation & error monitoring | [prod_launch_step6_prod_hardening_backups.md](file:///lamp/www/naxielly/docs/plans/prod_launch_step6_prod_hardening_backups.md) |

---

## 🛠 Quality & Verification Standard

1. **Evidence Before Claims**: No step is marked complete without CLI automated test output, HTTP response verification, and database query logs.
2. **Backwards Compatibility**: Existing `appointments`, `expedientes`, `users`, and `cfdi_invoices` tables remain untouched in legacy behavior; new columns default to backwards-compatible fallbacks.
3. **Traceability**: All execution steps generate CLI verification scripts (`test_prod_step*.php`) and structured `error_log()` audit entries.
