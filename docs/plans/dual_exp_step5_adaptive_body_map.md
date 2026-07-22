# Step 5: Adaptive Anatomical Body Map (Desktop Silhouette vs Mobile Touch Zones)

## Objective
Adapt the interactive anatomical body map canvas (`dolor_puntos`) to provide two specialized rendering modes: a high-precision multi-angle vector silhouette canvas for Desktop Workbench, and an ergonomic anatomical region touch selector for Mobile Remote.

## User Value
- **Desktop Users**: Precise SVG vector coordinate pin placement with detailed EVA pain sliders (1-10) and notes.
- **Mobile Users**: Large tap targets for anatomical zones (e.g. *Hombro Der*, *Cervicales*, *Lumbar*, *Rodilla Izq*) avoiding tiny pin precision issues on small touch screens.

## Files or Modules Likely Affected
- **Views**: `app/views/inc/body_map_svg.php`, `app/views/dashboard/sections/patients.php`.
- **JS**: `js/sections/patients.js` (Add viewport breakpoint detection for body map mode).
- **CSS**: `css/style.css` (Mobile anatomical region grid styles).

## Implementation Plan
1. **Desktop Workbench Canvas Mode**:
   - Renders 2D SVG vector silhouette with precise `pos_x` and `pos_y` percentage positioning.
   - Shows hover tooltips with region name, EVA scale rating, and pain type.
2. **Mobile Remote Touch Grid Mode**:
   - On screens `< 768px`, transforms the SVG canvas into a responsive 2-column anatomical region grid card list (*Cervicales*, *Hombro Derecho*, *Zona Lumbar*, *Cadera*, *Rodilla*).
   - Tapping an anatomical region card slides up a simple EVA pain slider modal (1 to 10).

## UX Expectations
- On mobile, therapists don't have to pinch-zoom or squint to tap tiny SVG coordinates; large touch buttons make recording pain areas effortless.

## Security Considerations
- Data structure remains identical (`dolor_puntos` table); mode switching is purely presentation layer adaptation.

## Failure Cases
- **Orientation Change**: Dynamically switches rendering mode if phone is rotated from portrait to landscape.

## Test Plan
- Write `test_adaptive_body_map.js` verifying region card selection formats valid JSON payload compatible with `Expediente::savePainPins`.

## Verification Evidence
- CLI execution output confirming JSON payload compatibility between Desktop pin coordinates and Mobile touch region cards.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("AUDIT LOG: Body map pain pin added via [desktop_canvas/mobile_region_grid]")`.

## Definition of Done
- Dual rendering modes functional for desktop and mobile.
- Pain points save seamlessly to DB regardless of input device.

## Next Logical Step
Proceed to **Step 6: PWA Manifest, Service Worker & Offline Sync Queue**.
