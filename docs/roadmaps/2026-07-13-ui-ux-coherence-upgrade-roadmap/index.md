# 🩺 Doctoria CRM — UI/UX Coherence Upgrade Roadmap

**Date**: 2026-07-13  
**Author**: Filemón Coder (Antigravity)  
**Project**: `/lamp/www/naxielly/` — Doctoria CRM & Calendar  
**Branch**: `feature/docs-and-branding` (only branch; rename to `main` recommended)

---

## Current-State Assessment

### Strongest Areas (with evidence)

1. **Clinical Record Wizard is genuinely sophisticated.**  
   The 5-step expediente wizard (~1,077 lines of JS) has autosave with visual status, offline detection, BMI gauge, EVA pain slider, Tinetti scoring with SVG ring, contraindication warnings, and localStorage draft persistence. This is real clinical software, not a toy form. Evidence: `test_wizard_logic.php` passes, `Expediente.php` model is 17KB with 8 database tables.

2. **Role-based access control works and is consistent.**  
   The sidebar conditionally shows Patients (admin/medico) and Users (admin only). The controller (`Dashboard.php`, L202-308) checks `$_SESSION['user_role']` before serving data. Soft-delete prevents data loss. Evidence: `test_crud.php` verifies collision detection and soft-delete.

3. **The calendar integration is functional and polished.**  
   FullCalendar 5.11 with Spanish locale, appointment CRUD via modal, drag-select to create events, click-to-edit. The `Appointment.php` model (7.5KB) handles full lifecycle. The mini-cal sidebar and controls panel give a Google Calendar-like layout.

4. **The chat module works end-to-end.**  
   Real-time-ready messaging with sender/receiver routing, chat contact list, WhatsApp-style bubbles, empty-state handling ("Selecciona un chat para comenzar"). The `Chat.php` model covers `sendMessage`, `getMessages`, `getContacts`.

5. **Test infrastructure exists and passes.**  
   4 test files covering CRUD, patient files, and wizard logic. Not comprehensive, but real. All pass cleanly on PHP 8.3.

### Weak Spots / Blind Spots (prioritized by user impact)

1. **Language schizophrenia.**  
   Login page: "Login", "Password:", "Please fill in your credentials", "No account? Register". Dashboard: "Agendar cita", "Guardar Borrador", "Expediente Clínico". The register form mixes both: "Name:", "Teléfono:", "Role:". `<html lang="en">` on a Spanish-target app. A first-time clinic user sees English auth → Spanish dashboard and wonders if they're on the right site.

2. **No design system — three competing visual layers.**  
   - `style.css` declares `--primary: #4185d8` (blue) then overrides to `--primary: #00a29a` (teal) 700 lines later.  
   - The wizard declares its own `:root` with brand-pink `#E8A0AC`, `--font-heading: 'Outfit'`, `--font-body: 'Inter'` — but **Outfit and Inter are never loaded** (`<link>` only loads Roboto).  
   - Body uses `Segoe UI`, dashboard shell uses `Roboto`. Three font stacks fighting.  
   - 131 inline `style=""` attributes override everything unpredictably.  

3. **The 157KB monolith template.**  
   `dashboard/index.php` is 2,817 lines containing ALL sections (8 panels), ALL inline CSS (~340 lines of `<style>`), and ALL inline JS (~1,400 lines across 4 `<script>` blocks). This makes every change risky, every section review slow, and caching impossible. `main.js` is 2 lines (`console.log('CRM Loaded')`).

4. **Zero mobile support below 900px.**  
   Only 3 CSS breakpoints exist: 1200px, 1100px, 900px. Below 900px the sidebar and search just vanish. No phone layout. For a medical app where a therapist might check a patient record on their phone between sessions — this is a gap.

5. **No empty states, no loading skeletons.**  
   If a doctor has no appointments, the calendar renders empty with no guidance. Empty patient list = blank table. Empty reports table = empty `<tbody>`. No "You don't have any patients yet" messaging anywhere except chat.

6. **Registration lets anyone pick "Médico" role.**  
   The register form exposes a `<select>` with Cliente/Médico options. Any visitor can self-register as a doctor. No admin approval flow.

7. **Auth views have zero branding.**  
   Login and register use raw Bootstrap card on gray background. No logo, no brand colors, no connection to the polished dashboard. A user arriving at login sees a generic CRUD tutorial page.

### Product Direction (from repo/docs only)

Doctoria CRM is a physiotherapy clinic management platform for **Naxielly Franco Ascencio's practice**. The core product is the clinical intake wizard (based on a real PDF form she uses), combined with appointment scheduling and basic team coordination. The brand palette is dusty pink `#E8A0AC` (from the physical form's design). The product targets a single practice first, with API integration hooks (Twilio, WhatsApp/Evolution, n8n) suggesting future multi-channel patient communication. The README markets it generically, but the docs reveal it's built around one physiotherapist's specific workflow.

### Momentum Check

**Just finished**: Bug fixes (login input type, PHP deprecation, broken users view), MCP tooling setup, verification testing. The build is stable and verified.

**Next logical layer**: The app works functionally but **looks and feels like three different apps glued together** — a Bootstrap tutorial (auth), a Google Calendar clone (dashboard shell), and a boutique clinical form (wizard). The next layer is making it feel like **one coherent product** that a real clinic could trust.

---

## 7-Step Roadmap

| Step | Title | Category | Impact |
|------|-------|----------|--------|
| 1 | [Unified Language Pass](step-01-unified-language-pass.md) | UX | 🔴 Critical |
| 2 | [Design Token Consolidation](step-02-design-token-consolidation.md) | UX / Architecture | 🔴 Critical |
| 3 | [Auth Views Rebrand](step-03-auth-views-rebrand.md) | UX / Product | 🟠 High |
| 4 | [Empty States & User Feedback](step-04-empty-states-user-feedback.md) | UX / Product | 🟠 High |
| 5 | [Template Decomposition](step-05-template-decomposition.md) | Architecture / DX | 🟡 Medium |
| 6 | [Mobile Responsive Pass](step-06-mobile-responsive-pass.md) | UX / Product | 🟡 Medium |
| 7 | [Registration Hardening & Role Guard](step-07-registration-hardening.md) | Security / Product | 🟡 Medium |

---

## A. Full 7-Step Roadmap

See individual step files linked above.

---

## B. The 3 Most Urgent Upgrades

| # | Step | Complexity | Impact | Why Now |
|---|------|-----------|--------|---------|
| 1 | **Unified Language Pass** | Low (text changes only) | High | A user who sees English auth then Spanish dashboard will not trust the app. This is a 1-hour fix. |
| 2 | **Design Token Consolidation** | Medium (CSS refactor) | High | Three competing color systems and font stacks cause visual incoherence across every section. Fonts that are declared but never loaded cause silent rendering fallbacks. |
| 3 | **Auth Views Rebrand** | Low-Medium (HTML/CSS) | High | Login is the first thing users see. Right now it's a raw Bootstrap card with no logo, no brand, no connection to the teal/pink dashboard. First impressions determine trust. |

---

## C. The 2 Biggest Long-Term Strategic Upgrades

| # | Step | Why Strategic |
|---|------|---------------|
| 1 | **Template Decomposition** (Step 5) | The 157KB monolith is the #1 maintenance risk. Every bug fix touches a 2,817-line file. Extracting sections into partials enables caching, parallel development, and code review. This unlocks the ability to safely evolve individual features without regression risk. |
| 2 | **Mobile Responsive Pass** (Step 6) | A physiotherapist checking patient records between sessions will use their phone. No mobile layout means no field usage. This is the gate between "demo app" and "daily-use tool." |

---

## D. What NOT To Do Yet (3-5 items)

1. **Don't add i18n/translation framework.** Pick one language (Spanish) and commit. The user base is a Mexican physiotherapy clinic, not a global SaaS. An i18n framework adds complexity for zero current value.

2. **Don't rewrite the MVC framework.** The custom Core/Controller/Database stack works, tests pass, routing is predictable. Migrating to Laravel or a framework would cost weeks and break all existing tests for no user-visible gain.

3. **Don't add new feature modules** (reporting dashboards, PDF export, analytics). The current features aren't coherent yet. Adding more surface area before fixing language, branding, and empty states makes the incoherence worse.

4. **Don't implement real-time WebSocket chat.** The current polling/POST chat works. Real-time requires a persistent connection server (Node, Ratchet), deployment complexity, and infrastructure. Not worth it until the core UX is solid.

5. **Don't touch the clinical wizard internals.** The 5-step wizard is the most polished and tested module. Its inline CSS/JS is complex but working. Extract it in Step 5, but don't refactor its logic until Steps 1-4 are done.

---

## E. Recommended Execution Order

### 1. Quick Win / Coherence Pass
- **Step 1: Unified Language Pass** — Translate all English strings in auth views and navbar to Spanish. Change `<html lang="en">` to `lang="es"`. ~30 string changes, zero logic risk.

### 2. Flow Hardening
- **Step 2: Design Token Consolidation** — Merge the 3 competing variable systems into one `style.css` block. Load Outfit + Inter fonts. Remove dead CSS variable declarations. Move inline `<style>` block from dashboard into `style.css`.
- **Step 3: Auth Views Rebrand** — Add logo, brand colors, and professional styling to login/register. Connect them visually to the dashboard.
- **Step 4: Empty States & User Feedback** — Add empty-state messages to calendar, patients table, doctors grid, reports. Add loading skeletons for async operations.

### 3. Testing
- Run `php test_crud.php`, `php test_patient_file.php`, `php test_wizard_logic.php` after each step.
- Add PHP syntax linting: `find app/ -name '*.php' -exec php -l {} \;`
- Manual browser check: login → each section → verify rendering.

### 4. Documentation / Memory Update
- Update `docs/memories/session-2026-07-13-ui-ux-coherence.md` with what changed.
- Update README.md with current feature status and verification results.

### 5. Commit Strategy
- One commit per step: `fix(ux): step-01 unify language to Spanish`
- All on current branch (or renamed to `main`).
- Push after each verified step.
- Tag after all 7 steps: `v0.3.0-coherence`

---

> **The goal is not "more app."**  
> The goal is that a user opens the app, understands where they are, knows what to do next, trusts the result, and completes the main flows without the builder standing next to them.
