# Step 1: Color Tokens & Input Glow States

This step establishes the visual foundation of the beautification round. It focuses on declaring a modern clinical-grade CSS theme, typography hierarchy, and glowing active states for inputs.

---

## 🎨 Changes to Implement

### 1. Define Modern HSL Variables in CSS
We will declare variables inside the style tag of `app/views/dashboard/index.php`:
```css
:root {
    --brand-pink: #E8A0AC;
    --brand-pink-glow: rgba(232, 160, 172, 0.22);
    --brand-green-success: #7FB8A6;
    --brand-green-glow: rgba(127, 184, 166, 0.15);
    --warning-ochre: #E5A87B;
    --critical-rose: #D66F7C;
    --slate-text: #2D3748;
    --slate-muted: #718096;
    --bg-light-gray: #F7FAFC;
    --bg-input: #FFFFFF;
    --border-gray: #E2E8F0;
    --font-heading: 'Outfit', 'Plus Jakarta Sans', system-ui, sans-serif;
    --font-body: 'Inter', system-ui, sans-serif;
}
```

### 2. Styling Global Inputs Focus & Hover states
All text inputs, select comboboxes, and textareas inside the wizard modal will get smooth micro-transitions:
* **Focus State**:
  - Border transitions to `var(--brand-pink)`.
  - Box-shadow gets a soft radial glow: `box-shadow: 0 0 0 4px var(--brand-pink-glow)`.
  - Background transitions to pure white.
* **Hover State**:
  - Border transitions to a slightly darker gray (`#CBD5E0`).
  - Subtle drop-shadow appears to indicate interactivity.
```css
.calendar-modal-form input, 
.calendar-modal-form select, 
.calendar-modal-form textarea {
    font-family: var(--font-body);
    font-size: 14px;
    color: var(--slate-text);
    border: 1.5px solid var(--border-gray);
    background-color: var(--bg-light-gray);
    border-radius: 8px;
    padding: 10px 14px;
    min-height: 44px;
    transition: all 0.2s ease-in-out;
}
```

### 3. Typography Realignment
Apply modern fonts to the wizard modal:
- Modal headers (`h3`, `h4`) get `var(--font-heading)` with a semi-bold weight.
- Labels get a slightly bolder weight (`font-weight: 600`) and a softer color (`var(--slate-muted)`) to make inputs pop.

---

## 🧪 Verification Plan

1. **Syntax Check**: Run `php -l app/views/dashboard/index.php` to ensure style injection does not break template syntax.
2. **Visual Check**: Open any patient expediente inside the browser and verify inputs are highlighted in soft pink on focus and outline curves render cleanly.
