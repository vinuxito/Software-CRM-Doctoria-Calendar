# Step 4: Empty States & User Feedback

**Category**: UX / Product  
**Impact**: 🟠 High  
**Complexity**: Low-Medium (HTML additions, minimal logic)  
**Estimated effort**: 3-4 hours

---

## Why It Matters Now

When a section has no data, the user sees... nothing. An empty table body. A blank calendar. An empty grid. This communicates "broken" to a non-technical user, not "no data yet."

**Current empty-state coverage**:
| Section | Has Empty State? | What Happens |
|---------|-----------------|-------------|
| Calendar | ❌ No | Blank calendar grid, no guidance |
| Doctors | ❌ No | Empty grid, nothing rendered |
| Chat | ✅ Yes | "Selecciona un chat para comenzar" with icon |
| Panel (KPIs) | ❌ No | KPI cards show "0", tables render empty |
| Panel (pending) | ❌ No | Empty table body |
| Patients | ❌ No | Table header with empty `<tbody>` |
| Users | ❌ No | Table header with empty `<tbody>` |
| Settings | N/A | Static content, always has data |
| Profile | N/A | Always has user data |

**1 out of 7 applicable sections has an empty state.** The chat module got it right — the others need the same treatment.

## What Exactly Should Be Done

### 1. Add empty-state blocks to each section

Each empty state should follow this pattern:
```html
<?php if (empty($data['items'])) : ?>
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-[relevant-icon]"></i></div>
        <h4>[Short, clear message]</h4>
        <p>[What to do next]</p>
        <?php if ($canCreate) : ?>
            <a href="[create-url]" class="btn-configurar">[Action button]</a>
        <?php endif; ?>
    </div>
<?php else : ?>
    <!-- existing table/grid -->
<?php endif; ?>
```

### 2. Specific empty states needed

| Section | Icon | Heading | Help Text | Action |
|---------|------|---------|-----------|--------|
| Calendar (no events) | `fa-calendar-plus` | "No hay citas programadas" | "Haz clic en una fecha del calendario para agendar tu primera cita" | — (calendar click does it) |
| Doctors (no doctors) | `fa-user-md` | "No hay especialistas registrados" | "Los médicos aparecerán aquí cuando un administrador los registre" | — (admin action) |
| Panel pending (no pending) | `fa-check-circle` | "No hay citas pendientes" | "Todas las citas están al día" | — (positive empty state) |
| Panel CRUD (no appointments) | `fa-calendar-alt` | "No hay citas en el sistema" | "Las citas aparecerán aquí cuando se agenden desde el calendario" | "Ir al Calendario" link |
| Patients (no patients) | `fa-notes-medical` | "No hay expedientes clínicos" | "Los expedientes se crean automáticamente cuando se registran pacientes" | — |
| Users (no users) | `fa-users` | "No hay usuarios registrados" | "Crea el primer usuario para comenzar" | "Crear Usuario" button |

### 3. Style the empty-state component

Add to `style.css`:
```css
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
    color: var(--text-primary);
    margin-bottom: 8px;
}
.empty-state p {
    font-size: 14px;
    max-width: 400px;
    margin: 0 auto 20px;
}
```

### 4. Add flash message standardization

Currently the flash message uses a regex to detect success vs. error (L82-84):
```php
$isError = preg_match('/(error|incorrecto|ya está|no puedes|no válido|campos obligatorios|completados)/i', $data['flash']);
```

This is fragile. Add a `flash_type` to the data array (`success`, `error`, `info`) so the controller explicitly sets the style, rather than pattern-matching message text.

### 5. Add confirmation for destructive appointment actions

Currently only user deletion has `confirm()`. The appointment delete button (L140) submits directly. Add:
```html
<button type="submit" onclick="return confirm('¿Seguro que deseas eliminar esta cita?')">Eliminar</button>
```

## What Existing Work It Builds On

- The chat empty state (L221-224) already establishes the pattern: icon + message + centered layout
- The flash message system (L80-90) already works, just needs explicit typing
- The wizard already has excellent feedback (autosave status, contraindication warnings, offline banner)

## What Risks It Avoids

- **"Is it broken?" questions**: An empty table looks like a loading failure to non-technical users
- **Accidental data deletion**: No confirmation on appointment delete means one click destroys data
- **Support calls**: "I can't see any patients" — because there are none, but the user thinks the system is broken

## Expected Payoff

Every section of the app communicates its state clearly. Empty = helpful guidance, not silence. Destructive actions require confirmation. The app feels complete even when data is sparse (which is the normal state for a new installation).

## Definition of Done (Testable Acceptance Criteria)

1. Each section (calendar, doctors, panel, patients, users) shows a descriptive empty state when no data exists
2. Empty state includes an icon, a heading, and help text
3. `grep -c 'empty-state' app/views/dashboard/index.php` returns ≥ 5
4. `grep 'empty-state' css/style.css` returns matches (component is styled in CSS, not inline)
5. Appointment delete button has `confirm()` protection
6. Flash messages use explicit `flash_type` instead of regex text matching
7. Manual check: create a test user with no appointments → navigate calendar → see empty state
8. All test suites pass
