# Step 7: Registration Hardening & Role Guard

**Status**: ✅ DONE  
**Depends on**: Step 3 ✅ (needs clean auth views from rebrand)  
**Impact**: 🟡 Medium | **Effort**: ~2 hours

---

## Problem

1. **Open role selector**: `/users/register` has a `<select>` with Cliente/Médico. Any visitor can self-register as a doctor and access clinical records.
2. **Passwords echoed in HTML**: Both login and register forms echo `$data['password']` into `<input value="">`. View Source exposes passwords.
3. **No CSRF protection**: All forms POST without tokens. Any external site can craft a form that targets our endpoints.

## Changes Required

### Task 7.1 — Remove role selector from public registration

**File**: `app/views/auth/register.php`  
**Action**: Remove the role `<select>` block entirely. After Step 3, the form uses the new auth-card layout. Remove the role form group:

```diff
-            <div class="form-group mb-3">
-                <label for="role">Rol: <sup>*</sup></label>
-                <select name="role" id="role" class="form-control">
-                    <option value="cliente" <?php echo ... ?>>Cliente</option>
-                    <option value="medico" <?php echo ... ?>>Médico</option>
-                </select>
-            </div>
```

### Task 7.2 — Force `cliente` role in controller

**File**: `app/controllers/Users.php`  
**Action**: In the `register()` method POST branch (around L21), force the role:

```diff
 $data = [
     'name' => trim($_POST['name']),
     'email' => trim($_POST['email']),
     'phone' => trim($_POST['phone'] ?? ''),
     'password' => trim($_POST['password']),
-    'role' => isset($_POST['role']) && in_array($_POST['role'], ['cliente', 'medico']) ? $_POST['role'] : 'cliente',
+    'role' => 'cliente',  // Always cliente — role changes are admin-only via /dashboard/users
     'confirm_password' => trim($_POST['confirm_password']),
```

Also in the GET branch (around L86), remove `'role' => 'cliente'` or keep it (harmless).

### Task 7.3 — Stop echoing passwords in forms

**File**: `app/views/auth/login.php`  
**Action**: The password input should already have `value=""` after Step 3. Verify this is the case. If not, change:

```diff
-value="<?php echo $data['password']; ?>"
+value=""
```

**File**: `app/views/auth/register.php`  
**Action**: Same for password and confirm_password fields. After Step 3, both should have `value=""`. Verify.

### Task 7.4 — Add CSRF token system

**File**: `app/bootstrap.php`  
**Action**: Add CSRF helper functions after the session_start block:

```php
/**
 * Generate or retrieve CSRF token for the current session.
 */
function csrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Render a hidden CSRF input field.
 */
function csrfField() {
    echo '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
}

/**
 * Verify the submitted CSRF token matches the session token.
 */
function verifyCsrfToken($token) {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token ?? '');
}
```

### Task 7.5 — Add CSRF fields to all forms

**Files affected**: 
- `app/views/auth/login.php` — add `<?php csrfField(); ?>` inside `<form>`
- `app/views/auth/register.php` — add `<?php csrfField(); ?>` inside `<form>`
- `app/views/dashboard/sections/calendar.php` — all forms (quick appointment, modal form)
- `app/views/dashboard/sections/users.php` — user CRUD form, delete forms
- `app/views/dashboard/sections/panel.php` — approve/reject/delete forms
- `app/views/dashboard/sections/chat.php` — chat send form

Pattern — add immediately after `<form ... method="post">`:
```php
<form action="..." method="post">
    <?php csrfField(); ?>
    <!-- existing fields -->
</form>
```

### Task 7.6 — Verify CSRF in controllers

**File**: `app/controllers/Users.php`  
**Action**: Add CSRF verification at the top of each POST handler:

```php
public function register(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            die('Solicitud no válida');
        }
        // ... existing code
```

```php
public function login(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            die('Solicitud no válida');
        }
        // ... existing code
```

**File**: `app/controllers/Dashboard.php`  
**Action**: Add CSRF verification in:
- `calendar()` method (L25) — handles appointment creation
- `users()` method (L202) — handles user CRUD
- `panel()` method (L72) — handles approve/reject
- `chat()` method (L47) — handles message sending

Pattern for each:
```php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        die('Solicitud no válida');
    }
    // ... existing POST handling
}
```

### Task 7.7 — Add login rate limiting (simple, session-based)

**File**: `app/controllers/Users.php`  
**Action**: In `login()` method, before validation:

```php
public function login(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Rate limiting
        $maxAttempts = 5;
        $lockoutMinutes = 5;
        $_SESSION['login_attempts'] = $_SESSION['login_attempts'] ?? 0;
        $_SESSION['login_lockout'] = $_SESSION['login_lockout'] ?? 0;
        
        if ($_SESSION['login_lockout'] > time()) {
            $remaining = ceil(($_SESSION['login_lockout'] - time()) / 60);
            $data = [
                'email' => '', 'password' => '',
                'email_err' => "Demasiados intentos. Espera {$remaining} minuto(s).",
                'password_err' => '',
                'body_class' => 'auth-page', 'hide_navbar' => true
            ];
            $this->view('auth/login', $data);
            return;
        }
        
        // ... existing CSRF check and validation ...
        
        // On failed login (where password_err is set):
        $_SESSION['login_attempts']++;
        if ($_SESSION['login_attempts'] >= $maxAttempts) {
            $_SESSION['login_lockout'] = time() + ($lockoutMinutes * 60);
            $_SESSION['login_attempts'] = 0;
        }
        
        // On successful login (in createUserSession):
        $_SESSION['login_attempts'] = 0;
        $_SESSION['login_lockout'] = 0;
```

## Verification

```bash
# No role selector in register form
grep -c 'medico\|Médico' app/views/auth/register.php  # Should be 0

# Role forced in controller
grep "role.*cliente" app/controllers/Users.php         # Should match the forced assignment

# No password echo
grep "echo.*password" app/views/auth/login.php | grep -v 'password_err'    # Should be 0
grep "echo.*password" app/views/auth/register.php | grep -v 'password_err' # Should be 0

# CSRF in all forms
grep -r 'csrfField' app/views/auth/                    # Should match in both files
grep -r 'csrfField' app/views/dashboard/sections/      # Should match in calendar, users, panel, chat

# CSRF verification in controllers
grep 'verifyCsrfToken' app/controllers/Users.php       # Should match >= 2
grep 'verifyCsrfToken' app/controllers/Dashboard.php   # Should match >= 4

# CSRF functions defined
grep 'csrfToken\|csrfField\|verifyCsrfToken' app/bootstrap.php  # Should match 3

# Syntax
php -l app/bootstrap.php
php -l app/controllers/Users.php
php -l app/controllers/Dashboard.php
php -l app/views/auth/login.php
php -l app/views/auth/register.php
find app/views/dashboard/sections/ -name '*.php' -exec php -l {} \;

# Tests
php test_crud.php && php test_patient_file.php && php test_wizard_logic.php
```

## Commit

```bash
git add app/bootstrap.php app/controllers/ app/views/
git commit -m "fix(security): step-07 lock registration to cliente, add CSRF, rate limit login"
git push origin feature/docs-and-branding
```

## Post-Step 7: Final Tag

After all 7 steps are verified:
```bash
git tag -a v0.3.0-coherence -m "UI/UX coherence upgrade: language, tokens, auth, empty states, decomposition, mobile, security"
git push origin v0.3.0-coherence
```
