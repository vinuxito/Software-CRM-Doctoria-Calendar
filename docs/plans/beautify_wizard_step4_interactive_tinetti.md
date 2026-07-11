# Step 4: Redesigned Tinetti Segmented Slider Cards

This step transforms the dense list of Tinetti criteria in Step 5 into a set of interactive segmented buttons, and introduces a floating circular score indicator.

---

## 🎨 Changes to Implement

### 1. Segmented Choice Cards for Tinetti
Each criteria block in the Tinetti evaluation is currently rendered as basic radio circles. We will:
* Re-style these options into a row of responsive cards (`.tinetti-segmented-row`):
  ```html
  <div class="tinetti-option-card" data-value="0">
      <strong>0</strong>
      <span>Inestable</span>
  </div>
  ```
* Apply hover scaling effects and a bright border highlights on selected options.

### 2. Floating Live Score Ring
* Position a floating visual indicator (`.tinetti-score-badge`) in the bottom corner of Step 5.
* Use a circular SVG progress ring that fills up dynamically in brand green or warning red based on the total score:
  - High risk of falls: < 19 (Red ring)
  - Moderate risk of falls: 19 - 24 (Yellow ring)
  - Low risk of falls: >= 25 (Green ring)
* The badge text dynamically updates to reflect current total (e.g. `24 / 28`).

---

## 🧪 Verification Plan

1. **Selection Sync**: Verify clicking a card updates the hidden radio option correctly.
2. **Total Score Calc**: Verify selecting multiple options correctly calculates and updates the SVG progress ring color.
