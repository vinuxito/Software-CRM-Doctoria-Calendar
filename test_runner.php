<?php
echo "=======================================================\n";
echo "       DOCTORIA CRM — MASTER TEST SUITE RUNNER       \n";
echo "=======================================================\n\n";

$scripts = [
    'Step 1: Global Search & Command Palette' => 'test_global_search.php',
    'Step 2: Interactive Anatomical Body Map' => 'test_body_map.php',
    'Step 3: WhatsApp & SMS Reminders Engine' => 'test_whatsapp_token.php',
    'Step 4: CFDI 4.0 SAT Medical Invoicing' => 'test_cfdi_invoice.php',
    'Step 5: Rehab Progress Analytics' => 'test_analytics.php',
    'Step 6: Clinical PDF Report Exporter' => 'test_pdf_export.php',
    'Step 7: Multi-Therapist Resource Optimizer' => 'test_resource_optimizer.php',
    'Step 8: Production Launch Doctrine Master Suite' => 'test_production_doctrine.php'
];

$passedCount = 0;
$failedCount = 0;

foreach ($scripts as $label => $scriptFile) {
    echo "[TESTING] {$label} ({$scriptFile})...\n";
    $cmd = "/lamp/php/bin/php " . escapeshellarg(__DIR__ . '/' . $scriptFile);
    exec($cmd, $outputLines, $returnCode);
    
    if ($returnCode === 0) {
        echo "  --> PASSED ✓\n\n";
        $passedCount++;
    } else {
        echo "  --> FAILED x (Exit Code: {$returnCode})\n\n";
        $failedCount++;
    }
}

echo "-------------------------------------------------------\n";
echo "SUMMARY: {$passedCount} Passed, {$failedCount} Failed out of " . count($scripts) . " Test Suites.\n";
echo "-------------------------------------------------------\n";

if ($failedCount > 0) {
    exit(1);
} else {
    echo "ALL " . count($scripts) . " TEST SUITES PASSED SUCCESSFULLY!\n";
    exit(0);
}
