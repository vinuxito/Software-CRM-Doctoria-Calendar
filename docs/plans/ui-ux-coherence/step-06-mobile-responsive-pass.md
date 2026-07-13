# Step 6: Mobile Responsive Pass

**Status**: ⬜ TODO  
**Depends on**: Step 5 ✅ (needs decomposed templates for targeted CSS changes)  
**Impact**: 🟡 Medium | **Effort**: ~4 hours

---

## Problem

3 CSS breakpoints exist, all max-width:

| Line | Breakpoint | Effect |
|------|-----------|--------|
| 727 | `≤ 1200px` | Controls panel → 220px, search → 180px |
| 736 | `≤ 900px` | Controls panel hidden, search hidden, grids → 1fr |
| 1595 | `≤ 1100px` | Chat reference → 1fr, controls hidden |

**Below 900px** (all phones): nothing. The 64px sidebar persists. Tables clip. Modals overflow. No phone layout exists.

## Changes Required

### Task 6.1 — Add tablet breakpoint (≤ 768px) to `style.css`

**File**: `css/style.css`  
**Action**: Append after existing media queries:

```css
/* =============================================
   RESPONSIVE — Tablet (≤ 768px)
   ============================================= */
@media (max-width: 768px) {
    .doctor-grid {
        grid-template-columns: 1fr;
    }
    
    .panel-layout {
        grid-template-columns: 1fr;
    }
    
    .panel-left,
    .panel-right {
        padding: 12px;
    }
    
    .panel-kpi {
        font-size: 1.5rem;
    }
    
    .settings-wrap {
        grid-template-columns: 1fr;
    }
    
    .calendar-modal-card {
        max-width: 100%;
        width: 100%;
        margin: 0 10px;
        max-height: 85vh;
    }
    
    .wizard-steps-progress {
        font-size: 11px;
        gap: 4px;
    }
    
    .form-grid-2,
    .form-grid-3 {
        grid-template-columns: 1fr;
    }
}
```

### Task 6.2 — Add phone breakpoint (≤ 600px) to `style.css`

**File**: `css/style.css`  
**Action**: Append:

```css
/* =============================================
   RESPONSIVE — Phone (≤ 600px)
   ============================================= */
@media (max-width: 600px) {
    /* Sidebar → Bottom tab bar */
    .icon-sidebar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 56px;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        border-right: none;
        border-top: 1px solid var(--border-default);
        z-index: 100;
        padding: 0 4px;
        background: var(--bg-card);
        box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.06);
    }
    
    .icon-sidebar .brand-icon {
        display: none;
    }
    
    .icon-sidebar .bottom-actions {
        margin-top: 0;
        flex-direction: row;
        gap: 0;
    }
    
    .nav-icon {
        margin-bottom: 0;
    }
    
    /* Main view adjustments */
    .crm-calendar-shell {
        flex-direction: column;
    }
    
    .main-view {
        margin-left: 0;
        padding-bottom: 64px; /* Space for bottom nav */
    }
    
    /* Toolbar stacks */
    .toolbar {
        flex-wrap: wrap;
        padding: 8px 12px;
    }
    
    .tol-left {
        width: 100%;
    }
    
    .tol-right {
        width: 100%;
        margin-top: 8px;
        justify-content: flex-start;
    }
    
    .date-title span {
        font-size: 16px;
    }
    
    /* Tables scroll horizontally */
    .crud-table,
    .report-table {
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Cards and panels */
    .settings-card {
        padding: 12px;
    }
    
    .chat-layout {
        grid-template-columns: 1fr;
    }
    
    .chat-list {
        max-height: 200px;
    }
    
    /* Profile */
    .profile-card {
        padding: 20px 16px;
    }
    
    .profile-grid {
        grid-template-columns: 1fr;
    }
    
    /* Calendar modal fills screen */
    .calendar-modal-overlay {
        padding: 0;
        align-items: flex-end;
    }
    
    .calendar-modal-card {
        max-width: 100%;
        width: 100%;
        max-height: 92vh;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        margin: 0;
    }
    
    /* Wizard modal full-screen on mobile */
    .calendar-modal-card[style*="max-width: 950px"] {
        max-width: 100% !important;
        width: 100% !important;
    }
    
    /* Form inputs min size to prevent iOS zoom */
    input, select, textarea {
        font-size: 16px;
    }
    
    /* Auth pages */
    .auth-container {
        padding: 0 8px;
    }
    
    .auth-card {
        padding: 24px 20px;
    }
}
```

### Task 6.3 — Add small phone breakpoint (≤ 400px) to `style.css`

**File**: `css/style.css`  
**Action**: Append:

```css
/* =============================================
   RESPONSIVE — Small Phone (≤ 400px)
   ============================================= */
@media (max-width: 400px) {
    .wizard-steps-progress {
        overflow-x: auto;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 4px;
    }
    
    .wizard-step-indicator {
        white-space: nowrap;
        font-size: 10px;
        padding: 4px 8px;
    }
    
    .calendar-modal-head h3 {
        font-size: 15px;
    }
    
    .pending-actions {
        flex-direction: column;
        gap: 4px;
    }
    
    .btn-configurar {
        font-size: 12px;
        padding: 8px 10px;
    }
}
```

### Task 6.4 — Ensure FullCalendar respects mobile

FullCalendar has built-in responsive features, but the `crm-fc` container may need:

**File**: `css/style.css`  
**Action**: Add inside the `≤ 600px` media query:

```css
    /* FullCalendar mobile */
    .crm-fc {
        font-size: 12px;
    }
    
    .fc-header-toolbar {
        flex-wrap: wrap;
        gap: 4px;
    }
    
    .fc .fc-toolbar-title {
        font-size: 1rem;
    }
```

### Task 6.5 — Verify viewport meta exists

**File**: `app/views/inc/header.php`  
**Check**: Line 5 should have:
```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```
Already present ✅ — no change needed.

## Verification

```bash
# Breakpoint count
grep -c '@media' css/style.css          # Should be >= 6 (was 3, added 3)

# New breakpoints present
grep '@media.*600' css/style.css        # Should match
grep '@media.*768' css/style.css        # Should match
grep '@media.*400' css/style.css        # Should match

# No overflow: hidden on containers
grep -n 'overflow: hidden' css/style.css | grep -v 'crm-calendar-shell\|select'  # Review manually

# Syntax
php -l app/views/dashboard/index.php

# Tests (CSS changes don't affect PHP tests, but verify nothing broke)
php test_crud.php && php test_patient_file.php && php test_wizard_logic.php

# Manual check (use browser DevTools responsive mode):
# 375px (iPhone SE): sidebar = bottom bar, tables scroll, modals full-width
# 768px (iPad): grids = 1 column, forms = 1 column
# 1024px (desktop): existing layout preserved
```

## Commit

```bash
git add css/style.css
git commit -m "fix(ux): step-06 add mobile responsive layouts for phone and tablet"
git push origin feature/docs-and-branding
```
