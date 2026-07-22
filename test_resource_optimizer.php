<?php
require_once 'config/config.php';
require_once 'app/bootstrap.php';
require_once 'app/models/Resource.php';

echo "Running Step 7 Multi-Therapist Resource Optimizer Tests...\n";

$resourceModel = new Resource();

// 1. Add test cubicle resource
$added = $resourceModel->addResource([
    'name' => 'Cubículo 1 (Electroterapia & Ultrasonido)',
    'type' => 'cubiculo',
    'status' => 'available'
]);

if ($added) {
    echo "✓ Added new treatment cubicle resource to DB.\n";
} else {
    echo "x Failed adding resource.\n";
    exit(1);
}

// 2. Fetch resources list
$resources = $resourceModel->getResources();
if (is_array($resources) && count($resources) > 0) {
    echo "✓ Retrieved clinic resources. Total count: " . count($resources) . "\n";
    echo "✓ Resource 1 Name: " . $resources[0]->name . " (" . $resources[0]->status . ")\n";
} else {
    echo "x Resources list empty.\n";
    exit(1);
}

// 3. Test status toggle to maintenance
$toggled = $resourceModel->updateStatus($resources[0]->id, 'maintenance');
if ($toggled) {
    echo "✓ Resource status successfully toggled to maintenance.\n";
} else {
    echo "x Failed toggling status.\n";
    exit(1);
}

echo "ALL STEP 7 RESOURCE OPTIMIZER TESTS PASSED!\n";
