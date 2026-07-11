# Step 6: Autosave & Offline Resilience

## Objective
Enforce autosave features, localStorage draft recovery, and offline support triggers.

---

## 💾 Autosave & Offline Sync Architecture (GC-5)

To prevent loss of patient records during clinic interruptions, we will implement an autosave layer:

### 1. LocalStorage Draft Mirror
* Every keystroke, radio toggle, or checkbox selection in the wizard is instantly saved to `localStorage` under a patient-specific draft key (e.g. `expediente_draft_{patient_id}_{timestamp}`).
* If the user accidentally closes the tab or loses power, reopening the wizard instantly detects and populates the unsaved draft from `localStorage`.

### 2. Debounced AJAX Sync
* A background auto-save event is triggered automatically:
  1. On changing wizard steps.
  2. On field blur (`blur` event on textareas and inputs).
* Changes are sent via a debounced POST request to the controller save action (`actionSave`).

### 3. Last-Write-Wins Conflict Resolution
* The controller includes a simple conflict resolution rule: the last write wins.
* The frontend displays a save timestamp (e.g. `Guardado a las 11:42 AM`).

### 4. Connection Loss Indicators
* In the event of network dropouts:
  * The system displays an offline banner: `Sin conexión. Cambios guardados localmente.`.
  * Form actions and auto-saves are queued in `localStorage` and sent once a connection is re-established.

---

## 🧪 Acceptance Criteria
1. Closing the browser tab mid-entry, reopening it, and reloading the page retains all inputs.
2. Auto-save triggers correctly on step changes and input blurs.
3. Offline banner renders when internet connectivity is lost.
