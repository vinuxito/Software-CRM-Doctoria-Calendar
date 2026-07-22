<?php
require_once 'config/config.php';
require_once 'app/bootstrap.php';
require_once 'app/models/Expediente.php';

echo "Running Step 5 Rehab Progress Analytics Tests...\n";

$expedienteModel = new Expediente();

// Retrieve progress history for patient ID 5 (Pepe)
$history = $expedienteModel->getPatientProgressHistory(5);

if (is_array($history)) {
    echo "✓ Retrieved patient rehab progress history array. Records count: " . count($history) . "\n";
    if (count($history) > 0) {
        echo "✓ Historical EVA Pain Score: " . ($history[0]->eva_dolor ?? 'N/A') . "/10\n";
    }
} else {
    echo "x Failed retrieving patient progress history.\n";
    exit(1);
}

echo "ALL STEP 5 ANALYTICS TESTS PASSED!\n";
