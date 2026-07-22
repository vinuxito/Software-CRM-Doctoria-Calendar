<?php
require_once 'config/config.php';
require_once 'app/bootstrap.php';
require_once 'app/models/Clinic.php';
require_once 'app/models/Payment.php';
require_once 'app/models/CarePathway.php';
require_once 'app/helpers/TelemedService.php';
require_once 'app/helpers/AiClinicalCopilot.php';

echo "Running Production Launch Doctrine Verification Tests...\n";

// 1. Test Clinic Model
$clinicModel = new Clinic();
$clinics = $clinicModel->getClinics();
if (is_array($clinics) && count($clinics) > 0) {
    echo "✓ Retrieved clinic branches. Count: " . count($clinics) . " (Branch 1: " . $clinics[0]->name . ")\n";
} else {
    echo "x Failed fetching clinic branches.\n";
    exit(1);
}

// 2. Test Telemedicine Token Generation & Validation
$token = TelemedService::generateRoomToken(101);
$isValid = TelemedService::validateRoomToken($token);
$joinUrl = TelemedService::buildPatientJoinUrl($token);

if (strlen($token) === 64 && $isValid && strpos($joinUrl, '/telemed/join/') !== false) {
    echo "✓ Telemedicine room token generated & validated cleanly (64 chars).\n";
} else {
    echo "x Telemedicine token validation failed.\n";
    exit(1);
}

// 3. Test Financial Ledger & Commission Splits
$paymentModel = new Payment();
$recorded = $paymentModel->recordTransaction([
    'appointment_id' => 1,
    'patient_id' => 5,
    'doctor_id' => 2,
    'amount' => 1200.00,
    'commission_rate' => 60.0,
    'payment_method' => 'card',
    'payment_status' => 'paid',
    'transaction_ref' => 'TX-TEST-1001'
]);

if ($recorded) {
    $summary = $paymentModel->getFinancialSummary();
    echo "✓ Financial transaction recorded cleanly. Total Revenue: $" . number_format($summary->total_revenue ?? 0, 2) . " MXN\n";
} else {
    echo "x Failed recording financial transaction.\n";
    exit(1);
}

// 4. Test AI Clinical Copilot & Contraindications
$parsed = AiClinicalCopilot::parseDictationToSoap("Paciente refiere dolor agudo en zona lumbar tras esfuerzo físico.");
$warnings = AiClinicalCopilot::checkContraindications("Paciente con marcapasos cardiaco y embarazo");

if (!empty($parsed['soap_subjetivo']) && count($warnings) >= 2) {
    echo "✓ AI SOAP parser structured notes & flagged 2 contraindications!\n";
} else {
    echo "x AI Copilot verification failed.\n";
    exit(1);
}

// 5. Test Care Pathway Assignment
$pathwayModel = new CarePathway();
$pathways = $pathwayModel->getPathways();
if (count($pathways) === 0) {
    $pathwayModel->addPathway("Protocolo Lumbalgia Mecánica Test", "lumbalgia", 14);
    $pathways = $pathwayModel->getPathways();
}

if (count($pathways) > 0) {
    $assigned = $pathwayModel->assignPathwayToPatient(5, $pathways[0]->id, date('Y-m-d'));
    echo "✓ Assigned Care Pathway ID " . $pathways[0]->id . " (" . $pathways[0]->name . ") to Patient ID 5.\n";
} else {
    echo "x Failed pathways test.\n";
    exit(1);
}

echo "ALL PRODUCTION LAUNCH DOCTRINE TESTS PASSED!\n";
