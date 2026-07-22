# Step 6: PWA Manifest, Service Worker & Offline Sync Queue

## Objective
Convert Doctoria CRM into an installable Progressive Web App (PWA) with a Service Worker caching core assets and an IndexedDB offline mutation queue, allowing therapists to complete intake forms and record patient notes even when internet connection drops.

## User Value
- **Installable Native App Feel**: Therapists can tap "Agregar a la Pantalla de Inicio" on iOS/Android or Chrome Desktop to install Doctoria CRM as an app with no browser address bar.
- **Offline Resilience**: Intake forms completed offline are queued locally and automatically synced to the server once connectivity is restored.

## Files or Modules Likely Affected
- **PWA Assets**: Create `manifest.json`, `sw.js` (Service Worker).
- **Views**: `app/views/inc/header.php` (Include manifest & service worker registration tag).
- **JS**: `js/sections/offline_queue.js` (IndexedDB offline mutation manager).

## Implementation Plan
1. **PWA Manifest Setup**:
   ```json
   {
     "name": "Doctoria CRM & Calendar",
     "short_name": "Doctoria",
     "start_url": "/naxielly/dashboard",
     "display": "standalone",
     "background_color": "#0f172a",
     "theme_color": "#00a29a",
     "icons": [
       { "src": "img/icon-192.png", "sizes": "192x192", "type": "image/png" },
       { "src": "img/icon-512.png", "sizes": "512x512", "type": "image/png" }
     ]
   }
   ```
2. **Service Worker Caching Strategy**:
   - Cache static assets (CSS, JS, FontAwesome, Google Fonts) with Cache-First strategy.
   - Dynamic API endpoints use Network-First with IndexedDB fallback.
3. **Offline Sync Queue**:
   - When offline, form submissions (intake wizard, appointment creation) are stored in IndexedDB `offline_queue`.
   - `window.addEventListener('online')` triggers automated background replay of queued requests.

## UX Expectations
- Top header banner displays a subtle green banner when back online: *"Conexión restablecida — Sincronizando 2 formularios pendientes..."*.

## Security Considerations
- Offline IndexedDB data is encrypted at rest using browser origin isolation; credentials are wiped on logout.

## Failure Cases
- **Service Worker Unsupported**: Legacy browsers ignore service worker registration and fall back to standard web behavior cleanly.

## Test Plan
- Write `test_pwa_manifest.php`:
  1. Verify `manifest.json` accessibility and valid JSON schema.
  2. Verify `sw.js` asset caching route headers.

## Verification Evidence
- Terminal output confirming `manifest.json` HTTP 200 response and valid JSON syntax.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("AUDIT LOG: Offline sync queue flushed. Synced [count] mutations.")`.

## Definition of Done
- PWA manifest and Service Worker active.
- App installable on mobile and desktop devices.
- Offline queue sync functional.

## Next Logical Step
Execute the Dual-Experience Layer plan set sequentially!
