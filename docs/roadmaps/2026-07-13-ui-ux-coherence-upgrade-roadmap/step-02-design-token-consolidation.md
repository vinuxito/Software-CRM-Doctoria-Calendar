# Step 2: Design Token Consolidation

**Category**: UX / Architecture  
**Impact**: 🔴 Critical  
**Complexity**: Medium (CSS refactor, no logic changes)  
**Estimated effort**: 3-4 hours

---

## Why It Matters Now

The app currently has **three competing visual identity layers**, each declaring its own colors and fonts:

| Layer | File | Primary Color | Font |
|-------|------|---------------|------|
| Body default | `style.css` L1-4 | N/A | `Segoe UI, Tahoma, Geneva` |
| Dashboard shell (1st declaration) | `style.css` L36-47 | `#4185d8` (blue) | `Roboto` |
| Dashboard shell (2nd declaration) | `style.css` L756-760 | `#00a29a` (teal) | (inherits Roboto) |
| Clinical wizard | `index.php` L381-395 (inline `<style>`) | `#E8A0AC` (pink) | `Outfit`, `Inter` |

**Problems**:
- The first `--primary: #4185d8` is dead code — overridden 700 lines later
- `Outfit` and `Inter` fonts are declared in CSS variables (`--font-heading`, `--font-body`) but **never loaded** — no `<link>` or `@import` exists for them
- `Segoe UI` on `body` is overridden by `Roboto` on `.crm-calendar-shell`, so it only applies to auth pages (which already use Bootstrap's sans-serif default)
- The wizard's `<style>` block inside the PHP conditional means its `:root` variables only exist when `$section === 'patients'`
- 131 inline `style=""` attributes override class-based styling unpredictably

This means: the calendar is teal, the wizard is pink, auth pages are Bootstrap gray, and nothing feels intentional.

## What Exactly Should Be Done

### 1. Define one canonical `:root` in `style.css`

```css
:root {
    /* Brand */
    --brand-primary: #00a29a;
    --brand-primary-light: #e7fbf7;
    --brand-accent: #E8A0AC;
    --brand-accent-glow: rgba(232, 160, 172, 0.22);
    
    /* Semantic */
    --color-success: #7FB8A6;
    --color-success-glow: rgba(127, 184, 166, 0.15);
    --color-warning: #E5A87B;
    --color-danger: #D66F7C;
    
    /* Text */
    --text-primary: #2D3748;
    --text-secondary: #718096;
    --text-muted: #a0aec0;
    
    /* Surfaces */
    --bg-page: #f8f9fa;
    --bg-card: #ffffff;
    --bg-input: #F7FAFC;
    --border-default: #E2E8F0;
    --border-light: #edf1f6;
    
    /* Typography */
    --font-heading: 'Outfit', 'Roboto', system-ui, sans-serif;
    --font-body: 'Inter', 'Roboto', system-ui, sans-serif;
    
    /* Spacing (optional, for future) */
    --radius-sm: 6px;
    --radius-md: 8px;
    --radius-lg: 12px;
}
```

### 2. Load missing fonts in `header.php`

Add `Outfit` and `Inter` to the Google Fonts link:
```html
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
```

### 3. Remove the duplicate variable declarations from `style.css`

- Delete L36-47 first `--primary` block (dead code)
- Delete L756-760 second override block
- Replace all `var(--primary)` references with `var(--brand-primary)`
- Replace all `var(--primary-light)` with `var(--brand-primary-light)`
- Replace all `var(--secondary-text)` with `var(--text-secondary)`
- Replace all `var(--border)` with `var(--border-default)`

### 4. Extract the wizard's `<style>` block from `index.php` into `style.css`

Move the ~340-line `<style>` block (L381-718) from `app/views/dashboard/index.php` into the bottom of `css/style.css`. Remove the inline `<style>` tags. Delete the duplicate `:root` declaration (now in the canonical block).

### 5. Eliminate the highest-impact inline styles

Priority targets (from 131 total):
- Flash message bar (L86-89) — extract to `.flash-bar` class
- Wizard `<h4>` section headers — extract to `.wizard-section-title` class
- Antecedentes grid layout (L832) — already has `.form-grid-2`, use it
- IMC gauge container (L870) — extract to `.imc-gauge-container` class (already named)
- Autosave/offline banners (L722-726) — extract to `.autosave-status`, `.offline-banner` classes

Target: reduce inline styles from 131 to under 30 in first pass.

## What Existing Work It Builds On

- The wizard's variable naming is already well-thought-out (`--brand-pink`, `--slate-text`, `--font-heading`)
- `style.css` already uses CSS variables — just inconsistently
- The teal `#00a29a` and pink `#E8A0AC` together form a complementary palette that works

## What Risks It Avoids

- **Silent font fallbacks**: Outfit/Inter being declared but unloaded means the browser falls back silently to system fonts, creating subtle visual inconsistency that's hard to debug
- **Cascade confusion**: Three variable systems means any developer (human or AI) changing a color variable can't predict what it actually affects
- **Regression from style block location**: The inline `<style>` in the PHP conditional means wizard CSS only loads when `$section === 'patients'`, but the modal overlay class names are shared — potential style leaking or missing

## Expected Payoff

One font stack. One color palette. One source of truth for design tokens. Every section of the app uses the same visual vocabulary. The wizard's polish extends to the whole app instead of being an isolated island.

## Definition of Done (Testable Acceptance Criteria)

1. `grep -c 'style="' app/views/dashboard/index.php` returns < 30 (down from 131)
2. `grep '<style>' app/views/dashboard/index.php` returns zero matches (all CSS moved to style.css)
3. `grep -c '\-\-primary:' css/style.css` returns exactly 1 (one canonical declaration)
4. `grep 'Outfit' app/views/inc/header.php` returns a match (font loaded)
5. `grep 'Inter' app/views/inc/header.php` returns a match (font loaded)
6. All 3 test suites pass (`test_crud.php`, `test_patient_file.php`, `test_wizard_logic.php`)
7. Manual check: login page, calendar, wizard, and settings all use the same font rendering
8. Manual check: no "flash of unstyled text" when opening the wizard modal
