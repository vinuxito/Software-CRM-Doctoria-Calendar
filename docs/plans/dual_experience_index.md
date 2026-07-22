# 🖥️📱 Doctoria CRM — Dual-Experience Layer Master Index

> **Core Philosophy**: *"Same engine. Two intentional experiences. Desktop = power. Mobile = comfort."*

This index connects 6 detailed, sequential design and execution blueprints for Doctoria CRM's **Dual-Experience Layer**. It preserves the proven PHP/MySQL core engine (auth, permissions, clinical records, CFDI invoicing, resource optimization, WhatsApp engine) while surfacing two purpose-built front-end experiences:

1. **Desktop Workbench**: High-density, keyboard-driven (`Ctrl+K`, quick hotkeys), multi-panel split view for specialists operating at a desk.
2. **Mobile Couch Remote**: Simple, thumb-first, 1-handed ergonomics with a sticky bottom navigation bar and 1-tap action sheets for specialists on the move.

---

## 📌 Dual-Experience Step Index

| Step | Blueprint Title | Target Experience | Target Plan File |
|------|-----------------|-------------------|------------------|
| **Step 1** | **Desktop Workbench High-Density Layout & Multi-Panel Shell** | Desktop (Power) | [dual_exp_step1_desktop_workbench_shell.md](file:///lamp/www/naxielly/docs/plans/dual_exp_step1_desktop_workbench_shell.md) |
| **Step 2** | **Mobile Couch Remote Shell & Thumb-Zone Action Sheets** | Mobile (Comfort) | [dual_exp_step2_mobile_remote_shell.md](file:///lamp/www/naxielly/docs/plans/dual_exp_step2_mobile_remote_shell.md) |
| **Step 3** | **Desktop Power Calendar Timeline & Drag-and-Reschedule Grid** | Desktop (Power) | [dual_exp_step3_desktop_power_calendar.md](file:///lamp/www/naxielly/docs/plans/dual_exp_step3_desktop_power_calendar.md) |
| **Step 4** | **Mobile Express Patient Check-In & 1-Tap WhatsApp Dispatch** | Mobile (Comfort) | [dual_exp_step4_mobile_express_checkin.md](file:///lamp/default/docs/plans/dual_exp_step4_mobile_express_checkin.md) |
| **Step 5** | **Adaptive Anatomical Body Map (Desktop Silhouette vs Mobile Touch Zones)** | Both (Adaptive) | [dual_exp_step5_adaptive_body_map.md](file:///lamp/www/naxielly/docs/plans/dual_exp_step5_adaptive_body_map.md) |
| **Step 6** | **PWA Manifest, Service Worker & Offline Sync Queue** | Mobile + Desktop | [dual_exp_step6_offline_sync_pwa.md](file:///lamp/www/naxielly/docs/plans/dual_exp_step6_offline_sync_pwa.md) |

---

## 🧭 Core Architectural Principles

- **Engine Preserved**: Zero changes to core database tables, business logic, or backend endpoints.
- **Adaptive Surface Detection**: Media queries and CSS container queries (`@container`) dynamically adapt components between Workbench Mode (`min-width: 1024px`) and Remote Mode (`max-width: 1023px`).
- **Zero Friction Shift**: Specialists can start a patient session on their desktop workbench, walk into a treatment room with a phone, and seamlessly continue without losing state.
