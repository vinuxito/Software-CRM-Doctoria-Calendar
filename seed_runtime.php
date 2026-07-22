<?php
require_once 'config/config.php';
require_once 'app/bootstrap.php';

// SECURITY: Only allow seeding when accessed by an authenticated admin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    http_response_code(403);
    die('Acceso denegado. Solo un administrador autenticado puede ejecutar el seeder.');
}

$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
    DB_USER,
    DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(40) DEFAULT NULL,
    role ENUM('admin','medico','cliente') NOT NULL DEFAULT 'cliente',
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    doctor_id INT NOT NULL,
    patient_id INT NOT NULL,
    created_by INT NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    contact_phone VARCHAR(40) DEFAULT NULL,
    status ENUM('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending',
    source_channel VARCHAR(100) DEFAULT 'crm',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$columns = $pdo->query("SHOW COLUMNS FROM users")->fetchAll(PDO::FETCH_COLUMN);
if (!in_array('role', $columns, true)) {
    $pdo->exec("ALTER TABLE users ADD COLUMN role ENUM('admin','medico','cliente') NOT NULL DEFAULT 'cliente' AFTER email");
}
if (!in_array('phone', $columns, true)) {
    $pdo->exec("ALTER TABLE users ADD COLUMN phone VARCHAR(40) DEFAULT NULL AFTER email");
}

$appointmentColumns = $pdo->query("SHOW COLUMNS FROM appointments")->fetchAll(PDO::FETCH_COLUMN);
if (!in_array('doctor_id', $appointmentColumns, true)) {
    $pdo->exec("ALTER TABLE appointments ADD COLUMN doctor_id INT NULL AFTER title");
}
if (!in_array('user_id', $appointmentColumns, true)) {
    $pdo->exec("ALTER TABLE appointments ADD COLUMN user_id INT NULL AFTER id");
}
if (!in_array('patient_id', $appointmentColumns, true)) {
    $pdo->exec("ALTER TABLE appointments ADD COLUMN patient_id INT NULL AFTER doctor_id");
}
if (!in_array('created_by', $appointmentColumns, true)) {
    $pdo->exec("ALTER TABLE appointments ADD COLUMN created_by INT NULL AFTER patient_id");
}
if (!in_array('status', $appointmentColumns, true)) {
    $pdo->exec("ALTER TABLE appointments ADD COLUMN status ENUM('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending' AFTER end_date");
}
if (!in_array('source_channel', $appointmentColumns, true)) {
    $pdo->exec("ALTER TABLE appointments ADD COLUMN source_channel VARCHAR(100) DEFAULT 'crm' AFTER status");
}
if (!in_array('contact_phone', $appointmentColumns, true)) {
    $pdo->exec("ALTER TABLE appointments ADD COLUMN contact_phone VARCHAR(40) DEFAULT NULL AFTER end_date");
}

$pdo->exec("CREATE TABLE IF NOT EXISTS chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$password = password_hash('123456', PASSWORD_DEFAULT);

$users = [
    [1, 'Administrador CRM', 'admin@doctoria.com', '+57 300 100 0001', 'admin'],
    [2, 'Dr. Gregory House', 'house@doctoria.com', '+57 300 100 0002', 'medico'],
    [3, 'Dra. Elena Torres', 'elena@doctoria.com', '+57 300 100 0003', 'medico'],
    [4, 'Dr. Alfredo Hidalgo', 'alfredo@doctoria.com', '+57 300 100 0004', 'medico'],
    [5, 'Pepe Paciente', 'pepe@doctoria.com', '+57 300 100 0005', 'cliente'],
    [6, 'Ana Suarez', 'ana@doctoria.com', '+57 300 100 0006', 'cliente'],
    [7, 'Carlos Rivas', 'carlos@doctoria.com', '+57 300 100 0007', 'cliente'],
    [8, 'Marta Perez', 'marta@doctoria.com', '+57 300 100 0008', 'cliente'],
    [9, 'Lucia Mendez', 'lucia@doctoria.com', '+57 300 100 0009', 'cliente'],
    [10, 'Jorge Almanza', 'jorge@doctoria.com', '+57 300 100 0010', 'cliente'],
    [11, 'Dra. Sofia Rosales', 'sofia@doctoria.com', '+57 300 100 0011', 'medico'],
    [12, 'Dr. Juan Pardo', 'juan@doctoria.com', '+57 300 100 0012', 'medico']
];

$userStmt = $pdo->prepare("INSERT INTO users (id, name, email, phone, role, password) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name), phone = VALUES(phone), role = VALUES(role), password = VALUES(password)");
foreach ($users as $u) {
    $userStmt->execute([$u[0], $u[1], $u[2], $u[3], $u[4], $password]);
}

$pdo->exec("DELETE FROM chat_messages");
$chatRows = [
    [5,2,'Hola doctor, quiero cambiar la hora'],
    [2,5,'Perfecto, te muevo a las 10:30'],
    [6,3,'Tengo una pregunta de mi receta'],
    [3,6,'Te respondo en unos minutos'],
    [7,4,'¿La consulta sigue confirmada?'],
    [4,7,'Sí, nos vemos hoy'],
    [8,11,'Necesito una teleconsulta'],
    [11,8,'Listo, te agendo para mañana'],
    [9,12,'Quiero revisión general'],
    [12,9,'Te comparto horarios disponibles']
];
$chatStmt = $pdo->prepare("INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
foreach ($chatRows as $row) {
    $chatStmt->execute($row);
}

$pdo->exec("DELETE FROM appointments");
$channels = ['crm', 'web', 'whatsapp', 'chatbot'];
$statuses = ['pending', 'approved', 'approved', 'approved', 'pending', 'rejected', 'completed'];
$titles = ['Consulta General', 'Control Mensual', 'Seguimiento', 'Chequeo', 'Teleconsulta', 'Revisión', 'Consulta Especializada'];
$description = ['Control clínico', 'Validación de resultados', 'Dolor persistente', 'Chequeo anual', 'Consulta rápida', 'Revisión integral'];

$apptStmt = $pdo->prepare("INSERT INTO appointments (user_id, title, doctor_id, patient_id, created_by, start_date, end_date, contact_phone, status, source_channel, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$base = new DateTime('2026-03-10 08:00:00');
for ($i = 0; $i < 80; $i++) {
    $doctorIds = [2,3,4,11,12];
    $patientIds = [5,6,7,8,9,10];
    $doctorId = $doctorIds[$i % count($doctorIds)];
    $patientId = $patientIds[$i % count($patientIds)];
    $creator = ($i % 2 === 0) ? $patientId : $doctorId;
    $start = clone $base;
    $start->modify('+' . (int)($i * 3) . ' hours');
    $end = clone $start;
    $end->modify('+30 minutes');
    $apptStmt->execute([
        $patientId,
        $titles[$i % count($titles)] . ' #' . ($i + 1),
        $doctorId,
        $patientId,
        $creator,
        $start->format('Y-m-d H:i:s'),
        $end->format('Y-m-d H:i:s'),
        '+57 300 100 ' . str_pad((string)(1000 + $patientId), 4, '0', STR_PAD_LEFT),
        $statuses[$i % count($statuses)],
        $channels[$i % count($channels)],
        $description[$i % count($description)]
    ]);
}

echo "Seed completado";
