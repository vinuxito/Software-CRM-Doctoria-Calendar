<?php
require_once 'config/config.php';
require_once 'app/bootstrap.php';
require_once 'app/controllers/Dashboard.php';

$_SESSION['user_id'] = 1;
$_SESSION['user_name'] = 'Admin Test';
$_SESSION['user_role'] = 'admin';

$_GET['q'] = 'Pepe';

$dashboard = new Dashboard();

ob_start();
$dashboard->globalSearch();
$output = ob_get_clean();

$data = json_decode($output, true);

echo "Running Global Search Command Palette Tests...\n";
if (isset($data['results']) && is_array($data['results'])) {
    echo "✓ Global search returned valid JSON array. Count: " . count($data['results']) . "\n";
    if (count($data['results']) > 0) {
        echo "✓ Search result title: " . $data['results'][0]['title'] . "\n";
        echo "✓ Search result category: " . $data['results'][0]['category'] . "\n";
    }
} else {
    echo "x Search failed or returned invalid JSON.\n";
    exit(1);
}

echo "ALL STEP 1 SEARCH TESTS PASSED!\n";
