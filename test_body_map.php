<?php
require_once 'config/config.php';
require_once 'app/bootstrap.php';
require_once 'app/models/Expediente.php';

echo "Running Step 2 Interactive Body Map Tests...\n";

$expedienteModel = new Expediente();

// Save test pain pins for patient ID 5 (Pepe)
$mockPayload = [
    'patient' => ['name' => 'Pepe Paciente Renovado', 'phone' => '555123456'],
    'expediente' => ['eva_dolor' => 8, 'notas_generales' => 'Dolor lumbar severo'],
    'dolor_puntos' => [
        [
            'region' => 'Hombro Derecho',
            'vista' => 'anterior',
            'eva_nivel' => 7,
            'tipo_dolor' => 'Punzante',
            'notas' => 'Al abducir el brazo',
            'pos_x' => 35.5,
            'pos_y' => 28.2
        ],
        [
            'region' => 'Zona Lumbar',
            'vista' => 'posterior',
            'eva_nivel' => 9,
            'tipo_dolor' => 'Opresivo',
            'notas' => 'Post-ejercicio',
            'pos_x' => 50.0,
            'pos_y' => 52.0
        ]
    ]
];

$saved = $expedienteModel->saveExpedienteData(5, $mockPayload);
if ($saved) {
    echo "✓ Successfully saved body map pain pins to DB.\n";
} else {
    echo "x Failed saving body map pins.\n";
    exit(1);
}

$reloaded = $expedienteModel->loadExpedienteData(5);
if (isset($reloaded['dolor_puntos']) && count($reloaded['dolor_puntos']) === 2) {
    echo "✓ Verified 2 pain pins loaded correctly from database.\n";
    echo "✓ Pin 1 Region: " . $reloaded['dolor_puntos'][0]->region . " (EVA " . $reloaded['dolor_puntos'][0]->eva_nivel . "/10)\n";
    echo "✓ Pin 2 Region: " . $reloaded['dolor_puntos'][1]->region . " (EVA " . $reloaded['dolor_puntos'][1]->eva_nivel . "/10)\n";
} else {
    echo "x Reloaded pain pins count mismatch.\n";
    exit(1);
}

echo "ALL STEP 2 BODY MAP TESTS PASSED!\n";
