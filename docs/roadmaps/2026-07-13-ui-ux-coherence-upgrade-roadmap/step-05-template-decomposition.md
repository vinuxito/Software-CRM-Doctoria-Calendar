# Step 5: Template Decomposition

**Category**: Architecture / Developer Experience  
**Impact**: 🟡 Medium  
**Complexity**: Medium-High (structural refactor, careful section extraction)  
**Estimated effort**: 4-6 hours

---

## Why It Matters Now

`app/views/dashboard/index.php` is **2,817 lines and 157KB**. It contains:
- 8 PHP section blocks (~1,200 lines of HTML)
- 1 inline `<style>` block (~340 lines of CSS)
- 4 inline `<script>` blocks (~1,400 lines of JavaScript)

Every bug fix, feature addition, or style change requires navigating a single massive file. This is the #1 maintenance risk in the codebase.

**Concrete problems caused by this**:
- The previous session found a "duplicate `elseif`" on line 1138 that was actually the section boundary between HTML (L1139) and JS (L1666) for the same `users` section. The monolith's structure makes this confusing.
- Code review is impractical — a 157KB diff is unreadable
- Multiple developers (human or AI) cannot work on different sections simultaneously
- Browser caching is impossible — any change forces re-downloading the entire template

## What Exactly Should Be Done

### 1. Extract each section's HTML into partial view files

Create `app/views/dashboard/sections/`:
```
app/views/dashboard/sections/
├── calendar.php      (lines ~24-146)
├── doctors.php       (lines ~147-176)
├── chat.php          (lines ~177-226)
├── settings.php      (lines ~227-300)
├── profile.php       (lines ~301-325)
├── patients.php      (lines ~326-1138)
├── users.php         (lines ~1139-1395)
└── panel.php         (lines from the panel HTML block)
```

### 2. Replace section blocks with includes

```php
<?php if ($section === 'calendar') : ?>
    <?php require APPROOT . '/views/dashboard/sections/calendar.php'; ?>
<?php elseif ($section === 'doctors') : ?>
    <?php require APPROOT . '/views/dashboard/sections/doctors.php'; ?>
<?php elseif ($section === 'chat') : ?>
    <?php require APPROOT . '/views/dashboard/sections/chat.php'; ?>
<!-- ... etc ... -->
<?php endif; ?>
```

### 3. Extract inline JavaScript into section-specific JS files

Create `js/sections/`:
```
js/
├── main.js              (keep as app init, add global utilities)
├── sections/
│   ├── calendar.js      (~204 lines from script block 1)
│   ├── panel.js         (~62 lines from script block 2)
│   ├── users.js         (~67 lines from script block 3)
│   └── patients.js      (~1,077 lines from script block 4)
```

Load per-section JS at the bottom of each section partial:
```php
<!-- In sections/calendar.php -->
<script src="<?php echo URLROOT; ?>/js/sections/calendar.js"></script>
```

### 4. Move the inline `<style>` block to `style.css`

This should already be done in Step 2. If not, do it here. The `<style>` block at L381-718 moves to the end of `css/style.css`.

### 5. Keep `index.php` as the shell

After extraction, `index.php` should be ~100 lines: the sidebar nav, the `<main>` wrapper, the section switch, and the flash message bar. The shell stays.

## What Existing Work It Builds On

- The MVC framework already supports `require` for view loading (fixed in previous session from `require_once`)
- The `header.php` / `footer.php` / `navbar.php` partial pattern is already established in `app/views/inc/`
- Each section is already self-contained within PHP `if/elseif` blocks — they share no variables between sections

## What Risks It Avoids

- **Regression from touching the monolith**: Every change to any section risks breaking unrelated sections in the same file
- **Developer onboarding friction**: A new builder (human or AI) must understand a 2,817-line file to make any change
- **Git merge conflicts**: Two builders working on calendar and users simultaneously will always conflict in the same file

## Expected Payoff

Each section is independently editable, reviewable, and cacheable. `git blame` shows meaningful per-section history. A builder can work on `patients.php` without loading 2,817 lines of context. The dashboard shell becomes a clean routing layer.

## Definition of Done (Testable Acceptance Criteria)

1. `wc -l app/views/dashboard/index.php` returns < 150 lines
2. `ls app/views/dashboard/sections/*.php | wc -l` returns ≥ 7 (one per section)
3. `ls js/sections/*.js | wc -l` returns ≥ 4 (calendar, panel, users, patients)
4. `grep '<script>' app/views/dashboard/index.php` returns zero matches (no inline JS in shell)
5. `grep '<style>' app/views/dashboard/index.php` returns zero matches (no inline CSS)
6. All 3 test suites pass
7. Manual check: navigate to each section → renders correctly
8. Manual check: wizard opens and autosaves correctly from `/dashboard/patients`
9. `php -l` passes for all new and modified files
