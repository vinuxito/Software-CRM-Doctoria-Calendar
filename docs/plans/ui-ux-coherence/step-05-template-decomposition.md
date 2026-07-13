# Step 5: Template Decomposition

**Status**: ⬜ TODO  
**Depends on**: Steps 2-4 ✅ (clean CSS, empty states added)  
**Impact**: 🟡 Medium | **Effort**: ~4-5 hours

---

## Problem

`app/views/dashboard/index.php` is 2,817 lines (157KB) containing ALL sections. Every change risks breaking unrelated sections. The file is unreviable, uncacheable, and blocks parallel development.

## Architecture Map (post Step 2-4)

After Steps 2-4, the inline `<style>` block is gone, but the structure remains:

```
index.php (2,817 lines → ~2,480 after <style> extraction)
├── L1-22:       Shell (header include, sidebar nav)
├── L24-77:      Calendar aside (controls-panel)
├── L79-90:      Flash message bar
├── L91-146:     Calendar section HTML
├── L147-176:    Doctors section HTML
├── L177-226:    Chat section HTML  
├── L227-300:    Settings section HTML
├── L301-325:    Profile section HTML
├── L326-1138:   Patients section HTML (largest — wizard modal, ~812 lines)
├── L1139-1220:  Users section HTML
├── L1221-1392:  Panel section HTML (else/default)
├── L1393-1395:  PHP endif
├── L1396-1601:  Calendar JS (script block, 205 lines)
├── L1602-1665:  Panel JS (script block, 63 lines)
├── L1666-1734:  Users JS (script block, 68 lines)
├── L1735-2815:  Patients JS (script block, 1080 lines)
└── L2815-2817:  PHP endif + footer
```

> **Note**: Line numbers will shift after Steps 2-4. Always use `grep` to find exact section boundaries before extraction.

## Changes Required

### Task 5.1 — Create section directory

```bash
mkdir -p app/views/dashboard/sections
mkdir -p js/sections
```

### Task 5.2 — Extract HTML sections into partial files

For each section, the process is:
1. Find the `<?php elseif ($section === 'xxx') : ?>` boundary
2. Find the matching closing tag (usually the next `<?php elseif` or `<?php else` or `<?php endif`)
3. Copy the HTML content between them into `app/views/dashboard/sections/xxx.php`
4. Replace the original block with a `require` include

**Important**: The partial files do NOT need `<?php elseif` wrappers — the `if/elseif` logic stays in the shell.

#### 5.2a — Calendar aside + HTML → `sections/calendar.php`

Extract the calendar aside panel (L24-77) AND the calendar main content (L91-146) into one file. The aside only shows when `$section === 'calendar'`, so it belongs with the calendar partial.

**New file**: `app/views/dashboard/sections/calendar.php`
- Contains: controls-panel aside + toolbar + FullCalendar grid + calendar modal

#### 5.2b — Doctors → `sections/doctors.php`

Extract L147-176 (between `elseif doctors` and `elseif chat`).

**New file**: `app/views/dashboard/sections/doctors.php`
- Contains: toolbar + doctor grid + empty state (from Step 4)

#### 5.2c — Chat → `sections/chat.php`

Extract L177-226 (between `elseif chat` and `elseif settings`).

**New file**: `app/views/dashboard/sections/chat.php`
- Contains: chat layout + contact list + messages + send form

#### 5.2d — Settings → `sections/settings.php`

Extract L227-300 (between `elseif settings` and `elseif profile`).

**New file**: `app/views/dashboard/sections/settings.php`
- Contains: settings-wrap + API cards

#### 5.2e — Profile → `sections/profile.php`

Extract L301-325 (between `elseif profile` and `elseif patients`).

**New file**: `app/views/dashboard/sections/profile.php`
- Contains: profile card + profile grid

#### 5.2f — Patients → `sections/patients.php`

Extract L326-1138 (between `elseif patients` and `elseif users`). **This is the largest section (~812 lines)** — includes the patient table, the wizard modal, all 5 wizard steps.

**New file**: `app/views/dashboard/sections/patients.php`
- Contains: toolbar + patient table + empty state + wizard modal (5 steps)

#### 5.2g — Users → `sections/users.php`

Extract L1139-1220 (between `elseif users` and `else`).

**New file**: `app/views/dashboard/sections/users.php`
- Contains: toolbar + users table + empty state + create/edit modal

#### 5.2h — Panel → `sections/panel.php`

Extract L1221-1392 (the `else` default block).

**New file**: `app/views/dashboard/sections/panel.php`
- Contains: toolbar + KPI cards + pending list + CRUD table + detail modal

### Task 5.3 — Rewrite `index.php` shell

After extraction, `index.php` should look like:

```php
<?php require APPROOT . '/views/inc/header.php'; ?>
<?php $section = $data['section'] ?? 'calendar'; ?>
<div class="crm-calendar-shell">
    <nav class="icon-sidebar">
        <!-- sidebar icons (unchanged, ~18 lines) -->
    </nav>

    <?php if ($section === 'calendar') : ?>
        <?php require APPROOT . '/views/dashboard/sections/calendar.php'; ?>
    <?php elseif ($section === 'doctors') : ?>
        <?php require APPROOT . '/views/dashboard/sections/doctors.php'; ?>
    <?php elseif ($section === 'chat') : ?>
        <?php require APPROOT . '/views/dashboard/sections/chat.php'; ?>
    <?php elseif ($section === 'settings') : ?>
        <?php require APPROOT . '/views/dashboard/sections/settings.php'; ?>
    <?php elseif ($section === 'profile') : ?>
        <?php require APPROOT . '/views/dashboard/sections/profile.php'; ?>
    <?php elseif ($section === 'patients') : ?>
        <?php require APPROOT . '/views/dashboard/sections/patients.php'; ?>
    <?php elseif ($section === 'users') : ?>
        <?php require APPROOT . '/views/dashboard/sections/users.php'; ?>
    <?php else : ?>
        <?php require APPROOT . '/views/dashboard/sections/panel.php'; ?>
    <?php endif; ?>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
```

**Target: ~40-50 lines total.**

### Task 5.4 — Extract inline JavaScript into section-specific JS files

For each `<script>` block:

| Script block | Lines | Extract to |
|-------------|-------|-----------|
| Calendar (L1397-1601) | ~204 lines | `js/sections/calendar.js` |
| Panel (L1603-1665) | ~63 lines | `js/sections/panel.js` |
| Users (L1667-1734) | ~68 lines | `js/sections/users.js` |
| Patients (L1736-2814) | ~1,078 lines | `js/sections/patients.js` |

**Process for each**:
1. Copy the JS content between `<script>` and `</script>` tags (not the tags themselves)
2. Wrap in a `document.addEventListener('DOMContentLoaded', function() { ... });` if not already wrapped
3. Save to `js/sections/xxx.js`
4. Add a `<script>` tag at the bottom of the corresponding section partial:

```html
<!-- At bottom of sections/calendar.php -->
<script src="<?php echo URLROOT; ?>/js/sections/calendar.js"></script>
```

5. Remove the PHP conditional `<?php if ($section === 'xxx') : ?>` wrapping from around the script block — the partial already only loads for that section.

### Task 5.5 — Delete the script block section from `index.php`

After extracting all scripts, remove lines 1396-2815 from `index.php` (the entire `<?php if ($section === 'calendar') : ?>` script conditional block). This should leave `index.php` at ~40-50 lines.

### Task 5.6 — Update `main.js` stub

**File**: `js/main.js`  
**Action**: Replace content with useful utilities:

```js
// Doctoria CRM — Global Utilities
'use strict';

/**
 * URL root for AJAX calls — injected by PHP in footer or header
 * Falls back to auto-detection from current URL
 */
var URLROOT = document.querySelector('meta[name="urlroot"]')
    ? document.querySelector('meta[name="urlroot"]').content
    : window.location.origin + '/naxielly';
```

And add to `header.php` (inside `<head>`):
```html
<meta name="urlroot" content="<?php echo URLROOT; ?>">
```

This lets JS files reference `URLROOT` without inline PHP.

## Verification

```bash
# Shell is small
wc -l app/views/dashboard/index.php    # Should be < 60

# All section partials exist
ls app/views/dashboard/sections/*.php | wc -l  # Should be 8

# All JS files exist
ls js/sections/*.js | wc -l            # Should be 4

# No inline <script> in shell
grep '<script>' app/views/dashboard/index.php  # Should return 0

# No inline <style> in shell (already done in Step 2)
grep '<style>' app/views/dashboard/index.php   # Should return 0

# PHP syntax on all new files
find app/views/dashboard/sections/ -name '*.php' -exec php -l {} \;
php -l app/views/dashboard/index.php

# Tests
php test_crud.php && php test_patient_file.php && php test_wizard_logic.php
```

## Commit

```bash
git add app/views/dashboard/ js/ app/views/inc/header.php
git commit -m "refactor(arch): step-05 decompose monolith into 8 section partials + 4 JS modules"
git push origin feature/docs-and-branding
```

## Critical Notes

- **Variable scope**: PHP variables from the controller (`$data`, `$section`) are available inside `require`'d files — they share the calling scope. No changes needed to the controller.
- **URLROOT in JS**: The patients script uses `URLROOT` for fetch calls. After extraction, it needs access to this value. The `<meta name="urlroot">` approach (Task 5.6) solves this cleanly.
- **Order matters**: Extract HTML sections first (Task 5.2), verify, then extract JS (Task 5.4). Don't do both at once.
