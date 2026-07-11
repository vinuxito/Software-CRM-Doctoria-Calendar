# Step 5: Step 5 Gait & Scoring (Tinetti)

## Objective
Implement gait observation parameters, the 10 scored categories of the Tinetti gait subscale, and the manual balance subscale calculator.

---

## 🛠️ Step 5 Components

### 1. Marcha / Deambulación (5a)
* **Checkboxes**: 6 independent checkboxes (Libre, Claudicante, Con ayuda, Espásticas, Atáxica, Otros).
* **Otros Input**: Checking `Otros` reveals a small text field to specify.
* **Observaciones**: A shared textarea block for notes.

### 2. Análisis de Marcha - Scored Radio Toggles (5b)
The 10 categories of the Tinetti Gait Subscale (POMA-G) will be implemented as mutually exclusive radio groups showing the points next to the label:
1. **Inicio de la marcha**: Duda, vacila (0) | No vacilante (1).
2. **Paso derecho, longitud**: No sobrepasa izquierdo (0) | Sobrepasa izquierdo (1).
3. **Paso derecho, altura**: No se levanta (0) | Se levanta completamente (1).
4. **Paso izquierdo, longitud**: No sobrepasa derecho (0) | Sobrepasa derecho (1).
5. **Paso izquierdo, altura**: No se levanta (0) | Se levanta completamente (1).
6. **Simetría del paso**: Longitud diferente (0) | Pasos iguales (1).
7. **Continuidad de los pasos**: Paro/discontinuidad (0) | Pasos continuos (1).
8. **Trayectoria**: Marcada desviación (0) | Desviación moderada (1) | Derecho sin ayudas (2).
9. **Tronco**: Marcado balanceo (0) | No balanceo pero flexión/brazos extensión (1) | No balanceo ni ayudas (2).
10. **Postura en la marcha**: Talones separados (0) | Talones casi se tocan (1).

---

## 📐 Scoring Calculations & Decision D-2
* **Total Marcha**: Dynamically calculated sum of the 10 items (maximum 12).
* **Total Equilibrio (manual)**: Since the template expects a total score but lacks the physical balance subscale items, we will provide a manual numeric input from `0` to `16` (labeled `Total equilibrio (manual)`).
* **Total General**: Dynamically calculated sum of `Total Marcha` + `Total Equilibrio` (maximum 28).
* **Server-Side Recomputation**: All totals are recalculated on the server side on save to verify data integrity (GC-7).

---

## 🧪 Acceptance Criteria
1. Total marcha score maxes out at 12.
2. Total general score aggregates gait + manual balance (max 28).
3. Totals display correctly during partial entries.
