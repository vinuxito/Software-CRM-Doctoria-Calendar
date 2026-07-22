# Step 2: Interactive Anatomical Body Map & Pain Charting

> **Goal**: Integrate an interactive 2D anatomical body diagram (Anterior/Posterior view) into Step 3 (Exploración Física) of the clinical intake wizard, allowing therapists to click/tap anatomical regions to record pain points, EVA severity scale (1-10), and treatment targets visually.

---

## Proposed Changes

### 1. Database Schema
#### Schema Update in `setup.sql` & Migration Script
```sql
CREATE TABLE IF NOT EXISTS dolor_puntos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    expediente_id INT NOT NULL,
    region VARCHAR(50) NOT NULL, -- e.g., 'hombro_derecho', 'lumbar', 'rodilla_izquierda'
    vista VARCHAR(20) NOT NULL DEFAULT 'anterior', -- 'anterior' or 'posterior'
    eva_nivel INT NOT NULL DEFAULT 5, -- 1 to 10
    tipo_dolor VARCHAR(50) DEFAULT 'sordo', -- 'punzante', 'sordo', 'urente', 'opresivo'
    notas VARCHAR(255) DEFAULT NULL,
    pos_x FLOAT NOT NULL, -- percentage coordinate for pin SVG overlay
    pos_y FLOAT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (expediente_id) REFERENCES expedientes(id) ON DELETE CASCADE
);
```

---

### 2. View & Asset Layer
#### [MODIFY] [patients.php](file:///lamp/www/naxielly/app/views/dashboard/sections/patients.php)
- In Step 3 (`#step-content-3`), add an interactive dual-view anatomical SVG canvas (Front & Back human body silhouette).
- Add pin placement controls, EVA slider (1-10), pain quality chips (Punzante, Urente, Sordo, Opresivo), and active pain points table.

#### [NEW] [body_map.svg / Inline SVG](file:///lamp/www/naxielly/app/views/inc/body_map_svg.php)
- Clean vector anatomical outline (human posture silhouette anterior/posterior) with clickable coordinate region zones.

---

### 3. Model & Controller Layer
#### [MODIFY] [Expediente.php](file:///lamp/www/naxielly/app/models/Expediente.php)
- Add `savePuntosDolor($expedienteId, $puntos)` and `getPuntosDolor($expedienteId)`.
- Update `loadExpedienteData` and `saveExpedienteData` to include anatomical pain points.

#### [MODIFY] [patients.js](file:///lamp/www/naxielly/js/sections/patients.js)
- Implement interactive click handler on body canvas to drop pain pins (`.pain-pin-dot`), open quick pin config popover, and serialize pins into the JSON payload sent to `/dashboard/saveExpediente`.

---

## Verification Plan
1. Open Patient Expediente Wizard -> Go to Step 3 (Exploración Física).
2. Click on the right shoulder of the anatomical silhouette: verify red pain pin appears at click coordinates.
3. Set EVA scale slider to 8 and select "Punzante": verify pin updates visually and point is saved to DB draft.
4. Close and reopen wizard: verify pain pin persists at exact SVG coordinates.
