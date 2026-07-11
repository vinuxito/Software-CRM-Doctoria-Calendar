# 📄 Companion Description — `Historial_clínico_corto_small.pdf`
**Purpose of this file:** verbose, page-by-page prose description of the source PDF, meant to travel *alongside* the PDF itself so any pipeline or coder ingesting the document has full human-readable context — including visual/layout information that raw text extraction loses.

---

## 1. 🪪 Document Identity

- **Title (header on every page):** `EXPEDIENTE CLÍNICO` (clinical record)
- **Owner / brand:** Naxielly Franco Ascencio — *Fisioterapeuta* (physiotherapist). Logo top-left on every page: three small icons in rounded squares (a brain in purple, a joint/bone in coral-red, a spine in violet) above the name and the word "FISIOTERAPEUTA" in letter-spaced caps.
- **Footer on every page:** `T.F. Naxielly Z. Franco Ascencio | D.G.P. 32676222 | Cel. 55 8796 4800` — set in white over a decorative footer band. D.G.P. is the Mexican professional license number (Dirección General de Profesiones), which anchors this as a **legal clinical document in Mexico**.
- **Language:** 100% Spanish (Mexican clinical vocabulary).
- **Length:** 5 pages, US-letter portrait.
- **Nature:** a **blank fill-in template**, not a filled record. Every data field is an empty underline, empty checkbox, or empty table cell. It is designed to be printed and completed by hand.

## 2. 🎨 Visual System (matters for any digital re-creation)

- **Palette:** dusty pink/rose (`~#E8A0AC` range) for section boxes and table header rows; coral-orange and purple/violet in the diagonal footer wedges; white page background; dark gray/black body text.
- **Typography:** section titles in a bold sans-serif, all caps (e.g., `DATOS DEL PACIENTE`); the fill-in labels and table body text use a **handwriting-style script font**, which gives the form its personal-clinic character.
- **Layout grammar:** rounded-corner boxes with pink borders group each section; two-column arrangement on page 1; full-width stacked sections elsewhere. Checkboxes are drawn as small pink outline squares, always in **pairs** under a `Sí / No` column header.
- **Decorative geometry:** every page bottom has overlapping diagonal triangles (purple from the left, coral from the right) forming the footer band.

## 3. 📄 Page-by-Page Content

### Page 1 — Patient data, history, physical exam

Structured as one full-width top box plus a two-column grid below it.

**Box: `DATOS DEL PACIENTE`** (full width, pink fill, white script labels)
Fields, all blank underlines:
- `Nombre:` (long line) and `Ocupación:` on the same row
- `Fecha de nacimiento:` — `Edad:` — `Sexo:` — `E. Civil:` on one row (four short fields)
- `Domicilio:` (long) — `Tel:` — `Cel:`
- `Familiar responsable:` (emergency/responsible family member) — `Tel:` — `Cel:`
Total: 12 data fields.

**Left column, box: `ANTECEDENTES PATOLÓGICOS Y HEREDOFAMILIARES`** (pathological & hereditary-family history)
A vertical checklist. Column headers: `Sí / No` (two checkboxes per item) and `Especificaciones` (a blank line per item for details). Eleven items, top to bottom:
1. Diabetes
2. Alergia (allergy)
3. HTA (hipertensión arterial)
4. Cáncer
5. Marcapasos (pacemaker — clinically critical: electrotherapy contraindication)
6. En. Reumáticas (rheumatic diseases)
7. Encames (prolonged bed confinement)
8. Accidentes
9. Cardiopatías
10. Cirugías (surgeries)
11. Fracturas

**Right column, box: `ANTECEDENTES NO PATOLÓGICOS Y SALUD`** (non-pathological/lifestyle history)
Same Sí/No + Especificaciones pattern, six items:
1. Tabaquismo (smoking)
2. Alcoholismo
3. Drogas
4. Actividad Física
5. Embarazo (pregnancy — also a treatment-modality contraindication flag)
6. Hijos (children)

**Right column, box: `VALORACIÓN FUNCIONAL`** (functional assessment)
Four blank long lines:
- `Reflejos:`
- `Sensibilidad:`
- `Lenguaje/orientación:`
- `Otros:`

**Left column, box: `EXPLORACIÓN FÍSICA`** (physical examination)
- Row 1: `Talla:` — `Peso:` — `Estatura:` ⚠️ *Note: Talla and Estatura both mean height in Mexican usage; the template carries an apparent redundancy (possibly talla = clothing size or seated height in this clinic's convention).*
- Row 2: `F/C:` (frecuencia cardíaca) — `F/R:` (frecuencia respiratoria) — `T/A:` (tensión arterial)
- `Arcos de movimiento:` (range of motion)
- `Fuerza Muscular:` (muscle strength)
- `Marcha:` (gait, free-text here; the structured gait instrument lives on pages 4–5)

**Right column, box: `CICATRÍZ QUIRÚRGICA`** (surgical scar)
- `Sitio:` (location, long line)
- One row of three short blanks: `Queloide:` — `Retractil:` — `Abierta:`
- One row of two: `Con adherencia:` — `Hipertófica:` *(sic — the template misspells "hipertrófica")*
These five scar qualities are independent descriptors, not mutually exclusive.

**Right column, small box: `NOTAS`** — an empty free-space box.

### Page 2 — Current condition, pain scale, identified problems

**Box: `PADECIMIENTO ACTUAL`** (current condition; full-width pink box, five long blank lines)
- `Motivo de consulta:` (chief complaint)
- `Inicio:` (onset)
- `Evolución:` (course/progression)
- `Estudios:` (imaging/lab studies)
- `Tratamientos previos:` (previous treatments)

**Section: `VALORACIÓN DOLOR`** (pain assessment)
A printed **EVA / visual analog pain scale graphic**: a horizontal ruler numbered `0` through `10` with tick marks, six cartoon faces below it in colored circles, each with a text label:
- 0 — gray smiling face — `Sin dolor`
- 2 — blue smiling face — `Dolor leve`
- 4 — yellow neutral face — `Dolor moderado`
- 6 — green flat/uneasy face — `Dolor severo`
- 8 — black frowning face — `Dolor muy severo`
- 10 — red crying face — `Máximo dolor`
There is no explicit answer blank; on paper the therapist circles a number. *(Note the unconventional color order — green appears at 6 "severo", darker than yellow at 4; a digital version may keep it for fidelity or fix it, but the paper is authoritative.)*

**Section: `PROBLEMAS IDENTIFICADOS`**
A two-column table. Header row (pink): `PROBLEMAS IDENTIFICADOS` | `VALORACIÓN`. Eight fixed body rows with the problem pre-printed in the left cell and an empty right cell for the therapist's valuation:
1. Dolor
2. Edema
3. Limitación articular
4. Contractura
5. Supuración
6. Infección
7. Inmovilización
8. Ayuda para marcha (gait assistance required)

### Page 3 — Treatment plan and notes

**Section: `PLAN DE TRATAMIENTO`**
A two-column table. Header row (pink): `FECHA` | `INDICACIONES (FRECUENCIA Y DURACIÓN)`. Seven empty rows follow — narrow date column on the left, wide instructions column on the right. The row count (7) is a paper-space artifact, not a clinical rule; a digital version should treat sessions as unbounded.

**Box: `NOTAS`** — a large empty pink-bordered box occupying roughly a third of the page. Rest of the page is whitespace above the footer band.

### Page 4 — Gait observation and start of the gait analysis instrument

**Box: `MARCHA / DEAMBULACIÓN`** (gait/ambulation)
Left side: a `Sí / No` checkbox pair per item, six items:
1. Libre (free/independent)
2. Claudicante (limping)
3. Con ayuda (with assistance)
4. Espásticas (spastic)
5. Atáxica (ataxic)
6. Otros
Right side: one large solid-pink `Observaciones` area shared by the whole block. These are observational descriptors and can legitimately coexist (e.g., claudicante + con ayuda).

**Section: `ANÁLISIS DE MARCHA`**
First, an illustrative **gait-cycle diagram**: stick figures walking left-to-right across the phases of the gait cycle, with Spanish phase labels (contacto de talón, pie plano, apoyo medio, despegue de talón, despegue de punta, balanceo inicial/medio/terminal, respuesta a la carga, apoyo terminal, impulso, prebalanceo). Decorative/educational — it carries no fill-in fields.

Then the scoring table begins (pink header rows for categories, white rows for scorable items, and a narrow empty score column at the far right of every row):

- **`INICIO DE LA MARCHA`** *(Inmediatamente después de decir "camine")* — gait initiation, right after saying "walk":
  - Duda, vacila o múltiples intentos para comenzar
  - No vacilante
- **`LONGITUD Y ALTURA DEL PASO`** — step length and height, eight items covering both feet:
  - El pie derecho no sobrepasa al izquierdo con el paso en la fase de balanceo.
  - El pie derecho sobrepasa al izquierdo con el paso.
  - El pie derecho no se levanta completamente del suelo con el paso en la fase de balanceo.
  - El pie derecho se levanta completamente.
  - El pie izquierdo no sobrepasa el derecho con el paso en la fase de balanceo.
  - El pie izquierdo sobrepasa al derecho con el paso.
  - El pie izquierdo no se levanta completamente del suelo con el paso en la fase de balanceo.
  - El pie izquierdo se levanta completamente.

### Page 5 — Remainder of the gait instrument and totals

The scoring table continues, same visual grammar:

- **`SIMETRÍA DEL PASO`** (step symmetry):
  - La longitud del paso con el pie derecho e izquierdo es diferente (estimada)
  - Los pasos son iguales en longitud
- **`CONTINUIDAD DE LOS PASOS`** (step continuity):
  - Para o hay discontinuidad entre los pasos
  - Los pasos son continuos
- **`TRAYECTORIA`** *(Estimada en relación a las baldosas del suelo de 30 CM; se observa la desviación de un pie en 3 MTS de distancia)* — walking path, estimated against 30 cm floor tiles over a 3 m distance:
  - Marcada desviación
  - Desviación moderada, media o utiliza ayudas
  - Derecho sin utilizar ayudas
- **`TRONCO`** (trunk):
  - Marcado balanceo o utiliza ayudas
  - No balanceo pero hay flexión de rodillas, espalda o extensión hacia afuera de los brazos
  - No balanceo ni flexión, ni utiliza ayudas
- **`POSTURA EN LA MARCHA`** (walking stance):
  - Talones separados
  - Talones casi se tocan mientras caminan
- **`RESULTADOS`** — three total rows with empty score cells:
  - Total marcha
  - Total
  - Total general

The rest of page 5 is whitespace above the footer band.

## 4. 🧠 Interpretive Notes (what the paper implies but never states)

1. **The gait instrument is the Tinetti gait subscale (POMA-G).** Item wording, the paired 0/1 options, the 0/1/2 structure of Trayectoria and Tronco, and the 30 cm / 3 m trajectory protocol all match the standard Spanish-language Tinetti gait section. Correctly scored, the pairs collapse into 10 criteria with a **maximum gait total of 12**.
2. **`Total` is orphaned.** The results table expects a second subtotal — in standard Tinetti that is the *balance* subscale (max 16, grand total 28) — but the PDF contains **no balance section anywhere**. Any faithful digitization must decide how to source that number (manual entry, added balance module, or hide).
3. **Sí/No pairs are two independent checkboxes on paper**, which physically allows contradictory or empty states. That is a paper affordance, not intent; intent is a tri-state (yes / no / not assessed).
4. **Scores per gait item are written into a blank right-hand cell**, so the paper doesn't print the 0/1/2 values — the therapist knows them by convention. Within each category the statements are mutually exclusive options of one criterion, not independent checkboxes.
5. **Clinical safety signals** embedded in the checklist: `Marcapasos` and `Embarazo` are the two items whose "Sí" changes what treatment modalities are safe (electrotherapy, certain physical agents).
6. **No consent, signature, date-of-record, or folio fields exist** anywhere in the template — worth noting for anyone extending it into a legal-grade digital record.

## 5. 📊 Field Inventory Summary

| Zone | Mechanism | Count |
|---|---|---|
| Datos del paciente | text/date blanks | 12 |
| Antecedentes patológicos | Sí/No pair + espec. line | 11 × 2 = 22 |
| Antecedentes no patológicos | Sí/No pair + espec. line | 6 × 2 = 12 |
| Valoración funcional | free-text lines | 4 |
| Exploración física | short blanks + lines | 9 |
| Cicatriz quirúrgica | 1 line + 5 short blanks | 6 |
| Notas (p.1 + p.3) | free boxes | 2 |
| Padecimiento actual | long lines | 5 |
| EVA dolor | circle-a-number graphic | 1 |
| Problemas identificados | fixed rows + valuation cell | 8 |
| Plan de tratamiento | date + instructions rows | 7 printed rows (unbounded intent) |
| Marcha/deambulación | Sí/No pairs + shared obs. | 6 pairs + 1 |
| Análisis de marcha (Tinetti) | score cells per statement | 22 statements → 10 criteria |
| Resultados | total cells | 3 |

**Rough total: ~110 fillable positions on paper, collapsing to ~75 logical data points once Sí/No pairs and Tinetti option-pairs are normalized.**
