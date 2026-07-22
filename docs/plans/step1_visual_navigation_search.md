# Step 1: Smart Visual Navigation & Universal Command Palette

> **Goal**: Replace the confusing icon-only sidebar with a high-contrast, labeled sidebar navigation with badges and tooltips, and add a global `Cmd/Ctrl + K` Command Palette for instant search across patients, appointments, doctors, and actions.

---

## Proposed Changes

### 1. View Layer
#### [MODIFY] [index.php](file:///lamp/www/naxielly/app/views/dashboard/index.php)
- Replace icon-only sidebar buttons with explicit labeled links (Icon + Label + Active Indicator):
  - `Panel de Control` (`fa-chart-line`)
  - `Agenda de Citas` (`fa-calendar-alt`)
  - `Expedientes Clínicos` (`fa-notes-medical`)
  - `Especialistas / Médicos` (`fa-user-md`)
  - `Facturación CFDI` (`fa-file-invoice-dollar`)
  - `Mensajes` (`fa-comment-alt`)
  - `Usuarios` (`fa-users-cog`)
  - `Mi Perfil` (`fa-user`)
  - `Configuración` (`fa-cogs`)
- Add a top search bar in the main layout with a shortcut pill `Ctrl + K`.

#### [NEW] [command_palette.php](file:///lamp/www/naxielly/app/views/inc/command_palette.php)
- Modal overlay activated by `Cmd/Ctrl + K` or clicking top search.
- Live search input that filters matching patients, appointments, specialists, and quick actions (e.g., "Nueva Cita", "Ver Expediente de...").

---

### 2. JavaScript Layer
#### [NEW] [command_palette.js](file:///lamp/www/naxielly/js/sections/command_palette.js)
- Global keydown listener for `Ctrl+K` and `Cmd+K`.
- AJAX search fetch endpoint `/dashboard/globalSearch?q=...` returning JSON results grouped by category.

---

### 3. Controller & Model Layer
#### [MODIFY] [Dashboard.php](file:///lamp/www/naxielly/app/controllers/Dashboard.php)
- Add `globalSearch()` method returning JSON formatted results across `users`, `appointments`, and `expedientes`.

---

## Verification Plan
1. Open dashboard in browser: verify sidebar displays visible text labels next to every icon.
2. Press `Ctrl + K` or `Cmd + K`: verify Command Palette opens.
3. Type patient name (e.g., "Pepe"): verify matching patient record appears and clicking it opens their expediente directly.
