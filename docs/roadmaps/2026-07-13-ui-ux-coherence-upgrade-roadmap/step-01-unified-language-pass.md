# Step 1: Unified Language Pass

**Category**: UX  
**Impact**: 🔴 Critical  
**Complexity**: Low (text-only changes, zero logic risk)  
**Estimated effort**: 1-2 hours

---

## Why It Matters Now

The app targets a Mexican physiotherapy clinic. Right now:

- Login page says: "Login", "Password:", "Please fill in your credentials to log in", "No account? Register"
- Register page says: "Create An Account", "Name:", "Role:", "Confirm Password:", "Have an account? Login"
- Navbar says: "Welcome", "Logout", "Register", "Login"
- Dashboard says: "Agendar cita", "Guardar Borrador", "Expediente Clínico Digital"
- `<html lang="en">` is declared in `header.php`

A clinic receptionist logs in seeing English, then lands in a Spanish dashboard. This breaks trust at the first interaction.

## What Exactly Should Be Done

### File: `app/views/inc/header.php`
| Line | Current | Replace With |
|------|---------|-------------|
| 3 | `<html lang="en">` | `<html lang="es">` |

### File: `app/views/auth/login.php`
| Line | Current | Replace With |
|------|---------|-------------|
| 5 | `<h2>Login</h2>` | `<h2>Iniciar Sesión</h2>` |
| 6 | `Please fill in your credentials to log in` | `Ingresa tus credenciales para acceder` |
| 14 | `Password: *` | `Contraseña: *` |
| 20 | `value="Login"` | `value="Iniciar Sesión"` |
| 23 | `No account? Register` | `¿No tienes cuenta? Regístrate` |

### File: `app/views/auth/register.php`
| Line | Current | Replace With |
|------|---------|-------------|
| 5 | `Create An Account` | `Crear Cuenta` |
| 6 | `Please fill out this form to register with us` | `Completa el formulario para registrarte` |
| 9 | `Name: *` | `Nombre: *` |
| 14 | `Email: *` → keep as-is | `Correo Electrónico: *` |
| 23 | `Password: *` | `Contraseña: *` |
| 28 | `Role: *` | `Rol: *` |
| 35 | `Confirm Password: *` | `Confirmar Contraseña: *` |
| 41 | `value="Register"` | `value="Registrarse"` |
| 44 | `Have an account? Login` | `¿Ya tienes cuenta? Inicia Sesión` |

### File: `app/views/inc/navbar.php`
| Line | Current | Replace With |
|------|---------|-------------|
| 11 | `Dashboard` | `Panel` |
| 19 | `Welcome` | `Bienvenido(a)` |
| 22 | `Logout` | `Cerrar Sesión` |
| 26 | `Register` | `Registrarse` |
| 29 | `Login` | `Iniciar Sesión` |

**Total: ~20 string replacements across 4 files. No logic, no CSS, no JS changes.**

## What Existing Work It Builds On

- The dashboard is already 95% Spanish (sidebar labels, wizard steps, flash messages, button text)
- The label "Email o Usuario:" in login was already partially translated in the previous session
- All dashboard section headers are Spanish: "Gestión de Expedientes", "Panel de control", "Configuración de APIs"

## What Risks It Avoids

- **User confusion**: A bilingual UI signals "unfinished" or "not for me" to non-English-speaking clinic staff
- **Accessibility compliance**: `lang="en"` causes screen readers to use English pronunciation for Spanish text
- **Support burden**: "What language is this app in?" is a question no one should need to ask

## Expected Payoff

The app feels like one product from the first screen. Login → Dashboard is a single-language experience. Screen readers work correctly. The "unfinished prototype" impression disappears.

## Definition of Done (Testable Acceptance Criteria)

1. `grep -r 'Login\|Register\|Password\|Create An Account\|Welcome\|Logout' app/views/` returns zero matches in user-facing labels (HTML attribute values like `name="password"` don't count)
2. `grep 'lang="en"' app/views/inc/header.php` returns zero matches
3. `grep 'lang="es"' app/views/inc/header.php` returns exactly one match
4. Manual check: navigate to `/users/login` — all text is Spanish
5. Manual check: navigate to `/users/register` — all text is Spanish
6. Manual check: logged-in navbar shows "Bienvenido(a)" and "Cerrar Sesión"
7. `php -l` passes for all 4 modified files
