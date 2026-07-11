<?php
require_once 'config/config.php';
require_once 'app/core/Database.php';
require_once 'app/models/User.php';
require_once 'app/models/PatientFile.php';

$userModel = new User();
$patientFileModel = new PatientFile();

echo "Running Patient Digital File CRUD Tests...\n";

// 1. Retrieve the patient Pepe Paciente (ID 5)
$patient = $userModel->getUserById(5);
if (!$patient || $patient->role !== 'cliente') {
    die("ERROR: Test patient Pepe Paciente (ID 5) not found.\n");
}
echo "✓ Test patient Pepe Paciente found.\n";

// 2. Get or create clinical record
$record = $patientFileModel->getOrCreateFile(5);
if (!$record || (int)$record->patient_id !== 5) {
    die("ERROR: Failed to retrieve or create clinical record for Pepe.\n");
}
echo "✓ Clinical record initialized/retrieved successfully.\n";

// 3. Update clinical record
$updateData = [
    'patient_id' => 5,
    'dob' => '1985-05-15',
    'address' => 'Avenida Principal 123',
    'blood_type' => 'O+',
    'allergies' => 'Penicilina y mariscos',
    'medical_history' => 'Hipertensión arterial controlada',
    'medications' => 'Losartán 50mg diario',
    'clinical_notes' => 'Paciente refiere sentirse bien hoy. Presión arterial dentro del rango normal.'
];

$updated = $patientFileModel->updateFile($updateData);
if (!$updated) {
    die("ERROR: Failed to update clinical record.\n");
}

$recordUpdated = $patientFileModel->getOrCreateFile(5);
if ($recordUpdated->dob !== '1985-05-15' || 
    $recordUpdated->address !== 'Avenida Principal 123' || 
    $recordUpdated->blood_type !== 'O+' || 
    $recordUpdated->allergies !== 'Penicilina y mariscos' || 
    $recordUpdated->medical_history !== 'Hipertensión arterial controlada' || 
    $recordUpdated->medications !== 'Losartán 50mg diario' || 
    $recordUpdated->clinical_notes !== 'Paciente refiere sentirse bien hoy. Presión arterial dentro del rango normal.') {
    die("ERROR: Updated clinical record values do not match.\n");
}
echo "✓ Updated clinical record verified successfully.\n";

echo "ALL PATIENT CLINICAL FILE TESTS PASSED!\n";
