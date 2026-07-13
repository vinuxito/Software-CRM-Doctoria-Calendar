# Step 6: Mobile Responsive Pass

**Category**: UX / Product  
**Impact**: 🟡 Medium  
**Complexity**: Medium (CSS additions, no backend changes)  
**Estimated effort**: 4-5 hours

---

## Why It Matters Now

The app currently has **3 CSS breakpoints**:

| Breakpoint | What Changes |
|-----------|-------------|
| `≤ 1200px` | Controls panel shrinks to 220px, search box shrinks |
| `≤ 1100px` | Chat layout goes single-column |
| `≤ 900px` | Controls panel **hidden**, search **hidden**, most grids collapse to 1-column |

**Below 900px (phones): nothing.** The 64px icon sidebar persists. The toolbar doesn't stack. Tables don't scroll. The wizard modal is 95% width of an already-cramped viewport. Form grids don't collapse.

**Why this matters for a physiotherapy clinic**: A therapist between sessions will check their next appointment on their phone. A patient might receive a link to their profile. The clinic owner might approve a pending appointment while commuting. If the app doesn't work on mobile, it doesn't work in the field.

## What Exactly Should Be Done

### 1. Add phone breakpoints (≤ 600px)

```css
@media (max-width: 600px) {
    /* Sidebar becomes a bottom tab bar */
    .icon-sidebar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 56px;
        flex-direction: row;
        justify-content: space-around;
        border-right: none;
        border-top: 1px solid var(--border-default);
        z-index: 100;
        padding: 0;
    }
    .icon-sidebar .brand-icon { display: none; }
    .icon-sidebar .bottom-actions { margin-top: 0; flex-direction: row; }
    
    /* Main view fills screen */
    .main-view { margin-left: 0; padding-bottom: 64px; }
    
    /* Toolbar stacks */
    .toolbar { flex-wrap: wrap; }
    .tol-right { width: 100%; margin-top: 8px; }
    
    /* Tables scroll horizontally */
    .crud-table, .report-table { display: block; overflow-x: auto; }
    
    /* Form grids collapse */
    .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
    
    /* Modal respects mobile viewport */
    .calendar-modal-card { max-width: 100%; width: 100%; max-height: 90vh; border-radius: 12px 12px 0 0; }
}
```

### 2. Add tablet breakpoint (≤ 768px)

Between the existing 900px and the new 600px:
- Doctor grid: 2 columns → 1 column
- Panel KPI cards: stack vertically
- Chat: full-width layout
- Settings API cards: single column

### 3. Make the wizard modal mobile-friendly

The wizard is the most complex UI. On mobile:
- Step indicators should be scrollable horizontal chips (already `overflow-x: auto`)
- Form grids must collapse to single column
- Navigation buttons should be fixed at the bottom of the modal
- Touch targets are already 44px (good — this was designed for tablets)

### 4. Ensure login/register work on mobile

After Step 3 (Auth Rebrand), ensure:
- Auth card max-width respects viewport
- No horizontal overflow on 320px screens
- Input font size ≥ 16px (prevents iOS auto-zoom)

### 5. Add viewport meta (verify)

`header.php` already has `<meta name="viewport" content="width=device-width, initial-scale=1.0">` ✅ — no change needed.

## What Existing Work It Builds On

- The 3 existing breakpoints (1200, 1100, 900px) provide the desktop→tablet transition
- The wizard already uses `overflow-x: auto` on step indicators and `overflow-y: auto` on step content
- Touch targets are already 44px in the wizard (tablet compliance)
- The sidebar icon pattern (circle icons, no text) translates naturally to a bottom tab bar

## What Risks It Avoids

- **Field unusability**: A therapist who can't check their schedule on their phone will stop using the app
- **Patient-facing risk**: If the app is ever shared with patients (appointment links, etc.), it must work on phones
- **Market limitation**: "Desktop only" is a hard ceiling for any modern clinic tool

## Expected Payoff

The app becomes usable on phones and tablets. The therapist can check appointments between sessions. The admin can approve pending appointments from anywhere. The app goes from "office-only tool" to "always-available practice tool."

## Definition of Done (Testable Acceptance Criteria)

1. At 375px viewport width (iPhone SE): all 8 sections render without horizontal overflow
2. At 375px: the sidebar appears as a bottom tab bar
3. At 375px: tables are horizontally scrollable, not clipped
4. At 375px: the wizard modal opens and all 5 steps are navigable
5. At 375px: login/register pages are fully usable
6. At 768px (iPad): doctor grid shows 2 columns, forms use 2-column grids
7. `grep '@media' css/style.css | wc -l` returns ≥ 5 (at least 5 breakpoints)
8. No `overflow: hidden` on any container that clips mobile content
9. All test suites pass (CSS changes don't affect PHP tests)
10. Manual check: Chrome DevTools responsive mode at 375px, 768px, 1024px, 1440px — no layout breaks
