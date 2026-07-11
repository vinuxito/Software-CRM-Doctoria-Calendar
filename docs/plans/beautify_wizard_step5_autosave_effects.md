# Step 5: Autosave Feedback Loops & Final Verification

This step implements minor UI details, including a pulsing status light, scroll boundaries, and final QA verification.

---

## 🎨 Changes to Implement

### 1. Autosave Glowing status light
In the wizard header next to the status message:
* Render a glowing pulse dot (`.autosave-glow-dot`):
  - **Saving**: Green pulsing light.
  - **Saved**: Static green light that gently fades out.
  - **Error/Offline**: Solid red warning indicator.
* Apply keyframe animations (`@keyframes pulse`) to create a smooth breathing effect.

### 2. Scroll Boundary Fade Gradients
When modal step content has scrollable vertical contents:
* Add a soft background linear-gradient shadow (`linear-gradient(to top, rgba(255,255,255,1), rgba(255,255,255,0))`) to indicate there is more scrollable content.
* The shadow dynamically fades away when the user reaches the bottom of the container.

### 3. Final Validation check
Run E2E verification to ensure:
* All form elements populate and save correctly.
* Performance parameters (CWV/INP) are under 100ms for all step switches.
* Git commits are pushed cleanly to the default active branch.

---

## 🧪 Verification Plan

1. **Autosave Visual**: Check that editing a field causes the status light to pulse green, then transition to static green on save.
2. **Offline Check**: Simulate offline mode in devtools and check that the indicator glows red.
