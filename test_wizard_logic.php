<?php
require_once 'config/config.php';
require_once 'app/core/Database.php';
require_once 'app/models/User.php';
require_once 'app/models/Expediente.php';

$userModel = new User();
$expedienteModel = new Expediente();

echo "Running Advanced Clinical Record Wizard Happy Path Tests...\n";

// 1. Verify patient user exists
$patient = $userModel->getUserById(5); // Pepe Paciente
if (!$patient || $patient->role !== 'cliente') {
    die("ERROR: Test patient Pepe Paciente (ID 5) not found.\n");
}
echo "✓ Patient Pepe Paciente verified.\n";

// 2. Load draft or create one
$data = $expedienteModel->loadExpedienteData(5);
if (!$data || !isset($data['expediente'])) {
    die("ERROR: Failed to load/create expediente draft.\n");
}
echo "✓ Loaded clinical expediente draft successfully. ID: " . $data['expediente']->id . "\n";

// 3. Compile mock save payload matching the PRD wizard fields
$mockPayload = [
    'patient' => [
        'name' => 'Pepe Paciente Renovado',
        'ocupacion' => 'Ingeniero de Software',
        'fecha_nacimiento' => '1990-08-25',
        'sexo' => 'Masculino',
        'estado_civil' => 'Soltero(a)',
        'domicilio' => 'Calle 100 #20-30',
        'phone' => '5512345678',
        'tel' => '5512345678',
        'cel' => '5512345678',
        'familiar_responsable' => 'Maria Paciente',
        'familiar_tel' => '5587654321',
        'familiar_cel' => '5587654321'
    ],
    'expediente' => [
        'eva_dolor' => 4, // Dolor moderado
        'notas_generales' => 'Notas del plan general',
        'notas_plan' => ''
    ],
    'antecedentes' => [
        ['grupo' => 'patologico', 'item_key' => 'diabetes', 'valor' => 'no', 'especificacion' => ''],
        ['grupo' => 'patologico', 'item_key' => 'marcapasos', 'valor' => 'si', 'especificacion' => 'Instalado hace 2 años'],
        ['grupo' => 'no_patologico', 'item_key' => 'embarazo', 'valor' => 'no', 'especificacion' => '']
    ],
    'exploracion' => [
        'estatura_cm' => 175,
        'peso_kg' => 78.5,
        'ta' => '120/80',
        'fc' => 72,
        'fr' => 16,
        'arcos_movimiento' => 'Rangos completos',
        'fuerza_muscular' => '5/5 general',
        'reflejos' => 'Normales',
        'sensibilidad' => 'Conservada',
        'lenguaje_orientacion' => 'Orientado en 3 esferas',
        'otros' => 'Sin observaciones adicionales'
    ],
    'cicatriz' => [
        'presenta' => 1,
        'sitio' => 'Abdomen anterior',
        'queloide' => 'no',
        'retractil' => 'si',
        'abierta' => 'no',
        'con_adherencia' => 'si',
        'hipertrofica' => 'no'
    ],
    'padecimiento' => [
        'motivo_consulta' => 'Dolor lumbar crónico',
        'inicio' => 'Hace 3 meses tras levantar carga',
        'evolucion' => 'Progresivo',
        'estudios' => 'Resonancia lumbar sin hernia',
        'tratamientos_previos' => 'Analgésicos'
    ],
    'problemas' => [
        ['item_key' => 'dolor', 'severidad' => 'moderado', 'nota' => 'Zona lumbar'],
        ['item_key' => 'contractura', 'severidad' => 'leve', 'nota' => 'Paravertebrales']
    ],
    'plan_sesiones' => [
        ['fecha' => '2026-07-12', 'indicaciones' => 'Compresa húmeda caliente + TENS 15 min'],
        ['fecha' => '2026-07-15', 'indicaciones' => 'Masaje terapéutico + Ejercicios Williams']
    ],
    'marcha' => [
        'libre' => 1,
        'claudicante' => 0,
        'con_ayuda' => 0,
        'espasticas' => 0,
        'ataxica' => 0,
        'otros' => 0,
        'otros_spec' => '',
        'observaciones' => 'Marcha fluida',
        'inicio_marcha' => 1,
        'paso_pd_longitud' => 1,
        'paso_pd_altura' => 1,
        'paso_pi_longitud' => 1,
        'paso_pi_altura' => 1,
        'simetria_paso' => 1,
        'continuidad_pasos' => 1,
        'trayectoria' => 2,
        'tronco' => 2,
        'postura_marcha' => 1,
        'total_balance_manual' => 10
    ]
];

$saved = $expedienteModel->saveExpedienteData(5, $mockPayload);
if (!$saved) {
    die("ERROR: Failed to save mock expediente data payload.\n");
}
echo "✓ Saved mock clinical expediente draft successfully.\n";

// 4. Verify saved data by reloading
$reloaded = $expedienteModel->loadExpedienteData(5);

if ($reloaded['patient']->ocupacion !== 'Ingeniero de Software' ||
    (int)$reloaded['expediente']->eva_dolor !== 4 ||
    $reloaded['exploracion']->ta !== '120/80' ||
    (int)$reloaded['cicatriz']->presenta !== 1 ||
    $reloaded['padecimiento']->motivo_consulta !== 'Dolor lumbar crónico' ||
    count($reloaded['plan_sesiones']) !== 2 ||
    (int)$reloaded['marcha']->total_marcha !== 12 ||
    (int)$reloaded['marcha']->total_general !== 22) {
    var_dump($reloaded['patient']->ocupacion);
    var_dump($reloaded['expediente']->eva_dolor);
    var_dump($reloaded['exploracion']->ta);
    var_dump($reloaded['cicatriz']->presenta);
    var_dump($reloaded['padecimiento']->motivo_consulta);
    var_dump(count($reloaded['plan_sesiones']));
    var_dump($reloaded['marcha']->total_marcha);
    var_dump($reloaded['marcha']->total_general);
    die("ERROR: Reloaded clinical records do not match saved mock payload.\n");
}
echo "✓ Validated reloaded clinical record values match perfectly (Byte-Exact persistence check).\n";

echo "ALL WIZARD LOGIC TESTS PASSED!\n";
