# Step 2: ToggleWithSpec Component & Step 2

## Objective
Build the reusable three-state segmented toggle control (`ToggleWithSpec`) for pathological and non-pathological checklist items and establish critical warning triggers.

---

## 🛠️ Reusable Component: `ToggleWithSpec` (GC-6)
To avoid paper's contradictory double checkboxes, we will build a segmented control in CSS/JS:
* **States**: `Sí` | `No` | `Unset` (default status is unset).
* **Specifications Area**: Selecting `Sí` slides down a text input (`Especificaciones`) with a CSS height transition. Selecting `No` or clicking `Unset` hides the input and clears its content.
* **Declarative Configuration**: Instantiated 17 times using a configuration array:
  ```json
  [
    {"key": "diabetes", "label": "Diabetes", "grupo": "patologico"},
    {"key": "alergia", "label": "Alergia", "grupo": "patologico"},
    {"key": "hta", "label": "HTA", "grupo": "patologico"},
    {"key": "cancer", "label": "Cáncer", "grupo": "patologico"},
    {"key": "marcapasos", "label": "Marcapasos", "grupo": "patologico"},
    {"key": "reumaticas", "label": "Enf. Reumáticas", "grupo": "patologico"},
    {"key": "encames", "label": "Encames", "grupo": "patologico"},
    {"key": "accidentes", "label": "Accidentes", "grupo": "patologico"},
    {"key": "cardiopatias", "label": "Cardiopatías", "grupo": "patologico"},
    {"key": "cirugias", "label": "Cirugías", "grupo": "patologico"},
    {"key": "fracturas", "label": "Fracturas", "grupo": "patologico"},
    {"key": "tabaquismo", "label": "Tabaquismo", "grupo": "no_patologico"},
    {"key": "alcoholismo", "label": "Alcoholismo", "grupo": "no_patologico"},
    {"key": "drogas", "label": "Drogas", "grupo": "no_patologico"},
    {"key": "actividad_fisica", "label": "Actividad Física", "grupo": "no_patologico"},
    {"key": "embarazo", "label": "Embarazo", "grupo": "no_patologico"},
    {"key": "hijos", "label": "Hijos", "grupo": "no_patologico", "placeholder": "¿Cuántos?"}
  ]
  ```

---

## 🚨 Clinical Warning Badges
* If `Marcapasos` is toggled `Sí` or `Embarazo` is toggled `Sí`:
  * Display a persistent, red warning badge: `Contraindicación posible: verificar modalidades de electroterapia / agentes físicos`.
  * The warning badge must render inside Step 2 and echo at the top of the treatment plan header in Step 4.
  * The badge is strictly informational and does not block form submissions (GC-4).

---

## 🧪 Acceptance Criteria
1. Toggles persist tri-state correctly in the database.
2. Clicking `Sí` reveals the specifications text input with a slide animation.
3. Warning badges appear immediately and survive reload.
