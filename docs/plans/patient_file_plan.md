# Implementation Plan: Patients Digital File CRUD

## Objective
Provide clinic administrators and medical practitioners (medicos) with a Patient Command Center. It will feature a searchable patient list and a **Digital File (Ficha Digital / Historia Clínica)** system linked to each patient.

---

## Proposed Changes

### 1. Database Schema
#### [NEW] `patient_files` Table
Create a new database table to store clinical records:
```sql
CREATE TABLE IF NOT EXISTS patient_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL UNIQUE,
    dob DATE DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    blood_type VARCHAR(10) DEFAULT NULL,
    allergies TEXT DEFAULT NULL,
    medical_history TEXT DEFAULT NULL,
    medications TEXT DEFAULT NULL,
    clinical_notes TEXT DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

### 2. Model Layer
#### [NEW] [PatientFile.php](file:///lamp/www/naxielly/app/models/PatientFile.php)
Create a model to handle queries for the digital files:
* `getOrCreateFile($patientId)`: Retrieves or instantiates a default digital file record.
* `updateFile($data)`: Saves allergies, history, medications, notes, blood type, address, and DOB.

---

### 3. Controller Layer
#### [MODIFY] [Dashboard.php](file:///lamp/www/naxielly/app/controllers/Dashboard.php)
* Load the `PatientFile` model in the constructor.
* Add a `patients()` action method:
  * Restricts access to roles `admin` and `medico`.
  * Fetches all patients (`users` role = `cliente` where `is_deleted = 0`).
  * Handles POST updates for both basic profile details (via `User` model) and digital medical file inputs (via `PatientFile` model).
  * Records detailed admin/medico audit trails for all medical file edits.

---

### 4. View Layer
#### [MODIFY] [index.php](file:///lamp/www/naxielly/app/views/dashboard/index.php)
* **Sidebar Link**: Add `fa-notes-medical` icon navigation link for the `patients` section (visible to admins and medicos).
* **Patients Section Layout**:
  * Implement a searchable directory table showing Patient ID, Name, Email, Phone, and a "Ver Ficha" action button.
* **Digital File Modal Form**:
  * Split layout: left column shows profile details and clinic records input fields (Blood Type, DOB, Allergies, Medical History, Medications, Notes). Right column displays the patient's past appointments and chat messages.
  * Form fields to submit clinical updates back to the controller action.
* **JavaScript controller**:
  * Handles opening the Digital File modal, fetching clinical records dynamically via data attributes, and clearing inputs on close.

---

### 5. Verification Plan
#### Automated Tests
* Create `test_patient_file.php` executing the lifecycle:
  1. Retrieve/instantiate a digital file for a test client.
  2. Perform updates to allergies, notes, and blood type.
  3. Validate changes are saved correctly in the database.
#### Manual Verification
* Access the patients list in browser, click "Ver Ficha", submit updates, and verify success indicators.
