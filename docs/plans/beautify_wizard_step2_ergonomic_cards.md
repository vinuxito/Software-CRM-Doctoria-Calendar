# Step 2: Touch-First Toggle Cards & Option Chips

This step improves tablet speed and readability by replacing traditional drop-down selects and checkboxes with tactile, visual cards and option chips.

---

## 🎨 Changes to Implement

### 1. Replace Select Inputs with Option Chips
Instead of standard dropdown selects for **Sexo** and **Estado Civil**:
* Hide the raw select element from view but keep it in the DOM to preserve JS data binding.
* Render horizontal rows of interactive option chips:
  ```html
  <div class="option-chips-container" data-target="patient-sexo">
      <button type="button" class="option-chip" data-value="Femenino">Femenino</button>
      <button type="button" class="option-chip active" data-value="Masculino">Masculino</button>
      <button type="button" class="option-chip" data-value="Otro">Otro</button>
  </div>
  ```
* Write Javascript listeners to sync chip clicks to the hidden select's value.

### 2. Styling Segmented Option Cards
Refine the segmented buttons layout inside **Antecedentes** (Step 2):
* When "Sí" is active, display a soft coral fill: `background: #FEE2E2; color: #991B1B; border: 1.5px solid #FCA5A5;`.
* When "No" is active, display a soft mint fill: `background: #D1FAE5; color: #065F46; border: 1.5px solid #6EE7B7;`.
* When "N/A" is active, display a neutral gray fill: `background: #F3F4F6; color: #374151; border: 1.5px solid #D1D5DB;`.

### 3. Smooth Expanding Textareas for Antecedentes Specs
* Add a soft dynamic transition (`transition: max-height 0.3s ease-out, opacity 0.2s ease-out;`) to specification text inputs.
* Slide inputs open smoothly only when "Sí" is tapped, keeping the form compact when no anomalies exist.

---

## 🧪 Verification Plan

1. **Interactivity Check**: Ensure tapping on a chip updates the form's internal value correctly.
2. **Layout Check**: Verify option cards layout fits columns cleanly on portrait tablets.
