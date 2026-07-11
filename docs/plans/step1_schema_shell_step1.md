# Step 1: Schema + Shell + Step 1

## Objective
Establish the relational tables, build the class-based AJAX responders, design the wizard shell layout, and implement the initial "Datos del Paciente" panel.

---

## 🛠️ Schema Configuration

We will execute database migrations to define the target tables:
1. **`patients`**: Person master record (`id`, `nombre`, `ocupacion`, `fecha_nacimiento`, `sexo`, `estado_civil`, `domicilio`, `tel`, `cel`, `familiar_responsable`, `familiar_tel`, `familiar_cel`).
2. **`expedientes`**: One visit intake cycle; owns records below (`id`, `patient_id`, `status` [draft/complete], `eva_dolor`, `notas_generales`, `notas_plan`).
3. **`antecedentes`**: Yes/No/Unset items (`id`, `expediente_id`, `grupo` [patologico/no_patologico], `item_key`, `valor`, `especificacion`).
4. **`exploraciones`**: Physical stats (`estatura_cm`, `peso_kg`, `fc`, `fr`, `ta`, `arcos_movimiento`, `fuerza_muscular`, `marcha_descriptiva`, `reflejos`, `sensibilidad`, `lenguaje_orientacion`, `otros`).
5. **`cicatrices`**: Surgical scar info (`presenta`, `sitio`, `queloide`, `retractil`, `abierta`, `con_adherencia`, `hipertrofica`).
6. **`padecimientos`**: Current condition notes (`motivo_consulta`, `inicio`, `evolucion`, `estudios`, `tratamientos_previos`).
7. **`problemas`**: Identified concerns (`id`, `expediente_id`, `item_key`, `severidad` [leve/moderado/severo/na/null], `nota`).
8. **`plan_sesiones`**: Treatment plan logs (`id`, `expediente_id`, `fecha`, `indicaciones`, `orden`).
9. **`marchas`**: Gait checklist and Tinetti score points.

---

## 🧱 PHP Responders (GC-1)
Create `ExpedienteController.php` matching the existing MVC architecture to process requests:
* `actionCreate()`: Initializes a draft.
* `actionLoad($id)`: Returns data payload as JSON.
* `actionSave()`: Parses payload, saves entities, and recalculates values.

---

## 🎨 UI Wizard Shell & Step 1
* **Progress Bar**: Non-numbered step markers (Datos del Paciente, Antecedentes, Exploración, Plan de Tratamiento, Marcha).
* **Autosave Status Indicator**: Shows `Guardado hace X segundos`.
* **Step 1 Inputs**: Mirror Naxielly's form (Nombre, Ocupación, Fecha de Nacimiento, Edad, Sexo, Estado Civil, Domicilio, Phone values, emergency contact details).
* **Edad Autocompute**: JavaScript recalculates Age based on DOB change. If DOB is empty, the input becomes editable (GC-7).

---

## 🧪 Acceptance Criteria
1. Draft is successfully created in database.
2. Form captures basic parameters and autocomputes age.
3. Refreshing reloads saved draft details.
