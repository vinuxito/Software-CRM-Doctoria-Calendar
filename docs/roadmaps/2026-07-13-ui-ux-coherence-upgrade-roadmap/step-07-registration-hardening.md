# Step 7: Registration Hardening & Role Guard

**Category**: Security / Product  
**Impact**: 🟡 Medium  
**Complexity**: Low-Medium (backend + minor frontend)  
**Estimated effort**: 2-3 hours

---

## Why It Matters Now

The registration form at `/users/register` exposes a `<select>` with two options:
```html
<option value="cliente">Cliente</option>
<option value="medico">Médico</option>
```

**Any visitor can self-register as a doctor.** This means:
- An unauthorized person gains access to the Patients section (clinical records)
- They can see other doctors' appointments in the calendar
- They appear in the doctor grid and can receive appointment bookings
- They can access the chat with real staff

This is a **real security gap** for a medical application handling patient data (PII, clinical records, medical history).

Additionally:
- Passwords are echoed back in form input `value` attributes on validation failure (both login and register)
- There is no CSRF protection on any form
- There is no rate limiting on login attempts

## What Exactly Should Be Done

### 1. Remove the role selector from public registration

Change the register form to always create `cliente` accounts:
```php
// In Users.php register() method:
$data['role'] = 'cliente'; // Force, ignore POST input
```

Remove the `<select>` from `register.php`. Add a hidden field or just hardcode in the controller.

### 2. Add admin-only role assignment

The admin panel (`/dashboard/users`) already has a Create User modal with role selection. This is where role assignment belongs. Keep it there, but also:
- Add a "Promover a Médico" action to the user edit flow (admin only)
- Add a confirmation dialog for role changes: "¿Seguro que deseas cambiar el rol a Médico?"

### 3. Stop echoing passwords in form values

In `login.php` L15:
```html
<!-- CURRENT (insecure) -->
<input type="password" ... value="<?php echo $data['password']; ?>">

<!-- FIX -->
<input type="password" ... value="">
```

Same in `register.php` L24 and L36. Never echo passwords back into HTML. On validation failure, let the user re-enter their password. This is standard practice.

### 4. Add CSRF token to forms

In `Controller.php` or `bootstrap.php`, add a CSRF token generator:
```php
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}
```

Add to every form:
```html
<input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
```

Verify in every POST handler:
```php
if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    die('Invalid request');
}
```

### 5. Add basic login rate limiting (optional, if time allows)

Track failed attempts per IP in session:
```php
$_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
if ($_SESSION['login_attempts'] > 5) {
    $data['email_err'] = 'Demasiados intentos. Espere 5 minutos.';
    // Could also use a timestamp check
}
```

## What Existing Work It Builds On

- The admin Create User modal already handles role assignment correctly
- Session-based auth (`$_SESSION['user_id']`, `$_SESSION['user_role']`) is already in place
- The controller already validates POST data with `filter_input()`

## What Risks It Avoids

- **Unauthorized access to patient data**: A stranger registers as "medico" and sees clinical records
- **Session hijacking via password leakage**: Passwords visible in HTML source (View Source, DOM inspection)
- **CSRF attacks**: Any external site could craft a form that POSTs to `/users/register` or `/dashboard/users` and creates/modifies users
- **Brute force**: Unlimited login attempts allow credential stuffing

## Expected Payoff

Registration becomes safe for public exposure. Patient data is protected behind admin-controlled role assignment. Password handling follows security best practices. The app can be deployed on a public URL without immediate security concerns.

## Definition of Done (Testable Acceptance Criteria)

1. `/users/register` does NOT show a role selector — all new registrations are `cliente`
2. `grep 'role' app/views/auth/register.php` returns zero matches for any `<select>` or `<option>` containing "medico"
3. `grep 'password' app/views/auth/login.php` — no `value="<?php echo $data['password']"` pattern
4. `grep 'password' app/views/auth/register.php` — no echoed password values
5. `grep 'csrf_token' app/views/auth/login.php` returns a match (token present)
6. `grep 'csrf_token' app/views/auth/register.php` returns a match
7. Manual test: register a new user via `/users/register` → verify they are created with role `cliente`
8. Manual test: attempt to register as `medico` by injecting POST data → verify role is still `cliente`
9. Admin can still change roles from `/dashboard/users`
10. All test suites pass
