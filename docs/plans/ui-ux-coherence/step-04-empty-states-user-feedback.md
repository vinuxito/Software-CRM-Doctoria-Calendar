# Step 4: Empty States & User Feedback

**Status**: ⬜ TODO  
**Depends on**: Step 2 ✅ (needs design tokens for empty-state styling)  
**Impact**: 🟠 High | **Effort**: ~3 hours

---

## Problem

When a section has no data, the user sees blank tables or empty grids. Only chat has an empty state. The flash message system uses regex to guess success/error.

| Section | Empty State? | Current behavior |
|---------|-------------|-----------------|
| Calendar events | ❌ | Blank calendar grid |
| Doctors grid | ❌ | Empty grid |
| Chat | ✅ | "Selecciona un chat para comenzar" |
| Panel pending | ❌ | Empty table body |
| Panel CRUD | ❌ | Empty table body |
| Patients | ❌ | Table header + empty tbody |
| Users | ❌ | Table header + empty tbody |

## Changes Required

### Task 4.1 — Add `.empty-state` CSS component to `style.css`

**File**: `css/style.css`  
**Action**: Append:

```css
/* =============================================
   EMPTY STATES
   ============================================= */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--text-secondary);
}

.empty-state-icon {
    font-size: 48px;
    color: var(--border-default);
    margin-bottom: 16px;
}

.empty-state h4 {
    font-family: var(--font-heading);
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
    font-size: 1.1rem;
}

.empty-state p {
    font-size: 0.875rem;
    max-width: 400px;
    margin: 0 auto 20px;
    line-height: 1.5;
}

.empty-state .btn-configurar {
    display: inline-block;
    margin-top: 8px;
}
```

### Task 4.2 — Add `.flash-bar` CSS component to `style.css`

**File**: `css/style.css`  
**Action**: Append:

```css
/* =============================================
   FLASH MESSAGES
   ============================================= */
.flash-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    margin: 15px;
    border-radius: var(--radius-md);
    font-weight: 500;
    font-size: 14px;
    font-family: var(--font-body);
    animation: slideInUp 280ms ease;
}

.flash-bar.flash-success {
    background: #d1e7dd;
    color: #0f5132;
    border: 1px solid #badbcc;
}

.flash-bar.flash-danger {
    background: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
}
```

### Task 4.3 — Replace inline-styled flash message in `index.php`

**File**: `app/views/dashboard/index.php`  
**Action**: Replace the flash message block at lines 80-90.

**Current** (L80-90):
```php
<?php if (!empty($data['flash'])) : ?>
    <?php 
        $isError = preg_match('/(error|incorrecto|ya está|no puedes|no válido|campos obligatorios|completados)/i', $data['flash']);
        $flashClass = $isError ? 'calendar-flash flash-danger' : 'calendar-flash flash-success';
        $flashIcon = $isError ? 'fas fa-exclamation-circle' : 'fas fa-check-circle';
    ?>
    <div class="<?php echo $flashClass; ?>" style="display: flex; align-items: center; gap: 10px; padding: 12px 15px; margin: 15px; border-radius: 6px; font-weight: 500; font-size: 14px; background: <?php echo $isError ? '#f8d7da' : '#d1e7dd'; ?>; color: <?php echo $isError ? '#842029' : '#0f5132'; ?>; border: 1px solid <?php echo $isError ? '#f5c2c7' : '#badbcc'; ?>;">
        <i class="<?php echo $flashIcon; ?>"></i>
        <span><?php echo htmlspecialchars($data['flash']); ?></span>
    </div>
<?php endif; ?>
```

**Replace with**:
```php
<?php if (!empty($data['flash'])) : ?>
    <?php 
        $flashType = $data['flash_type'] ?? 'auto';
        if ($flashType === 'auto') {
            $isError = preg_match('/(error|incorrecto|ya está|no puedes|no válido|campos obligatorios|completados)/i', $data['flash']);
        } else {
            $isError = ($flashType === 'error');
        }
        $flashClass = $isError ? 'flash-bar flash-danger' : 'flash-bar flash-success';
        $flashIcon = $isError ? 'fas fa-exclamation-circle' : 'fas fa-check-circle';
    ?>
    <div class="<?php echo $flashClass; ?>">
        <i class="<?php echo $flashIcon; ?>"></i>
        <span><?php echo htmlspecialchars($data['flash']); ?></span>
    </div>
<?php endif; ?>
```

> This keeps backward compatibility (regex auto-detect) but allows controllers to pass `$data['flash_type'] = 'error'` or `'success'` explicitly.

### Task 4.4 — Add empty states to each section in `index.php`

Add empty-state blocks to the following sections. Each wraps the existing content in an `<?php if (empty(...)): ?>` check:

#### 4.4a — Doctors (around L147-176)

After the toolbar header, before closing `</section>`:
```php
<?php if (empty($data['doctors'])) : ?>
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-user-md"></i></div>
        <h4>No hay especialistas registrados</h4>
        <p>Los médicos aparecerán aquí cuando un administrador los registre en el sistema.</p>
    </div>
<?php else : ?>
    <!-- existing doctor-grid content -->
<?php endif; ?>
```

#### 4.4b — Patients table (around L326-378, inside the patients section)

Wrap the existing `<table>` in a conditional:
```php
<?php if (empty($data['patients'])) : ?>
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-notes-medical"></i></div>
        <h4>No hay expedientes clínicos</h4>
        <p>Los expedientes se crean automáticamente cuando se registran pacientes en el sistema.</p>
    </div>
<?php else : ?>
    <!-- existing patients table -->
<?php endif; ?>
```

#### 4.4c — Users table (around L1139-1180)

Wrap the existing `<table>` in a conditional:
```php
<?php if (empty($data['users'])) : ?>
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-users"></i></div>
        <h4>No hay usuarios registrados</h4>
        <p>Crea el primer usuario para comenzar a gestionar tu equipo.</p>
        <button class="btn-configurar" id="btn-add-user-empty" onclick="document.getElementById('btn-add-user').click()">
            <i class="fas fa-user-plus"></i> Crear Usuario
        </button>
    </div>
<?php else : ?>
    <!-- existing users table -->
<?php endif; ?>
```

#### 4.4d — Panel pending items (around L1257-1320)

Wrap the pending/rejected items lists:
```php
<?php if (empty($data['pending_appointments']) && empty($data['rejected_appointments'])) : ?>
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-check-circle"></i></div>
        <h4>No hay citas pendientes</h4>
        <p>Todas las citas están al día. ¡Excelente!</p>
    </div>
<?php else : ?>
    <!-- existing pending/rejected lists -->
<?php endif; ?>
```

#### 4.4e — Panel CRUD table (around L1326-1370)

Wrap the CRUD appointments table:
```php
<?php if (empty($data['appointments'])) : ?>
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-calendar-alt"></i></div>
        <h4>No hay citas en el sistema</h4>
        <p>Las citas aparecerán aquí cuando se agenden desde el calendario.</p>
        <a href="<?php echo URLROOT; ?>/dashboard/calendar" class="btn-configurar">
            <i class="fas fa-calendar-plus"></i> Ir al Calendario
        </a>
    </div>
<?php else : ?>
    <!-- existing CRUD table -->
<?php endif; ?>
```

### Task 4.5 — Add `confirm()` to appointment delete buttons

**File**: `app/views/dashboard/index.php`  
**Action**: Find appointment delete forms/buttons (in the panel CRUD section and the calendar modal) and add confirmation:

Search for delete submit buttons that lack `confirm()`:
```bash
grep -n 'delete\|eliminar' app/views/dashboard/index.php | grep -i 'submit\|button\|btn'
```

Add `onclick="return confirm('¿Seguro que deseas eliminar esta cita?')"` to any delete button missing it.

## Verification

```bash
# Empty state components present
grep -c 'empty-state' app/views/dashboard/index.php   # Should be >= 5
grep 'empty-state' css/style.css                       # Should match

# Flash bar styled via CSS
grep 'flash-bar' css/style.css                         # Should match
grep 'flash-bar' app/views/dashboard/index.php         # Should match

# No inline style on flash message
# (The old massive inline style= on the flash div should be gone)

# Syntax
php -l app/views/dashboard/index.php

# Tests
php test_crud.php && php test_patient_file.php && php test_wizard_logic.php
```

## Commit

```bash
git add css/style.css app/views/dashboard/index.php
git commit -m "fix(ux): step-04 add empty states, CSS flash messages, confirm dialogs"
git push origin feature/docs-and-branding
```
