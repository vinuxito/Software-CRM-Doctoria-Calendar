# Step 3: Auth Views Rebrand

**Category**: UX / Product  
**Impact**: 🟠 High  
**Complexity**: Low-Medium (HTML/CSS, no backend changes)  
**Estimated effort**: 2-3 hours

---

## Why It Matters Now

Login is the **first screen** every user sees. Right now it's a raw Bootstrap card on a gray `#f8f9fa` background:
- No logo
- No brand colors (teal `#00a29a` or accent pink `#E8A0AC`)
- Generic Bootstrap `btn-success` green button (not the app's teal)
- `card-body bg-light` class — the most generic Bootstrap look possible
- No visual connection to the polished dashboard that appears after login

A clinic staff member seeing this login page has zero indication they're about to use a medical practice management system. It looks like a developer tutorial exercise.

## What Exactly Should Be Done

### 1. Add logo and app name to login/register

Add the clinic logo (`img/logo.png`, already exists at 17KB) above the form card:
```html
<div class="auth-brand">
    <img src="<?php echo URLROOT; ?>/img/logo.png" alt="Doctoria CRM">
    <h1><?php echo SITENAME; ?></h1>
    <p>Gestión clínica inteligente</p>
</div>
```

### 2. Style the auth pages with brand identity

Add auth-specific styles to `style.css` (not inline):
- Background: subtle gradient using brand teal + white, or a clean white/light teal split
- Card: white with soft shadow, rounded corners using `var(--radius-lg)`
- Form inputs: use the same styling as the wizard (`var(--font-body)`, `var(--border-default)`, focus glow)
- Submit button: use `var(--brand-primary)` teal instead of Bootstrap green
- Links: teal instead of Bootstrap blue
- Overall: vertical centered layout, max-width 420px

### 3. Remove the Bootstrap navbar from auth pages

The auth pages currently show the dark Bootstrap navbar at the top, which conflicts with the dashboard's icon sidebar. Since `$data['hide_navbar']` already exists in `header.php`, set it in the Users controller for login/register routes:
```php
$data['hide_navbar'] = true;
```

### 4. Add body class for auth-specific styling

Already supported by `header.php` L17: `$data['body_class']`. Set `body_class` to `auth-page` in the login/register controller methods so CSS can target auth pages specifically.

### 5. Add a footer credit or link

Below the form card, add a subtle footer:
```html
<div class="auth-footer">Doctoria CRM &copy; 2026</div>
```

## What Existing Work It Builds On

- `header.php` already has `hide_navbar` and `body_class` support (L17-19)
- Logo already exists at `/img/logo.png` and is used in the dashboard sidebar
- The wizard already demonstrates premium form styling (focus glows, variable-based colors, 44px touch targets)
- Brand teal `#00a29a` is already the dashboard's primary color

## What Risks It Avoids

- **First-impression rejection**: A clinic administrator evaluating the software sees a generic page and assumes the product is unfinished
- **Brand disconnect**: Login looks like App A, dashboard looks like App B — this undermines trust
- **Support burden**: "Is this the right link?" from staff who don't recognize the login page

## Expected Payoff

Login becomes a branded entry point that says "this is a professional medical tool." The visual bridge from login to dashboard is seamless. The experience feels intentional from the first pixel.

## Definition of Done (Testable Acceptance Criteria)

1. Login page shows the clinic logo (`img/logo.png`)
2. Login page uses brand teal (`#00a29a` or `var(--brand-primary)`) for the submit button
3. Login page does NOT show the dark Bootstrap navbar
4. Register page matches login page styling
5. `grep 'btn-success' app/views/auth/login.php` returns zero matches
6. `grep 'bg-light' app/views/auth/login.php` returns zero matches (no generic Bootstrap card)
7. Manual check: login page feels visually connected to the dashboard
8. Manual check: login → dashboard transition doesn't feel like switching apps
9. Form inputs on auth pages have the same focus-glow behavior as the wizard
10. Mobile: login page is usable on a 375px-wide screen (single column, no overflow)
