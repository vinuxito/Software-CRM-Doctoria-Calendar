<?php
require_once 'config/config.php';
require_once 'app/bootstrap.php';
require_once 'app/models/Invoice.php';

echo "Running Step 4 CFDI 4.0 SAT Medical Invoicing Tests...\n";

$invoiceModel = new Invoice();

// 1. Save Fiscal Profile for patient ID 5 (Pepe)
$profileSaved = $invoiceModel->saveFiscalProfile([
    'patient_id' => 5,
    'rfc' => 'PEPA900101XYZ',
    'razon_social' => 'Pepe Paciente Renovado S.A. de C.V.',
    'codigo_postal' => '06600',
    'uso_cfdi' => 'D01',
    'email_cfdi' => 'pepe.facturacion@doctoria.com'
]);

if ($profileSaved) {
    echo "✓ Saved patient RFC fiscal profile successfully.\n";
} else {
    echo "x Failed saving fiscal profile.\n";
    exit(1);
}

$profile = $invoiceModel->getFiscalProfile(5);
if ($profile && $profile->rfc === 'PEPA900101XYZ') {
    echo "✓ Verified RFC profile retrieval: " . $profile->rfc . " (Uso CFDI: " . $profile->uso_cfdi . ")\n";
} else {
    echo "x Profile retrieval mismatch.\n";
    exit(1);
}

// 2. Issue mock medical CFDI 4.0 invoice
$invResult = $invoiceModel->createInvoice([
    'appointment_id' => 1,
    'patient_id' => 5,
    'subtotal' => 850.00,
    'iva' => 0.00,
    'total' => 850.00
]);

if ($invResult && isset($invResult['folio'])) {
    echo "✓ Issued CFDI 4.0 SAT medical invoice! Folio: F-" . $invResult['folio'] . " (UUID: " . $invResult['uuid'] . ")\n";
} else {
    echo "x Failed issuing CFDI 4.0 invoice.\n";
    exit(1);
}

echo "ALL STEP 4 INVOICING TESTS PASSED!\n";
