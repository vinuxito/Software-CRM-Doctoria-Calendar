# Step 3: Step 3 Full (Exploración, Dolor, Cicatriz & Problemas)

## Objective
Implement physical examinations, functional assessments, conditional surgical scar tracking, visual pain scales, and identified orthopedic problems lists.

---

## 🛠️ Step 3 Components

### 1. Exploración Física (3a) & Valoración Funcional (3b)
* Inputs: Estatura (cm), Peso (kg), F/C (lpm), F/R (rpm), T/A (text input with `###/###` mmHg placeholder mask).
* Merged Height fields: Merge "Talla" and "Estatura" into a single Estatura (cm) field. If the clinic confirms Talla is a distinct measure, add it back as a separate input.
* Functional assessment textareas: Reflejos, Sensibilidad, Lenguaje/Orientación, Otros.

### 2. Cicatriz Quirúrgica (3c)
* Master Toggle: `¿Presenta cicatriz quirúrgica?` (collapsed by default).
* Toggling `Sí` reveals:
  * Sitio (text input).
  * 5 independent checkboxes (Queloide, Retráctil, Abierta, Con adherencia, Hipertrófica).
* Toggling `No` automatically clears and disables all sub-fields.

### 3. Padecimiento Actual (3d)
* Textareas: Motivo de consulta, Inicio, Evolución, Estudios, Tratamientos previos.

### 4. Valoración Dolor - EVA Slider (3e)
* UI Element: Slider from `0` to `10` with a large touch thumb.
* Feedback Widget: Emoji face + color indicator corresponding to paper values (0: Gray "Sin dolor", 2: Blue "Dolor leve", 4: Yellow "Dolor moderado", 6: Green "Dolor severo", 8: Black "Dolor muy severo", 10: Red "Máximo dolor").
* Null-Until-Touched: Stored as `NULL` in the database until the therapist interacts with it. A value of `0` represents a real answer, not a default (crucial diagnostic distinction).

### 5. Problemas Identificados (3f)
* 8 fixed rows: Dolor, Edema, Limitación articular, Contractura, Supuración, Infección, Inmovilización, Ayuda para marcha.
* Grid Columns:
  1. Problema (Static text)
  2. Severidad dropdown (`Leve` | `Moderado` | `Severo` | `No aplica` | `Unset`)
  3. Nota (short text input for specs)

---

## 🧪 Acceptance Criteria
1. EVA `NULL` is clearly distinguished from a score of `0` in database saves.
2. Disabling the scar master toggle clears and hides all sub-options.
3. Identified problems are saved in the database under `problemas`.
