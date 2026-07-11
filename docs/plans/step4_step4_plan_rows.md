# Step 4: Step 4 Treatment Plan Rows

## Objective
Implement a dynamic treatment session planner using repeatable row components, ordering keys, and safety alerts.

---

## 🛠️ Dynamic Session Component (`RepeatableRow`)

Rather than limiting sessions to Naxielly's paper-space restriction (7 rows), we will implement a dynamic, infinite session manager:

* **Session Row Fields**:
  * Date picker.
  * Indicaciones (frecuencia y duración) textarea.
  * Remove button.
* **Control Actions**:
  * `+ Agregar sesión`: Appends a blank session row.
  * Start with one empty row on new intake files.
* **Stable Ordering**:
  * Each session row carries a hidden `orden` integer field to preserve sorting sequence during additions or removals.
  * Deleting a middle row updates the remaining ordering keys to preserve the sequence.
* **Empty Row Exclusion**:
  * Empty session rows (where date and indications are blank) are ignored and not saved to the database.

---

## 🚨 Badges Echo
* Display the Step 2 clinical warning badges (`Marcapasos` or `Embarazo`) prominently above the treatment plan rows to remind the therapist before writing daily indications.

---

## 🧪 Acceptance Criteria
1. At least 1 row is saved. Dynamic rows (1..N) persist with stable ordering.
2. Deleting a middle row preserves the visual sequence and correct indices.
3. Empty rows are skipped during database writes.
