# UI/UX Coherence Upgrade — Implementation Plans

**Created**: 2026-07-13  
**Project**: Doctoria CRM (`/lamp/www/naxielly/`)  
**Goal**: Take the app from "working" to "coherent, easy, trustworthy, and usable by real users without help."

---

## Status

| Step | Title | Status | Commit |
|------|-------|--------|--------|
| 1 | [Unified Language Pass](step-01-unified-language-pass.md) | ✅ DONE | `05a587a` |
| 2 | [Design Token Consolidation](step-02-design-token-consolidation.md) | ⬜ TODO | — |
| 3 | [Auth Views Rebrand](step-03-auth-views-rebrand.md) | ⬜ TODO | — |
| 4 | [Empty States & User Feedback](step-04-empty-states-user-feedback.md) | ⬜ TODO | — |
| 5 | [Template Decomposition](step-05-template-decomposition.md) | ⬜ TODO | — |
| 6 | [Mobile Responsive Pass](step-06-mobile-responsive-pass.md) | ⬜ TODO | — |
| 7 | [Registration Hardening & Role Guard](step-07-registration-hardening.md) | ⬜ TODO | — |

---

## Execution Rules

1. **Sequential**: Each step builds on the previous. Execute in order.
2. **Incremental**: Each step ends with a working app. Verify, commit, push before starting the next.
3. **One commit per step**: `fix(ux): step-0N <short description>`
4. **Verify after each step**: Run `php test_crud.php && php test_patient_file.php && php test_wizard_logic.php` + PHP syntax lint on all changed files.
5. **No scope creep**: Each plan says exactly what to change. Don't add extras.

## Architecture Reference (Current)

```
app/views/dashboard/index.php  (2,817 lines — THE monolith)
├── L1-22:       Sidebar navigation
├── L24-77:      Calendar aside panel (left sidebar, only for calendar section)
├── L79-1392:    Main view (all section HTML via if/elseif/else)
│   ├── L91-146:     Calendar HTML
│   ├── L147-176:    Doctors HTML
│   ├── L177-226:    Chat HTML
│   ├── L227-300:    Settings HTML
│   ├── L301-325:    Profile HTML
│   ├── L326-1138:   Patients HTML (includes inline <style> L381-718)
│   ├── L1139-1220:  Users HTML
│   └── L1221-1392:  Panel HTML (else/default)
├── L1396-1601:  Calendar JS (<script> block)
├── L1602-1665:  Panel JS (<script> block)
├── L1666-1734:  Users JS (<script> block)
└── L1735-2815:  Patients JS (<script> block)

css/style.css  (1,603 lines)
├── L1-4:        Body base (Segoe UI)
├── L36-47:      Shell variables V1 (--primary: #4185d8) ← DEAD CODE
├── L49-726:     Component styles
├── L727-754:    Media queries (1200px, 900px)
├── L756-761:    Shell variables V2 (--primary: #00a29a) ← OVERRIDE
├── L762-1594:   More component styles
└── L1595-1603:  Media query (1100px)

js/main.js  (2 lines — console.log stub)
```

## Dependency Graph

```
Step 1 (Language) ✅ DONE
  └─→ Step 2 (Design Tokens)
       └─→ Step 3 (Auth Rebrand)    ← needs tokens from Step 2
            └─→ Step 4 (Empty States) ← needs styles from Step 2
                 └─→ Step 5 (Template Decomposition) ← needs clean CSS from Step 2
                      └─→ Step 6 (Mobile Responsive) ← needs decomposed templates
                           └─→ Step 7 (Registration Hardening) ← needs clean auth from Step 3
```
