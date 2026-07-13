# Step 2: Design Token Consolidation

**Status**: ✅ DONE  
**Depends on**: Step 1 ✅  
**Impact**: 🔴 Critical | **Effort**: ~3 hours

---

## Problem

Three competing visual identity layers:

| Layer | Location | Primary Color | Font Stack |
|-------|----------|---------------|------------|
| Body | `style.css` L1-4 | — | `Segoe UI, Tahoma, Geneva` |
| Shell V1 | `style.css` L36-47 | `#4185d8` blue | `Roboto` |
| Shell V2 | `style.css` L756-761 | `#00a29a` teal | (inherits) |
| Wizard | `index.php` L381-395 (inline `<style>`) | `#E8A0AC` pink | `Outfit`, `Inter` (NEVER LOADED) |

## Changes Required

### Task 2.1 — Add canonical `:root` variable block to `css/style.css`

**File**: `css/style.css`  
**Action**: INSERT at line 1 (before `body {`), the following:

```css
/* =============================================
   DESIGN TOKENS — Single source of truth
   ============================================= */
:root {
    /* Brand Colors */
    --brand-primary: #00a29a;
    --brand-primary-light: #e7fbf7;
    --brand-primary-dark: #007d77;
    --brand-accent: #E8A0AC;
    --brand-accent-glow: rgba(232, 160, 172, 0.22);

    /* Semantic Colors */
    --color-success: #7FB8A6;
    --color-success-glow: rgba(127, 184, 166, 0.15);
    --color-warning: #E5A87B;
    --color-warning-bg: #fff7e7;
    --color-danger: #D66F7C;
    --color-danger-bg: #fdebec;
    --color-info: #4185d8;

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

    /* Radii */
    --radius-sm: 6px;
    --radius-md: 8px;
    --radius-lg: 12px;

    /* Shadows */
    --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.04);
    --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
}
```

### Task 2.2 — Update `body` and shell selectors

**File**: `css/style.css`

**Change L1-4** (body): Replace font stack:
```diff
 body {
-    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
+    font-family: var(--font-body);
     background-color: #f8f9fa;
 }
```

**Change L36-47** (.crm-calendar-shell first block): Remove inline variable declarations, keep only structural props:
```diff
 .crm-calendar-shell {
-    --primary: #4185d8;
-    --primary-light: #e6f2ff;
-    --secondary-text: #5f6368;
-    --border: #dadce0;
-    font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
+    font-family: var(--font-body);
     display: flex;
     height: 100vh;
     width: 100%;
     overflow: hidden;
-    color: #202124;
+    color: var(--text-primary);
 }
```

**Change L756-761** (.crm-calendar-shell override block): Remove variable overrides:
```diff
 .crm-calendar-shell {
-    --primary: #00a29a;
-    --primary-light: #e7fbf7;
-    --border: #edf1f6;
     background: #fff;
 }
```

### Task 2.3 — Replace all `var(--primary)` usages in `style.css`

Run this find/replace across `css/style.css`:

| Find | Replace |
|------|---------|
| `var(--primary)` | `var(--brand-primary)` |
| `var(--primary-light)` | `var(--brand-primary-light)` |
| `var(--secondary-text)` | `var(--text-secondary)` |
| `var(--border)` | `var(--border-default)` |

Current usage count: 15 instances of `var(--` in style.css.

### Task 2.4 — Load Outfit + Inter fonts in `header.php`

**File**: `app/views/inc/header.php`  
**Action**: Replace the Google Fonts `<link>` (L7):

```diff
-    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
+    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
```

### Task 2.5 — Extract wizard `<style>` block from `index.php` to `style.css`

**Source**: `app/views/dashboard/index.php` L381-718 (the `<style>...</style>` block inside the patients section)  
**Target**: Append to bottom of `css/style.css`  

Steps:
1. Copy lines 382-717 from `index.php` (the CSS content between `<style>` and `</style>` tags)
2. Append to bottom of `css/style.css`
3. Delete the entire `<style>...</style>` block (L381-718) from `index.php`
4. Remove the duplicate `:root` declaration from the copied CSS (since it's now in the canonical block at the top of style.css). Keep only the wizard-specific class declarations.

**Critical**: The `:root` block inside the wizard style (L383-395 approx) declares `--brand-pink`, `--brand-green-success`, `--warning-ochre`, etc. These are NOW in the canonical `:root` as `--brand-accent`, `--color-success`, `--color-warning`. Update any `var(--brand-pink)` references to `var(--brand-accent)` etc in the moved CSS.

### Task 2.6 — Reduce the worst inline styles (target: <80)

**File**: `app/views/dashboard/index.php`  
Extract these patterns to CSS classes in `style.css`:

| Pattern | Occurrences | New CSS Class |
|---------|-------------|---------------|
| Flash message bar (L86) | 1 | `.flash-bar` |
| Wizard `<h4>` headers (`margin-bottom: 12px; border-bottom...`) | ~5 | `.wizard-section-title` |
| `display: grid; grid-template-columns: 1fr 1fr; gap: 20px` (L832) | ~3 | `.form-grid-2` (already exists, use it) |
| IMC gauge inline styles (L870-886) | 1 block | Move to `.imc-gauge-container` styles |
| Autosave status bar (L722-726) | 2 | `.autosave-status-bar`, `.offline-banner` |

## Verification

```bash
# Syntax
php -l app/views/inc/header.php
php -l app/views/dashboard/index.php

# No duplicate :root in index.php
grep ':root' app/views/dashboard/index.php  # Should return 0

# No <style> in index.php
grep '<style>' app/views/dashboard/index.php  # Should return 0

# Only one --brand-primary declaration
grep -c '\-\-brand-primary:' css/style.css  # Should return 1

# Fonts loaded
grep 'Outfit' app/views/inc/header.php  # Should match
grep 'Inter' app/views/inc/header.php   # Should match

# No old variable names
grep 'var(--primary)' css/style.css      # Should return 0

# Inline style count reduced
grep -c 'style="' app/views/dashboard/index.php  # Target: < 80 (was 131)

# Tests pass
php test_crud.php && php test_patient_file.php && php test_wizard_logic.php
```

## Commit

```bash
git add css/style.css app/views/inc/header.php app/views/dashboard/index.php
git commit -m "fix(ux): step-02 consolidate design tokens, load fonts, extract wizard CSS"
git push origin feature/docs-and-branding
```
