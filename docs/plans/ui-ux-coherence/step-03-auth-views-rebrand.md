# Step 3: Auth Views Rebrand

**Status**: ⬜ TODO  
**Depends on**: Step 2 ✅ (needs design tokens + loaded fonts)  
**Impact**: 🟠 High | **Effort**: ~2-3 hours

---

## Problem

Login and register pages use raw Bootstrap card on gray background:
- No logo (exists at `img/logo.png`, unused in auth)
- Generic `btn-success` green button (not brand teal)
- `bg-light` card class — most generic Bootstrap look
- No visual connection to the teal/pink dashboard

## Changes Required

### Task 3.1 — Add auth styles to `css/style.css`

**File**: `css/style.css`  
**Action**: Append the following auth-specific styles:

```css
/* =============================================
   AUTH PAGES — Login / Register
   ============================================= */
.auth-page {
    background: linear-gradient(135deg, var(--bg-page) 0%, var(--brand-primary-light) 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.auth-container {
    width: 100%;
    max-width: 420px;
}

.auth-brand {
    text-align: center;
    margin-bottom: 28px;
}

.auth-brand img {
    width: 64px;
    height: auto;
    margin-bottom: 12px;
}

.auth-brand h1 {
    font-family: var(--font-heading);
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 4px;
}

.auth-brand p {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0;
}

.auth-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    padding: 32px;
    border: 1px solid var(--border-light);
}

.auth-card h2 {
    font-family: var(--font-heading);
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.auth-card > p {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 24px;
}

.auth-card .form-control {
    font-family: var(--font-body);
    border: 1.5px solid var(--border-default);
    border-radius: var(--radius-md);
    padding: 10px 14px;
    font-size: 0.9375rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.auth-card .form-control:focus {
    border-color: var(--brand-primary);
    box-shadow: 0 0 0 3px var(--brand-accent-glow);
}

.auth-card label {
    font-family: var(--font-body);
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--text-secondary);
    margin-bottom: 4px;
}

.btn-auth-primary {
    background: var(--brand-primary);
    border: none;
    color: #fff;
    font-family: var(--font-body);
    font-weight: 600;
    padding: 10px 20px;
    border-radius: var(--radius-md);
    width: 100%;
    font-size: 0.9375rem;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
}

.btn-auth-primary:hover {
    background: var(--brand-primary-dark);
}

.btn-auth-primary:active {
    transform: scale(0.98);
}

.btn-auth-secondary {
    background: transparent;
    border: 1.5px solid var(--border-default);
    color: var(--text-secondary);
    font-family: var(--font-body);
    font-weight: 500;
    padding: 10px 20px;
    border-radius: var(--radius-md);
    width: 100%;
    font-size: 0.875rem;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    transition: border-color 0.2s, color 0.2s;
}

.btn-auth-secondary:hover {
    border-color: var(--brand-primary);
    color: var(--brand-primary);
    text-decoration: none;
}

.auth-footer {
    text-align: center;
    margin-top: 24px;
    font-size: 0.75rem;
    color: var(--text-muted);
}
```

### Task 3.2 — Rewrite `app/views/auth/login.php`

**File**: `app/views/auth/login.php`  
**Action**: Replace entire file content:

```php
<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="auth-container">
    <div class="auth-brand">
        <img src="<?php echo URLROOT; ?>/img/logo.png" alt="<?php echo SITENAME; ?>">
        <h1><?php echo SITENAME; ?></h1>
        <p>Gestión clínica inteligente</p>
    </div>
    <div class="auth-card">
        <h2>Iniciar Sesión</h2>
        <p>Ingresa tus credenciales para acceder</p>
        <form action="<?php echo URLROOT; ?>/users/login" method="post">
            <div class="form-group mb-3">
                <label for="email">Email o Usuario: <sup>*</sup></label>
                <input type="text" name="email" id="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="password">Contraseña: <sup>*</sup></label>
                <input type="password" name="password" id="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="">
                <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>
            <div class="d-grid gap-2 mt-4">
                <input type="submit" value="Iniciar Sesión" class="btn-auth-primary">
                <a href="<?php echo URLROOT; ?>/users/register" class="btn-auth-secondary">¿No tienes cuenta? Regístrate</a>
            </div>
        </form>
    </div>
    <div class="auth-footer">Doctoria CRM &copy; <?php echo date('Y'); ?></div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
```

> **Note**: Password `value=""` — we no longer echo the password back (security fix, was `value="<?php echo $data['password']; ?>"`).

### Task 3.3 — Rewrite `app/views/auth/register.php`

**File**: `app/views/auth/register.php`  
**Action**: Replace entire file content:

```php
<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="auth-container">
    <div class="auth-brand">
        <img src="<?php echo URLROOT; ?>/img/logo.png" alt="<?php echo SITENAME; ?>">
        <h1><?php echo SITENAME; ?></h1>
        <p>Gestión clínica inteligente</p>
    </div>
    <div class="auth-card">
        <h2>Crear Cuenta</h2>
        <p>Completa el formulario para registrarte</p>
        <form action="<?php echo URLROOT; ?>/users/register" method="post">
            <div class="form-group mb-3">
                <label for="name">Nombre: <sup>*</sup></label>
                <input type="text" name="name" id="name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="email">Correo Electrónico: <sup>*</sup></label>
                <input type="email" name="email" id="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="phone">Teléfono:</label>
                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $data['phone'] ?? ''; ?>" placeholder="+52 300 000 0000">
            </div>
            <div class="form-group mb-3">
                <label for="password">Contraseña: <sup>*</sup></label>
                <input type="password" name="password" id="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="">
                <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="role">Rol: <sup>*</sup></label>
                <select name="role" id="role" class="form-control">
                    <option value="cliente" <?php echo (($data['role'] ?? 'cliente') === 'cliente') ? 'selected' : ''; ?>>Cliente</option>
                    <option value="medico" <?php echo (($data['role'] ?? '') === 'medico') ? 'selected' : ''; ?>>Médico</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="confirm_password">Confirmar Contraseña: <sup>*</sup></label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="">
                <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
            </div>
            <div class="d-grid gap-2 mt-4">
                <input type="submit" value="Registrarse" class="btn-auth-primary">
                <a href="<?php echo URLROOT; ?>/users/login" class="btn-auth-secondary">¿Ya tienes cuenta? Inicia Sesión</a>
            </div>
        </form>
    </div>
    <div class="auth-footer">Doctoria CRM &copy; <?php echo date('Y'); ?></div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
```

> **Note**: Passwords `value=""` — no longer echoed back. Role selector remains for now (removed in Step 7).

### Task 3.4 — Set `body_class` and `hide_navbar` for auth routes

**File**: `app/controllers/Users.php`  
**Action**: In the `register()` method's GET branch (around L81-92), add body_class and hide_navbar to the data array:

```diff
 $data = [
     'name' => '',
     'email' => '',
     'phone' => '',
     'password' => '',
     'role' => 'cliente',
     'confirm_password' => '',
     'name_err' => '',
     'email_err' => '',
     'password_err' => '',
-    'confirm_password_err' => ''
+    'confirm_password_err' => '',
+    'body_class' => 'auth-page',
+    'hide_navbar' => true
 ];
```

Also add to the POST branch data array (L16-27) and to both branches of `login()` (L105-110 and L150-155):

```diff
+    'body_class' => 'auth-page',
+    'hide_navbar' => true
```

**Total**: Add `'body_class' => 'auth-page', 'hide_navbar' => true` to **4 data arrays** in Users.php:
1. `register()` POST branch (L16-27)
2. `register()` GET branch (L81-92)
3. `login()` POST branch (L105-110)
4. `login()` GET branch (L150-155)

## Verification

```bash
# Syntax
php -l app/views/auth/login.php
php -l app/views/auth/register.php
php -l app/controllers/Users.php

# Logo present
grep 'logo.png' app/views/auth/login.php      # Should match
grep 'logo.png' app/views/auth/register.php    # Should match

# No Bootstrap btn-success
grep 'btn-success' app/views/auth/login.php    # Should return 0
grep 'btn-success' app/views/auth/register.php # Should return 0

# No bg-light generic card
grep 'bg-light' app/views/auth/login.php       # Should return 0

# Password not echoed
grep 'echo.*password' app/views/auth/login.php # Should return 0 user-data echo matches

# Auth page class set
grep 'auth-page' app/controllers/Users.php     # Should match 4 times

# hide_navbar set
grep 'hide_navbar' app/controllers/Users.php   # Should match 4 times

# Tests
php test_crud.php && php test_patient_file.php && php test_wizard_logic.php
```

## Commit

```bash
git add css/style.css app/views/auth/login.php app/views/auth/register.php app/controllers/Users.php
git commit -m "fix(ux): step-03 rebrand auth views with logo, brand colors, professional styling"
git push origin feature/docs-and-branding
```
