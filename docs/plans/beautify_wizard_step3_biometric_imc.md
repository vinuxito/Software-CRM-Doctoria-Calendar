# Step 3: Biometric Visual Scales & Smart Input Masks

This step introduces visual calculators for patient biometrics and refines the EVA pain slider with high-fidelity emoji transformations.

---

## 🎨 Changes to Implement

### 1. BMI (IMC) Real-Time Visual Gauge
In Step 3 (Exploración):
* Calculate IMC automatically when the doctor edits height (*Estatura*) and weight (*Peso*):
  $$\text{IMC} = \frac{\text{Peso (kg)}}{\left(\frac{\text{Estatura (cm)}}{100}\right)^2}$$
* Render a colored horizontal meter below the biometric input grid:
  - Blue: Underweight (< 18.5)
  - Green: Healthy Weight (18.5 - 24.9)
  - Yellow: Overweight (25 - 29.9)
  - Red: Obese (>= 30)
* A small visual needle indicator slides in real-time along the gauge track based on the computed score.

### 2. Blood Pressure (TA) Autocomplete Mask
* Listen to keypresses on the blood pressure input:
  - Automatically format numbers as `SYS/DIA` (e.g. typing `12080` inserts `/` to output `120/80`).
  - Restrict input to digits and slashes only, protecting the schema against invalid string configurations.

### 3. High-Fidelity EVA Pain Tracker
* Style the EVA Pain scale track with a soft linear gradient representing pain intensity (Green ➔ Yellow ➔ Red).
* When sliding the thumb, apply a pulsing zoom effect (`transform: scale(1.3) rotate(5deg);`) to the selected pain face emoji.
* Display descriptive helper text beneath the face (e.g., "Sin dolor", "Dolor insoportable") for precise visual diagnostics.

---

## 🧪 Verification Plan

1. **BMI Calculator Check**: Input `175` cm and `78.5` kg and verify the IMC needle points correctly to the Overweight area (25.6).
2. **Input Mask Check**: Verify typing blood pressure formats and filters out letters.
