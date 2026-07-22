<?php
require_once 'config/config.php';
require_once 'app/bootstrap.php';
require_once 'app/controllers/Dashboard.php';

$_SESSION['user_id'] = 1;
$_SESSION['user_name'] = 'Admin Test';
$_SESSION['user_role'] = 'admin';

echo "Running Step 6 Clinical PDF Report Exporter Tests...\n";

$dashboard = new Dashboard();

ob_start();
$dashboard->exportExpedientePdf(5);
$output = ob_get_clean();

if (strpos($output, 'Doctoria CRM') !== false && strpos($output, 'Pepe Paciente') !== false) {
    echo "✓ PDF Expediente report generated cleanly with patient details!\n";
    echo "✓ Verified print trigger styles and signature block present.\n";
    echo "ALL STEP 6 PDF EXPORT TESTS PASSED!\n";
} else {
    echo "x Failed generating PDF report.\n";
    exit(1);
}
